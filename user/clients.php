<?php
$pageTitle = "Clients - Testimonials";
include_once '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($pageTitle); ?></title>
  <style>
    body {
      background-color: #000;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-image: url(../user/images/clientBG.jpg);
    }
    .testimonial-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 50px 20px;
    }
    .section-title {
      font-size: 36px;
      text-align: center;
      margin-bottom: 40px;
      color: white;
    }
    /* Chat-like testimonial list */
    .testimonial {
      display: flex;
      margin-bottom: 20px;
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
    .testimonial.visible {
      opacity: 1;
      transform: translateY(0);
    }
    /* Avatar circle */
    .avatar {
      flex-shrink: 0;
      width: 50px;
      height: 50px;
      background-color: #5e17eb;
      border-radius: 50%;
      color: #fff;
      font-size: 20px;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }
    /* Chat bubble for review text */
    .bubble {
      background-color: #0000008c;
      padding: 15px;
      border-radius: 15px;
      position: relative;
      flex-grow: 1;
      border: 1px solid #5e17eb;
    }
    .bubble::after {
      content: "";
      position: absolute;
      top: 10px;
      left: -10px;
      border-width: 10px;
      border-style: solid;
      border-color: transparent #222 transparent transparent;
    }
    .testimonial .name-rating {
      font-size: 16px;
      margin-bottom: 8px;
      font-weight: 600;
    }
    .testimonial .date {
      font-size: 13px;
      color: #aaa;
      margin-top: 8px;
    }
    /* Star ratings */
    .stars {
      color: #ffc107;
    }
  </style>
</head>
<body>
  <div class="testimonial-container">
    <h2 class="section-title">What Our Clients Say</h2>
    <?php
    // Manually defined reviews array – adjust as needed
    $reviews = [
      [
        "author" => "anonymous",
        "rating" => 5,
        "comment" => "Parth Video helped us organise our event very well and made our job really easy", // No comment provided, we skip it (or display "No comment provided" if desired)
        "date" => "27 Jan 2022"
      ],
      [
        "author" => "Raval Royal",
        "rating" => 5,
        "comment" => "Really great job, he brings his whole team even if its diffrent cities or if you have destination wedding planned. No compromise on quality! loved the work", 
        "date" => "4 Mar 2020"
      ],
      [
        "author" => "Pankaj Raval",
        "rating" => 5,
        "comment" => "Excellent work",
        "date" => "4 Mar 2020"
      ],
      [
        "author" => "anonymous",
        "rating" => 5,
        "comment" => "did amazing work! quality work",
        "date" => "4 Mar 2020"
      ],
      [
        "author" => "anonymous",
        "rating" => 5,
        "comment" => "He did best job with our wedding",
        "date" => "4 Mar 2020"
      ],
      [
        "author" => "Chirag Dave",
        "rating" => 5,
        "comment" => "Accurate work. Nice photography with new and latest techniques. More details available upon request.",
        "date" => "4 Mar 2020"
      ],
      [
        "author" => "Fun With Maths",
        "rating" => 5,
        "comment" => "They did their best work. Loved working with Parth Video!",
        "date" => "4 Mar 2019"
      ]
    ];

    foreach ($reviews as $review):
        // Skip reviews with no comment. Alternatively, you could set a default comment.
        if (trim($review['comment']) === "") {
            continue;
        }
        // Generate initials for the avatar
        $nameParts = explode(" ", $review['author']);
        $initials = "";
        foreach ($nameParts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }
    ?>
      <div class="testimonial">
        <div class="avatar"><?php echo htmlspecialchars($initials); ?></div>
        <div class="bubble">
          <div class="name-rating">
            <?php echo htmlspecialchars($review['author']); ?> 
            <span class="stars">
              <?php 
                $rating = (int)$review['rating'];
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $rating ? "&#9733; " : "&#9734; ";
                }
              ?>
            </span>
          </div>
          <div class="comment"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></div>
          <div class="date"><?php echo htmlspecialchars($review['date']); ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  
  <script>
    // Intersection Observer to animate testimonials on scroll
    const testimonials = document.querySelectorAll('.testimonial');
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if(entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });
    
    testimonials.forEach(item => observer.observe(item));
  </script>
</body>
</html>
<?php include_once '../includes/footer.php'; ?>
