<?php
session_start();

require_once 'includes/db.inc.php';  // MySQLi connection setup
require_once 'includes/functions.php';  // General functions

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch the order details
$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    echo "<div class='alert alert-danger'>Order ID is missing.</div>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

$rider_id = $order['rider_id'] ?? null;

// Check if order exists and belongs to logged-in user
if (!$order || $order['user_id'] != $_SESSION['user_id']) {
    echo "<div class='alert alert-danger'>This order doesn't belong to you.</div>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $rider_id = isset($_POST['rider_id']) ? (int)$_POST['rider_id'] : null;
    $rating = $_POST['rider_rating'];
    $comment = trim($_POST['rider_comment']);
    $user_id = $_SESSION['user_id'];
    $user_fname = $_SESSION['user_fname'];
    $user_lname = $_SESSION['user_lname'];

    // Validate input
    if (empty($rating) || empty($comment)) {
        echo "<div class='alert alert-danger'>Please provide both a rating and a comment.</div>";
        exit;
    }

    // Prevent duplicate reviews
    if (has_rider_review($order_id, $user_id)) {
        echo "<div class='alert alert-info'>You have already submitted a review for this rider.</div>";
        exit;
    }

    // Insert review
    $stmt = $conn->prepare("INSERT INTO rider_reviews (order_id, rider_id, user_id, rating, comment, user_fname, user_lname) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissss", $order_id, $rider_id, $user_id, $rating, $comment, $user_fname, $user_lname);

    if ($stmt->execute()) {
        $_SESSION['review_success'] = true;
        header("Location: order.php?order_id=$order_id");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error submitting your review. Please try again later.</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rider Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Leave a Review for Rider</h3>

    <?php if ($order['delivery_status'] === 'Delivered' && !has_rider_review($order['order_id'], $_SESSION['user_id'])): ?>
        <div class="card mt-2 mb-4 ms-md-2 me-md-2 p-3 border shadow-sm bg-light">
            <form method="post" action="rider_reviews.php?order_id=<?= $order['order_id'] ?>">
              <input type="hidden" name="rider_id" value="<?= $order['rider_id'] ?? '' ?>">
                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

                <h6>Rider Feedback</h6>

                <div class="mb-2">
                    <label for="rider_rating" class="form-label">Rating:</label>
                    <select name="rider_rating" id="rider_rating" class="form-select" required>
                        <option value="">Select rating</option>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <option value="<?= $i ?>"><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="rider_comment" class="form-label">Comment:</label>
                    <textarea name="rider_comment" id="rider_comment" class="form-control" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-success btn-sm">Submit Feedback</button>
            </form>
        </div>
    <?php elseif (has_rider_review($order['order_id'], $_SESSION['user_id'])): ?>
        <div class="mt-2 mb-4 ms-md-4 me-md-4">
            <p class="text-success"><strong>Rider feedback already submitted.</strong></p>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">You cannot submit feedback for this order.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
