<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/assistant/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/assistant/actions/main.php";

$apiBalance=apiBalance();

$sql=$link->prepare("SELECT * FROM users WHERE role != 'assistant' ");
$sql->execute();
$result=$sql->get_result();
$totalUsers=$result->num_rows;

$sql=$link->prepare("SELECT * FROM users WHERE acctype = 'standard' ");
$sql->execute();
$result=$sql->get_result();
$totalUpgraded=$result->num_rows;

$sql=$link->prepare("SELECT SUM(funds) AS totalFunds FROM users WHERE funds != '0'");
$sql->execute();
$result=$sql->get_result();
$totalFunds=$result->fetch_assoc()['totalFunds'];

$sql=$link->prepare("SELECT * FROM transactions");
$sql->execute();
$result=$sql->get_result();
$totalTrx=$result->num_rows;

$sql = $link->prepare("SELECT SUM(amount) AS totalpending FROM withdrawals WHERE status = 'pending'");
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc(); // Fetch the row containing the total sum
$totalpending = $row['totalpending']; // Access the total sum

$sql = $link->prepare("SELECT SUM(amount) AS total_paid FROM withdrawals WHERE status = 'successful'");
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc(); // Fetch the row containing the total sum
$totalPayout = $row['total_paid']; // Access the total sum



$sql=$link->prepare("SELECT SUM(amount) AS totalDataPayout FROM datawithdrawals WHERE status = 'success' ");
$sql->execute();
$result=$sql->get_result();
$totalDataPayout=$result->fetch_assoc()['totalDataPayout'];


$sql=$link->prepare("SELECT * FROM fundwallet WHERE status = 'successful' ");
$sql->execute();
$result=$sql->get_result();
$totalFunding=$result->num_rows;


?>

<?php include"inc/header.php" ?>



                <div class="container-fluid">

                    <div class="layout-specing">
                        <br> 
                        <?php echo $genMsg?>
                        <div class="d-flex align-items-center justify-content-between">

                            <div>

                                <h6 class="text-muted mb-1">Welcome back, <?php echo $greeting ?> </h6>

                                <h5 class="mb-0">Assistant</h5>

                            </div>



                            <div class="mb-0 position-relative">

                                
                                                
                                                
                                                
                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#announcement" class="btn btn-primary m-1">Announcement</a>
                                                
                                            
                            </div>

                        </div>                <!-- Announce Popup End -->
 

                    

                        

                           
                            

                        <!--    <div class="col mt-4">

                                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">

                                    <div class="d-flex align-items-center">

                                        <div class="icon text-center rounded-pill">

                                            <i class="uil uil-users-alt fs-1 mb-0"></i>

                                        </div>

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-0 text-muted">Total Users</h6>

                                            <p class="fs-5 text-dark fw-bold mb-0"><span><?php echo number_format($totalUsers)?></span></p>

                                        </div>

                                    </div>



                                    <span class="text-primary"><i class="uil uil-users-alt"></i></span>

                                </a>

                            </div><!--end col
                            
                            <div class="col mt-4">

                                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">

                                    <div class="d-flex align-items-center">

                                        <div class="icon text-center rounded-pill">

                                            <i class="uil uil-wallet fs-1 mb-0"></i>

                                        </div>

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-0 text-muted">Total Payout</h6>

                                            <p class="fs-5 text-dark fw-bold mb-0"><span>$<?php echo number_format($totalPayout, 2)?></span></p>

                                        </div>

                                    </div>



                                    <span class="text-primary"><i class="uil uil-wallet"></i></span>

                                </a>

                            </div><!--end col-
                            
                            <div class="col mt-4">

                                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">

                                    <div class="d-flex align-items-center">

                                        <div class="icon text-center rounded-pill">

                                            <i class="uil uil-users-alt fs-1 mb-0"></i>

                                        </div>

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-0 text-muted">Total Pending</h6>

                                            <p class="fs-5 text-dark fw-bold mb-0"><span>$<?php echo number_format($totalpending, 2)?></span></p>

                                        </div>

                                    </div>-



                                    <span class="text-primary"><i class="uil uil-users-alt"></i></span>

                                </a>

                            </div>
                            
                            
                           <div class="col mt-4">

                                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">

                                    <div class="d-flex align-items-center">

                                        <div class="icon text-center rounded-pill">

                                            <i class="uil uil-users-alt fs-1 mb-0"></i>

                                        </div>

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-0 text-muted">Total Funds</h6>

                                            <p class="fs-5 text-dark fw-bold mb-0"><span>$<?php echo number_format($totalFunds, 2)?></span></p>

                                        </div>

                                    </div>-



                                    <span class="text-primary"><i class="uil uil-users-alt"></i></span>

                                </a>

                            </div>
                            
                            
                             <div class="col mt-4">

                                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">

                                    <div class="d-flex align-items-center">

                                        <div class="icon text-center rounded-pill">

                                            <i class="uil uil-users-alt fs-1 mb-0"></i>

                                        </div>

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-0 text-muted">Upgraded Users</h6>

                                            <p class="fs-5 text-dark fw-bold mb-0"><span><?php echo number_format($totalUpgraded)?></span></p>

                                        </div>

                                    </div>



                                    <span class="text-primary"><i class="uil uil-users-alt"></i></span>

                                </a>

                            </div>
                            
                            
                            <div class="col mt-4">

                                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">

                                    <div class="d-flex align-items-center">

                                        <div class="icon text-center rounded-pill">

                                            <i class="uil uil-arrow-growth fs-1 mb-0"></i>

                                        </div>

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-0 text-muted">Total Data Payouts</h6>

                                            <p class="fs-5 text-dark fw-bold mb-0"><span>₦<?php echo number_format($totalDataPayout)?></span></p>

                                        </div>

                                    </div>



                                    <span class="text-primary"><i class="uil uil-arrow-growth"></i> </span>

                                </a>

                            </div>

                            

                            <div class="col mt-4">

                                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">

                                    <div class="d-flex align-items-center">

                                        <div class="icon text-center rounded-pill">

                                            <i class="uil uil-arrow-growth fs-1 mb-0"></i>

                                        </div>

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-0 text-muted">Total Deposits</h6>

                                            <p class="fs-5 text-dark fw-bold mb-0"><span><?php echo number_format($totalFunding)?></span></p>

                                        </div>

                                    </div>



                                    <span class="text-primary"><i class="uil uil-arrow-growth"></i> </span>

                                </a>

                            </div>

                             <div class="col mt-4">

                                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">

                                    <div class="d-flex align-items-center">

                                        <div class="icon text-center rounded-pill">

                                            <i class="uil uil-wallet fs-1 mb-0"></i>

                                        </div>

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-0 text-muted">API Balance</h6>

                                            <p class="fs-5 text-dark fw-bold mb-0">₦<span><?php echo number_format($apiBalance, 2)?></span></p>

                                        </div>

                                    </div>



                                    <span class="text-primary"><i class="uil uil-wallet"></i> </span>

                                </a>

                            </div><!--end col


                            <div class="col mt-4">

                                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">

                                    <div class="d-flex align-items-center">

                                        <div class="icon text-center rounded-pill">

                                            <i class="uil uil-weight fs-1 mb-0"></i>

                                        </div>

                                        <div class="flex-1 ms-3">

                                            <h6 class="mb-0 text-muted">Transactions</h6>

                                            <p class="fs-5 text-dark fw-bold mb-0"><span><?php echo number_format($totalTrx)?></span></p>

                                        </div>

                                    </div>



                                    <span class="text-primary"><i class="uil uil-weight"></i> </span>

                                </a>

                            </div>-
<hr>
                            <div class="mb-0 position-relative">
                                <form method="POST">
                                    <button class="btn btn-primary m-1" name="resolvePending">Resolve Pending</button>
                                </form>
                            </div>
                            <!--end col-
                            
                           <!-- Table Start --

                            <div class="col mt-4 pt-2" id="tables">

                                <div class="component-wrapper rounded shadow">

                                    <div class="p-4 border-bottom">

                                        <h4 class="title mb-0"> Recent Notifications</h4>

                                    </div>



                                    <div class="p-4">

                                        <div class="table-responsive bg-white shadow rounded">

                                            <table class="table mb-0 table-center">

                                                <thead>

                                                    <tr>

                                                    <th scope="col" class="border-bottom">#</th>

                                                    <th scope="col" class="border-bottom">Title</th>
                                                    <th scope="col" class="border-bottom">Message</th>

                                                    <th scope="col" class="border-bottom">Date</th>

                                                    <th scope="col" class="border-bottom">Action</th>

                                                    </tr>

                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $sql=$link->prepare("SELECT * FROM notifications ORDER BY id DESC");
                                                    $sql->execute();
                                                    $result=$sql->get_result();
                                                    $numrow=$result->num_rows;
                                                    if($numrow > 0){
                                                        while($row=$result->fetch_assoc()){
                                                            $id=$row['id'];
                                                            $title=$row['title'];
                                                            $message=$row['message'];
                                                            $date=$row['date'];
                                                    ?>

                                                    <tr>

                                                        <th scope="row"><?php echo $id?></th>

                                                        <td><?php echo $title?></td>

                                                        <td><?php echo $message?></td>
                                                        <td><?php echo $date?></td>

                                                        <td> <button class="btn btn-sm btn-danger deleteMsg">Delete</button> </td>
                                                        <input type="hidden" class="id" value="<?php echo $id?>">

                                                    </tr>
                                                    <?php }} ?>
                                                    

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>


                            </div><!--end col
                            
                            
                            
                            
                            
                            
                            <div class="col mt-4 pt-2" id="tables">

                                <div class="component-wrapper rounded shadow">

                                    <div class="p-4 border-bottom">

                                        <h4 class="title mb-0">All Transactions</h4>

                                    </div>



                                    <div class="p-4">

                                        <div class="table-responsive ">

                                            <table id="myTable" data-order='[[0, "desc"]]' class="table mb-0 table-center">

                                                <thead>
<th>ID</th>
<th>Username</th>
<th>Number</th>
<th>Reference</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        
                                        <th>Status</th>
                                            </tr>

                                                </thead>

                                                <tbody>
                                                    <?php
                                $sql=$link->prepare("SELECT * FROM transactions ORDER BY id DESC LIMIT 500");
                               // $sql->execute();
                               // $result=$sql->get_result();
                               // $numrow=$result->num_rows;
                               // if($numrow > 0){
                               //     while($row=$result->fetch_assoc()){
                               //         $id=$row['id'];
                               //         $desc=$row['description'];
                               //         $amount=$row['amount'];
                               //         $date=$row['date'];
                               //         $status=$row['status'];
                               //         $username=$row['username'];
                               //         $number=$row['number'];
                               //         $reference=$row['reference'];
                               //         $statusColor=""; 
                               //         if($status == "success" || $status == "successful"){
                               //             $statusColor="success";
                               //         }
                               //         else{
                               //             $statusColor="danger";
                               //         }
                               // ?>

                                                   <tr>
                                        <td>#<?php echo $id?></td>
                                        <td><?php echo $username?></td>
                                        <td><?php echo $number?></td>
                                        <td><?php echo $reference?></td>
                                        <td><?php echo $desc?></td>
                                        
                                        <td><?php echo $date?></td>
                                        <td>₦<?php echo number_format($amount, 2)?></td>
                                        
                                        
                                        <td class="text-<?php echo $statusColor?>"><?php echo $status?></td>
                                        
                                    </tr>
                                                    <?php //}} ?>
                                                    

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>

                            </div><!--end col-->

                            
                            
                            

                            <!-- Table End -->

                           
                                            
                                                            
                    </div>

                </div><!--end container-->

                <script>
                    $(".deleteMsg").on("click", function(){
                        let id= $(this).closest("tr").find(".id").val();
                        let actionType="deleteMsg";
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