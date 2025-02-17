<?php
// includes/ai_chat_hf.php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['chatHistory'])) {
    echo json_encode(['success' => false, 'reply' => 'No conversation data']);
    exit;
}

$chatHistory = $data['chatHistory'];

// Build a prompt by concatenating the chat history
$prompt = "You are a helpful wedding and event planning assistant. Provide detailed wedding planning advice based on the conversation below.\n\n";
foreach ($chatHistory as $msg) {
    $prefix = ($msg['role'] === 'user') ? "User: " : "Assistant: ";
    $prompt .= $prefix . $msg['content'] . "\n";
}
$prompt .= "Assistant:"; // Instruct the model to continue the conversation

// Set the model and payload – adjust model name if needed
$payload = json_encode([
    "inputs" => $prompt,
    "parameters" => [
        "max_new_tokens" => 200,
        "temperature" => 0.7
    ]
]);

$hf_api_token = getenv('HF_API_TOKEN');
if (!$hf_api_token) {
    echo json_encode(['success' => false, 'reply' => 'No Hugging Face API token set']);
    exit;
}

// Set the Hugging Face inference endpoint
$model = "EleutherAI/gpt-neo-2.7B"; // Change if needed
$url = "https://api-inference.huggingface.co/models/" . $model;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $hf_api_token
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(['success' => false, 'reply' => 'Curl error: ' . curl_error($ch)]);
    exit;
}
curl_close($ch);

$result = json_decode($response, true);
// The response structure from Hugging Face is an array of outputs
if (isset($result[0]['generated_text'])) {
    $reply = trim($result[0]['generated_text']);
    // Optionally, remove the prompt from the reply if it echoes the prompt
    if (strpos($reply, $prompt) === 0) {
        $reply = trim(substr($reply, strlen($prompt)));
    }
    echo json_encode(['success' => true, 'reply' => $reply]);
} else {
    echo json_encode(['success' => false, 'reply' => 'No reply from AI']);
}
?>
