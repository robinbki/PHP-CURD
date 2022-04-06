<?php
ob_start();
session_start();
require_once '../Includes/Config.php';
require_once '../Includes/Db.php';
$errors = [];
if(isset ($_POST)){
    $email = trim($_POST['email']);
    $pwd = trim($_POST['password']);

    if(empty($email)){
        $errors[]= "Email can not be empty.";
    }
    if(!empty($email && !filter_var($email,FILTER_VALIDATE_EMAIL))){
        $errors[]= "Email address is not valid.";
    }
    
    if(empty($pwd)){
        $errors[]= "Password can not be empty.";
    }

    if(!empty($errors)){
        $_SESSION['errors']= $errors;
        header('location:'.SITEURL.'../login.php');
    }
    //if no errors
    if(!empty($email) && !empty($pwd)){
     $conn= db_connect();
     $emailsanitize= mysqli_real_escape_string($conn,$email);
     $sql= "SELECT * FROM `users` WHERE `email`='$emailsanitize'";
     $mysqlresult= mysqli_query($conn,$sql);
     if(mysqli_num_rows($mysqlresult)> 0){
         $userinfo= mysqli_fetch_assoc($mysqlresult);
        // var_dump($userinfo);
        // die();
         if(!empty($userinfo)){
             $pwdindb=$userinfo['psw'];
             if(password_verify($pwd,$pwdindb)){
                 
                 unset($userinfo['psw']);
                 $_SESSION['user']= $userinfo;
                 $request_url= !empty($_SESSION['request_url'])?$_SESSION['request_url']:SITEURL;
                 unset($_SESSION['request_url'] );
                 header('location:'.$request_url);

             }else{
                $errors[]= "incorrect password";
                $_SESSION['errors']= $errors;
                header('location:'.SITEURL.'../login.php');
                exit();
             }
         }
     }else{
        $errors[]= "incorrect Email address";
        $_SESSION['errors']= $errors;
        header('location:'.SITEURL.'../login.php');
        exit();
     }
    }
}
?>

