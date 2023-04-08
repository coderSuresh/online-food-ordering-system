<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Analytics | RestroHub</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>

    <style>
        .chart_container {
            min-width: 350px;
            width: 45%;
            min-height: 410px;
        }

        #pie-chart {
            width: 280px !important;
            margin: auto;
        }

        .chart {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>

<body>

    <?php
    require '../config.php';
    require './components/header.php';
    require './components/sidebar.php';

    $sql = "select sum(qty) as total_qty,
            category.cat_name,
            MONTH(orders.date) as month
            from orders
            inner join food on orders.f_id = food.f_id
            inner join category on food.category = category.cat_id
            inner join aos on orders.id = aos.order_id
            where YEAR(orders.date) = 2023 AND
            aos.status = 'delivered' AND
            MONTH(orders.date) = MONTH(CURRENT_DATE())
            group by category.cat_name
            order by MONTH(orders.date);";

    $result = mysqli_query($conn, $sql);

    $labels = array();
    $qty = array();
    $percent = array();

    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $i++;
        array_push($labels, $row['cat_name']);
        array_push($qty, $row['total_qty']);
    }

    $quantity = array_sum($qty);

    foreach ($qty as $q) {
        array_push($percent, round(($q / $quantity) * 100, 2));
    }
    ?>

    <main class="admin_dashboard_body">
        <section class="dashboard_inner-head flex items-center">
            <h2 class="heading">Analytics</h2>
            <img src="../images/ic_calender.svg" class="filter_by_date popper-btn" alt="filter">
        </section>

        <?php
        $whichPage = 'report';
        require "./components/filter.php";
        ?>

        <!-- ==================== analytics cards ====================== -->
        <p class="mt-20"><b>Filter :</b> <?php echo $filter_text; ?></p>
        <div class="flex gap wrap mt-20">
            <article class="card flex items-center text-center border-curve-md shadow p-20 w-32">
                <img src="../images/ic_total-customer.svg" alt="total menu" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_customer; ?></h2>
                    <p class="mt-10">Total Customers</p>
                </div>
            </article>

            <article class="card flex items-center text-center border-curve-md shadow p-20 w-32">
                <img src="../images/ic_total-revenue.svg" alt="total revenue" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $total_rev; ?></h2>
                    <p class="mt-10">Total Revenue</p>
                </div>
            </article>

            <article class="card flex items-center text-center border-curve-md shadow p-20 w-32">
                <img src="../images/ic_total-order.svg" alt="total menu" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_order; ?></h2>
                    <p class="mt-10">Total Orders</p>
                </div>
            </article>

            <article class="card flex items-center text-center border-curve-md shadow p-20 w-32">
                <img src="../images/ic_order-cancel.svg" alt="total revenue" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_order_canceled; ?></h2>
                    <p class="mt-10">Orders Canceled</p>
                </div>
            </article>

            <article class="card flex items-center text-center border-curve-md shadow p-20 w-32">
                <img src="../images/ic_total-menu.svg" alt="total menu" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_food; ?></h2>
                    <p class="mt-10">Total Items</p>
                </div>
            </article>

            <article class="card flex items-center text-center border-curve-md shadow p-20 w-32">
                <img src="../images/ic_total-category.svg" alt="total revenue" aria-hidden="true" class="card_icon">
                <div>
                    <h2><?php echo $count_cat; ?></h2>
                    <p class="mt-10">Total Category</p>
                </div>
            </article>
        </div>

        <section class="dashboard_inner-body mt-40 flex gap wrap">

            <!-- =================== Category wise info ========================== -->
            <?php
            if (!isset($_GET['percent-filter'])) {
                if (isset($_COOKIE['percent-filter'])) {
                    $_GET['percent-filter'] = $_COOKIE['percent-filter'];
                } else {
                    $_GET['percent-filter'] = "pf-quantity";
                }
            }
            ?>

            <div class="chart_container shadow p-20 border-curve" id="cwi">
                <div class="flex items-center">
                    <h3 class="heading">Category wise info</h3>

                    <form action="./report.php" method="get" class="filter-form cat_wise">
                        <select name="percent-filter" id="percent-filter">
                            <option name="pf-quantity" value="pf-quantity" <?php if (isset($_GET['percent-filter']) && $_GET['percent-filter'] == 'pf-quantity')
                                                                                echo 'selected'; ?>>Show quantity</option>

                            <option name="pf-percent" value="pf-percent" <?php if (isset($_GET['percent-filter']) && $_GET['percent-filter'] == 'pf-percent')
                                                                                echo 'selected';
                                                                            ?>>Show percent</option>
                        </select>
                    </form>

                </div>
                <canvas id="pie-chart" class="chart mt-20"></canvas>
            </div>

            <!-- ========================= Total sales ========================== -->
            <div class="chart_container shadow p-20 border-curve" id="ts">
                <div class="flex items-center">
                    <h3 class="heading">Total sales</h3>

                    <?php
                    if (!isset($_GET['tsf'])) {
                        if (isset($_COOKIE['tsf'])) {
                            $_GET['tsf'] = $_COOKIE['tsf'];
                        } else {
                            $_GET['tsf'] = "daily";
                        }
                    }
                    ?>

                    <form action="./report.php" method="get" class="filter-form tsf">
                        <select name="tsf" id="tsf">
                            <option name="monthly" value="monthly" <?php if (isset($_GET['tsf']) && $_GET['tsf'] == "monthly") echo " selected" ?>>Monthly</option>
                            <option name="weekly" value="weekly" <?php if (isset($_GET['tsf']) && $_GET['tsf'] == "weekly") echo " selected" ?>>Weekly</option>
                            <option name="hourly" value="hourly" <?php if (isset($_GET['tsf']) && $_GET['tsf'] == "hourly") echo " selected" ?>>Daily</option>
                        </select>
                    </form>

                </div>

                <?php
                function queryDB($conn, $isForItem)
                {
                    $sql_line = "SELECT CONCAT(LPAD(HOUR(aos.delivered_at), 2, '0'), ':00') AS interval_start,
                                    SUM(total_price) AS total_price_sum
                                    FROM orders
                                    INNER JOIN aos ON orders.id = aos.order_id
                                    WHERE aos.status = 'delivered'   
                                    AND DATE(aos.delivered_at) = CURDATE()
                                    " . ($isForItem && isset($_GET['food']) ? " AND orders.f_id = " . $_GET['food'] : "") . "
                                    GROUP BY HOUR(aos.delivered_at)
                                    order by hour(aos.delivered_at);";

                    $result_line = mysqli_query($conn, $sql_line);

                    $labels_line = array();
                    $total_price = array();

                    foreach ($result_line as $row) {
                        array_push($labels_line, $row['interval_start']);
                        array_push($total_price, $row['total_price_sum']);
                    }

                    // for weekly
                    $sql_line_week = "SELECT WEEKDAY(aos.delivered_at) AS day,
                                    SUM(total_price) AS total_price_sum
                                    FROM orders
                                    INNER JOIN aos ON orders.id = aos.order_id
                                    WHERE aos.status = 'delivered'
                                    " . ($isForItem && isset($_GET['food']) ? " AND orders.f_id = " . $_GET['food'] : "") . " 
                                    AND aos.delivered_at >= NOW() - INTERVAL 1 WEEK
                                    GROUP BY WEEKDAY(aos.delivered_at)
                                    ORDER BY WEEKDAY(aos.delivered_at);";

                    $result_line_week = mysqli_query($conn, $sql_line_week);

                    $labels_line_week = array();
                    $total_price_week = array();

                    foreach ($result_line_week as $row) {
                        array_push($labels_line_week, $row['day']);
                        array_push($total_price_week, $row['total_price_sum']);
                    }

                    // for monthly
                    $sql_line_month = "SELECT
                                            MONTH(aos.delivered_at) AS month,
                                            SUM(total_price) AS total_price_sum
                                        FROM
                                            orders
                                        INNER JOIN aos ON orders.id = aos.order_id
                                        WHERE
                                            aos.status = 'delivered'
                                        " . ($isForItem && isset($_GET['food']) ? " AND orders.f_id = " . $_GET['food'] : "") . "
                                        AND YEAR(aos.delivered_at) = YEAR(CURRENT_DATE())
                                        GROUP BY
                                            MONTH(aos.delivered_at)
                                        ORDER BY
                                            MONTH(aos.delivered_at);";

                    $result_line_month = mysqli_query($conn, $sql_line_month);

                    $labels_line_month = array();
                    $total_price_month = array();

                    foreach ($result_line_month as $row) {
                        array_push($labels_line_month, $row['month']);
                        array_push($total_price_month, $row['total_price_sum']);
                    }

                    return array($labels_line, $total_price, $labels_line_week, $total_price_week, $labels_line_month, $total_price_month);
                }

                list($labels_line, $total_price, $labels_line_week, $total_price_week, $labels_line_month, $total_price_month) = queryDB($conn, false);
                ?>

                <canvas id="line-chart" class="chart mt-20"></canvas>
            </div>

            <!-- ===================== Item wise sales ============================== -->

            <?php

            if (!isset($_GET['food'])) {
                if (isset($_COOKIE['foodID'])) {
                    $_GET['food'] = $_COOKIE['foodID'];
                } else {
                    $_GET['food'] = 1;
                }
            }

            if (!isset($_GET['isf'])) {
                if (isset($_COOKIE['isf'])) {
                    $_GET['isf'] = $_COOKIE['isf'];
                } else {
                    $_GET['isf'] = "hourly";
                }
            }

            ?>
            <div class="chart_container shadow p-20 border-curve" id="iws">
                <div class="flex items-center">
                    <h3 class="heading">Item wise sales</h3>

                    <form action="./report.php" method="get" class="filter-form item_wise">
                        <select name="isf" id="isf">
                            <option name="monthly" value="monthly" <?php if (isset($_GET['isf']) && $_GET['isf'] == "monthly") echo " selected" ?>>Monthly</option>
                            <option name="weekly" value="weekly" <?php if (isset($_GET['isf']) && $_GET['isf'] == "weekly") echo " selected" ?>>Weekly</option>
                            <option name="hourly" value="hourly" <?php if (isset($_GET['isf']) && $_GET['isf'] == "hourly") echo " selected" ?>>Daily</option>
                        </select>
                    </form>
                </div>

                <?php
                $sql = "SELECT name, f_id FROM food";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                ?>
                    <datalist id="food-list">
                        <?php
                        while ($foods = mysqli_fetch_assoc($result)) {
                        ?>
                            <option class="food_option" data-id="<?php echo $foods['f_id']; ?>" value="<?php echo $foods['name'] ?>"><?php echo $foods['name']; ?></option>
                        <?php }
                        ?>
                    </datalist>
                <?php
                } else {
                    echo "<p class='mt-20'>No food available</p>";
                }
                ?>

                <div class="mt-20 div_food_search text-center">
                    <input list="food-list" name="food" id="food" placeholder="Search Food" class="search_food_offer p_7-20 border-curve form_input" required>
                    <button type="submit" onclick="selectFood()" class="button no_bg no_outline border-curve p_7-20" id="search_food_offer">Search</button>
                </div>

                <canvas id="line-chart-item" class="chart"></canvas>
            </div>

            <!-- ===================== category wise sales in price ============================== -->

            <!-- get data from db -->
            <?php
            // daily data

            if (!isset($_GET['bf'])) {
                if (isset($_COOKIE['bf'])) {
                    $_GET['bf'] = $_COOKIE['bf'];
                } else {
                    $_GET['bf'] = "weekly";
                }
            }

            $sql_cat_paisa = "SELECT CONCAT(LPAD(HOUR(aos.delivered_at), 2, '0'), ':00') AS interval_start,
                                    SUM(total_price) AS total_price_sum,
                                    category.cat_name
                                    FROM orders
                                    INNER JOIN aos ON orders.id = aos.order_id
                                    INNER JOIN food ON orders.f_id = food.f_id
                                    INNER JOIN category ON category.cat_id = food.category
                                    WHERE aos.status = 'delivered'
                                    AND DATE(aos.delivered_at) = CURDATE()
                                    GROUP BY category.cat_id, interval_start
                                    ORDER BY interval_start;
                                ";

            $result_cat_paisa = mysqli_query($conn, $sql_cat_paisa);

            $labels_cat_paisa = array();
            $total_price_cat_paisa = array();
            $cat_name = array();

            foreach ($result_cat_paisa as $row) {
                array_push($labels_cat_paisa, $row['interval_start']);
                array_push($total_price_cat_paisa, $row['total_price_sum']);
                array_push($cat_name, $row['cat_name']);
            }

            // weekly data
            $sql_cat_paisa_week = "SELECT WEEKDAY(aos.delivered_at) AS day,
                                        SUM(total_price) AS total_price_sum,
                                        category.cat_name,
                                        aos.delivered_at
                                        FROM orders
                                        INNER JOIN aos ON orders.id = aos.order_id
                                        INNER JOIN food ON orders.f_id = food.f_id
                                        INNER JOIN category ON category.cat_id = food.category
                                        WHERE aos.status = 'delivered'
                                        AND WEEK(aos.delivered_at) = WEEK(CURDATE())
                                        GROUP BY category.cat_id, WEEKDAY(aos.delivered_at)
                                        ORDER BY WEEKDAY(aos.delivered_at);
                                    ";

            $result_cat_paisa_week = mysqli_query($conn, $sql_cat_paisa_week);

            $labels_cat_paisa_week = array();
            $total_price_cat_paisa_week = array();
            $cat_name_week = array();

            foreach ($result_cat_paisa_week as $row) {
                array_push($labels_cat_paisa_week, $row['day']);
                array_push($total_price_cat_paisa_week, $row['total_price_sum']);
                array_push($cat_name_week, $row['cat_name']);
            }

            // monthly data
            $sql_cat_paisa_month = "SELECT YEAR(aos.delivered_at) AS year,
                                            MONTH(aos.delivered_at) AS month,
                                            SUM(total_price) AS total_price_sum,
                                            category.cat_name
                                            FROM orders
                                            INNER JOIN aos ON orders.id = aos.order_id
                                            INNER JOIN food ON orders.f_id = food.f_id
                                            INNER JOIN category ON category.cat_id = food.category
                                            WHERE aos.status = 'delivered'
                                            AND aos.delivered_at >= NOW() - INTERVAL 1 MONTH
                                            GROUP BY category.cat_id, YEAR(aos.delivered_at), MONTH(aos.delivered_at)
                                            ORDER BY YEAR(aos.delivered_at), MONTH(aos.delivered_at);
                                        ";

            $result_cat_paisa_month = mysqli_query($conn, $sql_cat_paisa_month);

            $labels_cat_paisa_month = array();
            $total_price_cat_paisa_month = array();
            $cat_name_month = array();

            foreach ($result_cat_paisa_month as $row) {
                array_push($labels_cat_paisa_month, $row['month']);
                array_push($total_price_cat_paisa_month, $row['total_price_sum']);
                array_push($cat_name_month, $row['cat_name']);
            }
            ?>

            <div class="chart_container shadow p-20 border-curve" id="cws">
                <div class="flex items-center">
                    <h3 class="heading">Category wise sales</h3>

                    <form action="./report.php" method="get" class="filter-form cat_bar">
                        <select name="bf" id="bf">
                            <option name="monthly" value="monthly" <?php if (isset($_GET['bf']) && $_GET['bf'] == "monthly") echo " selected" ?>>Monthly</option>
                            <option name="weekly" value="weekly" <?php if (isset($_GET['bf']) && $_GET['bf'] == "weekly") echo " selected" ?>>Weekly</option>
                            <option name="hourly" value="hourly" <?php if (isset($_GET['bf']) && $_GET['bf'] == "hourly") echo " selected" ?>>Daily</option>
                        </select>
                    </form>
                </div>

                <canvas id="bar-chart" class="chart mt-20"></canvas>
            </div>

            <!-- =========================== individual foods of each category ========================= -->
            <div class="w-full mt-20 shadow p-20 border-curve" id="ioc">
                <div class="flex items-center">
                    <h3 class="heading">Items of a Category</h3>

                    <form action="./report.php" method="get" class="filter-form iocf">
                        <select name="iocf" id="iocf">
                            <option name="monthly" value="monthly" <?php if (isset($_GET['iocf']) && $_GET['iocf'] == "monthly") echo " selected" ?>>Monthly</option>
                            <option name="weekly" value="weekly" <?php if (isset($_GET['iocf']) && $_GET['iocf'] == "weekly") echo " selected" ?>>Weekly</option>
                            <option name="hourly" value="hourly" <?php if (isset($_GET['iocf']) && $_GET['iocf'] == "hourly") echo " selected" ?>>Daily</option>
                        </select>
                    </form>
                </div>

                <!-- fetch categories from db -->
                <?php
                $sql_cat = "SELECT * FROM category";
                $result_cat = mysqli_query($conn, $sql_cat);
                $row = mysqli_fetch_assoc($result_cat);

                if ($row > 0) {
                    echo '<datalist id="category-list">';
                    foreach ($result_cat as $row) {
                        echo '<option class="category_option" data-id="' . $row['cat_id'] . '" value="' . $row['cat_name'] . '">';
                    }
                    echo '</datalist>';
                }
                ?>

                <div class="mt-20 div_cat_search text-center">
                    <input list="category-list" name="category" id="category" placeholder="Search category" class="p_7-20 border-curve form_input" required>
                    <button type="submit" onclick="selectCategory()" class="button no_bg no_outline border-curve p_7-20" id="search_category">Search</button>

                    <?php
                    if (isset($_GET['category']) || isset($_COOKIE['catID'])) {
                        $cat_id = $_GET['category'] ?? $_COOKIE['catID'];
                    }

                    if (isset($_GET['iocf'])) {
                        $iocf = $_GET['iocf'];
                    }

                    require './components/food-table-and-filter.php';
                    ?>
                </div>

            </div>

        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function submitFilterForm() {
            const filterForm = document.querySelectorAll('.filter-form')
            filterForm.forEach(form => {
                form.addEventListener('change', (e) => {
                    e.preventDefault();
                    const query = form.childNodes[1].value

                    if (form.classList.contains('item_wise')) {
                        const foodId = document.cookie.split(';').find(row => row.trim().startsWith('foodID=')).split('=')[1];
                        if (food == '')
                            return;
                        window.location.href = `./report.php?isf=${query}&food=${foodId}#iws`;
                        document.cookie = `isf=${query};`;
                    } else if (form.classList.contains('cat_wise')) {
                        window.location.href = `./report.php?percent-filter=${query}#cwi`;
                        document.cookie = `percent-filter=${query};`;
                    } else if (form.classList.contains('cat_bar')) {
                        window.location.href = `./report.php?bf=${query}#cws`;
                        document.cookie = `bf=${query};`;
                    } else if (form.classList.contains('tsf')) {
                        window.location.href = `./report.php?tsf=${query}#ts`;
                        document.cookie = `tsf=${query};`;
                    } else if (form.classList.contains('iocf')) {
                        const categoryId = document.cookie.split(';').find(row => row.trim().startsWith('catID=')).split('=')[1];
                        window.location.href = `./report.php?iocf=${query}&category=${categoryId}#ioc`;
                        document.cookie = `iocf=${query};`;
                    }
                })
            })
        }

        submitFilterForm();

        function generateColor() {
            const len = 25;
            const color = [];
            for (let i = 0; i < len; i++) {
                const colorCode = `hsl(${Math.floor(Math.random() * 360)}, ${Math.floor(Math.random() * 51) + 50}%, ${Math.floor(Math.random() * 51)}%)`;
                if (color.includes(colorCode))
                    i--;
                else
                    color.push(colorCode);
            }
            localStorage.setItem('color', JSON.stringify(color));
        }

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const hours = ['9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00'];

        // =============================== Pie Chart =====================================
        let pieChart = document.getElementById('pie-chart');

        let dataPieChart = {
            labels: <?php
                    echo json_encode($labels);
                    ?>,
            datasets: [{
                label: "Total Sold",
                data: <?php
                        if (isset($_GET['percent-filter']) && $_GET['percent-filter'] == 'pf-quantity')
                            echo json_encode($qty);
                        else if (!isset($_GET['percent-filter']) || $_GET['percent-filter'] == 'pf-percent')
                            echo json_encode($percent);
                        else
                            echo json_encode(array());
                        ?>,
                backgroundColor: localStorage.getItem('color') ? JSON.parse(localStorage.getItem('color')) : generateColor(),
                borderWidth: [1, 1, 1, 1, 1]
            }]
        };

        let options = {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    position: "top",
                    text: "CATEGORY WISE SALES",
                    fontSize: 18,
                    fontColor: "#000"
                },
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                        fontColor: "#333",
                        fontSize: 16
                    }
                }
            }
        };

        const pie_chart = new Chart(pieChart, {
            type: "pie",
            data: dataPieChart,
            options: options
        });

        // ======================== Line Chart ========================

        // determine get parameter
        <?php
        function getParam($param)
        {
            if (isset($_GET[$param]) && $_GET[$param] == 'hourly') {
                $query = 'hourly';
            } else if (isset($_GET[$param]) && $_GET[$param] == 'weekly') {
                $query = 'weekly';
            } else if (isset($_GET[$param]) && $_GET[$param] == 'monthly') {
                $query = 'monthly';
            } else {
                $query = 'hourly';
            }
            return $query;
        }
        $query = getParam('tsf');

        // determine label       
        function getLabels($query, $labels_line, $labels_line_week, $labels_line_month)
        {
            if ($query == 'hourly') {
                $labels = $labels_line;
            } else if ($query == 'weekly') {
                $labels = $labels_line_week;
            } else if ($query == 'monthly') {
                $labels = $labels_line_month;
            } else {
                $labels = $labels_line;
            }

            return $labels;
        }

        $labels = getLabels($query, $labels_line, $labels_line_week, $labels_line_month);

        // determine data
        $data = array();
        function getData($query, $total_price, $total_price_week, $total_price_month)
        {
            if ($query == 'hourly') {
                $data = $total_price;
            } else if ($query == 'weekly') {
                $data = $total_price_week;
            } else if ($query == 'monthly') {
                $data = $total_price_month;
            } else {
                $data = $total_price;
            }
            return $data;
        }

        $data = getData($query, $total_price, $total_price_week, $total_price_month);
        ?>

        generateLineChart(
            "line-chart",
            '<?php echo $query ?>',
            hours,
            months,
            days,
            <?php echo json_encode($labels); ?>,
            <?php echo json_encode($data); ?>
        );

        function generateLineChart(id, getParam, hours, months, days, labels, data) {
            const lineChart = document.getElementById(id);

            let period = '';
            const query = getParam;

            if (query === 'hourly') {
                period = 'Daily';
            } else if (query === 'weekly') {
                period = 'Weekly';
            } else if (query === 'monthly') {
                period = 'Monthly';
            } else {
                period = 'Daily';
            }

            dbLabel = labels;

            data = data

            let finalData = new Array(13).fill(0);

            if (query === 'hourly') {
                dbLabel.forEach((l, i) => {
                    finalData[hours.indexOf(l)] = data[i]
                })
            } else if (query === 'weekly') {

                const weekDays = {
                    0: 'Mon',
                    1: 'Tue',
                    2: 'Wed',
                    3: 'Thu',
                    4: 'Fri',
                    5: 'Sat',
                    6: 'Sun'
                }

                const tempDay = dbLabel.map((d, i) => {
                    return weekDays[d]
                })

                tempDay.forEach((l, i) => {
                    finalData[days.indexOf(l)] = data[i]
                })

            } else {
                dbLabel.forEach((l, i) => {
                    finalData[l - 1] = data[i]
                })
            }

            let finalLabels = ""
            if (query === 'hourly') {
                finalLabels = hours
            } else if (query === 'weekly') {
                finalLabels = days
            } else if (query === 'monthly') {
                finalLabels = months
            } else {
                finalLabels = hours
            }

            const dataLine = {
                labels: finalLabels,
                datasets: [{
                    label: 'Sales',
                    data: finalData,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            };

            const lineOptions = {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                },
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        position: "top",
                        text: `${period.toUpperCase()} SALES`,
                        fontSize: 18,
                        fontColor: "#000"
                    },
                }
            };

            const line_chart = new Chart(lineChart, {
                type: "line",
                data: dataLine,
                options: lineOptions,
            });
        }

        // =================== Item wise sales ===================
        function selectFood() {
            const foodInput = document.getElementById('food');
            const food = document.getElementById('food').value;
            const foodList = document.querySelectorAll('.food_option');

            if (foodInput.checkValidity()) {
                foodList.forEach((foodOption) => {
                    if (foodOption.value === food) {
                        const foodId = foodOption.getAttribute('data-id');
                        document.cookie = `foodID=${foodId}`;
                        window.location.href = `?food=${foodId}#iws`;
                    } else {
                        return
                    }
                })
            } else {
                foodInput.reportValidity();
            }
        }

        function selectCategory() {
            const categoryInput = document.getElementById('category');
            const category = document.getElementById('category').value;
            const categoryList = document.querySelectorAll('.category_option');

            if (categoryInput.checkValidity()) {
                categoryList.forEach((categoryOption) => {
                    if (categoryOption.value === category) {
                        const categoryId = categoryOption.getAttribute('data-id');
                        document.cookie = `catID=${categoryId}`;
                        window.location.href = `?category=${categoryId}#ioc`;
                    } else {
                        return
                    }
                })
            } else {
                categoryInput.reportValidity();
            }
        }

        // set the food name in the input field from the local storage
        window.onload = () => {
            const foodId = (document.cookie.split(';').find(row => row.trim().startsWith('foodID'))) ?
                document.cookie.split(';').find(row => row.trim().startsWith('foodID')).split('=')[1] :
                null;

            if (foodId) {
                const foodList = document.querySelectorAll('.food_option');
                foodList.forEach((foodOption) => {
                    if (foodOption.getAttribute('data-id') === foodId) {
                        const foodName = foodOption.value;
                        document.getElementById('food').value = foodName;
                    }
                })
            }

            const categoryId = (document.cookie.split(';').find(row => row.trim().startsWith('catID'))) ?
                document.cookie.split(';').find(row => row.trim().startsWith('catID')).split('=')[1] :
                null

            if (categoryId) {
                const categoryList = document.querySelectorAll('.category_option');
                categoryList.forEach((categoryOption) => {
                    if (categoryOption.getAttribute('data-id') === categoryId) {
                        const categoryName = categoryOption.value;
                        document.getElementById('category').value = categoryName;
                    }
                })
            }
        }

        // call the function to generate the chart for item wise sales
        <?php
        list($labels_line, $total_price, $labels_line_week, $total_price_week, $labels_line_month, $total_price_month) = queryDB($conn, true);
        $query = getParam('isf');
        $labels = getLabels($query, $labels_line, $labels_line_week, $labels_line_month);
        $data = getData($query, $total_price, $total_price_week, $total_price_month);
        ?>

        generateLineChart(
            "line-chart-item",
            '<?php echo $query ?>',
            hours,
            months,
            days,
            <?php echo json_encode($labels); ?>,
            <?php echo json_encode($data); ?>
        );

        // =================== Category wise sales bar chart ===================

        <?php
        $query = getParam('bf');
        $labels = getLabels($query, $labels_cat_paisa, $labels_cat_paisa_week, $labels_cat_paisa_month);
        $name = getLabels($query, $cat_name, $cat_name_week, $cat_name_month);
        $price = getData($query, $total_price_cat_paisa, $total_price_cat_paisa_week, $total_price_cat_paisa_month);
        ?>

        let query = <?php echo json_encode($query); ?>;
        let tempName = <?php echo json_encode($name); ?>;
        let tempData = <?php echo json_encode($price); ?>;
        let tempLabel = <?php echo json_encode($labels); ?>;

        const data = tempLabel.map((label, i) => ({
            category: tempName[i],
            day: label,
            sales: tempData[i],
        }));

        const salesByCategoryAndDay = {};

        data.forEach(({
            category,
            day,
            sales
        }) => {

            if (query === 'hourly') {
                day = hours.indexOf(day);
            } else if (query === 'weekly') {
                day = parseInt(day) + 1;
            } else if (query === 'monthly') {
                day = parseInt(day) - 1;
            } else {
                day = parseInt(day);
            }

            if (!salesByCategoryAndDay[category]) {
                salesByCategoryAndDay[category] = new Array(15).fill(0);
            }
            salesByCategoryAndDay[category][day] += sales;
        });

        const dataset = Object.entries(salesByCategoryAndDay).map(([category, sales], i) => ({
            label: category,
            data: sales,
            backgroundColor: localStorage.getItem('color') ? JSON.parse(localStorage.getItem('color'))[i] : generateColor(),
            borderWidth: 1,
        }));

        const realLabels = query === 'hourly' ? hours : query === 'weekly' ? days : query === 'monthly' ? months : hours;

        const barChart = document.querySelector('#bar-chart');
        const dataBar = {
            labels: realLabels,
            datasets: dataset,
        };

        const barOptions = {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    position: 'top',
                    text: 'sales',
                    fontSize: 18,
                    fontColor: '#000',
                },
            },
        };

        const bar_chart = new Chart(barChart, {
            type: 'bar',
            data: dataBar,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: `${query.toUpperCase()} SALES`,
                    },
                },
            },
        });
    </script>
</body>

</html>