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
    <link rel="stylesheet" href="./styles/responsive.css">
</head>

<body>

    <?php require("./components/header.php"); ?>

    <!-- filter icon for small screen devices -->
    <img src="./images/ic_filter.svg" alt="filter icon" class="menu_filter_icon">

    <aside class="sidebar menu_sidebar shadow p_7-20">
        <h4 class="heading">Filter</h4>

        <!-- veg non-veg filter form -->
        <form action="./backend/veg-filter.php" method="post" class="veg_filter_form form flex direction-col mt-20">
            <div>
                <input type="radio" class="cbox-veg_nonveg" name="veg-filter" value="all" id="all" <?php if (isset($_SESSION['veg']) && $_SESSION['veg'] == "all") echo "checked"; ?>>
                <label for="all"> All</label>
            </div>
            <div>
                <input type="radio" class="cbox-veg_nonveg" name="veg-filter" value="veg" id="veg" <?php if (isset($_SESSION['veg']) && $_SESSION['veg'] == "veg") echo "checked"; ?>>
                <label for="veg"> Veg</label>
            </div>
            <div>
                <input type="radio" class="cbox-veg_nonveg" name="veg-filter" value="non-veg" id="non-veg" <?php if (isset($_SESSION['veg']) && $_SESSION['veg'] == "non-veg") echo "checked"; ?>>
                <label for="non-veg"> Non-veg</label>
            </div>
        </form>
    </aside>

    <main class="menu_container">

    <div class="menu_container_inner">

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
                ?>
                    <form action="./backend/category-filter.php" method="post" class="food_category">
                        <input type="hidden" name="cat-name" value="all">
                        <button class="text-center pointer no_bg no_outline" type="submit" name="category-filter">
                            <img src="./images/all.jpg" class="border-curve food_category-img" alt="all food">
                            <p class="food_category-name">All</p>
                        </button>
                    </form>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <form action="./backend/category-filter.php" method="post" class="food_category">
                            <input type="hidden" name="cat-name" value="<?php echo $row['cat_name']; ?>">
                            <button class="text-center pointer no_bg no_outline" type="submit" name="category-filter">
                                <img src="./uploads/category/<?php echo $row['image']; ?>" class="border-curve food_category-img" alt="food category">
                                <p class="food_category-name"><?php echo $row['cat_name']; ?></p>
                            </button>
                        </form>
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
            if (isset($_GET['search'])) {
                $searchKey = $_GET['search'];
                $sql = "SELECT * FROM food where name like '%$searchKey%'" . (isset($_SESSION['veg-int']) ? " and veg = '{$_SESSION['veg-int']}'" : "") . " order by f_id desc";
            } else {
                if (isset($_SESSION['cat_name']) && $_SESSION['cat_name'] !== "all") {
                    $sql = "SELECT cat_name FROM category where cat_name = '{$_SESSION['cat_name']}'";
                } else {
                    $sql = "SELECT cat_name FROM category";
                }
            }

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                if (!isset($_GET['search'])) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
                        <section class="menu_food-card-container mt-20 flex direction-col">
                            <?php
                            $sql_food = "SELECT * FROM food inner join category on food.category = category.cat_id where category.cat_name = '$row[cat_name]' and disabled = 0" . (isset($_SESSION['veg-int']) ? " and veg = '{$_SESSION['veg-int']}'" : "") . " order by food.f_id desc";
                            $res = mysqli_query($conn, $sql_food);
                            if (mysqli_num_rows($res) > 0) {
                            ?>
                                <h2 class="heading"><?php if (isset($row['cat_name']))
                                                        echo $row['cat_name'];
                                                    else
                                                        echo $searchKey; ?></h2>
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
                                                <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($data['name'])); ?>">
                                                    <img src="./uploads/foods/<?php echo $data['img']; ?>" alt="food image" class="border-curve food_img">
                                                </a>
                                            </div>
                                            <article class="card__food-info flex items-center">
                                                <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($data['name'])); ?>">
                                                    <h2 class="card__food-title heading"><?php echo $data['name']; ?></h2>
                                                </a>
                                                <p class="card__food-price heading">Rs. <?php echo $data['price']; ?></p>
                                            </article>
                                            <p class="card__food-desc"><?php echo $data['short_desc']; ?></p>
                                            <div class="card__btns flex">
                                                <div class="form mr-10">
                                                    <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($data['name'])); ?>" class="button card__btn flex justify-center border-curve" name="view"><img src="./images/ic_eye.svg" alt="view"></a>
                                                </div>
                                                <form action="./backend/add-to-cart.php" method="post" class="form_food-card" name="form_food-card">
                                                    <input type="hidden" name="f_id" value="<?php echo $data['f_id']; ?>">
                                                    <button type="button" class="button card__btn btn_add-to-cart flex justify-center border-curve" name="add-to-card"><img src="./images/ic_add-cart.svg" alt="add to cart"></button>
                                                </form>
                                            </div>
                                        </div>
                                <?php   }
                                }
                                ?>
                                </div>
                        </section>
                    <?php  }
                } else {
                    ?>
                    <section class="menu_food-card-container mt-20 flex direction-col">
                        <?php
                        $sql_food = "SELECT * FROM food where name like '%$searchKey%' and disabled = 0" . (isset($_SESSION['veg-int']) ? " and veg = '{$_SESSION['veg-int']}'" : "") . " order by f_id desc";
                        $res = mysqli_query($conn, $sql_food);
                        if (mysqli_num_rows($res) > 0) {
                        ?>
                            <h2 class="heading"><?php if (isset($row['cat_name']))
                                                    echo $row['cat_name'];
                                                else
                                                    echo $searchKey; ?></h2>
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
                                            <div class="form mr-10">
                                                <a href="./details.php?name=<?php echo $data['name']; ?>" class="button card__btn flex justify-center border-curve" name="view"><img src="./images/ic_eye.svg" alt="view"></a>
                                            </div>

                                            <form action="./backend/add-to-cart.php" method="post" class="form_food-card" name="form_food-card">
                                                <input type="hidden" name="f_id" value="<?php echo $data['f_id']; ?>">
                                                <button type="button" class="button card__btn btn_add-to-cart flex justify-center border-curve" name="add-to-card"><img src="./images/ic_add-cart.svg" alt="add to cart"></button>
                                            </form>
                                        </div>
                                    </div>
                            <?php   }
                            }
                            ?>
                            </div>
                    </section>
            <?php }
            } else
                echo "No food items found";
            ?>
        </div>
    </div>
        <?php require("./components/footer.php"); ?>
    </main>

    <script type="module" src="./js/app.js"></script>

</body>

</html>