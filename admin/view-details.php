<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Details | RestroHub</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>
</head>

<body>

    <?php
    require './components/header.php';
    require './components/sidebar.php';
    ?>

    <main class="admin_dashboard_body">
        <section class="dashboard_inner-head flex items-center">
            <h2 class="heading">View Order Details</h2>
        </section>
        <div class="vod_container flex gap wrap justify-center p-20">
            <div class="vod_left shadow p-20 border-curve">
                <div class="vod_left-head w-fit">
                    <h3>Order Details</h3>
                    <hr class="underline">
                </div>
                <div class="vod_left-body mt-20">
                    <div class="vod_left-body-inner">
                        <div class="vod_left-body-inner-content">
                            <table class="table_order-details">
                                <tr>
                                    <td>Order Date</td>
                                    <td>:</td>
                                    <td>12/12/2021</td>
                                </tr>
                                <tr>
                                    <td>Order Status</td>
                                    <td>:</td>
                                    <td>Delivered</td>
                                </tr>
                                <tr>
                                    <td>Order Total</td>
                                    <td>:</td>
                                    <td>Rs. 1000</td>
                                </tr>
                                <tr>
                                    <td>Payment Method</td>
                                    <td>:</td>
                                    <td>COD</td>
                                </tr>
                                <tr>
                                    <td>Note</td>
                                    <td>:</td>
                                    <td>No note</td>
                                </tr>
                                <tr>
                                    <td>Reject Reason</td>
                                    <td>:</td>
                                    <td>Just for testing purpose nothing else.</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="vod_right shadow p-20 border-curve">
                <div class="vod_right-head w-fit">
                    <h3>Customer Details</h3>
                    <hr class="underline">
                </div>
                <div class="vod_right-body mt-20">
                    <div class="vod_right-body-inner">
                        <div class="vod_right-body-inner-content">
                            <table class="table_order-details">
                                <tr>
                                    <td>Customer's Name</td>
                                    <td>:</td>
                                    <td>John Doe</td>
                                </tr>
                                <tr>
                                    <td>Receiver's Name</td>
                                    <td>:</td>
                                    <td>John the Don</td>
                                </tr>
                                <tr>
                                    <td>Customer's Email</td>
                                    <td>:</td>
                                    <td>
                                        <a href="mailto:customer@gmail.com">
                                            <div class="w-fit">
                                                customer@gmail.com
                                                <hr>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Receiver's Contact</td>
                                    <td>:</td>
                                    <td>
                                        <a href="tel:1234567890">
                                            <div class="w-fit">1234567890
                                                <hr>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shipping Address</td>
                                    <td>:</td>
                                    <td>123, ABC Street, XYZ City, 123456</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="vod_food shadow p-20 border-curve">
                <div class="vod_right-head w-fit">
                    <h3>Food Details</h3>
                    <hr class="underline">
                </div>
                <div class="mt-20 vdo_food-details">
                    <div class="vod_image-container">
                        <img src="../uploads/foods/1677405481buff burger.jpg" class="vod_food-img border-curve" alt="food">
                    </div>
                    <table class="table_order-details mt-20">
                        <tr>
                            <td>Food Name</td>
                            <td>:</td>
                            <td>Crunchy Chicken Burger</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>:</td>
                            <td>Rs. 100</td>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td>:</td>
                            <td>2</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="vod_btns flex gap w-full p-20">
            <button class="button border-curve">Accept</button>
            <button class="button gray border-curve">Reject</button>
        </div>

    </main>

</body>

</html>