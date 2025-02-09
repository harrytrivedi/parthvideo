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

