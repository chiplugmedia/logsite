<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$genMsg=$refBonus=$welcomeBonus=$minDataWithdrawAmt=$minRefWithdrawAmt=$minActWithdrawAmt=$sponsoredPostAmt=$indRef=$thirdIndRef=$dailyLogin="";

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/settings.php";




// Initialize variables
$enableRef = $enableAct = $enableSpin = $enableCameroon = $enableNigeria = $enableGhana = $enableSierraLeone = $enableSouthAfrica = $enableKenya = $enableTanzania = $enableUganda = $enableAmerica = $enablevtu = $enablesoci="";

// Set "checked" if the corresponding withdraw value is 1
if ($refWithdraw == 1) {
    $enableRef = "checked";
}
if ($activityWithdraw == 1) {
    $enableAct = "checked";
}
if ($spinWheel == 1) {
    $enableSpin = "checked";
}
if ($CameroonWithdraw == 1) {
    $enableCameroon = "checked";
}
if ($NigeriaWithdraw == 1) {
    $enableNigeria = "checked";
}
if ($GhanaWithdraw == 1) {
    $enableGhana = "checked";
}
if ($SierraLeoneWithdraw == 1) {
    $enableSierraLeone = "checked";
}
if ($SouthAfricaWithdraw == 1) {
    $enableSouthAfrica = "checked";
}
if ($KenyaWithdraw == 1) {
    $enableKenya = "checked";
}
if ($TanzaniaWithdraw == 1) {
    $enableTanzania = "checked";
}
if ($UgandaWithdraw == 1) {
    $enableUganda = "checked";
}
if ($AmericaWithdraw == 1) {
    $enableAmerica = "checked";
}
if ($vtuportal == 1) {
    $enablevtu = "checked";
}
if ($sociWithdraw == 1) {
    $enablesoci = "checked";
}


?>

<?php include"inc/header.php" ?>



                <div class="container-fluid">

                    <div class="layout-specing">
                        <br>
                        <?php echo $genMsg?>

                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">General Setting</h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    

                                    <li class="breadcrumb-item text-capitalize"><a href="profile">General </a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Plan Setting</li>

                                </ul>

                            </nav>

                        </div>

                    

                      <div class="row">
    <!-- Personal Details Section -->
    <div class="col-lg-4 mt-4">
        <div class="card border-0 rounded shadow">
            <div class="card-body">
                <h5 class="text-md-start text-center mb-0">Personal Details :</h5>
                <form method="POST">
                    <div class="row mt-4">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <div class="form-icon position-relative">
                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                    <input name="firstname" id="first" type="text" class="form-control ps-5" placeholder="First Name :" required value="<?php echo $firstname; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- Last Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <div class="form-icon position-relative">
                                    <i data-feather="user-check" class="fea icon-sm icons"></i>
                                    <input name="lastname" id="last" type="text" class="form-control ps-5" placeholder="Last Name :" required value="<?php echo $lastname; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Your Email</label>
                                <div class="form-icon position-relative">
                                    <i data-feather="mail" class="fea icon-sm icons"></i>
                                    <input name="email" id="email" type="email" class="form-control ps-5" placeholder="Your email :" required value="<?php echo $email; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone No. :</label>
                                <div class="form-icon position-relative">
                                    <i data-feather="phone" class="fea icon-sm icons"></i>
                                    <input name="phone" id="number" type="number" class="form-control ps-5" placeholder="Phone :" required value="<?php echo $phoneNumber; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="submit" id="submit" name="saveDetails" class="btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <div class="col-lg-4 mt-4">

                <div class="card border-0 rounded shadow p-4">

                    <h5 class="mb-0">Bank Details :</h5>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="row mt-4">

                            <div class="col-lg-12">

                                <div class="mb-3">

                                    <label class="form-label">Bank :</label>

                                    <div class="form-icon position-relative">

                                        <i data-feather="key" class="fea icon-sm icons"></i>

                                        <input type="text" class="form-control ps-5" placeholder="Bank "
                                            name="flwSecretKey" value="<?php echo $flwSecretKey?>">

                                    </div>

                                </div>

                            </div>
                            <!--end col-->

                            <div class="col-lg-12">

                                <div class="mb-3">

                                    <label class="form-label">Account Name :</label>

                                    <div class="form-icon position-relative">

                                        <i data-feather="key" class="fea icon-sm icons"></i>

                                        <input type="text" class="form-control ps-5" placeholder="Account Name "
                                            name="flwPublicKey" value="<?php echo $flwPublicKey?>">

                                    </div>

                                </div>

                            </div>
                            <!--end col-->


                            <div class="col-lg-12">

                                <div class="mb-3">

                                    <label class="form-label">Account Number :</label>

                                    <div class="form-icon position-relative">

                                        <i data-feather="key" class="fea icon-sm icons"></i>

                                        <input type="text" class="form-control ps-5" placeholder="Account Number "
                                            name="paymentaccount" value="<?php echo $paymentAccount?>">

                                    </div>

                                </div>

                            </div>
                            <!--end col-->



                            <div class="col-lg-12 mt-2 mb-0">

                                <button class="btn btn-primary" name="saveFlutterwave">Save Details </button>

                            </div>
                            <!--end col-->



                        </div>
                        <!--end row-->

                    </form>

                </div>



            </div>
            <!--end col-->

    <!-- Site Details Section -->
    <div class="col-lg-4 mt-4">
        <div class="card border-0 rounded shadow p-4">
            <h5 class="mb-0">Site Details :</h5>
            <form method="POST" enctype="multipart/form-data">
                <div class="row mt-4">
                    <!-- Site Name -->
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Site Name :</label>
                            <div class="form-icon position-relative">
                                <i data-feather="key" class="fea icon-sm icons"></i>
                                <input type="text" class="form-control ps-5" placeholder="Site Name" name="sitename" value="<?php echo $sitename; ?>">
                            </div>
                        </div>
                    </div>
                    <!-- Site Tag -->
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Exchange Rate :</label>
                            <div class="form-icon position-relative">
                                <i data-feather="key" class="fea icon-sm icons"></i>
                                <input type="number" class="form-control ps-5" placeholder="Exchange Rate" name="sitetag" value="<?php echo $sitetag; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">API Site Link :</label>
                            <div class="form-icon position-relative">
                                <i data-feather="key" class="fea icon-sm icons"></i>
                                <textarea type="text" class="form-control ps-5" placeholder="API Site Link" name="siteDesc"><?php echo $siteDesc; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">API KEY:</label> 
                            <div class="form-icon position-relative">
                                <i data-feather="key" class="fea icon-sm icons"></i>
                                <input type="text" class="form-control ps-5" placeholder="API KEY" name="apiKey" value="<?php echo $apiKey; ?>">
                            </div>
                        </div>
                    </div>
                 
                    </div>
                    <div class="col-lg-12 mt-2 mb-0">
                        <button class="btn btn-primary" name="siteDetails">Save Details</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



                        


                            <!--<div class="mb-0 position-relative">-->
                            <!--    <form method="POST">-->
                            <!--        <button class="btn btn-primary m-1" name="deleteMsgusees">Delete User E</button>-->
                            <!--    </form>-->
                            <!--</div>-->


                            <!--<div class="mb-0 position-relative">-->
                            <!--    <form method="POST">-->
                            <!--        <button class="btn btn-primary m-1" name="deleteusersponsored">Delete User T</button>-->
                            <!--    </form>-->
                            <!--</div>-->



                       
                            <!--<div class="mb-0 position-relative">-->
                            <!--    <form method="POST">-->
                            <!--        <button class="btn btn-primary m-1" name="deusert444asks">Delete User SP</button>-->
                            <!--    </form>-->
                            <!--</div>-->


 
                            

                <?php include"inc/footer.php" ?>