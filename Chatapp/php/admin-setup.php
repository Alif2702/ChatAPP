<?php
$conn = mysqli_connect("localhost", "root", "", "chatapp");

// Create admin user if it doesn't exist
$check_admin = "SELECT * FROM users WHERE email='admin@admin.com'";
$result = mysqli_query($conn, $check_admin);
if (mysqli_num_rows($result) == 0) {
    $unique_id = rand(time(), 10000000);
    $password = password_hash("admin123", PASSWORD_DEFAULT);
    $insert_admin = "INSERT INTO users (unique_id, fname, lname, email, password, img, status, role) 
                     VALUES ($unique_id, 'Admin', 'User', 'admin@admin.com', '$password', 'default.png', 'Active now', 'admin')";
    if(mysqli_query($conn, $insert_admin)){
        echo "Admin account created successfully!";
    } else {
        echo "Error creating admin account: " . mysqli_error($conn);
    }
} else {
    echo "Admin account already exists!";
}
?>