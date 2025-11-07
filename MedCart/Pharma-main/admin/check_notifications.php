<?php
include './includes/db.inc.php';
session_start();

if (!isset($_SESSION['staff_id'])) {
    echo json_encode([]);
    exit;
}

$staff_id = $_SESSION['staff_id'];
$stmt = $conn->prepare("SELECT * FROM notification WHERE staff_id = ? AND status = 'unseen' ORDER BY created_at DESC");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['id'],
        'message' => $row['message'],
        'time' => date('M d, Y H:i', strtotime($row['created_at']))
    ];
}

header('Content-Type: application/json');
echo json_encode($notifications);
