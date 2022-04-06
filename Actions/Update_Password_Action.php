<?php
ob_start();
session_start();
require_once '../Includes/Config.php';
require_once '../Includes/Db.php';
$errors = [];
if(isset ($_POST)){
    $old_password = trim($_POST['old_password']);
    $New_Password = trim($_POST['New_Password']);
    $Confirm_Password= trim($_POST['Confirm_Password']);

    //validations 
    if(empty($old_password)){
        $errors[]= "old Password can not be empty.";
    }
    if(empty($New_Password)){
        $errors[]= "New Password can not be empty.";
    }

    if(empty($Confirm_Password)){
        $errors[]= "confirm New Password can not be empty.";
    }

    if(!empty (($New_Password) && !empty($Confirm_Password) && $New_Password !=$Confirm_Password)){
        $errors[]= "Password do not matched.";
    }
   if(!empty($errors)){
       $_SESSION['errors']=$errors;
       header('location:'.'../Change_password.php');
       exit();
   }
   $userid= (!empty($_SESSION['user']) && !empty($_SESSION['user']['id']))?
   $_SESSION['user']['id']:0;
   $conn=db_connect();
   $sql="SELECT * FROM `users` WHERE `id` = $userid";
   $sqlresult = mysqli_query($conn,$sql);
   if(mysqli_num_rows($sqlresult)>0){
       $userinfo= mysqli_fetch_assoc($sqlresult);
       $pwdindb= $userinfo['psw'];
       if(password_verify($old_password ,$pwdindb)){
        $newpasswordhash= password_hash( $New_Password,PASSWORD_DEFAULT);
        $updatepasssql="UPDATE `users` SET `psw`='$newpasswordhash' WHERE `id`='$userid'";
        if(mysqli_query($conn,$updatepasssql)){
            $_SESSION['success']= "New Password has been updated successfully";  
            header('location:'.'../Change_password.php');
        } db_close($conn);

       }else{
        $errors[]= "old  Password is incorrect !";   
        $_SESSION['errors']=$errors;
  header('location:'.'../Change_password.php');
        exit();
       }
   }}
?>