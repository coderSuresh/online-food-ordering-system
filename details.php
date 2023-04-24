<?php
session_start();
require('./config.php');

if (isset($_GET['name'])) {
    $raw_name = mysqli_real_escape_string($conn, $_GET['name']);
    $name = mysqli_real_escape_string($conn, str_replace('-', ' ', $raw_name));
    $sql = "select * from food where name = '$name'";
    $res = mysqli_query($conn, $sql) or die("could not fetch from database");
    $row = mysqli_fetch_assoc($res);

    if ($row <= 0) {
        header("Location: ./invalid.html");
    }

    $cat_id = $row['category'];

    $sql_cat = "select cat_name from category where cat_id = $cat_id";
    $res_cat = mysqli_query($conn, $sql_cat) or die("could not fetch from database");
    $data = mysqli_fetch_assoc($res_cat);

    $category = $data['cat_name'];

    $title = $row['name'];
    $short_desc = $row['short_desc'];
    $price = $row['price'];
    $img = $row['img'];
    $f_id = $row['f_id'];
    $desc = $row['description'];
    $cooking_time = $row['cooking_time'];
    $ingredients = $row['ingredients'];

    require('./components/header.php');
?>
    <main class="details_main">

        <button class="go_top no_bg no_outline"><img src="./images/ic_top.svg" alt="go to top"></button>

        <section class="details_container flex justify-center">
            <div class="details_img-container">
                <img src="./uploads/foods/<?php echo $img; ?>" class="details_img border-curve-md" alt="food image">
            </div>

            <section class="details_right-container">

                <p class="details_category"><?php echo $category; ?></p>
                <h1 class="details_title heading"><?php echo $title; ?></h1>
                <p class="details_short-desc mt-20"><?php echo $short_desc; ?></p>
                <p class="details_price mt-20"><b>Rs. <?php echo $price; ?></b></p>

                <div class="details_add-to-cart">
                    <form action="./backend/add-to-cart.php" method="post" class="form_food-card flex items-center justify-start" name="form_food-card">
                        <div class="details_quantity-container flex items-center justify-center mt-20">
                            <button type="button" class="no_bg no_outline details_quantity-btn-dec">
                                <img src="./images/ic_remove-yellow.svg" alt="decrement">
                            </button>
                            <input type="text" class="details_quantity p-20 no_outline text-center" value="1">
                            <button type="button" class="no_bg no_outline details_quantity-btn-inc">
                                <img src=" ./images/ic_add-yellow.svg" alt="increment">
                            </button>
                        </div>
                        <input type="hidden" name="f_id" value="<?php echo $f_id; ?>">
                        <button class="button gray btn_add-to-cart details border-curve mt-20 ml-35" style="outline: 2px solid #F7922F">Add to Cart</button>
                    </form>
                </div>

                <form action="./buy.php" method="post">
                    <input type="hidden" class="buy_qty" name="quantity" value="1">
                    <input type="hidden" name="f_id" value="<?php echo $f_id; ?>">
                    <button class="button btn_buy-now border-curve mt-20" name="buy-now">Buy now</button>
                </form>

            </section>
        </section>

        <section class="details_description">
            <h2 class="description heading">Description</h2>
            <p class="mt-20">Cooking time: <?php echo $cooking_time; ?> Minute</p>
            <p class="mt-20" style="text-align: justify;">
                <?php echo $desc; ?>
            </p>
            <h3 class="heading mt-20">Ingredients</h3>
            <pre class="ingredients-font mt-20"><?php echo $ingredients; ?></pre>
        </section>

        <section class="similar-foods mt-60">
            <h2 class="heading our_special ml-auto">Foods You May Like
                <hr class="underline ml-auto no_outline">
            </h2>

            <div class="food_cards flex gap wrap justify-center p-20">
                <?php
                $sql_food = "select * from food where category = $cat_id and name not in ('{$title}') order by f_id desc limit 4";
                $res_food = mysqli_query($conn, $sql_food);
                while ($data = mysqli_fetch_assoc($res_food)) {
                ?>
                    <div class="menu_food-card border-curve shadow">
                        <p class="card__tag text-center heading"><?php if ($data['veg'] == 1)
                                                                        echo "Veg";
                                                                    else
                                                                        echo "Non-veg"; ?></p>

                        <div class="card__food-img">
                            <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($data['name'])); ?>">
                                <img src="./uploads/foods/<?php echo $data['img']; ?>" alt="food image" class="border-curve food_img">
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

                ?>
            </div>
        </section>

    </main>

    <?php
    require('./components/footer.php');
    ?>
    <script type="module" src="./js/app.js"></script>
    </body>

    </html>
<?php } else {
    echo "Something went wrong! Please go back and try again.";
    echo " <a href='./menu.php'>Go back</a>";
}
?>