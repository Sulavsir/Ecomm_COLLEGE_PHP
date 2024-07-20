<?php
@include 'config.php';
if (isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;
   $select_cart = mysqli_query($conn, "SELECT * FROM `wiishlist` WHERE name = '$product_name'");
   if (mysqli_num_rows($select_cart) > 0) {
      $message[] = 'Product already added to cart';
   } else {
      $insert_product = mysqli_query($conn, "INSERT INTO `wishlist`(name,price,image,quantity) VALUES('$product_name','$product_price','$product_image','$product_quantity')");
      $message[] = 'Product added to cart successfully';
   }
}
if(isset($_GET['remove'])){
   $remove_id= $_GET['remove'];
   mysqli_query($conn,"DELETE from wishlist WHERE id='$remove_id'");
   header('location:wishlist.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="
   style.css">
</head>

<body>
   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
      }
      ;
   }
   ;
   ?>
   <div class="container">
   <div style="text-align: right; margin: 20px;">
   <a href="http://localhost/Ecommerce" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: green; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Add product</a>
   <a href="http://localhost/Ecommerce/display.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #f8b400; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">All Products</a>
   <a href="http://localhost/Ecommerce/cart.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Cart</a>
</div>
      <section class="products">
         <h1 class="heading">wishlist</h1>
         <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM  wishlist");
            if (mysqli_num_rows($select_products) > 0) {
               while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                  ?>
                  <form action="" method="post">
                     <div class="box">
                        <img src="<?php echo UPLOAD_DIR,$fetch_product['image'];?>" alt="">
                        <h3>
                           <?php echo $fetch_product['name']; ?>
                        </h3>
                        <div class="price">Rs.
                           <?php echo $fetch_product['price']; ?>
                        </div>
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                        <td><a href="wishlist.php?remove=<?php echo $fetch_product['id']; ?>"
                              onclick="return confirm('remove item from cart?')" class="delete-btn"><i
                                 class="fas fa-trash"></i> remove</a></td>
                     </div>
                  </form>
                  <?php
               }
               ;
            }
            ;
            ?>
         </div>
      </section>

   </div>