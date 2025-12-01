<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Admin</title>
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
            <div class="col-sm-12 col-lg-4 col-md-6 offset-lg-4 my-5">
                <form action="insert.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <h4 class="text-center text-danger">ADD PRODUCTS</h4>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="fw-bold text-warning">Product Name:</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="fw-bold text-warning">Product Price:</label>
                        <input type="number" class="form-control" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="fw-bold text-warning">Product Image:</label>
                        <input type="file" class="form-control" name="image">
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
                    <button type="submit" class="btn btn-danger col-12" name="add">Add</button>
                </form>
            </div>
        </div>
    </div>

    <!-- display content -->

    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Image</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "connection.php";
                        $alldata = mysqli_query($conn, "SELECT * FROM crud");
                        while ($arr = mysqli_fetch_array($alldata)) {
                            echo
                            "<tr>
                    <td>$arr[id]</td>
                    <td>$arr[name]</td>
                    <td>$arr[price]</td>
                    <td>$arr[category]</td>
                    <td><img src='$arr[image]' alt='image' width='100px'></td>
                    <td><a class='btn btn-danger' href='delete.php?id=$arr[id]' name='id'>Delete</a></td>
                     <td><a class='btn btn-warning' href='update.php?id=$arr[id]' name='id'>Update</a></td>
                   </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>