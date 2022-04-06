<?php
include_once './Common/Header.php';
require_once './Includes/Db.php';
if(empty($_SESSION['user'])) {
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
    //printrr($userinfo);
?>
<style>
    .wrapper {
        padding-top: 30px;
    }
</style>
<div class="row justify-content-center wrapper">
    <div class="col-md-6">
     <?php
     include_once './Common/alert_msg.php';
     ?>
        <div class="card">
            <header class="card-header">
                <h4 class="card-title mt-2">Edit Profile</h4>
            </header>
            <article class="card-body">
            <form method="POST" action="<?php echo SITEURL.'./Actions/Update_Profile_Action.php'?>" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col form-group">
                            <label>First name </label>
                            <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo $userinfo['first_name'] ;?>">
                        </div> <!-- form-group end.// -->
                        <div class="col form-group">
                            <label>Last name</label>
                            <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $userinfo['last_name'] ;?>">
                        </div> <!-- form-group end.// -->
                    </div> <!-- form-row end.// -->
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="text" name="email" class="form-control" placeholder="enter your email" value="<?php echo $userinfo['email'] ;?>">

                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="photo">Photo</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="photo" class="custom-file-input" id="profile_photo">
                            <label class="custom-file-label" for="contact_photo">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update_profile" class="btn btn-success btn-block"> UPDTE</button>
                    </div>

                </form>
            </article>
        </div>
    </div>

</div>
<?php
include_once './Common/Footer.php';
?>