<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

define('API_HOST', '127.0.0.1');
define('API_PORT', 8000);

function callApi(string $method, string $endpoint, array $body = []): ?array {
    $host = API_HOST;
    $port = API_PORT;
    $jsonBody = !empty($body) ? json_encode($body) : '';

    $request  = "$method $endpoint HTTP/1.1\r\n";
    $request .= "Host: $host:$port\r\n";
    $request .= "Content-Type: application/json\r\n";
    $request .= "Content-Length: " . strlen($jsonBody) . "\r\n";
    $request .= "Connection: close\r\n\r\n";
    $request .= $jsonBody;

    $fp = @fsockopen($host, $port, $errno, $errstr, 5);
    if (!$fp) {
        return ['error' => "Cannot connect to Python API ($errno: $errstr)"];
    }

    fwrite($fp, $request);
    $response = '';
    while (!feof($fp)) {
        $response .= fgets($fp, 1024);
    }
    fclose($fp);

    $parts = explode("\r\n\r\n", $response, 2);
    $responseBody = isset($parts[1]) ? $parts[1] : '';

    if (stripos($parts[0], 'Transfer-Encoding: chunked') !== false) {
        $decoded = '';
        while (strlen($responseBody) > 0) {
            $pos = strpos($responseBody, "\r\n");
            if ($pos === false) break;
            $chunkSize = hexdec(substr($responseBody, 0, $pos));
            if ($chunkSize === 0) break;
            $decoded .= substr($responseBody, $pos + 2, $chunkSize);
            $responseBody = substr($responseBody, $pos + 2 + $chunkSize + 2);
        }
        $responseBody = $decoded;
    }

    $data = json_decode(trim($responseBody), true);
    return $data ?? ['error' => 'Invalid JSON response'];
}

$action = $_GET['action'] ?? '';
$type   = $_GET['type'] ?? 'regular'; // 'regular' or 'priority'

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