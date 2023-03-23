<?php
session_start();
require('../config.php');
require('../components/get-current-timestamp.php');

header('Content-Type: application/json; charset=utf-8');

$response = array();

// $_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address'])) {

    $isFromBuy = false;

    if (isset($_POST['f_id']) && isset($_POST['qty'])) {
        $isFromBuy = true;
        $f_id = mysqli_real_escape_string($conn, $_POST['f_id']);
        $q = mysqli_real_escape_string($conn, $_POST['qty']);
    } else if (isset($_POST['food_id']) && isset($_POST['quantity'])) {
        $isFromBuy = false;

        $food_id = mysqli_real_escape_string($conn, $_POST['food_id']);
        $qty = mysqli_real_escape_string($conn, $_POST['quantity']);

        $fo_id = unserialize(base64_decode($food_id));
        $quantity = unserialize(base64_decode($qty));
    } else {
        $isFromBuy = false;
        showMessage("Invalid request");
    }

    $uid = $_SESSION['user'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    if ($note == "") {
        $note = "No note";
    }

    function showMessage($errorMessage)
    {
        $response['success'] = false;
        $response['message'] = $errorMessage;
        echo json_encode($response);
        exit();
    }

    function placeOrder($f_id, $q, $track_id, $uid, $note, $conn, $o_c_id)
    {
        $sql_food_info = "select price from food where f_id = $f_id";
        $res_food_info = mysqli_query($conn, $sql_food_info) or die("Could not get food info");
        $row_food_info = mysqli_fetch_assoc($res_food_info);
        $price = $row_food_info['price'];

        $total_price = (intval($price) * intval($q));
        $vat = $total_price * 13 / 100;
        $total_price = $total_price + $vat;

        $date = getCurrentTimestamp();

        $sql = "insert into orders values (DEFAULT, $uid, '$track_id', $o_c_id, $q, $f_id, $total_price, '$note', '$date')";
        $res = mysqli_query($conn, $sql) or die("Could not place order");
        $order_id = mysqli_insert_id($conn);

        $sql_aos = "insert into aos values (DEFAULT, $order_id, 'pending', '$date')";
        $res_aos = mysqli_query($conn, $sql_aos) or die("Could not insert into aos");

        if ($res && $res_aos) {
            $sql_remove_cart = "delete from cart where food_id = $f_id and customer_id = $uid";
            mysqli_query($conn, $sql_remove_cart) or die("Could not remove from cart");
        } else {
            $_SESSION['order_placed'] = "Order could not be placed";
            $response['success'] = false;
            $response['message'] = "Could not place order";
            echo json_encode($response);
            exit();
        }

        if ($res && $res_aos) {
            $_SESSION['order_placed'] = "Order placed successfully";
            $response['success'] = true;
            $response['message'] = "Order placed successfully";
            return $response;
        } else {
            $_SESSION['order_placed'] = "Order could not be placed";
            $response['success'] = false;
            $response['message'] = "Could not place order";
            echo json_encode($response);
            exit();
        }
    }

    function insertContactDetails($address, $phone, $name, $conn)
    {
        $sql_o_c_t = "insert into order_contact_details values (DEFAULT, '$address', '$phone', '$name')";
        $res_o_c_t = mysqli_query($conn, $sql_o_c_t) or die("Could not insert order contact details");
        $o_c_t_id = mysqli_insert_id($conn);

        if ($res_o_c_t) {
            return $o_c_t_id;
        } else {
            return 0;
        }
    }

    if (!preg_match("/^[a-z A-z]{2,}$/", $name)) {
        showMessage("Name must contain only letters and must be at least 2 characters long");
    } else if (!preg_match("/^98\d{8}|0\d{8}$/", $phone)) {
        showMessage("Phone number must contain only 10 digits & start with 98");
    } else if (!preg_match("/^[a-zA-z,0-9 -]{5,}$/", $address)) {
        showMessage("Address must contain only letters, numbers, commas and must be at least 5 characters long");
    } else if (!preg_match("/^[a-z A-z\/0-9]{5,}$/", $note)) {
        showMessage("Note must contain only letters, numbers and must be at least 5 characters long");
    } else {

        $sql_get_track_id = "select track_id from orders order by track_id desc limit 1";
        $res_get_track_id = mysqli_query($conn, $sql_get_track_id) or die("Could not get track id");
        $row_get_track_id = mysqli_fetch_assoc($res_get_track_id);

        if (mysqli_num_rows($res_get_track_id) > 0) {
            $track_id = $row_get_track_id['track_id'];
            $track_id = intval(str_replace("rh", "", $track_id)) + 1;
            $track_id = "rh" . str_pad($track_id, 8, "0", STR_PAD_LEFT);
        } else {
            $track_id = "rh00000000";
        }

        if ($isFromBuy) {
            $o_c_id = insertContactDetails($address, $phone, $name, $conn);
            if ($o_c_id == 0) {
                showMessage("Could not place order");
            } else {
                $response = placeOrder($f_id, $q, $track_id, $uid, $note, $conn, $o_c_id);
            }
        } else {
            $o_c_id = insertContactDetails($address, $phone, $name, $conn);
            if ($o_c_id == 0) {
                showMessage("Could not place order");
            } else {
                foreach (array_combine($fo_id, $quantity) as $f_id => $q) {
                    $response = placeOrder($f_id, $q, $track_id, $uid, $note, $conn, $o_c_id);
                }
            }
        }

        echo json_encode($response);
        exit();
    }
} else {
    header("Location: ../invalid.html");
}
