<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/deposit.php";

?>

<?php include"inc/header.php" ?>

                <div class="container-fluid">
                    <div class="layout-specing">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Youngaccount</h5>

                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">
                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">
                                    <li class="breadcrumb-item text-capitalize"><a href="index">Youngaccount</a></li>
                                   
                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Successful Deposits
                                </ul>
                            </nav>
                        </div>
                    
                        <br>
                        <?php echo $genMsg?>
  <!-- All Transactions Table -->
       <div class="col mt-4 pt-2">
    <div class="component-wrapper rounded shadow">
        <div class="p-4 border-bottom">
            <h4 class="title mb-0">Successful Deposits</h4>
        </div>
        <div class="p-4">
            <div class="table-responsive">
                <table id="myTable" data-order='[[0, "desc"]]' class="table mb-0 table-center">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = $link->prepare("SELECT * FROM fundwallet WHERE status ='successful' ORDER BY id DESC");
                        $sql->execute();
                        $result = $sql->get_result();
                        $id = 0; // Initialize $id variable
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $id++;
                                $email = htmlspecialchars($row['email']);
                                $amount = htmlspecialchars($row['amount']);
                                $date = htmlspecialchars($row['date']);
                                $status = htmlspecialchars($row['status']);
                                $username = htmlspecialchars($row['username']);
                                $initiatedfrom = htmlspecialchars($row['initiatedfrom']);
                                $statusColor = ($status == "success" || $status == "successful") ? "success" : "danger";
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $initiatedfrom; ?></td>
                            <td><?php echo $date; ?></td>
                            <td>₦<?php echo number_format($amount, 2); ?></td>
                            <td>
                                <a href="#" class="btn btn-<?php echo $statusColor; ?> btn-sm">
                                    <?php echo htmlspecialchars($status); ?>
                                </a>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else { 
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">No records found</td>
                        </tr>
                        <?php 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
    $(".deleteMsg").on("click", function(){
        let id = $(this).closest("tr").find(".id").val();
        let actionType = "deleteMsg";
        action(id, actionType);
    });

    function action(id, action, extraName = "", extraVal = "") {
        let form = document.createElement('form');
        let inputID = document.createElement('input');
        let inputAction = document.createElement('input');
        let inputExtra = document.createElement('input');
        let body = document.querySelector('body');
        form.method = "POST";

        inputID.type = "hidden";
        inputID.value = id;
        inputID.name = "id";

        inputAction.type = "hidden";
        inputAction.value = action;
        inputAction.name = action;

        inputExtra.type = "hidden";
        inputExtra.value = extraVal;
        inputExtra.name = extraName;

        form.appendChild(inputExtra);
        form.appendChild(inputAction);
        form.appendChild(inputID);
        body.appendChild(form);
        form.submit();
    }
</script>


<?php include"inc/footer.php" ?>
                