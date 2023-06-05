<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <!-- Bootsrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <h3 class="text-center text-danger mb-4">Delete Account</h3>
    <form action="" method="post" class="mt-5">
        <div class="form-outline mb-4">
            <input type="submit" class="form control w-50 m-auto bg-info" name="not_delete" 
            value="Don't Delete Account">
        </div>
        <div class="form-outline mb-4">
            <input type="submit" class="form control w-50 m-auto bg-danger" name="delete" 
            value="Delete Account">
        </div>
    </form>
    <?php
    $username_session=$_SESSION['username'];
    if(isset($_POST['delete'])){
        $delete_query="Delete from `user_table` where username='$username_session'";
        $result=mysqli_query($con, $delete_query);
        if($result){
            session_destroy();
            echo"<script>alert('Account Deleted Successfully')</script>";
            echo"<script>window.open('../index.php','_self')</script>";
        }
    }
    if(isset($_POST['not_delete'])){
        echo"<script>window.open('profile.php','_self')</script>";
    }
    
    
    ?>
</body>
</html>