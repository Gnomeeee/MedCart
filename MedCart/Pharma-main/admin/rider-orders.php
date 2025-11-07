<?php 
include "includes/head1.php";

include_once 'includes/functions.php';


if (!isset($_SESSION['user_id']) || $_SESSION['rider_role_id'] != 3) {
    get_redirect("login.php");
}

$rider_id = (int) $_SESSION['user_id'];

if (isset($_POST['cancel'])) {
    get_redirect("rider-orders.php");
}

if (isset($_POST['mark_delivered'], $_POST['order_id'])) {
    $order_id = (int) $_POST['order_id'];
    if ($order_id > 0) {
        $success = rider_mark_order_as_delivered($order_id);
        $_SESSION[$success ? 'success' : 'error'] = $success
            ? "Order marked as delivered."
            : "Failed to update order.";
    } else {
        $_SESSION['error'] = "Invalid order ID.";
    }
    get_redirect("rider-orders.php");
}

if (isset($_GET['delete'])) {
    $order_id = (int) $_GET['delete'];
    if ($order_id > 0) {
        $success = delete_order_by_rider($order_id);
        $_SESSION[$success ? 'success' : 'error'] = $success
            ? "Delivered order deleted successfully."
            : "Failed to delete order.";
    } else {
        $_SESSION['error'] = "Invalid order ID.";
    }
    get_redirect("rider-orders.php");
}

$assigned_orders = rider_get_assigned_orders($rider_id);
?>

<body>
<?php include "includes/header.php";
include "includes/sidebar2.php"; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
    <h3>My Assigned Orders</h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Product image</th>
                    <th>Price</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($assigned_orders)) : ?>
                    <?php foreach ($assigned_orders as $order) : ?>
                        <tr>
                            <td><strong><?= (int) $order['order_id']; ?></strong></td>
                            <td><?= htmlspecialchars($order['product_name']); ?></td>
                            <td><?= htmlspecialchars($order['order_quantity']); ?></td>
                            <td><?= htmlspecialchars($order['item_image']); ?></td>
                            <td><strong>₱<?= number_format((float) $order['product_price'], 2); ?></strong></td>
                            <td><?= htmlspecialchars($order['customer_name']); ?></td>
                            <td><?= htmlspecialchars($order['customer_phone']); ?></td>
                            <td><?= htmlspecialchars($order['customer_address']); ?></td>
                            <td>
                                <span class="badge bg-<?= strtolower($order['delivery_status']) === 'delivered' ? 'success' : 'secondary'; ?>">
                                    <?= htmlspecialchars($order['delivery_status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if (strtolower($order['delivery_status']) !== 'delivered') : ?>
                                    <form method="POST" action="rider-orders.php" class="d-inline">
                                        <input type="hidden" name="order_id" value="<?= (int) $order['order_id']; ?>">
                                        <button type="submit" name="mark_delivered" class="btn btn-sm btn-success">
                                            Mark Delivered
                                        </button>
                                    </form>
                                <?php else : ?>
                                    <a href="rider-orders.php?delete=<?= $order['order_id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this delivered order?');">
                                        Delete
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-muted">No assigned orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include "includes/footer1.php"; ?>
</body>
</html>
