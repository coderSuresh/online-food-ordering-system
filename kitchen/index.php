<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | RestroHub</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
</head>

<body>

    <?php
    require("../config.php");
    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

   <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2>Order Details</h2>
        </section>

        <div class="flex items-center">
            <!-- buttons for order management -->
            <div class="flex items-center">

                <!-- search form for orders -->
                <form action="#" method="post" class="search_form border-curve-lg">
                    <div class="flex items-center">
                        <input type="search" placeholder="Search..." class="no_outline search_employee" name="search-employee" id="search-employee">
                        <button type="submit" class="no_bg no_outline"><img src="../images/ic_search.svg" alt="search icon"></button>
                    </div>
                </form>

                <button class="button ml-35 border-curve-lg">All</button>
                <button class="button ml-35 border-curve-lg">Pending</button>
                <button class="button ml-35 border-curve-lg">Accepted</button>

            </div>
        </div>

        <!-- food cards -->
        <table class="mt-20">
            <tr class="shadow">
                <th>SN</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Note</th>
                <th>Order Status</th>
                <th>Action</th>
            </tr>
            <tr class="shadow">
                <td>1</td>
                <td>Chinese Momo</td>
                <td>3</td>
                <td>N/A</td>
                <td><span class="pending border-curve-lg p_7-20">Pending</span></td>
                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images//ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <div class="table_action_options shadow border-curve p-20 flex direction-col">
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_accept.svg" alt="accpet icon">
                                    <p>Accept</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_reject.svg" alt="reject icon">
                                    <p>Reject</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_prepared.svg" alt="prepared icon">
                                    <p>Prepared</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="shadow">
                <td>2</td>
                <td>Chinese Momo</td>
                <td>3</td>
                <td>Please put some extra corona viruses</td>
                <td><span class="accepted border-curve-lg p_7-20">Accepted</span></td>
                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images//ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <div class="table_action_options shadow border-curve p-20 flex direction-col">
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_accept.svg" alt="accpet icon">
                                    <p>Accept</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_reject.svg" alt="reject icon">
                                    <p>Reject</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_prepared.svg" alt="prepared icon">
                                    <p>Prepared</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="shadow">
                <td>3</td>
                <td>Chinese Momo</td>
                <td>3</td>
                <td>N/A</td>
                <td><span class="pending border-curve-lg p_7-20">Pending</span></td>
                <td class="table_action_container">
                    <!-- action menu -->
                    <button class="no_bg no_outline table_option-menu">
                        <img src="../images//ic_options.svg" alt="options menu">
                    </button>
                    <!-- options -->
                    <div class="table_action_options shadow border-curve p-20 flex direction-col">
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_accept.svg" alt="accpet icon">
                                    <p>Accept</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_reject.svg" alt="reject icon">
                                    <p>Reject</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <div class="flex items-center justify-start">
                                    <img src="../images/ic_prepared.svg" alt="prepared icon">
                                    <p>Prepared</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </main>
</body>

</html>