<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Are you hungry? You are at the right place. We offer mouth watering foods at your doorstep. Click now and order food online.">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <title>RestroHub | Order Food Online</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/responsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>

<body>

    <?php $noBackBtn = true;
    require("./components/header.php"); ?>

    <main class="user_main">

        <section class="hero border-curve" style="border: 1px solid #000">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower("meat lovers pizza")); ?>">
                            <img src="./images/restrohub offer banner.png" class="offer_img" alt="offer banner">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower("meat lovers pizza")); ?>">
                            <img src="./images/kharbuja ko juice.png" class="offer_img" alt="offer banner">
                        </a>
                    </div>
                </div>

                <div class="swiper-button-prev swiper-button"></div>
                <div class="swiper-button-next swiper-button"></div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <h2 class="heading our_special ml-auto mt-60">Our Special
            <hr class="underline ml-auto no_outline">
        </h2>

        <!-- cards container -->
        <div class="food_cards flex gap wrap justify-center">
            <?php
            require("./config.php");
            $sql = "SELECT * FROM food where special = 1 and disabled = 0";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="menu_food-card border-curve shadow">
                        <!-- testing badge or something for card -->
                        <p class="card__tag text-center heading"><?php if ($data['veg'] == 1)
                                                                        echo "Veg";
                                                                    else
                                                                        echo "Non-veg"; ?></p>

                        <div class="card__food-img">
                            <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($data['name'])); ?>">
                                <img src="./uploads/foods/<?php echo $data['img']; ?>" class="food_img w-full" alt="food item">
                            </a>
                        </div>
                        <article class="card__food-info flex items-center">
                            <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($data['name'])); ?>" class="card__food-name heading">
                                <h2 class="card__food-title heading"><?php echo $data['name']; ?></h2>
                            </a>
                            <p class="card__food-price heading">Rs. <?php echo $data['price']; ?></p>
                        </article>
                        <p class="card__food-desc"><?php echo $data['short_desc']; ?></p>
                        <div class="card__btns flex">
                            <div class="form mr-10">
                                <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($data['name'])); ?>" class="button card__btn flex justify-center border-curve" name="view"><img src="./images/ic_eye.svg" alt="view"></a>
                            </div>
                            <form action="#" method="post" class="form_food-card" name="form_food-card">
                                <input type="hidden" name="f_id" value="<?php echo $data['f_id']; ?>">
                                <button href="submit" class="button card__btn btn_add-to-cart flex justify-center border-curve" name="add-to-card"><img src="./images/ic_add-cart.svg" alt="add to cart"></button>
                            </form>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <!-- card end -->

        <h2 class="heading our_special ml-auto mt-60">Best Selling
            <hr class="underline ml-auto no_outline">
        </h2>

        <div class="food_cards flex gap wrap justify-center">
            <?php
            $sql_fetch_food = "select (count(f_id) * qty), f_id from orders inner join aos on orders.id = aos.order_id where aos.status = 'delivered' group by f_id order by (count(f_id) * qty) desc limit 4";
            $res_fetch_food = mysqli_query($conn, $sql_fetch_food);
            $count_fetch_food = mysqli_num_rows($res_fetch_food);
            while ($top_data = mysqli_fetch_assoc($res_fetch_food)) {
                $f_id = $top_data['f_id'];
                $sql_food = "SELECT * FROM food where f_id = $f_id";
                $res_food = mysqli_query($conn, $sql_food);
                $data = mysqli_fetch_assoc($res_food);
            ?>
                <div class="menu_food-card border-curve shadow">
                    <!-- testing badge or something for card -->
                    <p class="card__tag text-center heading"><?php if ($data['veg'] == 1)
                                                                    echo "Veg";
                                                                else
                                                                    echo "Non-veg"; ?></p>

                    <div class="card__food-img">
                        <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($data['name'])); ?>">
                            <img src="./uploads/foods/<?php echo $data['img']; ?>" class="food_img w-full" alt="food item">
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
                        <form action="#" method="post" class="form_food-card" name="form_food-card">
                            <input type="hidden" name="f_id" value="<?php echo $data['f_id']; ?>">
                            <button href="submit" class="button card__btn btn_add-to-cart flex justify-center border-curve" name="add-to-card"><img src="./images/ic_add-cart.svg" alt="add to cart"></button>
                        </form>
                    </div>
                </div>
            <?php
            }

            ?>
        </div>

        <a href="./menu.php">
            <div class="button w-fit border-curve mt-60 ml-auto">View All Foods </div>
        </a>

        <section class="newsletter mt-60">

            <div>
                <h2 class="newsletter-header heading">Subscribe to our newsletter</h2>
                <p class="newsletter-desc mt-20">Get the latest updates on our new foods and offers</p>
            </div>

            <form method="post" action="#" class="newsletter-form flex items-center mt-40">
                <div class="border-curve">
                    <input type="email" name="email" placeholder="Enter your email" class="newsletter-input border-curve no_bg no_outline" required>
                    <button type="submit" name="subscribe" class="newsletter-btn button border-curve">Subscribe</button>
                </div>
            </form>

        </section>

    </main>

    <?php require("./components/footer.php"); ?>
    <script type="module" src="./js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</body>

</html>