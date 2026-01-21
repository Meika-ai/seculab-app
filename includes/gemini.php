<?php
/**
 * Client API Gemini 2.5 Flash
 * Permet d'envoyer des messages à l'IA avec un prompt système
 */

/**
 * Appelle l'API Gemini avec un message et un prompt système
 * 
 * @param string $userMessage Le message de l'utilisateur
 * @param string $systemPrompt Le prompt système (instructions pour l'IA)
 * @return array ['success' => bool, 'response' => string|null, 'error' => string|null]
 */
function callGemini(string $userMessage, string $systemPrompt): array {
    $apiKey = GEMINI_API_KEY;
    
    if (empty($apiKey)) {
        return [
            'success' => false,
            'response' => null,
            'error' => 'Clé API Gemini non configurée'
        ];
    }
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;
    
    $data = [
        'system_instruction' => [
            'parts' => [
                ['text' => $systemPrompt]
            ]
        ],
        'contents' => [
            [
                'parts' => [
                    ['text' => $userMessage]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.7,
            'maxOutputTokens' => 500,
        ]
    ];
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_TIMEOUT => 30,
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [
            'success' => false,
            'response' => null,
            'error' => 'Erreur cURL : ' . $error
        ];
    }
    
    if ($httpCode !== 200) {
        $decoded = json_decode($response, true);
        $errorMessage = $decoded['error']['message'] ?? 'Erreur HTTP ' . $httpCode;
        return [
            'success' => false,
            'response' => null,
            'error' => $errorMessage
        ];
    }
    
    $decoded = json_decode($response, true);
    
    if (isset($decoded['candidates'][0]['content']['parts'][0]['text'])) {
        return [
            'success' => true,
            'response' => $decoded['candidates'][0]['content']['parts'][0]['text'],
            'error' => null
        ];
    }
    
    return [
        'success' => false,
        'response' => null,
        'error' => 'Réponse inattendue de l\'API'
    ];
}
