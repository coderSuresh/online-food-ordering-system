 <?php session_start(); ?>
 <header>
     <nav class="top_nav flex items-center">
         <div class="logo__back-btn flex items-center">
             <!-- back btn -->
             <button class="nav__btn-back no_bg no_outline"><img src="./images/ic_back.svg" alt="go back"></button>
             <a href="./index.php" class="logo heading flex items-center"><img src="./images/logo.png" alt="logo">Restro
                 <span>Hub</span>
             </a>
         </div>

         <ul class="flex items-center">
             <li class="flex direction-col"><a href="menu.php">Menu</a></li>

             <!-- nav search form -->
             <li>
                 <form action="#" method="post" class="search_form flex items-center border-curve-lg">
                     <input type="search" name="search" placeholder="search..." id="search" class="search no_outline">
                     <button type="submit" class="btn_search no_outline no_bg"><img src="./images/ic_search.svg" alt="search icon" class="icon_search"></button>
                 </form>
             </li>

             <!-- show profile icon if the user is logged in -->
             <?php
                if (isset($_SESSION['success'])) {
                    echo '<li class="flex direction-col">
                            <img src="./images/logo.png" class="user_profile_icon" alt="account">
                            <div class="logout-dropdown border-curve shadow p-20">
                                <a href="./customer_auth/logout.php">Logout</a>   
                            </div>                         
                          </li>
                          ';
                } else {
                    echo '<li class="flex direction-col"><a href="./customer_auth/login.php"><img src="./images/ic_acc.svg" alt="account">
                    <span class="nav__tooltip shadow p-20">Login</span></a>';
                }
                ?>

             <li class="flex direction-col">
                 <button class="cart no_bg no_outline relative"><img src="./images/ic_cart.svg" alt="cart">
                     <?php
                        require('./config.php');
                        if (isset($_SESSION['user'])) {
                            $username = $_SESSION['user'];
                            $sql_uid = "select id from customer where username = '$username'";
                            $result_uid = mysqli_query($conn, $sql_uid);
                            $row_uid = mysqli_fetch_assoc($result_uid) or die(mysqli_error($conn));
                            $uid = $row_uid['id'];

                            $sql = "SELECT * FROM cart where customer_id = $uid";
                            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                            $count = mysqli_num_rows($result);

                            if ($count > 0) {
                                echo '<div class="count-top cart_count-top shadow">' . $count . '</div>';
                            }

                        ?>
                 </button>
             </li>
         </ul>
         <!-- cart drop down -->
         <div class="cart_dropdown border-curve shadow p-20">

             <?php
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $food_id = $row['food_id'];
                                    $cart_id = $row['id'];
                                    $quantity = $row['quantity'];
                                    $sql_food = "SELECT name,price,img FROM food where f_id = $food_id";
                                    $result_food = mysqli_query($conn, $sql_food) or die(mysqli_error($conn));
                                    $row_food = mysqli_fetch_assoc($result_food);
                                    $food_name = $row_food['name'];
                                    $food_price = $row_food['price'];
                                    $food_img = $row_food['img'];
                ?>
                     <div class="cart_content flex items-center">
                         <img src="./uploads/foods/<?php echo $food_img; ?>" class="cart_img" alt="food image">
                         <div class="flex items-center">
                             <div>
                                 <h3 class="title cart_title"><?php echo $food_name ?></h3>
                                 <div class="qty_container flex items-center">
                                     <button class="cart_item-btn no_outline shadow cart_inc">
                                         <img src="./images/ic_add.svg" alt="plus icon" class="cart_item-icon">
                                     </button>

                                     <p class="qty">Qty: <input class="cart_qty no_outline" value="<?php echo $quantity; ?>"></p>

                                     <button class="cart_item-btn no_outline shadow cart_dec">
                                         <img src="./images/ic_remove.svg" alt="minus icon" class="cart_item-icon">
                                     </button>
                                 </div>
                             </div>
                             <p class="cart_hidden-price"><?php echo $food_price; ?></p>
                             <p class="cart_price ml-35">Rs. <?php echo $food_price; ?></p>
                         </div>
                         <form action="./backend/remove-from-cart.php" class="cart_content-form" method="post">
                             <input type="hidden" name="id" value="<?php echo $cart_id; ?>">
                             <button type="submit" class="no_bg no_outline ml-35 btn_remove-from-cart"><img src="./images/ic_cross.svg" alt="remove from cart"></button>
                         </form>
                     </div>
                     <hr>
                 <?php
                                }
                    ?>
                 <div class="flex items-center mt-20">
                     <p class="cart_total">Total: Rs. 400</p>
                     <a href="#" class="button border-curve checkout-btn">Checkout</a>
                 </div>
         <?php
                            }
                        }
            ?>
         </div>

     </nav>

 </header>