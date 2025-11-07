<?php
session_start();

require_once 'includes/db.inc.php';
require_once 'includes/functions.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $order_id = $_POST['order_id'];
    $user_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_fname = $_SESSION['user_fname'] ?? '';
    $user_lname = $_SESSION['user_lname'] ?? '';

    // Validate input
    if (empty($rating) || empty($comment)) {
        echo "<div class='alert alert-danger'>Please fill in all fields.</div>";
        exit;
    }

    // Prevent duplicate reviews
    if (has_review($order_id)) {
        echo "<div class='alert alert-info'>You have already submitted a review for this order.</div>";
        exit;
    }

    // Prepare and insert
    $stmt = $conn->prepare("INSERT INTO reviews (order_id, user_id, rating, comment, user_fname, user_lname) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisss", $order_id, $user_id, $rating, $comment, $user_fname, $user_lname);

    if ($stmt->execute()) {
        $_SESSION['review_success'] = true;
        header("Location: order.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>An error occurred while submitting your review. Please try again.</div>";
    }

    $stmt->close();
}
?>
