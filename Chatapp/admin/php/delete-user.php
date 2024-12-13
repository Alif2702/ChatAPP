<?php
    session_start();
    include_once "../../php/config.php";
    
    if(!isset($_SESSION['unique_id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        echo "unauthorized";
        exit;
    }
    
    if(isset($_POST['user_id'])){
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        
        // Delete user's messages
        mysqli_query($conn, "DELETE FROM messages WHERE incoming_msg_id = {$user_id} OR outgoing_msg_id = {$user_id}");
        
        // Delete user
        $sql = mysqli_query($conn, "DELETE FROM users WHERE unique_id = {$user_id} AND role != 'admin'");
        
        if($sql){
            echo "success";
        } else {
            echo "error";
        }
    }
?>
