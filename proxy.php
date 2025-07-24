<?php
// Disable warnings
error_reporting(0);
header('Content-Type: application/json');

// Get TMDB ID from query
$id = $_GET['id'] ?? '';
if (!is_numeric($id)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
    exit;
}

$url = "http://213.232.235.66:3014/movie/" . $id;

// Fetch the real API using cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Provide response
if ($code != 200 || !$response) {
    echo json_encode(['status' => 'error', 'message' => 'Proxy fetch failed']);
    exit;
}

echo $response;
