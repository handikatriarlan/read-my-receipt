<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIParserService extends Helper
{
    public function parseWithAI(string $text)
    {
        $apiKey = env('COHERE_API_KEY');
        $prompt = <<<PROMPT
            Ubah teks struk belanja berikut menjadi format JSON tanpa penjelasan tambahan apapun. Cukup berikan JSON-nya saja.

            Contoh format JSON yang diharapkan:
                {
                    "date": "2025-08-20",
                    "items": [
                        { "name": "Indomie", "qty": 1, "price": 3000, "subtotal": 3000 },
                        { "name": "Aqua", "qty": 2, "price": 2500, "subtotal": 5000 }
                    ],
                    "total": 8000
                }

            Teks struk:
            $text
            PROMPT;

        $response = Http::withToken($apiKey)
            ->post('https://api.cohere.ai/v1/generate', [
                'model' => 'command',
                'prompt' => $prompt,
                'max_tokens' => 500,
                'temperature' => 0.2,
            ]);

        if (!$response->successful()) {
            return null;
        }

        $raw = $response->json('generations.0.text');
        $onlyJson = $this->cleanCohereResponse($raw);

        return $onlyJson;
    }
}
