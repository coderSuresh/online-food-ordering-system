<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#F7922F">
  <title>FAQ | RestroHub</title>
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="./styles/responsive.css">

</head>

<body>

  <?php require("./components/header.php"); ?>

  <main class="faq">

    <button class="go_top no_bg no_outline"><img src="./images/ic_top.svg" alt="go to top"></button>

    <h1 class="heading mt-20">FAQs</h1>

    <section class="question mt-20 open">
      <h2>Does this system prepare food itself?</h2>
      <p class="answer">
        Yes. It is a food ordering and delivery system for our own restaurant.
      </p>
    </section>

    <section class="question mt-20">
      <h2>To which location do you deliver?</h2>
      <p class="answer">
        We deliever to any location inside kathmandu valley.
      </p>
    </section>

    <section class="question mt-20">
      <h2>Do you charge more for the food than in the restaurant?</h2>
      <p class="answer">
        No. The price in our online menu is exactly the same as the table menu price of the respective member
        restaurants.
      </p>
    </section>

    <section class="question mt-20">
      <h2> Do you guarantee the quality for food?</h2>
      <p class="answer">
        Yes, we guarantee the quality for food.
      </p>
    </section>

    <section class="question mt-20">
      <h2> Can I cancel my order if needed?</h2>
      <p class="answer">
        You can. However, you need to inform us over the phone on time. If the ordered food is already prepared
        by the
        restaurant, you cannot cancel the order.
      </p>
    </section>

    <section class="question mt-20">
      <h2> What are your service hours?</h2>
      <p class="answer">
        For the time being, our service operates from 10:00 am and we take orders till 9:00 pm.
      </p>
    </section>

    <?php require './components/top-selling-food.php'; ?>

  </main>

  <?php require("./components/footer.php"); ?>

  <script type="module" src="./js/app.js"></script>
</body>

</html>