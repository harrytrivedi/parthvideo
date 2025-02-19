<?php
session_start();

// Retrieve folder info from URL parameters (or later, from a JSON mapping file)
$folderId = $_GET['folder'] ?? null;
$folderName = $_GET['folderName'] ?? null;

// Generate expected password using a default pattern
$expectedPassword = "parthvideo2024" . $folderName;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered = $_POST['password'] ?? '';
    if ($entered === $expectedPassword) {
        // Mark this folder as unlocked in session
        $_SESSION['gallery_access'][$folderId] = true;
    } else {
        $error = "Incorrect password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Protected Gallery - <?php echo htmlspecialchars($folderName); ?></title>
  <style>
    body { background: #000; color: #fff; font-family: Arial, sans-serif; text-align: center; }
    .container { margin: 50px auto; max-width: 600px; }
    input[type="password"] { padding: 10px; width: 80%; }
    input[type="submit"] { padding: 10px 20px; }
    .error { color: #f00; }
    iframe { width: 100%; height: 600px; border: none; }
  </style>
  <!-- Favicon (optional) -->
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="container">
  <?php if (!$folderId || !$folderName): ?>
    <h1>Error: Folder information missing.</h1>
  <?php else: ?>
    <?php if (!isset($_SESSION['gallery_access'][$folderId])): ?>
      <h1>Enter Password to View Gallery</h1>
      <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
      <?php endif; ?>
      <form method="POST">
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Unlock">
      </form>
      <p>Hint: Your password is <strong>parthvideo2024<?php echo htmlspecialchars($folderName); ?></strong></p>
    <?php else: ?>
      <h1>Your Photo Gallery: <?php echo htmlspecialchars($folderName); ?></h1>
      <iframe src="https://drive.google.com/embeddedfolderview?id=<?php echo htmlspecialchars($folderId); ?>#list"></iframe>
    <?php endif; ?>
  <?php endif; ?>
</div>
</body>
</html>
