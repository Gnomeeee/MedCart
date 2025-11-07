<?php
session_start();
include './includes/db.inc.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$err = '';
$success = '';

if (isset($_POST['changePassword'])) {
    $user_id = $_SESSION['user_id'];
    $currentPassword = trim($_POST['currentPassword']);
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $err = "All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $err = "New passwords do not match.";
    } elseif (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%]{8,30}$/', $newPassword)) {
        $err = "Password must be at least 8 characters with uppercase, lowercase, and a number.";
    } else {
        // Fetch current password
        $query = "SELECT user_password FROM user WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            if (password_verify($currentPassword, $row['user_password'])) {
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE user SET user_password = ? WHERE user_id = ?");
                $update->bind_param("si", $hashedNewPassword, $user_id);

                if ($update->execute()) {
                    $success = "Password updated successfully. Redirecting...";
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'index.php';
                        }, 2000);
                    </script>";
                } else {
                    $err = "Failed to update password.";
                }
            } else {
                $err = "Current password is incorrect.";
            }
        } else {
            $err = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <style>
        body {
            background: url('./images/360_F_96243602_hgZuimFj1cJFqrrvERCnsq7NZ8VRZ7y7.jpg') no-repeat center center/cover;
            font-family: Arial; background: #f4f4f4; padding: 30px;
        }
        .form-box {
            max-width: 450px; margin: auto; background: white;
            padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        h2 {
            margin-bottom: 25px; text-align: center; margin-left: -20px;
        }
        input[type="password"], button {
            width: 95%; padding: 10px; margin-bottom: 15px;
            margin-top: 10px;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            background: #38c172; color: white; font-weight: bold;
            width: 250px; display: flex; align-items: center; justify-content: center; margin: 0 auto;
            margin-top: 15px; border: none;
            padding: 10px; cursor: pointer;
        }
        button:hover {
            background: #2fa25a;
        }
        .message {
            color: red; font-weight: bold; margin-bottom: 15px;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>🔒 Change Password</h2>

    <?php if ($err): ?>
        <div class="message"><?= htmlspecialchars($err) ?></div>
    <?php elseif ($success): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="password" name="currentPassword" placeholder="Current Password" required>
        <input type="password" name="newPassword" placeholder="New Password" required>
        <input type="password" name="confirmPassword" placeholder="Confirm New Password" required>
        <button type="submit" name="changePassword">Change Password</button>
    </form>
</div>

</body>
</html>
