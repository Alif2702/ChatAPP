<?php
    session_start();
    include_once "../../php/config.php";
    
    if(!isset($_SESSION['unique_id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header("location: ../login.php");
    }
    
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE role != 'admin'");
    $output = "";
    if(mysqli_num_rows($sql) == 0){
        $output .= "No users are available";
    }elseif(mysqli_num_rows($sql) > 0){
        while($row = mysqli_fetch_assoc($sql)){
            $image = !empty($row['img']) ? $row['img'] : "default.png";
            $output .= '<div class="user-item">
                        <div class="content">
                            <div class="user-image">
                                <img src="../php/images/'. $image .'" alt="">
                            </div>
                            <div class="details">
                                <span>'. $row['fname']. " " . $row['lname'] .'</span>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button onclick="window.location.href=\'edit-user.php?id='. $row['unique_id'] .'\'">Edit</button>
                            <button onclick="deleteUser('. $row['unique_id'] .')">Delete</button>
                        </div>
                    </div>';
        }
    }
    echo $output;
?>
