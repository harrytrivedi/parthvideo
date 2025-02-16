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

<!-- Link to your main stylesheet -->
<link rel="stylesheet" type="text/css" href="/css/stylesheet.css">

<script>
// Global variables for the chatbot
let isAIPlanning = false;  // Can be 'idle', 'collecting', or 'complete'
let aiState = "idle";      // For our rule-based planning flow
let planData = {};         // Store user-provided plan details
let chatHistory = [];      // (Optional) For keeping conversation context if needed

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

// Show and remove typing indicator
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
    
    // If user types "book now", show booking form
    if (message.toLowerCase().includes("book now")) {
        showBookingForm();
        return;
    }
    
    // If user asks for wedding/event advice or planning
    if (message.toLowerCase().includes("wedding") || 
        message.toLowerCase().includes("advice") || 
        message.toLowerCase().includes("planning")) {
        // Start or continue the rule-based AI planning flow
        handleAIMessage(message);
        return;
    }
    
    // If already in planning flow, continue it
    if (aiState !== "idle") {
        handleAIMessage(message);
        return;
    }
    
    // Fallback response for other messages
    showTypingIndicator();
    setTimeout(() => {
        removeTypingIndicator();
        getBotResponse(message);
    }, 1000);
}

/* --- Rule-Based AI Planning Flow --- */
function handleAIMessage(userMessage) {
    userMessage = userMessage.toLowerCase();
    
    if (aiState === "idle") {
        // Trigger planning if the user asks for wedding advice.
        if (userMessage.includes("wedding") || userMessage.includes("advice")) {
            aiState = "collecting";
            appendChatMessage("Bot", "Sure, I can help plan your wedding. What type of event is it? (e.g., wedding, ring ceremony, birthday)");
            return;
        }
    }
    
    if (aiState === "collecting") {
        if (!planData.eventType) {
            planData.eventType = userMessage;
            appendChatMessage("Bot", "Great. How many days of service do you need?");
            return;
        }
        if (!planData.days) {
            planData.days = userMessage;
            appendChatMessage("Bot", "What services do you need? (e.g., photography, videography, live streaming, event management, etc.)");
            return;
        }
        if (!planData.services) {
            planData.services = userMessage;
            appendChatMessage("Bot", "Could you please provide your Name, Email, and Phone number? (separated by commas)");
            return;
        }
        if (!planData.contact) {
            // Assume user enters: "John Doe, john@example.com, 1234567890"
            planData.contact = userMessage;
            aiState = "complete";
            const plan = `Based on your input: Event Type: ${planData.eventType}, Duration: ${planData.days} days, Services: ${planData.services}. To proceed with booking, please type "book now".`;
            appendChatMessage("Bot", plan);
            return;
        }
    }
    
    // If planning is complete and user says "book now", show the booking form
    if (aiState === "complete" && userMessage.includes("book now")) {
        showBookingForm();
        aiState = "idle"; // reset for next conversation
        planData = {};
        chatHistory = [];
        return;
    }
    
    // Fallback if input doesn't match any rule
    appendChatMessage("Bot", "I'm sorry, I didn't understand that. Could you please rephrase?");
}

/* --- Fallback Simple Response --- */
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

/* --- Booking Form Flow --- */
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

function submitBookingForm() {
    const name = document.getElementById('booking-name').value.trim();
    const email = document.getElementById('booking-email').value.trim();
    const phone = document.getElementById('booking-phone').value.trim();
    const enquiryFor = document.getElementById('booking-enquiry-for').value.trim();
    const message = document.getElementById('booking-message').value.trim();
    
    if (!name || !email || !phone || !enquiryFor || !message) {
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

// Allow sending messages with Enter key in the main input
document.getElementById('chatbot-input').addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        sendChatbotMessage();
    }
});
</script>
