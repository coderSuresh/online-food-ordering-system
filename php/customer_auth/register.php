<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <title>Register | RestroHub</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <script src="../js/app.js" defer></script>
</head>


<body>
    <header>
        <nav class="top_nav flex items-center">
            <div class="logo__back-btn flex items-center">
                <!-- test back btn -->
<<<<<<< HEAD:php/customer_auth/register.php
                <button class="nav__btn-back no_bg no_outline"><img src="../../images/ic_back.svg" alt="go back"></button>
                <a href="#" class="logo heading flex items-center"><img src="../../images/logo.png" alt="logo">Restro
=======
                <button class="nav__btn-back no_bg no_outline"><img src="./images/ic_back.svg" alt="go back"></button>
                <a href="./index.html" class="logo heading flex items-center"><img src="./images/logo.png" alt="logo">Restro
>>>>>>> 8235073a0c983e961dacb38bdd7b0b9720ba8f93:register.html
                    <span>Hub</span>
                </a>
            </div>

            <ul class="flex items-center">
                <li class="flex direction-col"><a href="menu.html">Menu</li>

                <li class="flex direction-col"><a href="login.html"><img src="../../images/ic_acc.svg" alt="account"></a>
                    <span class="nav__tooltip">Account</span>
                </li>
                <li class="flex direction-col"><a href="#"><img src="../../images/ic_cart.svg" alt="cart"></a> <span
                        class="nav__tooltip">Cart</span> </li>
            </ul>
        </nav>

    </header>

    <div class="center border-curve-lg shadow">
        <h1 class="heading text-center">Register</h1>
        <form method="post" action = "./insert-register.php">
            <div class="text_field">
                <input type="text" class="no_bg no_outline" name = "name" required autofocus>
                <label>Name</label>
            </div>
             <div class="text_field">
                <input type="text" class="no_bg no_outline" name = "username" required autofocus>
                <label>Username</label>
            </div>
            <div class="text_field">
                <input type="email" class="no_bg no_outline" name ="email" required>
                <label>Email</label>
            </div>
            <div class="text_field">
                <input type="password" class="no_bg no_outline" name = "password" required>
                <label>Password</label>
            </div>
            <div class="text_field">
                <input type="password" class="no_bg no_outline" required>
                <label>Confirm password</label>
            </div>
            <input type="submit" class="no_outline border-curve-lg" name = "register" value="Register">
            <p class="signup_link text-center">
                Already have an account?<a href="../customer_auth/login.php"> Sign in</a>
            </p>
        </form>
    </div>

</body>

</html>