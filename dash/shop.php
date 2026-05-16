<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";

$ptitle="MarketPlace";
include "inc/header2.php" ?>
<style>
   .card-title{
        font-weight: 400 !important;
        font-size: 14px !important;
    }
</style>
<!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4 mt-4"><span class="text-black"></span> <?php echo $ptitle?></h4>

<div class="row">
        <?php
        $sql=$link->prepare("SELECT * FROM products WHERE status='approved' ORDER BY id DESC");
        $sql->execute();
        $result=$sql->get_result();
        $numrow=$result->num_rows;
        if($numrow > 0){
            while($row=$result->fetch_assoc()){
                $id=$row['id'];
                $amount=$row['price'];
                $status=$row['stockstatus'];
                $image=$row['image1'];
                $title=$row['title'];
                $titleID=$row['identifier'];
                
                if($status =="active"){
                    $statusColor="success";
                }
                else if($status =="limited"){
                    $statusColor="warning";
                }
                else{
                    $statusColor="danger";
                }
                
        ?>
        <div class="col-6 col-md-4 col-lg-3 mb-4">
          <div class="card">
            <span class="badge bg-label-<?php echo $statusColor ?>" style="position: absolute; top: 4px; right: 4px;"><?php echo ucwords($status) ?></span>
            <img src="img/products/<?php echo $image ?>"  class="rounded-t-lg object-cover w-full" alt="Product Image">
            <div class="card-body px-2">
              <h5 class="p-2 sm:p-4 flex flex-col gap-2"><?php echo $title ?></h5>
              <p class="text-sm font-semibold text-red-600 dark:text-primary font-semibold">₦<?php echo number_format((int)$amount ) ?></p>
              <a href="product/<?php echo $titleID ?>" class="btn btn-primary btn-sm">Buy Now</a>
            </div>
          </div>
        </div>
        <?php }} ?>
        
     </div>






</div>
          <!--/ Content -->
         
<?php include "inc/footer2.php" ?>