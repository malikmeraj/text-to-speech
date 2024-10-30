<?php

function textToSpeechChunked($text, $lang = 'en') {
    // Google Translate TTS base URL
    $baseUrl = "https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&tl=$lang";

    // Split text into 199 character chunks
    $chunks = str_split($text, 199);
    $audioContent = '';

    // Fetch each chunk's audio
    foreach ($chunks as $chunk) {
        $chunk = urlencode($chunk);
        $url = "$baseUrl&q=$chunk";

        // Set up headers to mimic a browser request
        $options = [
            "http" => [
                "header" => "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0\r\n"
            ]
        ];
        $context = stream_context_create($options);

        // Fetch the audio content for the chunk
        $result = file_get_contents($url, false, $context);
        if ($result) {
            $audioContent .= $result;
        } else {
            return null; // Return null if a chunk fails
        }
    }

    return $audioContent;
}

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Retrieve text and language from GET or POST request
$text = $_REQUEST['text'] ?? '';
$lang = $_REQUEST['lang'] ?? 'en';

if (empty($text)) {
    echo json_encode(["error" => "Text is required"]);
    exit;
}

// Generate the TTS audio
$audioContent = textToSpeechChunked($text, $lang);

if ($audioContent) {
    // Save or output the combined audio as an MP3 file
    $outputFile = 'output.mp3';
    file_put_contents($outputFile, $audioContent);
    
    // Send the MP3 file as a downloadable response
    header('Content-Type: audio/mpeg');
    header('Content-Disposition: attachment; filename="output.mp3"');
    header('Content-Length: ' . filesize($outputFile));
    readfile($outputFile);
    unlink($outputFile); // Clean up the file after sending
} else {
    echo json_encode(["error" => "Failed to generate audio"]);
}
