<?php
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (add_rider($fname, $lname, $email, $password)) {
        header("Location: rider.php"); // Update this path if needed
        exit();
    } else {
        echo $_SESSION['error'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Delivery Rider</title>
</head>
<body>
    <h2>Add Delivery Rider</h2>
    <form method="POST" action="">
        <input type="text" name="fname" placeholder="First Name" required><br>
        <input type="text" name="lname" placeholder="Last Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Add Rider</button>
    </form>
</body>
</html>
