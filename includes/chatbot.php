<?php
// includes/chatbot.php
?>
<!-- Chatbot Icon using Font Awesome -->
<div id="chatbot-icon" onclick="openChatbot()">
  <i class="fa-solid fa-comments"></i>
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

<!-- Link to your main stylesheet -->
<link rel="stylesheet" type="text/css" href="/css/stylesheet.css">

<script>
// Global variables for the chatbot planning flow
let aiState = "idle";      // 'idle', 'collecting', or 'complete'
let planData = {};         // To store user input: eventType, days, services, contact
let chatHistory = [];      // Optional conversation context

// Open and close chatbot window
function openChatbot() {
    document.getElementById('chatbot-window').style.display = 'flex';
}
function closeChatbot() {
    document.getElementById('chatbot-window').style.display = 'none';
}

// Append a message bubble to the chat window
function appendChatMessage(sender, message) {
    const messagesDiv = document.getElementById('chatbot-messages');
    const msgDiv = document.createElement('div');
    msgDiv.classList.add('chat-message', sender.toLowerCase());
    msgDiv.innerHTML = `<span class='message-text'>${message}</span>`;
    messagesDiv.appendChild(msgDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

// Show typing indicator
function showTypingIndicator() {
    const messagesDiv = document.getElementById('chatbot-messages');
    const typingDiv = document.createElement('div');
    typingDiv.classList.add('chat-message', 'bot', 'typing');
    typingDiv.id = 'typing-indicator';
    typingDiv.innerHTML = "<em>Wedding Planner is typing...</em>";
    messagesDiv.appendChild(typingDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}
function removeTypingIndicator() {
    const typingDiv = document.getElementById('typing-indicator');
    if (typingDiv) {
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
    
    // If user types "book now" while planning is complete, submit enquiry directly
    if (aiState === "complete" && message.toLowerCase().includes("book now")) {
        submitPlanEnquiry();
        aiState = "idle"; // Reset for next conversation
        planData = {};
        chatHistory = [];
        return;
    }
    
    // If user asks for wedding/event advice and planning hasn't started
    if (aiState === "idle" && (message.toLowerCase().includes("wedding") || message.toLowerCase().includes("advice"))) {
        aiState = "collecting";
        appendChatMessage("Bot", "Sure, I can help plan your wedding. What type of event is it? (e.g., wedding, ring ceremony, birthday)");
        return;
    }
    
    // If in planning flow, continue collecting details
    if (aiState === "collecting") {
        if (!planData.eventType) {
            planData.eventType = message;
            appendChatMessage("Bot", "Great. How many days of service do you need?");
            return;
        }
        if (!planData.days) {
            planData.days = message;
            appendChatMessage("Bot", "What services do you need? (e.g., photography, videography, live streaming, event management, etc.)");
            return;
        }
        if (!planData.services) {
            planData.services = message;
            appendChatMessage("Bot", "Could you please provide your Name, Email, and Phone number? (separated by commas)");
            return;
        }
        if (!planData.contact) {
            // Expect input like: "John Doe, john@example.com, 1234567890"
            planData.contact = message;
            aiState = "complete";
            const plan = `Plan Summary:\nEvent: ${planData.eventType}\nDuration: ${planData.days} days\nServices: ${planData.services}\nContact: ${planData.contact}\n\nIf you'd like to proceed, please type "book now".`;
            appendChatMessage("Bot", plan);
            return;
        }
    }
    
    // If planning is complete but user doesn't say "book now", remind them
    if (aiState === "complete") {
        appendChatMessage("Bot", "If you'd like to proceed with booking, please type 'book now'.");
        return;
    }
    
    // Fallback: Use Hugging Face AI for general conversation.
    getHFAiResponse(message);
}

// Function to send the user message to Hugging Face API via chat_ai_hf.php
function getHFAiResponse(message) {
    showTypingIndicator();
    const formData = new FormData();
    formData.append('message', message);
    
    fetch('chat_ai_hf.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        removeTypingIndicator();
        if (data.error) {
            appendChatMessage("Bot", "There was an error: " + data.error);
        } else {
            // Depending on the response format, adjust how you extract the reply.
            let reply = (data[0] && data[0].generated_text) ? data[0].generated_text : "Sorry, I didn't get a proper response.";
            appendChatMessage("Bot", reply);
        }
    })
    .catch(error => {
        removeTypingIndicator();
        appendChatMessage("Bot", "Sorry, something went wrong while contacting the AI.");
        console.error(error);
    });
}

// Function to submit collected plan details directly via SMTP
function submitPlanEnquiry() {
    // Parse contact details: expecting "Name, email, phone"
    let contactParts = planData.contact.split(",");
    if(contactParts.length < 3) {
        appendChatMessage("Bot", "The contact details provided seem incomplete. Please try again.");
        return;
    }
    let name = contactParts[0].trim();
    let email = contactParts[1].trim();
    let phone = contactParts[2].trim();
    
    let enquiryFor = `Event: ${planData.eventType}, Duration: ${planData.days} days, Services: ${planData.services}`;
    let message = `Please contact me for the above event.`;
    
    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('enquiryFor', enquiryFor);
    formData.append('message', message);
    
    showTypingIndicator();
    fetch('../includes/send_enquiry_ai.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.text())
    .then(responseText => {
        removeTypingIndicator();
        document.getElementById('chatbot-messages').innerHTML = "";
        appendChatMessage("Bot", responseText);
    })
    .catch(error => {
        removeTypingIndicator();
        appendChatMessage("Bot", "Sorry, there was an error sending your enquiry.");
        console.error(error);
    });
}

// Allow sending messages with Enter key
document.getElementById('chatbot-input').addEventListener("keypress", function(e) {
    if(e.key === "Enter") {
        sendChatbotMessage();
    }
});
</script>
