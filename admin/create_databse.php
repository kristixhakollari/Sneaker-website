<?php
// Database credentials
$host = "localhost";
$username = "root";
$password = "";

// Database name
$dbname = "stepx_database";

try {
    // Connect to MySQL
    $conn = new mysqli($host, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully.\n";
    } else {
        die("Error creating database: " . $conn->error);
    }

    // Select the database
    $conn->select_db($dbname);

    // SQL to create order_info table
    $sql = "CREATE TABLE IF NOT EXISTS order_info (
        order_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        customer_name VARCHAR(20) COLLATE utf8mb4_general_ci,
        order_state VARCHAR(20) COLLATE utf8mb4_general_ci NOT NULL,
        reject_reason VARCHAR(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '-' 
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'order_info' created successfully.\n";
    } else {
        die("Error creating table 'order_info': " . $conn->error);
    }

    // SQL to create customer_info table
    $sql = "CREATE TABLE IF NOT EXISTS customer_info (
        customer_name VARCHAR(20) COLLATE utf8mb4_general_ci PRIMARY KEY,
        password VARCHAR(10) COLLATE utf8mb4_general_ci NOT NULL,
        blocked_status BIT(1) NOT NULL DEFAULT 0,
        order_no INT(5) NOT NULL DEFAULT 0,
        isAdmin BIT(1) NOT NULL DEFAULT 0
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'customer_info' created successfully.\n";
    } else {
        die("Error creating table 'customer_info': " . $conn->error);
    }

    // Insert dummy customer
    $adminPassword = "admin12345";
    $sql = "INSERT INTO customer_info (customer_name, password, blocked_status, order_no, isAdmin)
            VALUES ('Admin', '$adminPassword', 0, 0, 1)
            ON DUPLICATE KEY UPDATE password = '$adminPassword', isAdmin = 1";

    if ($conn->query($sql) === TRUE) {
        echo "Admin user inserted successfully.\n";
    } else {
        die("Error inserting Admin user: " . $conn->error);
    }

    // Close connection
    $conn->close();
    echo "Setup complete.";

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
