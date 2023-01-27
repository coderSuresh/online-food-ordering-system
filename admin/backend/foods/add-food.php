<?php
session_start();
include '../../../config.php';
header("Content-Type: application/json; charset=UTF-8");

// response holder
$response = array();

if (!isset($_SESSION['admin-success'])) {
    $response['status'] = "error";
    $response['msg'] = "You are not logged in";
    echo json_encode($response);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // function for response status update
        function updateResponse($status, $msg)
        {
            $response['status'] = $status;
            $response['msg'] = $msg;
            echo json_encode($response);
            exit();
        }

        // get image info
        $target_dir = "../../../uploads/foods/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $temp_file = $_FILES["image"]["tmp_name"];
        $file_name = basename($_FILES["image"]["name"]);
        $uploadOk = 1;

        require('../validate-img.php');

        // get data from form
        $isVeg = 0;
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $cost = mysqli_real_escape_string($conn, $_POST['cost']);
        $cat_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $estimated_cooking_time = mysqli_real_escape_string($conn, $_POST['estimated-cooking-time']);
        $product_id = mysqli_real_escape_string($conn, $_POST['product-id']);
        $veg_non_veg = mysqli_real_escape_string($conn, $_POST['veg-non-veg']);

        if (isset($_POST['veg-non-veg'])) {
            if ($veg_non_veg == "veg") {
                $isVeg = 1;
            }
        }

        if (!preg_match("/^[A-Z a-z]{2,30}$/", $name)) {
            updateResponse("error", "Name should contain alphabet only");
        } else if (!preg_match("/^[0-9]+$/", $price)) {
            updateResponse("error", "Price should contain numbers only");
        } else if (!preg_match("/^[0-9]+$/", $cost)) {
            updateResponse("error", "Cost should contain numbers only");
        } else if (!preg_match("/^[0-9]+$/", $estimated_cooking_time)) {
            updateResponse("error", "Estimated cooking time should contain numbers only");
        } else if (!preg_match("/^[A-Za-z0-9]+$/", $product_id)) {
            updateResponse("error", "Product ID should not contain special characters");
        } else {

            // check if food item already exists
            $sql = "SELECT name FROM food WHERE name = '$name'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                updateResponse("error", "Food item already exists");
            }

            if ($uploadOk == 0) {
                updateResponse("error", "Sorry, your file was not uploaded.");
            } else {
                if (move_uploaded_file($temp_file, $target_file)) {
                    // insert into database
                    $sql = "INSERT INTO food VALUES (DEFAULT, '$file_name', '$name', $price, $cost, $estimated_cooking_time, '$desc', $isVeg, '$product_id', $cat_id)";
                    $result = mysqli_query($conn, $sql);
                } else {
                    updateResponse("error", "Sorry, there was an error uploading your file.");
                }
            }

            if ($result) {
                $response['status'] = "success reset";
                $response['msg'] = $name . " has been added successfully";
            } else {
                updateResponse("error", "Something went wrong");
            }
        }

        echo json_encode($response);
    } else {
        header('location: ../../../invalid.html');
    }
}
