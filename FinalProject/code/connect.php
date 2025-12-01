<?php
    session_start();
    $username=$_POST['name'];
    $password=$_POST['password'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $verificationcode = rand(100000, 999999);
    
    $host="localhost";
    $dbusername="root";
    $dbpassword= "";
    $dbname= "techhive";
    $port=3307;
    $conn=mysqli_connect($host,$dbusername,$dbpassword,$dbname,$port);
    if($conn->connect_error){
        die("Connection Error". $conn->connect_error);
    }
    else{
        $check = $conn->prepare("SELECT id FROM userinfo WHERE email = ?");
        if ($check === false) {
            die("Prepare failed: " . $conn->error);
        }
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            die("Error: email already registered");
        }
        $stmt = $conn->prepare("INSERT INTO userinfo(name,email,phone,address,password,verified) VALUES(?,?,?,?,?,0)");
        $_SESSION['email'] = $email;
        $_SESSION['verificationcode']=$verificationcode;
        if($stmt===false){
            die("Prepare failed". $conn->connect_error);
        }
    }
    $stmt->bind_param("sssss", $username, $email,$phone,$address,$password);
    if( $stmt->execute() === false ){
        die("Error". $stmt->error);
    }
    else{
        // Redirect to verification page and include email as a GET parameter
        header('Location: verification.php');
        exit;
    }

?>