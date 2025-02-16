<?php
// chatbot.php
?>
<!-- Chatbot Icon -->
<div id="chatbot-icon" onclick="openChatbot()">
  <img src="/user/images/chat-icon.png" alt="Chat with us">
</div>

<!-- Chatbot Window -->
<div id="chatbot-window">
  <div id="chatbot-header">
    <span>Chat with us</span>
    <button id="chatbot-close-btn" onclick="closeChatbot()">&times;</button>
  </div>
  <div id="chatbot-messages"></div>
  <div id="chatbot-input-container">
    <input type="text" id="chatbot-input" placeholder="Type your message...">
    <button onclick="sendChatbotMessage()">Send</button>
  </div>
</div>

<!-- Include the chatbot CSS -->
<link rel="stylesheet" type="text/css" href="/css/chatbot.css">

<script>
// Open and close functions
function openChatbot() {
    document.getElementById('chatbot-window').style.display = 'flex';
}
function closeChatbot() {
    document.getElementById('chatbot-window').style.display = 'none';
}

// Append a message to the chat window
function appendChatMessage(sender, message) {
    var messagesDiv = document.getElementById('chatbot-messages');
    var msgDiv = document.createElement('div');
    msgDiv.classList.add('chat-message');
    msgDiv.classList.add(sender.toLowerCase());
    msgDiv.innerHTML = "<strong>" + sender + ":</strong> " + message;
    messagesDiv.appendChild(msgDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

// Show typing indicator
function showTypingIndicator() {
    var messagesDiv = document.getElementById('chatbot-messages');
    var typingDiv = document.createElement('div');
    typingDiv.classList.add('chat-message', 'bot', 'typing');
    typingDiv.id = 'typing-indicator';
    typingDiv.innerHTML = "<em>Bot is typing...</em>";
    messagesDiv.appendChild(typingDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}
function removeTypingIndicator() {
    var typingDiv = document.getElementById('typing-indicator');
    if(typingDiv) {
        typingDiv.remove();
    }
}

// Process and send the user's message
function sendChatbotMessage() {
    var input = document.getElementById('chatbot-input');
    var message = input.value.trim();
    if(message === "") return;
    
    // Append user's message
    appendChatMessage("User", message);
    input.value = "";
    
    // Simulate bot typing
    showTypingIndicator();
    setTimeout(function(){
        removeTypingIndicator();
        var botResponse = getBotResponse(message);
        appendChatMessage("Bot", botResponse);
    }, 1000);
}

// Simple bot logic; customize as needed
function getBotResponse(message) {
    message = message.toLowerCase();
    if(message.includes("hello") || message.includes("hi")) {
        return "Hello! How can I help you today?";
    } else if(message.includes("booking")) {
        return "For booking inquiries, please visit our booking page.";
    } else if(message.includes("price")) {
        return "You can check our pricing details on the pricing page.";
    } else {
        return "I'm sorry, I didn't understand that. Could you please rephrase?";
    }
}

// Allow sending with Enter key
document.getElementById('chatbot-input').addEventListener("keypress", function(e) {
    if(e.key === "Enter") {
        sendChatbotMessage();
    }
});
</script>
