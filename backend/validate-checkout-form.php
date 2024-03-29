<?php
session_start();
require '../config.php';
header('Content-Type: application/json; charset=utf-8');

$response = array();

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name']) && isset($data['phone']) && isset($data['address'])) {
    function showMessage($errorMessage)
    {
        $response['success'] = false;
        $response['message'] = $errorMessage;
        echo json_encode($response);
        exit();
    }
    $captcha = '';
    if (isset($data['g-recaptcha-response'])) {
        $captcha = $data['g-recaptcha-response'];
    }
    if (!$captcha) {
        showMessage("Please check the recaptcha checkbox first");
    } else {

        $isFromBuy = false;

        if (isset($data['f_id']) && isset($data['qty'])) {
            $isFromBuy = true;
            $f_id = mysqli_real_escape_string($conn, $data['f_id']);
            $q = mysqli_real_escape_string($conn, $data['qty']);
        } else if (isset($data['food_id']) && isset($data['quantity'])) {
            $isFromBuy = false;

            $food_id = mysqli_real_escape_string($conn, $data['food_id']);
            $qty = mysqli_real_escape_string($conn, $data['quantity']);

            $fo_id = unserialize(base64_decode($food_id));
            $quantity = unserialize(base64_decode($qty));
        } else {
            $isFromBuy = false;
            showMessage("Invalid request");
        }

        $uid = $_SESSION['user'];
        $name = mysqli_real_escape_string($conn, $data['name']);
        $phone = mysqli_real_escape_string($conn, $data['phone']);
        $address = mysqli_real_escape_string($conn, $data['address']);
        $note = mysqli_real_escape_string($conn, $data['note']);
        $payment_method = mysqli_real_escape_string($conn, $data['payment-method']);

        $pm = "";

        if ($payment_method == "payment-method-cod") {
            $pm = "cod";
        } else if ($payment_method == "payment-method-esewa") {
            $pm = "esewa";
        }

        if ($note == "") {
            $note = "No note";
        }

        if (!preg_match("/^[a-z A-z]{2,}$/", $name)) {
            showMessage("Name must contain only letters and must be at least 2 characters long");
        } else if (!preg_match("/^98\d{8}|0\d{8}$/", $phone)) {
            showMessage("Phone number must contain only 10 digits & start with 98");
        } else if (!preg_match("/^[a-zA-z,0-9 -]{5,}$/", $address)) {
            showMessage("Address must contain only letters, numbers, commas and must be at least 5 characters long");
        } else if (!preg_match("/^[a-z A-z\/0-9:,]{5,}$/", $note)) {
            showMessage("Note must contain only letters, numbers and must be at least 5 characters long");
        } else {

            $start_time = "09:00";
            $end_time = "21:00";

            require '../components/get-current-timestamp.php';
            $current_date = getCurrentDate();
            $current_time = getCurrentTime();

            if (isset($data['date']) && isset($data['time'])) {
                $date = mysqli_real_escape_string($conn, $data['date']);
                $time = mysqli_real_escape_string($conn, $data['time']);

                if ($date == "" || $time == "") {
                    showMessage("Please select a date and time");
                } elseif ($date < $current_date || $date == $current_date && $time < $current_time) {
                    showMessage("Please select a date and time in the future");
                } elseif ($time < date('H:i', strtotime($start_time . ' +30 minutes')) || $time > $end_time) {
                    showMessage("We are closed now. Please select a date and time in the future");
                } elseif ($date > date('Y-m-d', strtotime($current_date . ' +3 day'))) {
                    showMessage("You can't order for more than 3 days in advance");
                } elseif ( $date <= $current_date && $time < date('H:i', strtotime($current_time . ' +30 minutes'))) {
                    showMessage("You can't order for less than 30 minutes in advance");
                } else {
                    $response['redirect'] = true;
                    $response['pm'] = $pm;
                    $response['location'] = "./confirm-order.php";
                    echo json_encode($response);
                    exit();
                }
            } else if ($current_time < date('H:i', strtotime($start_time . ' +30 minutes')) || $current_time > $end_time) {
                showMessage("We are closed now. Please select a date and time in the future");
            } else {
                $response['redirect'] = true;
                $response['pm'] = $pm;
                $response['location'] = "./confirm-order.php";
                echo json_encode($response);
                exit();
            }
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request";
    echo json_encode($response);
    exit();
}
