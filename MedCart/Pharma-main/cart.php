<?php
include "includes/head.php"; 
// Call the delete function to handle item removal
delete_from_cart();
?>

<body>
  <div class="site-wrap">
    <?php include "includes/header.php"; ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Cart</strong>
          </div>
        </div>
      </div>
    </div>

    <?php if (!empty($_SESSION['cart'])): ?>
    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
        <form action="checkout.php" class="col-md-12" method="post">
          <div class="site-blocks-table">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Select</th>
                  <th class="product-thumbnail">Image</th>
                  <th class="product-name">Product</th>
                  <th class="product-price">Price</th>
                  <th class="product-quantity">Quantity</th>
                  <th class="product-total">Total</th>
                  <th class="product-remove">Remove</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $data = get_cart();
                $cart_total = 0; // initialize total
                foreach ($data as $i => $item) {
                  if (isset($item[0])) {
                    $total_item_price = $item[0]['item_price'] * $_SESSION['cart'][$i]['quantity'];
                    $cart_total += $total_item_price; // add to total
                ?>
                <tr>
                  <td class="text-center align-middle">
                    <input type="checkbox" name="selected_items[]" value="<?php echo $item[0]['item_id']; ?>" />
                  </td>
                  <td class="product-thumbnail">
                    <img src="images/<?php echo $item[0]['item_image']; ?>" alt="Image" class="img-fluid">
                  </td>
                  <td class="product-name">
                    <h2 class="h5 text-black"><?php echo $item[0]['item_title']; ?></h2>
                  </td>
                  <td>&#8369;<?php echo $item[0]['item_price']; ?></td>
                  <td><?php echo $_SESSION['cart'][$i]['quantity']; ?></td>
                  <td>&#8369;<?php echo $total_item_price; ?></td>
                  <td><a href="cart.php?delete=<?php echo $item[0]['item_id']; ?>" class="btn btn-primary height-auto btn-sm">delete</a></td>
                </tr>
                <?php }} ?>
              </tbody>
            </table>
          </div>
          <div class="row justify-content-center mt-3">
            <div class="col-md-6">
              <button type="submit" class="btn btn-primary btn-lg btn-block">Proceed To Checkout</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php else: ?>
  <h1 style="text-align: center; color:black;">Your Cart is empty</h1>
  <div class="text-center my-4">
    <img src="images/nocart.png" alt="Empty cart" class="img-fluid" style="max-width: 100%; height: auto;">
  </div>
  <?php endif; ?>

  <?php include "includes/footer.php"; ?>
</div>
</body>
</html>
