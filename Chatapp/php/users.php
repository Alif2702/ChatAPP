<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    
    // Get current user's role
    $role_query = mysqli_query($conn, "SELECT role FROM users WHERE unique_id = {$outgoing_id}");
    $user_role = mysqli_fetch_assoc($role_query)['role'];

    // If user is admin, show all users except self
    // If user is regular user, show only admins
    if ($user_role == 'admin') {
        $sql = "SELECT users.*, MAX(messages.timestamp) as latest_msg_time 
                FROM users 
                LEFT JOIN messages ON (users.unique_id = messages.outgoing_msg_id 
                                  OR users.unique_id = messages.incoming_msg_id)
                WHERE NOT users.unique_id = {$outgoing_id} 
                GROUP BY users.unique_id
                ORDER BY CASE 
                    WHEN MAX(messages.timestamp) IS NULL THEN 1 
                    ELSE 0 
                END, 
                MAX(messages.timestamp) DESC, 
                users.user_id DESC";
    } else {
        $sql = "SELECT users.*, MAX(messages.timestamp) as latest_msg_time 
                FROM users 
                LEFT JOIN messages ON (users.unique_id = messages.outgoing_msg_id 
                                  OR users.unique_id = messages.incoming_msg_id)
                WHERE NOT users.unique_id = {$outgoing_id} 
                AND users.role = 'admin'
                GROUP BY users.unique_id
                ORDER BY CASE 
                    WHEN MAX(messages.timestamp) IS NULL THEN 1 
                    ELSE 0 
                END, 
                MAX(messages.timestamp) DESC, 
                users.user_id DESC";
    }
            
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>