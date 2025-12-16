<?php

namespace App\Helpers;

use Google\Auth\OAuth2;
use Illuminate\Support\Facades\Http;

class FCMHelper
{
    public static function getAccessToken()
    {
        $credentialsPath = storage_path('app/firebase/ornatique-firebase.json');

        $serviceAccount = json_decode(file_get_contents($credentialsPath), true);

        $oauth = new OAuth2([
            'audience' => 'https://oauth2.googleapis.com/token',
            'issuer' => $serviceAccount['client_email'],
            'signingAlgorithm' => 'RS256',
            'signingKey' => file_get_contents($credentialsPath),
            'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        ]);

        $token = $oauth->fetchAuthToken();
        return $token['access_token'] ?? null;
    }

    public static function sendPush($fcmToken, $title, $body)
    {
        $accessToken = self::getAccessToken();
        $projectId = 'ornatique-7e468';

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                'message' => [
                    'token' => $fcmToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ],
            ]);

        \Log::info("FCM response for token {$fcmToken}: " . $response->body());

        return $response->successful();
    }
}