<?php
$pageTitle = "Homepage - Parth Video";
include_once '../includes/header.php';
?>

<div class="hero-section">
    <div class="container1">
        <h1>Welcome to <span> Parth Video! </span></h1>
        <p>Turning your precious moments into timeless memories.</p>
        <a href="#" class="cta-button">Book Now</a>
    </div>
    <div class="hero-section-img"></div>
</div>

<!-- Services Section -->
<section id="services">
    <h2 class="section-title">Our Services</h2>
    <div class="carousel-container">
        <button class="carousel-btn prev" onclick="moveCarousel(-1)">&lt;</button>
        <div class="carousel">
            <!-- Card 1 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Event+Management" alt="Event Management">
                <h3>Event Management</h3>
                <p>We provide comprehensive event planning and management for all occasions.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 2 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Video+Production" alt="Video Production">
                <h3>Video Production</h3>
                <p>High-quality video production to capture your precious moments.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 3 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Corporate+Events" alt="Corporate Events">
                <h3>Corporate Events</h3>
                <p>Professional coverage and planning for corporate events and conferences.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 4 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Photography" alt="Photography">
                <h3>Photography</h3>
                <p>Capturing the essence of your special moments in stunning photographs.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 5 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Live+Streaming" alt="Live Streaming">
                <h3>Live Streaming</h3>
                <p>Broadcast your events in real time to reach a global audience.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 6 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Wedding" alt="Wedding">
                <h3>Wedding</h3>
                <p>Expert wedding coverage, from ceremonies to receptions.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 7 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Ring+Ceremony" alt="Ring Ceremony">
                <h3>Ring Ceremony</h3>
                <p>Capture every magical moment of your engagement ceremony.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 8 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Birthday+Party" alt="Birthday Party">
                <h3>Birthday Party</h3>
                <p>From kids’ parties to milestone celebrations, we cover it all.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 9 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Pre-Wedding+Package" alt="Pre-Wedding Package">
                <h3>Pre-Wedding Package</h3>
                <p>Special packages for pre-wedding photoshoot and videoshoot.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
        </div>
        <button class="carousel-btn next" onclick="moveCarousel(1)">&gt;</button>
    </div>
</section>

<!-- Optional Gallery Section (if needed) -->
<section id="gallery">
    <h2 class="section-title">Gallery</h2>
    <div class="gallery-grid">
        <img src="https://via.placeholder.com/400x250?text=Gallery+1" alt="Gallery Image 1">
        <img src="https://via.placeholder.com/400x250?text=Gallery+2" alt="Gallery Image 2">
        <img src="https://via.placeholder.com/400x250?text=Gallery+3" alt="Gallery Image 3">
        <img src="https://via.placeholder.com/400x250?text=Gallery+4" alt="Gallery Image 4">
    </div>
</section>

<!-- Include Chatbot Module (chatbot.php) -->
<?php include_once '../includes/chatbot.php'; ?>

<!-- Footer -->
<?php include_once '../includes/footer.php'; ?>

<script>
// Simple carousel functionality for the services section
let currentIndex = 0;
const carousel = document.querySelector('.carousel');
const cards = document.querySelectorAll('.carousel .card');
const cardWidth = cards.length ? (cards[0].offsetWidth + 20) : 320; // card width + margin fallback

function moveCarousel(direction) {
    currentIndex += direction;
    // Limit currentIndex to a valid range
    if (currentIndex < 0) currentIndex = 0;
    if (currentIndex > cards.length - 1) currentIndex = cards.length - 1;
    carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
}
</script>

<script src="../js/script.js"></script>
</body>
</html>
