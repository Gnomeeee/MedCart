<?php 
require_once '../includes/db.inc.php';

if (!isset($_SESSION['staff_email'], $_SESSION['staff_role_id']) || $_SESSION['staff_role_id'] != 2) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['staff_email'];

// === Functions ===
function update_staff_profile_pic($conn, $email, $filename) {
    $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE email = ? AND role_id = 2");
    $stmt->bind_param("ss", $filename, $email);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();
    return $affected > 0;
}

function get_staff_profile_pic($conn, $email) {
    $stmt = $conn->prepare("SELECT profile_pic FROM users WHERE email = ? AND role_id = 2 LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($dbPic);
    $stmt->fetch();
    $stmt->close();
    return $dbPic;
}

// === Handle Selecting Existing Picture ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select_existing'], $_POST['selected_pic'])) {
    $selected = basename($_POST['selected_pic']);
    $imageDir = realpath(__DIR__ . '/../../images/');
    $imagePath = realpath($imageDir . '/' . $selected);

    if ($imagePath && strpos($imagePath, $imageDir) === 0 && file_exists($imagePath)) {
        if (update_staff_profile_pic($conn, $email, $selected)) {
            $_SESSION['staff_profile_pic'] = $selected;
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// === Handle Uploading New Picture ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_new']) && isset($_FILES['new_pic'])) {
    $uploadDir = realpath(__DIR__ . '/../../images') . '/';
    $fileTmp = $_FILES['new_pic']['tmp_name'];
    $fileName = basename($_FILES['new_pic']['name']);
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($ext, $allowedExts)) {
        $newName = uniqid('profile_', true) . '.' . $ext;
        $targetPath = $uploadDir . $newName;

        if (move_uploaded_file($fileTmp, $targetPath)) {
            if (update_staff_profile_pic($conn, $email, $newName)) {
                $_SESSION['staff_profile_pic'] = $newName;
            }
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// === Load Profile Picture for Display ===
$pic = 'default-user.png';
$dbPic = get_staff_profile_pic($conn, $email);
$imagePath = __DIR__ . '/../../images/' . $dbPic;

if (!empty($dbPic) && file_exists($imagePath)) {
    $pic = $dbPic;
}
?>

<style>
input[type="radio"]:checked + img {
    border: 3px solid #007bff;
}
</style>

<!-- Sidebar -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse mt-4">
    <div class="position-sticky d-flex flex-column h-100 pt-3 justify-content-between">
        <div>
            <div class="px-3 pb-3 border-bottom text-center">
                <img src="../images/<?= htmlspecialchars($pic) ?>?v=<?= time() ?>" alt="Profile Picture" width="50" height="50"
                     class="rounded-circle mb-2" style="object-fit: cover; cursor: pointer;"
                     data-bs-toggle="modal" data-bs-target="#choosePicModal">
                <br>
                <strong><?= htmlspecialchars($_SESSION['staff_fname'] ?? '') . ' ' . htmlspecialchars($_SESSION['staff_lname'] ?? '') ?></strong><br>
                <small><?= htmlspecialchars($email) ?></small>
            </div>

            <ul class="nav flex-column mt-3">
                <li class="nav-item"><a class="nav-link" href="orders1.php"><span data-feather="shopping-cart"></span> Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="products1.php"><span data-feather="package"></span> Products</a></li>
                <li class="nav-item"><a class="nav-link" href="customers1.php"><span data-feather="users"></span> Customers</a></li>
                <li class="nav-item"><a class="nav-link" href="rider1.php"><span data-feather="user"></span> Assign Orders to Rider</a></li>
                <li class="nav-item"><a class="nav-link" href="assigned-orders.php"><span data-feather="truck"></span> Assigned Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="reviews.php"><span data-feather="star"></span> Reviews</a></li>
                <li class="nav-item"><a class="nav-link" href="../index.php"><span data-feather="shopping-bag"></span> Go to Store</a></li>
            </ul>
        </div>
        <div class="p-3 border-top">
            <a href="logout.php" class="btn btn-outline-danger w-100">
                <span data-feather="log-out"></span> Sign out
            </a>
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="choosePicModal" tabindex="-1" aria-labelledby="choosePicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Choose or Upload Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $imgDir = realpath(__DIR__ . '/../../images');
                    $images = scandir($imgDir);
                    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

                    foreach ($images as $img) {
                        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                        if (in_array($ext, $allowedExts)) {
                            echo '
                            <div class="col-3 mb-3 text-center">
                                <label>
                                    <input type="radio" name="selected_pic" value="' . htmlspecialchars($img) . '" style="display:none;" required>
                                    <img src="../images/' . htmlspecialchars($img) . '" class="img-thumbnail"
                                         style="width:100px; height:100px; object-fit:cover; cursor:pointer;"
                                         onclick="this.closest(\'label\').querySelector(\'input[type=radio]\').checked = true;">
                                </label>
                            </div>';
                        }
                    }
                    ?>
                </div>
                <div class="mt-4">
                    <label for="new_pic" class="form-label">Or Upload New Picture:</label>
                    <input class="form-control" type="file" name="new_pic" id="new_pic" accept=".jpg,.jpeg,.png,.gif">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="select_existing" class="btn btn-primary">Set Selected Picture</button>
                <button type="submit" name="upload_new" class="btn btn-success">Upload New Picture</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Hamburger Button for Small Screens -->
<!-- Navbar Toggle Button -->
<nav class="navbar navbar-light bg-light d-md-none">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" id="sidebarToggleBtn" aria-label="Toggle navigation">
      <span id="toggleIcon" class="fs-3">&#9776;</span> <!-- ☰ initially -->
    </button>
    <span class="navbar mb-0 h3">Staff Panel</span>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const toggleBtn = document.getElementById('sidebarToggleBtn');
  const toggleIcon = document.getElementById('toggleIcon');
  const sidebar = document.getElementById('sidebarMenu');

  toggleBtn.addEventListener('click', function () {
    sidebar.classList.toggle('show'); // Bootstrap's collapse class
    toggleIcon.innerHTML = sidebar.classList.contains('show') ? '&times;' : '&#9776;';
  });
</script>
