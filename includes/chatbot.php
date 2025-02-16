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

<link rel="stylesheet" type="text/css" href="/css/stylesheet.css">

<script>
let isAIPlanning = false;  // Track if user is in AI wedding planning flow
let planDetails = {};      // Store user details (name, days, services, etc.)
let chatHistory = [];      // Keep short conversation context for AI

function openChatbot() {
    document.getElementById('chatbot-window').style.display = 'flex';
}
function closeChatbot() {
    document.getElementById('chatbot-window').style.display = 'none';
}

// Utility: append message bubble
function appendChatMessage(sender, message) {
    const messagesDiv = document.getElementById('chatbot-messages');
    const msgDiv = document.createElement('div');
    msgDiv.classList.add('chat-message', sender.toLowerCase());
    msgDiv.innerHTML = `<span class='message-text'>${message}</span>`;
    messagesDiv.appendChild(msgDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function showTypingIndicator() {
    const messagesDiv = document.getElementById('chatbot-messages');
    const typingDiv = document.createElement('div');
    typingDiv.classList.add('chat-message', 'bot', 'typing');
    typingDiv.id = 'typing-indicator';
    typingDiv.innerHTML = "<em>Parth Video is typing...</em>";
    messagesDiv.appendChild(typingDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

function removeTypingIndicator() {
    const typingDiv = document.getElementById('typing-indicator');
    if(typingDiv) {
        typingDiv.remove();
    }
}

// Main function to send a message
function sendChatbotMessage() {
    const input = document.getElementById('chatbot-input');
    let message = input.value.trim();
    if (!message) return;
    
    appendChatMessage("User", message);
    input.value = "";
    
    // If user says "book now", show booking form
    if(message.toLowerCase().includes("book now")) {
        showBookingForm();
        return;
    }
    
    // If user is asking for wedding/event advice
    if(message.toLowerCase().includes("wedding") ||
       message.toLowerCase().includes("event advice") ||
       message.toLowerCase().includes("planning")) {
        isAIPlanning = true;
        handleAIMessage(message);
        return;
    }
    
    // If already in AI planning flow, continue it
    if(isAIPlanning) {
        handleAIMessage(message);
        return;
    }
    
    // Otherwise, fallback simple response
    showTypingIndicator();
    setTimeout(() => {
        removeTypingIndicator();
        getBotResponse(message);
    }, 1000);
}

// AI Flow: now using AIMLAPI endpoint
function handleAIMessage(userMessage) {
    showTypingIndicator();
    
    // Add user message to chat history
    chatHistory.push({role: 'user', content: userMessage});
    
    fetch('../includes/ai_chat_aimlapi.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ chatHistory })
    })
    .then(res => res.json())
    .then(data => {
        removeTypingIndicator();
        if(data.success) {
            const reply = data.reply;
            appendChatMessage("Bot", reply);
            chatHistory.push({role: 'assistant', content: reply});
        } else {
            // Fallback message if AIMLAPI doesn't return a valid reply
            appendChatMessage("Bot", "I'm sorry, I couldn't process your wedding advice request right now.");
        }
    })
    .catch(err => {
        removeTypingIndicator();
        appendChatMessage("Bot", "Error contacting AI service. Please try again later.");
        console.error(err);
    });
}

// Fallback getBotResponse for simple keywords
function getBotResponse(message) {
    const lowerMsg = message.toLowerCase();
    let response = "";
    if(lowerMsg.includes("hello") || lowerMsg.includes("hi")) {
        response = "Hello! How can I help you today?";
    } else if(lowerMsg.includes("service")) {
        fetch('../includes/services_summary.php')
            .then(r => r.text())
            .then(txt => appendChatMessage("Bot", txt))
            .catch(() => appendChatMessage("Bot", "Sorry, I couldn't fetch services info."));
        return;
    } else if(lowerMsg.includes("about") || lowerMsg.includes("history")) {
        fetch('../includes/aboutus_summary.php')
            .then(r => r.text())
            .then(txt => appendChatMessage("Bot", txt))
            .catch(() => appendChatMessage("Bot", "Sorry, I couldn't fetch about us info."));
        return;
    } else if(lowerMsg.includes("price")) {
        response = "You can find our pricing details on our pricing page.";
    } else {
        response = "I'm sorry, I didn't understand that. Could you please rephrase?";
    }
    appendChatMessage("Bot", response);
}

// Display booking form inside chat window
function showBookingForm() {
    const messagesDiv = document.getElementById('chatbot-messages');
    messagesDiv.innerHTML = ""; // Clear messages
    const formHTML = `
        <div id="booking-form">
            <h4>Book Now</h4>
            <input type="text" id="booking-name" placeholder="Your Name" required><br>
            <input type="email" id="booking-email" placeholder="Your Email" required><br>
            <input type="text" id="booking-phone" placeholder="Your Phone" required><br>
            <input type="text" id="booking-enquiry-for" placeholder="Enquiry For" required><br>
            <textarea id="booking-message" placeholder="Your Message" required></textarea><br>
            <button onclick="submitBookingForm()">Send Enquiry</button>
        </div>
    `;
    messagesDiv.innerHTML = formHTML;
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

// Submit the booking form via AJAX to send an email
function submitBookingForm() {
    const name = document.getElementById('booking-name').value.trim();
    const email = document.getElementById('booking-email').value.trim();
    const phone = document.getElementById('booking-phone').value.trim();
    const enquiryFor = document.getElementById('booking-enquiry-for').value.trim();
    const message = document.getElementById('booking-message').value.trim();
    
    if(!name || !email || !phone || !enquiryFor || !message) {
        alert("Please fill in all fields.");
        return;
    }
    
    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('enquiryFor', enquiryFor);
    formData.append('message', message);
    
    fetch('../includes/send_enquiry.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.text())
    .then(responseText => {
        document.getElementById('chatbot-messages').innerHTML = "";
        appendChatMessage("Bot", responseText);
    })
    .catch(error => {
        appendChatMessage("Bot", "Sorry, there was an error sending your enquiry.");
        console.error(error);
    });
}

// Allow sending message with Enter key in the main input
document.getElementById('chatbot-input').addEventListener("keypress", function(e) {
    if(e.key === "Enter") {
        sendChatbotMessage();
    }
});
</script>
