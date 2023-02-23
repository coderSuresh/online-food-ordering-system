<body>
    <?php
    session_start();
    require('./config.php');
    if (isset($_SESSION['details-id'])) {
        $id = $_SESSION['details-id'];
    }

    $sql = "select * from food where f_id = $id";
    $res = mysqli_query($conn, $sql) or die("could not fetch from database");

    $row = mysqli_fetch_assoc($res);

    $cat_id = $row['category'];

    $sql_cat = "select cat_name from category where cat_id = $cat_id";
    $res_cat = mysqli_query($conn, $sql_cat) or die("could not fetch from database");
    $data = mysqli_fetch_assoc($res_cat);

    $category = $data['cat_name'];
    $title = $row['name'];
    ?>

    <?php require('./components/header.php'); ?>
    <main class="details_main">

        <section class="details_container flex justify-center">
            <div class="details_img-container">
                <img src="./uploads/foods/<?php echo $row['img']; ?>" class="details_img border-curve-md" alt="food image">
            </div>

            <section class="details_right-container">

                <p class="details_category"><?php echo $category; ?></p>
                <h1 class="details_title heading"><?php echo $row['name']; ?></h1>
                <p class="details_short-desc mt-20"><?php echo $row['short_desc']; ?></p>
                <p class="mt-20">Cooking time: <?php echo $row['cooking_time']; ?> Minute</p>
                <p class="details_price mt-20"><b>Rs. <?php echo $row['price']; ?></b></p>

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
                        <input type="hidden" name="f_id" value="<?php echo $row['f_id']; ?>">
                        <button class="button gray btn_add-to-cart details border-curve mt-20 ml-35" style="outline: 2px solid #F7922F">Add to Cart</button>
                    </form>
                </div>

                <form action="./buy.php" method="post">
                    <input type="hidden" class="buy_qty" name="quantity" value="1">
                    <input type="hidden" name="f_id" value="<?php echo $row['f_id']; ?>">
                    <button class="button btn_buy-now border-curve mt-20" name="buy-now">Buy now</button>
                </form>

            </section>
        </section>

        <section class="details_description">
            <h2 class="description heading">Description</h2>
            <p class="mt-20">
                <?php echo $row['description']; ?>
            </p>
            <h3 class="heading mt-20">Ingredients</h3>
            <pre class="ingredients-font mt-20"><?php echo $row['ingredients']; ?></pre>
        </section>
    </main>

    <?php require('./components/footer.php'); ?>

    <script type="module" src="./js/app.js"></script>
</body>

</html>