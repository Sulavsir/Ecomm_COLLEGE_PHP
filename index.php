<?php
include 'config.php';
if(isset($_POST['submit'])){
    $error = array();

    $product_Name = isset($_POST['name'])? $_POST['name']:'';
    $product_Price = isset($_POST['price'])? $_POST['price']:'';

    if(empty($product_Name)){
        $error[] = 'Please enter product name';
    }

    if(empty($product_Price)){
        $error[] = 'Please enter product price';
    }

    if(!is_dir(UPLOAD_DIR)){
        mkdir(UPLOAD_DIR,0777,true);
    }

    $file_name = $_FILES['file']['name'];
    $file_tmp=$_FILES['file']['tmp_name'];
    $tmp = explode(".",$file_name);
    $file_ext = end($tmp);

    if(empty($error)){
        $insert_product = mysqli_query($conn,"INSERT INTO products(name,price,image) VALUES('$product_Name','$product_Price','$file_name')");
        if($insert_product==1){
            move_uploaded_file($file_tmp,UPLOAD_DIR.$file_name);
            $message[] = 'Product added successfully';
        }else{
            $message[] = 'Error adding product';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta charset="UTF-8" />
    <title>Save product details</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style type="text/css">
        body {
            padding: 30px;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .form-container {
            margin: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-width: 500px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-container .messages {
            margin-bottom: 15px;
            color: #d32f2f;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="file"] {
            display: block;
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container label {
            display: inline-block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-container button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #8daf15;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #7c9914;
        }

        .form-container .link-to-product-details {
            margin-top: 20px;
            display: inline-block;
        }

        .message {
            background-color: #e0f7fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .message span {
            color: #00796b;
        }
    </style>
</head>
<body>
    <?php
      if(isset($message)){
        echo '<div class="message">';
        foreach ($message as $msg) {
            echo '<span>' . $msg . '</span>';
        }
        echo '</div>';
    }
    ?>
    
    <div class="form-container">
        <h1 style=>&nbsp;&nbsp; *******My Ecommerce*******</h1><br/>
        <h2>Add a product</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo isset($product_Name) ? $product_Name : ''; ?>">

            <label for="price">Price</label>
            <input type="number" id="price" name="price" min="0" value="<?php echo isset($product_Price) ? $product_Price : ''; ?>">

            <label for="file">Image</label>
            <input type="file" id="file" name="file">

            <button type="submit" id="submit" name="submit">Submit</button>
        </form>
        <div class="link-to-product-details">
            <a href="http://localhost/Ecommerce/display.php" style="color: blue; text-decoration: none;">View Product</a>
        </div>
    </div>
</body>
</html>
