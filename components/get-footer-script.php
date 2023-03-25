<?php require('./components/footer.php') ?>

<script type="module" src="./js/app.js"></script>
<script>
    const forLaterInputs = document.querySelector('.for_later_inputs')
    const forLaterCheckBox = document.querySelector('.for_later')
    const warnContainer = document.querySelector('.warn_msg')

    <?php
    // get current date and time
    if ($time < date('H:i', strtotime($start_time . ' +30 minutes')) || $time > $end_time) {
    ?>

        forLaterCheckBox.checked = true

        function showWarning() {
            const warnMsg = document.createElement('p')

            warnMsg.style.color = 'red'
            warnMsg.style.fontWeight = '700'
            warnMsg.style.margin = '10px 0'
            warnMsg.style.fontSize = '0.825rem'

            warnMsg.textContent = "We are closed now. If you wish to order for later, please specify date and time below."

            warnContainer.appendChild(warnMsg)

            const btn = document.querySelector('.place_order')
            btn.disabled = true
        }

        showWarning()
    <?php }
    ?>

    window.onload = () => {
        checkIfChecked()
        validateDateTime()
    }

    forLaterCheckBox.addEventListener("click", () => {
        checkIfChecked()
    })

    function checkIfChecked() {
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
                        <select name="time" id="time" required>
                            <option value=''>__SELECT__</option>
                            <optgroup class="time_option"> <?php
                                                            if ($time < date('H:i', strtotime($start_time . ' +30 minutes'))) {
                                                                $time = "09:00";
                                                            }
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
            const timeInput = document.querySelector('#time')
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
                    if ($time < date('H:i', strtotime($start_time . ' +30 minutes'))) {
                        $time = "09:00";
                    }
                    while (date('H:i', strtotime($time . ' +30 minutes')) <= $end_time) {
                        $time = date('H:i', strtotime($time . ' +30 minutes'))
                    ?> <option value='<?php echo $time; ?>'> <?php echo $time; ?> </option>
                            <?php
                        }
                            ?>`
                }

            })

            // ==================== watch time input change ====================
            timeInput.addEventListener('change', () => {
                validateDateTime()
            })

        } else {
            forLaterInputs.innerHTML = ''
        }
    }

    // ==================== validate date and time ====================
    function validateDateTime() {

        const dateInput = document.querySelector('#date')
        const timeInput = document.querySelector('#time')
        const btn = document.querySelector('.place_order')
        const warnMsg = document.querySelector('.warn_msg')

        if (dateInput.value == '' || timeInput.value == '') {
            btn.disabled = true
        } else {
            warnMsg.remove()
            btn.disabled = false
        }
    }

    // ==================== handle payment via esewa ====================

    const checkoutForm = document.querySelector('.checkout_form');
    const esewaBtn = document.querySelector('.esewa_btn');
    const esewaRadioBtn = document.querySelector('#payment-method-esewa');
    const placeOrderBtn = document.querySelector('.place_order');

    esewaBtn.addEventListener('click', (e) => {
        esewaRadioBtn.checked = true
    })

    placeOrderBtn.addEventListener('click', (e) => {
        e.preventDefault()
        if (checkoutForm.checkValidity()) {

            const formData = Object.fromEntries(new FormData(checkoutForm).entries())

            fetch('./backend/validate-checkout-form.php', {
                    method: 'POST',
                    body: JSON.stringify(formData)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.redirect) {
                        formData['pm'] = data.pm
                        document.cookie = `checkoutFormData=${JSON.stringify(formData)}`
                        window.location.href = data.location
                    } else {
                        alert(data.message)
                    }
                })
                .catch(err => {
                    console.error(err)
                })
        } else {
            checkoutForm.reportValidity()
        }
    })

    if (history.replaceState) {
        history.replaceState("", "", window.location.href)
    }
</script>
</body>

</html>