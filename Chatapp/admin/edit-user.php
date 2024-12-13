<?php 
  session_start();
  if(!isset($_SESSION['unique_id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("location: login.php");
  }
  
  include_once "../php/config.php";
  
  if(!isset($_GET['id'])){
    header("location: index.php");
  }
  
  $user_id = mysqli_real_escape_string($conn, $_GET['id']);
  $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id} AND role != 'admin'");
  if(mysqli_num_rows($sql) == 0){
    header("location: index.php");
  }
  $user = mysqli_fetch_assoc($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
  <div class="wrapper">
    <section class="form signup">
      <header>Edit User</header>
      <form action="#" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <input type="hidden" name="user_id" value="<?php echo $user['unique_id']; ?>">
        <div class="name-details">
          <div class="field input">
            <label>First Name</label>
            <input type="text" name="fname" value="<?php echo $user['fname']; ?>" required>
          </div>
          <div class="field input">
            <label>Last Name</label>
            <input type="text" name="lname" value="<?php echo $user['lname']; ?>" required>
          </div>
        </div>
        <div class="field input">
          <label>Email Address</label>
          <input type="text" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="field input">
          <label>New Password (leave empty to keep current)</label>
          <input type="password" name="password" placeholder="Enter new password">
          <i class="fas fa-eye"></i>
        </div>
        <div class="field image">
          <label>Profile Image</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
          <?php if($user['img']): ?>
            <div class="current-image">
              <p>Current image:</p>
              <img src="../php/images/<?php echo $user['img']; ?>" alt="Current profile image" style="max-width: 100px;">
            </div>
          <?php endif; ?>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Update User">
        </div>
      </form>
      <div class="link">Back to <a href="index.php">Dashboard</a></div>
    </section>
  </div>
  
  <script src="../javascript/pass-show-hide.js"></script>
  <script src="js/edit-user.js"></script>
</body>
</html>
