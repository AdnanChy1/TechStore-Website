<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
session_start();
$email=isset($_POST['email']) ? $_POST['email']:null;
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "techhive";
$port = 3307;
$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname, $port);
if(isset($email)){
$sql = "SELECT PASSWORD FROM USERINFO WHERE EMAIL='$email'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
    echo "<script>alert('No Account found with that Email');
        </script>";
} else {
    $row = mysqli_fetch_assoc($result);
    if($row){
    $password=$row['PASSWORD'];
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'awesomeadnan097@gmail.com';
    $mail->Password   = 'dvpnlpqndsikfvfw';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('awesomeadnan097@gmail.com','Password');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Forgotten Password';
    // Use double quotes so variable is interpolated
    $mail->Body    = "Your Password is <b>{$password}</b>";
    try{
    $mail->send();
    echo "<script>alert('Email sent with your Password');
        </script>";
    }catch(Exception $e){
        echo "<script>alert('Unable to send email at the moment.Please try again Later');
        </script>";
    }
}
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
    <body class="bg-light">
    <div class="container my-5 w-50 mx-auto p-4 shadow rounded bg-white">
        <h1 class="text-center">Welcome to TechHive</h1>
        <h6 class="text-center">Your Hub for All Things Tech</h6>
        <h3 class="text-center">Forget Password</h3>
        <form method="post" id="form">
            <div class="mb-3">
                <label>Email Address</label>
                <input name="email" class="form-control" id="emailaddress">
            </div>
             <button type="submit" class="btn btn-dark d-block mx-auto mt-3">Submit</button>
        </form>
    </div>
</body>
</html>