<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$ok = false;
$email=isset($_SESSION['email'])?$_SESSION['email']:null;
function send_email_verify($email, $verificationcode)
{
    $mail = new PHPMailer(true);
    // SMTP configuration - set to your SMTP provider details
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'example@gmail.com';
    $mail->Password   = '1111111';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('awesomeadnan097@gmail.com', 'Verification');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Verify your email address';
    // Use double quotes so variable is interpolated
    $mail->Body    = "Your verification code is <b>{$verificationcode}</b>";
    $mail->send();
    return true;
}
$email = $_SESSION['email'] ?? null;
$verificationcode = $_SESSION['verificationcode'] ?? null;
if ($email && $verificationcode) {
    $sent = send_email_verify($email, $verificationcode);
    if (! $sent) {
        $mail_error = 'Could not send mail; showing code below for testing.';
    }
} else {
    $mail_error = 'No verification data in session.';
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <?php
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $conn = new mysqli("localhost", "root", "", "techhive",3307);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $code  = $_POST['code'];
            if ($verificationcode == $code) {
                $conn->query("UPDATE userinfo SET verified=1 WHERE email='$email'");
                $message = "✅ Email verified successfully!";
                $ok = true;
                header("login.php");
            } else {
                $message = "❌ Invalid code.";
            }
        } else {
            $message = "User not found.";
        }
    ?>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }
    </style>
    </head>

    <body class="d-flex justify-content-center align-items-center">

        <div class="container text-center border p-4" style="max-width: 400px; background-color: #f8f9fa; border-radius: 8px; border-color: black;">
            <h3 class="mb-4">Verify Your Email</h3>

            <form action="verification.php" method="POST">
                <div class="mb-3 text-start">
                    <input type="text" class="form-control" name="code" placeholder="Enter code" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Submit</button>
            </form>
            <?php if (!empty($message)): ?>
                <div class="mt-3 text-center">
                    <span class="<?php echo $is_success ? 'text-success' : 'text-danger'; ?> fw-bold">
                        <?php echo htmlspecialchars($message); ?>
                        <?php if ($ok) {
                            header('Location:login.php');
                            exit;
                        }
                        ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>



        </div>

    </body>

</html>