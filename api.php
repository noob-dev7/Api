<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$apiKey = $_GET['api_key'] ?? '';
if ($apiKey !== "iloveyou") {
    echo json_encode(["status" => "error", "message" => "Invalid API key"]);
    exit;
}

$movieId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$movieId) {
    echo json_encode(["status" => "error", "message" => "Invalid movie ID"]);
    exit;
}

$apiUrl = "http://213.232.235.66:3014/movie/$movieId";
$response = file_get_contents($apiUrl);
if ($response === false) {
    echo json_encode(["status" => "error", "message" => "Unable to fetch movie data"]);
    exit;
}

$data = json_decode($response, true);
if (!isset($data['title'])) {
    echo json_encode(["status" => "error", "message" => "Invalid movie response"]);
    exit;
}

echo json_encode([
    "status" => "success",
    "data" => [
        "title" => $data['title'],
        "year" => $data['year'] ?? '',
        "downloads" => $data['sources'] ?? [],
        "subtitles" => $data['subtitles'] ?? null
    ]
]);
