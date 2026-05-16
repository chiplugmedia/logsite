<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";

if(!isset($_GET['identifier']) || empty($_GET['identifier'])){
    header("location:$stream/dash/shop");
    exit;
}
$identifier=filter_string($_GET['identifier']);
$sql=$link->prepare("SELECT * FROM products WHERE identifier=? AND status='approved' ");
$sql->bind_param("s", $identifier);
$sql->execute();
$result=$sql->get_result();
$numrow=$result->num_rows;
$row=$result->fetch_assoc();
if($numrow == 0){
    header("location:$stream/dash/shop");
    exit;
}
$title=$row['title'];
$desc=$row['description'];
$price=(int) $row['price'];
$sellerName=$row['sellername'];
$oldPrice=(int) $row['oldprice'];
$contactLink=$row['contactlink'];
$image1=$row['image1'];
$image2=$row['image2'];
$image3=$row['image3'];
$status=$row['status'];
$stockStatus=$row['stockstatus'];

if($status =="active"){
    $statusColor="success";
}
else if($status =="limited"){
    $statusColor="warning";
}
else{
    $statusColor="danger";
}

$ptitle=$title;
include "inc/header2.php" ?>
<style>
    .radius-10{
        border-radius: 20px;
    }
    .product-desc{
        word-wrap: pre-wrap !important;
    }
</style>

<!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
              
              <h4 class="fw-bold py-3">
  <span class="text-black"></span> 
  
</h4>





<div class="row">
        <div class="col-md-6">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="img/products/<?php echo $image1 ?>" class="d-block w-100 radius-10" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="img/products/<?php echo $image2 ?>" class="d-block w-100 radius-10" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="img/products/<?php echo $image3 ?>" class="d-block w-100 radius-10" alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-md-6 mt-4 px-3">
          <h2><?php echo $title ?></h2>
          <p>Price: ₦<?php echo number_format($price) ?></p>
          <div class="d-flex justify-content-between">
              <p class="text-<?php echo $statusColor ?>"><?php echo ucwords($stockStatus) ?></p>
              <p class="text-primary"><?php echo $sellerName ?></p>
          </div>
          <a href="<?php echo $contactLink ?>" target="_blank" class="btn btn-primary mb-3">Contact Seller</a>
          <div class="mt-3">
              <h4 class="mb-3">Description</h4>
              <p class="product-desc" style="white-space: pre-wrap; overflow-x: auto;"><?php echo $desc ?></p>
          </div>
        </div>
      </div>



</div>
          <!--/ Content -->
<?php include "inc/footer2.php" ?>