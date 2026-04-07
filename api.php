<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

define('API_BASE', 'https://queuing-system-crht.onrender.com');

function callApi(string $method, string $endpoint, array $body = []): ?array {
    $url = API_BASE . $endpoint;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, !empty($body) ? json_encode($body) : '{}');
    }

    $response = curl_exec($ch);
    $err      = curl_error($ch);
    curl_close($ch);

    if ($err) {
        return ['error' => 'cURL error: ' . $err];
    }

    $data = json_decode($response, true);
    return $data ?? ['error' => 'Invalid JSON response'];
}

$action = $_GET['action'] ?? '';
$type   = $_GET['type'] ?? 'regular';

switch ($action) {
    case 'status':
        echo json_encode(callApi('GET', '/status'));
        break;
    case 'next':
        echo json_encode(callApi('POST', "/next/$type"));
        break;
    case 'skip':
        echo json_encode(callApi('POST', "/skip/$type"));
        break;
    case 'reset':
        $start = intval($_POST['start'] ?? 1);
        $end   = intval($_POST['end']   ?? 100);
        echo json_encode(callApi('POST', "/reset/$type", ['start' => $start, 'end' => $end]));
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
}