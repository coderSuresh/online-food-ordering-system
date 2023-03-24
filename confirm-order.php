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
            <input value="100" id="tAmt" name="tAmt" type="hidden">
            <input value="100" id="amt" name="amt" type="hidden">
            <input value="0" id="txAmt" name="txAmt" type="hidden">
            <input value="0" name="psc" type="hidden">
            <input value="0" name="pdc" type="hidden">
            <input value="EPAYTEST" name="scd" type="hidden">
            <input value="<?php echo time(); ?>" name="pid" type="hidden">
            <input value="http://localhost/messy-code/components/esewa/success?q=su" type="hidden" name="su">
            <input value="http://localhost/messy-code/components/esewa/failed?q=fu" type="hidden" name="fu">
        </form>
    </main>

    <?php require "./components/footer.php"; ?>

    <script>
        const data = JSON.parse(
            document.cookie
            .split("; ")
            .find(row => row.startsWith("checkoutFormData"))
            .split("=")[1]
        );

        const checkoutDetails = document.querySelector(".checkout-details");

        const tAmt = document.getElementById("tAmt");
        const amt = document.getElementById("amt");
        const txAmt = document.getElementById("txAmt");

        amt.value = parseInt(data.total_price) - parseInt(data.vat);
        txAmt.value = data.vat;
        tAmt.value = data.total_price;

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
                            document.cookie = "checkoutFormData=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=http://localhost/messey-code;";
                            document.cookie = `checkoutFormData=${JSON.stringify({
                            msg: "Your order was placed successfully.",
                            btn: "view order"
                        })}; path=http://localhost/messey-code`;
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