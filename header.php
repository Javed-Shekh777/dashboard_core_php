<?php
$image = "./public/image/localProfile.png";
if (isset($_SESSION["userData"]) && is_array($_SESSION["userData"])) {
    $image = "./public/user/" . $_SESSION["userData"]["profileImage"];
}
$helper  = new Helper();

$notifications;
$count = 0;
$notifications = $helper->getNotifications($conn, $dbName, $notification);
if ($notifications) {
    $count = mysqli_num_rows($notifications);
};




?>


<!-- Header -->
<header class="header fixed-top">
    <h4 style="margin-left: 55px;">USER DASHBOARB </h4>
    <div class="notification-bar">
        <!-- Notification Icon -->
        <div class="notification-icon">
            <a href="#" class="text-white" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-envelope"></i>
                <span class="notification-badge">3</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-item"><i class="fas fa-info-circle"></i> New update available</li>
                <li class="dropdown-item"><i class="fas fa-user"></i> New user registered</li>
                <li class="dropdown-item"><i class="fas fa-exclamation-triangle"></i> System alert</li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="dropdown-item text-center"><a href="#">View All</a></li>
            </ul>
        </div>
        <!-- Message Icon -->
        <div class="notification-icon">
            <a href="#" class="text-white" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-lg"></i>
                <span class="notification-badge"><?php echo htmlspecialchars($count) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <?php if ($notifications) : ?>
                    <?php while ($noty = mysqli_fetch_assoc($notifications)): ?>
                        <li class="dropdown-item">
                            <?php echo $noty['message']; ?>
                            <a href="./backend/process.php?action=delete&notificationId=<?php echo $noty['id'] ?>" style="border: none; background: none;">
                                <i class="fa-solid fa-x"></i>
                            </a>
                            </form>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="dropdown-item"><i class="fas fa-user"></i>No notifications</li>
                <?php endif; ?>

                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="dropdown-item text-center"><a href="#">View All</a></li>
            </ul>
        </div>
        <!-- User Avatar -->
        <img src="<?php echo htmlspecialchars($image) ?>" alt="User" class="rounded-circle" style="height: 50px; width: 50px;">
    </div>
</header>