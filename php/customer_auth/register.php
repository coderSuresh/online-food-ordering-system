<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
    <title>Register | RestroHub</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <script src="../../js/app.js" defer></script>
</head>


<body>
    <header>
        <nav class="top_nav flex items-center">
            <div class="logo__back-btn flex items-center">
                <!-- test back btn -->
                <button class="nav__btn-back no_bg no_outline"><img src="../../images/ic_back.svg"
                        alt="go back"></button>
                <a href="#" class="logo heading flex items-center"><img src="../../images/logo.png" alt="logo">Restro

                    <span>Hub</span>
                </a>
            </div>

            <ul class="flex items-center">
                <li class="flex direction-col"><a href="menu.html">Menu</li>

                <li class="flex direction-col"><a href="login.html"><img src="../../images/ic_acc.svg"
                            alt="account"></a>
                    <span class="nav__tooltip">Account</span>
                </li>
                <li class="flex direction-col"><a href="#"><img src="../../images/ic_cart.svg" alt="cart"></a> <span
                        class="nav__tooltip">Cart</span> </li>
            </ul>
        </nav>

    </header>

    <div class="center border-curve-lg shadow">
        <h1 class="heading text-center">Register</h1>
        <form method="post" action="./insert-register.php">
            <p>
                <?php
                if (isset($_SESSION["invalid_name"])) {
                    echo $_SESSION["invalid_name"];
                    ?><br>
                    <?php unset($_SESSION["invalid_name"]);
                }
                ?>
                <?php
                if (isset($_SESSION["invalid_username"])) {
                    echo $_SESSION["invalid_username"];
                    ?><br>
                    <?php unset($_SESSION["invalid_username"]);
                }
                ?>
                <?php
                if (isset($_SESSION["invalid_email"])) {
                    echo $_SESSION["invalid_email"];
                    ?><br>
                    <?php unset($_SESSION["invalid_email"]);
                }
                ?>
                <?php
                if (isset($_SESSION["invlaid_password"])) {
                    echo $_SESSION["invlaid_password"];
                    ?><br>
                    <?php unset($_SESSION["invlaid_password"]);
                }
                ?>
                <?php
                if (isset($_SESSION["password_not_match"])) {
                    echo $_SESSION["password_not_match"];
                    ?><br>
                    <?php unset($_SESSION["password_not_match"]);
                }
                ?>
                <?php
                if (isset($_SESSION["email_already_exit"])) {
                    echo $_SESSION["email_already_exit"];
                    ?><br>
                    <?php unset($_SESSION["email_already_exit"]);
                }
                ?>
                <?php
                if (isset($_SESSION["username_already_exit"])) {
                    echo $_SESSION["username_already_exit"];
                    ?><br>
                    <?php unset($_SESSION["username_already_exit"]);
                }
                ?>
            </p>
            <div class="text_field">
                <input type="text" class="no_bg no_outline" placeholder="John Doe" name="name" required autofocus>
                <label>Name</label>
            </div>

            <div class="text_field">
                <input type="text" class="no_bg no_outline" placeholder="johndoe" name="username" required>
                <label>Username</label>
            </div>
            <div class="text_field">
                <input type="email" class="no_bg no_outline" placeholder="johndoe@gmail.com" name="email" required>
                <label>Email</label>
            </div>
            <div class="text_field">
                <input type="password" class="no_bg no_outline password_input" placeholder="xxxxxxxxxx" name="password" required>
                <label>Password</label>
                <img src="../../images/ic_eye-off.svg" alt="hide password" class="pointer password_toggle_btn">
            </div>
            <div class="text_field">
                <input type="password" class="no_bg no_outline password_input" placeholder="xxxxxxxxxx" name="confirm_password" required>
                <label>Confirm Password</label>
                <img src="../../images/ic_eye-off.svg" alt="hide password" class="pointer password_toggle_btn">
            </div>
            <input type="submit" class="no_outline border-curve-lg" name="register" value="Register">
            <p>
                <?php
                if (isset($_SESSION['register-insert'])) {
                    echo $_SESSION['register-insert'];
                }
                ?>
            </p>
            <p class="signup_link text-center">
                Already have an account?<a href="../customer_auth/login.php"> Sign in</a>
            </p>
        </form>
    </div>

</body>

</html>
<?php
session_unset();
?>