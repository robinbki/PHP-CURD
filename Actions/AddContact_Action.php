<?php
ob_start();
session_start();
require_once '../Includes/Config.php';
require_once '../Includes/Db.php';
$errors = [];
if(isset ($_POST) && !empty($_SESSION['user'])){
    $firstname = trim($_POST['fname']);
    $lasttname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $userphoto = !empty($_FILES ['photo']) ? $_FILES ['photo']:[] ;
    $cid =!empty($_POST['cid'])?$_POST['cid']:'';
    //validations
    if(empty($firstname)){
        $errors[]= "first name can not be empty.";
    }
   
    if(empty($email)){
        $errors[]= "Email can not be empty.";
    }

    if(!empty($email && !filter_var($email,FILTER_VALIDATE_EMAIL))){
        $errors[]= "Email address is not valid.";
    }
    
    if(empty($phone)){
        $errors[]= "Phone number can not be empty.";
    }
    if(!empty($phone) && (strlen($phone)>10 ||strlen($phone)<10 )){
        $errors[]= "Invalid Phone number.";
    }

    if(!empty($phone) && !is_numeric($phone)){
        $errors[]= "Phone number Should be in number.";
    }

    if(empty($address)){
        $errors[]= "Address can not be empty.";
    }

    if(!empty($errors)){
        $_SESSION['errors']=$errors;
        header('location:'.SITEURL.'../Addcontact.php');
        exit();
    }
    //uploading user photo
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
            $uploadfiledir ='../Uploads/Photos';
            $destfilepath= $uploadfiledir. $photoname;
            if(move_uploaded_file($filetemppath,$destfilepath)){
                $errors[]="file could not be uploaded";
            }
        }else{
            $errors[]="invalid photo file extension";
        }

    }
    $ownderid = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id']))?$_SESSION['user']['id']:0;
        if(!empty($cid)){
            //update exiting record
            //if photo name exits
            if(!empty($photoname)){
                $sql= "UPDATE `contacts` SET `f_name`='$firstname',`l_name`='$lasttname',`email`='$email',`phone`='$phone',`adrs`='$address',`photo`='$photoname' WHERE `id`='$cid' AND `owner_id`='$ownderid'";
            }else{
                //if no photo name selected
                $sql= "UPDATE `contacts` SET `f_name`='$firstname',`l_name`='$lasttname',`email`='$email',`phone`='$phone',`adrs`='$address' WHERE `id`='$cid' AND `owner_id`='$ownderid'";
     
            }
            $msg = "contact has been Updated successfully";
        }else{
    //insert new record
            $sql= "INSERT INTO `contacts`( `f_name`, `l_name`, `email`, `phone`, `adrs`, `photo`, `owner_id`) VALUES ('$firstname','$lasttname','$email','$phone','$address','$photoname','$ownderid')";
            $msg = "New contact has been added successfully";
        }
   $conn = db_connect();
   //printrr($sql);
   // die();
   if(mysqli_query($conn, $sql)){
       db_close($conn);
       $_SESSION['success']=$msg;
       header('location:'.SITEURL);
   }
}

   
   