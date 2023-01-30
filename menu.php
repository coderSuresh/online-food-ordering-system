<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Are you hungry? You are at the right place. We offer mouth watering foods at your doorstep. Click now and order food online.">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <title>Menu | RestroHub</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>

    <?php require("./components/header.php"); ?>

    <aside class="sidebar menu_sidebar shadow p_7-20">
        <h4 class="heading">Filter</h4>
        <!-- veg non-veg filter form -->
        <form action="#" method="post" class="form flex direction-col mt-20">
            <div>
                <input type="checkbox" name="all" value="all" id="all">
                <label for="all"> All</label>
            </div>
            <div>
                <input type="checkbox" name="veg" value="veg" id="veg">
                <label for="veg"> Veg</label>
            </div>
            <div>
                <input type="checkbox" name="non-veg" value="non-veg" id="non-veg">
                <label for="non-veg"> Non-veg</label>
            </div>
        </form>

        <!-- price range filter form -->
        <h4 class="mt-20 heading">Price range</h4>
        <form action="#" method="post" class="mt-20 price_filter_form">
            <div>
                <label for="from">From:</label>
                <input type="number" name="from" id="from" class="p_7-20">
            </div>

            <div>
                <label for="to">To:</label>
                <input type="number" name="to" id="to" class="p_7-20">
            </div>
            <button type="submit" class="button mt-20">Search</button>
        </form>

    </aside>

    <main class="menu_container">

        <button class="go_top no_bg no_outline"><img src="./images/ic_top.svg" alt="go to top"></button>

        <section class="food_categories">

            <div class="flex items-center">
                <h2 class="food_category-title heading"></h2>
                <button class="toggle_categories button"></button>
            </div>

            <div class="category_container mt-20 flex gap wrap justify-center">

                <!-- fetch categories from db -->
                <?php
                require("./config.php");
                $sql = "SELECT image, cat_name FROM category";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="food_category text-center">
                            <img src="./uploads/category/<?php echo $row['image']; ?>" class="food_category-img" alt="food category">
                            <p class="food_category-name"><?php echo $row['cat_name']; ?></p>
                        </div>
                <?php
                    }
                } else
                    echo "No categories found";
                ?>
            </div>
        </section>

        <div class="menu_food-card-category-container">

            <!-- fetch categories from db -->
            <?php
            $sql = "SELECT cat_name FROM category";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <section class="menu_food-card-container mt-20 flex direction-col">
                        <?php
                        $sql_food = "SELECT * FROM food inner join category on food.category = category.cat_id where category.cat_name = '$row[cat_name]' and disabled = 0";
                        $res = mysqli_query($conn, $sql_food);
                        if (mysqli_num_rows($res) > 0) {
                        ?>
                            <h2 class="heading"><?php echo $row['cat_name']; ?></h2>
                            <div class="food_cards mt-20 flex gap wrap justify-start">
                                <?php while ($data = mysqli_fetch_assoc($res)) {
                                ?>
                                    <div class="menu_food-card border-curve shadow">
                                        <!-- testing badge or something for card -->
                                        <p class="card__tag text-center heading">
                                            <?php
                                            if ($data['veg'] == 1)
                                                echo "Veg";
                                            else
                                                echo "Non-veg";
                                            ?>
                                        </p>

                                        <div class="card__food-img">
                                            <img src="./uploads/foods/<?php echo $data['img']; ?>" class="food_img w-full" alt="food">
                                        </div>
                                        <article class="card__food-info flex items-center">
                                            <h2 class="card__food-title heading"><?php echo $data['name']; ?></h2>
                                            <p class="card__food-price heading">Rs. <?php echo $data['price']; ?></p>
                                        </article>
                                        <p class="card__food-desc"><?php echo $data['short_desc']; ?></p>
                                        <div class="card__btns flex">
                                            <form action="./backend/details.php" class="mr-10" method="post">
                                                <input type="hidden" name="f_id" value="<?php echo $data['f_id']; ?>">
                                                <button type="submit" class="button card__btn flex justify-center border-curve" name="view"><img src="./images/ic_eye.svg" alt="view"></button>
                                            </form>

                                            <form action="#" method="post">
                                                <input type="hidden" name="f_id" value="<?php echo $data['f_id']; ?>">
                                                <button type="submit" class="button card__btn flex justify-center border-curve" name="add-to-card"><img src="./images/ic_add-cart.svg" alt="add to cart"></button>
                                            </form>
                                        </div>
                                    </div>

                            <?php   }
                            }
                            ?>
                            </div>
                    </section>

            <?php  }
            } else
                echo "No food items found";
            ?>
        </div>
        <?php require("./components/footer.php"); ?>
    </main>

    <script type="module" src="./js/app.js"></script>

</body>

</html>