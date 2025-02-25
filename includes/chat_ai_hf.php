<?php
// chat_ai_hf.php

// Load the Hugging Face API token from an environment variable.
$api_token = getenv('HF_API_TOKEN');
if (!$api_token) {
    echo json_encode(['error' => 'API token not set']);
    exit;
}

$model_id = 'microsoft/DialoGPT-medium';
$api_url = "https://api-inference.huggingface.co/models/$model_id";

// Retrieve the user message from POST.
$user_message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($user_message)) {
    echo json_encode(['error' => 'No input provided.']);
    exit;
}

// New, simpler prompt that instructs the model to answer directly.
$prompt = "You are a wedding planner expert. Provide a succinct, direct answer to the following question without repeating any context.\nQ: \"$user_message\"\nA:";

// Build the data payload including generation parameters.
$data = json_encode([
    'inputs' => $prompt,
    'parameters' => [
        'max_new_tokens' => 150,
        'temperature' => 0.5
    ]
]);

// Initialize the cURL request.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $api_token",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

// Decode and post-process the response.
$decoded = json_decode($response, true);
$generated_text = "";

if (isset($decoded[0]['generated_text'])) {
    $generated_text = $decoded[0]['generated_text'];
    // Remove everything before the "A:" delimiter to keep only the answer.
    $parts = explode("A:", $generated_text, 2);
    if (count($parts) == 2) {
        $answer = trim($parts[1]);
    } else {
        $answer = trim($generated_text);
    }
    echo json_encode(['generated_text' => $answer]);
} else {
    // Return raw response if structure is unexpected.
    echo $response;
}
?>
