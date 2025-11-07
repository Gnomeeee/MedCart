<?php
session_start();
require_once '../includes/db.inc.php';

$admin_logged_in = isset($_SESSION['admin_email'], $_SESSION['admin_id']) && $_SESSION['role'] === 'admin';
$staff_logged_in = isset($_SESSION['staff_email'], $_SESSION['staff_role_id']) && $_SESSION['staff_role_id'] == 2;

if (!$admin_logged_in && !$staff_logged_in) {
    header("Location: login.php");
    exit();
}


$stmt = $conn->prepare("
    SELECT r.*, i.item_title, u.user_fname, u.user_lname
    FROM reviews r
    JOIN orders o ON r.order_id = o.order_id
    JOIN item i ON o.item_id = i.item_id
    JOIN user u ON r.user_id = u.user_id
    ORDER BY r.created_at DESC
");

$stmt->execute();
$result = $stmt->get_result();
$reviews = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Customer Reviews</h2>
    <?php if (empty($reviews)): ?>
        <div class="alert alert-info">No reviews available.</div>
    <?php else: ?>
        <?php foreach ($reviews as $review): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($review['item_title']) ?></h5> <!-- Display the item title -->
                    <h6 class="card-subtitle mb-2 text-muted">Rated <?= $review['rating'] ?>/5</h6>
                    <p class="card-text"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                    <p class="card-text">
                        <small class="text-muted">By <?= htmlspecialchars($review['user_fname'] . ' ' . $review['user_lname']) ?> on <?= date('M d, Y h:i A', strtotime($review['created_at'])) ?></small>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
