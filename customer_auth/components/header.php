 <?php session_start(); ?>
 <header>
     <nav class="top_nav flex items-center">
         <div class="logo__back-btn flex items-center">
             <!-- back btn -->
             <button class="nav__btn-back no_bg no_outline"><img src="../images/ic_back.svg" alt="go back"></button>
             <a href="../index.php" class="logo heading flex items-center"><img src="../images/logo.png" alt="logo">Restro
                 <span>Hub</span>
             </a>
         </div>

         <ul class="flex items-center">
             <li class="flex direction-col"><a href="menu.php">Menu</a></li>

             <!-- nav search form -->
             <li>
                 <form action="#" method="post" class="search_form flex items-center border-curve-lg">
                     <input type="search" name="search" placeholder="search..." id="search" class="search no_outline">
                     <button type="submit" class="btn_search no_outline no_bg"><img src="../images/ic_search.svg" alt="search icon" class="icon_search"></button>
                 </form>
             </li>

             <!-- show profile icon if the user is logged in -->
             <?php
                if (isset($_SESSION['success'])) {
                    echo '<li class="flex direction-col">
                            <img src="../images/logo.png" class="user_profile_icon" alt="account">
                            <div class="logout-dropdown border-curve shadow p-20">
                                <a href="../customer_auth/logout.php">Logout</a>   
                            </div>                         
                          </li>
                          ';
                } else {
                    echo '<li class="flex direction-col"><a href="../customer_auth/login.php"><img src="../images/ic_acc.svg" alt="account">
                    <span class="nav__tooltip shadow p-20">Login</span></a>';
                }
                ?>

             <li class="flex direction-col"><img src="../images/ic_cart.svg" alt="cart">
             </li>
         </ul>
         <!-- cart drop down -->
         <div class="cart_dropdown border-curve shadow p-20">

         </div>

     </nav>

 </header>