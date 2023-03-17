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
        .pie_container {
            max-width: 350px;
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
            MONTH(orders.date) = 2
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

    while ($i > 0) {
        $i--;
        array_push($percent, round(floatval($qty[$i] / $quantity * 100.0), 2));
    }

    ?>

    <main class="admin_dashboard_body">
        <section class="dashboard_inner-head flex items-center">
            <h2 class="heading">Sales Report</h2>
        </section>

        <section class="dashboard_inner-body mt-20">

            <div class="pie_container shadow p-20 border-curve">
                <div class="flex items-center">
                    <h3 class="heading">Filter</h3>

                    <form action="./report.php" method="get" class="percent-filter-form">
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
                <canvas id="pie-chart"></canvas>
            </div>

        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function submitFilterForm() {
            const filterForm = document.querySelector('.percent-filter-form');
            const filterOptions = document.getElementById('percent-filter');
            filterForm.addEventListener('change', () => {
                filterForm.submit();
            });
        }

        submitFilterForm();

        function generateColor(len) {
            const color = [];
            for (let i = 0; i < len; i++) {
                color.push('#' + Math.floor(Math.random() * 0xFFFFFF).toString(16));
            }
            return color;
        }

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

        let pie_chart = new Chart(pieChart, {
            type: "pie",
            data: dataPieChart,
            options: options
        });
    </script>
</body>

</html>