<?php
session_start();
if (!empty($_SESSION['flash'])) {
  $msg = $_SESSION['flash'];
  unset($_SESSION['flash']);
  echo '<script> alert(' . json_encode($msg) . '); </script>';
}
if (!isset($_SESSION['password']) && !isset($_SESSION['email'])) {
  header('Location:login.php');
  exit;
}
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$id = $_SESSION['id'];
if (isset($_POST['logout'])) {
  $_SESSION = [];
  session_destroy();
  header('Location:Login.php');
  exit;
}
if (isset($_GET['id'])) {
  $productId = (int) $_GET['id'];
  include 'connection.php';
  $sql = "select name,price from crud where id='$productId'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $productName = $row['name'];
  $productPrice = $row['price'];
  $sql = "INSERT INTO cart (productid,productname,productprice,userid,quantity)
VALUES ('$productId','$productName','$productPrice','$id','1')
ON DUPLICATE KEY UPDATE quantity = quantity + 1";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $_SESSION['flash'] = 'Added to Cart Successfully!';
    header('Location: home.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    .card-img-top {
      width: 100%;
      height: 200px;
      object-fit: contain;
      display: block;
    }

    @media (min-width: 992px) {
      .card-img-top {
        height: 250px;
      }
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="home.php" style="font-family:cursive;">TechHive</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
          <li class="nav-item">
            <a class="nav-link " href="smartphones.php">Smartphones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="laptops.php">Laptops</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="headphones.php">Headphones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="gaming.php">Gaming</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="accessories.php">Accessories</a>
          </li>

        </ul>
        <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="cart.php">Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <form method="post" class="m-0">
              <button type="submit" name="logout" class="btn btn-link nav-link" style="padding: 6;">Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container my-3">
    <form class="d-flex justify-content-center" method="post" action="search.php" role="search">
      <input class="form-control me-2" type="search" name="search" placeholder="Search products..." style="max-width:600px;">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
  <?php
  include 'connection.php';
  $sql = "SELECT id, name, price, image, category FROM crud ORDER BY id DESC";
  $res = mysqli_query($conn, $sql);
  ?>
  <div class="container my-5">
    <div class="row g-4">
      <?php if ($res && mysqli_num_rows($res) > 0): ?>
        <?php while ($p = mysqli_fetch_assoc($res)): ?>
          <?php $img = $p['image']; ?>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
              <img src="<?php echo $img ?>" class="card-img-top">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?php echo $p['name'] ?></h5>
                <p class="card-text mb-1"><?php echo $p['category']; ?></p>
                <p class="card-text fw-bold">Tk.<?php echo $p['price']; ?></p>
                <a href="home.php?id=<?php echo (int)$p['id']; ?>" class="btn btn-outline-dark mt-auto">Add to Cart</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12">
          <p class="text-center">No products found.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <footer class="mt-5 bg-light text-muted">
    <div class="container py-4">
      <div class="row">
        <div class="col-md-6">
          <h6 class="text-dark mb-1">TechHive</h6>
          <p class="small mb-0">A simple PHP/MySQL e‑commerce prototype. &copy; <?php echo date('Y'); ?> TechHive.</p>
        </div>
        <div class="col-md-3">
          <h6 class="text-dark mb-1">Quick Links</h6>
          <ul class="list-unstyled small mb-0">
            <li><a href="home.php" class="text-muted">Home</a></li>
            <li><a href="profile.php" class="text-muted">Profile</a></li>
            <li><a href="cart.php" class="text-muted">Cart</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6 class="text-dark mb-1">Contact</h6>
          <p class="small mb-0">support@techhive.example</p>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>