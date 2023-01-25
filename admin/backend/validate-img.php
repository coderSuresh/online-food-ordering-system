<?php

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
    $file_name = time() . $file_name;
    $target_file = $target_dir . $file_name;
}

// Check file size
if ($_FILES["image"]["size"] > 200000) {
    $response["status"] = "error";
    $response["msg"] = "Sorry, file should be less than 200KB.";
    $uploadOk = 0;
    echo json_encode($response);
    exit();
}
