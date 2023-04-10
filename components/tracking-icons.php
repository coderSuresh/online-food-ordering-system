<?php
$status = isset($status) ? $status : 'pending';

if ($status == 'pending') {
    echo '<div class="ti_success">Pending</div>';
    echo '<div class="line"></div>';
    echo '<div class="ti_success not">Accepted</div>';
    echo '<div class="line"></div>';
    echo '<div class="ti_success not">Delivered</div>';
} else if ($status == 'accepted') {
    echo '<div class="ti_success">Pending</div>';
    echo '<div class="line"></div>';
    echo '<div class="ti_success">Accepted</div>';
    echo '<div class="line"></div>';
    echo '<div class="ti_success not">Delivered</div>';
} else if ($status == 'rejected') {
    echo '<div class="ti_success">Pending</div>';
    echo '<div class="line"></div>';
    echo '<div class="ti_success reject">Rejected</div>';
    echo '<div class="line"></div>';
    echo '<div class="ti_success not">Delivered</div>';
} else if ($status == 'delivered') {
    echo '<div class="ti_success">Pending</div>';
    echo '<div class="line"></div>';
    echo '<div class="ti_success">Accepted</div>';
    echo '<div class="line"></div>';
    echo '<div class="ti_success">Delivered</div>';
}
?>