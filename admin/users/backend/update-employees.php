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
        $isDuplicatePass = false;
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['con-password']);

        $sql_password = "SELECT password from employees WHERE emp_id = $id";
        $res_password = mysqli_query($conn, $sql_password);
        $row = mysqli_fetch_assoc($res_password);
        if ($password != $row["password"]) {
            if ($password != $confirm_password) {
                $response['status'] = "error";
                $response['msg'] = "Password does not match";
                echo json_encode($response);
                exit();
            } else {
                $password = md5($password);
            }
        } else {
            $isDuplicatePass = true;
        }

        // upload image to server 
        $target_dir = "../../../uploads/employees/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $temp_file = $_FILES["image"]["tmp_name"];
        $file_name = basename($_FILES["image"]["name"]);
        $uploadOk = 1;

        $isDuplicate = false;
        // get image name from db
        $sql_img = "select image from employees where emp_id = $id";
        $res_img = mysqli_query($conn, $sql_img);

        if ($res_img) {
            $row = mysqli_fetch_assoc($res_img);
            $imgName = $row['image'];

            if (!preg_match("/^[0-9]{10}[$file_name]+$/", $imgName)) {
                require('../../backend/validate-img.php');
            } else
                $isDuplicate = true;
        } else {
            $response['status'] = "error";
            $response['msg'] = "Could not get image from database";
            echo json_encode($response);
            exit();
        }

        if (!preg_match("/^[A-Z a-z]{2,30}$/", $name)) {
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
                if ($isDuplicate || $isDuplicatePass) {
                    if ($isDuplicate) {
                        $sql_wo_img = "update employees set name ='$name', username = '$username', password = '$password', department = $department, email = '$email'  where emp_id = $id ";
                        $res = mysqli_query($conn, $sql_wo_img) or die("Could not update employee");
                    } else if ($isDuplicatePass) {
                        if (move_uploaded_file($temp_file, $target_file)) {
                            // remove previous image
                            unlink($target_dir . $imgName);
                            $sql_wo_pass = "update employees set name ='$name', username = '$username', image = '$file_name', department = $department, email = '$email' where emp_id = $id ";
                            $res = mysqli_query($conn, $sql_wo_pass) or die("Could not update employee");
                        } else {
                            $response["status"] = "error";
                            $response["msg"] = "Sorry, there was an error uploading your file.";
                            echo json_encode($response);
                            exit();
                        }
                    }
                } else {
                    if (move_uploaded_file($temp_file, $target_file)) {
                        // remove previous image
                        unlink($target_dir . $imgName);
                        // update name and image
                        $sql = "update employees set name ='$name', username = '$username', image = '$file_name', department = $department, email = '$email', password = '$password' where emp_id = $id";
                        $res = mysqli_query($conn, $sql) or die("Could not update employee");
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
                $response['msg'] = "Employee updated successfully";
            } else {
                $response['status'] = "error";
                $response['msg'] = "Could not update employee";
                echo json_encode($response);
                exit();
            }
        }
        echo json_encode($response);
    } else {
        $response['status'] = "error";
        $response['msg'] = "Invalid request";
        echo json_encode($response);
        exit();
    }
}
