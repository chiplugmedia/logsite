<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";

$ptitle="Top Earners";
include "inc/header.php" ?>

<style>
   
    .card{
        border-radius: 18px !important;
        border: 1px solid #E25D1A;
        margin-top: -5px !important;
        margin-bottom: -5px !important;
        max-height: 100px !important;
        padding: -50px;
    }
    .card-img{
        max-width: 100px !important;
        height: 100px !important;
        magrgin-left: -20px;
    }
    
    .card-text{
        padding-top: -50px !important;
    }
    
    
        .absolute {
        position: absolute;
    }
    .relative {
        position: relative;
    }
    
    
    .small{
        font-size: 12px !important;
        color: #fff;
    }
    .bold{
        font-weight: semibold !important;
    }
    .bolder{
        font-weight: bold !important;
    }
</style>

<!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
              
              <h4 class="fw-bold py-3 mb-4">
  <span class="text-black"></span> <?php echo $ptitle?>
  
</h4>

<div class="row mb-4">
    
    
    
<?php 
    $sql=$link->prepare("SELECT * FROM users WHERE totalrefearnings > 0 ORDER BY CAST(totalrefearnings AS UNSIGNED) DESC LIMIT 20");
    $sql->execute();
    $result=$sql->get_result();                  
    $numrow=$result->num_rows;
    if($numrow > 0){
        $id=0;
        while($row=$result->fetch_assoc()){
            $id++;
            $image=$row['image'];
            $referralFunds=$row['totalrefearnings'];
            $username=$row['username'];                                      
        
                                           
?>
<div class="col-sm-6 col-md-4 mb-4">
<div class="card">
  <div class="row no-gutters d-flex flex-column justify-content-between h-100">
    <div class="col-md-4 absolute ">
      <img src="assets/img/profilephotos/<?php echo $image ?>" class="card-img rounded-circle img-fluid p-2">
    </div>
    <div class="col-md-8 text-end">
      <div class="card-body  ">
        <div>
          <p class="card-text text-black bold"><?php echo $username ?></p>
        </div>
        <div class="mt-3">
          <p class="card-text text-black bold">Amount: <small class="text-primary bolder">₦<?php echo number_format((int)$referralFunds, 2) ?></small></p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<?php }} ?>


<!--
<div class="col-sm-6 col-md-4 mb-4">
<div class="card">
  <div class="row no-gutters d-flex flex-column justify-content-between h-100">
    <div class="col-md-4 absolute">
      <img src="https://via.placeholder.com/150" class="card-img rounded-circle img-fluid p-2">
    </div>
    <div class="col-md-8 text-end">
      <div class="card-body  ">
        <div>
          <p class="card-text">Username</p>
        </div>
        <div class="mt-3">
          <p class="card-text"><small class="text-muted">₦50,000</small></p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
-->







</div>





</div>
          <!--/ Content -->
<?php include "inc/footer.php" ?>