// script.js
// Select the button for toggling mode
const modeToggleBtn = document.getElementById('modeToggle');

// Add event listener for button click
modeToggleBtn.addEventListener('click', function() {
    // Toggle day mode class on the body
    document.body.classList.toggle('day-mode');

    // Check if day mode is enabled
    const isDayMode = document.body.classList.contains('day-mode');

    // Toggle background color based on the mode
    const containers = document.querySelectorAll('.container');
    if (isDayMode) {
        // Change background color of all containers to white
        containers.forEach(container => {
            container.style.backgroundColor = 'white';
        });

        // Change logo to white mode logo
        const logoImg = document.querySelector('.logo_reglo');
        logoImg.src = '../user/images/logo-white.png';
    } else {
        // Change background color of all containers to default color (black)
        containers.forEach(container => {
            container.style.backgroundColor = '#000000';
        });

        // Change logo to default logo
        const logoImg = document.querySelector('.logo_reglo');
        logoImg.src = '../user/images/logo-dark.png';
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const modeToggle = document.getElementById("modeToggle");
    const body = document.body;

    modeToggle.addEventListener("click", function() {
        body.classList.toggle("night-mode");
        const currentIcon = modeToggle.querySelector("i");
        currentIcon.classList.toggle("fa-solid");
        currentIcon.classList.toggle("fa-sun");
        currentIcon.classList.toggle("fa-moon");
        const buttonText = body.classList.contains("night-mode") ? "Dark Mode" : "Light Mode";
        modeToggle.innerHTML = `<i class="${body.classList.contains("night-mode") ? "fa-solid fa-moon" : "fa-solid fa-sun"}"></i> ${buttonText}`;
    });
});
// ===== Carousel Boundary Logic =====
document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.querySelector('.carousel');
    const cards = document.querySelectorAll('.carousel .card');
    const prevBtn = document.querySelector('.carousel-btn.prev');
    const nextBtn = document.querySelector('.carousel-btn.next');

    if (!carousel || !cards.length || !prevBtn || !nextBtn) {
        // If elements aren't found, exit early
        return;
    }

    let currentIndex = 0;
    const cardWidth = cards[0].offsetWidth + 20; // card width + margin

    // Initialize button visibility
    checkButtons();

    // Attach click events
    prevBtn.addEventListener('click', function() {
        moveCarousel(-1);
    });
    nextBtn.addEventListener('click', function() {
        moveCarousel(1);
    });

    function moveCarousel(direction) {
        currentIndex += direction;
        // Clamp the index between 0 and cards.length - 1
        if (currentIndex < 0) currentIndex = 0;
        if (currentIndex > cards.length - 1) currentIndex = cards.length - 1;

        carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        checkButtons();
    }

    function checkButtons() {
        // Hide prev button if at the first card
        if (currentIndex === 0) {
            prevBtn.style.display = 'none';
        } else {
            prevBtn.style.display = 'block';
        }

        // Hide next button if at the last card
        if (currentIndex === cards.length - 1) {
            nextBtn.style.display = 'none';
        } else {
            nextBtn.style.display = 'block';
        }
    }
});

