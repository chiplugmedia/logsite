<?php

$genMsg = "";
$title=$image=$desc=$genMsg=$profileLink=$url="";
require $_SERVER['DOCUMENT_ROOT'] . "/stream.php";
require $_SERVER['DOCUMENT_ROOT'] . "$stream/includes/generalinclude.php";

$ptitle = "Product Details";
include "includes/header.php" ?> 

    <link rel="stylesheet" href="/css/app.css">

<!-- Start Process Area -->
      	<div class="relative bg-secondary text-white bg-cover bg-clip-padding w-full sm:pb-0 after:absolute after:inset-0 bg-page-heading-pattern">
        <div class="container relative py-10 sm:py-16">
            <div class="border-l-4 border-primary pl-5 text-left max-w-4xl ">
                <h1 class="text-white  text-3xl sm:text-4xl lg:text-4xl font-extrabold dark:text-white"><?php echo $ptitle?></h1>
                            </div>
        </div>
    </div>
      <!-- Start Breadcrumb -->    
      
      
      
      <?php
      if(!isset($_GET['identifier']) || empty($_GET['identifier'])){
   
}
$identifier=filter_string($_GET['identifier']);
$sql=$link->prepare("SELECT * FROM products WHERE identifier=? AND status='approved' ");
$sql->bind_param("s", $identifier);
$sql->execute();
$result=$sql->get_result();
$numrow=$result->num_rows;
$row=$result->fetch_assoc();

$title=$row['title'];
$desc=$row['description'];
$price=(int) $row['price'];
$sellerName=$row['sellername'];
$oldPrice=(int) $row['oldprice'];
$contactLink=$row['contactlink'];
$location=$row['location'];
$date=$row['date'];
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
      
      ?>
      
      
      
      
      <style>
    .radius-10{
        border-radius: 20px;
    }
    .product-desc{
        word-wrap: pre-wrap !important;
    }
</style>

<!-- Content -->
        
        <main>
<div class="container py-6 lg:py-14">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
<div class="lg:col-span-8">
<div class="flex gap-2 items-center text-sm mb-4">
<figure class="rounded-full">

</div>
<div class="hidden lg:grid grid-cols-1 gap-2 lg:gap-2 lg:grid-cols-4 lg:items-start">
<div class="block relative  lg:col-span-4 ">
<div class="swiper swiper-dark gallery-slider lg:h-full swiper-initialized swiper-horizontal swiper-backface-hidden">
<div class="swiper-wrapper h-full" id="swiper-wrapper-69629ab1713a8cdb" aria-live="polite">
<div class="swiper-slide bg-white h-full dark:bg-gray-800 swiper-slide-active swiper-slide-next" role="group" aria-label="1 / 1" data-swiper-slide-index="0" style="width: 813px; margin-right: 30px;">
<img src="/admin/assets/images/products/<?php echo $image1 ?>" alt="Allutfy DESIGNS" class="swiper-lazy object-cover h-full lg:h-[30rem] w-full rounded-xl">

</div>
</div>
<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
</div>
<div class="flex w-full relative lg:h-[30rem]  hidden ">
<div class=" inline-flex w-full flex-col relative">
<div class="swiper gallery-thumb-swiper m-0 ml-0 mr-0 swiper-initialized swiper-vertical swiper-watch-progress swiper-thumbs">
<div class="swiper-wrapper flex-col w-full" id="swiper-wrapper-65fe6d79c2aafd45" aria-live="polite" style="transition-duration: 0ms; transition-delay: 0ms;">
<div class="swiper-slide group w-full swiper-slide-active swiper-slide-next swiper-slide-thumb-active" data-swiper-slide-index="0" role="group" aria-label="1 / 1">
<img src="/admin/assets/images/products/<?php echo $image1 ?>" alt="Allutfy DESIGNS" class="swiper-lazy lg:h-[15rem] w-full object-cover rounded-xl transition ease-in-out transition-all ">

</div>
</div>
<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
</div>
</div>
</div>
<div class="lg:hidden gap-2 lg:gap-2">
<div class="">
<div class="swiper swiper-dark m-gallery-slider lg:h-full swiper-fade swiper-initialized swiper-horizontal swiper-watch-progress swiper-backface-hidden">
<div class="swiper-wrapper h-full" id="swiper-wrapper-810631ac607ff55410" aria-live="polite" style="transition-duration: 0ms; transition-delay: 0ms;">
<div class="swiper-slide bg-white dark:bg-gray-800 h-full swiper-slide-visible swiper-slide-active swiper-slide-next" data-swiper-slide-index="0" role="group" aria-label="1 / 1" style="width: 678px; transition-duration: 0ms; opacity: 1; transform: translate3d(0px, 0px, 0px);">
<img src="/admin/assets/images/products/<?php echo $image1 ?>" alt="Allutfy DESIGNS" class="swiper-lazy object-cover h-[20rem] w-full rounded-xl">

</div>
</div>
<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
</div>
<div thumbsslider="" class="swiper mySwiper mt-4 swiper-initialized swiper-horizontal swiper-free-mode swiper-watch-progress swiper-thumbs swiper-backface-hidden">
<div class="swiper-wrapper" id="swiper-wrapper-c9e8efaa0d19d699" aria-live="polite" style="transition-duration: 0ms; transition-delay: 0ms; transform: translate3d(0px, 0px, 0px);">
<div class="swiper-slide h-fulll swiper-slide-visible swiper-slide-active swiper-slide-thumb-active" style="width: 162px; margin-right: 10px;" role="group" aria-label="1 / 1">
<img src="/admin/assets/images/products/<?php echo $image1 ?>" alt="Allutfy DESIGNS" class="swiper-lazy w-20 h-20 object-cover rounded-xl transition ease-in-out transition-all">

</div>
</div>
<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
</div>
<div class="mt-10">
<h2 class="font-semibold text-xl lg:text-2xl mb-4"><?php echo $title ?></h2>
<div class="prose max-w-full mb-14 dark:text-gray-400"><p><?php echo $desc ?></p>
<p>&nbsp;</p></div>
</div>
</div>
<div class="lg:col-span-4">
<div class="shadow-lg border dark:border-gray-500 flex flex-col justify-between sticky top-0 rounded-xl dark:text-gray-200 p-4 lg:p-5">
<div class="py-5">
<div class="relative inline-block mb-5">
<div itemprop="price" class="inline-flex items-start leading-normal relative">
<span class="symbol text-xl font-semibold block mt-2">₦</span>
<span class="price text-4xl font-bold text-secondary dark:text-primary"><?php echo number_format($price) ?></span>
</div>
<span class="text-xs absolute inline-block rright-0 -top-2">NGN</span>
</div>
<div class="flex gap-2 items-center text-sm mb-8">
<figure class="rounded-full">

<p class="dark:text-gray-400"><?php echo $sellerName ?></p>
</span>
</div>
<div class="flex flex-col gap-4">
<div class="flex justify-between">
<span>From: <?php echo $location ?></span>
<span class="font-semibold"></span>
</div>
<div class="flex justify-between">
<span>Date: <?php echo $date ?></span>
</div>
<div class=" prose prose-sm max-w-full dark:text-gray-400"></div>
<a href="<?php echo $contactLink ?>" class="btn btn-primary btn-block">Contact me</a>
</div>
</div>
</div>
</div>
</div>
</div>
</main>
      
      
      
      
      
      
      
      
<?php include "includes/footer.php" ?>