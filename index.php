<?php
include "./backend/helper.php";
include "./backend/table.php";

session_start();
unset($_SESSION["formData"]);
unset($_SESSION["errors"]);
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
    unset($_SESSION["success"]);
}

if (!isset($_SESSION["username"])) {
    header("location: ./login.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS --> 
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css" />
    <style>
        .card h6 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-custom {
            position: relative;
            border: none;
            border-radius: 10px;
            background-color: #6b6161;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card-custom::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background-color: #007bff;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>


    <?php include "./sidebar.php" ?>


    <!-- Main Content -->
    <div class="flex-grow-1">

        <?php include "./header.php" ?>

        <div class="row g-3 py-4 px-4 mt-5">
            <div class="col-md-4">
                <div class="card text-center shadow-sm card-custom">
                    <div class="card-body">
                        <h6 class="text-primary">GALLERY</h6>
                        <p class="display-6">4</p>
                        <i class="fas fa-images fa-3x text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm card-custom">
                    <div class="card-body">
                        <h6 class="text-info">TESTIMONIAL</h6>
                        <p class="display-6">4</p>
                        <i class="fas fa-comments fa-3x text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm card-custom">
                    <div class="card-body">
                        <h6 class="text-primary">CONTACT</h6>
                        <p class="display-6">2</p>
                        <i class="fas fa-phone fa-3x text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm card-custom">
                    <div class="card-body">
                        <h6 class="text-warning">BLOG</h6>
                        <p class="display-6">1</p>
                        <i class="fas fa-blog fa-3x text-warning"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm card-custom">
                    <div class="card-body">
                        <h6 class="text-warning">DEPARTMENT</h6>
                        <p class="display-6">4</p>
                        <i class="fas fa-columns fa-3x text-warning"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm card-custom">
                    <div class="card-body">
                        <h6 class="text-primary">APPOINTMENT</h6>
                        <p class="display-6">1</p>
                        <i class="fas fa-network-wired fa-3x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>

 
    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
     
    <script>
        const toggler = document.querySelector('.sidebar-toggler');
        const sidebar = document.querySelector('.sidebar');

        toggler.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        <?php
        if (isset($_SESSION["success"])) {
            echo "alert('" . $_SESSION['success'] . "')";
            unset($_SESSION["success"]);
        }
        ?>
    </script>
</body>

</html>