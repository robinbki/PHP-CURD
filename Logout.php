<?php
ob_start();
session_start();
require_once './Includes/Config.php';
$errors = [];
if(isset ($_SESSION['user'])){
    unset( $_SESSION['user']);
    session_destroy();
    header('location:'.SITEURL);
}
?>