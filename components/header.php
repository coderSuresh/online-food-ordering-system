 <?php session_start(); ?>
 <header>
     <nav class="top_nav flex items-center">
         <a href="./index.php" class="logo heading flex items-center"><img src="./images/logo.png" alt="logo">Restro
             <span>Hub</span></a>

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
                     <div class="count-top shadow">4</div>
                 </button>
             </li>
         </ul>
         <!-- cart drop down -->
         <div class="cart_dropdown border-curve shadow p-20">
             <!-- <p>Cart is empty</p> -->
             <div class="cart_content flex items-center">
                 <img src="./images/food.png" class="cart_img" alt="food image">
                 <div class="flex items-center">
                     <div>
                         <h3 class="title">Food Name</h3>
                         <div class="flex items-center">
                             <button class="cart_item-btn no_outline shadow cart_inc">
                                 <img src="./images/ic_add-yellow.svg" alt="plus icon" class="cart_item-icon">
                             </button>

                             <p class="qty">Qty: <input class="cart_qty no_outline" value="1"></p>

                             <button class="cart_item-btn no_outline shadow cart_dec">
                                 <img src="./images/ic_remove-yellow.svg" alt="minus icon" class="cart_item-icon">
                             </button>
                         </div>
                     </div>
                     <p class="price ml-35">Rs. 100</p>
                 </div>
                 <button class="no_bg no_outline ml-35"><img src="./images/ic_cross.svg" class="close_icon" alt="remove from cart"></button>
             </div>
             <hr>
              <div class="flex items-center mt-20">
                 <p class="total">Total: Rs. 400</p>
                 <a href="#" class="button border-curve checkout-btn">Checkout</a>
             </div>
     </nav>

 </header>