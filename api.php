<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Get parameters
$apiKey = $_GET['api_key'] ?? '';
$movieId = $_GET['id'] ?? '';

// Validate API key
if ($apiKey !== "iloveyou") {
    echo json_encode(["status" => "error", "message" => "Invalid API key"]);
    exit;
}

// Validate movie ID
if (!is_numeric($movieId)) {
    echo json_encode(["status" => "error", "message" => "Invalid movie ID"]);
    exit;
}

// Build external API URL
$externalUrl = "http://213.232.235.66:3014/movie/" . urlencode($movieId);

// Use cURL to fetch external API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $externalUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Check response
if ($httpCode !== 200 || !$response) {
    echo json_encode(["status" => "error", "message" => "Unable to fetch movie data"]);
    exit;
}

$data = json_decode($response, true);

// Validate response format
if (!isset($data['title']) || !isset($data['downloads'])) {
    echo json_encode(["status" => "error", "message" => "Invalid movie response"]);
    exit;
}

// Build API response
echo json_encode([
    "status" => "success",
    "data" => [
        "title" => $data['title'],
        "year" => $data['year'] ?? null,
        "downloads" => $data['downloads'] ?? [],
        "subtitles" => $data['subtitles'] ?? null
    ]
]);
?>
