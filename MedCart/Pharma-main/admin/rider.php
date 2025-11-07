<?php
include "includes/head.php";
include_once 'includes/functions.php';

// Handle Add Rider
if (isset($_POST['add_rider'])) {
    $added = add_rider($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password']);
    if ($added) {
        $_SESSION['success'] = "Rider added successfully.";
    } else {
        $_SESSION['error'] = "Failed to add rider.";
    }
    get_redirect("rider.php");
}

// Handle Edit/Update Rider
if (isset($_POST['update_rider'])) {
    $id = $_SESSION['rider_id'] ?? null;
    if ($id && isset($_POST['fname'], $_POST['lname'], $_POST['email'])) {
        update_user($id, $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password'] ?? '', 3);
        $_SESSION['success'] = "Rider updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update rider.";
    }
    unset($_SESSION['rider_id']);
    get_redirect("rider.php");
}

// Handle Cancel
if (isset($_POST['cancel'])) {
    unset($_SESSION['rider_id']);
    get_redirect("rider.php");
}

// Handle Delete
if (isset($_GET['delete'])) {
    $rider_id = (int) $_GET['delete'];
    if (delete_rider($rider_id)) {
        $_SESSION['success'] = "Rider deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete rider.";
    }
    get_redirect("rider.php");
}
?>

<body>
<?php include "includes/header.php"; ?>
<?php include "includes/sidebar.php"; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
        <div class="container">
            <div class="row align-items-center mb-3">
                <div class="col-12 col-md-6">
                    <h2>Rider Details</h2>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                <form class="d-flex" method="GET" action="rider.php">
                    <input class="form-control me-2 col" type="search" name="search_rider_email" placeholder="Search for rider (email)" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit" name="search_rider" value="search">Search</button>
                </form>
                </div>
            </div>
        </div>
<?php message(); ?>
    <?php
    if (isset($_GET['edit'])) {
        $_SESSION['rider_id'] = $_GET['edit'];
        $data = get_rider($_SESSION['rider_id']);
        if (!empty($data)) {
    ?>
        <br>
        <h2>Edit Rider Details</h2>
        <form action="rider.php" method="POST">
            <div class="form-group">
                <label>First Name</label>
                <input pattern="[A-Za-z_]{1,30}" type="text" class="form-control" value="<?php echo $data[0]['fname'] ?>" name="fname" required>
            </div>
            <br>
            <div class="form-group">
                <label>Last Name</label>
                <input pattern="[A-Za-z_]{1,30}" type="text" class="form-control" value="<?php echo $data[0]['lname'] ?>" name="lname" required>
            </div>
            <br>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" value="<?php echo $data[0]['email'] ?>" name="email" required>
            </div>
            <br>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="New password (optional)" name="password">
            </div>
            <br>
            <button type="submit" class="btn btn-outline-success" name="update_rider">Submit</button>
            <button type="submit" class="btn btn-outline-danger" name="cancel">Cancel</button>
            <br><br>
        </form>
    <?php
        }
    }
    ?>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>
                        <a class="btn btn-outline-primary" href="rider.php?add=1">Add</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = all_riders();
                if (isset($_GET['search_rider'])) {
                    $query = search_rider();
                    if (!empty($query)) {
                        $data = $query;
                    } else {
                        set_message("noResultRider");
                        get_redirect("rider.php");
                    }
                }

                foreach ($data as $rider) {
                ?>
                    <tr>
                    <td><?php echo $rider['id']; ?></td>
                    <td><?php echo $rider['fname']; ?></td>
                    <td><?php echo $rider['lname']; ?></td>
                    <td><?php echo $rider['email']; ?></td>
                        <td>
                            <a class="btn btn-outline-warning" href="rider.php?edit=<?php echo $rider['id']; ?>">Edit</a>
                            <a class="btn btn-outline-danger" href="rider.php?delete=<?php echo $rider['id']; ?>" onclick="return confirm('Are you sure you want to delete this rider?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($_GET['add'])) { ?>
        <h2>Add New Delivery Rider</h2>
        <form method="POST" action="rider.php">
            <div class="form-group mt-3">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control" required pattern="[A-Za-z_]{1,30}">
            </div>
            <div class="form-group mt-3">
                <label>Last Name</label>
                <input type="text" name="lname" class="form-control" required pattern="[A-Za-z_]{1,30}">
            </div>
            <div class="form-group mt-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="add_rider" class="btn btn-outline-primary mt-4">Add Rider</button>
        </form>
    <?php } ?>
</main>

<?php include "includes/footer.php"; ?>
</body>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>