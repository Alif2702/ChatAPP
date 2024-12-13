<?php
    session_start();
    include_once "../../php/config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if(!empty($email) && !empty($password)){
        // Check if user exists and is an admin
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' AND role = 'admin'");
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            // Verify password
            if(md5($password) === $row['password']){
                $_SESSION['unique_id'] = $row['unique_id'];
                $_SESSION['role'] = 'admin';
                echo "success";
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else{
            echo "Invalid admin credentials!";
        }
    }else{
        echo "All input fields are required!";
    }
?>
