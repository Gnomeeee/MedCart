<?php 
include "includes/head1.php";
include_once 'includes/functions.php';

// Delete or update status if needed
staff_delete_order_or_status_update();

// Handle cancel button
if (isset($_POST['cancel'])) {
    get_redirect("rider1.php");
}

if (isset($_POST['delete_order'], $_POST['order_id'])) {
    $order_id = (int) $_POST['order_id'];

    if ($order_id > 0) {
        $success = rider_cancel_order($order_id);
        $_SESSION[$success ? 'success' : 'error'] = $success
            ? "Order cancelled successfully."
            : "Failed to cancel the order.";
    } else {
        $_SESSION['error'] = "Invalid order ID.";
    }

    get_redirect("rider1.php"); // or wherever the form lives
}

if (isset($_POST['mark_delivered'], $_POST['order_id'])) {
    $order_id = (int) $_POST['order_id'];

    if ($order_id > 0) {
        $updated = mark_order_as_delivered($order_id); // This function should update delivery_status = 'delivered'
        $_SESSION[$updated ? 'success' : 'error'] = $updated
            ? "Order marked as delivered."
            : "Failed to update delivery status.";
    } else {
        $_SESSION['error'] = "Invalid order ID.";
    }

    get_redirect("rider1.php");
}

// Handle assign rider form
if (isset($_POST['assign_rider'])) {
    $order_id = (int) $_POST['order_id'];
    $rider_id = (int) $_POST['rider_id'];

    $rider = get_user_by_id_and_role($rider_id, 3); // Only allow valid riders
    if ($rider) {
        $assigned = staff_assign_rider_to_order($order_id, $rider_id);
        $_SESSION[$assigned ? 'success' : 'error'] = $assigned ? "Rider assigned successfully." : "Failed to assign rider.";
    } else {
        $_SESSION['error'] = "Invalid rider selected.";
    }
    get_redirect("rider1.php");
}
?>

<body>
<?php include "includes/header.php"; ?>
<?php include "includes/sidebar1.php"; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php message(); ?>

    <div class="container mt-4">
        <h3>Assigned Orders</h3>
        <div class="table-responsive mt-3 mb-5">
            <table class="table table-bordered table-hover table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Product Image</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Rider</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $assigned_orders = get_assigned_orders_with_rider();
                foreach ($assigned_orders as $order):
                    $rider_name = htmlspecialchars($order['rider_fname'] . ' ' . $order['rider_lname']);
                    $customer_name = htmlspecialchars($order['customer_fname'] . ' ' . $order['customer_lname']);
                    $status = strtolower($order['delivery_status']);
                    $color = match ($status) {
                        'pending' => 'orange',
                        'shipped' => 'blue',
                        'delivered' => 'green',
                        default => 'gray'
                    };
                ?>
                    <tr>
                        <td><?= (int)$order['order_id']; ?></td>
                        <td><?= htmlspecialchars($order['item_image']); ?></td>
                        <td><?= $customer_name; ?></td>
                        <td><?= htmlspecialchars($order['customer_phone_number']); ?></td>
                        <td><?= htmlspecialchars($order['customer_address']); ?></td>
                        <td><?= htmlspecialchars($order['item_title']); ?></td>
                        <td><span style="color: <?= $color ?>;"><?= ucfirst($status) ?></span></td>
                        <td><?= $rider_name; ?></td>
                        <td>
                            <?php if ($status !== 'delivered'): ?>
                                <form method="POST" action="rider1.php" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= (int)$order['order_id']; ?>">
                                    <button type="submit" name="delete_order" onclick="return confirm('Are you sure you want to cancel this order?');" class="btn btn-sm btn-danger">
                                        Cancel
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($assigned_orders)): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">No assigned orders.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include "includes/footer1.php"; ?>
</body>
</html>
