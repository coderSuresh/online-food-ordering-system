<?php
session_start();
if (isset($_SESSION['success'])) {
    header('Location: ../index.php');
}
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
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/responsive.css">
    <script type="module" src="../js/app.js" defer></script>
</head>

<body>

    <?php require("./components/header.php"); ?>

    <main class="center border-curve-lg shadow">
        <h1 class="heading text-center">Register</h1>
        <form method="post" class="form" action="./insert-register.php">

            <?php
            if (isset($_SESSION["invalid_name"])) {
            ?>
                <!-- to show error alert -->
                <p class="error-container error p_7-20">
                    <?php echo $_SESSION["invalid_name"]; ?>
                </p>

            <?php
                unset($_SESSION["invalid_name"]);
            }
            ?>

            <?php
            if (isset($_SESSION["invalid_username"])) {
            ?>
                <!-- to show error alert -->
                <p class="error-container error p_7-20">
                    <?php echo $_SESSION["invalid_username"]; ?>
                </p>
            <?php
                unset($_SESSION["invalid_username"]);
            }
            ?>

            <?php
            if (isset($_SESSION["username_already_exit"])) {
            ?>
                <!-- to show error alert -->
                <p class="error-container error p_7-20">
                    <?php echo $_SESSION["username_already_exit"]; ?>
                </p>
            <?php
                unset($_SESSION["username_already_exit"]);
            }
            ?>

            <?php
            if (isset($_SESSION["invalid_email"])) {
            ?>
                <!-- to show error alert -->
                <p class="error-container error p_7-20">
                    <?php echo $_SESSION["invalid_email"]; ?>
                </p>
            <?php
                unset($_SESSION["invalid_email"]);
            }
            ?>

            <?php
            if (isset($_SESSION["email_already_exit"])) {
            ?>
                <!-- to show error alert -->
                <p class="error-container error p_7-20">
                    <?php echo $_SESSION["email_already_exit"]; ?>
                </p>
            <?php
                unset($_SESSION["email_already_exit"]);
            }
            ?>

            <?php
            if (isset($_SESSION["invlaid_password"])) {
            ?>
                <!-- to show error alert -->
                <p class="error-container error p_7-20">
                    <?php echo $_SESSION["invlaid_password"]; ?>
                </p>
            <?php
                unset($_SESSION["invlaid_password"]);
            }
            ?>

            <?php
            if (isset($_SESSION["password_not_match"])) {
            ?>
                <!-- to show error alert -->
                <p class="error-container error p_7-20">
                    <?php echo $_SESSION["password_not_match"]; ?>
                </p>
            <?php
                unset($_SESSION["password_not_match"]);
            }
            ?>
            <?php
            if (isset($_SESSION["email"])) {


                echo $_SESSION["email"];
            }

            ?>
            <?php
            if (isset($_SESSION["otp-failed"])) {
            ?>
                <!-- to show error alert -->
                <p class="error-container error p_7-20">
                    <?php echo $_SESSION["otp-failed"]; ?>
                </p>

            <?php
                unset($_SESSION["otp-failed"]);
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
                <img src="../images/ic_eye-off.svg" alt="hide password" class="pointer password_toggle_btn">
            </div>
            <div class="text_field">
                <input type="password" class="no_bg no_outline password_input" placeholder="xxxxxxxxxx" name="confirm_password" required>
                <label>Confirm Password</label>
                <img src="../images/ic_eye-off.svg" alt="hide password" class="pointer password_toggle_btn">
            </div>
            <div>
                <input type="submit" class="button h-40 w-full no_outline border-curve-lg" name="register" value="Register">
            </div>
            <p>
                <?php
                if (isset($_SESSION['register-insert'])) {
                    echo $_SESSION['register-insert'];
                }
                ?>
            </p>
            <p class="text-center mt-20">
                Already have an account? <a href="./login.php"> <span class="cta">Sign in</span></a>
            </p>
        </form>
    </main>

</body>

</html>
<?php
session_unset();
?>