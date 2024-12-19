<?php
session_start();
if (isset($_SESSION["warning"])) {
    echo "<script>alert('" . $_SESSION['warning'] . "')</script>";
    unset($_SESSION["warning"]);
}
if (isset($_SESSION["error"])) {
    echo "<script>alert('" . $_SESSION['error'] . "')</script>";
    unset($_SESSION["error"]);
}
 
$username = $email = $password =  "";
$usernameError = $emailError = $passwordError =  "";



if (isset($_SESSION["errors"]) && isset($_SESSION["formData"])) {
    $username = $_SESSION["formData"]["username"]  ?? "";
    $email = $_SESSION["formData"]["email"]  ?? "";
    $password = $_SESSION["formData"]["password"]  ?? "";

    $usernameError = $_SESSION["errors"]["username"] ?? "";
    $emailError = $_SESSION["errors"]["email"] ?? "";
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
                    <h3 class="text-center mb-4">Sign Up</h3>
                    <form action="./backend/process.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?php echo $username; ?>">
                            <div class="invalid-feedback">
                                <?php echo $usernameError; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control <?php echo !empty($emailError) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email">
                            <div class="invalid-feedback">
                                <?php echo $emailError; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control <?php echo !empty($passwordError) ? 'is-invalid' : ''; ?>" id="password" name="password" value="<?php echo $password; ?>" placeholder="Enter your password">
                            <div class="invalid-feedback">
                                <?php echo $passwordError; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profileImage" name="profileImage">

                        </div>

                        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="./login.php" class="text-decoration-none">Login</a></p>
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