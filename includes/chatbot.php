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
let aiState = "idle";      // Possible values: 'idle', 'collecting', 'complete'
let planData = {};         // To store details: eventType, days, services, contact
let chatHistory = [];      // For conversation context

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
    typingDiv.innerHTML = "<em>Parth Video is typing...</em>";
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
    
    // If user types "book now" while planning is complete, submit the enquiry directly
    if (aiState === "complete" && message.toLowerCase().includes("book now")) {
        submitPlanEnquiry();
        aiState = "idle"; // Reset for next conversation
        planData = {};
        chatHistory = [];
        return;
    }
    
    // Start wedding planning flow using Hugging Face if user mentions wedding/advice
    if (aiState === "idle" && (message.toLowerCase().includes("wedding") || message.toLowerCase().includes("advice"))) {
        aiState = "collecting";
        appendChatMessage("Bot", "Sure, I can help plan your wedding. What type of event is it? (e.g., wedding, ring ceremony, birthday)");
        chatHistory.push({role: 'user', content: message});
        return;
    }
    
    // If in planning flow, continue collecting details using Hugging Face AI
    if (aiState !== "idle") {
        // Add user message to chat history
        chatHistory.push({role: 'user', content: message});
        // Use Hugging Face Inference API endpoint (ai_chat_hf.php)
        showTypingIndicator();
        fetch('../includes/ai_chat_hf.php', {
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
                appendChatMessage("Bot", "Sorry, I couldn't process your wedding planning request right now.");
            }
        })
        .catch(err => {
            removeTypingIndicator();
            appendChatMessage("Bot", "Error contacting AI service. Please try again later.");
            console.error(err);
        });
        return;
    }
    
    // Fallback simple response for non-planning messages
    showTypingIndicator();
    setTimeout(() => {
        removeTypingIndicator();
        getBotResponse(message);
    }, 1000);
}

// Fallback simple response function
function getBotResponse(message) {
    const lowerMsg = message.toLowerCase();
    let response = "";
    if (lowerMsg.includes("hello") || lowerMsg.includes("hi")) {
        response = "Hello! How can I help you today?";
    } else if (lowerMsg.includes("service")) {
        fetch('../includes/services_summary.php')
            .then(r => r.text())
            .then(txt => appendChatMessage("Bot", txt))
            .catch(() => appendChatMessage("Bot", "Sorry, I couldn't fetch services info."));
        return;
    } else if (lowerMsg.includes("about") || lowerMsg.includes("history")) {
        fetch('../includes/aboutus_summary.php')
            .then(r => r.text())
            .then(txt => appendChatMessage("Bot", txt))
            .catch(() => appendChatMessage("Bot", "Sorry, I couldn't fetch about us info."));
        return;
    } else if (lowerMsg.includes("price")) {
        response = "You can find our pricing details on our pricing page.";
    } else {
        response = "I'm sorry, I didn't understand that. Could you please rephrase?";
    }
    appendChatMessage("Bot", response);
}

// Function to submit collected plan details directly via SMTP
function submitPlanEnquiry() {
    // Parse contact details: expecting "Name, email, phone"
    let contactParts = planData.contact ? planData.contact.split(",") : [];
    if (contactParts.length < 3) {
        appendChatMessage("Bot", "The contact details provided seem incomplete. Please try again.");
        return;
    }
    let name = contactParts[0].trim();
    let email = contactParts[1].trim();
    let phone = contactParts[2].trim();
    
    // Construct enquiryFor from planData collected during AI planning
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

// Allow sending messages with Enter key in the main input
document.getElementById('chatbot-input').addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        sendChatbotMessage();
    }
});
</script>
