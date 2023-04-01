<?php
$total_pages = ceil($count / $limit);
if (isset($_GET['page'])) {
    $page = mysqli_real_escape_string($conn, $_GET['page']);
    if (!is_numeric($page)) {
        $page = 1;
    }
} else {
    $page = 1;
}

$offset = intval(($page - 1) * $limit);
?>