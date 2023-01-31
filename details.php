<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Are you hungry? You are at the right place. We offer mouth watering foods at your doorstep. Click now and order food online.">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <title>Food Details | RestroHub</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>

    <?php require('./components/header.php'); ?>
    <main class="main">

        <?php
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
        ?>

        <section class="details_container flex justify-center">
            <div class="details_img-container">
                <img src="./uploads/foods/<?php echo $row['img']; ?>" class="details_img border-curve-md" alt="food image">
            </div>

            <section class="details_right-container">

                <p class="details_category"><?php echo $category; ?></p>
                <h1 class="details_title heading"><?php echo $row['name']; ?></h1>
                <p class="details_short-desc mt-20"><?php echo $row['short_desc']; ?></p>
                <p class="details_price mt-20"><b>Rs. <?php echo $row['price']; ?></b></p>

                <div class="details_add-to-cart flex items-center justify-start">
                    <div class="details_quantity-container flex items-center justify-center mt-20">
                        <button class="details_quantity-btn-dec button gray border-curve"><img src="./images/ic_remove-yellow.svg" alt="decrement"></button>
                        <input type="text" class="details_quantity p-20 no_outline text-center" value="1">
                        <button class="details_quantity-btn-inc button gray border-curve"><img src="./images/ic_add-yellow.svg" alt="increment"></button>
                    </div>
                    <button class="button btn_add-to-cart border-curve mt-20 ml-35">Add to Cart</button>
                </div>
                <button class="button border-curve mt-20">Buy now</button>
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