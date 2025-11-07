
<?php
include "includes/head.php";
?>

<body>
  <div class="site-wrap">
    <?php
    include "includes/header.php";

    if (!isset($_SESSION['user_id'])) {
      echo "<p style='color:red'>Error: User not logged in.</p>";
      exit;
    }

    $user_data = get_user($_SESSION['user_id']);
    if (!empty($user_data)) {
      $user = $user_data[0];
    } else {
      echo "<p style='color:red'>Error: User not found.</p>";
      exit;
    }

    $selected_ids = $_POST['selected_items'] ?? [];

    if (empty($selected_ids)) {
        echo "<p style='color:red'>Error: No products selected for checkout.</p>";
        exit;
    }

    $data_cart = [];
    if (!empty($_SESSION['cart'])) {
        $full_cart = get_cart();
        foreach ($full_cart as $i => $item) {
            $item_id = $item[0]['item_id'];
            if (in_array($item_id, $selected_ids)) {
                $data_cart[] = $item;
            }
        }
    } else {
        echo "<p style='color:red'>Error: Cart is empty or no valid items.</p>";
        exit;
    }
    ?>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Checkout</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="row mb-6">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Delivery Details</h2>
                <div class="p-3 p-lg-7 border">
                  <table class="table site-block-order-table mb-5">
                    <thead>
                      <th class="col-md-7">Customer Details</th>
                    </thead>
                    <tbody>
                      <tr><td>First Name</td><td><?php echo $user['user_fname']; ?></td></tr>
                      <tr><td>Last Name</td><td><?php echo $user['user_lname']; ?></td></tr>
                      <tr><td>Email</td><td><?php echo $user['email']; ?></td></tr>
                      <tr><td>Address</td><td><?php echo $user['user_address']; ?></td></tr>
                      <tr><td>Phone number</td><td><?php echo $user['phone_number']; ?></td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="row mb-6">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Your Order</h2>
                <div class="p-3 p-lg-7 border">
                  <form method="POST" action="thankyou.php">
                    <table class="table site-block-order-table mb-4">
                      <thead>
                        <th>Product</th>
                        <th>Total</th>
                      </thead>
                      <tbody>
                        <?php
                        $order_total = 0;
                        foreach ($data_cart as $i => $item) {
                          $item_id = $item[0]['item_id'];
                          $title = $item[0]['item_title'];
                          $price = $item[0]['item_price'];
                          $quantity = 0;

                          foreach ($_SESSION['cart'] as $cart_item) {
                            if ($cart_item['item_id'] == $item_id) {
                              $quantity = $cart_item['quantity'];
                              break;
                            }
                          }

                          $total = $price * $quantity;
                          $order_total += $total;

                          echo "<tr><td>$title <strong class='mx-2'>x</strong> $quantity</td><td>&#8369;$total</td></tr>";

                          echo "<input type='hidden' name='selected_items[]' value='$item_id'>";
                        }
                        ?>
                        <tr>
                          <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                          <td class="text-black">&#8369;<?php echo $order_total; ?></td>
                        </tr>
                        <tr>
                          <td class="text-black font-weight-bold"><strong>Delivery Fees</strong></td>
                          <td class="text-black">&#8369;<?php echo delivery_fees($data_cart); ?></td>
                        </tr>
                        <tr>
                          <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                          <td class="text-black font-weight-bold">
                            <strong>&#8369;<?php echo $order_total + delivery_fees($data_cart); ?></strong>
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <div class="form-group">
                      <button type="submit" name="order" value="done" class="btn btn-primary btn-lg btn-block">Place Order</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <?php include "includes/footer.php"; ?>
  </div>
</body>
</html>