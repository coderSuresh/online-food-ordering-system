 <?php if (isset($title)) { ?>
     <!DOCTYPE html>
     <html lang="en">

     <head>
         <meta charset="UTF-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <meta name="description" content="Are you hungry? You are at the right place. We offer mouth watering foods at your doorstep. Click now and order food online.">
         <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
         <meta name="theme-color" content="#F7922F">
         <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
         <title><?php echo $title; ?> | RestroHub</title>
         <link rel="stylesheet" href="./styles/style.css">
         <link rel="stylesheet" href="./styles/responsive.css">
     </head>
 <?php } else
        session_start(); ?>

 <body>
     <header>
         <nav class="top_nav flex items-center">
             <div class="logo__back-btn flex items-center">
                 <!-- back btn -->
                 <?php if (isset($noBackBtn) && $noBackBtn == true) {
                    } else {
                        echo '<button class="nav__btn-back no_bg no_outline"><img src="./images/ic_back.svg" alt="go back"></button>';
                    }
                    ?>
                 <a href="./" class="logo heading flex items-center"><img src="./images/logo.png" alt="logo">Restro
                     <span>Hub</span>
                 </a>
             </div>

             <ul class="flex items-center">
                 <li class="flex direction-col"><a href="menu.php">Menu</a></li>
                 <li class="flex direction-col"><a href="track-order.php" class="tmo">Track Order</a></li>

                 <!-- nav search form -->
                 <?php require './components/search-form.php'; ?>

                 <!-- show profile icon if the user is logged in -->
                 <?php
                    require './config.php';
                    if (isset($_SESSION['success'])) {
                        $sql = "SELECT * FROM customer WHERE id = '{$_SESSION['user']}'";
                        $result = mysqli_query($conn, $sql);
                        $row_header = mysqli_fetch_assoc($result);
                        $name = $row_header['names'];

                        if ($row_header['image'] != '') {
                            $profile_img = $row_header['image'];
                        } else {
                            $profile_img = '';
                    ?>
                         <p class="user_name"><?php echo $name; ?></p>

                     <?php
                        }
                        ?>
                     <li class="flex direction-col profile_img-container">
                         <img src="<?php echo $profile_img; ?>" class="user_profile_icon relative" alt="account">
                         <div class="logout-dropdown border-curve shadow p-20">
                             <a href="./customer_auth/logout.php">Logout</a>
                         </div>
                     </li>
                 <?php
                    } else {
                        echo '<li class="flex direction-col"><a href="./customer_auth/login.php"><img src="./images/ic_acc.svg" alt="account">
                    <span class="nav__tooltip shadow p-20">Login</span></a>';
                    }
                    ?>

                 <li class="flex direction-col">
                     <button class="cart no_bg no_outline relative"><img src="./images/ic_cart.svg" alt="cart">
                         <div class="count-top cart_count-top shadow"></div>
                     </button>
                 </li>
             </ul>
             <!-- cart drop down -->
             <div class="cart_dropdown border-curve shadow p-20">

             </div>

         </nav>

     </header>