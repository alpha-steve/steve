<?php 
// Start Session
session_start();

// Create Constants to Store Non-Repeating Values
define('SITEURL', 'http://localhost/food-order-main/'); // Update the home URL if you've changed the port number or it's live on the server
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food-order');

// Database Connection
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Selecting Database
$db_select = mysqli_select_db($conn, DB_NAME);

// Check if the database selection was successful
if (!$db_select) {
    die("Database selection failed: " . mysqli_error($conn));
}
?>
