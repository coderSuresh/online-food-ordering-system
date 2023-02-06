<?php
session_start();
if (isset($_SESSION['test'])) {
    echo $_SESSION['test'];
} else {
    echo "not set";
}
