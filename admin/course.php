<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/upcourse.php";


include"inc/header.php" ?>

               
    

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="d-md-flex justify-content-between align-items-center">
                <h5 class="mb-0">List of API Services</h5>
                <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">
                    <ul class="breadcrumb bg-transparent rounded mb-0 p-0">
                        <li class="breadcrumb-item text-capitalize"><a href="profile">Profile</a></li>
                        <li class="breadcrumb-item text-capitalize active" aria-current="page">Services</li>
                    </ul>
                </nav>
            </div>

            <div class="col-md-7 col-lg-8 mt-4">
                <div class="card rounded shadow p-4 border-0">
                    <h4 class="mb-3">Import Service</h4>
                    <div class="row g-3">
                        <form method="POST">
                            <div class="col-12 mb-2">
                                <label for="apiKey" class="form-label">API Key</label>
                                <input type="text" id="apiKey" class="form-control" name="apiKey" required>
                                <button type="submit" id="bulkUploadBtn" class="btn btn-primary mt-2">Start Bulk Upload</button>
                            </div>
                        </form>
                    </div><!-- end row -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end layout-specing -->
    </div><!-- end container-fluid -->

  


                        <?php include"inc/footer.php" ?>
