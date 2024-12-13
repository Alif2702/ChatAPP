<?php
    session_start();
    include_once "../../php/config.php";
    
    if(!isset($_SESSION['unique_id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        echo "unauthorized";
        exit;
    }
    
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = !empty($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
    
    if(!empty($fname) && !empty($lname) && !empty($email)){
        // Check if email already exists for other users
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' AND unique_id != {$user_id}");
        if(mysqli_num_rows($sql) > 0){
            echo "This email already exists!";
        } else {
            $update_query = "UPDATE users SET fname = '{$fname}', lname = '{$lname}', email = '{$email}'";
            
            // Add password to update query if provided
            if(!empty($password)){
                $md5_password = md5($password);
                $update_query .= ", password = '{$md5_password}'";
            }
            
            // Handle image upload if provided
            if(isset($_FILES['image'])){
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];
                
                if(!empty($img_name)){
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);
    
                    $extensions = ["jpeg", "png", "jpg"];
                    if(in_array($img_ext, $extensions) === true){
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            $time = time();
                            $new_img_name = $time.$img_name;
                            if(move_uploaded_file($tmp_name,"../../php/images/".$new_img_name)){
                                $update_query .= ", img = '{$new_img_name}'";
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                            exit;
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                        exit;
                    }
                }
            }
            
            $update_query .= " WHERE unique_id = {$user_id} AND role != 'admin'";
            $update_sql = mysqli_query($conn, $update_query);
            
            if($update_sql){
                echo "success";
            }else{
                echo "Something went wrong. Please try again!";
            }
        }
    }else{
        echo "All input fields are required!";
    }
?>
