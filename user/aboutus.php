<?php
$pageTitle = "About Us - Parth Video";
include_once '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Added meta viewport for responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <style>
        /* General Styles */
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-image: url(../user/images/aboutus2.jpg);
            background-size: cover;
            background-position: center;
        }

        h1, h2, h3, p {
            margin: 0 0 20px 0;
            padding: 0;
        }

        a {
            color: #5e17eb;
            text-decoration: none;
        }

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

        /* Header Section */
        .about-header {
            background: linear-gradient(135deg, #5e17eb, #5ecfff);
            padding: 80px 20px;
            text-align: center;
        }

        .about-header h1 {
            font-size: 48px;
            font-weight: bold;
            color: white;
        }

        .about-header p {
            font-size: 20px;
        }

        /* Timeline Section */
        .timeline-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            position: relative;
        }

        .timeline-container::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 4px;
            background: #5e17eb;
            transform: translateX(-50%);
        }

        .timeline-item {
            position: relative;
            width: 45%;
            padding: 20px;
            background: #0000008c;
            border: 1px solid #5e17eb;
            border-radius: 10px;
            margin: 20px 0;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .timeline-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .timeline-item.left {
            float: left;
            clear: both;
            text-align: right;
            margin-right: 55%;
        }

        .timeline-item.right {
            float: right;
            clear: both;
            text-align: left;
            margin-left: 55%;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            top: 20px;
            width: 16px;
            height: 16px;
            background: #fff;
            border: 4px solid #5e17eb;
            border-radius: 50%;
            z-index: 1;
        }

        .timeline-item.left::after {
            right: -30px;
        }

        .timeline-item.right::after {
            left: -30px;
        }

        .timeline-item h3 {
            margin-bottom: 10px;
            font-size: 20px;
        }

        .timeline-item p {
            font-size: 16px;
        }

        /* Founders Section */
        .founders-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }

        .founders-title {
            font-size: 36px;
            margin-bottom: 40px;
            color: white;
        }

        .founder-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }

        .founder-card {
            background: #0000008c;
            border: 2px solid #5e17eb;
            border-radius: 10px;
            padding: 20px;
            width: 280px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
        }

        .founder-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .founder-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }

        .founder-photo {
            width: 100%;
            height: 280px;
            background-color: #444;
            border-radius: 8px;
            margin-bottom: 15px;
            background-size: cover;
            background-position: center;
        }

        .founder-name {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .founder-role {
            font-size: 18px;
            color: #5e17eb;
            margin-bottom: 10px;
        }

        .founder-bio {
            font-size: 16px;
            line-height: 1.4;
        }

        .section-title {
            font-size: 32px;
            margin-bottom: 20px;
            color: white;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .founder-cards {
                flex-direction: column;
                align-items: center;
            }
            .timeline-item.left,
            .timeline-item.right {
                width: 90%;
                margin: 20px auto;
                text-align: left;
            }
            .timeline-container::before {
                left: 5%;
                transform: none;
            }
        }
        @media screen and (max-width: 480px) {
            .about-header h1 {
                font-size: 36px;
            }
            .about-header p {
                font-size: 16px;
            }
            .founder-card {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <section class="about-header fade-in">
        <h1>About Parth Video</h1>
        <p>
            Founded on 14th January 1999 – the day our founder got married and was inspired by his wife to start something extraordinary.
            Since then, our journey has been driven by passion, creativity, and a commitment to turning precious moments into timeless memories.
        </p>
    </section>

    <!-- Timeline Section -->
    <section class="timeline-container fade-in">
        <h2 class="section-title" style="text-align: center;">Our Journey</h2>
        <!-- Timeline items -->
        <div class="timeline-item left">
            <h3>14 Jan 1999</h3>
            <p>Parth Video was founded on this day, inspired by love and a dream to create lasting memories.</p>
        </div>
        <div class="timeline-item right">
            <h3>Early 2000s</h3>
            <p>We began expanding our services to include cutting-edge photography and videography.</p>
        </div>
        <div class="timeline-item left">
            <h3>2010</h3>
            <p>Introduced live streaming and innovative event management solutions.</p>
        </div>
        <div class="timeline-item right">
            <h3>Today</h3>
            <p>Continuing our legacy with passion, creativity, and a commitment to excellence.</p>
        </div>
    </section>

    <!-- Founders Section -->
    <section class="founders-container fade-in">
        <h2 class="founders-title">Our Founders</h2>
        <div class="founder-cards">
            <!-- Founder Card 1 -->
            <div class="founder-card">
                <div class="founder-photo" style="background-image: url('../user/images/bhavesh_ceo.png');"></div>
                <div class="founder-name">Bhavesh Trivedi</div>
                <div class="founder-role">Founder, Parth Video</div>
                <div class="founder-bio">
                    A visionary entrepreneur whose passion for preserving memories began on a very special day.
                </div>
            </div>
            <!-- Founder Card 2 -->
            <div class="founder-card">
                <div class="founder-photo" style="background-image: url('../user/images/harsh.jpeg');"></div>
                <div class="founder-name">Harsh Trivedi</div>
                <div class="founder-role">CEO, Parth Video</div>
                <div class="founder-bio">
                    The driving force behind our creative vision and operations, ensuring every moment is captured perfectly.
                </div>
            </div>
        </div>
    </section>

    <!-- Include Chatbot Module -->
    <?php include_once '../includes/chatbot.php'; ?>

    <!-- Footer -->
    <?php include_once '../includes/footer.php'; ?>

    <script>
        // Intersection Observer for fade-in animations
        const fadeElements = document.querySelectorAll('.fade-in, .founder-card, .timeline-item');
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3
        });
        fadeElements.forEach(el => observer.observe(el));
    </script>
</body>
</html>
