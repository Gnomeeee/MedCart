<?php
include "includes/head1.php";
include_once "includes/functions.php";
?>

<body>
    <?php
    include "includes/header.php"
    ?>


    <?php
    include "includes/sidebar1.php";
    ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-3 mt-4">
        <?php
        ?>
        <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col-12 col-md-6">
                <h2>Products Details</h2>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <form class="d-flex" method="GET" action="products1.php">
                    <input class="form-control me-2" type="search" name="search_item_name" placeholder="Search for product" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit" name="search_item" value="search">Search</button>
                </form>
            </div>
        </div>
    </div>
        <?php 
message();

if (isset($_GET['edit'])) {
    $item_id = intval($_GET['edit']);
    $_SESSION['id'] = $item_id;
    $data = staff_get_item_details($item_id); // returns single item row
}

if (isset($_SESSION['id'])) {
    staff_edit_item($_SESSION['id']);
}

if (!empty($data)) {
?>
    <br>
    <h2>Edit Product Details</h2>
    <form action="products1.php" method="POST">
        <div class="form-group mb-2">
            <label>Product name</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['item_title']); ?>" name="name" required>
            <div class="form-text">Please enter the product name (1–25 characters). Special characters not allowed.</div>
        </div>

        <div class="form-group">
            <label>Brand name</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['item_brand']); ?>" name="brand" required>
            <div class="form-text">Please enter the brand name (1–25 characters). Special characters not allowed.</div>
        </div>

        <div class="input-group mb-3 form-group">
            <label class="input-group-text" for="inputGroupSelect01">Category</label>
            <select name="cat" class="form-select" id="inputGroupSelect01" required>
               <option selected>Choose...</option>
                <option value="Medicine/Treatments" <?php if ($data['item_cat'] == 'Medicine/Treatments') echo 'selected'; ?>>Medicine/Treatments</option>
                <option value="Personal Care" <?php if ($data['item_cat'] == 'Personal Care') echo 'selected'; ?>>Personal Care</option>
                <option value="Baby & Kid Care" <?php if ($data['item_cat'] == 'Baby & Kid Care') echo 'selected'; ?>>Baby & Kid Care</option>
            </select>
        </div>

        <div class="form-group">
            <label>Product tags</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['item_tags']); ?>" name="tags" required>
            <div class="form-text">Enter tags (1–250 characters). Use only allowed characters.</div>
        </div>

        <div class="form-group">
            <label>Product image (URL)</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['item_image']); ?>" name="item_image" required>
            <div class="form-text">Enter the image filename or path.</div>
        </div>

        <div class="form-group">
            <label>Product quantity</label>
            <input type="number" class="form-control" value="<?php echo htmlspecialchars($data['item_quantity']); ?>" name="quantity" min="1" max="10000" required>
            <div class="form-text">Enter quantity (1–10000).</div>
        </div>

        <div class="input-group mb-3 form-group">
            <span class="input-group-text">&#8369;</span>
            <input pattern="[0-9.]+" type="text" class="form-control" value="<?php echo htmlspecialchars($data['item_price']); ?>" name="price" required>
            <span class="input-group-text">PHP</span>
        </div>
        <div class="form-text">Enter product price (numbers only).</div>

        <div class="form-group">
            <label>Product details</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['item_details']); ?>" name="details" required>
            <div class="form-text">Enter a description of the product.</div>
        </div>  

        <br>
        <button type="submit" class="btn btn-outline-primary" value="update" name="update">Update</button>
        <button type="submit" class="btn btn-outline-danger" value="cancel" name="cancel">Cancel</button>
        <br><br>
    </form>
<?php
}
?>


        <?php
        staff_add_item();
        if (isset($_GET['add'])) {
        ?>
            <br>
            <h2>Add Product</h2>
            <form action="products1.php" method="POST">
                <div class=" form-group mb-3">
                    <label>Product name</label>
                    <input id="exampleInputText1" type="text" class="form-control" placeholder="product name" name="name">
                    <div class="form-text">please enter the product name in range(1-25) character/s , special character not allowed !</div>
                </div>
                <div class="form-group">
                    <label>Brand name</label>
                    <input id="validationTooltip01" type="text" class="form-control" placeholder="product brand" name="brand">
                    <div class="form-text">please enter the brand name in range(1-25) character/s , special character not allowed !</div>
                </div>
                <div class="input-group mb-3 form-group">
                    <label class="input-group-text" for="inputGroupSelect01">category</label>
                    <select name="cat" class="form-select" id="inputGroupSelect01">
                        <option value="" selected>Choose...</option>
                        <option value="Medicine/Treatments">Medicine/Treatments</option>
                        <option value="Personal Care">Personal Care</option>
                        <option value="Baby & Kid Care">Baby & Kid Care</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Product tags</label>
                    <input id="validationTooltip01" type="text" class="form-control" placeholder="product tags" name="tags">
                    <div class="form-text">please enter tags for the product in range(1-250) character/s , special character not allowed !</div>
                </div>
                <div class="form-group">
                    <label>Product image</label>
                    <input type="file" accept="image/*" class="form-control" placeholder="image" name="image">
                    <div class="form-text">please enter image for the product .</div>
                </div>
                <div class="form-group">
                    <label>Product quantity</label>
                    <input type="number" class="form-control" placeholder="product quantity" name="quantity" min="1" max="999">
                    <div class="form-text">please enter the quantity of the product in range(1-999) .</div>
                </div>
                <div class="input-group mb-3 form-group">
                    <span class="input-group-text">&#8369;</span>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" placeholder="product price">
                    <span class="input-group-text"></span>
                </div>
                <div class="form-text">please enter the price of the product .</div>
                <div class="form-group">
                    <label for="inputAddress2">Product details</label>
                    <input type="text" class="form-control" placeholder="product details" name="details">
                </div>
                <div class="form-text">please enter the product details .</div>
                <br>
                <button type="submit" class="btn btn-outline-primary" value="update" name="add_item">Submit</button>
                <button type=" submit" class="btn btn-outline-danger" value="cancel" name="cancel">Cancel</button>
                <br> <br>
            </form>
            <?php
}
?>
<div class="table-responsive">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Product List</h4>
        <a href="products1.php?add=1" class="btn btn-primary">+ Add Product</a>
    </div>
    <table class="table table-hover table-bordered align-middle text-center shadow-sm">
        <thead class="table" style="background-color:rgb(165, 210, 255);">  
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Tags</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price (₱)</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php
    staff_delete_item(); // Delete item if requested

    // Default: fetch all items
    $data = staff_all_items();

    // If a search was submitted, get search results
    if (isset($_GET['search_item'])) {
        $query = staff_search_item();
        if (!empty($query)) {
            $data = $query;
        } else {
            get_redirect("products1.php"); // Redirect if no results
        }
    }

    // If an individual item is requested (e.g., for edit view), fetch just that one
    if (isset($_GET['edit'])) {
        $item_id = intval($_GET['edit']); // Make sure it's a number
        $single_item = staff_get_item_details($item_id);
        $data = $single_item ? [$single_item] : [];
    }

    // Display the table rows if data exists
    if (!empty($data)) {
        foreach ($data as $index => $item) {
?>
            <tr>
                <td><?= $index + 1; ?></td>
                <td><?= $item['item_id']; ?></td>
                <td><?= htmlspecialchars($item['item_title']); ?></td>
                <td><?= htmlspecialchars($item['item_brand']); ?></td>
                <td><?= htmlspecialchars($item['item_cat']); ?></td>
                <td><?= htmlspecialchars($item['item_tags']); ?></td>
                <td>
                    <?php if (!empty($item['item_image'])): ?>
                        <img src="<?= $item['item_image']; ?>" alt="Product" width="50" height="50" class="rounded">
                    <?php else: ?>
                        <span class="text-muted">No Image</span>
                    <?php endif; ?>
                </td>
                <td><?= $item['item_quantity']; ?></td>
                <td>₱<?= number_format($item['item_price'], 2); ?></td>
                <td><?= htmlspecialchars($item['item_details']); ?></td>
                <td>
                    <a href="products1.php?edit=<?= $item['item_id']; ?>" class="btn btn-warning btn-sm">Edit</a><br>
                    <a href="products1.php?delete=<?= $item['item_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </td>
            </tr>
<?php
        }
    }
?>

        </tbody>
    </table>
</div>
     <?php       
    include "includes/footer1.php"
    ?>
</body>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>