<?php 
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";

if(!isset($_GET['reference']) || empty($_GET['reference'])){
    header("location:$stream/admin/dashboard.php");
    exit;
}

$reference=filter_string($_GET['reference']);
$sql=$link->prepare("SELECT * FROM products WHERE reference=?");
$sql->bind_param("s", $reference);
$sql->execute();
$result=$sql->get_result();
$numrow=$result->num_rows;
$row=$result->fetch_assoc();
if($numrow == 1){
   $name = $row['name'];
   
}
else{
    header("location:$stream/admin/dashboard.php");
    exit;
}

require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/products.php";


include"inc/header.php" 

?>


                <div class="container-fluid">

                    <div class="layout-specing">
                        <?php echo $genMsg ?>

                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Edit Products</h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    

                                    <li class="breadcrumb-item text-capitalize"><a href="profile">Activity </a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Products</li>

                                </ul>

                            </nav>

                        </div>
                       
                       <div class="row">

                            <div class="col-lg-4 mt-4">

                                <div class="card border-0 rounded shadow">

                                    <div class="card-body">

                                        <h5 class="text-md-start text-center mb-0">Edit product:</h5>

        

                                        

                                        <form method="POST" enctype="multipart/form-data">

                                            <div class="row mt-4">

                                                <div class="col-md-6">

                                                    <div class="mb-3">

                                                        <label class="form-label">Category Name</label>

                                                        <div class="form-icon position-relative">

                                                            <i data-feather="user" class="fea icon-sm icons"></i>

                                                            <input name="categoryName" id="categoryName" type="text" class="form-control ps-5" placeholder="Category Title :" value="<?php echo $name ?>">

                                                        </div>

                                                    </div>

                                                </div><!--end col-->
                                                

                                            <div class="row">

                                                <div class="col-sm-12">

                                                    <input type="submit" id="submit" name="updateCategory" class="btn btn-primary" value="Update Category">
                                                    <input type="hidden" name="reference" value="<?php echo $reference ?>">


                                                </div><!--end col-->

                                            </div><!--end row-->

                                        </form><!--end form-->

                                    </div>
</div>
                                </div>

</div><!--end row-->




                    </div>

                </div><!--end container-->



                <?php include"inc/footer.php" ?>