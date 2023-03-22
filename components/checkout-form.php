<div class="mt-20 flex justify-center checkout_form_container">
    <div>
        <?php
        // get current date and time
        require './components/get-current-timestamp.php';

        $date = getCurrentDate();
        $time = getCurrentTime();

        $start_time = "09:00";
        $end_time = "21:00";

        $isToday = false;
        ?>

        <form action="./backend/place-order.php" method="post" class="checkout_form flex direction-col shadow border-curve p-20">
            <label for="name">Name:*</label>
            <input type="text" placeholder="John Sharma" name="name" class="p_7-20" id="name" required autofocus>
            <label for="phone">Phone:*</label>
            <input type="tel" name="phone" placeholder="9800000000" maxlength="10" class="p_7-20" id="phone" required>
            <label for="address">Address:*</label>
            <input type="text" name="address" placeholder="Chardobato, Banepa near check post" class="p_7-20" id="address" required>

            <div class="for-later flex items-center">
                <input type="checkbox" name="for-later" class="p_7-20 for_later" id="for-later">
                <label for="for-later" style="white-space: nowrap;">&nbsp; Order for Later</label>
            </div>

            <div class="for_later_inputs">
                <!-- coming from js below -->
            </div>

            <label for="note"> Note: </label>
            <input type="text" placeholder="example: with no sugar" name="note" class="p_7-20" id="note">
            <p style="font-weight: 700; margin-top: 10px;"> Payment Method </p>
            <div class="flex items-center justify-start payment">
                <div class="flex items-center">
                    <input type="radio" name="payment-method" value="payment-method-cod" id="payment-method-cod">
                    <label for="payment-method-cod" style="white-space: nowrap; margin-left: 10px;"> Cash on Delivery </label>
                </div>
                <div class="flex items-center ml-35">
                    <input type="radio" name="payment-method" value="payment-method-esewa" id="payment-method-esewa" checked>
                    <label for="payment-method-esewa" style="white-space: nowrap; margin-left: 10px;"> eSewa </label>
                </div>
            </div>
            <?php
            if (isset($isFromBuy)) {
            ?>
                <input type="hidden" name="f_id" value="<?php echo $food_id; ?>">
                <input type="hidden" name="qty" class="hidden_quantity" value="<?php echo $quantity; ?>">
            <?php
            } else if (isset($isFromCheckout)) {
            ?>
                <input type="hidden" name="food_id" value="<?php echo base64_encode(serialize($food_id_arr)); ?>">
                <input type="hidden" name="quantity" value="<?php echo base64_encode(serialize($qty_arr)); ?>">
            <?php
            }
            ?>
            <input type="hidden" name="total_price" value="<?php echo $totalPrice + $vat; ?>">
            <button type="submit" name="<?php if (isset($isFromBuy))
                                            echo "place-order-buy";
                                        else
                                            echo "place-order"; ?>" class="button mt-20 w-full border-curve"> Place Order </a>
        </form>
    </div>
    <div class="direction-col justify-start ml-35 p-20 shadow border-curve checkout_details">
        <div class="checkout_info">
            <h5 class="final_price_without_vat"> Total: <?php echo $totalPrice; ?> </h5>
            <h5 class="vat"> Vat(13 % ): <?php echo $vat; ?> </h5>
            <h5 class="final_price"> Grand Total: Rs.<?php echo $totalPrice + $vat; ?> </h5>
        </div>
        <div class="mt-20 flex direction-col">
            <a href="./menu.php" class="button mt-20 border-curve" style="background-color: #F7922F0a;"> Continue Shopping </a>
        </div>

        <!-- ================ e-Sewa ================== -->
        <div class="mt-40 flex direction-col">
            <h4>Pay with eSewa</h4>
            <button class="button gray mt-20 no_outline no_bg" style="padding: 3px !important">
                <img src="./images/esewa.svg" alt="e-sewa" style="width: 100px;">
            </button>
        </div>

    </div>
</div>