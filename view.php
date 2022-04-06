<?php
    include_once './Common/Header.php';
    require_once './Includes/Db.php';
    if(empty($_SESSION['user'])) {
        header('location:'.SITEURL.'./login.php');
        exit();
    }
    $error_msg='';
    $userid = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id']))?$_SESSION['user']['id']:0;
    $contactid=$_GET['id'];
    if(!empty($contactid) && is_numeric($contactid)){
        $conn= db_connect();
        $contact_id = mysqli_real_escape_string($conn,$contactid);
        $sql= "SELECT * FROM `contacts` WHERE `id` ={$contact_id } AND `owner_id` ={$userid}";
        $sqlresult=mysqli_query($conn,$sql);
        $row= mysqli_num_rows($sqlresult);
        if($row>0){
            $contactresult= mysqli_fetch_assoc($sqlresult);
        }else{
            $error_msg= "Result Does not exit's.";
           
        }db_close($conn);
    }else{
        $error_msg= "invalid contact ID. ID Should be Numberic. ";
        
    }
    if(!empty($error_msg)){

echo '<div class="alert alert-danger text-center mt-2">'.$error_msg.'</div>';
    }else{
    ?>
  <div class="row justify-content-center wrapper">
<div class="col-md-6">
<div class="card">
<header class="card-header">
	<h4 class="card-title mt-2">Contact</h4>
</header>
<article class="card-body">
<div class="container" id="profile"> 
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <img src="<?php echo !empty($contactresult['photo']) ? SITEURL."/Uploads/Photos".$contactresult['photo'] : "https://via.placeholder.com/50.png/09f/666";?>" width="150" class="img-thumbnail" />
            </div>
            <div class="col-sm-6 col-md-8">
                <h4 class="text-primary">
                <?php
                echo $contactresult['f_name'].' '.$contactresult['l_name'];
                ?> 
                </h4>
                <p class="text-secondary">
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                <?php
                echo $contactresult['email'];
                ?> 
                <br />
                <i class="fa fa-phone" aria-hidden="true"></i> 
                <?php
                echo $contactresult['phone'];

                ?> 
                <br />
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <?php
                echo $contactresult['adrs'];
                ?> 
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
    }
    include_once './Common/Footer.php';
    ?>