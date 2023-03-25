<?php
session_start();

$url = "https://uat.esewa.com.np/epay/transrec";
$data = [
    'amt' => $_GET['amt'],
    'rid' => $_GET['refId'],
    'pid' => $_GET['oid'],
    'scd' => 'EPAYTEST'
];

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

if (str_contains($response, "Success")) {

    if (isset($_SESSION['order_success'])) {
        // TODO: redirect to thank you page or something
        header("Location: ../../track-order.php");
        exit();
    }

?>

    <script>
        const data = JSON.parse(
            document.cookie
            .split("; ")
            .find(row => row.startsWith("checkoutFormData"))
            .split("=")[1]
        );
        const url = "../../backend/place-order.php";

        fetch(url, {
                method: "POST",
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {

                    <?php $_SESSION['order_success'] = "Your order was placed successfully."; ?>

                    document.cookie = "checkoutFormData=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/messey-code;";
                    document.cookie = `checkoutFormData=${JSON.stringify({
                            msg: "Your order was placed successfully.",
                            btn: "view order"
                        })}; path=/messey-code;`;


                    <?php
                    if (isset($_SESSION['order_success'])) {
                        echo "window.location.href = '../../track-order.php';";
                    }
                    ?>

                } else {
                    window.location.href = "./failed.php";
                }
            })
            .catch(err => {
                console.error(err);
            })
    </script>

<?php

    // remove cookie
    setcookie("checkoutFormData", "", time() - 3600, "/messey-code/");
} else {
    header("Location: ./failed.php");
}
?>