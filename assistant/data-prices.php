<?php
$genMsg=$refBonus=$refDataBonus=$welcomeDataBonus=$minFunding=$minDataWithdrawAmt=$minRefWithdrawAmt=$minMainWithdrawAmt=$couponAmount=$refDataComm=$refAirtimeComm=$refCommFirstDeposit="";

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/settings.php";

?>

<?php include"inc/header.php" ?>



                <div class="container-fluid">

                    <div class="layout-specing">
                        <br>
                        <?php echo $genMsg?>
                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Prices </h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    <li class="breadcrumb-item text-capitalize"><a href="dashboard.php"><?php echo $sitename ?></a></li>

                                    <li class="breadcrumb-item text-capitalize"><a href="#">Prices</a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Data Prices </li>

                                </ul>

                            </nav>

                        </div>

                    

                        <div class="row">

                            <div class="col-md-7 col-lg-8 mt-4">

                                <div class="card rounded shadow p-4 border-0">

                                    <h4 class="mb-3">Mtn SME</h4>

                                    <form method="POST">

                                        <div class="row g-3">


                                            
                                            <div class="col-md-3">

                                                <label for="direct" class="form-label">MTN SME 500MB</label>

                                                <input type="text" class="form-control" id="direct" placeholder="500" required name="data1" value="<?php echo $mtnSME500MB ?>">

                                            </div>

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">MTN SME 1GB</label>

                                                <input type="text" class="form-control" id="number" placeholder="" required name="data2" value="<?php echo $mtnSME1GB ?>">
                                            </div>


                                            <div class="col-md-5">
                                                <label for="number" class="form-label">MTN SME 2GB</label>

                                                <input type="text" class="form-control" id="number" placeholder="" required name="data3" value="<?php echo $mtnSME2GB ?>">
                                            </div>

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">MTN SME 5GB</label>

                                                <input type="text" class="form-control" id="number" placeholder="" required name="data4" value="<?php echo $mtnSME5GB ?>">

                                            </div>

                                            <div class="col-md-3">

                                                <label for="direct" class="form-label">MTN SME 10GB</label>

                                                <input type="text" class="form-control" id="direct" placeholder="500" required name="data5" value="<?php echo $mtnSME10GB ?>">

                                            </div>

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">MTN CG 500MB</label>

                                                <input type="text" class="form-control" id="number" placeholder="" required name="data6" value="<?php echo $mtnCG500MB ?>">
                                            </div>


                                            <div class="col-md-5">
                                                <label for="number" class="form-label">MTN CG 1GB</label>

                                                <input type="text" class="form-control" id="number" placeholder="" required name="data7" value="<?php echo $mtnCG1GB ?>">
                                            </div>

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">MTN CG 2GB</label>

                                                <input type="text" class="form-control" id="number" placeholder="" required name="data8" value="<?php echo $mtnCG2GB ?>">

                                            </div>

                                            <div class="col-md-5">
                                                <label for="number" class="form-label">MTN CG 5GB</label>

                                                <input type="text" class="form-control" id="number" placeholder="" required name="data9" value="<?php echo $mtnCG5GB ?>">
                                            </div>

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">MTN CG 10GB</label>

                                                <input type="text" class="form-control" id="number" placeholder="" required name="data10" value="<?php echo $mtnCG10GB ?>">

                                            </div>

                                            <div></div>

                                        </div>

        

        

                                        <button class="w-100 btn btn-primary" type="submit" name="addMtnData" value="addMtnData">Save</button>

                                    </form>

                                </div>

                            </div><!--end col-->

                        </div><!--end row-->





                        <div class="row">

                            <div class="col-md-7 col-lg-8 mt-4">

                                <div class="card rounded shadow p-4 border-0">

                                    <h4 class="mb-3">Glo</h4>

                                    <form method="POST">

                                        <div class="row g-3">

                                            

        

                                            

        

                                            

                                            

                                            <div class="col-md-3">

                                                <label for="direct" class="form-label">GLO 1.35GB</label>

                                                <input type="text" class="form-control" id="direct" placeholder="500"  name="data1" value="<?php echo $glo1_35GB?>" required>

                                               

                                            </div>

                                        

        

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">GLO 2.90GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""  name="data2" value="<?php echo $glo2_90GB?>" required>

                                                

                                            </div>



                                            

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">GLO 4.10GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""  name="data3" value="<?php echo $glo4_10GB?>" required>

                                                

                                            </div>

                                            

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">GLO 5.80GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""  name="data4" value="<?php echo $glo5_80GB?>" required>

                                                

                                            </div>

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">GLO 10GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""  name="data5" value="<?php echo $glo10GB?>" required>

                                                

                                            </div>

                                            <div></div>

                                        </div>

        

        

                                        <button class="w-100 btn btn-primary" type="submit" name="addGloData" value="addGloData">Save</button>

                                    </form>

                                </div>

                            </div><!--end col-->

                        </div><!--end row-->



                        <div class="row">

                            <div class="col-md-7 col-lg-8 mt-4">

                                <div class="card rounded shadow p-4 border-0">

                                    <h4 class="mb-3">Airtel</h4>

                                    <form method="POST">

                                        <div class="row g-3">

                                

                                            <div class="col-md-3">

                                                <label for="direct" class="form-label">AIRTEL 500MB</label>

                                                <input type="text" class="form-control" id="direct" placeholder="500"  name="data1" value="<?php echo $airtel500MB?>" required>

                                               

                                            </div>

                                        

        

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">AIRTEL 1GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""  name="data2" value="<?php echo $airtel1GB?>" required>

                                                

                                            </div>



                                                                    <div class="col-md-5">

                                                <label for="number" class="form-label">AIRTEL 2GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""  name="data3" value="<?php echo $airtel2GB?>" required>

                                                

                                            </div>

                                            

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">AIRTEL 5GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""  name="data4" value="<?php echo $airtel5GB?>" required>

                                                

                                            </div>

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">AIRTEL 10GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""  name="data5" value="<?php echo $airtel10GB?>" required>

                                                

                                            </div>

                                            <div></div>

                                        </div>

        

        

                                        <button class="w-100 btn btn-primary" type="submit" name="addAirtelData" value="addAirtelData">Save</button>

                                    </form>

                                </div>

                            </div><!--end col-->

                        </div><!--end row-->



                        <div class="row">

                            <div class="col-md-7 col-lg-8 mt-4">

                                <div class="card rounded shadow p-4 border-0">

                                    <h4 class="mb-3">9Mobile</h4>

                                    <form method="POST">

                                        <div class="row g-3">

       
                                            

                                            <div class="col-md-3">

                                                <label for="direct" class="form-label">9Mobile 500MB</label>

                                                <input type="text" class="form-control" id="direct" placeholder="500"   name="data1" value="<?php echo $etisalat500MB?>" required>

                                               

                                            </div>

                                        

        

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">9Mobile 1.5GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""   name="data2" value="<?php echo $etisalat1_5GB?>" required>

                                                

                                            </div>



                                                                    <div class="col-md-5">

                                                <label for="number" class="form-label">9Mobile 2GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""   name="data3" value="<?php echo $etisalat2GB?>" required>

                                                

                                            </div>

                                            

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">9Mobile 3GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""   name="data4" value="<?php echo $etisalat3GB?>" required>

                                                

                                            </div>

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">9Mobile 11GB</label>

                                                <input type="text" class="form-control" id="number" placeholder=""   name="data5" value="<?php echo $etisalat11GB?>" required>



                                            </div>

                                            <div></div>

                                        </div>

        

        

                                        <button class="w-100 btn btn-primary" type="submit" name="add9mobileData" value="add9mobileData">Save</button>

                                    </form>

                                </div>

                            </div><!--end col-->

                        </div><!--end row-->

                    </div>

                </div><!--end container-->



<?php include"inc/footer.php" ?>

                