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
if (isset($_SESSION["success"])) {
    echo "<script>alert('" . $_SESSION['success'] . "')</script>";
    unset($_SESSION["error"]);
}
$username = $password = $cpassword =  "";
$usernameError =  $passwordError = $cpasswordError =  "";

if (isset($_SESSION["errors"]) && isset($_SESSION["formData"])) {
    $username = $_SESSION["formData"]["username"]  ?? "";
    $password = $_SESSION["formData"]["password"]  ?? "";
    $cpassword = $_SESSION["formData"]["cpassword"]  ?? "";


    $usernameError = $_SESSION["errors"]["username"] ?? "";
    $passwordError = $_SESSION["errors"]["password"] ?? "";
    $cpasswordError = $_SESSION["errors"]["cpassword"] ?? "";


    unset($_SESSION["errors"]);
    unset($_SESSION["formData"]);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Change Password</h4>
                    </div>
                    <div class="card-body">
                        <form action="./backend/process.php" method="POST">
                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?php echo $username; ?>" placeholder="Enter username or email">
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
                            <div class="mb-3">
                                <label for="cpassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control <?php echo !empty($cpasswordError) ? 'is-invalid' : ''; ?>" id="cpassword" name="cpassword" value="<?php echo $cpassword; ?>" placeholder="Confirm password">
                                <div class="invalid-feedback">
                                    <?php echo $cpasswordError; ?>
                                </div>
                            </div>
                            <button type="submit" name="forgetPassword" class="btn btn-primary w-100">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>