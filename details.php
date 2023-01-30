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

        <section class="details_container flex justify-center">
            <div class="details_img-container">
                <img src="./images/food.png" class="details_img border-curve-md" alt="food image">
            </div>

            <section class="details_right-container">
                <p class="details_category">Burger</p>
                <h1 class="details_title heading">Cheese Burger</h1>
                <p class="details_short-desc mt-20">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Quisquam,
                    quod.</p>
                <p class="details_price mt-20"><b>Rs. 200</b></p>

                <div class="details_add-to-cart flex items-center justify-start">
                    <div class="details_quantity-container flex items-center justify-center mt-20">
                        <button class="details_quantity-btn-dec button gray border-curve"><img src="./images/ic_remove-yellow.svg" alt="decrement"></button>
                        <input type="text" min="1" max="10" class="details_quantity p-20 no_outline text-center" value="1">
                        <button class="details_quantity-btn-inc button gray border-curve"><img src="./images/ic_add-yellow.svg" alt="increment"></button>
                    </div>
                    <button class="button border-curve mt-20 ml-35">Add to Cart</button>
                </div>
            </section>
        </section>

        <section class="details_description">
            <h2 class="description heading">Description</h2>
            <p class="mt-20">
                These dumplings are packed with healthy veggies like carrots and cabbage sauteed with onion, garlic, soya sauce, vinegar and black pepper. The perfect homemade vegetarian snack to serve for evening snacks.
            </p>
            <h3 class="heading mt-20">Ingredients</h3>
            <ul class="mt-20">
                <li>Maida</li>
                <li>Salt</li>
                <li>Baking powderFor filling</li>
                <li>Carrot, grated</li>
                <li>Cabbage, grated</li>
                <li>Oil</li>
                <li>Onion, finely chopped</li>
                <li>Garlic, chopped</li>
                <li>Soya sauceto taste Salt</li>
                <li>Vinegar</li>
                <li>Black pepper</li>
            </ul>
        </section>
    </main>

    <?php require('./components/footer.php'); ?>

    <script type="module" src="./js/app.js"></script>
</body>

</html>