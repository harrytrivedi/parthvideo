<?php
// includes/ai_chat_aimlapi.php
header('Content-Type: application/json');

// Get the input JSON data
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['chatHistory'])) {
    echo json_encode(['success' => false, 'reply' => 'No conversation data']);
    exit;
}

$chatHistory = $data['chatHistory'];

// For simplicity, we’ll take the last user message as the query
$query = "";
for ($i = count($chatHistory) - 1; $i >= 0; $i--) {
    if ($chatHistory[$i]['role'] === 'user') {
        $query = $chatHistory[$i]['content'];
        break;
    }
}
if (empty($query)) {
    echo json_encode(['success' => false, 'reply' => 'No user query found']);
    exit;
}

// Retrieve your AIMLAPI key from environment variables
$aiml_api_key = getenv('AIML_API_KEY');
if (!$aiml_api_key) {
    echo json_encode(['success' => false, 'reply' => 'No AIML API key set']);
    exit;
}

// Prepare the payload
$payload = json_encode([
    "apikey" => $aiml_api_key,
    "query" => $query
]);

// Set the AIMLAPI endpoint (adjust if needed based on their docs)
$url = "https://api.aimlapi.com/chat"; // <-- Replace with the correct endpoint if different

// Initialize and execute cURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if(curl_errno($ch)) {
    echo json_encode(['success' => false, 'reply' => 'Curl error: ' . curl_error($ch)]);
    exit;
}
curl_close($ch);

// Decode the response
$result = json_decode($response, true);
// Debug: you might log the full response to check its structure
// error_log("AIMLAPI response: " . $response);

if (isset($result['reply'])) {
    $reply = trim($result['reply']);
    echo json_encode(['success' => true, 'reply' => $reply]);
} else {
    echo json_encode(['success' => false, 'reply' => 'No reply from AIMLAPI']);
}
?>
