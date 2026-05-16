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
                                   
                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Users Orders
                                </ul>
                            </nav>
                        </div>
                    
                        <br>
                        <?php echo $genMsg?>
  <!-- All Transactions Table -->
    <div class="col mt-4 pt-2">
    <div class="component-wrapper rounded shadow">
        <div class="p-4 border-bottom">
            <h4 class="title mb-0">Users Orders</h4>
        </div>
        <div class="p-4">
            <div class="table-responsive">
                <table id="myTable" data-order='[[0, "desc"]]' class="table mb-0 table-center">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Username</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = $link->prepare("SELECT * FROM userpurchases WHERE status ='Completed' ORDER BY id DESC");
                        $sql->execute();
                        $result = $sql->get_result();
                        $orderID = 1; // Initialize counter

                        if ($result->num_rows > 0) { // Check if there are results
                            while ($row = $result->fetch_assoc()) {
                                $id = $orderID++;
                                $username = $row['username'];
                                $description = $row['description']; // Assuming 'email' is the correct column
                                $amount = $row['amount'];
                                $date = $row['date'];
                                $status = $row['status'];

                                // Set button color based on status
                                $color = "";
                                if ($status == "pending") {
                                    $color = "warning";
                                } elseif ($status == "rejected") {
                                    $color = "danger";
                                } elseif ($status == "Completed") {
                                    $color = "success";
                                }

                                $symbol = "₦";
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo htmlspecialchars($username); ?></td>
                            <td><?php echo htmlspecialchars($description); ?></td>
                                                        <td>₦<?php echo number_format($amount, 2); ?></td>

                            <td><?php echo htmlspecialchars($date); ?></td>
                            <td>
                                <a href="#" class="btn btn-<?php echo $color; ?> btn-sm">
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



<?php include"inc/footer.php" ?>
                