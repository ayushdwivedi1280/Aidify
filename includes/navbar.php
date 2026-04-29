<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/db.php"; // IMPORTANT

$user = null;

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $res = mysqli_query($conn, "SELECT name, profile_pic FROM users WHERE id='$user_id'");
    $user = mysqli_fetch_assoc($res);
}
?>

<nav style="background:#333;padding:15px;display:flex;justify-content:space-between;align-items:center;">

    <!-- LEFT -->
    <div>
        <a href="/aidify1/index.php" style="color:white;margin-right:15px;">Home</a>

        <?php if(isset($_SESSION['user_id'])){ ?>
            <a href="/aidify1/pages/dashboard.php" style="color:white;margin-right:15px;">Dashboard</a>
        <?php } ?>
    </div>

    <!-- RIGHT -->
    <div style="display:flex;align-items:center;gap:10px;">

        <?php if(isset($_SESSION['user_id'])){ ?>

            <!-- Profile Image -->
            <?php if(!empty($user['profile_pic'])){ ?>
                <img src="/aidify1/uploads/<?php echo $user['profile_pic']; ?>" 
                     width="40" height="40" 
                     style="border-radius:50%;object-fit:cover;">
            <?php } else { ?>
                <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" 
                     width="40" height="40"
                     style="border-radius:50%;">
            <?php } ?>

            <!-- Name -->
            <span style="color:white;"><?php echo $user['name']; ?></span>

            <!-- Logout -->
            <a href="/aidify1/pages/logout.php" style="color:white;margin-left:10px;">Logout</a>

        <?php } else { ?>

            <a href="/aidify1/pages/login.php" style="color:white;margin-right:15px;">Login</a>
            <a href="/aidify1/pages/register.php" style="color:white;">Register</a>

        <?php } ?>

    </div>

</nav>