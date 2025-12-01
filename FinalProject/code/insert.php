<?php

include 'connection.php';

$name=$_POST['name'];
$price=$_POST['price'];
$image=$_FILES['image'];
$category=$_POST['category'];

$imagelocation=$_FILES['image']['tmp_name'];
$imagename=$_FILES['image']['name'];
$image_final_des="media/".$imagename;

move_uploaded_file($imagelocation,$image_final_des);

$insertquery="INSERT INTO crud(name, price,category,image) VALUES ('$name','$price','$category','$image_final_des')";

if(mysqli_query($conn,$insertquery)){
    echo "<script>alert('inserted')</script>";
    header('location:admin.php');
}



?>