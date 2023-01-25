<?php
include('../../../config.php');
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = mysqli_real_escape_string($conn, $_POST['cat-id']);
    $name = mysqli_real_escape_string($conn, $_POST['category']);

    // upload image to server 
    $target_dir = "../../../uploads/category/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $temp_file = $_FILES["image"]["tmp_name"];
    $file_name = basename($_FILES["image"]["name"]);
    $uploadOk = 1;

    $isDuplicate = false;

    // get image name from db
    $sql_img = "select image from category where cat_id = $id";
    $res_img = mysqli_query($conn, $sql_img);

    if ($res_img) {
        $row = mysqli_fetch_assoc($res_img);
        $imgName = $row['image'];

        if ($imgName != $file_name) {
            require('../validate-img.php');
        } else
            $isDuplicate = true;
    } else {
        $response['status'] = "error";
        $response['msg'] = "Could not get image from database";

        echo json_encode($response);
        exit();
    }

    if ($uploadOk == 0) {
        $response["status"] = "error";
        $response["msg"] = "Sorry, your file was not uploaded.";
        echo json_encode($response);
        exit();
    } else {
        if (move_uploaded_file($temp_file, $target_file)) {
            // update category name
            $query_string = $isDuplicate ? "" : ", image='$file_name'";
            $sql = "UPDATE category SET name = '$name', image = '$file_name' WHERE cat_id = $id";
            $res = mysqli_query($conn, $sql);
        } else {
            $response["status"] = "error";
            $response["msg"] = "Sorry, there was an error uploading your file.";
            echo json_encode($response);
            exit();
        }
    }

    if ($res) {
        $response['status'] = "success";
        $response['msg'] = "Category updated successfully";
    } else {
        $response['status'] = "error";
        $response['msg'] = "Could not update category";
    }

    echo json_encode($response);
} else {
    $response['status'] = "error";
    $response['msg'] = "Invalid request";

    echo json_encode($response);
}
