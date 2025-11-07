<?php
include "includes/db.inc.php"; // Make sure this is added if not already
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }
    body {
      background: url(./images/360_F_96243602_hgZuimFj1cJFqrrvERCnsq7NZ8VRZ7y7.jpg);
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: white;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0px 10px 30px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    p {
      margin-bottom: 20px;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="email"],
    input[type="text"] {
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      outline: none;
      font-size: 14px;
    }

    input[disabled] {
      background-color: #f9f9f9;
    }

    button {
      padding: 10px;
      background-color:rgb(52, 187, 84);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      margin-bottom: 10px;
    }

    button:hover {
      background-color: #218838;
    }

    .message {
      text-align: center;
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Reset Password</h2>

  <p>Please enter your email address to reset your password.</p>

  <form method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" placeholder="Enter your email" required>
  </form>

  <?php
  if (isset($_POST['ehelp'])) {
      $email = $_POST['email'];
      include "includes/db.inc.php"; // ensure DB is included

      $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $res = $stmt->get_result();

      if ($row = $res->fetch_assoc()) {
          ?>
          <form method="POST" action="php/forgot1.inc.php">
              <label>Security Question:</label>
              <input type="text" value="<?php echo htmlspecialchars($row['secque']); ?>" disabled>
              <input type="hidden" name="username" value="<?php echo htmlspecialchars($row['user_fname']); ?>">
              <input type="text" name="answer" placeholder="Your Answer" required>
              <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
              <button type="submit" name="submit">Next</button>
          </form>
          <?php
      } else {
          echo "<p class='message'>Email not found.</p>";
      }
  }
  ?>
</div>

</body>
</html>
