<?php

@include 'config.php';
if(isset($_POST['add_to_wishlist'])){
   $product_Name=$_POST['product_name'];
   $product_Price=$_POST['product_price'];
   $product_Image=$_POST['product_image'];
   $product_Quantity=1;
   
   $select_wishlist= mysqli_query($conn,"SELECT * from wishlist WHERE name = '$product_Name'");
   if(mysqli_num_rows($select_wishlist)>5){
      $message []= "Product already added to wishlist";
   }
   else{
      $insert_products=mysqli_query($conn,"INSERT into wishlist(name,price, image, quantity) VALUES ('$product_Name','$product_Price','$product_Image','$product_Quantity')");
      $message[]="Product added to wishlist";
   }
}
if(isset($_POST['add_to_cart'])){
   $product_Name=$_POST['product_name'];
   $product_Price=$_POST['product_price'];
   $product_Image=$_POST['product_image'];
   $product_Quantity=1;
   
   $select_cart= mysqli_query($conn,"SELECT * from cart WHERE name = '$product_Name'");
   if(mysqli_num_rows($select_cart)>2){
      $message []= "Product already added to cart";
   }
   else{
      $insert_products=mysqli_query($conn,"INSERT into cart(name,price, image, quantity) VALUES ('$product_Name','$product_Price','$product_Image','$product_Quantity')");
      $message[]="Product added to cart";
   }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>
<body>
<div style="text-align: right; margin: 20px;">
<a href="http://localhost/Ecommerce" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: green; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Add product</a>
      <a href="http://localhost/Ecommerce/wishlist.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #f8b400; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Wishlist</a>
      <a href="http://localhost/Ecommerce/cart.php" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">Cart</a>
   </div>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.
      '</span> <i class="fas fa-times" 
      onclick="this.parentElement.style.display = none;"></i> </div>';
   };
};
?>

<div class="container">
<section class="products">
   <h1 class="heading">latest products</h1>
   <div class="box-container">
      <?php
         $select_products= mysqli_query($conn,"SELECT * from products");
         if(mysqli_num_rows($select_products)>0){
            while($fetch_product=mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="post">
         <div class="box">
            <img src="<?php echo UPLOAD_DIR,$fetch_product['image'];?>" alt="">
            <h3><?php echo $fetch_product['name']; ?></h3>
            <div class="price">Rs.<?php echo $fetch_product['price']; ?>/-</div>
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
            <input type="submit" class="btn" value="add to wishlist" name="add_to_wishlist"style=" background-color: #f8b400;">
         </div>
      </form>
      <?php
         };
      };
      ?>
   </div>
</section>
</div>