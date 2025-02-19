<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../css/stylesheet.css"> <!-- Assuming you have a common CSS file -->
</head>
<body class="events-body">
    <?php include_once '../includes/header.php'; ?>
    
    <section class="event-cards">
        <?php
        include_once 'cryptoshow_db.php';

        // Fetch team members from the database
        $sql = "SELECT * FROM team";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="event-card about-card">
                    <img src="../user/images/uploads/<?php echo $row['photo']; ?>" alt="Profile Image">
                    <div class="event-details">
                        <h2><?php echo $row['name']; ?></h2>
                        <p><strong>Role:</strong> <?php echo $row['role']; ?></p>
                        <div class="about-description">
                            <p><?php echo $row['description']; ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No team members found.</p>";
        }

        mysqli_close($conn);
        ?>
    </section>

    <style>
        .about-card {
            position: relative;
            overflow: hidden;
        }
        .about-description {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .about-card:hover .about-description {
            opacity: 1;
        }
    </style>
    <?php include_once '../includes/footer.php'; ?>
    <script src="../js/script.js"></script>
</body>
</html>
