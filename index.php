<?php
    include_once './Common/Header.php';
    require_once './Includes/Db.php';
    $userid = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id']))?$_SESSION['user']['id']:0;
    ?>
    <?php
      if(!empty($_SESSION['success'])){
        ?>
        <div class="alert alert-success text-center mt-2">
        <?php echo $_SESSION['success']; ?>
        </div>
        <?php
         unset($_SESSION['success']);
        }
        if (!empty($userid)){
          $currentpage=!empty($_GET['page']) ?($_GET['page']) :1;
          $limit = 5;
          $offset = ($currentpage-1)*$limit;
            $contactsql= "SELECT * FROM `contacts` WHERE `owner_id` ='$userid' ORDER BY `f_name` ASC LIMIT {$offset},{$limit}";
      
            $conn= db_connect();
            $contactresult = mysqli_query($conn,$contactsql);
            $contactnumrows=mysqli_num_rows($contactresult);
            //for counts
            $countsql= "SELECT id FROM `contacts` WHERE `owner_id` ='$userid'";
            $countresult = mysqli_query($conn,$countsql);
            $numrows = mysqli_num_rows($countresult);
            if($contactnumrows>0){
           
        ?>

<table class="table text-center">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php
while ($row = mysqli_fetch_assoc($contactresult)) {
    $contactimg=!empty($row['photo']) ? SITEURL."./Uploads/Photos".$row['photo'] : "https://via.placeholder.com/50.png/09f/666";
      ?>
      <tr>
      <td class="align-middle"><img src="<?php echo  $contactimg ?> " class="img-thumbnail img-list img-fluid" /></td>
      <td class="align-middle"><?php
      echo $row['f_name'].' ' .$row['l_name'];
      ?>
      </td>
      <td class="align-middle"> 
      <a href="<?php echo SITEURL.'./view.php?id='.$row['id'];
    ?>" class="btn btn-success">View</a>
      <a href="<?php echo SITEURL.'./Addcontact.php?id='.$row['id'];
    ?>" class="btn btn-primary">Edit</a>
      <a href="<?php echo SITEURL.'./Delete.php?id='.$row['id'];
    ?>" class="btn btn-danger" onclick="return confirm(`Are you sure want to delete this contact?`)">Delete</a>
      </td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>
<?php
getpagination($numrows,$currentpage);
?>
<?php
     }
     else{
        echo '<div class = "alert alert-danger text-center mt-2">No Contacts avaliable found</div>';
     }
    }
    else{

    ?>
    <style>
      body{
        background-image: url("<?php echo SITEURL."./Public/Images/contactbook.jpg"?>");
        background-repeat: no-repeat;
        background-size: cover;
      }
    </style>
<?php
    }
    include_once './Common/Footer.php';
    ?>