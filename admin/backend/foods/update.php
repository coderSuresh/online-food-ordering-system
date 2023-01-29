<?php

session_start();

require('../../../config.php');
$response = array();

if (!isset($_SESSION['admin-success'])) {
    $response['status'] = "error";
    $response['msg'] = "You are not logged in";
    echo json_encode($response);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        function updateResponse($status, $msg)
        {
            $response['status'] = $status;
            $response['msg'] = $msg;
            echo json_encode($response);
            exit();
        }

        $id = mysqli_real_escape_string($conn, $_POST['f-id']);
        $isVeg = 0;
        $isDisabled = 0;
        $isSpecial = 0;
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

        // check if item is disabled
        $sql = "select name from food where disabled = 1 and f_id = $id";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            $isDisabled = 1;
        }

        // check if item is special
        $sql = "select name from food where special = 1 and f_id = $id";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);

        if (mysqli_num_rows($res) > 0) {
            $isSpecial = 1;
        }

        // get image info
        $target_dir = "../../../uploads/foods/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $temp_file = $_FILES["image"]["tmp_name"];
        $file_name = basename($_FILES["image"]["name"]);
        $uploadOk = 1;

        $isDuplicate = false;

        // get image name from db
        $sql_img = "select img from food where f_id = $id";
        $res_img = mysqli_query($conn, $sql_img);

        if ($res_img) {
            $row = mysqli_fetch_assoc($res_img);
            $imgName = $row['img'];

            if (!preg_match("/^[0-9]{10}[$file_name]+$/", $imgName)) {
                require('../validate-img.php');
            } else
                $isDuplicate = true;
        } else {
            $response['status'] = "error";
            $response['msg'] = "Could not get image from database";

            echo json_encode($response);
            exit();
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
                $row = mysqli_fetch_assoc($result);
                if ($name != $row['name']) {
                    updateResponse("error", "Food item already exists");
                }
            }

            if ($uploadOk == 0) {
                $response["status"] = "error";
                $response["msg"] = "Sorry, your file was not uploaded.";
                echo json_encode($response);
                exit();
            } else {
                if ($isDuplicate) {
                    // don't update image
                    $sql = "update food set name = '$name', price = $price, cost = $cost, cooking_time = $estimated_cooking_time, description = '$desc', veg = $isVeg, product_id = '$product_id', disabled = $isDisabled, special = $isSpecial, category = $cat_id where f_id = $id";
                    $res = mysqli_query($conn, $sql) or die("Could not update category name");
                } else {
                    if (move_uploaded_file($temp_file, $target_file)) {
                        // remove previous image
                        unlink($target_dir . $imgName);
                        // update name and image
                        $sql = "update food set img = '$file_name', name = '$name', price = $price, cost = $cost, cooking_time = $estimated_cooking_time, description = '$desc', veg = $isVeg, product_id = '$product_id', disabled = $isDisabled, special = $isSpecial, category = $cat_id where f_id = $id";
                        $res = mysqli_query($conn, $sql) or die("Could not update category");
                    } else {
                        $response["status"] = "error";
                        $response["msg"] = "Sorry, there was an error uploading your file.";
                        echo json_encode($response);
                        exit();
                    }
                }
            }
            if ($res) {
                $response['name'] = $name;
                $response['status'] = "success";
                $response['msg'] = "Food item updated successfully";
            } else {
                $response['status'] = "error";
                $response['msg'] = "Could not update food item";
                echo json_encode($response);
                exit();
            }
        }
        echo json_encode($response);
    } else {
        header('location: ../../../invalid.html');
    }
}
