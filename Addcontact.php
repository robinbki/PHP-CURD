<?php
    include_once './Common/Header.php';
    require_once './Includes/Db.php';
    if(empty($_SESSION['user'])) {
        $currentpage = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '' ;
        $_SESSION['request_url']=$currentpage;
        header('location:'.SITEURL.'./login.php');
        exit();
    }
        //update contact 
        $userid = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id']))?$_SESSION['user']['id']:0;
        $contactid= !empty ($_GET['id']) ? $_GET['id'] : '';
        if(!empty($contactid) && is_numeric($contactid)){
            $conn= db_connect();
            $contact_id = mysqli_real_escape_string($conn,$contactid);
            $sql= "SELECT * FROM `contacts` WHERE `id` ={$contact_id } AND `owner_id` ={$userid}";
            $sqlresult=mysqli_query($conn,$sql);
            $row= mysqli_num_rows($sqlresult);
            if($row>0){
                $contact= mysqli_fetch_assoc($sqlresult);
            }else{
                $error_msg= "Result Does not exit's.";
               
            }
            db_close($conn);
        }
      
        $first_name = (!empty($contact) && !empty($contact['f_name']))?$contact['f_name']:'';
        $last_name = (!empty($contact) && !empty($contact['l_name']))?$contact['l_name']:'';
        $email = (!empty($contact) && !empty($contact['email']))? $contact['email']:'';
        $phone = (!empty($contact) && !empty($contact['phone']))?$contact['phone']:'';
        $adrs = (!empty($contact) && !empty($contact['adrs']))?$contact['adrs']:'';
       
        //update contact end

    ?>
<div class="row justify-content-center wrapper">
<div class="col-md-6">
<?php
         if(!empty($_SESSION['errors'])){
            ?>
            <div class="alert alert-danger">
				<p>There Were Following Error(s) Found...</p>
                <ul>
                    <?php
                    foreach ($_SESSION['errors'] as $err){
                        print '<li>'. $err .'</li>';
                    }
                    
                    ?>
                </ul>
                 </div>
                 <?php
                 unset($_SESSION['errors']);
         }
      ?>
<div class="card">
<header class="card-header">
	<h4 class="card-title mt-2">Add/Edit Contact</h4>
</header>
<article class="card-body">
<form method="POST" action="<?php echo SITEURL.'./Actions/AddContact_Action.php'?>" enctype="multipart/form-data">
	<div class="form-row">
		<div class="col form-group">
			<label>First Name </label>   
		  	<input type="text" name="fname" value="<?php echo $first_name ; ?>" class="form-control" placeholder="First Name">
		</div>
		<div class="col form-group">
			<label>Last Name</label>
		  	<input type="text" name="lname" value="<?php echo $last_name ; ?>" class="form-control" placeholder="Last Name">
		</div>
	</div>
	<div class="form-group">
		<label>Email Address</label>
		<input type="email" name="email" value="<?php echo $email ; ?>" class="form-control" placeholder="Email">
	</div>
	<div class="form-group">
		<label>Phone No.</label>
		<input type="text" name="phone" value="<?php echo $phone ; ?>"  class="form-control" placeholder="Contact">
	</div>
	<div class="form-group">
		<label>Address</label>
		<input type="text" name="address" value="<?php echo $adrs ; ?>" class="form-control" placeholder="Address">
	</div>
	<div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="photo">Photo</span>
        </div>
    <div class="custom-file">
        <input type="file" name="photo" class="custom-file-input" id="contact_photo">
        <label class="custom-file-label" for="contact_photo">Choose file</label>
    </div>
	</div>
    <div class="form-group">
        <input type="hidden" name="cid" value="<?php echo $contactid;?>" />
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </div>    
</form>
</article>
</div> 
</div>

</div>
<?php
    include_once './Common/Footer.php';
    ?>