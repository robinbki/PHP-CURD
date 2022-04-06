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
                <h4 class="card-title mt-2">Change Password</h4>
            </header>
            <article class="card-body">
            <form method="POST" action="<?php echo SITEURL.'./Actions/Update_Password_Action.php'?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>old password</label>
                        <input type="password" name="old_password" class="form-control" placeholder="old_password" value="">

                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="New_Password" class="form-control" placeholder="New_Password" value="">

                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="Confirm_Password" class="form-control" placeholder="Confirm_Password" value="">

                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="change_password" class="btn btn-success btn-block"> UPDTE</button>
                    </div>
              

                </form>
            </article>
        </div>
    </div>

</div>
<?php
include_once './Common/Footer.php';
?>