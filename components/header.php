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
                 <li class="flex direction-col relative">
                     <button class="tmo no_bg no_outline">Track Order</button>
                     <?php
                        require './config.php';
                        if (isset($_SESSION['success'])) {
                            $user_id = $_SESSION['user'];
                            $sql = "SELECT * FROM orders WHERE c_id = $user_id GROUP BY track_id ORDER BY id DESC LIMIT 5";
                            $result = mysqli_query($conn, $sql);
                        ?>
                         <div class="track_dropdown shadow p-20 border-curve">
                             <div class="recent_orders">
                                 <h3>Recent Orders</h3>
                                 <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $track_id = $row['track_id'];
                                    ?>
                                         <a href="./track-order.php?id=<?php echo strtolower($track_id) ?>"><?php echo strtoupper($track_id); ?></a>
                                     <?php }
                                        ?>
                             </div>
                             <form action="./track-order.php" method="get">
                                 <input type="text" name="id" class="p_7-20 border-curve" id="id" placeholder="Order ID" required>
                                 <button type="submit" class="button mt-10 border-curve w-full">Track</button>
                             </form>
                             <a href="./track-order.php#history" class="view_all w-full text-center button gray border-curve">View all orders</a>
                         </div>
                 <?php }
                                } else {
                                    echo '<p class="text-center">No recent orders</p>';
                                }
                    ?>
                 </li>

                 <!-- nav search form -->
                 <?php require './components/search-form.php'; ?>

                 <!-- show profile icon if the user is logged in -->
                 <?php
                    if (isset($_SESSION['success'])) {
                        $sql = "SELECT names FROM customer WHERE id = '{$_SESSION['user']}'";
                        $result = mysqli_query($conn, $sql);
                        $row_header = mysqli_fetch_assoc($result);
                        $name = $row_header['names'];
                    ?>
                     <p class=" user_name"><?php echo $name; ?></p>

                     <li class="flex direction-col profile_img-container">
                         <img src="" class="user_profile_icon relative" alt="account">
                         <div class="logout-dropdown border-curve shadow p-20">
                             <p><?php echo $name; ?></p>
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