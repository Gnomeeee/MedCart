<?php include "includes/head1.php"; ?>

<body>

  <?php include "includes/header.php"; ?>

  <div class="container-fluid">

    <?php include "includes/sidebar2.php"; ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <br>
      <div class="d-flex justify-content-center flex-wrap">
        <div class="card m-4" style="width: 25rem;">
          <a href="rider-dashboard.php">
            <img class="card-img-top mx-auto d-block" src="../images/house.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Dashboard</h5>
            <a href="rider-dashboard.php" class="btn btn-primary">Go to Dashboard page</a>
          </div>
        </div>
        <div class="card m-4" style="width: 25rem;">
          <a href="rider-orders.php">
            <img class="card-img-top mx-auto d-block" src="../images/shopping-cart.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Assigned Orders</h5>
            <a href="rider-orders.php" class="btn btn-primary">Go to Assigned Orders page</a>
          </div>
        </div>
        <div class="card m-4" style="width: 25rem;">
          <a href="#">
            <img class="card-img-top mx-auto d-block" src="../images/star.svg" alt="Card image cap" style="width: 5rem; margin-top: 20px;">
          </a>
          <div class="card-body text-center">
            <h5 class="card-title">Reviews</h5>
            <a href="view_rider_reviews.php" class="btn btn-primary">Go to Reviews page</a>
          </div>
        </div>
      </div>
    </main>
  </div>

  <?php include "includes/footer.php"; ?>
</body>

</html>
