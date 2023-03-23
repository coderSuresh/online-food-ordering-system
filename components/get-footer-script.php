<?php require('./components/footer.php') ?>

<script type="module" src="./js/app.js"></script>
<script>
    const forLaterInputs = document.querySelector('.for_later_inputs')
    const forLaterCheckBox = document.querySelector('.for_later')

    forLaterCheckBox.addEventListener("click", () => {
        if (forLaterCheckBox.checked) {
            forLaterInputs.innerHTML = `
                        <label for="date">Date:*</label>
                        <input type="date" name="date" 
                                value="<?php echo $date; ?>"
                                min="<?php echo $date; ?>" 
                                max="<?php echo date_format((date_add(date_create($date), date_interval_create_from_date_string("3 days"))), 'Y-m-d'); ?>" 
                                class="p_7-20" id="date" 
                                required>
                       
                        <label for="time">Time:*</label>
                        <?php
                        if (date('H:i', strtotime($time . ' +30 minutes')) > $end_time || date('H:i', strtotime($time . ' +30 minutes')) < $start_time) {
                            echo "<p><b>Sorry, we are not open at this time. Please select another date if you wish to order for later.</b></p>";
                        }
                        ?>

                        <select name="time" required>
                            <option value=''>__SELECT__</option>
                            <optgroup class="time_option"> <?php
                                                            while (date('H:i', strtotime($time . ' +30 minutes')) <= $end_time) {
                                                                $time = date('H:i', strtotime($time . ' +30 minutes'))
                                                            ?> <option value='<?php echo $time; ?>'> <?php echo $time; ?> </option>
                        <?php
                                                            }
                        ?> </optgroup>
                        </select>
                        `

            // ============== listen for date change and set time options accordingly ==============

            const dateInput = document.querySelector('#date')
            const timeOption = document.querySelector('.time_option')

            dateInput.addEventListener("change", () => {

                const date = dateInput.value
                const today = '<?php echo $date; ?>'

                if (date != today) {
                    timeOption.innerHTML = `
                            <?php
                            while (date('H:i', strtotime($start_time . ' +30 minutes')) <= $end_time) {
                                $start_time = date('H:i', strtotime($start_time . ' +30 minutes'))
                            ?> <option value='<?php echo $start_time; ?>'> <?php echo $start_time; ?> </option>
                            <?php
                            }
                            ?>`
                } else {
                    timeOption.innerHTML = `
                    <?php
                    $time = getCurrentTime();
                    while (date('H:i', strtotime($time . ' +30 minutes')) <= $end_time) {
                        $time = date('H:i', strtotime($time . ' +30 minutes'))
                    ?> <option value='<?php echo $time; ?>'> <?php echo $time; ?> </option>
                            <?php
                        }
                            ?>`
                }
            })
        } else {
            forLaterInputs.innerHTML = ''
        }
    })

    // ==================== handle payment via esewa ====================

    const checkoutForm = document.querySelector('.checkout_form');
    const esewaBtn = document.querySelector('.esewa_btn');
    const esewaForm = document.querySelector('.esewa_form');
    const esewaRadioBtn = document.querySelector('#payment-method-esewa');
    const placeOrderBtn = document.querySelector('.place_order');

    esewaBtn.addEventListener('click', (e) => {
        esewaRadioBtn.checked = true
    })

    placeOrderBtn.addEventListener('click', (e) => {
        // TODO: maybe store the form data in local storage and then submit it when the user comes back from esewa
        e.preventDefault()
        if (checkoutForm.checkValidity()) {

            if (esewaRadioBtn.checked) {
                const formData = new FormData(checkoutForm)
                const data = Object.fromEntries(formData.entries())
                const json = JSON.stringify(data)
                localStorage.setItem('order', json)
                esewaForm.submit()

            } else {
                fetch('./backend/place-order.php', {
                        method: 'POST',
                        body: JSON.stringify(Object.fromEntries(new FormData(checkoutForm).entries()))
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = './track-order.php'
                        } else {
                            alert(data.message)
                        }
                    })
                    .catch(err => {
                        console.error(err)
                    })
            }
        } else {
            checkoutForm.reportValidity()
        }
    })
</script>
</body>

</html>