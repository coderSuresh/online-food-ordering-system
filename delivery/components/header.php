 <header>
     <nav class="top_nav flex items-center">
         <div class="logo__back-btn flex items-center">
             <a href="./index.php" class="logo heading flex items-center"><img src="../images/logo.png" alt="logo">Restro
                 <span>Hub</span>
             </a>
         </div>

         <h2 class="heading">Delivery Department</h2>

         <ul class="flex items-center">

             <?php
                if (isset($_SESSION['delivery-username'])) {
                    $sql_get_img = "SELECT image FROM employees WHERE username = '{$_SESSION['delivery-username']}'";
                    $result_get_img = mysqli_query($conn, $sql_get_img);
                    $row_get_img = mysqli_fetch_assoc($result_get_img);
                    if ($row_get_img['image'] == "") {
                        $image = "../images/profile.jpg";
                    } else {
                        $image = "../uploads/employees/" . $row_get_img['image'];
                    }
                }
                ?>

             <li>
                 <img src="<?php echo $image; ?>" alt="admin profile picture" class="admin_profile_image">

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