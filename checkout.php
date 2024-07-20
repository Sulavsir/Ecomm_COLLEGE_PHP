<?php
session_start();
@include 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $house_no = $_POST['house_no'];
   $city = $_POST['city'];
   $street = $_POST['street'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];
   $grand_total = isset($_SESSION['grand_total']) ? $_SESSION['grand_total'] : 0;
   $delivery_charge = 100;
   $total_amount = $grand_total + $delivery_charge;

   if ($method === 'esewa') {
      header("Location: esewa.php?total=$total_amount");
      exit();
   } elseif ($method === 'cash on delivery') {
      $message = "Your order has been successfully placed! The total amount is Rs. $total_amount, including a delivery charge of Rs. $delivery_charge.";
   } else {
      echo "<script>alert('Order placement failed, please try again.');</script>";
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<section class="checkout-form">
   <h1 class="heading">complete your order</h1>
   <form action="" method="post">
      <div class="display-order">
         <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM cart");
         $grand_total = 0;
         if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
               $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
               $grand_total += $sub_total;
            }
         }
         $_SESSION['grand_total'] = $grand_total;
         ?>
         <span class="grand-total"> grand total : Rs.<?= $grand_total; ?>/- </span>
      </div>
      <div class="flex">
         <div class="inputBox">
            <span>your name</span>
            <input type="text" placeholder="Name" name="name" required>
         </div>
         <div class="inputBox">
            <span>your number</span>
            <input type="number" placeholder="Phone Number" name="number" required>
         </div>
         <div class="inputBox">
            <span>your email</span>
            <input type="email" placeholder="Email" name="email" required>
         </div>
         <div class="inputBox">
            <span>payment method</span>
            <select name="method">
               <option value="cash on delivery" selected>cash on delivery</option>
               <option value="esewa">esewa</option>
            </select>
         </div>
         <div class="inputBox">
            <span>House Number</span>
            <input type="text" placeholder="" name="house_no" required>
         </div>
         <div class="inputBox">
            <span>City</span>
            <input type="text" placeholder="" name="city" required>
         </div>
         <div class="inputBox">
            <span>Street</span>
            <input type="text" placeholder="" name="street" required>
         </div>
         <div class="inputBox">
            <span>State</span>
            <input type="text" placeholder="" name="state" required>
         </div>
         <div class="inputBox">
            <span>country</span>
            <input type="text" placeholder="" name="country" required>
         </div>
         <div class="inputBox">
            <span>pin code</span>
            <input type="text" placeholder="" name="pin_code" required>
         </div>
      </div>
      <input type="submit" value="order now" name="order_btn" class="btn">
   </form>
</section>
</div>
<script src="script.js"></script>
<?php
if (!empty($message)) {
   echo "<script>alert('$message');</script>";
}
?>
</body>
</html>
