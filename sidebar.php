
<?php
$username = "Username";
$image = "./public/image/localProfile.png";
if (isset($_SESSION["userData"]) && is_array($_SESSION["userData"])) {
    $username = $_SESSION["userData"]["username"];
    $image = "./public/user/".$_SESSION["userData"]["profileImage"];
}
?>
<!-- Sidebar Toggle Button (Visible on small screens) -->
<button class="sidebar-toggler">
    <i class="fas fa-bars"></i>
</button>


<nav class="sidebar mt-5" style="z-index: 100;height:100vh;">
    <div class="text-center">
        <img src="<?php echo htmlspecialchars($image) ?>" alt="User" class="rounded-circle mb-2" style="height: 80px; width: 80px;">
        <h6><?php echo htmlspecialchars($username) ?></h6>
        <span class="badge bg-success">Online</span>
    </div>
    <a href="./index.php"><i class="fas fa-home my-2"></i> Dashboard</a>
    <a href="./student.php"><i class="fas fa-table"></i> Student</a>
    <a href="./teacher.php"><i class="fas fa-envelope"></i> Teachers</a>
    <a href="./chat.php"><i class="fas fa-chart-bar"></i> Chat</a>

    <a href="#update-menu" data-bs-toggle="collapse" class="d-flex align-items-center">
        <i class="fas fa-edit"></i> Profile
        <i class="fas fa-chevron-down ms-auto"></i>
    </a>
    <div id="update-menu" class="collapse submenu">
        <a href="#">Update Profile</a>
        <a href="#">Update Settings</a>
    </div>
    <a href="#delete-menu" data-bs-toggle="collapse" class="d-flex align-items-center">
        <i class="fas fa-trash-alt"></i> Delete
        <i class="fas fa-chevron-down ms-auto"></i>
    </a>
    <div id="delete-menu" class="collapse submenu">
        <a href="#">Delete Account</a>
        <a href="#">Delete Data</a>
    </div>

    <a href="#elements-menu" data-bs-toggle="collapse" class="d-flex align-items-center">
        <i class="fas fa-th"></i> Elements
        <i class="fas fa-chevron-down ms-auto"></i>
    </a>
    <div id="elements-menu" class="collapse submenu">
        <a href="#">Element 1</a>
        <a href="#">Element 2</a>
    </div>
    <!-- <a href="./login.php"><i class="fas fa-sign-in-alt"></i> Sign In</a> -->
    <a href="./register.php"><i class="fas fa-user-plus my-2s"></i> Sign Up</a>
    <a href="./forgetPassword.php"><i class="fas fa-key"></i> Forgot Password</a>
    <form action="./backend/process.php" class="border-0 border bg-transparent" method="post">
        <button type="submit" name="logout" class="ms-2 border-0 border outline-0 text-white bg-transparent">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>

</nav>


 