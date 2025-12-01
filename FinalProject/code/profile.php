<?php
session_start();
include 'connection.php';
$id = $_SESSION['id'];
$password=$_SESSION['password'];
if (isset($_POST['updateinfo'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $sql = "update userinfo set name='$name',address='$address' where id='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location:profile.php");
    } else {
        echo 'Update failed';
    }
}
if (isset($_POST['updatepassword'])) {
    $enteredPass=$_POST['currentpass'];
    $newpass=$_POST['newpass'];
    if($enteredPass!=$password)echo "<script>alert('Password dont match');</script>";
    else{
    $_SESSION['password']=$newpass;
    $sql = "update userinfo set password='$newpass' where id='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location:profile.php");
    } else {
        echo 'Update failed';
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <h1 class="text-center">Profile</h1>
    <a class="btn btn-secondary" href="home.php">Go Back Home</a>
    <form method="post">
        <div class="form-group my-5">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name"
                value="<?php
                        include 'connection.php';
                        $sql = "select name,address from userinfo where id='$id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $name = $row["name"];
                        $address = $row["address"];
                        echo $name;
                        ?>">
        </div>
        <div class="form-group my-5">
            <label class="form-label">Address</label>
            <input name="address" type="text" class="form-control"
                value="<?php
                        include 'connection.php';
                        $sql = "select name,address from userinfo where id='$id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $name = $row["name"];
                        $address = $row["address"];
                        echo $address;
                        ?>">
        </div>
        <button name="updateinfo" type="submit" class="btn btn-primary">Update</button>
    </form>
    <h1 class="text-center">Change Password</h1>
    <form method="post">
        <div class="form-group my-5 w-50">
            <label class="form-label">Current Password</label>
            <input type="text" class="form-control" name="currentpass">  
        </div>
        <div class="form-group my-5 w-50">
            <label class="form-label">New Password</label>
            <input type="text" class="form-control" name="newpass">  
        </div>
        <button name="updatepassword" type="submit" class="btn btn-secondary">Update</button>
    </form>
</body>

</html>