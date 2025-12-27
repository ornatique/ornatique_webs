<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

class VisionController extends Controller
{
    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $path = $request->file('image')->path();

        // 🔍 IMAGE DEBUG (GOOD PRACTICE)
        Log::info('IMAGE DEBUG', [
            'exists' => file_exists($path),
            'size'   => filesize($path),
            'mime'   => mime_content_type($path),
        ]);

        $imageBase64 = base64_encode(file_get_contents($path));
        $apiKey = config('services.google.vision_key');
    
        // ✅ PAYLOAD (DOCUMENT_TEXT_DETECTION)
        $payload = [
            'requests' => [[
                'image' => [
                    'content' => $imageBase64,
                ],
                'features' => [[
                    'type' => 'WEB_DETECTION'
                ]],
                'imageContext' => [
                    'languageHints' => ['en']
                ]
            ]]
        ];

        // ✅ CURL REQUEST (MOST RELIABLE WITH GOOGLE VISION)
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://vision.googleapis.com/v1/images:annotate?key={$apiKey}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
        ]);

        $result = curl_exec($ch);

        if ($result === false) {
            return response()->json([
                'status' => false,
                'error' => curl_error($ch),
            ], 500);
        }

        curl_close($ch);

        $data = json_decode($result, true);
        dd($data);
        // 🔍 FINAL RESPONSE LOG
        Log::info('VISION FINAL RESPONSE', $data);

        // ✅ SAFELY EXTRACT OCR TEXT
        $ocrText = $data['responses'][0]['fullTextAnnotation']['text']
            ?? null;

        return response()->json([
            'status' => true,
            'ocr_text' => $ocrText,
            'raw' => $data,
        ]);
    }
}
