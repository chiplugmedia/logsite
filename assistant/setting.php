<?php
$genMsg=$refBonus=$welcomeBonus=$minDataWithdrawAmt=$minRefWithdrawAmt=$minActWithdrawAmt=$sponsoredPostAmt=$indRef=$thirdIndRef=$dailyLogin="";

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/settings.php";




$enableRef = $enableAct = $enableSpin = $enableCameroon = $enableNigeria = $enableGhana = $enableSierraLeone = $enableSouthAfrica = $enableKenya = $enableTanzania = $enableUganda = $enableAmerica = "";

if($refWithdraw == 1){
    $enableRef = "checked";
}
if($activityWithdraw == 1){
    $enableAct = "checked";
}
if($spinWheel == 1){
    $enableSpin = "checked";
}
if($CameroonWithdraw == 1){
    $enableCameroon = "checked";
}
if($NigeriaWithdraw == 1){
    $enableNigeria = "checked";
}
if($GhanaWithdraw == 1){
    $enableGhana = "checked";
}
if($SierraLeoneWithdraw == 1){
    $enableSierraLeone = "checked";
}
if($SouthAfricaWithdraw == 1){
    $enableSouthAfrica = "checked";
}
if($KenyaWithdraw == 1){
    $enableKenya = "checked";
}
if($TanzaniaWithdraw == 1){
    $enableTanzania = "checked";
}
if($UgandaWithdraw == 1){
    $enableUganda = "checked";
}
if($AmericaWithdraw == 1){
    $enableAmerica = "checked";
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

                            <div class="col-lg-4 mt-4">

                                <div class="card border-0 rounded shadow">

                                    <div class="card-body">

                                        <h5 class="text-md-start text-center mb-0">Personal Details :</h5>

        

                                       

        

                                        <form method="POST">

                                            <div class="row mt-4">

                                                <div class="col-md-6">

                                                    <div class="mb-3">

                                                        <label class="form-label">First Name</label>

                                                        <div class="form-icon position-relative">

                                                            <i data-feather="user" class="fea icon-sm icons"></i>

                                                            <input name="firstname" id="first" type="text" class="form-control ps-5" placeholder="First Name :" required value="<?php echo $firstname?>">

                                                        </div>

                                                    </div>

                                                </div><!--end col-->

                                                <div class="col-md-6">

                                                    <div class="mb-3">

                                                        <label class="form-label">Last Name</label>

                                                        <div class="form-icon position-relative">

                                                            <i data-feather="user-check" class="fea icon-sm icons"></i>

                                                            <input name="lastname" id="last" type="text" class="form-control ps-5" placeholder="Last Name :" required value="<?php echo $lastname?>">

                                                        </div>

                                                    </div>

                                                </div><!--end col-->

                                                <div class="col-md-6">

                                                    <div class="mb-3">

                                                        <label class="form-label">Your Email</label>

                                                        <div class="form-icon position-relative">

                                                            <i data-feather="mail" class="fea icon-sm icons"></i>

                                                            <input name="email" id="email" type="email" class="form-control ps-5" placeholder="Your email :" required value="<?php echo $email?>">

                                                        </div>

                                                    </div> 

                                                </div><!--end col-->

                                                <div class="col-md-6">

                                                <div class="mb-3">

                                                    <label class="form-label">Phone No. :</label>

                                                    <div class="form-icon position-relative">

                                                        <i data-feather="phone" class="fea icon-sm icons"></i>

                                                        <input name="phone" id="number" type="number" class="form-control ps-5" placeholder="Phone :" required value="<?php echo $phoneNumber?>">

                                                    </div>

                                                </div>

                                                </div><!--end col-->

                                               

                                            </div><!--end row-->

                                            <div class="row">

                                                <div class="col-sm-12">

                                                    <input type="submit" id="submit" name="saveDetails" class="btn btn-primary" value="Save Changes">

                                                </div><!--end col-->

                                            </div><!--end row-->

                                        </form><!--end form-->

                                    </div>

                                </div>



                                <div class="card border-0 rounded shadow p-4 mt-4">

                                    <h5 class="mb-0"> Structure :</h5>



                                    <form method="POST">

                                        <div class="row mt-4">

                                            <div class="col-lg-12">

                                                <div class="mb-3">

                                                    <label class="form-label">Daily login :</label>

                                                    <div class="form-icon position-relative">

                                                        <i data-feather="key" class="fea icon-sm icons"></i>

                                                        <input type="text" class="form-control ps-5" placeholder="Daily login " name="dailyLogin" value="<?php echo $dailyLogin?>">

                                                    </div>

                                                </div>

                                            </div><!--end col-->

        

                                            <div class="col-lg-12">

                                                <div class="mb-3">

                                                    <label class="form-label">Referral Bonus :</label>

                                                    <div class="form-icon position-relative">

                                                        <i data-feather="key" class="fea icon-sm icons"></i>

                                                        <input type="text" class="form-control ps-5" placeholder="Referral Bonus" name="refBonus" value="<?php echo $refBonus ?>">

                                                    </div>

                                                </div>

                                            </div><!--end col-->
                                            
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Welcome bonus:</label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="key" class="fea icon-sm icons"></i>
                                                        <input type="text" class="form-control ps-5" placeholder="Welcome  bonus" name="welBonus" value="<?php echo $welcomeBonus ?>">
                                                    </div>
                                                </div>
                                            </div><!--end col-->

                                            
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Minimum act wallet Withdrawal :</label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="key" class="fea icon-sm icons"></i>
                                                        <input type="text" class="form-control ps-5" placeholder="Minimum act Withdrawal " name="minActWithdrawAmt" value="<?php echo $minActWithdrawAmt ?>">
                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                            
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Minimum Referral wallet withdrawal:</label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                                    <input type="text" class="form-control ps-5" placeholder="Minimum Referral wallet withdrawal" name="minRefWithdrawAmt" value="<?php echo $minRefWithdrawAmt ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Sponsored post:</label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="key" class="fea icon-sm icons"></i>
                                                        <input type="text" class="form-control ps-5" placeholder="Sponsored post " name="spAmt" value="<?php echo $sponsoredPostAmt ?>">
                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                            
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Indirect bonus:</label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="key" class="fea icon-sm icons"></i>
                                                        <input type="text" class="form-control ps-5" placeholder="Indirect bonus " name="indRef" value="<?php echo $indRef ?>">
                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                            
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Third Indirect bonus:</label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="key" class="fea icon-sm icons"></i>
                                                        <input type="text" class="form-control ps-5" placeholder="Third Indirect bonus " name="thirdIndRef" value="<?php echo $thirdIndRef ?>">
                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                            
                                            

                                            <div class="col-lg-12 mt-2 mb-0">

                                                <button class="btn btn-primary" name="saveEarnings" type="submit">Save Settings</button>

                                            </div><!--end col-->

                                        </div><!--end row-->

                                    </form>

                                </div>
                                
                                
                                 

                            </div><!--end col-->

                            <div class="col-lg-4 mt-4">

                                <div class="card border-0 rounded shadow p-4">

                                    <h5 class="mb-0">Site Details :</h5>

                                    <form method="POST" enctype="multipart/form-data">

                                        <div class="row mt-4">

                                            <div class="col-lg-12">

                                                <div class="mb-3">

                                                    <label class="form-label">SiteName :</label>

                                                    <div class="form-icon position-relative">

                                                        <i data-feather="key" class="fea icon-sm icons"></i>

                                                        <input type="text" class="form-control ps-5" placeholder="Sitename " name="sitename" value="<?php echo $sitename?>">

                                                    </div>

                                                </div>

                                            </div><!--end col-->
                                            
                                            <div class="col-lg-12">

                                                <div class="mb-3">

                                                    <label class="form-label">SiteTag :</label>

                                                    <div class="form-icon position-relative">

                                                        <i data-feather="key" class="fea icon-sm icons"></i>

                                                        <input type="text" class="form-control ps-5" placeholder="SiteTag " name="sitetag" value="<?php echo $sitetag?>">

                                                    </div>

                                                </div>

                                            </div><!--end col-->

                                            

                                            <div class="col-lg-12">

                                                <div class="mb-3">

                                                    <label class="form-label">Site Description :</label>

                                                    <div class="form-icon position-relative">

                                                        <i data-feather="key" class="fea icon-sm icons"></i>

                                                        <textarea type="text" class="form-control ps-5" placeholder="Site Description " name="siteDesc"><?php echo $siteDesc?></textarea>

                                                    </div>

                                                </div>

                                            </div><!--end col-->
                                            
                                            
        
                                             <div class="col-lg-12">

                                                <div class="mb-3">

                                                    <label class="form-label">Vtu API/Token :</label>

                                                    <div class="form-icon position-relative">

                                                        <i data-feather="key" class="fea icon-sm icons"></i>

                                                        <input type="text" class="form-control ps-5" placeholder="Vtu API " name="apiKey" value="<?php echo $apiKey?>">

                                                    </div>

                                                </div>

                                            </div><!--end col-->
                                            
                                           
        
                                            
                                                <div>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="actWithdraw" name="actWithdraw" <?php echo $enableAct; ?>>
        <label class="form-check-label" for="actWithdraw">Enable activity Withdrawal</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="refWithdraw" name="refWithdraw" <?php echo $enableRef; ?>>
        <label class="form-check-label" for="refWithdraw">Enable referral Withdrawal</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="spinWheel" name="spinWheel" <?php echo $enableSpin; ?>>
        <label class="form-check-label" for="spinWheel">Enable spin and win</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="CameroonWithdraw" name="CameroonWithdraw" <?php echo $enableCameroon; ?>>
        <label class="form-check-label" for="CameroonWithdraw">Enable Cameroon</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="NigeriaWithdraw" name="NigeriaWithdraw" <?php echo $enableNigeria; ?>>
        <label class="form-check-label" for="NigeriaWithdraw">Enable Nigeria</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="GhanaWithdraw" name="GhanaWithdraw" <?php echo $enableGhana; ?>>
        <label class="form-check-label" for="GhanaWithdraw">Enable Ghana</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="SierraLeoneWithdraw" name="SierraLeoneWithdraw" <?php echo $enableSierraLeone; ?>>
        <label class="form-check-label" for="SierraLeoneWithdraw">Enable Sierra Leone</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="SouthAfricaWithdraw" name="SouthAfricaWithdraw" <?php echo $enableSouthAfrica; ?>>
        <label class="form-check-label" for="SouthAfricaWithdraw">Enable South Africa</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="KenyaWithdraw" name="KenyaWithdraw" <?php echo $enableKenya; ?>>
        <label class="form-check-label" for="KenyaWithdraw">Enable Kenya</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="TanzaniaWithdraw" name="TanzaniaWithdraw" <?php echo $enableTanzania; ?>>
        <label class="form-check-label" for="TanzaniaWithdraw">Enable Tanzania</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="UgandaWithdraw" name="UgandaWithdraw" <?php echo $enableUganda; ?>>
        <label class="form-check-label" for="UgandaWithdraw">Enable Uganda</label>
    </div>

    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="AmericaWithdraw" name="AmericaWithdraw" <?php echo $enableAmerica; ?>>
        <label class="form-check-label" for="AmericaWithdraw">Enable America</label>
    </div>
</div>


                                            <div class="col-lg-12 mt-2 mb-0">

                                                <button class="btn btn-primary" name="siteDetails">Save Details </button>

                                            </div><!--end col-->
                                            
                                            

                                        </div><!--end row-->

                                    </form>

                                </div>


                            </div><!--end col-->


                        </div><!--end row-->

</div>



                        
                        <!--<div class="col-lg-4 mt-4">

<div class="card border-0 rounded shadow p-4">

    <h5 class="mb-0">Flutterwave Settings :</h5>

    <form method="POST">

        <div class="row mt-4">

            <div class="col-lg-12">

                <div class="mb-3">

                    <label class="form-label">Public Live Key :</label>

                    <div class="form-icon position-relative">

                        <i data-feather="key" class="fea icon-sm icons"></i>

                        <input type="text" class="form-control ps-5" placeholder="pklivexxxxxxxxxxxxxxxx575 " name="flwPublicKey" value="<?php echo $flwPublicKey?>">

                    </div>

                </div>

            </div><!--end col


            <div class="col-lg-12">

                <div class="mb-3">

                    <label class="form-label">Secret Live Key :</label>

                    <div class="form-icon position-relative">

                        <i data-feather="key" class="fea icon-sm icons"></i>

                        <input type="text" class="form-control ps-5" placeholder="sklive-xxxxxxxxxxxxx877 " name="flwSecretKey" value="<?php echo $flwSecretKey?>">

                    </div>

                </div>

            </div><!--end col
            

            <div class="col-lg-12 mt-2 mb-0">

                <button class="btn btn-primary" name="saveFlutterwave">Save Details </button>

            </div><!--end col
            
            

        </div><!--end row

    </form>

</div>
</div>


                            </div><!--end col


                        </div><!--end row

</div><!--end col


<div class="col-lg-4 mt-4">

<div class="card border-0 rounded shadow p-4">

    <h5 class="mb-0">Monnify Settings :</h5>

    <form method="POST">

        <div class="row mt-4">

            <div class="col-lg-12">

                <div class="mb-3">

                    <label class="form-label">Secret Key :</label>

                    <div class="form-icon position-relative">

                        <i data-feather="key" class="fea icon-sm icons"></i>

                        <input type="text" class="form-control ps-5" placeholder="pklivexxxxxxxxxxxxxxxx575 " name="mfySecKey" value="<?php echo $mfySecKey?>">

                    </div>

                </div>

            </div><!--end col


            <div class="col-lg-12">

                <div class="mb-3">

                    <label class="form-label">API Key :</label>

                    <div class="form-icon position-relative">

                        <i data-feather="key" class="fea icon-sm icons"></i>

                        <input type="text" class="form-control ps-5" placeholder="sklive-xxxxxxxxxxxxx877 " name="mfyApiKey" value="<?php echo $mfyApiKey?>">

                    </div>

                </div>

            </div><!--end col
            
            <div class="col-lg-12">

                <div class="mb-3">

                    <label class="form-label">Contract Code :</label>

                    <div class="form-icon position-relative">

                        <i data-feather="key" class="fea icon-sm icons"></i>

                        <input type="text" class="form-control ps-5" placeholder="sklive-xxxxxxxxxxxxx877 " name="mfyContractCode" value="<?php echo $mfyContractCode?>">

                    </div>

                </div>

            </div><!--end col
            

            <div class="col-lg-12 mt-2 mb-0">

                <button class="btn btn-primary" name="saveMonnify">Save Details </button>

            </div><!--end col
            
            

        </div><!--end row

    </form>

</div>


</div><!--end col


</div><!--end row


                    </div>

                </div><!--end container



                <?php include"inc/footer.php" ?>