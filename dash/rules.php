<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/account-settings.php";

$ptitle="Rules Of Pinatexlogs";
include "inc/header2.php" ?>


 <div class="pc-container">
        <div class="pc-content">

            <div class="col-md-6">
                
                            <div class="row mt-5">


                                <div class="card">
                                    <div class="card-body">

                                        <h5><?php echo $ptitle ?></h5>

                                        <ul>

                                            <li>Always Secure your accts few hours after login
                                            </li>

                                            <hr>

                                            <li>Accounts cannot be replaced after changing the password.</li>

                                            <hr>
                                            <li>We replace bad accounts, if fault is from us (not after use)</li>
                                            <hr>
                                            <li>This rules can be changed at any time without prior notice.</li>
                                            <hr>
                                            <li>Obscene language to the admins may be grounds for service refusal.</li>
                                            <hr>
                                            <li>Ignorance of the rules does not absolve you of responsibility.</li>
                                            <hr>
                                            <li>The response time for technical support and the resolution of all
                                                problems/claims is 24/7.
                                            </li>
                                            <hr>
                                            <li>Accounts are always checked by our private program on private mobile
                                                proxy
                                                prior to sale, so we can guarantee 100% validity of the items.
                                            </li>
                                            <hr>
                                            <li>Accounts cannot be returned; instead, they can only be replaced if bad,
                                                provided that other rules are complied with.
                                            </li>
                                            <hr>
                                            <li>The store is not liable for any account activity. How your account will
                                                last
                                                depends on how it’s used. No replacement or refund for an account
                                                suspended/disabled/logged out after a successful login.
                                            </li>

                                        </ul>


                                    </div>

                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


  <?php include "inc/footer2.php" ?>