<?php
// chat_ai_hf.php

// Load the Hugging Face API token from an environment variable.
$api_token = getenv('HF_API_TOKEN');
if (!$api_token) {
    echo json_encode(['error' => 'API token not set']);
    exit;
}

$model_id = 'microsoft/DialoGPT-medium'; // Chosen model ID.
$api_url = "https://api-inference.huggingface.co/models/$model_id";

// Retrieve the user message from POST.
$user_message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($user_message)) {
    echo json_encode(['error' => 'No input provided.']);
    exit;
}

// Refined prompt that instructs the model to provide a direct answer without repeating instructions.
$prompt = "You are a wedding planner expert. Answer the following question directly without including any introductory or instructional text.\nQuestion: \"$user_message\"\nAnswer:";

// Build the data payload including generation parameters.
$data = json_encode([
    'inputs' => $prompt,
    'parameters' => [
        'max_new_tokens' => 100,
        'temperature' => 0.7,
        'stop' => ["\nQuestion:"]
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

// Extract the generated text (assuming the response structure includes 'generated_text').
if (isset($decoded[0]['generated_text'])) {
    $generated_text = $decoded[0]['generated_text'];
    // Remove any text before the first occurrence of "Answer:" to keep only the direct answer.
    $parts = explode("Answer:", $generated_text);
    if (count($parts) > 1) {
        $direct_answer = trim($parts[1]);
    } else {
        $direct_answer = trim($generated_text);
    }
    echo json_encode(['generated_text' => $direct_answer]);
} else {
    // If the response structure is different, output the raw response.
    echo $response;
}
?>