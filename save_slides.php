<?php
// save_slides.php: Receives JSON slide data and saves it to a file on the server
header('Content-Type: text/plain');

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

// Get the raw POST data
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!isset($data['slides']) || !is_array($data['slides'])) {
    http_response_code(400);
    echo 'Invalid data';
    exit;
}

// Save to a file (e.g., slides.json)
$file = __DIR__ . '/slides.json';
if (file_put_contents($file, json_encode($data['slides'], JSON_PRETTY_PRINT))) {
    echo 'Slides saved successfully!';
} else {
    http_response_code(500);
    echo 'Failed to save slides.';
}
?>
