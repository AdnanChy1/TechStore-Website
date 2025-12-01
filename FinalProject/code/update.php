<?php
 include 'connection.php';
 $id=$_GET['id'];
 $allitem=mysqli_query($conn,"SELECT * FROM crud WHERE id='$id'");
 $item=mysqli_fetch_array($allitem);
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Update</title>
    <style>
        form {
            box-shadow: 0 10px 10px 0;
            border-radius: 6px;
            padding: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row  mt-5">
            <div class="col-sm-12 col-lg-4 col-md-6 offset-lg-4">
                <form action="updateaction.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <h4 class="text-center text-danger">UPDATE</h4>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="fw-bold text-warning">Product Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $item['name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="fw-bold text-warning">Product Price:</label>
                        <input type="number" class="form-control" name="price" value="<?php echo $item['price'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="fw-bold text-warning">Product Image:</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="mb-3">
                          <img src="<?php echo $item['image'] ?>" alt="database image" width=100px>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="fw-bold text-warning">Category:</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Choose...</option>
                            <option value="Smartphones">Smartphones</option>
                            <option value="Laptops">Laptops</option>
                            <option value="Headphones">Headphones</option>
                            <option value="Gaming">Gaming</option>
                            <option value="Accessories">Accessories</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                    <button type="submit" class="btn btn-warning col-12" name="add">Update</button>
                </form>
            </div>
        </div>
    </div>