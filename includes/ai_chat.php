<?php
// includes/ai_chat.php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['chatHistory'])) {
    echo json_encode(['success' => false, 'reply' => 'No conversation data']);
    exit;
}

$chatHistory = $data['chatHistory'];
$openai_api_key = getenv('OPENAI_API_KEY');
if(!$openai_api_key) {
    echo json_encode(['success' => false, 'reply' => 'No API key set']);
    exit;
}

$messages = [
    ['role' => 'system', 'content' => "You are a helpful wedding and event planning assistant. When a user asks for wedding advice, ask for details such as event type, days needed, services (photography, videography, live streaming, event management, etc.), name, email, and phone, then provide a brief plan and suggest booking our service."],
];
foreach ($chatHistory as $msg) {
    $messages[] = [
        'role' => $msg['role'],
        'content' => $msg['content']
    ];
}

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

$response = curl_exec($ch);
error_log("OpenAI response: " . $response); // Debug log
if(curl_errno($ch)) {
    echo json_encode(['success' => false, 'reply' => 'Curl error: ' . curl_error($ch)]);
    exit;
}
curl_close($ch);

$result = json_decode($response, true);
if (isset($result['choices'][0]['message']['content'])) {
    $reply = trim($result['choices'][0]['message']['content']);
    echo json_encode(['success' => true, 'reply' => $reply]);
} else {
    error_log("OpenAI result structure: " . print_r($result, true)); // Debug structure
    echo json_encode(['success' => false, 'reply' => 'No reply from AI']);
}
?>
