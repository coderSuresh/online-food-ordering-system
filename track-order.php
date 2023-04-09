<?php
if (isset($_SESSION['order_placed'])) {
    echo $_SESSION['order_placed'];
    unset($_SESSION['order_placed']);
} else if (isset($_SESSION['order_success'])) {
    unset($_SESSION['order_success']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Are you hungry? You are at the right place. We offer mouth watering foods at your doorstep. Click now and order food online.">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <meta name="theme-color" content="#F7922F">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <title>Track Order | RestroHub</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/responsive.css">
</head>

<body>

    <?php
    require("./components/header.php"); ?>

    <main style="margin: 40px;">

        <button class="go_top no_bg no_outline"><img src="./images/ic_top.svg" alt="go to top"></button>

        <section class="mt-20 flex items-center gap wrap">
            <h1 class="heading">Track Order</h1>
            <form action="./track-order.php" method="get" class="search_form border-curve-lg">
                <div class="flex items-center">
                    <input type="search" placeholder="Track ID..." class="no_outline search" name="search" id="search">
                    <button type="submit" class="no_bg no_outline"><img src="./images/ic_search.svg" alt="search icon"></button>
                </div>
            </form>
        </section>

        <section class="p-20 mt-40 border-curve w-fit flex direction-col justify-center items-center ml-auto">
            <h2 class="text-center" style="letter-spacing: 2px">NO ORDERS</h2>
            <img src="./images/empty.png" alt="empty" width="300" class="empty_box ml-auto">
            <p class="text-center mt-20">You don't have any order in process.</p>
        </section>

        <?php require './components/top-selling-food.php'; ?>

    </main>

    <?php require("./components/footer.php"); ?>
    <script type="module" src="./js/app.js"></script>
</body>

</html>