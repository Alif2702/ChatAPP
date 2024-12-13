<?php
$conn = mysqli_connect("localhost", "root", "", "chatapp");

// Add is_admin column if it doesn't exist
$check_column = "SHOW COLUMNS FROM `users` LIKE 'is_admin'";
$result = mysqli_query($conn, $check_column);
if (mysqli_num_rows($result) == 0) {
    $alter_table = "ALTER TABLE users ADD is_admin TINYINT(1) DEFAULT 0";
    mysqli_query($conn, $alter_table);
}

// Create admin user if it doesn't exist
$check_admin = "SELECT * FROM users WHERE email='admin@admin.com'";
$result = mysqli_query($conn, $check_admin);
if (mysqli_num_rows($result) == 0) {
    $unique_id = rand(time(), 10000000);
    $password = password_hash("admin123", PASSWORD_DEFAULT);
    $insert_admin = "INSERT INTO users (unique_id, fname, lname, email, password, img, is_admin) 
                     VALUES ($unique_id, 'Admin', 'User', 'admin@admin.com', '$password', 'default.png', 1)";
    mysqli_query($conn, $insert_admin);
}

echo "Admin setup completed!";
?>
