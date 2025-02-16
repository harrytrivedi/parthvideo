<?php
// includes/ai_chat.php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['chatHistory'])) {
    echo json_encode(['success' => false, 'reply' => 'No conversation data']);
    exit;
}

$chatHistory = $data['chatHistory'];

// Build OpenAI API request
$openai_api_key = getenv('OPENAI_API_KEY');
if(!$openai_api_key) {
    echo json_encode(['success' => false, 'reply' => 'No API key set']);
    exit;
}

// Prepare messages for OpenAI
// We’ll set a system prompt to instruct the AI about the wedding planning domain
$messages = [
    ['role' => 'system', 'content' => "You are a helpful wedding and event planning assistant. Provide suggestions for wedding services, days needed, photography, videography, etc. If the user wants a plan, gather details. Keep answers short and friendly."],
];
// Merge user/assistant messages from chatHistory
foreach ($chatHistory as $msg) {
    $messages[] = [
        'role' => $msg['role'],
        'content' => $msg['content']
    ];
}

// Make the API request
$payload = json_encode([
    'model' => 'gpt-3.5-turbo',
    'messages' => $messages,
    'max_tokens' => 200,
    'temperature' => 0.7
]);

$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $openai_api_key
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Debug logs
error_log("OPENAI_API_KEY: " . substr($openai_api_key, 0, 5) . "..."); // partial print for safety
error_log("Payload: " . $payload);

$response = curl_exec($ch);
if(curl_errno($ch)) {
    error_log('cURL error: ' . curl_error($ch));
    echo json_encode(['success' => false, 'reply' => 'Curl error: ' . curl_error($ch)]);
    exit;
}

if(curl_errno($ch)) {
    echo json_encode(['success' => false, 'reply' => 'Curl error: ' . curl_error($ch)]);
    exit;
}
curl_close($ch);

$result = json_decode($response, true);
if(isset($result['choices'][0]['message']['content'])) {
    $reply = $result['choices'][0]['message']['content'];
    echo json_encode(['success' => true, 'reply' => $reply]);
} else {
    echo json_encode(['success' => false, 'reply' => 'No reply from AI']);
}
