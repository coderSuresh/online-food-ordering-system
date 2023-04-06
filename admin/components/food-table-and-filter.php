<?php

if (isset($cat_id)) {
    $c_id = intval($cat_id);
}

$sql_food = "SELECT COALESCE(SUM(o.total_qty), 0) as total_sold,
                            f.name,
                            f.img,
                            f.price
                        FROM food f
                        INNER JOIN category c ON f.category = c.cat_id
                        LEFT JOIN (
                            SELECT f_id, SUM(qty) as total_qty
                            FROM orders
                            INNER JOIN aos ON orders.id = aos.order_id AND aos.status = 'delivered'
                            GROUP BY f_id
                        ) o ON f.f_id = o.f_id
                        WHERE c.cat_id = $c_id
                        GROUP BY f.f_id
                        ORDER BY total_sold DESC";

if (isset($iocf)) {
    $filter = mysqli_real_escape_string($conn, $_GET['iocf']);
    if (isset($filter)) {

        require '../components/get-current-timestamp.php';
        $now = getCurrentTimestamp();

        if ($filter == "weekly")
            $afterAnd = "aos.delivered_at >= DATE_SUB('$now', INTERVAL 7 DAY)";
        else if ($filter == "monthly")
            $afterAnd = "aos.delivered_at >= DATE_SUB('$now', INTERVAL 30 DAY)";
        else if ($filter == "hourly")
            $afterAnd = "aos.delivered_at >= DATE_SUB('$now', INTERVAL 1 DAY)";

        $sql_food = "SELECT COALESCE(SUM(o.total_qty), 0) as total_sold,
                            f.name,
                            f.img,
                            f.price
                        FROM food f
                        INNER JOIN category c ON f.category = c.cat_id
                        LEFT JOIN (
                            SELECT f_id, SUM(qty) as total_qty
                            FROM orders
                            INNER JOIN aos ON orders.id = aos.order_id AND aos.status = 'delivered' AND $afterAnd
                            GROUP BY f_id
                        ) o ON f.f_id = o.f_id
                        WHERE c.cat_id = $c_id
                        GROUP BY f.f_id
                        ORDER BY total_sold DESC
                        ";
    }
}

$res_food = mysqli_query($conn, $sql_food);

if (mysqli_num_rows($res_food) > 0) {
?>

    <table>
        <tr class="shadow">
            <th>SN</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Total Sold</th>
        </tr>
        <?php
        $i = 1;
        while ($data = mysqli_fetch_assoc($res_food)) {
            $name = $data['name'];
            $image_name = $data['img'];
            $price = $data['price'];
            $total_sold = $data['total_sold'];
        ?>

            <tr class="shadow">
                <td><?php echo $i++; ?></td>
                <td>
                    <?php
                    if ($image_name != "") {
                    ?>
                        <img src="../uploads/foods/<?php echo $image_name; ?>" alt="Food Image" class="table_food-img">
                    <?php
                    } else {
                        echo "<div class='error'>Image Not Added</div>";
                    }
                    ?>
                </td>
                <td><?php echo $name; ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo $total_sold; ?></td>
            </tr>
        <?php }
        ?>
    </table>
<?php
} else {
    echo "<p class='mt-20'>No Food Found</p>";
}
?>