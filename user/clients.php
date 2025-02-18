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
      font-family: "Poppins", sans-serif;
      margin: 0;
      padding: 0;
    }
    .testimonial-container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 50px 20px;
    }
    .section-title {
      font-size: 32px;
      text-align: center;
      margin-bottom: 40px;
      background: #5e17eb;
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .testimonial {
      background-color: #222;
      border: 1px solid #5e17eb;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
    .testimonial.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .testimonial h3 {
      margin: 0 0 10px 0;
      font-size: 20px;
    }
    .testimonial .rating {
      color: #ffc107; /* Gold stars */
      margin-bottom: 10px;
    }
    .testimonial p {
      margin: 10px 0;
      white-space: pre-wrap;
    }
    .testimonial .date {
      font-size: 14px;
      color: #aaa;
    }
  </style>
</head>
<body>
<div class="testimonial-container">
  <h2 class="section-title">Client Testimonials</h2>
  <?php
  // Manually defined reviews array
  $reviews = [
    [
      "author" => "Akash Yadav",
      "rating" => 5,
      "comment" => "", // no comment -> default "Parth Video"
      "date" => "27 Jan 2022"
    ],
    [
      "author" => "Raval Royal",
      "rating" => 5,
      "comment" => "",
      "date" => "4 Mar 2020"
    ],
    [
      "author" => "Pankaj Raval",
      "rating" => 5,
      "comment" => "",
      "date" => "4 Mar 2020"
    ],
    [
      "author" => "Vicky Pandya",
      "rating" => 5,
      "comment" => "",
      "date" => "4 Mar 2020"
    ],
    [
      "author" => "raj trivedi",
      "rating" => 5,
      "comment" => "",
      "date" => "4 Mar 2020"
    ],
    [
      "author" => "Chirag Dave",
      "rating" => 5,
      "comment" => "Accurate work Nice photography with new and latest... More\n(owner)\n4 Mar 2020\nThank You..",
      "date" => "4 Mar 2020"
    ],
    [
      "author" => "Fun With Maths",
      "rating" => 5,
      "comment" => "They Had Do Their Best Work Loved Work With Parth Video",
      "date" => "4 Mar 2019"
    ]
  ];

  foreach ($reviews as $review) {
      // If comment is empty, substitute a default comment.
      $comment = trim($review['comment']);
      if ($comment === "") {
          $comment = "Parth Video";
      }
      echo '<div class="testimonial">';
      echo '<h3>' . htmlspecialchars($review['author']) . '</h3>';
      echo '<div class="rating">';
      $rating = (int)$review['rating'];
      for ($i = 1; $i <= 5; $i++) {
          echo $i <= $rating ? "&#9733; " : "&#9734; ";
      }
      echo '</div>';
      echo '<p>' . nl2br(htmlspecialchars($comment)) . '</p>';
      echo '<div class="date">' . htmlspecialchars($review['date']) . '</div>';
      echo '</div>';
  }
  ?>
</div>

<script>
  // Intersection Observer to animate testimonials on scroll
  const testimonials = document.querySelectorAll('.testimonial');
  const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
          if (entry.isIntersecting) {
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
