<?php

namespace App\Helpers;

class FCMManualHelper
{
    private static function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function createJWT($credentials)
    {
        $now = time();
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $payload = [
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => $credentials['token_uri'],
            'iat' => $now,
            'exp' => $now + 3600,
        ];

        $jwtHeader = self::base64url_encode(json_encode($header));
        $jwtPayload = self::base64url_encode(json_encode($payload));
        $unsignedJWT = "$jwtHeader.$jwtPayload";

        openssl_sign($unsignedJWT, $signature, $credentials['private_key'], 'sha256');

        return $unsignedJWT . '.' . self::base64url_encode($signature);
    }

    private static function getAccessToken($jwt, $token_uri)
    {
        $data = http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        $context = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => $data,
            ]
        ]);

        $response = file_get_contents($token_uri, false, $context);
        $json = json_decode($response, true);

        \Log::info('AccessToken Response:', ['response' => $json]);

        return $json['access_token'] ?? null;
    }

    public static function sendPush($deviceToken, $title, $body)
    {
        $path = storage_path('app/firebase/new-service-account.json');
        $credentials = json_decode(file_get_contents($path), true);

        $jwt = self::createJWT($credentials);
        $accessToken = self::getAccessToken($jwt, $credentials['token_uri']);
        $projectId = $credentials['project_id'];

        $message = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ],
        ];

        $headers = [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json",
        ];

        $ch = curl_init("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        \Log::info("Push sent to token: {$deviceToken}, HTTP {$httpcode}", ['response' => $response]);

        return $httpcode === 200;
    }



    public static function sendPushWithImage($deviceToken, $title, $body, $imageUrl, $category_id = null, $subcategory_id = null, $product_id = null)
    {
        $path = storage_path('app/firebase/new-service-account.json');
        $credentials = json_decode(file_get_contents($path), true);

        $jwt = self::createJWT($credentials);
        $accessToken = self::getAccessToken($jwt, $credentials['token_uri']);
        $projectId = $credentials['project_id'];

        $message = [
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'image' => $imageUrl,
                ],
                // 'data' => [ // 👈 this ensures Flutter sees payload in `message.data`
                //     'title' => $title,
                //     'body'  => $body,
                //     'image' => $imageUrl,
                //     'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                // ],
                'data' => [
                    'title' => $title,
                    'body' => $body,
                    'image' => $imageUrl,
                    'category_id' => $category_id,
                    'subcategory_id' => $subcategory_id,
                    'product_id' => $product_id,
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ],

                'android' => [
                    'notification' => [
                        'image' => $imageUrl,
                    ]
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'mutable-content' => 1,
                            'alert' => [
                                'title' => $title,
                                'body' => $body,
                            ],
                        ],
                    ],
                    'fcm_options' => [
                        'image' => $imageUrl,
                    ],
                ],
            ],
        ];

        $headers = [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json",
        ];

        $ch = curl_init("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        \Log::info("Image Push sent to token: {$deviceToken}, HTTP {$httpcode}", ['response' => $response]);

        return $httpcode === 200;
    }

    // public static function sendUserNotificationWithImage($userId, $title, $body, $imageUrl = null)
    // {
    //     $user = \App\Models\User::find($userId);

    //     if (!$user || !$user->token) {
    //         \Log::warning("User {$userId} has no FCM token, skipping notification.");
    //         return false;
    //     }

    //     return self::sendPushWithImage(
    //         $user->token,
    //         $title,
    //         $body,
    //         $imageUrl
    //     );
    // }
}