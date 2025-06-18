<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class AiHelper
{
    public static function generateReply($message)
    {
        $apiKey = env('GROQ_API_KEY');
        $model = env('AI_MODEL', 'llama3-70b-8192');

        $response = Http::withToken($apiKey)
            ->timeout(15)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                         'content' => 'Kamu adalah asisten ramah dari organisasi relawan. Balas jangan terlalu panjang, isi pesan yang menarik dan bila perlu sertakan emoji, serta hanya isi pesan HTML, tanpa ada kode html nya <html>, <head>, atau <body>. Jangan gunakan <b>, <i>, dan <br> juga.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ],
                ],
                'temperature' => 0.7,
            ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        }

        return "Maaf, sistem sedang sibuk. Silakan coba lagi nanti.";
    }
}
