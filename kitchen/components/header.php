 <?php
    session_start();
    if (!isset($_SESSION['kitchen-success'])) {
        header('location: ../invalid.html');
    }
    ?>

 <header>
     <nav class="top_nav flex items-center">
         <div class="flex items-center">
             <a href="./index.php" class="logo heading flex items-center"><img src="../images/logo.png" alt="logo">Restro
                 <span>Hub</span>
             </a>
         </div>

         <h1 class="heading">Kitchen Department</h1>

         <ul class="flex items-center">

             <li>
                 <a href="#">
                     <img src="../images/ic_dark_mode.svg" class="dark-mode-icon" alt="toggle night mode">
                 </a>

             </li>

             <li>
                 <img src="../images/profile.jpg" alt="admin profile picture" class="admin_profile_image">

                 <ul class="admin_profile p-20 shadow border-curve-md">
                     <li>
                         <a href="./backend/logout.php">
                             <div class="flex items-center justify-start">
                                 <img class="admin_profile_icon" src="../images/ic_logout.svg" alt="logout icon" aria-hidden="true">
                                 <p>Logout</p>
                             </div>
                         </a>
                     </li>
                 </ul>
             </li>
         </ul>
     </nav>

 </header>