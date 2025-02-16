<?php
$pageTitle = "Homepage - Parth Video";
include_once '../includes/header.php';
?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <h1>Welcome to <span> Parth Video! </span></h1>
        <p>Turning your precious moments into timeless memories.</p>
        <a href="#" class="cta-button">Book Now</a>
    </div>
</div>

<!-- Services Section (carousel) -->
<section id="services">
    <h2 class="section-title">Our Services</h2>
    <div class="carousel-container">
        <button class="carousel-btn prev" id="prevBtn" onclick="moveCarousel(-1)">&lt;</button>
        <div class="carousel" id="servicesCarousel">
            <!-- Card 1 -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Event+Management" alt="Event Management">
                <h3>Event Management</h3>
                <p>We provide comprehensive event planning and management for all occasions.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- Add more cards as needed -->
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Video+Production" alt="Video Production">
                <h3>Video Production</h3>
                <p>High-quality video production to capture your precious moments.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Wedding" alt="Wedding">
                <h3>Wedding</h3>
                <p>Expert wedding coverage, from ceremonies to receptions.</p>
                <a href="#" class="card-btn">Learn More</a>
            </div>
            <!-- etc... -->
        </div>
        <button class="carousel-btn next" id="nextBtn" onclick="moveCarousel(1)">&gt;</button>
    </div>
</section>

<!-- Chatbot -->
<?php include_once '../includes/chatbot.php'; ?>

<!-- Footer -->
<?php include_once '../includes/footer.php'; ?>

<script>
let currentIndex = 0;
const carousel = document.getElementById('servicesCarousel');
const cards = carousel.querySelectorAll('.card');
const cardWidth = cards.length ? (cards[0].offsetWidth + 20) : 320; // Card width + margin fallback
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

// Initial button state
checkButtons();

function moveCarousel(direction) {
  currentIndex += direction;

  // Clamp currentIndex between 0 and (cards.length - 1)
  if (currentIndex < 0) currentIndex = 0;
  if (currentIndex > cards.length - 1) currentIndex = cards.length - 1;

  carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
  checkButtons();
}

function checkButtons() {
  // Hide prev button if on first card
  if (currentIndex === 0) {
    prevBtn.style.display = 'none';
  } else {
    prevBtn.style.display = 'block';
  }

  // Hide next button if on last card
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
