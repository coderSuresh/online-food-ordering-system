<?php
session_start();

include '../../../config.php';

// response holder
$response = array();

if (!isset($_SESSION['success'])) {
    $response['status'] = "error";
    $response['msg'] = "You are not logged in";
    echo json_encode($response);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // upload image to server 
        $target_dir = "../../../uploads/category/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $temp_file = $_FILES["image"]["tmp_name"];
        $file_name = basename($_FILES["image"]["name"]);
        $uploadOk = 1;

        // Check if image file is an actual image 
        $check = getimagesize($temp_file);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $response["status"] = "error";
            $response["msg"] = "File is not an image.";
            $uploadOk = 0;
            echo json_encode($response);
            exit();
        }

        // Check for existing file
        if (file_exists($target_file)) {
            $response["status"] = "error";
            $response["msg"] = "Sorry, file with same name already exists.";
            echo json_encode($response);
            $uploadOk = 0;
            exit();
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 200000) {
            $response["status"] = "error";
            $response["msg"] = "Sorry, file should be less than 200KB.";
            $uploadOk = 0;
            echo json_encode($response);
            exit();
        }

        $category = mysqli_real_escape_string($conn, $_POST['category']);

        if (!preg_match("/^[A-Z a-z]{2,30}$/", $category)) {
            $response['status'] = "error";
            $response['msg'] = "Name should contain alphabet only";
            echo json_encode($response);
            exit();
        } else {

            if ($uploadOk == 0) {
                $response["status"] = "error";
                $response["msg"] = "Sorry, your file was not uploaded.";
                echo json_encode($response);
                exit();
            } else {
                if (move_uploaded_file($temp_file, $target_file)) {
                    $response["status"] = "success";
                    $response["msg"] = "The file has been uploaded.";

                    // insert into database
                    $sql = "INSERT INTO category VALUES (DEFAULT, '$file_name', '$category')";
                    $result = mysqli_query($conn, $sql);
                } else {
                    $response["status"] = "error";
                    $response["msg"] = "Sorry, there was an error uploading your file.";
                    echo json_encode($response);
                    exit();
                }
            }

            if ($result) {
                $response['status'] = "success";
                $response['msg'] = "Category added successfully";
            } else {
                $response['status'] = "error";
                $response['msg'] = "Failed to add category";
                echo json_encode($response);
                exit();
            }
        }

        echo json_encode($response);
    } else {
        header('location: ../../../invalid.html');
    }
}
