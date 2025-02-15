<?php
/**
 * footer.php
 * 
 * Include in pages with: include_once '../includes/footer.php';
 */
?>
<footer class="footer">
  <div class="footer-container">
    <div class="footer-top">
<!-- Left Column: Quick Links -->
<div class="footer-section footer-links">
  <h2>Quick Links</h2>
  <ul class="two-columns">
    <li><a href="index.php">Home</a></li>
    <li><a href="services.php">Services</a></li>
    <li><a href="gallery.php">Gallery</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
</div>


   <!-- Center Column: Logo -->
   <div class="footer-logo">
        <!-- Replace with your actual logo path -->
        <img src="../user/images/logo-dark.png" alt="Parth Video Logo">
      </div>

      <!-- Right Column: Contact Us (centered text) -->
      <div class="footer-section footer-contact">
        <h2>Contact Us</h2>
        <p>Email: <a href="mailto:info@parthvideo.com">info@parthvideo.com <i class="fa-solid fa-arrow-up-right-from-square"></i></a></p>
        <p>Phone: (123) 456-7890</p>
      </div>
    </div>

    <!-- Bottom Row: Social Icons + Copyright -->
    <div class="footer-bottom">
      <div class="footer-social">
        <!-- Load Font Awesome or another icon library in your <head> -->
        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
      </div>
      <p>&copy; <?php echo date("Y"); ?> Parth Video. All Rights Reserved.</p>
    </div>
  </div>
</footer>
