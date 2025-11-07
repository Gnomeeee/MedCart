<?php 
include "includes/head.php";
include_once 'includes/functions.php';

// Handle Add Staff
if (isset($_POST['add_staff'])) {
    $added = add_staff($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password']);
    if ($added) get_redirect("staff.php");
}

// Handle Edit/Update Staff
if (isset($_POST['update_staff'])) {
    $id = $_SESSION['staff_id'] ?? null;
    if ($id && isset($_POST['fname'], $_POST['lname'], $_POST['email'])) {
        update_user($id, $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password'] ?? '', 2);
    }
    unset($_SESSION['staff_id']);
    get_redirect("staff.php");
}

// Handle Cancel
if (isset($_POST['cancel'])) {
    unset($_SESSION['staff_id']);
    get_redirect("staff.php");
}

// Handle Delete Staff
if (isset($_GET['delete'])) {
  $staff_id = (int) $_GET['delete'];
  if (delete_staff($staff_id)) {
      $_SESSION['success'] = "Staff deleted successfully.";
  } else {
      $_SESSION['error'] = "Failed to delete staff.";
  }
  get_redirect("staff.php");
}
?>

<body>
<?php include "includes/header.php"; ?>
<?php include "includes/sidebar.php"; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
        <div class="container">
            <?php message(); ?>
            <div class="row align-items-center mb-3">
                <div class="col-12 col-md-6">
                    <h2>Staff Details</h2>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                <form class="d-flex" method="GET" action="staff.php">
                    <input class="form-control me-2" type="search" name="search_staff_email" placeholder="Search for staff (email)" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit" name="search_staff">Search</button>
                </form>
                </div>
            </div>
        </div>

    <?php
    if (isset($_GET['edit'])) {
        $_SESSION['staff_id'] = $_GET['edit'];
        $data = get_staff($_SESSION['staff_id']);
        if (!empty($data)) {
    ?>
        <br>
        <h2>Edit Staff Details</h2>
        <form action="staff.php" method="POST">
            <div class="form-group">
                <label>First Name</label>
                <input pattern="[A-Za-z_]{1,30}" type="text" class="form-control" value="<?php echo $data[0]['staff_fname'] ?>" name="fname" required>
            </div>
            <br>
            <div class="form-group">
                <label>Last Name</label>
                <input pattern="[A-Za-z_]{1,30}" type="text" class="form-control" value="<?php echo $data[0]['staff_lname'] ?>" name="lname" required>
            </div>
            <br>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" value="<?php echo $data[0]['staff_email'] ?>" name="email" required>
            </div>
            <br>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="New password (optional)" name="password">
            </div>
            <br>
            <button type="submit" class="btn btn-outline-success" name="update_staff">Submit</button>
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
                        <a class="btn btn-outline-primary" href="staff.php?add=1">Add</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = all_staff();
                if (isset($_GET['search_staff'])) {
                    $query = search_staff();
                    if (!empty($query)) {
                        $data = $query;
                    } else {
                        set_message("noResultStaff");
                        get_redirect("staff.php");
                    }
                }

                foreach ($data as $staff) {
                ?>
                    <tr>
                        <td><?php echo $staff['staff_id']; ?></td>
                        <td><?php echo $staff['staff_fname']; ?></td>
                        <td><?php echo $staff['staff_lname']; ?></td>
                        <td><?php echo $staff['staff_email']; ?></td>
                        <td>
                            <a class="btn btn-outline-warning" href="staff.php?edit=<?php echo $staff['staff_id']; ?>">Edit</a>
                            <a class="btn btn-outline-danger" href="staff.php?delete=<?php echo $staff['staff_id']; ?>" onclick="return confirm('Are you sure you want to delete this staff member?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($_GET['add'])) { ?>
        <h2>Add New Staff</h2>
        <form method="POST" action="staff.php">
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
            <button type="submit" name="add_staff" class="btn btn-outline-primary mt-4">Add Staff</button>
        </form>
    <?php } ?>
</main>

<?php include "includes/footer.php"; ?>
</body>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>