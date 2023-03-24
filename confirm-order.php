<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Are you hungry? You are at the right place. We offer mouth watering foods at your doorstep. Click now and order food online.">
    <meta name="author" content="Ashish Acharya, Bibek Mahat, Parask K. Bhandari, Suresh Dahal">
    <meta name="theme-color" content="#F7922F">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <title>Confirm | RestroHub</title>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/responsive.css">
</head>

<body>

    <?php require("./components/header.php"); ?>

    <main>
        <section class="confirm_card text-center p-20 w-fit shadow border-curve">
            <div class="w-fit" style="margin: auto">
                <h1 class="heading">Confirm Order</h1>
                <hr>
            </div>
            <div class="p-20 checkout-details">
                <!-- data coming from js below -->
            </div>
        </section>

        <!-- ======================= eSewa form ======================= -->
        <form action="https://uat.esewa.com.np/epay/main" method="POST" class="esewa_form">
            <input value="100" name="tAmt" type="hidden">
            <input value="90" name="amt" type="hidden">
            <input value="5" name="txAmt" type="hidden">
            <input value="2" name="psc" type="hidden">
            <input value="3" name="pdc" type="hidden">
            <input value="EPAYTEST" name="scd" type="hidden">
            <input value="ee2c3ca1-696b-4cc5-a6be-2c40d929d453" name="pid" type="hidden">
            <input value="http://merchant.com.np/page/esewa_payment_success?q=su" type="hidden" name="su">
            <input value="http://merchant.com.np/page/esewa_payment_failed?q=fu" type="hidden" name="fu">
        </form>
    </main>

    <?php require "./components/footer.php"; ?>

    <script>
        const data = JSON.parse(localStorage.getItem("checkoutFormData"));
        const checkoutDetails = document.querySelector(".checkout-details");

        if (data) {
            const p = document.createElement("p");
            p.innerHTML = `
        
            ${data.name 
                ? `<div class="flex gap mt-20">
                    <p class="tal"> <b>Name:</b> </p>
                    <p class="tar"> ${data.name} </p>
                </div>`
                : ""
            }
            
            ${data.phone 
                ? `<div class="flex gap mt-20">
                    <p class="tal"> <b>Phone:</b> </p>
                    <p class="tar"> ${data.phone} </p>
                </div>`
                : ""
            }

            ${data.address 
                ? `<div class="flex gap mt-20">
                    <p class="tal"> <b>Address:</b> </p>
                    <p class="tar"> ${data.address} </p>
                </div>`
                : ""
            }
        
            ${data.note 
                ? `<div class="flex gap mt-20">
                    <p class="tal"> <b>Note:</b> </p>
                    <p class="tar"> ${data.note} </p>
                </div>`
                : ""
            }
            
            ${data.total_price 
                ? `<div class="flex gap mt-20">
                    <p class="tal"> <b>Total Price:</b> </p>
                    <p class="tar"> Rs. ${Math.ceil(parseInt(data.total_price))} </p>
                   </div>`
                : ""
            }
            
            ${data.pm 
                ? `<div class="flex gap mt-20">
                <p class="tal"> <b>Payment Method:</b> </p>
                <p class="tar"> ${data.pm == "cod" ? "Cash on Delivery" : "eSewa"} </p>
                </div>`
                : ""
            }

            ${data['date']
                ? `<div class="flex gap mt-20">
                    <p class="tal"> <b>Delivery Date:</b> </p>
                    <p class="tar"> ${data['date']} </p>
                </div>`
                : ""
            }

            ${data['time']
                ? `<div class="flex gap mt-20">
                    <p class="tal"> <b>Delivery Time:</b> </p>
                    <p class="tar"> ${data['time']} </p>
                </div>`
                : ""
            }

            ${data.pm == "cod" 
                ? `<button class="button border-curve mt-20 cod_btn">Place Order</button>`
                : ``
            }

            ${data.pm == "esewa" 
                ? `<button class="button border-curve mt-20 esewa_btn">Pay with eSewa</button>`
                : ``
            }

            ${data.msg 
                ? `<p class="mt-20">${data.msg}</p>`
                : ""
            }

            ${data.btn == "view order" 
                ? `<div class="mt-20"><a href="./track-order.php" class="button border-curve mt-20">View Order</a></div>`
                : ""
            }
        `;

            checkoutDetails.appendChild(p);
        }

        const placeOrder = () => {
            const codBtn = document.querySelector('.cod_btn');
            const esewaBtn = document.querySelector('.esewa_btn');
            const esewaForm = document.querySelector('.esewa_form');

            esewaBtn && esewaBtn.addEventListener('click', () => {
                esewaForm.submit();
            })

            codBtn && codBtn.addEventListener('click', () => {
                fetch('./backend/place-order.php', {
                        method: 'POST',
                        body: JSON.stringify(data)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            localStorage.removeItem('checkoutFormData');
                            localStorage.setItem('checkoutFormData', JSON.stringify({
                                "msg": "Your order was placed successfully",
                                "btn": "view order"
                            }));
                            window.location.href = './track-order.php'
                        } else {
                            alert(data.message)
                        }
                    })
                    .catch(err => {
                        console.error(err)
                    })
            })
        }

        placeOrder();
    </script>
    <script src="./js/app.js" type="module"></script>
</body>

</html>