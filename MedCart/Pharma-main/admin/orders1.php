<?php 
include "includes/head1.php";
include_once "includes/functions.php";
?>

<body>
    <?php include "includes/header1.php"; ?>
    <?php include "includes/sidebar1.php"; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
        <div class="container">
        <?php message();?>
            <div class="row align-items-center mb-3">
                <div class="col-12 col-md-6">
                    <h2>Order Details</h2>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <form class="d-flex" method="GET" action="orders1.php">
                        <input class="form-control me-2" type="search" name="search_order_id" placeholder="Search for order (ID)" aria-label="Search">
                        <button class="btn btn-outline-secondary" type="submit" name="search_order" value="search">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <?php 
        // DELETE, MARK DONE, MARK PENDING, UPDATE ORDER etc.
        if (isset($_GET['delete']) && is_staff()) {
            delete_order();
            get_redirect("orders1.php");
        }
        if (isset($_GET['done']) && is_staff()) {
            mark_order_done($_GET['done']);
            notify_staff_on_delivery($_GET['done']);
            get_redirect("orders1.php");
        }
        if (isset($_GET['undo']) && is_staff()) {
            mark_order_pending($_GET['undo']);
            get_redirect("orders1.php");
        }
        if (isset($_POST['update_order']) && is_staff()) {
            update_order(
                $_POST['item_image'],
                $_POST['order_id'],
                $_POST['user_id'],
                $_POST['item_id'],
                $_POST['order_quantity'],
                $_POST['user_address'],
                $_POST['delivery_status'],
                $_POST['rider_id']
            );
            get_redirect("orders1.php");
        }

        // SEARCH
        $data = all_orders();
        if (isset($_GET['search_order'])) {
            $query = search_order();
            $data = !empty($query) ? $query : get_redirect("orders1.php");
        }
        ?>

        <div class="table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">Order List</h4>
            </div>
            <table class="table table-hover table-bordered align-middle text-center shadow-sm">
                <thead class="table" style="background-color:rgb(165, 210, 255);">
                    <tr>
                        <th>#</th>
                        <th>Product image</th>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Product ID</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Phone Number</th>
                        <th>Delivery</th>
                        <th>Rider ID</th>
                        <?php if (is_staff()) echo '<th>Delete</th>'; ?>
                        <?php if (is_staff()) echo '<th>Status Action</th>'; ?>
                        <th>User</th>
                        <th>Product</th>
                        <?php if (is_staff()) echo '<th>Edit</th>'; ?>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($data as $i => $row) { ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $row['item_image'] ?></td>
                            <td><?= $row['order_id'] ?></td>
                            <td><?= $row['user_id'] ?></td>
                            <td><?= $row['item_id'] ?></td>
                            <td><?= $row['order_quantity'] ?></td>
                            <td><?= $row['order_date'] ?></td>
                            <td>
                                <span class="badge" style="color: black"<?= $row['order_status']?>>
                                    <?= $row['order_status'] == 1 ? 'Done' : 'Pending' ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['user_address']) ?></td>
                            <td><?= htmlspecialchars($row['phone_number']) ?></td>
                            <td><?= htmlspecialchars($row['delivery_status']) ?></td>
                            <td><?= $row['rider_id'] ?></td>

                            <?php if (is_staff()) { ?>
                            <td>
                                <a class="btn btn-sm btn-danger" href="orders1.php?delete=<?= $row['order_id'] ?>"
                                   onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                            </td>
                            <td>
                                <?php if ($row['order_status'] == 1) { ?>
                                    <a class="btn btn-sm btn-outline-danger" href="orders1.php?undo=<?= $row['order_id'] ?>">Undo</a>
                                <?php } else { ?>
                                    <a class="btn btn-sm btn-outline-success" href="orders1.php?done=<?= $row['order_id'] ?>">Mark as Done</a>
                                <?php } ?>
                            </td>
                            <?php } ?>

                            <td>
                                <a class="btn btn-sm btn-info text-white" href="customers1.php?id=<?= $row['user_id'] ?>">View User</a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-info text-white" href="products1.php?id=<?= $row['item_id'] ?>">View Product</a>
                            </td>

                            <?php if (is_staff()) { ?>
                            <td>
                                <a class="btn btn-sm btn-warning" href="orders1.php?edit=<?= $row['order_id'] ?>">Edit</a>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php
        if (isset($_GET['edit']) && is_staff()) {
            $edit_id = $_GET['edit'];
            $order = get_order_by_id($edit_id);
            if ($order) {
        ?>
                <br>
                <h2>Edit Order</h2>
                <form method="POST" action="orders1.php">
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

                    <div class="form-group">
                        <label>User ID</label>
                        <input type="number" class="form-control" name="user_id" value="<?= $order['user_id'] ?>" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Product ID</label>
                        <input type="number" class="form-control" name="item_id" value="<?= $order['item_id'] ?>" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control" name="order_quantity" value="<?= $order['order_quantity'] ?>" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location" value="<?= htmlspecialchars($order['user_address']) ?>" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Delivery Status</label>
                        <select class="form-control" name="delivery_status">
                            <option value="Pending" <?= $order['delivery_status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Shipped" <?= $order['delivery_status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="Delivered" <?= $order['delivery_status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Rider ID</label>
                        <input type="number" class="form-control" name="rider_id" value="<?= $order['rider_id'] ?>">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-outline-primary" name="update_order">Update</button>
                    <a href="orders1.php" class="btn btn-outline-secondary">Cancel</a>
                    <br><br>
                </form>
        <?php
            }
        }
        ?>
    </main>

    <?php include "includes/footer1.php"; ?>
</body>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>