<?php
include "includes/head1.php";
include_once 'includes/functions.php';

// Ensure staff_id is set in the session
if (!isset($_SESSION['staff_id'])) {
    echo "No staff session found.";
    exit;
}
$staff_id = $_SESSION['staff_id'];

// Prepare and execute query to get unseen notifications
$stmt = $conn->prepare("SELECT * FROM notification WHERE staff_id = ? AND status = 'unseen' ORDER BY created_at DESC");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any notifications
if ($result->num_rows > 0) {
  while ($notification = $result->fetch_assoc()) {
      $text = htmlspecialchars($notification['message']);
      $type = 'info'; // You can change this dynamically if needed (e.g., based on severity)
      
      echo "
      <div class='alert alert-{$type} alert-dismissible fade show' role='alert' style='margin-top:15px; position: fixed; top: 20px; right: 20px; z-index: 1050; width: 300px;'>
          <button type='button' class='close' data-dismiss='alert' aria-label='Close' 
              style='border-radius:100px; border:none; background-color:transparent; font-size:20px;'>
              &times;
          </button>
          {$text}
      </div>";

      // Mark the notification as seen
      $mark_stmt = $conn->prepare("UPDATE notification SET status = 'seen' WHERE id = ?");
      $mark_stmt->bind_param("i", $notification['id']);
      $mark_stmt->execute();
  }
} else {
  $text = "No new orders.";
  $type = "info";

  echo "
  <div class='alert alert-{$type} alert-dismissible fade show' role='alert' style='margin-top:15px; position: fixed; top: 20px; right: 20px; z-index: 1050; width: 300px;'>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close' 
          style='border-radius:100px; border:none; background-color:transparent; font-size:20px;'>
          &times;
      </button>
      {$text}
  </div>";
}

?>

<body>
<?php include "includes/header1.php"; ?>

<div class="container-fluid">
  <?php include "includes/sidebar1.php"; ?>

  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <br>
    <div class="d-flex justify-content-center flex-wrap">
      <!-- Card for Orders -->
      <div class="card m-4" style="width: 100%; max-width: 25rem;">
        <a href="orders1.php">
          <img class="card-img-top mx-auto d-block" src="../images/shopping-cart.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
        </a>
        <div class="card-body text-center">
          <h5 class="card-title">Orders</h5>
          <a href="orders1.php" class="btn btn-primary">Go to orders page</a>
        </div>
      </div>

      <!-- Card for Products -->
      <div class="card m-4" style="width: 100%; max-width: 25rem;">
        <a href="products1.php">
          <img class="card-img-top mx-auto d-block" src="../images/package.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
        </a>
        <div class="card-body text-center">
          <h5 class="card-title">Products</h5>
          <a href="products1.php" class="btn btn-primary">Go to products page</a>
        </div>
      </div>

      <!-- Card for Customers -->
      <div class="card m-4" style="width: 100%; max-width: 25rem;">
        <a href="customers1.php">
          <img class="card-img-top mx-auto d-block" src="../images/users.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
        </a>
        <div class="card-body text-center">
          <h5 class="card-title">Customers</h5>
          <a href="customers1.php" class="btn btn-primary">Go to customers page</a>
        </div>
      </div>
      
      <!-- Card for Rider -->
      <div class="card m-4" style="width: 100%; max-width: 25rem;">
        <a href="rider1.php">
          <img class="card-img-top mx-auto d-block" src="../images/user.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
        </a>
        <div class="card-body text-center">
          <h5 class="card-title">Assign Orders to Rider</h5>
          <a href="rider1.php" class="btn btn-primary">Go to Assign Orders to Rider page</a>
        </div>
      </div>
      
      <div class="card m-4" style="width: 100%; max-width: 25rem;">
        <a href="assigned-orders.php">
          <img class="card-img-top mx-auto d-block" src="../images/truck.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
        </a>
        <div class="card-body text-center">
          <h5 class="card-title">Assigned Orders</h5>
          <a href="assigned-orders.php" class="btn btn-primary">Go to Assigned Orders page</a>
        </div>
      </div>

      <!-- Card for Reviews -->
      <div class="card m-4" style="width: 100%; max-width: 25rem;">
        <a href="reviews.php">
          <img class="card-img-top mx-auto d-block" src="../images/star.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
        </a>
        <div class="card-body text-center">
          <h5 class="card-title">Reviews</h5>
          <a href="reviews.php" class="btn btn-primary">Go to Reviews page</a>
        </div>
      </div>

      <!-- Card for Store -->
      <div class="card m-4" style="width: 100%; max-width: 25rem;">
        <a href="../index.php">
          <img class="card-img-top mx-auto d-block" src="../images/bag.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
        </a>
        <div class="card-body text-center">
          <h5 class="card-title">Go to Store</h5>
          <a href="../index.php" class="btn btn-primary">Go to Store</a>
        </div>
      </div>
      
    </div>
  </main>
</div>
<!-- Stylish Notification Container -->
<div id="notification-box" style="
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    width: 300px;
    max-height: 80vh;
    overflow-y: auto;
    display: none;
">
</div>

<?php include "includes/footer1.php"; ?>
</body>
</html>

<!-- Notification Box -->
<div id="notification-box" style="position: fixed; top: 10px; right: 10px; z-index: 1000; display: none;">
    <div class="alert alert-info" role="alert">
        <span id="notification-message"></span>
    </div>
</div>

<script>

function createNotificationElement(notification) {
    const div = document.createElement('div');
    div.className = 'alert alert-info alert-dismissible fade show shadow-sm mb-3';
    div.role = 'alert';
    div.style.borderLeft = '4px solid #0dcaf0'; // Bootstrap info color
    div.innerHTML = `
        <strong>🛎 Notification</strong><br>${notification.message}
        <br><small class="text-muted">${notification.time}</small>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    return div;
}

function checkNewNotifications() {
    fetch('check_notifications.php')
        .then(response => response.json())
        .then(data => {
            const box = document.getElementById('notification-box');
            box.innerHTML = ''; // Clear previous notifications

            if (data.length > 0) {
                box.style.display = 'block';
                data.forEach(notification => {
                    const element = createNotificationElement(notification);
                    box.appendChild(element);
                });

                // Mark as seen after displaying
                fetch('mark_notifications_seen.php');
            } else {
                box.style.display = 'none';
            }
        });
}

setInterval(checkNewNotifications, 30000);
checkNewNotifications();
</script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (required for dismiss buttons) -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
