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
    $userphoto = !empty($_FILES ['photo']) ? $_FILES ['photo']:[] ;

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

    //photo upload

    $photoname = '';
    if(!empty($userphoto['name'])){
        $filetemppath= $userphoto['tmp_name'];
        $filename = $userphoto['name'];
        $filenamecmp = explode('.',$filename);
        $fileextension = strtolower(end($filenamecmp));
        $filenewname = md5(time().$filename).'.'.$fileextension ;
        $photoname = $filenewname;

        $allowedext= ['jpeg','jpg','png', 'gif'];
        if(in_array($fileextension,$allowedext)){
            $uploadfiledir ='../Uploads/Profilephoto';
            $destfilepath= $uploadfiledir. $photoname;
            if(move_uploaded_file($filetemppath,$destfilepath)){
                $errors[]="file could not be uploaded";
            }
        }else{
            $errors[]="invalid photo file extension";
        }

    }
    //photo upload end.. 

    $userid= (!empty($_SESSION['user']) && !empty($_SESSION['user']['id']))?$_SESSION['user']['id']:0; 
  
    if(!empty( $userid)){
        if(! empty ($photoname)){
            $sql="UPDATE `users` SET `first_name`='$firstname',`last_name`='$lasttname',`email`='$email',`profile_photo`='$photoname' WHERE `id`='$userid'";

        }else{
            $sql="UPDATE `users` SET `first_name`='$firstname',`last_name`='$lasttname',`email`='$email' WHERE `id`='$userid'";
        }
        $conn= db_connect();
        if (mysqli_query($conn,$sql)){
            $_SESSION['success']= "profile has been updated successfully";
            db_close($conn);
            header('location:'.'../Profile.php');
        }
    } 
}
?>