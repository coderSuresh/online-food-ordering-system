<div class="vod_container flex gap wrap mt-20">
    <div class="vod_left shadow p-20 border-curve">
        <div class="vod_left-head w-fit">
            <h3 class="heading">Order Details</h3>
            <hr class="underline">
        </div>
        <div class="vod_left-body mt-20">
            <div class="vod_left-body-inner">
                <div class="vod_left-body-inner-content">
                    <table class="table_order-details">
                        <tr>
                            <td>Order ID</td>
                            <td>:</td>
                            <td><?php echo $row['track_id']; ?></td>
                        </tr>
                        <tr>
                            <td>Order Date</td>
                            <td>:</td>
                            <td><?php echo $row['date']; ?></td>
                        </tr>
                        <tr>
                            <td>Order Status</td>
                            <td>:</td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                        <tr>
                            <td>Order Total</td>
                            <td>:</td>
                            <td>Rs. <?php echo $total_price; ?></td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>:</td>
                            <td><?php echo $row['payment_method']; ?></td>
                        </tr>
                        <tr>
                            <td>Note</td>
                            <td>:</td>
                            <td><?php echo $row['note']; ?></td>
                        </tr>
                        <?php
                        if ($row['status'] == 'rejected') {
                        ?> <tr>
                                <td>Reason</td>
                                <td>:</td>
                                <td><?php echo $row_reject['reason']; ?></td>
                            </tr>
                            <tr>
                                <td>Rejected by</td>
                                <td>:</td>
                                <td><?php echo $row_reject['rejected_by']; ?></td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="vod_right shadow p-20 border-curve">
        <div class="vod_right-head w-fit">
            <h3 class="heading">Customer Details</h3>
            <hr class="underline">
        </div>
        <div class="vod_right-body mt-20">
            <div class="vod_right-body-inner">
                <div class="vod_right-body-inner-content">
                    <table class="table_order-details">
                        <tr>
                            <td>Customer's Name</td>
                            <td>:</td>
                            <td><?php echo $row['names']; ?></td>
                        </tr>
                        <tr>
                            <td>Receiver's Name</td>
                            <td>:</td>
                            <td><?php echo $row['c_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Customer's Email</td>
                            <td>:</td>
                            <td>
                                <a href="mailto:<?php echo $row['email']; ?>">
                                    <div class="w-fit">
                                        <?php echo $row['email']; ?>
                                        <hr>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Receiver's Contact</td>
                            <td>:</td>
                            <td>
                                <a href="tel:<?php echo $row['phone']; ?>">
                                    <div class="w-fit">
                                        <?php echo $row['phone']; ?>
                                        <hr>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Shipping Address</td>
                            <td>:</td>
                            <td><?php echo $row['address']; ?></td>
                        </tr>
                        <tr>
                            <?php
                            if (isset($delivery_date)) {
                            ?>
                                <td>Delivery Date</td>
                                <td>:</td>
                                <td><?php echo "Date: " . $delivery_date . "&nbsp; Time: " . $delivery_time; ?></td>
                            <?php
                            } else {
                            ?>
                                <td>Joined On</td>
                                <td>:</td>
                                <td><?php echo $row['c_date']; ?></td>
                            <?php
                            }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-20 p-20 shadow border-curve">
    <div class="w-fit">
        <h3 class="heading">Order Items</h3>
        <hr class="underline">
    </div>

    <div>
        <table class="table_order-items mt-20">
            <tr class="shadow">
                <th>SN</th>
                <th>Image</th>
                <th>Food Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php
            $i = 0;
            foreach ($result_all as $row) {
                $i++;
            ?>
                <tr class="shadow">
                    <td><?php echo $i; ?></td>
                    <td>
                        <img src="../uploads/foods/<?php echo $row['img']; ?>" alt="food image" class="table_food-img">
                    </td>
                    <td><?php echo $row['name']; ?></td>
                    <td>Rs. <?php echo $row['price']; ?></td>
                    <td><?php echo $row['qty']; ?></td>
                    <td>Rs. <?php echo $row['total_price']; ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

</div>