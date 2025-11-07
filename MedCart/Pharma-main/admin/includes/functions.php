<?php

include '../includes/db.inc.php'; // Adjust path if needed (e.g., ../includes/db.php)
$connection = mysqli_connect("localhost", "root", "", "medcart");

    function query($query)
    {
        global $connection;
        $run = mysqli_query($connection, $query);
        if ($run) {
            $data = [];
            while ($row = $run->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;  // return false for failure
        }
    }
    
    function single_query($query)
    {
        global $connection;
        $run = mysqli_query($connection, $query);
        return $run ? true : false;  // return true or false
    }
    
// query functions (end)
// redirect functions (start)
function post_redirect($url)
{
    ob_start();
    header('Location: ' . $url);
    // header('Location: https://md-taha-ahmed.000webhostapp.com/pharma/admin/' . $url);
    ob_end_flush();
    die();
}
function get_redirect($url)
{
    echo " <script> 
    window.location.href = '$url'; 
    </script>";
    // echo "<script>
    // window.location.href = 'https://md-taha-ahmed.000webhostapp.com/pharma/admin/" . $url . "';
    // </script>";
}
// redirect functions (end)
// messages function (start)
// Set a session message

function set_message($msg)
{
    $_SESSION['message'] = $msg;
}

function message()
{
    if (isset($_SESSION['message'])) {
        $messages = [
            // ⚠️ Error / Danger messages
            "loginErr"         => ["There is no account with this email!", "danger"],
            "emailErr"         => ["The email address is already taken. Please choose another.", "danger"],
            "loginErr1"        => ["The email or password is wrong!", "danger"],
            "noResult"         => ["There is no user with this email address.", "danger"],
            "itemerr"          => ["There is no product with this name!", "danger"],
            "itemErr"          => ["There is a product with the same name.", "danger"],
            "noResultOrder"    => ["There is no order with this ID!", "danger"],
            "noResultItem"     => ["There is no product with this name!", "danger"],
            "noResultAdmin"    => ["There is no admin with this email!", "danger"],
            "empty_err"        => ["Please don't leave anything empty!", "danger"],
            "noStaff"          => ["There are no Staff with this email!", "danger"],
            "noRider"          => ["There are no Rider with this email!", "danger"],
            "noResultRider"    => ["There is no rider with this email address.", "danger"],
            "noResultStaff"    => ["There is no staff with this email address.", "danger"],
            "noResultUser"     => ["There is no user with this email address.", "danger"],
            "noResultUser1"    => ["There is no user with this ID.", "danger"],
            "noResultAdmin1"   => ["There is no admin with this ID.", "danger"],
            "noResultItem1"    => ["There is no product with this ID.", "danger"],
            "noResultOrder1"   => ["There is no order with this ID.", "danger"],
            "noResultUser2"    => ["There is no user with this ID.", "danger"],
            "noResultUser3"    => ["There is no user with this ID.", "danger"],

            // ✅ Success messages
            "Added"            => ["Product added successfully.", "success"],
            "Edited"           => ["Product successfully updated!", "success"],
            "Deleted"          => ["Product successfully deleted.", "success"],
        ];

        $msgKey = $_SESSION['message'];

        if (isset($messages[$msgKey])) {
            [$text, $type] = $messages[$msgKey]; // destructure into text and type

            echo "
            <div class='alert alert-{$type} alert-dismissible' role='alert' style='margin-top:15px;'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='border-radius:100px; border:none; background-color:transparent; font-size:20px;'>

                 &times;
                </button>
                {$text}
            </div>";
        }

        unset($_SESSION['message']);
    }
}


// messages function (end)
// login function (start)
function login() {
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $email = $_POST['adminEmail'] ?? '';
        $password = $_POST['adminPassword'] ?? '';

        // 🔒 Admin login
        $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin) {
            if ($password === $admin['admin_password']) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_email'] = $admin['admin_email'];
                $_SESSION['role'] = 'admin';
                header("Location: ../admin/index.php");
                exit();
            } else {
                set_message("noResultAdmin"); // wrong password
                header("Location: login.php");
                exit();
            }
        }

        // 👨‍💼 Staff login
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role_id = 2");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $staff = $result->fetch_assoc();

        if ($staff) {
            if (password_verify($password, $staff['password'])) {
                $_SESSION['staff_id'] = $staff['id'];
                $_SESSION['staff_email'] = $staff['email'];
                $_SESSION['staff_fname'] = $staff['fname'];
                $_SESSION['staff_lname'] = $staff['lname'];
                $_SESSION['role'] = 'staff';
                $_SESSION['staff_role_id'] = $staff['role_id'];
                header("Location: ../admin/staff-dashboard.php");
                exit();
            } else {
                set_message("noStaff"); // wrong password
                header("Location: login.php");
                exit();
            }
        }

        // 🛵 Rider login
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role_id = 3");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $rider = $result->fetch_assoc();

        if ($rider) {
            if (password_verify($password, $rider['password'])) {
                $_SESSION['rider_id'] = $rider['id'];
                $_SESSION['rider_email'] = $rider['email'];
                $_SESSION['rider_fname'] = $rider['fname'];
                $_SESSION['rider_lname'] = $rider['lname'];
                $_SESSION['role'] = 'rider';
                $_SESSION['rider_role_id'] = $rider['role_id'];
                $_SESSION['user_id'] = $rider['id'];
                header("Location: ../admin/rider-dashboard.php");
                exit();
            } else {
                set_message("noRider"); // wrong password
                header("Location: login.php");
                exit();
            }
        }
    }
}

// login function (end)
// user functions (start)
function all_users()
{
    $query = "SELECT user_id, user_fname, user_lname, email, phone_number, user_address FROM user";
    $data = query($query);
    return $data;
}

function delete_user()
{
    if (isset($_GET['delete'])) {
        $userId = $_GET['delete'];
        $query = "DELETE FROM user WHERE user_id ='$userId'";
        $run = single_query($query);
        get_redirect("customers.php");
    }
}

function edit_user($id)
{
    if (isset($_POST['update'])) {
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $email = trim(strtolower($_POST['email']));
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);

        if (empty($email) || empty($address) || empty($fname) || empty($lname) || empty($phone)) {
            $_SESSION['message'] = "empty_err";
            get_redirect("customers.php");
            return;
        }

        $check = check_email_user($email);
        if ($check == 0) {
            $query = "UPDATE user SET email='$email', phone_number='$phone', user_fname='$fname', user_lname='$lname', user_address='$address' WHERE user_id='$id'";
            single_query($query);
            get_redirect("customers.php");
        } else {
            $_SESSION['message'] = "emailErr";
            get_redirect("customers.php");
        }
    } elseif (isset($_POST['cancel'])) {
        get_redirect("customers.php");
    }
}

function get_user($id)
{
    $query = "SELECT user_id, user_fname, user_lname, email, phone_number, user_address FROM user WHERE user_id=$id";
    $data = query($query);
    return $data;
}

function check_email_user($email)
{
    $query = "SELECT email FROM user WHERE email='$email'";
    $data = query($query);
    return $data ? 1 : 0;
}

function search_user()
{
    if (isset($_GET['search_user'])) {
        $email = trim(strtolower($_GET['search_user_email']));
        if (empty($email)) {
            return;
        }
        $query = "SELECT user_id, user_fname, user_lname, email, phone_number, user_address FROM user WHERE email='$email'";
        $data = query($query);
        if ($data) {
            return $data;
        } else {
            $_SESSION['message'] = "noResult";
            return;
        }
    }
}

function get_user_details()
{
    if ($_GET['id']) {
        $id = $_GET['id'];
        $query = "SELECT * FROM user WHERE user_id=$id";
        $data = query($query);
        return $data;
    }
}
// user functions (end)
// item functions (start)
function all_items()
{
    $query = "SELECT * FROM item";
    $data = query($query);
    return $data;
}
function delete_item()
{
    if (isset($_GET['delete'])) {
        $itemID = $_GET['delete'];
        $query = "DELETE FROM item WHERE item_id ='$itemID'";
        $run = single_query($query);
        get_redirect("products.php");
    }
}
function edit_item($id)
{
    if (isset($_POST['update'])) {
        $name = trim($_POST['name']);
        $brand = trim($_POST['brand']);
        $cat = trim($_POST['cat']);
        $tags = trim($_POST['tags']);
        $image = trim($_POST['item_image']);
        $quantity = trim($_POST['quantity']);
        $price = trim($_POST['price']);
        $details = trim($_POST['details']);
        $check = check_name($name);
        if ($check == 0) {
            $query = "UPDATE item SET item_title='$name' ,item_brand='$brand' ,item_cat='$cat' ,
            item_details='$details',item_tags='$tags' 
            ,item_image='$image' ,item_quantity='$quantity' ,item_price='$price'  WHERE item_id= '$id'";
            $run = single_query($query);
            get_redirect("products.php");
        } else {
            $_SESSION['message'] = "itemErr";
            get_redirect("products.php");
        }
    } elseif (isset($_POST['cancel'])) {
        get_redirect("products.php");
    }
}
function get_item($id)
{
    $query = "SELECT * FROM item WHERE item_id=$id";
    $data = query($query);
    return $data;
}
function check_name($name)
{
    $query = "SELECT item_title FROM item WHERE item_title='$name'";
    $data = query($query);
    if ($data) {
        return 1;
    } else {
        return 0;
    }
}
function search_item()
{
    if (isset($_GET['search_item'])) {
        $name = trim($_GET['search_item_name']);
        $query = "SELECT * FROM item WHERE item_title LIKE '%$name%'";
        $data = query($query);
        if ($data) {
            return $data;
        } else {
            $_SESSION['message'] = "noResultItem";
            return;
        }
    }
}
function add_item()
{
    if (isset($_POST['add_item'])) {
        $name = trim($_POST['name']);
        $brand = trim($_POST['brand']);
        $cat = trim($_POST['cat']);
        $tags = trim($_POST['tags']);
        $image = trim($_POST['image']);
        $quantity = trim($_POST['quantity']);
        $price = trim($_POST['price']);
        $details = trim($_POST['details']);
        $check = check_name($name);
        if (
            empty($name) or empty($brand) or empty($cat)  or
            empty($tags) or empty($image) or empty($quantity) or empty($price) or empty($details)
        ) {
            $_SESSION['message'] = "empty_err";
            get_redirect("products.php");
            return;
        }
        if ($check == 0) {
            $query = "INSERT INTO item (item_title, item_brand, item_cat, item_details  ,
            item_tags ,item_image ,item_quantity ,item_price) VALUES
            ('$name' ,'$brand' ,'$cat' ,'$details' ,'$tags' ,'$image' ,'$quantity' ,'$price')";
            $run = single_query($query);
            get_redirect("products.php");
        } else {
            $_SESSION['message'] = "itemErr";
            get_redirect("products.php");
        }
    } elseif (isset($_POST['cancel'])) {
        get_redirect("products.php");
    }
}
function get_item_details()
{
    if ($_GET['id']) {
        $id = $_GET['id'];
        $query = "SELECT * FROM item WHERE item_id=$id";
        $data = query($query);
        return $data;
    }
}
// item functions (end)
// admin functions (start)
function all_admins()
{
    $query = "SELECT admin_id ,admin_fname ,admin_lname ,admin_email  FROM admin";
    $data = query($query);
    return $data;
}
function get_admin($id)
{
    $query = "SELECT admin_id ,admin_fname ,admin_lname ,admin_email  FROM admin WHERE admin_id=$id";
    $data = query($query);
    return $data;
}
function edit_admin($id)
{
    if (isset($_POST['admin_update'])) {
        $fname = trim($_POST['admin_fname']);
        $lname = trim($_POST['admin_lname']);
        $email = trim(strtolower($_POST['admin_email']));
        $password = trim($_POST['admin_password']);
        $check = check_email_admin($email);
        if ($check == 0) {
            $query = "UPDATE admin SET admin_email='$email' ,admin_fname='$fname' ,admin_lname='$lname' ,admin_password='$password'  WHERE admin_id= '$id'";
            single_query($query);
            get_redirect("admin.php");
        } else {
            $_SESSION['message'] = "emailErr";
            get_redirect("admin.php");
        }
    } elseif (isset($_POST['admin_cancel'])) {
        get_redirect("admin.php");
    }
}
function check_email_admin($email)
{
    $query = "SELECT admin_email FROM admin WHERE admin_email='$email'";
    $data = query($query);
    if ($data) {
        return $data;
    } else {
        return 0;
    }
}
function add_admin()
{
    if (isset($_POST['add_admin'])) {
        $fname = trim($_POST['admin_fname']);
        $lname = trim($_POST['admin_lname']);
        $email = trim(strtolower($_POST['admin_email']));
        $password = trim($_POST['admin_password']);
        $check = check_email_admin($email);
        if ($check == 0) {
            $query = "INSERT INTO admin (admin_fname, admin_lname, admin_email, admin_password) 
            VALUES ('$fname','$lname','$email','$password')";
            single_query($query);
            get_redirect("admin.php");
        } else {
            $_SESSION['message'] = "emailErr";
            get_redirect("admin.php");
        }
    } elseif (isset($_POST['admin_cancel'])) {
        get_redirect("admin.php");
    }
}
function delete_admin()
{
    if (isset($_GET['delete'])) {
        $adminId = $_GET['delete'];
        $query = "DELETE FROM admin WHERE admin_id ='$adminId'";
        $run = single_query($query);
        get_redirect("admin.php");
    }
}
function search_admin()
{
    if (isset($_GET['search_admin'])) {
        $email = trim(strtolower($_GET['search_admin_email']));
        if (empty($email)) {
            return;
        }
        $query = "SELECT admin_id ,admin_fname ,admin_lname ,admin_email FROM admin WHERE admin_email='$email'";
        $data = query($query);
        if ($data) {
            return $data;
        } else {
            $_SESSION['message'] = "noResultAdmin";
            return;
        }
    }
}
function check_admin($id)
{
    $query = "SELECT admin_id FROM admin where admin_id='$id'";
    $row = query($query);
    if (empty($row)) {
        return 0;
    } else {
        return 1;
    }
}

// add_staff_or_rider function
function add_user_with_role($fname, $lname, $email, $password, $role_id) {
    global $connection;

    // Sanitize and validate
    $fname = trim($fname);
    $lname = trim($lname);
    $email = trim($email);
    $password = trim($password);

    if (!$fname || !$lname || !$email || !$password) {
        $_SESSION['error'] = "All fields are required.";
        return false;
    }

    // Check if email already exists
    $check = mysqli_query($connection, "SELECT id FROM users WHERE email = '$email'");
    if ($check && mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Email already exists.";
        return false;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $connection->prepare("INSERT INTO users (fname, lname, email, password, role_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $fname, $lname, $email, $hashed_password, $role_id);

    if ($stmt->execute()) {
        $stmt->close();
        $_SESSION['success'] = "User added successfully!";
        return true;
    } else {
        $_SESSION['error'] = "Insert error: " . $stmt->error;
        $stmt->close();
        return false;
    }
}

// =================== STAFF & RIDER FUNCTIONS ===================

function add_staff($fname, $lname, $email, $password) {
    return add_user_with_role($fname, $lname, $email, $password, 2); // 2 = Staff
}

function all_staff() {
    global $connection;
    $query = "SELECT id AS staff_id, fname AS staff_fname, lname AS staff_lname, email AS staff_email 
              FROM users 
              WHERE role_id = 2";
    $result = mysqli_query($connection, $query);
    $staff = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $staff[] = $row;
        }
    }

    return $staff;
}

function search_staff() {
    global $connection;
    $email = mysqli_real_escape_string($connection, $_GET['search_staff_email'] ?? '');

    $query = "SELECT id AS staff_id, fname AS staff_fname, lname AS staff_lname, email AS staff_email 
              FROM users 
              WHERE role_id = 2 AND email LIKE '%$email%'";

    $result = mysqli_query($connection, $query);
    $staff = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $staff[] = $row;
        }
    }

    // If search term was entered and no matching staff found
    if (isset($_GET['search_staff_email']) && empty($staff)) {
        set_message("noResultStaff");
    }

    return $staff;
}


function get_staff($id) {
    global $connection;
    $id = (int) $id;

    $query = "SELECT id AS staff_id, fname AS staff_fname, lname AS staff_lname, email AS staff_email 
              FROM users 
              WHERE role_id = 2 AND id = $id";

    $result = mysqli_query($connection, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        return [mysqli_fetch_assoc($result)];
    }

    return [];
}

function delete_staff($id) {
    global $connection;
    $id = (int)$id;

    $query = "DELETE FROM users WHERE id = $id AND role_id = 2";
    return mysqli_query($connection, $query);
}

function update_user($id, $fname, $lname, $email, $password, $role_id) {
    global $connection;

    $fname = trim($fname);
    $lname = trim($lname);
    $email = trim($email);
    $password = trim($password);
    $id = (int)$id;

    if ($password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET fname=?, lname=?, email=?, password=? WHERE id=? AND role_id=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssssii", $fname, $lname, $email, $hashed_password, $id, $role_id);
    } else {
        $query = "UPDATE users SET fname=?, lname=?, email=? WHERE id=? AND role_id=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssii", $fname, $lname, $email, $id, $role_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Staff updated successfully.";
    } else {
        $_SESSION['error'] = "Update failed.";
    }
    $stmt->close();
}


// Add rider
function add_rider($fname, $lname, $email, $password) {
    global $conn;

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result(); // ✅ required before accessing num_rows in MySQLi
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email already exists.";
        return false;
    }

    // Insert new rider
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, password, role_id) VALUES (?, ?, ?, ?, 3)");
    $stmt->bind_param("ssss", $fname, $lname, $email, $hashed_password);
    return $stmt->execute();
}


// admin functions Get all riders
function all_riders() {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE role_id = 3 ORDER BY id DESC");
    $stmt->execute();
    $result = $stmt->get_result(); // ✅ MySQLi-specific
    return $result->fetch_all(MYSQLI_ASSOC); // ✅ MySQLi-specific
}

// Get single rider
function get_rider($id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND role_id = 3");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


// Update rider
function update_rider($id, $fname, $lname, $email, $password) {
    global $conn;
    $role_id = 3;

    if ($password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET fname = ?, lname = ?, email = ?, password = ?, role_id = ? WHERE id = ?");
        return $stmt->execute([$fname, $lname, $email, $hashed_password, $role_id, $id]);
    } else {
        $stmt = $conn->prepare("UPDATE users SET fname = ?, lname = ?, email = ?, role_id = ? WHERE id = ?");
        return $stmt->execute([$fname, $lname, $email, $role_id, $id]);
    }
}

// Delete rider
function delete_rider($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role_id = 3");
    return $stmt->execute([$id]);
}

// Search rider
function search_rider() {
    global $conn;
    $email = "%" . trim($_GET['search_rider_email'] ?? '') . "%";

    $stmt = $conn->prepare("SELECT * FROM users WHERE email LIKE ? AND role_id = 3");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        set_message("noResultRider");
        return [];
    }
}


// admin functions (end)
// order functions (start)

function all_orders() {
    global $conn;

    $sql = "SELECT * FROM orders ORDER BY order_date DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function search_order() {
    global $conn;

    if (isset($_GET['search_order_id'])) {
        $order_id = mysqli_real_escape_string($conn, $_GET['search_order_id']);

        $sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
        $result = mysqli_query($conn, $sql);
        
        // Check if any result was returned
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            // No order found, set message
            set_message("noResultOrder");
            return [];
        }
    }

    return [];
}



function delete_order()
{
    if (isset($_GET['delete'])) {
        $order_id = $_GET['delete'];
        $query = "DELETE FROM orders WHERE order_id ='$order_id'";
        $run = single_query($query);
        get_redirect("orders.php");
    } elseif (isset($_GET['done'])) {
        $order_id = $_GET['done'];
        $query = "UPDATE orders SET order_status = 1 WHERE order_id='$order_id'";
        single_query($query);
        get_redirect("orders.php");
    } elseif (isset($_GET['undo'])) {
        $order_id = $_GET['undo'];
        $query = "UPDATE orders SET order_status = 0 WHERE order_id='$order_id'";
        single_query($query);
        get_redirect("orders.php");
    }
}
// order functions (end)

function get_all_staff() {
    global $conn;
    $stmt = $conn->query("SELECT id, email FROM users WHERE role_id = 2");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function is_staff() {
    return isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 2;
}

// Add item
// Add item (staff version)
function staff_all_items()
{
    $query = "SELECT * FROM item";
    $data = query($query);
    return $data;
}
function staff_delete_item()
{
    if (isset($_GET['delete'])) {
        $itemID = $_GET['delete'];
        $query = "DELETE FROM item WHERE item_id ='$itemID'";
        $run = single_query($query);
        get_redirect("products1.php");
        $_SESSION['message'] = "Deleted";
    }
}
function staff_edit_item($id)
{
    if (isset($_POST['update'])) {
        $name     = trim($_POST['name']);
        $brand    = trim($_POST['brand']);
        $cat      = trim($_POST['cat']);
        $tags     = trim($_POST['tags']);
        $image    = trim($_POST['item_image']);
        $quantity = trim($_POST['quantity']);
        $price    = trim($_POST['price']);
        $details  = trim($_POST['details']);

        // Check if name is used by another product (excluding current product)
        $query = "SELECT item_id FROM item WHERE item_title = '$name' AND item_id != '$id'";
        $existing = query($query);

        if ($existing) {
            set_message("itemErr"); // Product name conflict
            get_redirect("products1.php");
            return;
        }

        $query = "UPDATE item SET 
                    item_title    = '$name',
                    item_brand    = '$brand',
                    item_cat      = '$cat',
                    item_details  = '$details',
                    item_tags     = '$tags',
                    item_image    = '$image',
                    item_quantity = '$quantity',
                    item_price    = '$price'
                  WHERE item_id = '$id'";

        single_query($query);
        set_message("Edited"); // Reuse existing "Product successfully updated!" message
        get_redirect("products1.php");

    } elseif (isset($_POST['cancel'])) {
        get_redirect("products1.php");
    }
}


function staff_get_item_details($item_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM item WHERE item_id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
    $stmt->close();

    return $item;
}

function staff_check_name($name)
{
    $query = "SELECT item_title FROM item WHERE item_title='$name'";
    $data = query($query);
    if ($data) {
        return 1;
    } else {
        return 0;
    }
}

function staff_search_item()
{
    if (isset($_GET['search_item'])) {
        $name = trim($_GET['search_item_name']);
        $query = "SELECT * FROM item WHERE item_title LIKE '%$name%'";
        $data = query($query);
        if ($data) {
            return $data;
        } else {
            $_SESSION['message'] = "noResultItem";
            return;
        }
    }
}

function staff_add_item()
{
    if (isset($_POST['add_item'])) {
        $name     = trim($_POST['name']);
        $brand    = trim($_POST['brand']);
        $cat      = trim($_POST['cat']);
        $tags     = trim($_POST['tags']);
        $image    = trim($_POST['image']);
        $quantity = trim($_POST['quantity']);
        $price    = trim($_POST['price']);
        $details  = trim($_POST['details']);

        // Check for empty fields
        if (
            empty($name) || empty($brand) || empty($cat) ||
            empty($tags) || empty($image) || empty($quantity) || empty($price) || empty($details)
        ) {
            set_message("empty_err");
            get_redirect("products1.php");
            return;
        }

        // Check if product name already exists
        $check = check_name($name);
        if ($check == 0) {
            $query = "INSERT INTO item (item_title, item_brand, item_cat, item_details,
                      item_tags, item_image, item_quantity, item_price)
                      VALUES ('$name', '$brand', '$cat', '$details', '$tags', '$image', '$quantity', '$price')";
            single_query($query);
            set_message("Added"); // Use success message
        } else {
            set_message("itemErr"); // Correct key for "product with the same name"
        }

        get_redirect("products1.php");

    } elseif (isset($_POST['cancel'])) {
        get_redirect("products1.php");
    }
}


// Get all orders
function staff_all_orders() {
    global $conn;

    $sql = "SELECT * FROM orders ORDER BY order_date DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Search orders
function staff_search_order() {
    global $conn;

    if (isset($_GET['search_order_id'])) {
        $order_id = mysqli_real_escape_string($conn, $_GET['search_order_id']);

        $sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            set_message("noResultOrder"); // ✅ this key exists in your message map
            header("Location: orders1.php");
            exit();
        }
    } else {
        set_message("empty_err"); // ✅ you already use this for other empty-field messages
        header("Location: orders1.php");
        exit();
    }

    return [];
}


// Delete order or update status
function staff_delete_order_or_status_update() {
    if (!is_staff()) return;
    delete_order(); // handles delete/done/undo
}


  function get_order_by_id($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }
  
  function update_order($order_id, $user_id, $item_id, $order_quantity, $user_address, $delivery_status, $rider_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET user_id = ?, item_id = ?, order_quantity = ?, location = ?, delivery_status = ?, rider_id = ? WHERE order_id = ?");
    $stmt->bind_param("iiissii", $user_id, $item_id, $order_quantity, $user_address, $delivery_status, $rider_id, $order_id);
    return $stmt->execute();
}
  
  //STAFF TO RIDER FUNCTION 

 // Get user by full name and role

function get_user_by_name_and_role($fname, $lname, $role_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE fname = ? AND lname = ? AND role_id = ? LIMIT 1");
    $stmt->bind_param("ssi", $fname, $lname, $role_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Get user by ID and role
function get_user_by_id_and_role($id, $role_id) {
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ? AND role_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $id, $role_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Staff assigns a rider to an order

function get_assigned_orders_with_rider() {
    global $conn;

    $sql = "SELECT 
                o.*, 
                ru.fname AS rider_fname, ru.lname AS rider_lname,
                cu.user_fname AS customer_fname, cu.user_lname AS customer_lname, 
                cu.phone_number AS customer_phone_number, cu.user_address AS customer_address,
                i.item_title
            FROM orders o
            JOIN users ru ON o.rider_id = ru.id
            JOIN user cu ON o.user_id = cu.user_id
            JOIN item i ON o.item_id = i.item_id
            WHERE o.rider_id IS NOT NULL";

    $result = $conn->query($sql);
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    return $orders;
}


function staff_assign_rider_to_order($order_id, $rider_id) {
    global $conn;

    // Confirm the rider exists and has role_id = 3
    $stmt = $conn->prepare("SELECT id FROM users WHERE id = ? AND role_id = 3 LIMIT 1");
    $stmt->bind_param("i", $rider_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $stmt->close();

        // Just update rider_id and delivery_status
        $stmt = $conn->prepare("UPDATE orders SET rider_id = ?, delivery_status = 'Accepted' WHERE order_id = ?");
        $stmt->bind_param("ii", $rider_id, $order_id);
        $stmt->execute();
        $stmt->close();

        return true;
    } else {
        echo "Rider not found.";
        return false;
    }
}

// Get unassigned orders (for staff to assign riders)
function get_unassigned_orders() {
    global $conn;

    $sql = "SELECT 
                o.order_id,
                o.rider_id,
                CONCAT(c.user_fname, ' ', c.user_lname) AS customer_name,
                i.item_title AS product_name,
                i.item_image,
                o.order_status
            FROM orders o
            JOIN user c ON o.user_id = c.user_id
            JOIN item i ON o.item_id = i.item_id
            WHERE o.rider_id = 0 OR o.rider_id IS NULL";

    $result = mysqli_query($conn, $sql);
    $orders = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
    }

    return $orders;
}



// Rider views their assigned orders
function rider_get_assigned_orders() {
    global $conn;

    if (!isset($_SESSION['user_id']) || $_SESSION['rider_role_id'] != 3) return [];

    $rider_id = (int)$_SESSION['user_id'];

    $stmt = $conn->prepare("
    SELECT 
        o.order_id,
        i.item_image,
        i.item_title AS product_name,
        i.item_price AS product_price,
        CONCAT(c.user_fname, ' ', c.user_lname) AS customer_name,
        c.phone_number AS customer_phone,
        c.user_address AS customer_address,
        o.delivery_status,
        o.order_quantity,
        o.order_date
    FROM orders o
    JOIN item i ON o.item_id = i.item_id
    JOIN user c ON o.user_id = c.user_id
    WHERE o.rider_id = ?
    ORDER BY o.order_id DESC
    ");

    if (!$stmt) return [];

    $stmt->bind_param("i", $rider_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $orders;
}

function is_rider() {
    return isset($_SESSION['role_id']) && $_SESSION['rider_role_id'] == 3;
}

function rider_cancel_order($order_id) {
    global $conn;

    // If staff, they can cancel any order
    if (is_staff()) {
        $stmt = $conn->prepare("UPDATE orders SET delivery_status = 'cancelled', rider_id = NULL WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // If rider, cancel only if assigned to them
    if (is_rider() && isset($_SESSION['user_id'])) {
        $rider_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("SELECT rider_id FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->bind_result($assigned_rider_id);
        $stmt->fetch();
        $stmt->close();

        if ((int)$assigned_rider_id !== (int)$rider_id) {
            return false; // Rider trying to cancel someone else's order
        }

        $stmt = $conn->prepare("UPDATE orders SET delivery_status = 'cancelled', rider_id = NULL WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    return false;
}


function handle_rider_order_cancellation() {
    if (!isset($_POST['delete_order'], $_POST['order_id'])) {
        return;
    }

    $order_id = (int) $_POST['order_id'];

    if (!is_rider() || $order_id <= 0) {
        $_SESSION['error'] = "Unauthorized action or invalid order.";
        get_redirect("rider1.php");
    }

    $rider_id = $_SESSION['user_id']; // assumes user_id in session refers to rider ID

    $success = rider_cancel_order($order_id, $rider_id);
    $_SESSION[$success ? 'success' : 'error'] = $success
        ? "Order cancelled successfully."
        : "Failed to cancel the order.";

    get_redirect("rider1.php");
}


    // Step 1: Mark the order as delivered and reset order_status to 0
    function rider_mark_order_as_delivered($order_id) {
        global $conn;
    
        // 1. Mark as delivered
        $stmt = $conn->prepare("UPDATE orders SET delivery_status = 'Delivered', order_status = 1 WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $updated = $stmt->execute();
        $stmt->close();
    
        if (!$updated) return false;
    
        // 2. Get customer ID from order
        $stmt = $conn->prepare("SELECT user_id FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
    
        if (!$order) return false;
        $customer_id = $order['user_id'];
    
        // 3. Get customer's full name from users table
        $stmt = $conn->prepare("SELECT CONCAT(fname, ' ', lname) AS full_name FROM users WHERE id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();
        $stmt->close();
    
        $customer_name = $customer ? $customer['full_name'] : 'Unknown Customer';
    
        // 4. Send notification to all staff
        $message = "Order #$order_id for $customer_name has been delivered.";
    
        $stmt = $conn->prepare("SELECT id FROM users WHERE role_id = 2");
        $stmt->execute();
        $result = $stmt->get_result();
    
        while ($staff = $result->fetch_assoc()) {
            $staff_id = $staff['id'];
            $notify_stmt = $conn->prepare("INSERT INTO notifications (user_id, message, seen, created_at) VALUES (?, ?, 0, NOW())");
            $notify_stmt->bind_param("is", $staff_id, $message);
            $notify_stmt->execute();
            $notify_stmt->close();
        }
    
        $stmt->close();
    
        return true;
    }
    


// Rider marks an order as delivered & notifies staff

function get_all_riders() {
    global $conn;
    $sql = "SELECT id, fname, lname FROM users WHERE rider_role_id = 3";
    $result = mysqli_query($conn, $sql);
    $riders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $riders[] = $row;
    }
    return $riders;
}


function assign_order_to_rider($order_id, $rider_id) {
    global $conn;
    $sql = "UPDATE orders SET rider_id = ?, order_status = 'Assigned' WHERE order_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $rider_id, $order_id);
    return mysqli_stmt_execute($stmt);
}



function get_orders_assigned_to_rider($rider_id) {
    global $conn;
    $sql = "SELECT o.order_id, o.delivery_status AS order_status, 
                   i.item_title AS product_name, i.item_price AS product_price, 
                   CONCAT(c.fname, ' ', c.lname) AS customer_name
            FROM orders o
            JOIN item i ON o.item_id = i.item_id
            JOIN users c ON o.user_id = c.id
            WHERE o.rider_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $rider_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function delete_order_by_rider($order_id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    return $stmt->execute();
}

// Get all notifications for a user (e.g. staff)
function get_notifications_for_user($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Optional: Mark a notification as seen
function mark_notification_as_seen($notification_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE notifications SET seen = 1 WHERE id = ?");
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
}

function staff_all_riders() {
    global $conn;

    $sql = "SELECT id, fname, lname, email FROM users WHERE role_id = 3"; // role_id = 3 for riders
    $result = mysqli_query($conn, $sql);

    $riders = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $riders[] = $row;
        }
    }

    return $riders;
}

function send_notification($user_id, $message) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, seen, created_at) VALUES (?, ?, 0, NOW())");
    $stmt->bind_param("is", $user_id, $message);
    $stmt->execute();
    $stmt->close();
}


function notify_staff_on_delivery($order_id) {
    global $conn;

    // Get order details: staff and rider
    $stmt = $conn->prepare("SELECT staff_id, rider_id FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($staff_id, $rider_id);
    $stmt->fetch();
    $stmt->close();

    if ($staff_id) {
        $message = "Order #$order_id has been delivered by rider #$rider_id.";
        send_notification($staff_id, $message, 'staff');
    }
}


function notify_admin_on_delivery($order_id) {
    global $conn;

    $order = get_order_by_id($order_id); // Assumes this function returns array
    if ($order && $order['order_status'] == 1) {
        $admin_id = 1; // or fetch dynamically if needed
        $message = "Order #$order_id has been delivered by Rider #{$order['rider_id']}.";
        send_notification($admin_id, $message, 'admin');
    }
}

function has_review($order_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT 1 FROM reviews WHERE order_id = ? LIMIT 1");
    $stmt->bind_param("i", $order_id); // Ensure that $order_id is treated as an integer
    $stmt->execute();
    $stmt->store_result();
    $hasReview = $stmt->num_rows > 0;  // Returns true if there is a review
    $stmt->close();
    return $hasReview;
}

// Function to check if a rider review exists for a specific order
function has_rider_review($order_id, $user_id = null) {
    global $conn;
    if ($user_id !== null) {
        $stmt = $conn->prepare("SELECT 1 FROM rider_reviews WHERE order_id = ? AND user_id = ? LIMIT 1");
        $stmt->bind_param("ii", $order_id, $user_id);
    } else {
        $stmt = $conn->prepare("SELECT 1 FROM rider_reviews WHERE order_id = ? LIMIT 1");
        $stmt->bind_param("i", $order_id);
    }

    $stmt->execute();
    $stmt->store_result();
    $hasRiderReview = $stmt->num_rows > 0;
    $stmt->close();
    return $hasRiderReview;
}












