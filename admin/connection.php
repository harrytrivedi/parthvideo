<?php
// Read connection details from environment variables
$hostName   = getenv('DB_HOST');
$dbUser     = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$dbName     = getenv('DB_NAME');
$dbPort     = getenv('DB_PORT') ?: '5432';

// For Render, PostgreSQL often requires SSL. Add sslmode=require.
$connString = "host=$hostName port=$dbPort dbname=$dbName user=$dbUser password=$dbPassword sslmode=require";

// Connect using pg_connect (for PostgreSQL)
$conn = pg_connect($connString);

if (!$conn) {
    die("Something went wrong while connecting to PostgreSQL: " . pg_last_error());
}
?>
