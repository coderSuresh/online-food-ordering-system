<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Are you hungry? You are at the right place. We offer mouth watering foods at your doorstep. Click now and order food online.">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <title>RestroHub | Order Food Online</title>
    <link rel="stylesheet" href="./styles/style.css">
    <script src="./js/app.js" defer></script>
</head>

<body>

    <header>
        <nav class="top_nav flex items-center">
            <a href="./index.html" class="logo heading flex items-center"><img src="./images/logo.png" alt="logo">Restro
                <span>Hub</span></a>

            <ul class="flex items-center">
                <li class="flex direction-col"><a href="menu.html">Menu</a></li>

                <!-- nav search form -->
                <li>
                    <form action="#" method="post" class="search_form flex items-center border-curve-lg">
                        <input type="search" name="search" placeholder="search..." id="search"
                            class="search no_outline">
                        <button type="submit" class="btn_search no_outline no_bg"><img src="./images/ic_search.svg"
                                alt="search icon" class="icon_search"></button>
                    </form>
                </li>

                <li class="flex direction-col"><a href="./php/customer_auth/login.php"><img src="./images/ic_acc.svg" alt="account"></a>
                    <span class="nav__tooltip">Account</span> </li>
                <li class="flex direction-col"><a href="#"><img src="./images/ic_cart.svg" alt="cart"></a> <span
                        class="nav__tooltip">Cart</span> </li>
            </ul>
        </nav>

    </header>

    <main class="main">

        <section class="hero">
            <!-- TODO: slider/banner goes here -->
        </section>

        <h1 class="heading our_special ml-auto">Our Special
            <hr class="underline ml-auto no_outline">
        </h1>

        <!-- cards container -->
        <section class="card__container flex wrap gap justify-center">

            <!-- card start -->
            <article class="food_card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title">Chinese MoMo</h2>
                    <p class="card__food-price">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <article class="card__btns flex items-center">
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_eye.svg"
                            alt="view">View</a>
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_add-cart.svg"
                            alt="add to cart">Add to Cart</a>
                </article>
            </article>
            <article class="food_card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title">Chinese MoMo</h2>
                    <p class="card__food-price">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <article class="card__btns flex items-center">
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_eye.svg"
                            alt="view">View</a>
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_add-cart.svg"
                            alt="add to cart">Add to Cart</a>
                </article>
            </article>
            <article class="food_card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title">Chinese MoMo</h2>
                    <p class="card__food-price">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <article class="card__btns flex items-center">
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_eye.svg"
                            alt="view">View</a>
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_add-cart.svg"
                            alt="add to cart">Add to Cart</a>
                </article>
            </article>
            <article class="food_card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title">Chinese MoMo</h2>
                    <p class="card__food-price">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <article class="card__btns flex items-center">
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_eye.svg"
                            alt="view">View</a>
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_add-cart.svg"
                            alt="add to cart">Add to Cart</a>
                </article>
            </article>
            <article class="food_card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title">Chinese MoMo</h2>
                    <p class="card__food-price">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <article class="card__btns flex items-center">
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_eye.svg"
                            alt="view">View</a>
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_add-cart.svg"
                            alt="add to cart">Add to Cart</a>
                </article>
            </article>
            <article class="food_card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title">Chinese MoMo</h2>
                    <p class="card__food-price">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <article class="card__btns flex items-center">
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_eye.svg"
                            alt="view">View</a>
                    <a href="#" class="card__btn border-curve flex items-center"><img src="./images/ic_add-cart.svg"
                            alt="add to cart">Add to Cart</a>
                </article>
            </article>
            <!-- card end -->

        </section>

    </main>

</body>

</html>
<?php
session_unset();
?>