<?php

include 'connection.php';

$id=$_POST['id'];
$name=$_POST['name'];
$price=$_POST['price'];
$image=$_FILES['image'];
$category=$_POST['category'];

$imagelocation=$_FILES['image']['tmp_name'];
$imagename=$_FILES['image']['name'];
$image_final_des="media/".$imagename;

move_uploaded_file($imagelocation,$image_final_des);

$updatequery="UPDATE crud SET name='$name',price='$price',image='$image_final_des',category='$category' WHERE id='$id'";

if(mysqli_query($conn,$updatequery)){
    echo "<script>alert('updated')</script>";
    header('location:admin.php');
}



?>