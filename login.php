<?php
session_start();
$username = $password  = $warning = "";
$usernameError =  $passwordError =  "";;
if (isset($_SESSION["warning"])) {
    $warning = $_SESSION['warning'];
    unset($_SESSION["warning"]);
}
if (isset($_SESSION["error"])) {
    echo "<script>alert('" . $_SESSION['error'] . "')</script>";
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])) {
    echo "<script>alert('" . $_SESSION['success'] . "')</script>";
    unset($_SESSION["success"]);
}


if (isset($_SESSION["errors"]) && isset($_SESSION["formData"])) {
    $username = $_SESSION["formData"]["username"]  ?? "";
    $password = $_SESSION["formData"]["password"]  ?? "";

    $usernameError = $_SESSION["errors"]["username"] ?? "";
    $passwordError = $_SESSION["errors"]["password"] ?? "";

    unset($_SESSION["errors"]);
    unset($_SESSION["formData"]);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Form</title>
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

        .signin-card {
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
                <div class="signin-card bg-white p-4">
                    <h3 class="text-center mb-4">Sign In</h3>
                    <form action="./backend/process.php" method="POST">
                        <p class="text-center"><?php echo htmlspecialchars($warning) ?></p>
                        <div class="mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?php echo $username; ?>">
                            <div class="invalid-feedback">
                                <?php echo $usernameError; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control <?php echo !empty($passwordError) ? 'is-invalid' : ''; ?>" id="password" name="password" value="<?php echo $password; ?>" placeholder="Enter your password">
                            <div class="invalid-feedback">
                                <?php echo $passwordError; ?>
                            </div>
                        </div>
                        <!-- <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember Me</label>
                        </div> -->
                        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        <div class="text-center mt-3">
                            <a href="./forgotPassword.php" class="text-decoration-none">Forgot password?</a>
                        </div>
                        <div class="text-center mt-2">
                            <p>Don't have an account? <a href="./register.php" class="text-decoration-none">Register</a></p>
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