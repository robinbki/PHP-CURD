<?php
ob_start();
session_start();
require_once '../Includes/Config.php';
require_once '../Includes/Db.php';

$errors = [];
if(isset ($_POST)){
    $firstname = trim($_POST['fname']);
    $lasttname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $pwd = trim($_POST['password']);
    $cpwd= trim($_POST['cpassword']);

    //validations
    if(empty($firstname)){
        $errors[]= "first name can not be empty.";
    }
    if(empty($lasttname)){
        $errors[]= "last name can not be empty.";
    }
    if(empty($email)){
        $errors[]= "Email can not be empty.";
    }

    if(!empty($email && !filter_var($email,FILTER_VALIDATE_EMAIL))){
        $errors[]= "Email address is not valid.";
    }
    
    if(empty($pwd)){
        $errors[]= "Password can not be empty.";
    }
    if(empty($cpwd)){
        $errors[]= "confirm Password can not be empty.";
    }

    if(!empty (($pwd) && !empty($cpwd) && $pwd !=$cpwd)){
        $errors[]= "Password do not matched.";
    }
   

    //email already exits

    if(!empty ($email)){
        $conn = db_connect();
        $santizemail = mysqli_real_escape_string($conn,$email);
        $emailsql = "SELECT `id` FROM `users` WHERE `email` ='$santizemail'";
        $sqlresult = mysqli_query($conn,$emailsql);
        $emailrow= mysqli_num_rows($sqlresult);
        if($emailrow>0){
            $errors[]= "Email already exits";
           
        }db_close($conn);
       
    }
    if(!empty($errors)){
        $_SESSION['errors']= $errors;
        header('location:'.SITEURL.'../Signup.php');
        exit();
    }
   
    //if no error
    $passwordhash = password_hash($pwd,PASSWORD_DEFAULT);
    $sql="INSERT INTO `users`(`first_name`, `last_name`, `email`, `psw`) VALUES ('$firstname','$lasttname','$email','$passwordhash')";
    $conn= db_connect();
    if(mysqli_query($conn,$sql)){
        db_close($conn);
        $msg = "you are register successfully";
        $_SESSION['success']=$msg;
        header('location:'.SITEURL.'../Signup.php');
    }
}
?>