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
                <img src="../user/images/event_management.jpg" alt="Event Management">
                <h3>Event Management</h3>
                <p>We provide comprehensive event planning and management for all occasions.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 2 -->
            <div class="card">
                <img src="../user/images/video_production.jpg" alt="Video Production">
                <h3>Video Production</h3>
                <p>High-quality video production to capture your precious moments.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Card 3 -->
            <div class="card">
                <img src="../user/images/corporate_events.jpg" alt="Corporate Events">
                <h3>Corporate Events</h3>
                <p>Professional coverage and planning for corporate events and conferences.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
        </div>
        <button class="carousel-btn next" onclick="moveCarousel(1)">&gt;</button>
    </div>
</section>

<!-- Gallery Section -->
<section id="gallery">
    <h2 class="section-title">Gallery</h2>
    <div class="gallery-grid">
        <img src="../user/images/gallery1.jpg" alt="Gallery Image 1">
        <img src="../user/images/gallery2.jpg" alt="Gallery Image 2">
        <img src="../user/images/gallery3.jpg" alt="Gallery Image 3">
        <img src="../user/images/gallery4.jpg" alt="Gallery Image 4">
    </div>
</section>

<!-- Include Chatbot Module (chatbot.php) -->
<?php include_once '../includes/chatbot.php'; ?>

<!-- Footer -->
<?php include_once '../includes/footer.php'; ?>

<!-- Carousel and additional JS -->
<script>
// Simple carousel functionality for the services section
let currentIndex = 0;
const carousel = document.querySelector('.carousel');
const cards = document.querySelectorAll('.carousel .card');
const cardWidth = cards.length ? cards[0].offsetWidth + 20 : 0; // card width plus margin

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
