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
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Login | RestroHub</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <script src="../../js/app.js" defer></script>
</head>


<body>
    <header>
        <nav class="top_nav flex items-center">
            <div class="logo__back-btn flex items-center">
                <!-- back btn -->
                <button class="nav__btn-back no_bg no_outline"><img src="../../images/ic_back.svg"
                        alt="go back"></button>
                <a href="../../" class="logo heading flex items-center"><img src="../../images/logo.png"
                        alt="logo">Restro

                    <span>Hub</span>
                </a>
            </div>
            <ul class="flex items-center">
                <li class="flex direction-col"><a href="menu.html">Menu</li>

                <li class="flex direction-col"><a href="#"><img src="../../images/ic_acc.svg" alt="account"></a>
                    <span class="nav__tooltip">Account</span>
                </li>
                <li class="flex direction-col"><a href="#"><img src="../../images/ic_cart.svg" alt="cart"></a> <span
                        class="nav__tooltip">Cart</span> </li>
            </ul>
        </nav>
    </header>

    <main class="center border-curve-lg shadow">
        <h1 class="heading text-center">Login</h1>
        <form action="../../php/customer_auth/auth.php" method="post">
            <div class="text_field">
                <input type="text" class="no_bg no_outline" placeholder="John Doe" name="username" required autofocus>
                <label>Username</label>
            </div>
            <div class="text_field">
                <input type="password" class="no_bg no_outline password_input" placeholder="xxxxxxxx" name="password"
                    required>
                <label>Password</label>
                <img src="../../images/ic_eye-off.svg" alt="hide password" class="pointer password_toggle_btn">
            </div>
            <a href="#" class="forget_password">Forgot password?</a>
            <input type="submit" class="no_outline border-curve-lg mt-20" name="login" value="login">

            <div class="flex items-center or justify-center mt-20">
                <siv class="bar"></siv>
                <h4>Or Signup With</h4>
                <siv class="bar"></siv>
            </div>

            <div class="flex items-center mt-20">

                <img src="../../images/ic_apple.png" class="icons pointer shadow" alt="sign in with apple">

                <img src="../../images/ic_google.svg" class="icons pointer shadow" alt="sign in with google">

                <img src="../../images/ic_facebook.svg" class="icons pointer shadow" alt="sign in with facebook">

                <a href="./register.php"><img src="../../images/ic_mail.svg" class="icons pointer shadow"
                        alt="sign in with email"></a>
            </div>
        </form>
    </main>

</body>

</html>
<?php
session_unset();
?>


<!-- <script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  const firebaseConfig = {
    apiKey: "AIzaSyAgWmm70VliKQ68Cod0MgzmsncJ2R8h_jI",
    authDomain: "annular-magnet-374810.firebaseapp.com",
    projectId: "annular-magnet-374810",
    storageBucket: "annular-magnet-374810.appspot.com",
    messagingSenderId: "360310508668",
    appId: "1:360310508668:web:0bf9048fd87a2741338df9"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
</script> -->