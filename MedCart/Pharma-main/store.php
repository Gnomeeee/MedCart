 <?php
include "includes/head.php"
?>

<style>
.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
  overflow: hidden;
  border: 1px solid rgb(167, 170, 169);
}

.card:hover {
  transform: translateY(-10px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 1);
}

.card-img-container {
  overflow: hidden;
}

.card-img-top {
  transition: transform 0.4s ease;
}

.card:hover .card-img-top {
  transform: scale(1.1); /* image zooms in */
}

</style>

<body>

  <div class="site-wrap">

<?php include "includes/header.php" ?>

<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Store</strong>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">

    <?php
    $data = search($conn);
    if ($data != "no result" && !empty($data)) {
      $num = sizeof($data);
      echo '<div class="row">';
      for ($i = 0; $i < $num; $i++) {
    ?>
        <div class="col-sm-6 col-lg-4 mb-4 d-flex align-items-stretch">   
          <div class="card w-100 shadow-sm">
            <a href="product.php?product_id=<?php echo $data[$i]['item_id'] ?>">
              <img class="card-img-top img-fluid" style="height:300px; object-fit:contain;" src="images/<?php echo $data[$i]['item_image'] ?>" alt="Image">
            </a>
            <div class="card-body text-center">
              <h5 class="card-title mb-2">
                <a class="text-dark text-decoration-none" href="product.php?product_id=<?php echo $data[$i]['item_id'] ?>">
                  <?php echo (strlen($data[$i]['item_title']) <= 20) ? $data[$i]['item_title'] : substr($data[$i]['item_title'], 0, 20) . "..." ?>
                </a>
              </h5>
              <p class="card-text fw-bold">&#8369;<?php echo $data[$i]['item_price'] ?></p>
            </div>
          </div>
        </div>
    <?php
      }
      echo '</div>'; // close row

      unset($data);
      if ($num < 8) {
        $data = all_products();
        $num = sizeof($data);
    ?>
        <div class="title-section text-center col-12">
          <h1 class="text-uppercase">Products You Might Like</h1>
          <br><br>
        </div>
        <div class="row">
          <?php
          for ($i = 0; $i < $num && $i < 3; $i++) {
          ?>
            <div class="col-sm-6 col-lg-4 mb-4 d-flex align-items-stretch">
              <div class="card w-100 shadow-sm">
                <a href="product.php?product_id=<?php echo $data[$i]['item_id'] ?>">  
                  <img class="card-img-top img-fluid" style="height:300px; object-fit:contain;" src="images/<?php echo $data[$i]['item_image'] ?>" alt="Image">
                </a>
                <div class="card-body text-center">
                  <h5 class="card-title mb-2">
                    <a class="text-dark text-decoration-none" href="product.php?product_id=<?php echo $data[$i]['item_id'] ?>">
                      <?php echo (strlen($data[$i]['item_title']) <= 20) ? $data[$i]['item_title'] : substr($data[$i]['item_title'], 0, 20) . "..." ?>
                    </a>
                  </h5>
                  <p class="card-text fw-bold">&#8369;<?php echo $data[$i]['item_price'] ?></p>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
    <?php
      }
    } elseif (empty($data)) {
      $data = all_products();
      $num = sizeof($data);
      echo '<div class="row">';
      for ($i = 0; $i < $num && $i < 12; $i++) {
    ?>
        <div class="col-sm-6 col-lg-4 mb-4 d-flex align-items-stretch">
          <div class="card w-100 shadow-sm">
            <a href="product.php?product_id=<?php echo $data[$i]['item_id'] ?>">
              <img class="card-img-top img-fluid" style="height:300px; object-fit:contain;" src="images/<?php echo $data[$i]['item_image'] ?>" alt="Image">
            </a>
            <div class="card-body text-center">
              <h5 class="card-title mb-2">
                <a class="text-dark text-decoration-none" href="product.php?product_id=<?php echo $data[$i]['item_id'] ?>">
                  <?php echo (strlen($data[$i]['item_title']) <= 20) ? $data[$i]['item_title'] : substr($data[$i]['item_title'], 0, 20) . "..." ?>
                </a>
              </h5>
              <p class="card-text fw-bold">&#8369;<?php echo $data[$i]['item_price'] ?></p>
            </div>
          </div>
        </div>
    <?php
      }
      echo '</div>'; // close row
    } else {
    ?>
      <div class="text-center col-12">
        <img class="img-fluid" style="margin-top:-90px;" src="images/1.gif">
      </div>
    <?php
    }
    ?>

  </div>
</div>

<?php include "includes/footer.php" ?>

  </div>
</body>

</html>