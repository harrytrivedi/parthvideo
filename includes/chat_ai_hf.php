<?php
// chat_ai_hf.php

// Load the Hugging Face API token from an environment variable.
// Make sure you set HF_API_TOKEN in your server's environment configuration.
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

// Craft a refined prompt with a clear delimiter for the answer.
// This tells the model that the answer should come after "Answer:" and stop if it sees "\nQuery:".
$prompt = "You are a wedding planner expert. Provide detailed and creative wedding planning advice.\nQuery: \"$user_message\"\nAnswer:";

// Build the data payload including generation parameters.
$data = json_encode([
    'inputs' => $prompt,
    'parameters' => [
        'max_new_tokens' => 100,
        'temperature' => 0.7,
        'stop' => ["\nQuery:"]
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
} else {
    // Return the API response.
    echo $response;
}

curl_close($ch);
?>
