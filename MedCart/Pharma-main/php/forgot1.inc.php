<?php
include_once '../includes/db.inc.php'; 
if (isset($_POST['submit'])) {
    $ans = $_POST['answer'];
    $username = $_POST['username'];  

    $sql = "SELECT * FROM user WHERE user_fname = '$username'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    if ($row && $row['secans'] === $ans) {
        header("Location: ../newpass.php?username=$username");
    } else {
        echo "<script>alert('Answer didn\'t match!'); window.location.href='../forgot.php?res=fail';</script>";
    }
}
?>
