<?php
ob_start();
session_start();
    include_once './Includes/Config.php';
    require_once './Includes/Db.php';
    if(empty($_SESSION['user'])) {
        header('location:'.SITEURL.'./login.php');
        exit();
    }
    if(!empty($_GET['id']) && is_numeric($_GET['id'])){
        $userid=$_SESSION['user']['id'];
        $contactid=$_GET['id'];
        $conn= db_connect();
        $cid= mysqli_real_escape_string($conn,$contactid);
        $deletesql= "DELETE FROM `contacts` WHERE `id`='  $cid' AND `owner_id`='$userid'";
        if(mysqli_query($conn,$deletesql)){
            db_close($conn);
            $_SESSION['success']="Contact has been deleted successfully";
            header('location:'.SITEURL);
        }
    }else{
        echo 'invalid contact id';
        exit();
    }
    ?>