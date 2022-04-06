<?php
ob_start();
session_start();
require_once './Includes/Config.php';
$user= !empty( $_SESSION['user']) ?  $_SESSION['user']:[];
$currentpage = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '' ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Book</title>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo SITEURL; ?>../Public/Css/Stylee.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
<div class="container">
  <a class="navbar-brand" href="<?php echo SITEURL; ?>"><i class="fa fa-address-book"></i> ContactBook</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item <?php if($currentpage== SITEURL) {echo "active";}  ?>">
        <a class="nav-link" href="<?php echo SITEURL; ?>">Home <span class="sr-only">(current)</span></a>
      </li>
      <?php
      if(empty($user)){
      ?>
            <li class="nav-item  <?php if($currentpage== SITEURL.'./Signup.php') {echo "active";}  ?>">
        <a class="nav-link" href="<?php echo SITEURL.'./Signup.php'?>">Signup</a>
      </li>
      <li class="nav-item <?php if($currentpage== SITEURL.'../login.php') {echo "active";}  ?>" >
        <a class="nav-link" href="<?php echo SITEURL.'../login.php'?>">Login</a>
      </li>
      <?php
      }
      if(!empty($user)){
      ?>
       <li class="nav-item <?php if($currentpage== SITEURL.'../Addcontact.php') {echo "active";}  ?>"  >
        <a class="nav-link" href="<?php echo SITEURL.'../Addcontact.php'?>">Add Contact</a>
      </li>
      <li class="nav-item dropdown <?php if($currentpage== SITEURL.'../Profile.php') {echo "active";}?> ">
        <a class="nav-link dropdown-toggle" href="<?php echo SITEURL.'../Profile.php'?>" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php
     echo !empty($user['first_name']) ?$user['first_name']: 'Guest';
      ?>       </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?php echo SITEURL.'./Profile.php'?>">Profile</a>
          <a class="dropdown-item" href="<?php echo SITEURL.'./Edit_profile.php'?>">Edit_profile</a>
          <a class="dropdown-item" href="<?php echo SITEURL.'./Change_password.php'?>">Change_password</a>
          <a class="dropdown-item" href="<?php echo SITEURL.'./Logout.php'?>">Logout</a>
        </div>
      </li>
      <?php
      }
      ?>
          </ul>
  </div>
  </div>
</nav>
<main role="main" class="container">