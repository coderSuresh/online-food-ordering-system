 <?php
    session_start();
    if (!isset($_SESSION['admin-success'])) {
        header('location: ../../invalid.html');
    }
    ?>

 <header>
     <nav class="top_nav flex items-center">
         <div class="flex items-center">
             <a href="../index.php" class="logo heading flex items-center"><img src="../../images/logo.png" alt="logo">Restro
                 <span>Hub</span>
             </a>

             <div class="menu__for-sidebar ml-35">
                 <div class="bar bar1"></div>
                 <div class="bar bar2"></div>
                 <div class="bar bar3"></div>
             </div>
         </div>

         <h1 class="heading">Admin Department</h1>

         <ul class="flex items-center">

             <li>
                 <a href="#">
                     <img src="../../images/ic_dark_mode.svg" class="dark-mode-icon" alt="toggle night mode">
                 </a>
             </li>

             <li>
                 <img src="../../images/profile.jpg" alt="admin profile picture" class="admin_profile_image">

                 <ul class="admin_profile p-20 shadow border-curve-md">
                     <li>
                         <div class="admin_profile_info flex items-center">
                             <img src="../../images/profile.jpg" class="admin_profile_img" alt="admin profile picture" aria-hidden="true">
                             <div>
                                 <h4>Admin Kumar</h4>
                                 <p class="body-text">adminkumar@yandex.ru</p>
                             </div>
                         </div>
                     </li>
                     <li>
                         <hr class="no_outline">
                     </li>
                     <li>
                         <a href="#">
                             <div class="flex items-center justify-start">
                                 <img class="admin_profile_icon" alt="manage account" src="../../images/ic_manage_account.svg" aria-hidden="true">
                                 <p>Manage account</p>
                             </div>
                         </a>
                     </li>
                     <li>
                         <a href="../logout.php">
                             <div class="flex items-center justify-start">
                                 <img class="admin_profile_icon" src="../../images/ic_logout.svg" alt="logout icon" aria-hidden="true">
                                 <p>Logout</p>
                             </div>
                         </a>
                     </li>
                 </ul>
             </li>
         </ul>
     </nav>

 </header>