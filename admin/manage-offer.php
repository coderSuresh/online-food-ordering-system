<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Offers | RestroHub</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="icon" href="../images/logo.png" type="image/x-icon">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>

</head>

<body>

    <?php

    // TODO: make this functional
    // show current offers
    // add new offer
    // delete offer
    // modify offer
    // maybe set a time limit for offer

    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Manage Offers</h2>
        </section>

        <?php

        require '../config.php';

        $sql = "SELECT name, f_id FROM food";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
        ?>
            <datalist id="food-list">
                <?php
                while ($foods = mysqli_fetch_assoc($result)) {
                ?>
                    <option class="food_option" data-id="<?php echo $foods['f_id']; ?>" value="<?php echo $foods['name'] ?>"><?php echo $foods['name']; ?></option>
                <?php }
                ?>
            </datalist>
        <?php
        } else {
            echo "<p class='mt-20'>No food available</p>";
        }
        ?>
        <div class="flex wrap gap justify-start" style="gap: 50px;">
            <div class="left">
                <div class="mt-20 div_food_search">
                    <input list="food-list" name="food" id="food" placeholder="Search Food" class="search_food_offer p_7-20 border-curve form_input" required>
                    <button type="submit" onclick="selectFood()" class="button no_bg no_outline border-curve p_7-20" id="search_food_offer">Search</button>
                </div>

                <?php
                if (isset($_GET['food'])) {
                    $foodId = $_GET['food'];

                    $sql = "SELECT * FROM food WHERE f_id = $foodId";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $food = mysqli_fetch_assoc($result);
                    }
                ?>

                    <div class="food_details mt-20 p-20 shadow border-curve w-fit">
                        <div class="food_details_img">
                            <img src="../uploads/foods/<?php echo $food['img']; ?>" class="border-curve" width="250px" height="160px" alt="food image">
                        </div>
                        <div class="food_details_info mt-20">
                            <h3><?php echo $food['name']; ?></h3>
                            <p class="food_details_price mt-20"><b>Original price:</b> Rs. <?php echo $food['price']; ?></p>
                            <p class="food_details_price"><b>Offer price:</b> Rs. <?php echo $food['price']; ?></p>
                        </div>
                    </div>

                <?php }
                ?>
            </div>

            <div class="top-right">
                <div class="mt-20 shadow p-20 w-fit border-curve">
                    <form action="./components/add-offer.php" method="POST" class="flex flex-col">
                        <input type="hidden" name="food_id" value="<?php echo $food['f_id']; ?>">
                        <div class="flex direction-col">
                            <h3>Offer</h3>
                            <div class="mt-20 w-fit">
                                <input type="file" name="offer-img" id="offer-img" class="form_input" required>
                                <input type="number" name="offer" id="offer" class="form_input border-curve p_7-20" placeholder="Enter offer in %" required>
                                <button type="submit" class="button no_bg no_outline border-curve p_7-20" id="add_offer">Add Offer</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bottom-right">
                    <div class="mt-20 shadow p-20 w-fit border-curve">
                        <img src="../images/kharbuja ko juice.png" width="300px" height="120px" alt="offer image">
                    </div>
                </div>
            </div>

        </div>

    </main>

    <script>
        function selectFood() {
            const foodInput = document.getElementById('food');
            const food = document.getElementById('food').value;
            const foodList = document.querySelectorAll('.food_option');

            if (foodInput.checkValidity()) {
                foodList.forEach((foodOption) => {
                    if (foodOption.value === food) {
                        const foodId = foodOption.getAttribute('data-id');
                        window.location.href = `./manage-offer.php?food=${foodId}`;
                    } else {
                        return
                    }
                })
            } else {
                foodInput.reportValidity();
            }
        }

        // press enter to select food instead of clicking on select button
        const foodInput = document.getElementById('food');
        foodInput.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("select_food_offer").click();
            }
        });
    </script>

</body>

</html>