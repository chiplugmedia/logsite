<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/products.php";

?>

<?php include"inc/header.php" ?>

               <div class="container-fluid">

                    <div class="layout-specing">

                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Product</h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    

                                    <li class="breadcrumb-item text-capitalize"><a href="#">Home </a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Product</li>

                                </ul>

                            </nav>

                        </div>

<div class="row">
    <div class="col-lg-8 mt-4">
        <?php echo $genMsg; ?>
        <div class="card border-0 rounded shadow">
            <div class="card-body">
                <h5 class="text-md-start text-center mb-0">Add Product:</h5>
                <form method="POST" enctype="multipart/form-data">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <div class="form-icon position-relative">
                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                    <input id="productName" type="text" class="form-control ps-5" placeholder="Product Name :" name="productName" value="<?php echo $productName; ?>">
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product Description</label>
                                <div class="form-icon position-relative">
                                    <i data-feather="info" class="fea icon-sm icons"></i>
                                    <textarea id="productDescription" name="productDescription" class="form-control ps-5" placeholder="Product Description:"><?php echo $productDescription; ?></textarea>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product Price</label>
                                <div class="form-icon position-relative">
                                    <input type="number" id="productPrice" name="productPrice" step="0.01" class="form-control ps-5" placeholder="Product Price :" value="<?php echo $productPrice; ?>">
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Social Media Type</label>
                                <div class="form-icon position-relative">
                                    <div class="form-control-select">
                                        <select class="form-control" id="type" name="type">
                                            <option value="" disabled selected>Select type</option>
                                            <option value="facebook" <?php echo isset($isSelectedFb) ? $isSelectedFb : ''; ?>>Facebook</option>
                                            <option value="instagram" <?php echo isset($isSelectedIg) ? $isSelectedIg : ''; ?>>Instagram</option>
                                            <option value="youtube" <?php echo isset($isSelectedYt) ? $isSelectedYt : ''; ?>>YouTube</option>
                                            <option value="twitter" <?php echo isset($isSelectedTw) ? $isSelectedTw : ''; ?>>Twitter</option>
                                            <option value="telegram" <?php echo isset($isSelectedtg) ? $isSelectedtg : ''; ?>>Telegram</option>
                                            <option value="textnow" <?php echo isset($isSelectedtn) ? $isSelectedtn : ''; ?>>Textnow</option>
                                            <option value="mail" <?php echo isset($isSelectedM) ? $isSelectedM : ''; ?>>Old Gmail</option>
                                            <option value="outlook" <?php echo isset($isSelectedO) ? $isSelectedO : ''; ?>>Outlook</option>
                                            <option value="piavpn" <?php echo isset($isSelectedP) ? $isSelectedP : ''; ?>>PIA VPN</option>
                                            <option value="nordvpn" <?php echo isset($isSelectedN) ? $isSelectedN : ''; ?>>Nord VPN</option>
                                            <option value="ipvanishvpn" <?php echo isset($isSelectedIP) ? $isSelectedIP : ''; ?>>IP Vanish VPN</option>
                                            <option value="expressvpn" <?php echo isset($isSelectedEX) ? $isSelectedEX : ''; ?>>Express VPN</option>
                                            <option value="surfshark" <?php echo isset($isSelectedSU) ? $isSelectedSU : ''; ?>>Surfshark</option>
                                            <option value="snapchat" <?php echo isset($isSelectedSN) ? $isSelectedSN : ''; ?>>Snapchat</option>
                                            <option value="oldreddit" <?php echo isset($isSelectedOL) ? $isSelectedOL : ''; ?>>Old Reddit</option>
                                             <option value="applemusic" <?php echo isset($isSelectedAP) ? $isSelectedAP : ''; ?>>Apple Music</option>
                                            <option value="netflix" <?php echo isset($isSelectedNE) ? $isSelectedNE : ''; ?>>Premium Netflix</option>
                                            <option value="textplus" <?php echo isset($isSelectedTP) ? $isSelectedTP : ''; ?>>Textplus</option>
                                            <option value="googlevoice" <?php echo isset($isSelectedGV) ? $isSelectedGV : ''; ?>>Googlevoice</option>
                                            <option value="textfree" <?php echo isset($isSelectedTF) ? $isSelectedTF : ''; ?>>Textfree</option>
                                            <option value="talkatone" <?php echo isset($isSelectedTT) ? $isSelectedTT : ''; ?>>Talkatone</option>
                                            <option value="yellowupdate" <?php echo isset($isSelectedTnYU) ? $isSelectedTnYU : ''; ?>>Yellow Update</option>
                                            <option value="fakeflightticket" <?php echo isset($isSelectedTnFF) ? $isSelectedTnFF : ''; ?>>Fake Flight Ticket</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product Category</label>
                                <div class="form-icon position-relative">
                                    <select class="form-control" name="category" autofocus>
                                        <option selected disabled>Choose category</option>
                                        <?php
                                        $sql = $link->prepare("SELECT * FROM categories");
                                        $sql->execute();
                                        $result = $sql->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $nameOption = $row['name'];
                                            $optionValue = $nameOption;
                                            $selected = ($nameOption == $category) ? "selected" : "";
                                            echo "<option value='$optionValue' $selected>$nameOption</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Purchase Info:</label>
                                <div class="form-icon position-relative">
                                    <i data-feather="info" class="fea icon-sm icons"></i>
                                    <textarea id="postPurchaseInfo" name="postPurchaseInfo" class="form-control ps-5" placeholder="Purchase Info:"><?php echo $postPurchaseInfo; ?></textarea>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
<div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Product Quantity</label>
                        <div class="form-icon position-relative">
                            <i data-feather="hash" class="fea icon-sm icons"></i>
                            <input name="prodNum" id="prodNum" type="text" class="form-control ps-5" placeholder="Product Quantity :" value="<?php echo $prodNum ?>">
                        </div>
                    </div>
                </div><!--end col-->
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <input type="submit" id="submit" name="uploadProduct" class="btn btn-primary" value="Upload Product">
                        </div><!--end col-->
                    </div><!--end row-->
                </form><!--end form-->
            </div><!--end card-body-->
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->

     </div>
                                </div>


<?php include"inc/footer.php" ?>
                