<?php 
  session_start();
  if(isset($_SESSION['unique_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
    header("location: index.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
  <div class="wrapper">
    <section class="form login">
      <header>Admin Login</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Login as Admin">
        </div>
      </form>
      <div class="link">Back to <a href="../index.php">Chat App</a></div>
    </section>
  </div>
  
  <script src="../javascript/pass-show-hide.js"></script>
  <script src="js/admin-login.js"></script>

</body>
</html>
