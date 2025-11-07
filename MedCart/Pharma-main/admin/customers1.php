<?php
include "includes/head1.php";
?>

<body>
<?php include "includes/header.php"; ?>
<?php include "includes/sidebar1.php"; ?>

 <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
        <div class="container">
            <div class="row align-items-center mb-3">
                <div class="col-12 col-md-6">
                    <h2>Customer Details</h2>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <form class="d-flex" method="GET" action="customers1.php">
                        <input class="form-control me-2 col" type="search" name="search_user_email" placeholder="Search for user (email)" aria-label="Search">
                        <button class="btn btn-outline-secondary" type="submit" name="search_user" value="search">Search</button>
                    </form>
                </div>
            </div>
        </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php message();
                $data = all_users();

                if (isset($_GET['search_user'])) {
                    $query = search_user();
                    $data = $query ?: get_redirect("customers1.php");
                } elseif (isset($_GET['id'])) {
                    $data = get_user_details();
                }

                foreach ($data as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_fname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_lname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_address']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php include "includes/footer1.php"; ?>
</body>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>