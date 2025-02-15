<?php
$pageTitle = "Members - Cryptoshow Society";
include_once '..//includes/header.php';

if (!isset($_SESSION['userid'])) {
    echo "<script> window.location.href = 'login.php';</script>";
    exit(); // Stop further execution of the script
}
?>

<style>
    /* Table styles */
    .members-container {
        margin-top: 50px;
        width: 80%;
        padding: 60px;
        border-radius: 10px;
    }

    .members-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .members-table th,
    .members-table td {
        border: 1px solid #ffffff;
        padding: 8px;
        text-align: left;
        font-family: "Poppins", sans-serif;
        font-weight: normal;
        font-size: 18px; /* Reduced font size for better readability on smaller screens */
    }

    .members-table th {
        background: linear-gradient(to right, #c400ff, #5ecfff, #0af8ff);
        font-family: "Poppins", sans-serif;
        font-weight: bold;
        color: #ffffff;
        font-size: 22px; /* Increased font size for table headers */
    }

    .members-table tr:hover {
        background-color: white;
        color: black;
    }

     /* Avatar styles */
     .avatar-container {
        width: 240px; 
        height: 240px; 
        overflow: hidden; 
    }

    .avatar-image {
        width: 100%; 
        height: auto; 
        border-radius: 10%;
    }

    /* Responsive styles */
    @media screen and (max-width: 768px) {
        .members-container {
            width: 95%;
        }

        .members-table th,
        .members-table td {
            font-size: 14px; /* Adjusted font size for smaller screens */
            padding: 6px; /* Reduced padding for better spacing on smaller screens */
        }
    }

    @media screen and (max-width: 480px) {
        .members-table th,
        .members-table td {
            font-size: 12px; /* Further reduced font size for smaller screens */
            padding: 4px; /* Further reduced padding for better spacing on smaller screens */
        }
    }
</style>

<div class="members-container">
    <h2>Members</h2>
    <table class="members-table">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Full Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database connection file
            include_once '..//user/cryptoshow_db.php';

            // Fetch all members
            $sql = "SELECT fullname, avatar FROM users";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    // Display the circular avatar
                    echo "<td><div class='avatar-container'><img class='avatar-image' src='..//user/images/uploads/" . $row['avatar'] . "' alt='Avatar'></div></td>";
                    echo "<td>" . $row['fullname'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No members found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php include_once '../includes/footer.php'; ?>
