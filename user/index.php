<?php
$pageTitle = "Parth Video - Home";
include_once '../includes/header.php';
?>
<head>
    <!-- Favicon -->
    <link rel="icon" href="../user/images/logo-dark.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../user/images/logo-dark.ico" type="image/x-icon">
</head>
<!-- Inline animation styles -->
<style>
  /* Fade-in animation */
  .fade-in {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
  }
  .fade-in.visible {
    opacity: 1;
    transform: translateY(0);
  }
</style>

<!-- Hero Section -->
<div class="hero-section fade-in">
    <div class="container1">
        <h1>Welcome to <span> Parth Video! </span></h1>
        <p>Turning your precious moments into timeless memories.</p>
        <a href="../user/booknow.php" class="cta-button">Book Now</a>
    </div>
    <div class="hero-section-img"></div>
</div>

<!-- Services Section -->
<section id="services" class="fade-in">
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

<!-- Gallery Section -->
<section id="gallery" class="fade-in">
    <h2 class="section-title">Gallery</h2>
    <div class="gallery-grid">
        <img src="../user/images/image12.jpeg" alt="Gallery Image 1">
        <img src="../user/images/image2.jpeg" alt="Gallery Image 2">
        <img src="../user/images/image3.jpeg" alt="Gallery Image 3">
        <img src="../user/images/image5.jpeg" alt="Gallery Image 4">
    </div>
</section>

<!-- Include Chatbot Module (chatbot.php) -->
<?php include_once '../includes/chatbot.php'; ?>

<!-- Footer -->
<?php include_once '../includes/footer.php'; ?>

<!-- Inline JS for animations and carousel -->
<script>
  // Intersection Observer to add "visible" class to elements when scrolled into view
  const observerOptions = {
    threshold: 0.2
  };
  
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if(entry.isIntersecting) {
        entry.target.classList.add('visible');
        // Optionally unobserve if you want animation only once:
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);
  
  // Observe all elements with the fade-in class
  document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
  });
  
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
      // Clamp currentIndex between 0 and last card index
      if (currentIndex < 0) currentIndex = 0;
      if (currentIndex > cards.length - 1) currentIndex = cards.length - 1;
      carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
      checkButtons();
  }

  function checkButtons() {
      prevBtn.style.display = (currentIndex === 0) ? 'none' : 'block';
      nextBtn.style.display = (currentIndex === cards.length - 1) ? 'none' : 'block';
  }
</script>

<!-- Existing external script (if needed) -->
<script src="../js/script.js"></script>
</body>
</html>
