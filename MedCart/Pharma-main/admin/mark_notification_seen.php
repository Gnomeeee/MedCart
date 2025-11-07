<?php
include './includes/db.inc.php';
session_start();

$staff_id = $_SESSION['staff_id'];  // Assuming you store the staff ID in the session

$stmt = $conn->prepare("UPDATE notification SET status = 'seen' WHERE staff_id = ?");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
