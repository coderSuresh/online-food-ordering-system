<?php
session_start();
if (!isset($_SESSION['delivery-success'])) {
    header("Location: ../invalid.html");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <meta name="robots" content="noindex">
    <title>Delivery | RestroHub</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <header>
        <nav class="top_nav flex items-center">
            <div class="logo__back-btn flex items-center">
                <!-- back btn -->
                <button class="nav__btn-back no_bg no_outline"><img src="../images/ic_back.svg" alt="go back"></button>
                <a href="./index.php" class="logo heading flex items-center"><img src="../images/logo.png" alt="logo">Restro
                    <span>Hub</span>
                </a>
            </div>

            <ul class="flex items-center">
                <!-- show profile icon if the user is logged in -->
                <?php
                if (isset($_SESSION['delivery-success'])) {
                    echo '<li class="flex direction-col">
                            <img src="../images/logo.png" class="user_profile_icon relative" alt="account">
                            <div class="logout-dropdown border-curve shadow p-20">
                                <a href="./backend/logout.php">Logout</a>   
                            </div>                         
                          </li>
                          ';
                } else {
                    echo '<li class="flex direction-col"><a href="./login.php"><img src="../images/ic_acc.svg" alt="account">
                    <span class="nav__tooltip shadow p-20">Login</span></a>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Delivery Details</h2>
        </section>

    </main>
    <script src="../js/app.js" type="module"></script>
</body>

</html>