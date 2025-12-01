<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet" crossorigin="anonymous">
    <style>

        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            padding: 40px;
            margin-top: 50px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 48px;
        }

        h6 {
            font-size: 18px;
        }

        /* Large Devices (≥992px and <1200px) */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .container {
                padding: 35px;
            }

            h1 {
                font-size: 42px;
            }

            h6 {
                font-size: 17px;
            }
        }

        /* Medium Devices (≥768px and <992px) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .container {
                padding: 30px;
            }

            h1 {
                font-size: 36px;
            }

            h6 {
                font-size: 16px;
            }
        }

        /* Small Devices (≥576px and <768px) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .container {
                padding: 25px;
            }

            h1 {
                font-size: 32px;
            }

            h6 {
                font-size: 15px;
            }
        }

        /* Extra Small Devices (<576px) */
        @media (max-width: 575.98px) {
            .container {
                padding: 20px;
                margin-top: 20px;
            }

            h1 {
                font-size: 28px;
            }

            h6 {
                font-size: 14px;
            }
        }
        .transparent-container {
        background-color: rgba(255,255,255,0.1); 
        backdrop-filter: blur(6px); 
      }
    </style>
</head>

<body class="bg-light" style="background-image: url('media/bg-register.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container my-5 w-50 mx-auto p-4 shadow rounded transparent-container">
        <h1 class="text-center mb-2">Welcome to TechHive</h1>
        <h6 class="text-center mb-4">Your Hub for All Things Tech</h6>

        <h3 class="text-center mb-4">Register Your Account</h3>

        <form method="post" id="form" action="connect.php">
            <div class="mb-3">
                <label>Name</label>
                <input name="name" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label>Email Address</label>
                <input name="email" class="form-control" id="emailaddress">
            </div>
            <div class="mb-3">
                <label>Phone Number</label>
                <input name="phone" class="form-control" id="phone">
            </div>
            <div class="mb-3">
                <label>Address</label>
                <input name="address" class="form-control" id="address">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" id="confirmpassword">
            </div>
            <button type="submit" class="btn btn-dark d-block mx-auto mt-3">Register</button>
            <p class="text-center mt-3">Existing User? <a href="login.php">Login</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        const form = document.getElementById('form');
        const username = document.getElementById('name');
        const email = document.getElementById('emailaddress');
        const phone = document.getElementById('phone');
        const password = document.getElementById('password');
        const passwordcheck = document.getElementById('confirmpassword');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            checkinputs();
        });

        function checkinputs() {
            var u = false,
                em = false,
                p = false,
                pa = false,
                pac = false;
            const usernamevalue = username.value.trim();
            const emailvalue = email.value.trim();
            const phonevalue = phone.value.trim();
            const passwordvalue = password.value.trim();
            const passwordcheckvalue = passwordcheck.value.trim();
            if (usernamevalue === '') {
                alert('Username cannot be empty');
            } else {
                u = true;
            }
            if (emailvalue === '') {
                alert('Email cannot be empty');
            } else {
                em = true;
            }
            const phonePattern = /^01[356789]\d{8}$/;
            if (phonevalue == '') {
                alert('Phone Number cannot be empty');
            } else if (!phonePattern.test(phonevalue)) {
                alert('Enter a valid Phone Number');
            } else {
                p = true;
            }
            const pwdPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z0-9])\S{8,20}$/;
            if (!pwdPattern.test(passwordvalue)) {
                alert('Password should be alphanumeric and contain at least one special character and length should be between 8 to 20');
            } else {
                pa = true;
            }
            if (passwordvalue !== passwordcheckvalue) {
                alert('Password should match');
            } else {
                pac = true;
            }
            if (u && em && p && pa && pac) {
                form.submit();
            }
        }
    </script>
</body>

</html>