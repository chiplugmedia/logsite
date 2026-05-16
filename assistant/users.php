<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/users.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/edit-user.php";

?>

<?php include"inc/header.php" ?>



                <div class="container-fluid">

                    <div class="layout-specing">
                        <br>
                        <?php echo $genMsg?>
                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Users </h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    <li class="breadcrumb-item text-capitalize"><a href="index.php"><?php echo $sitename ?> </a></li>

                                    <li class="breadcrumb-item text-capitalize"><a href="#">Pages</a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page"> Users </li>

                                </ul>

                            </nav>

                        </div>

                    

                        <div class="col-xl-8 mt-4">



                                


                                <div  class="table-responsive " >




                                    <table id="myTable" class="table table-center bg-white mb-0">



                                        <thead>



                                            <tr>



                                                <th class="border-bottom p-3">No.</th>



                                                <th class="border-bottom p-3" style="min-width: 220px;">Usernames</th>



                                                <th class="text-center border-bottom p-3">Referral Bal</th>
                                                
 
 <th class="text-center border-bottom p-3">Activity Bal</th>




                                                <th class="text-center border-bottom p-3" style="min-width: 150px;">Registered Date</th>

<th class="text-center border-bottom p-3">Number</th>
<th class="text-center border-bottom p-3">Country Details</th>


                                                <th class="text-center border-bottom p-3">Status </th>



                                                <th class="text-end border-bottom p-3" style="min-width: 100px;">Preview</th>

                                                <th class="text-end border-bottom p-3" style="min-width: 100px;">Action1</th>
                                                <th class="text-end border-bottom p-3" style="min-width: 100px;">Action2</th>
<th class="text-end border-bottom p-3" style="min-width: 100px;">Action3</th>



                                            </tr>



                                        </thead>



                                        <tbody>



                                            <!-- Start -->

                                          <?php
$sql = $link->prepare("SELECT * FROM users WHERE role != 'admin' ORDER BY id DESC");
$sql->execute();
$result = $sql->get_result();
$numRows = $result->num_rows;

if ($numRows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $email = $row['email'];
        $funds = $row['funds'];
        $referralFunds = $row['referralfunds'];
        $activityFunds = $row['activityfunds'];
        $status = $row['status'];
        $date = $row['date'];
        $id = $row['id'];
        $number = $row['phone'];

        $statusColor = ($status == "active") ? "success" : "danger";

        $userCountryname = "";
        $sql_ref = $link->prepare("SELECT * FROM countryfrom WHERE username=?");
        $sql_ref->bind_param("s", $username);
        $sql_ref->execute();
        $result_ref = $sql_ref->get_result();
        $row_ref = $result_ref->fetch_assoc();

        if ($result_ref->num_rows == 1) {
            $userCountryname = $row_ref['countryname'];
        }
?>
        <tr>
            <th class="p-3">#<?php echo $id ?></th>
            <td class="p-3">
                <a href="#" class="text-primary">
                    <div class="d-flex align-items-center">
                        <span class="ms-2"><?php echo ucwords($username) ?></span>
                    </div>
                </a>
            </td>
            <td class="text-center p-3">$<?php echo number_format((int)$referralFunds, 2) ?></td>
            <td class="text-center p-3">$<?php echo number_format((int)$funds, 2) ?></td>
            <td class="text-center p-3"><?php echo $date ?></td>
            <td class="text-center p-3"><?php echo $number ?></td>
            <td class="text-center p-3"><?php echo $userCountryname ?></td>
            <td class="text-center p-3">
                <div class="badge bg-soft-<?php echo $statusColor ?> rounded px-3 py-1">
                    <?php echo $status ?>
                </div>
            </td>
            <td class="text-end p-3">
                <a href="edit-user.php?username=<?php echo $username ?>" class="btn btn-sm btn-primary">Preview</a>
            </td>
            <td class="text-end p-3">
                <button class="btn btn-sm btn-info makeVendor">Make Vendor</button>
            </td>
            <td class="text-end p-3">
                <button class="btn btn-sm btn-danger suspendUser">Suspend</button>
            </td>
            <td class="text-end p-3">
                <button class="btn btn-sm btn-success activate">Activate</button>
            </td>
            <input type="hidden" class="username" value="<?php echo $username ?>">
        </tr>
<?php
    }
}
?>

                                        </tbody>



                                    </table>
                                    
                                    
                                    <br><br>
                                    
                                    
  



                                </div>



                            </div><!--end col-->
                            
                            
                                    

                    </div>

                </div><!--end container-->


                <script>
                    $(".makeVendor").on("click", function(){
                        let username= $(this).closest("tr").find(".username").val();
                        let actionType="makeVendor";
                        action(username, actionType);
                        
                    })
                    $(".suspendUser").on("click", function(){
                        let username= $(this).closest("tr").find(".username").val();
                        let actionType="suspendUser";
                        action(username, actionType);
                        
                    })
                    $(".activate").on("click", function(){
                        let username= $(this).closest("tr").find(".username").val();
                        let actionType="activate";
                        action(username, actionType);
                        
                    })
                    
                
                    function action(username, action, extraName="", extraVal=""){
                        let form=document.createElement('form');
                        let inputID=document.createElement('input');
                        let inputAction=document.createElement('input');
                        let inputExtra=document.createElement('input');
                        let body=document.querySelector('body');
                        form.method="POST";

                        inputID.type="hidden";
                        inputID.value=username;
                        inputID.name="username";

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

                