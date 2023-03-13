<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ | RestroHub</title>
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="./styles/style.css">
</head>

<body>

  <?php require("./components/header.php"); ?>

  <main class="faq">
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

    <section class="mt-60">
      <div class="flex items-center">
        <h2 class="heading yellow-text">Top Selling Foods</h2>
        <a href="./menu.php" class="button gray border-curve">View All</a>
      </div>
      <!-- cards container -->
      <div class="food_cards mt-20 flex gap wrap justify-center">

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

  </main>

  <?php require("./components/footer.php"); ?>

  <script type="module" src="./js/app.js"></script>
</body>

</html>