<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F7922F">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Not Found</title>

    <style>
        .err_h1 {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.2em;
        }

        .err_img {
            height: auto;
            margin: -40px 0;
            z-index: -1;
        }

        .err_p {
            width: 80%;
            max-width: 500px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <?php require './components/header.php'; ?>

    <main class="flex direction-col items-center justify-center">
        <h1 class="yellow-text err_h1 mt-40">Not Found</h1>
        <img src="./images/lost.gif" width="400" class="err_img" alt="page not found">
        <p class="text-center err_p">Uh oh! It seems like you've landed on a page that's currently on vacation or enjoying an extended coffee break. We are trying to calling it back</p>
        <a href="./index.php" class="button border-curve mt-20">Go Home</a>
    </main>

    <?php require './components/footer.php'; ?>
    <script src="./js/app.js" type="module"></script>
</body>

</html>