<?php
$pageTitle = "Parth Video - Home";
include_once '../includes/header.php';
?>

<div class="hero-section">
    <div class="container1">
        <h1>Welcome to <span> Parth Video! </span></h1>
        <p>Turning your precious moments into timeless memories.</p>
        <a href="../user/booknow.php" class="cta-button">Book Now</a>
    </div>
    <div class="hero-section-img"></div>
</div>

<!-- Services Section -->
<section id="services">
    <h2 class="section-title">Our Services</h2>
    <div class="carousel-container">
        <!-- Give buttons unique IDs -->
        <button class="carousel-btn prev" id="prevBtn" onclick="moveCarousel(-1)">&lt;</button>
        <div class="carousel" id="servicesCarousel">
            <!-- Card 1 -->
            <div class="card">
                <img src="../user/images/eventman.jpg" alt="Event Management">
                <h3>Event Management</h3>
                <p>We provide comprehensive event planning and management for all occasions.</p>
                <a href="../user/booknow.php" class="card-btn">Learn More</a>
            </div>
            <!-- Card 2 -->
            <div class="card">
                <img src="../user/images/videoprod.jpg" alt="Video Production">
                <h3>Video Production</h3>
                <p>High-quality video production to capture your precious moments.</p>
                <a href="../user/booknow.php" class="card-btn">Learn More</a>
            </div>
            <!-- Card 3 -->
            <div class="card">
                <img src="../user/images/corpeven.jpg" alt="Corporate Events">
                <h3>Corporate Events</h3>
                <p>Professional coverage and planning for corporate events and conferences.</p>
                <a href="../user/booknow.php" class="card-btn">Learn More</a>
            </div>
            <!-- Card 4 -->
            <div class="card">
                <img src="../user/images/photograp.jpeg" alt="Photography">
                <h3>Photography</h3>
                <p>Capturing the essence of your special moments in stunning photographs.</p>
                <a href="../user/booknow.php" class="card-btn">Learn More</a>
            </div>
            <!-- Card 5 -->
            <div class="card">
                <img src="../user/images/livestream.jpg" alt="Live Streaming">
                <h3>Live Streaming</h3>
                <p>Broadcast your events in real time to reach a global audience.</p>
                <a href="../user/booknow.php" class="card-btn">Learn More</a>
            </div>
            <!-- Card 6 -->
            <div class="card">
                <img src="../user/images/wedding.jpeg" alt="Wedding">
                <h3>Wedding</h3>
                <p>Expert wedding coverage, from ceremonies to receptions.</p>
                <a href="../user/booknow.php" class="card-btn">Learn More</a>
            </div>
            <!-- Card 7 -->
            <div class="card">
                <img src="../user/images/ringcer.jpeg" alt="Ring Ceremony">
                <h3>Ring Ceremony</h3>
                <p>Capture every magical moment of your engagement ceremony.</p>
                <a href="../user/booknow.php" class="card-btn">Learn More</a>
            </div>
            <!-- Card 8 -->
            <div class="card">
                <img src="../user/images/birthdayp.jpg" alt="Birthday Party">
                <h3>Birthday Party</h3>
                <p>From kids’ parties to milestone celebrations, we cover it all.</p>
                <a href="../user/booknow.php" class="card-btn">Learn More</a>
            </div>
            <!-- Card 9 -->
            <div class="card">
                <img src="../user/images/prewed.jpg" alt="Pre-Wedding Package">
                <h3>Pre-Wedding Package</h3>
                <p>Special packages for pre-wedding photoshoot and videoshoot.</p>
                <a href="../user/booknow.php" class="card-btn">Learn More</a>
            </div>
        </div>
        <button class="carousel-btn next" id="nextBtn" onclick="moveCarousel(1)">&gt;</button>
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
// Minimal carousel functionality for the services section
let currentIndex = 0;
const carousel = document.querySelector('.carousel');
const cards = document.querySelectorAll('.carousel .card');
const cardWidth = cards.length ? (cards[0].offsetWidth + 20) : 320; // card width + margin fallback

// Identify the next/prev buttons by ID
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

// Initialize button states
checkButtons();

function moveCarousel(direction) {
    currentIndex += direction;
    // Limit currentIndex to a valid range
    if (currentIndex < 0) currentIndex = 0;
    if (currentIndex > cards.length - 1) currentIndex = cards.length - 1;
    carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    checkButtons();
}

function checkButtons() {
    // Hide prev button if at first card
    if (currentIndex === 0) {
        prevBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'block';
    }
    // Hide next button if at last card
    if (currentIndex === cards.length - 1) {
        nextBtn.style.display = 'none';
    } else {
        nextBtn.style.display = 'block';
    }
}
</script>

<script src="../js/script.js"></script>
</body>
</html>
