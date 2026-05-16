<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/deposit.php";

?>

<?php include"inc/header.php" ?>

                <div class="container-fluid">
                    <div class="layout-specing">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Vistapay</h5>

                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">
                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">
                                    <li class="breadcrumb-item text-capitalize"><a href="index">Vistapay</a></li>
                                   
                                    <li class="breadcrumb-item text-capitalize active" aria-current="page"> Deposit Request
                                </ul>
                            </nav>
                        </div>
                    
                        <br>
                        <?php echo $genMsg?>

                                                    <div class="col-xl-8 mt-4">

                                <div class="d-flex justify-content-between p-4 bg-white shadow rounded-top">

                                    <h6 class="fw-bold mb-0">Deposit Requests</h6>



                                    <ul class="list-unstyled mb-0">

                                        <li class="dropdown dropdown-primary list-inline-item">

                                            <button type="button" class="btn btn-icon btn-pills btn-soft-primary dropdown-toggle p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti ti-dots-vertical"></i></button>

                                            <div class="dropdown-menu dd-menu dropdown-menu-end bg-white shadow border-0 mt-3 py-3">

                                                <a class="dropdown-item text-dark" href="#"> Used</a>

                                                <a class="dropdown-item text-dark" href="#"> Unused</a>

                                            </div>

                                        </li>

                                    </ul>

                                </div>

                                <div class="table-responsive shadow rounded-bottom" data-simplebar style="height: 545px;">


                                    <table class="table table-center bg-white mb-0">

                                        <thead>

                                            <tr>

                                                <th class="border-bottom p-3">No.</th>

                                                <th class="border-bottom p-3" style="min-width: 220px;">Username</th>

                                                <th class="text-center border-bottom p-3">Payment Method</th>


                                                <th class="text-center border-bottom p-3">Amount</th>
                                                <th class="text-end border-bottom p-3" style="min-width: 100px;">Screenshot </th>

                                                <th class="text-center border-bottom p-3" style="min-width: 150px;">Submitted Date</th>

                                                <th class="text-center border-bottom p-3">Status</th>

                                                <th class="text-end border-bottom p-3" style="min-width: 100px;">Action</th>

                                                <th class="text-end border-bottom p-3" style="min-width: 100px;">Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <!-- Start -->

                                            <?php
                                            $sql=$link->prepare("SELECT * FROM bankdeposit WHERE status ='pending' ORDER BY id DESC");
                                            $sql->execute();
                                            $result=$sql->get_result();
                                            $numrow=$result->num_rows;
                                            if($numrow > 0){
                                                while($row=$result->fetch_assoc()){
                                                    $username=$row['username'];
                                                    $id=$row['id'];
                                                    $image=$row['image'];
                                                    $method=$row['method'];
                                                    $amount=$row['amount'];
                                                    $status=$row['status'];
                                                    $date=$row['date'];

                                                    $statusColor="";
                                                    if($status == "paid" || $status == "successful"){
                                                        $statusColor="success";
                                                    }
                                                    else if($status == "pending"){
                                                        $statusColor="warning";
                                                    }
                                                    else{
                                                        $statusColor="danger";
                                                    }

                                            ?>
                                            <tr>

                                                <th class="p-3">#<?php echo $id ?></th>

                                                <td class="p-3">
                                                    <a href="#" class="text-primary">
                                                        <div class="d-flex align-items-center">
                                                            <span class="ms-2"><?php echo $username ?></span>
                                                        </div>
                                                    </a>
                                                </td>

                                             
                                                <td class="text-center p-3"><?php echo $method ?></td>


                                                <td class="text-center p-3">₦<?php echo number_format($amount, 2) ?></td>
                                                <td class="text-end p-3">
                                                    <a href="../app/assets/img/deposits/<?php echo $image?>" class="btn btn-sm btn-primary ">View Image</a>
                     </td>

                                                <td class="text-center p-3"><?php echo $date ?></td>

                                                <td class="text-center p-3">
                                                    <div class="badge bg-soft-<?php echo $statusColor?> rounded px-3 py-1">
                                                        <?php echo $status?>
                                                    </div>
                                                </td>

                                                <td class="text-end p-3">
                                                    <button href="javascript:void(0)" class="btn btn-sm btn-primary approve">Approve</button>
                                                </td>

                                                <td class="text-end p-3">
                                                    <button href="javascript:void(0)" class="btn btn-sm btn-danger decline">Decline</button>
                                                </td>
                                                <input type="hidden" class="id" value="<?php echo $id?>">

                                            </tr>
                                            <?php }} ?>

                                            <!-- End -->






                                        </tbody>

                                    </table>

                                </div>

                            </div><!--end col-->
                    </div>
                </div><!--end container-->


<script>
    $(".approve").on("click", function(){
        let id= $(this).closest("tr").find(".id").val();
        let actionType="approve";
        action(id, actionType);
        
    })
    $(".decline").on("click", function(){
        let id= $(this).closest("tr").find(".id").val();
        let actionType="decline";
        action(id, actionType);
        
    })

    function action(id, action, extraName="", extraVal=""){
        let form=document.createElement('form');
        let inputID=document.createElement('input');
        let inputAction=document.createElement('input');
        let inputExtra=document.createElement('input');
        let body=document.querySelector('body');
        form.method="POST";

        inputID.type="hidden";
        inputID.value=id;
        inputID.name="id";

        inputAction.type="hidden";
        inputAction.value=action;
        inputAction.name=action;

        inputExtra.type="hidden";
        inputExtra.value=extraVal;
        inputExtra.name=extraName;

        form.appendChild(inputExtra);
        form.appendChild(inputAction);
        form.appendChild(inputID);
        body.appendChild(form);
        form.submit();
    }


</script>

<?php include"inc/footer.php" ?>
                