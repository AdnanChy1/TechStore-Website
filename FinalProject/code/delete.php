<?php
include 'connection.php';
$id=$_GET['id'];
mysqli_query($conn,"DELETE FROM crud WHERE id='$id'");
header('location:admin.php');
?>