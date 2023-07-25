<?php

// NOTE: When this page is called, if there's a POST request, the output is a string.
//       So it's actions should be different as we're not rendering the entire page.

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Psr7\Utils;

if (!isset($_FILES['audio']) || empty($_FILES['audio'])) {
    die('Invalid request.');
}

$client = OpenAI::client(''); 
$audio_format = 'audio/mpeg-3';

if (($_FILES['audio']['name'] != 'blob') || $_FILES['audio']['full_path'] != 'blob') {
    $error = json_encode(array(
        'success' => false,
        'text' => 'Naming error.'
    ));
    die($error);
}

$files_filtered = array(
    'tmp_name' => htmlspecialchars($_FILES['audio']['tmp_name']),
    'size' => filter_var($_FILES['audio']['size'], FILTER_SANITIZE_NUMBER_INT)
);

// Save the uploaded file to a temporary location with .mp3 extension
$temp_filename = tempnam(sys_get_temp_dir(), 'openai') . '.mp3';
move_uploaded_file($files_filtered['tmp_name'], $temp_filename);

$stream = Utils::streamFor(fopen($temp_filename, 'r'));

$response_text = $client->audio()->transcribe([
    "model" => "whisper-1",
    "file" => $stream,
    "response_format" => 'verbose_json'
]);

// Remember to delete the temporary file!
unlink($temp_filename);

if (isset($response_text->segments[0])) {
    $response_array = array(
        'text' => $response_text->segments[0]->text
    );
} else {
    $error = json_encode(array(
        'success' => false,
        'text' => 'No response'
    ));
    die($error);
}

if (!empty($response_array['text'])) {
    // Encode the obj
    echo json_encode(array(
        'success' => true,
        'text' => $response_array['text'])
    );
} else {
    $error = json_encode(array(
        'success' => false,
        'text' => '[Error: unable to transcribe voice.]'
    ));
    die($error);
}

?>