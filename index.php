<?php
$tmdbId = $_GET['id'] ?? '';
if (!is_numeric($tmdbId)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid or missing ID"]);
    exit;
}

$apiUrl = "http://213.232.235.66:3014/movie/" . $tmdbId;

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if ($response === false) {
    http_response_code(500);
    echo json_encode(["error" => "Unable to fetch data"]);
    exit;
}

header('Content-Type: application/json');
echo $response;
