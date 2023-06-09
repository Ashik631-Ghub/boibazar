<!-- connect files -->
<?php
include('includes/connect.php');
include('functions/common_function.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .cart_image {
            height: 100px;
            width: 50;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <!--Navbar-->
    <div class.container-fluid>
        <!-- First child-->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="./images/logo-no-background.png" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./users_area/user_registration.php">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"><sup>
                                        <?php cart_item(); ?>
                                    </sup></i></a>
                        </li>

                </div>
            </div>
        </nav>


    </div>
    <!-- Calling cart function -->
    <?php
    cart();
    ?>
    <!--Second child-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <ul class="navbar-nav me-auto">
        
            <?php
            
            if(!isset($_SESSION['username'])){
                echo "<li class='nav-item'>
                <a class='nav-link' href='#'>Welcome Guest</i></a>
            </li>";
            }else{
                echo"<li class='nav-item'>
                <a class='nav-link' href='#'> Welcome ".$_SESSION['username']."</a>
            </li>";

            }
             
            if(!isset($_SESSION['username'])){
                echo "<li class='nav-item'>
                <a class='nav-link' href='./users_area/user_login.php'>Login</i></a>
            </li>";
            }else{
                echo "<li class='nav-item'>
                <a class='nav-link' href='./users_area/logout.php'>Logout</i></a>
            </li>";
            }
            ?>
        </ul>
    </nav>
    <!--Third child-->
    <div class="bg-light">
        <h3 class="text-center">
            Cart Details
        </h3>
        <p class="text-center">
            “If you don’t like to read, you haven’t found the right book.” - J.K. Rowling
        </p>
    </div>


    <!-- Fourth child-->
    <div class="container">
        <div class="row">
            <form action="" method="post">
                <table class="table table-bordered text-center">
                    
                        <!-- Php code to display dynamic data -->
                        <?php

                        $total_price = 0;
                        $get_ip_add = getIPAddress();
                        $cart_query = "Select * from `cart_details` where ip_address= '$get_ip_add'";
                        $result = mysqli_query($con, $cart_query);
                        $result_count = mysqli_num_rows($result);
                        if($result_count>0){
                            echo"<thead>
                            <tr>
                                <th>Product Title </th>
                                <th>Product Image </th>
                                <th>Quantity </th>
                                <th>Total Price </th>
                                <th>Remove </th>
                                <th colspan='2'>Operation </th>
                            </tr>
                        </thead>";
                       
                        while ($row = mysqli_fetch_assoc($result)) {
                            $product_id = $row['product_id'];
                            $select_products = "Select * from `products` where product_id= $product_id";
                            $result_products = mysqli_query($con, $select_products);
                            while ($row_product_price = mysqli_fetch_array($result_products)) {
                                $product_price = array($row_product_price['product_price']);
                                $price_table = $row_product_price['product_price'];
                                $product_title = $row_product_price['product_title'];
                                $product_image1 = $row_product_price['product_image1'];
                                $product_values = array_sum($product_price);
                                $total_price += $product_values;




                        ?>

                                <tr>
                                    <td>
                                        <?php echo $product_title ?>
                                    </td>
                                    <td><img src="./admin_area/product_images/<?php echo $product_image1 ?>" class="cart_image py-1" alt=""></td>
                                    <td><input type="text" name="quantity" id="" class="form-input w-50"></td>

                                    <?php
                                    $get_ip_add = getIPAddress();
                                    if (isset($_POST['update_cart'])) {
                                        $quantities = $_POST['quantity'];
                                        $update_carts = "Update `cart_details` set quantity=$quantities where ip_address='$get_ip_add'";
                                        $result_products_quantity = mysqli_query($con, $update_carts);
                                        $total_price *= $quantities;
                                    }

                                    ?>
                                    <td>
                                        <?php echo $price_table ?> /-
                                    </td>
                                    <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id ?>"></td>
                                    <td>
                                        <!-- <button class="bg-info border px-3 m-3 p-3 py-2">Update</button>  -->
                                        <input type="submit" value="Update Cart" class="bg-info border px-3 m-3 p-3 py-2" name="update_cart">
                                        <!-- <button class="bg-info border px-3 m-3 p-3 py-2">Remove</button> -->
                                        <input type="submit" value="Remove " class="bg-secondary text-light border px-3 m-3 p-3 py-2" name="remove_cart">
                                    </td>

                                </tr>
                        <?php
                            }
                        }
                     }
                     else{
                        echo"<h2 class='text-danger text-center'> Cart is Empty</h2>";
                     }
                        ?>

                    </tbody>

                </table>
                <div class="d-flex m-5  ">
                    <?php 
                     $total_price = 0;
                     $get_ip_add = getIPAddress();
                     $cart_query = "Select * from `cart_details` where ip_address= '$get_ip_add'";
                     $result = mysqli_query($con, $cart_query);
                     $result_count = mysqli_num_rows($result);
                     if($result_count>0){
                     echo "<h4 class='px-3'> <strong class='text-info'>
                     <?php echo $total_price ?>
                 </strong></h4>
             <a href='index.php'><button class='bg-info border px-3 mx-3 p-3 py-2'>Continue Shopping</button></a>
             <button class='text-light bg-secondary border px-3 mx-3 p-3 py-2' name='checkout'><a href='./users_area/checkout.php' class='text-decoration-none text-light'>Checkout</a></button>";
                    
                    }else{
                        echo"<a href='index.php'><button class='bg-info border px-3 mx-3 p-3 py-2' name='continue_shopping'>Continue Shopping</button></a>";
                    }
                    if(isset($_POST['continue_shopping'])){
                        echo"<script>window.open('index.php','_self')</script>";
                    }

                    
                    ?>
                    
                </div>
        </div>
    </div>
    </form>

    <?php
    function remove_cart_item(){
        global $con;
        if (isset($_POST['remove_cart'])) {
            foreach ($_POST['removeitem'] as $remove_id) {
                echo $remove_id;
                $delete_query = "Delete from `cart_details` where product_id=$remove_id";
                $run_delete = mysqli_query($con, $delete_query);
                if ($run_delete) {
                    echo "<script> window.open('cart.php','_self') </script>";
                }
            }
        }
    }
    echo $remove_item = remove_cart_item();

    ?>



        <!-- Last child-->
        <div class="bg-info p-3 text-center">
            <p>All right reserved to Boi Bazar - Developed by Md Ashikur Rahman</p>

        </div>

        <!-- Bootstrap Js Link -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"><script/> 
    </body>

</html>