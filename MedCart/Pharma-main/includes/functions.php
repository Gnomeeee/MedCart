<?php
$connection = mysqli_connect("localhost", "root", "", "medcart");
function post_redirect($url)
{
    ob_start();
    header('Location: ' . $url);
    ob_end_flush();
    die();
}
function get_redirect($url)
{
    echo " <script> 
    window.location.href = '" . $url . "'; 
    </script>";
}
function query($query)
{
    global $connection;
    $run = mysqli_query($connection, $query);
    if ($run) {
        while ($row = $run->fetch_assoc()) {
            $data[] = $row;
        }
        if (!empty($data)) {
            return $data;
        } else {
            return "";
        }
    } else {
        return 0;
    }
}
function single_query($query)
{
    global $connection;
    if (mysqli_query($connection, $query)) {
        return "done";
    } else {
        die("no data");
    }
}

function login()
{
    if (isset($_POST['login'])) {
        include './includes/db.inc.php';

        $identifier = trim(strtolower($_POST['userEmail']));
        $password   = trim($_POST['password']);

        if (empty($identifier) || empty($password)) {
            $_SESSION['message'] = "empty_err";
            post_redirect("login.php");
            exit;
        }

        $query = "SELECT user_id, email, user_password, user_fname, user_lname, user_address, phone_number, profile_pic 
                  FROM user 
                  WHERE email = ? OR phone_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $identifier, $identifier);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $_SESSION['message'] = "loginErr";
            post_redirect("login.php");
            exit;
        }

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['user_password'])) {
            $_SESSION['user_id']      = $user['user_id'];
            $_SESSION['user_fname']   = $user['user_fname'];
            $_SESSION['user_lname']   = $user['user_lname'];
            $_SESSION['user_email']   = $user['email'];
            $_SESSION['user_address'] = $user['user_address'];
            $_SESSION['phone_number'] = $user['phone_number'];
            $_SESSION['profile_pic']  = $user['profile_pic'];

            
            $cart_stmt = $conn->prepare("SELECT item_id, quantity FROM cart WHERE user_id = ?");
            $cart_stmt->bind_param("i", $user['user_id']);
            $cart_stmt->execute();
            $cart_result = $cart_stmt->get_result();

            $_SESSION['cart'] = [];
            while ($cart_item = $cart_result->fetch_assoc()) {
                $_SESSION['cart'][] = [
                    'user_id'       => $user['user_id'],
                    'item_id'       => $cart_item['item_id'],
                    'quantity'      => $cart_item['quantity'],
                    'user_address'  => $user['user_address'],
                    'phone_number'  => $user['phone_number'],
                ];
            }

            post_redirect("index.php");
            exit;
        } else {
            $_SESSION['message'] = "loginErr";
            post_redirect("login.php");
            exit;
        }
    }
}

function signUp() {
    if (isset($_POST['signUp'])) {
        include './includes/db.inc.php';

        $email   = trim(strtolower($_POST['email']));
        $fname   = trim($_POST['Fname']);
        $lname   = trim($_POST['Lname']);
        $address = trim($_POST['address']);
        $passwd  = trim($_POST['passwd']);
        $number  = trim($_POST['number']);
        $secque  = trim($_POST['secque']);
        $secans  = trim($_POST['secans']);

        
        if (
            empty($email) || empty($passwd) || empty($number) || empty($address) ||
            empty($fname) || empty($lname) || empty($secque) || empty($secans)
        ) {
            $_SESSION['message'] = "empty_err";
            post_redirect("signUp.php");
            exit;
        }

        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "signup_err_email";
            post_redirect("signUp.php");
            exit;
        }

        
        if (!preg_match('/^[0-9]{10,}$/', $number)) {
            $_SESSION['message'] = "signup_err_number";
            post_redirect("signUp.php");
            exit;
        }

        
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%]{8,30}$/', $passwd)) {
            $_SESSION['message'] = "signup_err_password";
            post_redirect("signUp.php");
            exit;
        }

        // Check if email already exists
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['message'] = "usedEmail";
            post_redirect("signUp.php");
            exit;
        }

        // Hash password
        $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT);

        // Insert user
        $query = "INSERT INTO user (email, user_fname, user_lname, user_address, phone_number, user_password, secque, secans) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssss", $email, $fname, $lname, $address, $number, $hashedPassword, $secque, $secans);

        if ($stmt->execute()) {
            $_SESSION['message'] = "signup_success";
            post_redirect("login.php");
            exit;
        } else {
            $_SESSION['message'] = "wentWrong";
            post_redirect("signUp.php");
            exit;
        }
    }
}



function forgot_password() {
    if (isset($_POST['ehelp'])) {
        include './includes/db.inc.php';
        $email = $_POST['email'];
        $query = "SELECT * FROM user WHERE email = '$email'";
        $res = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($res)) {
            echo "<form method='POST' action='php/forgot1.inc.php'>";
            echo "<label>Security Question: </label>";
            echo "<input type='text' value='" . $row['secque'] . "' disabled><br>";
            echo "<input type='hidden' name='username' value='" . $row['user_fname'] . "'>";
            echo "<input type='text' name='answer' placeholder='Your Answer' required><br>";
            echo "<button type='submit' name='submit'>Next</button>";
            echo "</form>";
        } else {
            echo "<p>Email not found.</p>";
        }
    }
}

function message() {
    if (isset($_SESSION['message'])) {

        if ($_SESSION['message'] == "signup_err_password") {
            echo "<div class='alert alert-danger' role='alert'>
                    Please enter the password in the correct form!
                  </div>";
        } elseif ($_SESSION['message'] == "loginErr") {
            echo "<div class='alert alert-danger' role='alert'>
                    The email or the password is incorrect!
                  </div>";
        } elseif ($_SESSION['message'] == "usedEmail") {
            echo "<div class='alert alert-danger' role='alert'>
                    This email is already used!
                  </div>";
        } elseif ($_SESSION['message'] == "usedEmailOrUsername") {
            echo "<div class='alert alert-danger' role='alert'>
                    This email or username is already registered!
                  </div>";
        } elseif ($_SESSION['message'] == "wentWrong") {
            echo "<div class='alert alert-danger' role='alert'>
                    Something went wrong!
                  </div>";
        } elseif ($_SESSION['message'] == "empty_err") {
            echo "<div class='alert alert-danger' role='alert'>
                    Please don't leave anything empty!
                  </div>";
        } elseif ($_SESSION['message'] == "signup_err_email") {
            echo "<div class='alert alert-danger' role='alert'>
                    Please enter the email in the correct form!
                  </div>";
        }
        elseif ($_SESSION['message'] == "signup_success") {
    echo "<div class='alert alert-success' role='alert'>
            Registration successful! You can now log in.
          </div>";
}

        // Clear message after showing
        unset($_SESSION['message']);
    }
}

function search($conn)
{
    // Live search for AJAX query param ?query=...
    if (isset($_GET['query'])) {
        $search = trim($_GET['query']);

        if (strlen($search) < 1) {
            echo json_encode([]);
            exit;
        }

        $stmt = $conn->prepare("SELECT item_id, item_title, item_price, item_image FROM item WHERE item_title LIKE CONCAT('%', ?, '%') LIMIT 10");

        if (!$stmt) {
            echo json_encode(['error' => 'SQL preparation failed']);
            exit;
        }

        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = [
                'id' => $row['item_id'],
                'title' => $row['item_title'],
                'price' => number_format($row['item_price'], 2),
                'image' => '../Pharma-main/images/' . basename($row['item_image'])
            ];
        }

        $stmt->close();

        header('Content-Type: application/json');
        echo json_encode($products);
        exit; // Stop further processing
    }

    // Traditional ?search=
    if (isset($_GET['search'])) {
        $search_text = trim($_GET['search']);
        if ($search_text === "") return [];

        $stmt = $conn->prepare("SELECT * FROM item WHERE item_title LIKE CONCAT('%', ?, '%')");
        $stmt->bind_param("s", $search_text);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        $stmt->close();
        return empty($products) ? "no result" : $products;
    }

    // Category-based filtering
    if (isset($_GET['cat'])) {
        $cat = $_GET['cat'];
        $stmt = $conn->prepare("SELECT * FROM item WHERE item_cat = ? ORDER BY RAND()");
        $stmt->bind_param("s", $cat);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        $stmt->close();
        return $products;
    }

    // Default all store items
    if (isset($_GET['store'])) {
        return all_products();
    }

    return []; // fallback
}


function all_products()
{
    $query = "SELECT * FROM item ORDER BY RAND()";
    $data = query($query);
    return $data;
}
function total_price($data)
{
    $sum = 0;
    $num = sizeof($data);
    for ($i = 0; $i < $num; $i++) {
        $sum += ($data[$i][0]['item_price'] * $_SESSION['cart'][$i]['quantity']);
    }
    return $sum;
}
function get_item()
{
    if (isset($_GET['product_id'])) {
        $_SESSION['item_id'] = $_GET['product_id'];
        $id = $_GET['product_id'];
        $query = "SELECT * FROM item WHERE item_id='$id'";
        $data = query($query);
        return $data;
    }
}

function get_user($id)
{
    $query = "SELECT user_id, user_fname, user_lname, email, phone_number, user_address FROM user WHERE user_id=$id";
    $data = query($query);
    return $data;
}

function add_cart($item_id)
{
    include './includes/db.inc.php'; // Required to use DB functions

    $user_id = $_SESSION['user_id'];
    if (isset($_GET['quantity'])) {
        $quantity = $_GET['quantity']; 
    }

    // Make sure user is logged in
    if (empty($user_id)) {
        get_redirect("login.php");
    } else {
        // Get phone and address from session
        $user_address = $_SESSION['user_address'] ?? '';
        $phone_number = $_SESSION['phone_number'] ?? '';

        // Check if item is already in cart (database)
        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND item_id = ?");
        $stmt->bind_param("ii", $user_id, $item_id);
        $stmt->execute();
        $stmt->store_result();

        if (isset($_GET['cart'])) {
            // Only add to session if not already present
            $exists_in_session = false;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $cart_item) {
                    if ($cart_item['item_id'] == $item_id) {
                        $exists_in_session = true;
                        break;
                    }
                }
            }

            if (!$exists_in_session) {
                $new_item = [
                    'user_id' => $user_id,
                    'item_id' => $item_id,
                    'quantity' => $quantity,
                    'user_address' => $user_address,
                    'phone_number' => $phone_number
                ];
                $_SESSION['cart'][] = $new_item;
            }

            // Insert or update in database cart
            if ($stmt->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND item_id = ?");
                $stmt->bind_param("iii", $quantity, $user_id, $item_id);
            } else {
                $stmt = $conn->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $user_id, $item_id, $quantity);
            }

            $stmt->execute();
            get_redirect("cart.php");
        }

        // Merge duplicates in session cart
        if (isset($_SESSION['cart'])) {
            $num = sizeof($_SESSION['cart']);
            for ($i = 0; $i < $num; $i++) {
                for ($j = $i + 1; $j < $num; $j++) {
                    if ($_SESSION['cart'][$i]['item_id'] == $_SESSION['cart'][$j]['item_id']) {
                        $_SESSION['cart'][$i]['quantity'] += $_SESSION['cart'][$j]['quantity'];
                        unset($_SESSION['cart'][$j]);
                        $_SESSION['cart'] = array_values($_SESSION['cart']);
                    }
                }
            }
        }
    }
}

function get_cart()
{
    $num = sizeof($_SESSION['cart']);
    if (isset($num)) {
        for ($i = 0; $i < $num; $i++) {
            $item_id = $_SESSION['cart'][$i]['item_id'];
            $query = "SELECT item_id, item_image ,item_title  ,item_quantity ,item_price ,item_brand FROM item WHERE item_id='$item_id'";
            $data[$i] = query($query);
        }
        return $data;
    }
}

function delete_from_cart()
{
    include './includes/db.inc.php';
    $user_id = $_SESSION['user_id'];

    if (isset($_GET['delete'])) {
        $item_id = $_GET['delete'];

        // Remove from session
        $num = sizeof($_SESSION['cart']);
        for ($i = 0; $i < $num; $i++) {
            if ($_SESSION['cart'][$i]['item_id'] == $item_id) {
                unset($_SESSION['cart'][$i]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }

        // Remove from database
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND item_id = ?");
        $stmt->bind_param("ii", $user_id, $item_id);
        $stmt->execute();

        get_redirect("cart.php");

    } elseif (isset($_GET['delete_all'])) {
        unset($_SESSION['cart']);

        // Remove all cart items from DB for the user
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        get_redirect("cart.php");
    }
}


function add_order() {
    include './includes/db.inc.php'; // Ensure $conn is available

    if (isset($_POST['order']) && isset($_POST['selected_items'])) {
        $selected_items = $_POST['selected_items'];
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d");

        $user_id = null; // Set outside loop for notification use

        foreach ($selected_items as $item_id) {
            foreach ($_SESSION['cart'] as $cart_item) {
                if ($cart_item['item_id'] == $item_id) {
                    $quantity = $cart_item['quantity'];
                    $user_id = $cart_item['user_id'];
                    $user_address = $cart_item['user_address'];
                    $phone_number = $cart_item['phone_number'];

                    if ($quantity == 0) continue;

                    // Get item details
                    $item = get_item_id($item_id);
                    $item_image = $item[0]['item_image'] ?? '';

                    // Insert order into database
                    $query = "INSERT INTO orders (user_id, item_id, item_image, order_quantity, order_date, user_address, phone_number) 
                              VALUES('$user_id', '$item_id', '$item_image', '$quantity', '$date', '$user_address', '$phone_number')";
                    single_query($query);

                    // Update item quantity in inventory
                    if (!empty($item)) {
                        $new_quantity = $item[0]['item_quantity'] - $quantity;
                        $query = "UPDATE item SET item_quantity='$new_quantity' WHERE item_id = '$item_id'";
                        single_query($query);
                    }

                    // Remove item from cart table in DB
                    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND item_id = ?");
                    $stmt->bind_param("ii", $user_id, $item_id);
                    $stmt->execute();

                    break; // Stop inner loop once matched
                }
            }
        }

        // Remove purchased items from session cart
        foreach ($selected_items as $selected_id) {
            foreach ($_SESSION['cart'] as $index => $cart_item) {
                if ($cart_item['item_id'] == $selected_id) {
                    unset($_SESSION['cart'][$index]);
                }
            }
        }

        // Re-index session cart
        $_SESSION['cart'] = array_values($_SESSION['cart']);

        // Send notification to all staff (role_id = 2)
        if ($user_id !== null) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE role_id = 2");
            $stmt->execute();
            $result = $stmt->get_result();

            while ($staff = $result->fetch_assoc()) {
                $staff_id = $staff['id'];
                $message = "A new order has been placed by customer ID: $user_id on $date.";
                send_notification($staff_id, $message);
            }
        }
    }
}


function load_cart_from_db($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['cart'] = [];  // Clear any existing session cart
        while ($row = $result->fetch_assoc()) {
            $_SESSION['cart'][] = $row;
        }
    }
}

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
function get_customer_orders_with_status($user_id) {
    global $conn;   

    $stmt = $conn->prepare("
        SELECT 
            o.order_id,
            o.item_id,
            o.item_image,
            o.order_status,
            o.delivery_status,
            o.rider_id,
            o.order_date,
            i.item_title AS product_name,
            CONCAT(u.fname, ' ', u.lname) AS rider_name
        FROM orders o
        JOIN item i ON o.item_id = i.item_id
        LEFT JOIN users u ON u.id = o.rider_id
        WHERE o.user_id = ?
        ORDER BY o.order_date DESC
    ");

    if (!$stmt) {
        return [];
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $orders;
}


function cancel_customer_order($order_id, $user_id) {
    global $conn;

    // Make sure the order belongs to the user and is still cancellable
    $stmt = $conn->prepare("SELECT order_status FROM orders WHERE order_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if (!$order || $order['order_status'] === 'Cancelled' || $order['delivery_status'] === 'Delivered') {
        return false; // Order not found or cannot be cancelled
    }

    // Update order status to 'Cancelled'
    $stmt = $conn->prepare("UPDATE orders SET order_status = 'Cancelled', delivery_status = 'Cancelled' WHERE order_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $order_id, $user_id);
    $success = $stmt->execute();
    $stmt->close();

    return $success;
}


function check_user($id)
{
    // Sanitize input if not using prepared statements
    $id = (int)$id; // Ensures only an integer is passed (prevents SQL injection)

    $query = "SELECT user_id FROM user WHERE user_id = $id LIMIT 1";
    $row = query($query);

    return !empty($row) ? 1 : 0;
}


function get_item_id($id)
{
    $query = "SELECT * FROM item WHERE item_id= '$id'";
    $data = query($query);
    return $data;
}

function all_products_reverse()
{
    $query = "SELECT * FROM item ";
    $data = query($query);
    return array_reverse($data);
}
function delivery_fees($data)
{
    if (total_price($data) < 200) {
        $num = sizeof($data);
        return $num * 40;
    } else {
        
        return 0;
    }
}

function get_all_orders_for_rider($rider_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT o.*, p.name AS product_name, u.name AS customer_name, s.email AS staff_name
        FROM orders o
        JOIN products p ON o.product_id = p.id
        JOIN users u ON o.customer_id = u.id
        LEFT JOIN users s ON o.staff_id = s.id
        WHERE o.rider_id = ?");
    $stmt->bind_param("i", $rider_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function assign_staff_to_order($order_id, $staff_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET staff_id = ? WHERE order_id = ?");
    $stmt->bind_param("ii", $staff_id, $order_id);
    $stmt->execute();
}

function mark_order_as_delivered($order_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE orders SET status = 'Delivered' WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
}

function get_all_staff() {
    global $conn;
    $stmt = $conn->query("SELECT id, email FROM users WHERE role_id = 2");
    return $stmt->fetch_all(MYSQLI_ASSOC);
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

function send_notification($staff_id, $message) {
    include './includes/db.inc.php';

    // Prepare the SQL statement to insert the notification into the database
    $stmt = $conn->prepare("INSERT INTO notification (staff_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $staff_id, $message);
    $stmt->execute();
}






