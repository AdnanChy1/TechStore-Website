<?php
session_start();
include 'connection.php';

// require login
$userId = $_SESSION['id'] ?? null;
if (!$userId) {
    header('Location: login.php');
    exit;
}

// handle post actions: increase, decrease, remove, order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'order') {
        // simple order behavior: clear cart for this user and set flash
        $stmt = $conn->prepare("DELETE FROM cart WHERE userid = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->close();

        $_SESSION['flash'] = 'Order placed successfully!';
        header('Location: cart.php');
        exit;
    }

    $productId = isset($_POST['productid']) ? (int)$_POST['productid'] : 0;
    if ($productId > 0) {
        if ($action === 'increase') {
            $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE userid = ? AND productid = ?");
            $stmt->bind_param('ii', $userId, $productId);
            $stmt->execute();
            $stmt->close();
        } elseif ($action === 'decrease') {
            // decrease or remove if reaches 0/1
            // check current quantity
            $stmt = $conn->prepare("SELECT quantity FROM cart WHERE userid = ? AND productid = ? LIMIT 1");
            $stmt->bind_param('ii', $userId, $productId);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $stmt->close();

            if ($row) {
                $qty = (int)$row['quantity'];
                if ($qty > 1) {
                    $stmt = $conn->prepare("UPDATE cart SET quantity = quantity - 1 WHERE userid = ? AND productid = ?");
                    $stmt->bind_param('ii', $userId, $productId);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $stmt = $conn->prepare("DELETE FROM cart WHERE userid = ? AND productid = ?");
                    $stmt->bind_param('ii', $userId, $productId);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        } elseif ($action === 'remove') {
            $stmt = $conn->prepare("DELETE FROM cart WHERE userid = ? AND productid = ?");
            $stmt->bind_param('ii', $userId, $productId);
            $stmt->execute();
            $stmt->close();
        }
    }

    // redirect to avoid resubmission
    header('Location: cart.php');
    exit;
}

// show flash if present
$flash = '';
if (!empty($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

// fetch cart items for user
$stmt = $conn->prepare("SELECT productid, productname, productprice, quantity FROM cart WHERE userid = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// compute totals
$grandTotal = 0.0;
foreach ($items as $it) {
    $grandTotal += ((float)$it['productprice']) * ((int)$it['quantity']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container my-4">
    <?php if ($flash): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($flash, ENT_QUOTES); ?></div>
    <?php endif; ?>

    <h3 class="mb-3">Your Cart</h3>

    <?php if (empty($items)): ?>
      <p>Your cart is empty. <a href="home.php">Continue shopping</a></p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Product</th>
              <th class="text-end">Price</th>
              <th class="text-center">Quantity</th>
              <th class="text-end">Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $it): 
              $itemTotal = ((float)$it['productprice']) * ((int)$it['quantity']);
            ?>
              <tr>
                <td><?php echo htmlspecialchars($it['productname'], ENT_QUOTES); ?></td>
                <td class="text-end">Tk.<?php echo number_format((float)$it['productprice'], 2); ?></td>
                <td class="text-center">
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <form method="post" style="display:inline;">
                      <input type="hidden" name="productid" value="<?php echo (int)$it['productid']; ?>">
                      <input type="hidden" name="action" value="decrease">
                      <button type="submit" class="btn btn-sm btn-outline-secondary">-</button>
                    </form>

                    <span class="px-2"><?php echo (int)$it['quantity']; ?></span>

                    <form method="post" style="display:inline;">
                      <input type="hidden" name="productid" value="<?php echo (int)$it['productid']; ?>">
                      <input type="hidden" name="action" value="increase">
                      <button type="submit" class="btn btn-sm btn-outline-secondary">+</button>
                    </form>
                  </div>
                </td>
                <td class="text-end">Tk.<?php echo number_format($itemTotal, 2); ?></td>
                <td class="text-end">
                  <form method="post" style="display:inline;">
                    <input type="hidden" name="productid" value="<?php echo (int)$it['productid']; ?>">
                    <input type="hidden" name="action" value="remove">
                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="3" class="text-end fw-bold">Grand Total</td>
              <td class="text-end fw-bold">Tk.<?php echo number_format($grandTotal, 2); ?></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between">
        <a class="btn btn-secondary" href="home.php">Continue Shopping</a>

        <form method="post" onsubmit="return confirm('Place order for total Tk.<?php echo number_format($grandTotal,2); ?> ?');">
          <input type="hidden" name="action" value="order">
          <button type="submit" class="btn btn-primary">Order Now</button>
        </form>
      </div>
    <?php endif; ?>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>