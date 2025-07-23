<?php
  session_start();
  include 'dataBase.php';
  $products = $conn->query("SELECT * FROM tbl_products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add to Cart Task</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
  <div class="row">
    <!-- Products List -->
    <div class="col-lg-7 mb-4">
      <h4 class="mb-4">Products List</h4>
      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
          <thead class="text-start">
            <tr>
              <th scope="col">Image</th>
              <th scope="col">Name</th>
              <th scope="col">Price</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $products->fetch_assoc()): ?>
            <tr>
              <td class="text-start">
                <img src="assets/images/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_image']; ?>" class="img-fluid" width="60" height="72">
              </td>
              <td class="text-start">
                <?php echo $row['product_name']; ?>
              </td>
              <td class="text-start">
                Rs. <?php echo $row['product_price']; ?>
              </td>
              <td class="text-start">
                <form method="POST" action="addToCart.php">
                  <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" class="btn btn-warning">Add To Cart</button>
                </form>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Shopping Cart -->
    <div class="col-lg-5">
      <h3 class="mb-4">Shopping Cart</h3>
      <div class="card">
        <div class="card-body p-4">
          <div id="cart_list">
            <?php
            if(!empty($_SESSION['cart'])) {
              $total = 0;
              foreach ($_SESSION['cart'] as $item) {
              $subtotal = $item['quantity'] * $item['product_price'];
              $total += $subtotal;
            ?>
              <div class="card mb-3">
                <div class="card-body">
                  <div class="d-flex flex-column flex-lg-row">
                    <div class="d-flex col-lg-8 flex-row align-items-center">
                      <div class="col-3 col-lg-3">
                        <img src="assets/images/<?php echo $item['product_image']; ?>" class="img-fluid rounded-3" alt="<?php echo $item['product_image']; ?>" width="40">
                      </div>
                      <div class="col-9 col-lg-9">
                        <h6><?php echo $item['product_name']; ?></h6>
                        <p class="small mb-0">Rs. <?php echo $item['product_price']; ?></p>
                      </div>
                    </div>
                    <div class="d-flex flex-row col-lg-4 align-items-center mt-2 mt-lg-0">
                      <div class="col-3 col-lg-2">
                        <h6 class="fw-normal mb-0"><?php echo $item['quantity']; ?></h6>
                      </div>
                      <div class="col-7 col-lg-8">
                        <h6 class="mb-0">Rs.<?php echo $subtotal; ?></h6>
                      </div>
                      <form method="POST" action="removeFromCart.php" class="col-2 col-lg-2">
                        <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                        <button type="submit" class="btn p-0 border-0 bg-transparent">
                          <img src="assets/images/delete.png" width="24" height="24" alt="delete-icon">
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
              <div class="d-flex justify-content-between">
                <div>
                  <h5>Grand Total</h5>
                </div>
                <div>
                  <h5>Rs. <?php echo $total; ?></h5>
                </div>
              </div>
            <?php }
            else {
              echo '<p class="text-muted">Your shopping cart is empty.</p>';
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
