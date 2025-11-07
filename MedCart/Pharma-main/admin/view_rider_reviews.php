<?php
session_start();

require_once '../includes/db.inc.php';
require_once 'includes/functions.php';

// Fix: Check for 'rider_id' and 'role'
if (!isset($_SESSION['rider_id']) || $_SESSION['role'] !== 'rider') {
    header("Location: login.php");
    exit;
}

// Use the rider_id from session
$rider_id = $_SESSION['rider_id'];

$stmt = $conn->prepare("
    SELECT rr.*, u.user_fname, u.user_lname, r.fname AS rider_fname, r.lname AS rider_lname
    FROM rider_reviews rr
    JOIN user u ON rr.user_id = u.user_id
    JOIN users r ON rr.rider_id = r.id
    WHERE rr.rider_id = ?
    ORDER BY rr.created_at DESC
");

$stmt->bind_param("i", $rider_id);
$stmt->execute();
$result = $stmt->get_result();
$reviews = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rider Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>My Reviews</h3>

    <?php if ($result->num_rows > 0): ?>
        <div class="list-group">
            <?php foreach ($reviews as $review): ?>
                <div class="list-group-item">
                    <h5>Review by <?= htmlspecialchars($review['user_fname']) ?> <?= htmlspecialchars($review['user_lname']) ?>:</h5>
                    <p><strong>Rating:</strong> <?= htmlspecialchars($review['rating']) ?> Stars</p>
                    <p><strong>Comment:</strong> <?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                    <p>
                        <small class="text-muted">By <?= htmlspecialchars($review['user_fname'] . ' ' . $review['user_lname']) ?> on <?= date('M d, Y h:i A', strtotime($review['created_at'])) ?></small>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No reviews yet.</div>
    <?php endif; ?>
</div>
</body>
</html>
