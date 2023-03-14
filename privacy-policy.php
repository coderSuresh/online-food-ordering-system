<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Privacy Policy | RestroHub</title>
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="./styles/responsive.css">
  <script src="./js/app.js" defer></script>
</head>

<body>

  <?php require("./components/header.php"); ?>

  <main class="flex privacy_page justify-center">
    
    <button class="go_top no_bg no_outline"><img src="./images/ic_top.svg" alt="go to top"></button>

    <section class="privacy_container">
      <h1 class="heading yellow-text">Privacy Policy</h1>
      <section class="section mt-20">
        <h2>Introduction</h2>
        <p class="justify-text">
          This privacy policy outlines how we collect, use, and protect the personal information of our users. By using
          our website or services, you agree to the terms outlined in this policy.
        </p>
      </section>

      <section class="section mt-20">
        <h2>Information Collection and Use</h2>
        <p class="justify-text">
          We may collect information such as your name, email address, and other contact information when you sign up for
          our services or communicate with us through our website. We may also collect information about your use of our
          services and website, including but not limited to your browsing behavior and search history.
        </p>
        <p class="justify-text">
          This information is used to improve the services we provide and to communicate with you. We may also use this
          information to provide you with targeted foods that may be of interest to you.
        </p>
      </section>

      <section class="section mt-20">
        <h2>Data Retention and Security</h2>
        <p class="justify-text">
          We take appropriate measures to protect the personal information we collect, including using encryption and
          other security technologies. However, no method of transmission over the Internet or electronic storage is 100%
          secure. As such, we cannot guarantee the absolute security of your personal information.
        </p>
        <p class="justify-text">
          We retain personal information for as long as necessary to provide our services and fulfill the purposes
          outlined in this privacy policy. When it is no longer necessary to retain personal information, we will securely
          delete it.
        </p>
      </section>

      <section class="section mt-20 mb-40">
        <h2>Changes to this Privacy Policy</h2>
        <p class="justify-text">
          We may update this privacy policy from time to time. If we make any material changes to this policy, we will
          notify you either through the email address you have provided or by placing a prominent notice on our website.
        </p>
      </section>
    </section>

    <section class="top-foods ml-35">
      <div class="flex items-center">
        <h2 class="heading yellow-text text-center w-full">Our Special</h2>
      </div>
      <!-- cards container -->
      <div class="food_cards mt-20 flex gap wrap justify-center">

        <?php
        include('./config.php');
        $sql = "SELECT * FROM food where special = 1 and disabled = 0 limit 2";
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