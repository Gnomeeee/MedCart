<?php
include_once 'includes/db.inc.php';
$username = htmlspecialchars($_GET['username'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Set New Password</title>
  <link rel="icon" href="images/logo.png" type="image/icon type">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: url(./images/360_F_96243602_hgZuimFj1cJFqrrvERCnsq7NZ8VRZ7y7.jpg);
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90vh;
      margin: 0;
    }

    .container {
      background-color: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
      margin-top: 10px;
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
    }

    input[type="password"] {
      padding: 10px;
      width: 95%;
      margin-bottom: 20px;
      border-radius: 8px;
      border: 1px solid #ccc;
      outline: none;
    }

    button {
      padding: 10px;
      background-color:rgb(52, 187, 84);
      color: white;
      border: none;
      border-radius: 8px;
      width: 100%;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color:#218838;
    }

  </style>
</head>
<body>

  <div class="container">
    <h2>Set New Password</h2>
    <form action="php/newpass.php" method="POST">
      <label for="password1">Enter New Password</label>
      <input type="password" id="password1" name="password1" placeholder="Enter Password" required>

      <label for="password2">Confirm New Password</label>
      <input type="password" id="password2" name="password2" placeholder="Confirm Password" required>

      <input type="hidden" name="username" value="<?php echo $username; ?>">

      <button type="submit" name="confirm">Change Password</button>
    </form>
  </div>

</body>
</html>
