    <?php 
    session_start();
    require_once './includes/db.inc.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['user_email'];
    $fname = $_SESSION['user_fname'];
    $lname = $_SESSION['user_lname'];
    $phone = $_SESSION['phone_number'];
    $address = $_SESSION['user_address'];
    $fullname = $fname . ' ' . $lname;

    function get_user_profile_pic($conn, $email) {
        $stmt = $conn->prepare("SELECT profile_pic FROM user WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($pic);
        $stmt->fetch();
        $stmt->close();
        return $pic;
    }

    // ✅ Process Profile Picture Upload
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
        $uploadDir = __DIR__ . '/../images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmp = $_FILES['profile_pic']['tmp_name'];
        $fileName = basename($_FILES['profile_pic']['name']);
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $newName = uniqid('profile_', true) . '.' . $ext;
            $targetPath = $uploadDir . $newName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                $stmt = $conn->prepare("UPDATE user SET profile_pic = ? WHERE user_id = ?");
                $stmt->bind_param("si", $newName, $user_id);
                $stmt->execute();
                $stmt->close();
                $_SESSION['profile_pic'] = $newName;

                header("Location: user-center.php");
                exit;
            }
        }
    }

    // 🔄 Get latest user data
    $email = $_SESSION['user_email'];
    $fname = $_SESSION['user_fname'];
    $lname = $_SESSION['user_lname'];
    $phone = $_SESSION['phone_number'];
    $address = $_SESSION['user_address'];
    $fullname = $fname . ' ' . $lname;
    $pic = get_user_profile_pic($conn, $email);
    $picPath = '../images/' . ($pic && file_exists(__DIR__ . '/../images/' . $pic) ? $pic : 'default-user.png');
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User Center - MedCart</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" href="images/logo.png" type="image/icon type">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
        <style>
            body {background: url('./images/360_F_96243602_hgZuimFj1cJFqrrvERCnsq7NZ8VRZ7y7.jpg') no-repeat center center/cover; font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
            .profile-pic { width: 60px; height: 60px; object-fit: cover; border-radius: 50%; cursor: pointer;}
            .info-label { font-weight: bold; color: #555; }
            .info-value { color: #222; }
            .actions a, .actions button { margin-right: 10px; }
        </style>
    </head>
    <body>
    <?php include "includes/header1.php"; ?>
    <div class="container text-center table-responsive">
        <img src="<?= htmlspecialchars($picPath) ?>?v=<?= time() ?>" alt="Profile pic" class="profile-pic mb-3" data-bs-toggle="modal" data-bs-target="#picModal">
        
        <h2>User Profile</h2>
        <div class="text-center mt-4">
            <p><span class="info-label">Full Name:</span> <span class="info-value"><?= htmlspecialchars($fullname) ?></span></p>
            <p><span class="info-label">Email:</span> <span class="info-value"><?= htmlspecialchars($email) ?></span></p>
            <p><span class="info-label">Phone:</span> <span class="info-value"><?= htmlspecialchars($phone) ?></span></p>
            <p><span class="info-label">Address:</span> <span class="info-value"><?= htmlspecialchars($address) ?></span></p>
        </div>
        <div class="actions mt-5">
            <a href="change-password.php" class="btn" style="background: #2fa25a"><i class="fas fa-key"></i> Change Password</a>

            <a href="order.php" class="btn" style="background: #51eaea"><i class="fas fa-box"></i> View Orders</a>
        </div>
    </div>

    <!-- Profile Pic Modal -->
    <div class="modal fade" id="picModal" tabindex="-1" aria-labelledby="picModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="file" name="profile_pic" accept="image/*" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
    </body>
    </html>
