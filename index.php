<?php
session_start();
?>
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
</head>

<body>

    <header>
        <nav class="top_nav flex items-center">
            <a href="#" class="logo heading flex items-center"><img src="./images/logo.png" alt="logo">Restro
                <span>Hub</span></a>

            <ul class="flex items-center">
                <li class="flex direction-col"><a href="menu.html">Menu</a></li>

                <!-- nav search form -->
                <li>
                    <form action="#" method="post" class="search_form flex items-center border-curve-lg">
                        <input type="search" name="search" placeholder="search..." id="search" class="search no_outline">
                        <button type="submit" class="btn_search no_outline no_bg"><img src="./images/ic_search.svg" alt="search icon" class="icon_search"></button>
                    </form>
                </li>

                <li class="flex direction-col"><a href="./customer_auth/login.php"><img src="./images/ic_acc.svg" alt="account"></a>
                    <span class="nav__tooltip">Account</span>
                </li>
                <li class="flex direction-col"><a href="#"><img src="./images/ic_cart.svg" alt="cart"></a> <span class="nav__tooltip">Cart</span> </li>
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
        <div class="food_cards flex gap wrap justify-center">
            <div class="menu_food-card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center heading">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title heading">Chinese MoMo</h2>
                    <p class="card__food-price heading">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <div class="card__btns flex">
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_eye.svg" alt="view">
                    </a>
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_add-cart.svg" alt="add to cart">
                    </a>
                </div>
            </div>
            <div class="menu_food-card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center heading">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title heading">Chinese MoMo</h2>
                    <p class="card__food-price heading">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <div class="card__btns flex">
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_eye.svg" alt="view">
                    </a>
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_add-cart.svg" alt="add to cart">

                    </a>
                </div>
            </div>
            <div class="menu_food-card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center heading">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title heading">Chinese MoMo</h2>
                    <p class="card__food-price heading">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <div class="card__btns flex">
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_eye.svg" alt="view">
                    </a>
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_add-cart.svg" alt="add to cart">
                    </a>
                </div>
            </div>
            <div class="menu_food-card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center heading">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title heading">Chinese MoMo</h2>
                    <p class="card__food-price heading">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <div class="card__btns flex">
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_eye.svg" alt="view">
                    </a>
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_add-cart.svg" alt="add to cart">
                    </a>
                </div>
            </div>
            <div class="menu_food-card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center heading">veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title heading">Chinese MoMo</h2>
                    <p class="card__food-price heading">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <div class="card__btns flex">
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_eye.svg" alt="view">
                    </a>
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_add-cart.svg" alt="add to cart">
                    </a>
                </div>
            </div>

            <div class="menu_food-card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center heading">Non-veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title heading">Chicken Fried Burger</h2>
                    <p class="card__food-price heading">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <div class="card__btns flex">
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_eye.svg" alt="view">
                    </a>
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_add-cart.svg" alt="add to cart">
                    </a>
                </div>
            </div>
            <div class="menu_food-card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center heading">Non-veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title heading">Chicken Fried Burger</h2>
                    <p class="card__food-price heading">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <div class="card__btns flex">
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_eye.svg" alt="view">
                    </a>
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_add-cart.svg" alt="add to cart">
                    </a>
                </div>
            </div>
            <div class="menu_food-card border-curve shadow">
                <!-- testing badge or something for card -->
                <p class="card__tag text-center heading">Non-veg</p>

                <div class="card__food-img">
                    <img src="./images/food.png" class="food_img w-full" alt="food">
                </div>
                <article class="card__food-info flex items-center">
                    <h2 class="card__food-title heading">Chicken Fried Burger</h2>
                    <p class="card__food-price heading">Rs. 185</p>
                </article>
                <p class="card__food-desc">This is very delicious chinese momo full of corona virus.</p>
                <div class="card__btns flex">
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_eye.svg" alt="view">
                    </a>
                    <a href="#" class="card__btn flex justify-center border-curve">
                        <img src="./images/ic_add-cart.svg" alt="add to cart">
                    </a>
                </div>
            </div>
        </div>
        <!-- card end -->

        <div class="button w-fit border-curve mt-20 ml-auto">
            <a href="./menu.html">View All Foods</a>
        </div>
    </main>

    <footer class="footer">
        <section>
            <div class="footer_title">
                <h3 class="heading">Legal</h3>
                <hr class="underline no_outline">
            </div>
            <ul>
                <li><a href="#">Terms and conditions</a></li>
                <li><a href="#">Privacy policy</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </section>
        <section>
            <div class="footer_title">
                <h3 class="heading">Contact</h3>
                <hr class="underline no_outline">
            </div>
            <ul>
                <li>
                    <a href="#">
                        <div class="flex items-center justify-start">
                            <img src="./images/ic_call.svg" class="icon_with_text" alt="call icon">
                            <p>011-254565</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="flex items-center justify-start">
                            <img src="./images/ic_mail.svg" class="icon_with_text" alt="mail icon">
                            <p>customers@restrohub.com</p>
                        </div>
                    </a>
                </li>
            </ul>
        </section>

        <div class="footer_map">
            <img src="./images/img_map.jpg" alt="our location on map">
        </div>

        <div class="copyright">
            <p>Copyright &copy; <span class="footer_year"></span> Restrohub. All rights reserved.</p>
        </div>
        <div class="social">
            <a href="#" aria-label="our facebook">
                <img src="./images/ic_facebook_dark.svg" alt="facebook">
            </a>
            <a href="#" aria-label="our linkedin">
                <img src="./images/ic_linkedin.svg" alt="linkedin">
            </a>
            <a href="#" aria-label="our instagram">
                <img src="./images/ic_insta.svg" alt="instagram">
            </a>
        </div>
    </footer>

    <script type="module" src="./js/app.js"></script>
</body>

</html>
<?php
session_unset();
?>