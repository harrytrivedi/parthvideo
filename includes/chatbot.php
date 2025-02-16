<?php
// includes/chatbot.php
?>
<!-- Chatbot Icon using Font Awesome -->
<div id="chatbot-icon" onclick="openChatbot()">
  <i class="fa-solid fa-comment-dots"></i>
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

<!-- Link to Chatbot CSS -->
<link rel="stylesheet" type="text/css" href="/css/stylesheet.css">

<script>
// Open and close functions
function openChatbot() {
    document.getElementById('chatbot-window').style.display = 'flex';
}
function closeChatbot() {
    document.getElementById('chatbot-window').style.display = 'none';
}

// Append a message bubble to the chat window
function appendChatMessage(sender, message) {
    var messagesDiv = document.getElementById('chatbot-messages');
    var msgDiv = document.createElement('div');
    msgDiv.classList.add('chat-message');
    msgDiv.classList.add(sender.toLowerCase());
    msgDiv.innerHTML = "<span class='message-text'>" + message + "</span>";
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
    setTimeout(function() {
        // Check for keywords and, if needed, fetch content
        getBotResponse(message);
    }, 500);
}

// Function to get bot response (using AJAX for some keywords)
function getBotResponse(message) {
    var lowerMsg = message.toLowerCase();
    
    // If the message mentions "services", fetch from services_summary.php
    if(lowerMsg.includes("service")) {
        fetch('../includes/services_summary.php')
            .then(response => response.text())
            .then(text => {
                removeTypingIndicator();
                appendChatMessage("Bot", text);
            })
            .catch(error => {
                removeTypingIndicator();
                appendChatMessage("Bot", "Sorry, I couldn't fetch services info right now.");
            });
    }
    // If the message mentions "about" or "history", fetch from aboutus_summary.php
    else if(lowerMsg.includes("about") || lowerMsg.includes("history")) {
        fetch('../includes/aboutus_summary.php')
            .then(response => response.text())
            .then(text => {
                removeTypingIndicator();
                appendChatMessage("Bot", text);
            })
            .catch(error => {
                removeTypingIndicator();
                appendChatMessage("Bot", "Sorry, I couldn't fetch about us info right now.");
            });
    }
    // Otherwise, use default responses
    else {
        removeTypingIndicator();
        var response = "";
        if(lowerMsg.includes("hello") || lowerMsg.includes("hi")) {
            response = "Hello! How can I help you today?";
        } else if(lowerMsg.includes("booking")) {
            response = "For booking inquiries, please visit our booking page.";
        } else if(lowerMsg.includes("price")) {
            response = "You can find our pricing details on our pricing page.";
        } else {
            response = "I'm sorry, I didn't understand that. Could you please rephrase?";
        }
        appendChatMessage("Bot", response);
    }
}

// Allow sending messages with Enter key
document.getElementById('chatbot-input').addEventListener("keypress", function(e) {
    if(e.key === "Enter") {
        sendChatbotMessage();
    }
});
</script>
