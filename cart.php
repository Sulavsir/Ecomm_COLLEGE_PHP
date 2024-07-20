<?php
@include 'config.php';
if(isset($_POST['update_update_btn']))
{
   $update_value= $_POST['update_quantity'];
   $update_id=$_POST['update_quantity_id'];
   $update_query = mysqli_query($conn,"UPDATE cart SET quantity='$update_value' WHERE id='$update_id'");
   if($update_query){
      header('location:cart.php');
   }
}
if(isset($_GET['remove']))
{
   $remove_id= $_GET['remove'];
   mysqli_query($conn,"DELETE from cart WHERE id='$remove_id'");
   header('location:cart.php');
}

if(isset($_GET['delete_all']))
{
    mysqli_query($conn,"DELETE from cart");
    header('location:cart.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<div style="text-align: right; margin: 20px;">
   <a href="http://localhost/Ecommerce" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: green; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Add product</a>
   <a href="http://localhost/Ecommerce/wishlist.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Wishlist</a>
</div>
<section class="shopping-cart">
   <h1 class="heading">shopping cart</h1>
   <table>
      <thead>
         <th>image</th>
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th>action</th>
      </thead>
      <tbody>
       <?php
         $select_cart = mysqli_query($conn,"SELECT * from cart");
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0) {
            while($fetch_cart = mysqli_fetch_assoc($select_cart)) {
               $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
               $grand_total += $sub_total;
       ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td>Rs.<?php echo number_format($fetch_cart['price']); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>" >
                  <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>" >
                  <input type="submit" value="update" name="update_update_btn">
               </form>   
            </td>
            <td>Rs.<?php echo number_format($sub_total); ?>/-</td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
         </tr>
         <?php
            }
         }
         ?>
         <tr class="table-bottom">
            <td><a href="display.php" class="option-btn" style="margin-top: 0; background-color: red;">continue shopping</a></td>
            <td colspan="3">grand total</td>
            <td>Rs.<?php echo number_format($grand_total); ?>/-</td>
            <td><a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>
      </tbody>
   </table>
   <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed to checkout</a>
   </div>
</section>
</div>
<script src="script.js"></script>
</body>
</html>
