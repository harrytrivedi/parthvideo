<?php

// PostgreSQL connection settings
$hostName   = "dpg-cuoi0m5ds78s738l4rh0-a.oregon-postgres.render.com";
$dbUser     = "parth_video_user";
$dbPassword = "IAA2bTsNWd25P4el83B5syQbtohv7QAU";
$dbName     = "parth_video";
$dbPort     = "5432";

// Build the connection string for PostgreSQL
$connString = "host=$hostName port=$dbPort dbname=$dbName user=$dbUser password=$dbPassword";

// Connect using pg_connect
$conn = pg_connect($connString);

if (!$conn) {
    die("Something went wrong while connecting to PostgreSQL.");
}

// Connection successful!
?>
