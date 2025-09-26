<?php
// get posted json data and save the slide deck to the user's dir
header('Content-Type: text/plain');

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

// Read and decode JSON
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo "Invalid JSON data received.";
    exit;
}

// Validate required fields
if (!isset($data['user']) || !isset($data['slides']) || !is_array($data['slides'])) {
    http_response_code(400);
    echo "Missing or invalid data structure.";
    exit;
}

$user = preg_replace('/[^a-zA-Z0-9_-]/', '', $data['user']); // sanitize username
$userDir = __DIR__ . "/users/$user";

// Save each slide
foreach ($data['slides'] as $slide) {
    if (!isset($slide['filename']) || !isset($slide['html'])) {
        continue; // skip invalid entries
    }

    $filename = basename($slide['filename']); // sanitize filename
    $html = $slide['html'];

    file_put_contents("$userDir/$filename", $html);
}

echo "Slides saved successfully for user: $user";
?>
