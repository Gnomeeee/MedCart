<?php
require_once './includes/db.inc.php';

$user_id = $_SESSION['user_id'] ?? null;
$fname = htmlspecialchars($_SESSION['user_fname'] ?? '');
$lname = htmlspecialchars($_SESSION['user_lname'] ?? '');
$email = htmlspecialchars($_SESSION['user_email'] ?? '');
$pic = $_SESSION['profile_pic'] ?? null;

$profile_pic = '/MedCart/images/default-user.png';
if (!empty($_SESSION['profile_pic'])) {
    $pic = basename($_SESSION['profile_pic']); // sanitize filename
    $absolutePath = realpath(__DIR__ . '/../images/' . $pic);
    if ($absolutePath && file_exists($absolutePath)) {
        $profile_pic = '/MedCart/images/' . $pic;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MedCart</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

        .dropdown-user {
            position: relative;
            display: inline-block;
            
        }
        .search-results-box {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border: 1px solid #ccc;
            max-height: 300px;
            overflow-y: auto;
            z-index: 999;
            border-radius: 4px;
        }

        .result-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }
        .result-item:hover {
            background-color: #f9f9f9;
        }
        .result-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 4px;
        }

        .dropdown-user-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            min-width: 220px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 6px;
            padding: 10px 0;
        }

        .dropdown-user-content a {
            color: #333;
            padding: 10px 20px;
            text-decoration: none;
            display: block;
        }

        .dropdown-user-content a:hover {
            background-color: #f5f5f5;
        }

        .dropdown-user:hover .dropdown-user-content {
            display: block;
        }

        .user-info {
            padding: 10px 20px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .user-info strong {
            display: block;
        }

        .user-icon {
            font-size: 16px;
            margin-top: 4px;
        }
    </style>
</head>
<body>

<div class="site-navbar py-2">
    <div class="search-wrap">
        <div class="container">
            <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
            <form action="store.php" method="GET">
                <input type="text" name="search" class="form-control" id="liveSearch" placeholder="Search products..." autocomplete="off">
            </form>
            <!-- Search Results Box (it will be filled dynamically) -->
            <div id="searchResults" class="search-results-box"></div>
        </div>
    </div>
    
    <div class="container" style="background-color:rgb(22, 213, 213); border-radius: 60px;">         
        <div class="d-flex align-items-center justify-content-between">
            <div class="logo">
                <div class="site-logo">
                    <a href="index.php" class="js-logo-clone">MedCart</a>
                </div>
            </div>

            <div class="main-nav d-none d-lg-block">
                <nav class="site-navigation text-right text-md-center" role="navigation">
                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                        <li><a href="index.php" style="color: white">Home</a></li>
                        <li><a href="store.php?store=all" style="color: white;">Store</a></li>
                        <li class="has-children">
                            <a href="#" style="color: white;">All Categories</a>
                            <ul class="dropdown">
                                <li><a href="store.php?cat=medicine/Treatm">Medicine/Treatments</a></li>
                                <li><a href="store.php?cat=Personal Care">Personal Care</a></li>
                                <li><a href="store.php?cat=<?= urlencode('Baby & Kid Care') ?>">Baby & Kid Care</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="icons d-flex align-items-center">
                <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>
               

                <a href="cart.php" class="icons-btn d-inline-block bag">
                    <span class="icon-shopping-bag"></span>
                    <span class="number"><?= !empty($_SESSION['cart']) ? sizeof($_SESSION['cart']) : '0' ?></span>
                </a>
                <?php if (!$user_id): ?>
                    <a href="login.php" class="icons-btn d-inline-block">
                        <span class="fas fa-sign-in-alt"></span>
                    </a>
                <?php else: ?>
                    <div class="dropdown-user">
                        <a href="#" class="icons-btn d-inline-block">
                            <?php if (str_contains($profile_pic, 'default-user.png')): ?>
                                <span class="fas fa-user user-icon" ></span>
                            <?php else: ?>
                                <img src="<?= $profile_pic ?>?v=<?= time() ?>" alt="Profile" class="rounded-circle" style="width:35px;height:35px;object-fit:cover;">
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-user-content">
                            <div class="user-info text-center">
                                <strong><?= $fname . ' ' . $lname ?></strong>
                                <small><?= $email ?></small>
                            </div>
                            <a href="user-center.php"><i class="fas fa-user-circle"></i> User Center</a>
                            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                <?php endif; ?>
                <a href="#" class="site-menu-toggle js-menu-toggle ml-2 d-inline-block d-lg-none"><span class="icon-menu"></span></a>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("liveSearch");
    const resultBox = document.getElementById("searchResults");

    searchInput.addEventListener("input", function () {
        const query = this.value.trim();

        // Clear results if query is empty
        if (query.length < 1) {
            resultBox.innerHTML = "";
            return;
        }

        // Fetch results from the server
        fetch("live_search.php?query=" + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    resultBox.innerHTML = "<div class='result-item'>No results found</div>";
                    return;
                }

                // Display search results with image
                resultBox.innerHTML = data.map(product => `
                    <div class="result-item" onclick="window.location.href='product.php?product_id=${product.id}'">
                        <img src="${product.image}" alt="${product.title}" class="result-image" onerror="this.src='../Pharma-main/images/default-product.png'">
                        <div class="result-details">
                            <strong>${product.title}</strong><br>
                            <small>₱${product.price}</small>
                        </div>
                    </div>
                `).join('');
            })
            .catch(err => {
                console.error("Search error:", err);
                resultBox.innerHTML = "<div class='result-item'>Error loading results</div>";
            });
    });

    // Optional: hide results when clicking outside
    document.addEventListener("click", function (e) {
        if (!searchInput.contains(e.target) && !resultBox.contains(e.target)) {
            resultBox.innerHTML = "";
        }
    });
});
</script>

</body>
</html>