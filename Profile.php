<?php
    include_once './Common/Header.php';
    require_once './Includes/Db.php';
    if(empty($_SESSION['user'])){
        $currentpage = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '' ;
        $_SESSION['request_url']=$currentpage;
        header('location:'.SITEURL.'./login.php');
        exit();
    }
    $userid =$_SESSION['user']['id'];
    $conn=db_connect();
    $sql="SELECT * FROM `users` WHERE `id` = $userid";
    $sqlresult = mysqli_query($conn,$sql);
    if(mysqli_num_rows($sqlresult)>0){
        $userinfo= mysqli_fetch_assoc($sqlresult);
    }else{
        echo "user not found !";
        exit();
    }
    db_close($conn);
    ?>
    
<div class="row justify-content-center wrapper">
<div class="col-md-6">
<div class="card">
<header class="card-header">
	<h4 class="card-title mt-2">Profile</h4>
</header>
<article class="card-body">
<div class="container" id="profile"> 
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <img src="<?php echo !empty($userinfo['profile_photo']) ? SITEURL."./Uploads/Profilephoto".$userinfo['profile_photo'] : "https://via.placeholder.com/50.png/09f/666";?>" alt="" class="rounded-circle profile_photo" />
            </div>
            <div class="col-sm-6 col-md-8">
                <h4 class="text-primary">
                <?php
                echo $userinfo['first_name'].' '.$userinfo['last_name'];
                ?>
                </h4>
                <p class="text-secondary">
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                <?php
                echo $userinfo['email'];
                ?>         <br />
                </p>
                <!-- Split button -->
            </div>
        </div>

    </div>  
</article>

</div>
</div>
</div>
<?php
    include_once './Common/Footer.php';
    ?>
    