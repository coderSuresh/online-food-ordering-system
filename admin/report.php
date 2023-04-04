<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Sales Report | RestroHub</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>

    <style>
        .chart_container {
            min-width: 350px;
            width: 45%;
            min-height: 350px;
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
            <h2 class="heading">Sales Report</h2>
        </section>

        <section class="dashboard_inner-body mt-20 flex gap wrap">

            <div class="chart_container shadow p-20 border-curve">
                <div class="flex items-center">
                    <h3 class="heading">Filter</h3>

                    <form action="./report.php" method="get" class="filter-form">
                        <select name="percent-filter" id="percent-filter">
                            <option name="pf-quantity" value="pf-quantity" <?php if (isset($_GET['percent-filter']) && $_GET['percent-filter'] == 'pf-quantity')
                                                                                echo 'selected'; ?>>Show quantity</option>

                            <option name="pf-percent" value="pf-percent" <?php if (isset($_GET['percent-filter']) && $_GET['percent-filter'] == 'pf-percent')
                                                                                echo 'selected';
                                                                            else if (!isset($_GET['percent-filter']))
                                                                                echo 'selected';
                                                                            ?>>Show percent</option>
                        </select>
                    </form>

                </div>
                <canvas id="pie-chart" class="chart"></canvas>
            </div>

            <div class="chart_container shadow p-20 border-curve">
                <div class="flex items-center">
                    <h3 class="heading">Filter</h3>

                    <?php
                    // initially set to monthly
                    if (!isset($_GET['tsf'])) {
                        $_GET['tsf'] = "hourly";
                    }
                    ?>

                    <form action="./report.php" method="get" class="filter-form">
                        <select name="tsf" id="tsf">
                            <option name="monthly" value="monthly" <?php if (isset($_GET['tsf']) && $_GET['tsf'] == "monthly") echo " selected" ?>>Monthly</option>
                            <option name="weekly" value="weekly" <?php if (isset($_GET['tsf']) && $_GET['tsf'] == "weekly") echo " selected" ?>>Weekly</option>
                            <option name="hourly" value="hourly" <?php if (isset($_GET['tsf']) && $_GET['tsf'] == "hourly") echo " selected" ?>>Hourly</option>
                        </select>
                    </form>

                </div>

                <?php
                $sql_line = "SELECT CONCAT(LPAD(HOUR(aos.delivered_at), 2, '0'), ':00') AS interval_start,
                                    SUM(total_price) AS total_price_sum
                                    FROM orders
                                    INNER JOIN aos ON orders.id = aos.order_id
                                    WHERE aos.status = 'delivered'   
                                    AND DATE(aos.delivered_at) = CURDATE()
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

                ?>

                <canvas id="line-chart" class="chart"></canvas>
            </div>

        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function submitFilterForm() {
            const filterForm = document.querySelectorAll('.filter-form');
            filterForm.forEach(form => {
                form.addEventListener('change', (e) => {
                    form.submit();
                })
            })
        }

        submitFilterForm();

        function generateColor(len) {
            const color = [];
            for (let i = 0; i < len; i++) {
                const colorCode = '#' + Math.floor(Math.random() * 0xFFFFFF).toString(16);
                if (color.includes(colorCode))
                    i--;
                else
                    color.push(colorCode);
            }
            return color;
        }

        // Pie Chart
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
                backgroundColor: <?php
                                    $len = count($labels);
                                    if ($len > 0) {
                                        echo "generateColor($len)";
                                        $len--;
                                    }
                                    ?>,
                borderWidth: [1, 1, 1, 1, 1]
            }]
        };

        let options = {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    position: "top",
                    text: "Category Wise Sales",
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

        // Line Chart
        const lineChart = document.getElementById('line-chart');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const hours = ['9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00'];

        <?php
        $period = "";
        if (isset($_GET['tsf']) && $_GET['tsf'] == 'hourly')
            $period = "Hourly";
        else if (isset($_GET['tsf']) && $_GET['tsf'] == 'weekly')
            $period = "Weekly";
        else if (isset($_GET['tsf']) && $_GET['tsf'] == 'monthly')
            $period = "Monthly";
        else
            $period = "Hourly";
        ?>

        dbLabel = <?php
                    if (isset($_GET['tsf']) && $_GET['tsf'] == 'hourly')
                        echo json_encode($labels_line);
                    else if (isset($_GET['tsf']) && $_GET['tsf'] == 'weekly')
                        echo json_encode($labels_line_week);
                    else if (isset($_GET['tsf']) && $_GET['tsf'] == 'monthly')
                        echo json_encode($labels_line_month);
                    else
                        echo json_encode($labels_line);
                    ?>;

        data = <?php
                if (isset($_GET['tsf']) && $_GET['tsf'] == 'hourly')
                    echo json_encode($total_price);
                else if (isset($_GET['tsf']) && $_GET['tsf'] == 'weekly')
                    echo json_encode($total_price_week);
                else if (isset($_GET['tsf']) && $_GET['tsf'] == 'monthly')
                    echo json_encode($total_price_month);
                else
                    echo json_encode($total_price);
                ?>;

        let finalData = new Array(13).fill(0);

        <?php
        if (isset($_GET['tsf']) && $_GET['tsf'] == "hourly") {
        ?>
            dbLabel.forEach((l, i) => {
                finalData[hours.indexOf(l)] = data[i]
            })
        <?php
        } else if (isset($_GET['tsf']) && $_GET['tsf'] == "weekly") {
        ?>

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

        <?php } else {
        ?>
            dbLabel.forEach((l, i) => {
                finalData[l - 1] = data[i]
            })
        <?php   }
        ?>

        const finalLabels = <?php
                            if (isset($_GET['tsf']) && $_GET['tsf'] == 'hourly')
                                echo "hours";
                            else if (isset($_GET['tsf']) && $_GET['tsf'] == 'weekly')
                                echo "days";
                            else if (isset($_GET['tsf']) && $_GET['tsf'] == 'monthly')
                                echo "months";
                            else
                                echo "hours";
                            ?>

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
                    text: "<?php echo $period; ?> sales",
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
    </script>
</body>

</html>