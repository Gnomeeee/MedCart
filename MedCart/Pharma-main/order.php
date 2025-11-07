<?php
session_start(); // ← This is necessary to access session variables
require_once 'includes/db.inc.php';
require_once 'includes/functions.php';

// Continue your existing logic
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Cancel order if requested
if (isset($_GET['cancel_order_id']) && is_numeric($_GET['cancel_order_id'])) {
  $order_id = (int) $_GET['cancel_order_id'];
  $user_id = $_SESSION['user_id']; // assuming user_id is stored in session

  if (cancel_customer_order($order_id, $user_id)) {
      echo "<div class='alert alert-success'>Order cancelled successfully.</div>";
  } else {
      echo "<div class='alert alert-danger'>Unable to cancel order.</div>";
  }
}

if (is_rider()) {
    $orders = rider_get_assigned_orders();
} else {
    $orders = get_customer_orders_with_status($user_id);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .status-step {
        padding: 6px 12px;
        border-radius: 20px;
        background-color: #dee2e6;
        color: #495057;
        font-weight: 500;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .status-step.active {
        background-color: #0d6efd;
        color: white;
    }

    .status-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 5px;
        margin-top: 10px;
    }
</style>
</head>
<body>
<?php include "includes/header1.php"; ?>
<div class="container mt-4">
    <h3 class="mb-4">Your Orders</h3>
    <?php if (empty($orders)): ?>
        <div class="alert alert-info">You have no orders yet.</div>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
        <?php if (!empty($order['product_name']) && !empty($order['item_image'])): ?>
            <div class="card mb-4">
                <div class="row g-0">
                    <!-- Image Column -->
                    <div class="col-12 col-md-4 col-lg-2 p-2 text-center">
                        <?php
                            $imagePath = 'images/' . $order['item_image'];
                            $image = (!empty($order['item_image']) && file_exists($imagePath))
                                ? $imagePath
                                : 'images/default.jpg';
                        ?>
                        <img src="<?= htmlspecialchars($image) ?>" alt="Product Image" class="img-fluid rounded shadow-sm" style="max-height: 240px; object-fit: cover;">
                    </div>

                    <!-- Details Column -->
                    <div class="col-12 col-md-8 col-lg-10">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($order['product_name']) ?></h5>
                                <p class="card-text mb-1">Order ID: <?= $order['order_id'] ?></p>
                                <p class="card-text mb-1">
                                    Status: 
                                    <strong class="text-<?= $order['delivery_status'] === 'Cancelled' ? 'danger' : ($order['delivery_status'] === 'Delivered' ? 'success' : 'primary') ?>">
                                        <?= ucfirst($order['delivery_status'] ?? 'Pending') ?>
                                    </strong>
                                </p>
                                <p class="card-text mb-1">Rider: <?= $order['rider_name'] ?? 'Not assigned' ?></p>
                                <p class="card-text"><small class="text-muted">Ordered on <?= date('M d, Y h:i A', strtotime($order['order_date'])) ?></small></p>

                                <div class="status-bar mb-3">
                                    <div class="status-step <?= $order['delivery_status'] === 'Pending' ? 'active' : '' ?>">Pending</div>
                                    <div class="status-step <?= $order['delivery_status'] === 'Accepted' ? 'active' : '' ?>">Accepted</div>
                                    <div class="status-step <?= $order['delivery_status'] === 'Delivered' ? 'active' : '' ?>">Delivered</div>
                                    <div class="status-step <?= $order['delivery_status'] === 'Cancelled' ? 'active' : '' ?>">Cancelled</div>
                                </div>

                                <?php if ((!isset($order['order_status']) || $order['order_status'] !== 'Cancelled') && $order['delivery_status'] !== 'Delivered'): ?>
                                    <div class="text-center">
                                        <a href="order.php?cancel_order_id=<?= (int) $order['order_id'] ?>" class="btn btn-danger btn-sm">Cancel Order</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($order['delivery_status'] === 'Delivered' && !has_review($order['order_id'])): ?>
            <div class="card mt-2 mb-4 ms-md-2 me-md-2 p-2 border shadow-sm bg-light">
                <form method="post" action="submit_review.php">
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                    <div class="mb-2">
                        <label for="rating_<?= $order['order_id'] ?>" class="form-label">Rating:</label>
                        <select name="rating" id="rating_<?= $order['order_id'] ?>" class="form-select" required>
                            <option value="">Select rating</option>
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <option value="<?= $i ?>"><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="comment_<?= $order['order_id'] ?>" class="form-label">Comment:</label>
                        <textarea name="comment" id="comment_<?= $order['order_id'] ?>" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">Submit Feedback</button>
                </form>
            </div>
        <?php elseif (has_review($order['order_id'])): ?>
            <div class="mt-2 mb-4 ms-md-4 me-md-4">
                <p class="text-success"><strong>Feedback submitted.</strong></p>
            </div>
        <?php endif; ?>
        <?php if ($order['delivery_status'] === 'Delivered' && !has_rider_review($order['order_id'], $_SESSION['user_id'])): ?>
            <div class="card mt-2 mb-4 ms-md-2 me-md-2 p-2 border shadow-sm bg-light">
                <form method="post" action="rider_reviews.php?order_id=<?= $order['order_id'] ?>">
                    <input type="hidden" name="rider_id" value="<?= $order['rider_id'] ?? '' ?>">
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

                    <h6>Rider Feedback</h6>
                    
                    <!-- Rider Rating -->
                    <div class="mb-2">
                        <label for="rider_rating_<?= $order['order_id'] ?>" class="form-label">Rating:</label>
                        <select name="rider_rating" id="rider_rating_<?= $order['order_id'] ?>" class="form-select" required>
                            <option value="">Select rating</option>
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <option value="<?= $i ?>"><?= $i ?> Star<?= $i > 1 ? 's' : '' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Rider Comment -->
                    <div class="mb-2">
                        <label for="rider_comment_<?= $order['order_id'] ?>" class="form-label">Comment:</label>
                        <textarea name="rider_comment" id="rider_comment_<?= $order['order_id'] ?>" class="form-control" rows="2" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-sm">Submit Feedback</button>
                </form>
            </div>
        <?php elseif (has_rider_review($order['order_id'], $_SESSION['user_id'])): ?>
            <div class="mt-2 mb-4 ms-md-4 me-md-4">
                <p class="text-success"><strong>Rider Feedback submitted.</strong></p>
            </div>
        <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
