<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Verify | RestroHub</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <script type="module" src="../../js/app.js" defer></script>
</head>

<body>
    <header>
        <nav class="top_nav flex items-center">
            <div class="logo__back-btn flex items-center">
                <!-- back btn -->
                <button class="nav__btn-back no_bg no_outline"><img src="../../images/ic_back.svg" alt="go back"></button>
                <a href="../../../" class="logo heading flex items-center"><img src="../../images/logo.png" alt="logo">Restro

                    <span>Hub</span>
                </a>
            </div>
            <ul class="flex items-center">
                <li class="flex direction-col"><a href="menu.html">Menu</li>

                <li class="flex direction-col"><a href="#"><img src="../../images/ic_acc.svg" alt="account"></a>
                    <span class="nav__tooltip">Account</span>
                </li>
                <li class="flex direction-col"><a href="#"><img src="../../images/ic_cart.svg" alt="cart"></a> <span class="nav__tooltip">Cart</span> </li>
            </ul>
        </nav>
    </header>

    <main class="center border-curve-lg shadow">
        <h1 class="heading text-center">Verify Account</h1>

        <form action="./verify-reset-otp.php" method="post">

            <div class="text_field">
                <input type="text" class="no_bg no_outline" placeholder="546624" minlength="6" maxlength="6" name="otp" required autofocus>
                <label>OTP</label>
            </div>

            <div>
                <input type="submit" class="button h-40 w-full no_outline border-curve-lg mt-20" name="verify" value="verify">
            </div>

        </form>
    </main>
</body>

</html>