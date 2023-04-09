<section class="mt-60">
    <div class="">
        <h2 class="heading yellow-text text-center">Top Selling Foods</h2>
    </div>
    <!-- cards container -->
    <div class="food_cards mt-20 w-fit ml-auto flex gap wrap">

        <?php
        include('./config.php');
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
                    </div>
                    <article class="card__food-info flex items-center">
                        <h2 class="card__food-title heading"><?php echo $data['name']; ?></h2>
                        <p class="card__food-price heading">Rs. <?php echo $data['price']; ?></p>
                    </article>
                    <p class="card__food-desc"><?php echo $data['short_desc']; ?></p>
                    <div class="card__btns flex">
                        <div class="form mr-10">
                            <a href="./details.php?name=<?php echo str_replace(" ", "-", strtolower($data['name'])); ?>" class="button card__btn flex justify-center border-curve" name="view"><img src="./images/ic_eye.svg" alt="view"></a>
                        </div>

                        <form action="#" method="post" class="form_food-card" name="form_food-card">
                            <input type="hidden" name="f_id" value="<?php echo $data['f_id']; ?>">
                            <button type="submit" class="button card__btn btn_add-to-cart flex justify-center border-curve" name="add-to-card"><img src="./images/ic_add-cart.svg" alt="add to cart"></button>
                        </form>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <!-- card end -->
</section>