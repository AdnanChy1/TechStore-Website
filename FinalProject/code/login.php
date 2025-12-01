<?php
session_start();
$email = isset($_POST['email'])? $_POST['email']:null;
$password = isset($_POST['password']) ? $_POST['password']:null;
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "techhive";
$port = 3307;
$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname, $port);
if(isset($email)){
$sql = "SELECT id,PASSWORD,VERIFIED FROM USERINFO WHERE EMAIL='$email'";
$result = mysqli_query($conn, $sql);
$user_verified=null;
$user_password=null;
$user_id=null;
if (mysqli_num_rows($result) === 0) {
    echo "<script>alert('No Account found with that Email');
        </script>";
} else {
    $row = mysqli_fetch_assoc($result);
    if($row){
        $user_password=$row['PASSWORD'];
        $user_verified=$row['VERIFIED'];
        $user_id=$row['id'];
    }
    if($user_verified==0){
        $verificationcode=rand(100000,999999);
        $_SESSION['verificationcode']=$verificationcode;
        $_SESSION['email']=$email;
        header('Location:verification.php');
        exit;
    }
    else{
        if($password==$user_password){
            $_SESSION['email']=$email;
            $_SESSION['password']=$user_password;
            $_SESSION['id']=$user_id;
            header('Location:home.php');
        }
        else echo "<script>alert('Email and Password dont match');
        </script>";
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
      /* translucent container */
      .transparent-container {
        background-color: rgba(255,255,255,0.1); 
        backdrop-filter: blur(6px); 
      }
    </style>

</head>

<body class="bg-light" style="background-image: url('media/background.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container my-5 w-50 mx-auto p-4 shadow rounded transparent-container">
        <h1 class="text-center text-white">Welcome to TechHive</h1>
        <h6 class="text-center text-white">Your Hub for All Things Tech</h6>
        <h3 class="text-center text-white">Login</h3>
        <form method="post" id="form">
            <div class="mb-3">
                <label class="text-white">Email Address</label>
                <input name="email" class="form-control" id="emailaddress">
            </div>
            <div class="mb-3">
                <label class="text-white">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <button type="submit" class="btn btn-dark d-block mx-auto mt-3">Login</button>
            <p class="text-center mt-3 text-white">New User? <a class="text-white" href="register.php">Register</a></p>
            <a class="text-white" href="forgetpassword.php">Forget Password</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>