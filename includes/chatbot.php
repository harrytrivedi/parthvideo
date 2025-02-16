<?php
// verified chatbot files cloud @starkmehta
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

// Show typing indicator with custom text
function showTypingIndicator() {
    var messagesDiv = document.getElementById('chatbot-messages');
    var typingDiv = document.createElement('div');
    typingDiv.classList.add('chat-message', 'bot', 'typing');
    typingDiv.id = 'typing-indicator';
    typingDiv.innerHTML = "<em>Parth Video is typing...</em>";
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
    
    // If the message includes "book" or "booking", show the booking form instead of a text response
    if(message.toLowerCase().includes("book")) {
        showBookingForm();
    } else {
        // Otherwise, simulate bot typing and generate a normal response
        showTypingIndicator();
        setTimeout(function() {
            removeTypingIndicator();
            getBotResponse(message);
        }, 1000);
    }
}

// Function to get bot response for simple keywords
function getBotResponse(message) {
    var lowerMsg = message.toLowerCase();
    var response = "";
    if(lowerMsg.includes("hello") || lowerMsg.includes("hi")) {
        response = "Hello! How can I help you today?";
    } else if(lowerMsg.includes("service")) {
        // Fetch services summary via AJAX
        fetch('../includes/services_summary.php')
            .then(response => response.text())
            .then(text => {
                appendChatMessage("Bot", text);
            })
            .catch(error => {
                appendChatMessage("Bot", "Sorry, I couldn't fetch services info right now.");
            });
        return;
    } else if(lowerMsg.includes("about") || lowerMsg.includes("history")) {
        // Fetch about us summary via AJAX
        fetch('../includes/aboutus_summary.php')
            .then(response => response.text())
            .then(text => {
                appendChatMessage("Bot", text);
            })
            .catch(error => {
                appendChatMessage("Bot", "Sorry, I couldn't fetch about us info right now.");
            });
        return;
    } else if(lowerMsg.includes("price")) {
        response = "You can find our pricing details on our pricing page.";
    } else {
        response = "I'm sorry, I didn't understand that. Could you please rephrase?";
    }
    appendChatMessage("Bot", response);
}

// Display the booking enquiry form inside the chat window
function showBookingForm() {
    // Clear previous messages (optional)
    var messagesDiv = document.getElementById('chatbot-messages');
    messagesDiv.innerHTML = "";
    
    // Create the booking form HTML
    var formHTML = `
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
    var name = document.getElementById('booking-name').value.trim();
    var email = document.getElementById('booking-email').value.trim();
    var phone = document.getElementById('booking-phone').value.trim();
    var enquiryFor = document.getElementById('booking-enquiry-for').value.trim();
    var message = document.getElementById('booking-message').value.trim();
    
    if(name === "" || email === "" || phone === "" || enquiryFor === "" || message === "") {
        alert("Please fill in all fields.");
        return;
    }
    
    // Prepare data to send
    var formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('enquiryFor', enquiryFor);
    formData.append('message', message);
    
    // Send data via fetch POST to send_enquiry.php
    fetch('../includes/send_enquiry.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(responseText => {
        // Clear the booking form and show response
        document.getElementById('chatbot-messages').innerHTML = "";
        appendChatMessage("Bot", responseText);
    })
    .catch(error => {
        appendChatMessage("Bot", "Sorry, there was an error sending your enquiry.");
    });
}

// Allow sending messages with Enter key in the main input (not the booking form)
document.getElementById('chatbot-input').addEventListener("keypress", function(e) {
    if(e.key === "Enter") {
        sendChatbotMessage();
    }
});
</script>
