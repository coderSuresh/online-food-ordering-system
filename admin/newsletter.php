<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter | RestroHub</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <script src="../js/admin.js" defer></script>
    <script src="./watch-dog.js" defer></script>
    <script src="./watch-status.js" defer></script>
</head>

<body>
    <?php
    require '../config.php';
    require("./components/header.php");
    require("./components/sidebar.php");
    ?>

    <main class="admin_dashboard_body">

        <section class="dashboard_inner-head flex items-center">
            <h2 class="heading">Newsletter</h2>
        </section>

        <?php
        $sql = "SELECT * FROM newsletter";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
        ?>
            <div class="table">
                <table class="mt-20">
                    <tr class="shadow">
                        <th>SN</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Date</th>
                    </tr>

                    <?php
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $customer_id = $row['c_id'];
                        $sql_cus_name = "SELECT names FROM customer WHERE id = $customer_id";
                        $result_cus_name = mysqli_query($conn, $sql_cus_name);
                        $row_cus_name = mysqli_fetch_assoc($result_cus_name);
                        $name = $row_cus_name['names'];
                    ?>
                        <tr class="shadow">
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['date']; ?></td>

                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        <?php
        } else {
            echo "<h3 class='text-center mt-20'>No Newsletter Subscribers</h3>";
        }
        ?>

    </main>

</body>

</html>