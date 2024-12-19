<?php
session_start();
include "./backend/mail.php";
include "./backend/helper.php";

$helper = new Helper();

$token  = $email = "";
$otpError  = "";

if (isset($_SESSION["errors"])) {
    $otpError = $_SESSION["errors"]['otp'];
    $email = $_SESSION["formData"]['email'] ?? "";
    unset($_SESSION["errors"]);
};

if (isset($_SESSION["warning"])) {
    echo "<script>alert('" . $_SESSION['warning'] . "')</script>";
    unset($_SESSION["warning"]);
};
if (isset($_SESSION["error"])) {
    $email = $_SESSION["formData"]['email'] ?? "";
    echo "<script>alert('" . $_SESSION['error'] . "')</script>";
    unset($_SESSION["error"]);
    unset($_SESSION["formData"]);
};


if (isset($_GET["token"]) && isset($_GET["email"])) {
    $token = $_GET["token"];
    $email = $_GET["email"];
    
};




if (isset($_SESSION["errors"])) {
    $otpError = $_SESSION["errors"]["otpError"] ?? "";
    unset($_SESSION["errors"]);
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #6c63ff;
        }

        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
        }

        .btn-primary:hover {
            background-color: #5a54d6;
            border-color: #5a54d6;
        }
    </style>
</head>

<body class="bg-dark  bg-hover">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="signup-card bg-white p-4">
                    <h3 class="text-center mb-4">Email Verify</h3>
                    <form action="http://localhost/ekana/dashboard/backend/process.php" method="POST">
                        <div class="mb-3">
                            <label for="otp">OTP</label>
                            <input type="text" class="form-control <?php echo !empty($otpError) ? 'is-invalid' : ''; ?>" id="otp" name="otp">
                            <div class="invalid-feedback">
                                <?php echo $otpError; ?>
                            </div>
                        </div>

                        <button type="submit" name="verifyEmail" value="<?php echo htmlspecialchars($email); ?>" class="btn btn-primary w-100">Verify</button>
                        <div class="text-center mt-3">
                            <p><a href="http://localhost/ekana/dashboard/backend/process.php?resend=resend&email=<?php echo $email; ?>" class="text-decoration-none">Resend OTP</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>



</html>