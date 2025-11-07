<?php
include_once '../includes/db.inc.php';

if (isset($_POST['confirm'])) {
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];
    $username = $_POST['username'];

    if ($pass1 !== $pass2) {
        echo "<script>alert('Passwords didn\'t match!'); window.history.back();</script>";
    } else {
        $hashedPassword = password_hash($pass1, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET user_password = '$hashedPassword' WHERE user_fname = '$username'";
        mysqli_query($conn, $sql);
        header("Location: ../login.php");
    }
}
?>
