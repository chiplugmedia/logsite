<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/addproduct.php";


$ptitle="My Orders";
include "inc/header2.php" ?>


  <div class="pc-container">
        <div class="pc-content">
                       <?php echo $genMsg ?>             
            <div class="row p-4">
                <div class="col-6">
                    <div class="card border-0  p-4">
                        <h6 class="text-center">Total Orders</h6>
                        <strong class="text-center"><?php echo $totalorde?></strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0  p-4">
                        <h6 class="text-center">Total Spent</h6>
                        <strong class="text-center"><?php echo $dollar ?><?php echo number_format((int) $totalUserful, 2) ?></strong>
                    </div>
                </div>


                
                
                
                
                
                
                

                


                
<div class="col-xl-12 col-sm-12 p-2">
    <div class="dashboard-widget">
        <h5 class="mt-4 mb-4">Latest Order History</h5>

        <?php
        $sql = $link->prepare("SELECT * FROM userpurchases WHERE username = ? ORDER BY id DESC");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
        ?>
        <div class="dashboard-body__item">
            <div class="table-responsive">
                <table class="table style-two">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Product Info</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 1;

                    while ($row = $result->fetch_assoc()) {

                        $status = strtolower($row['status']);
                        $amount = (float)$row['amount'];

                        $statusColors = [
                            'pending'   => 'warning',
                            'rejected'  => 'danger',
                            'completed' => 'success'
                        ];

                        $color = $statusColors[$status] ?? 'secondary';

                        $dateTime = new DateTime($row['date']);
                        $now = new DateTime();
                        $interval = $dateTime->diff($now);

                        if ($interval->y > 0)      $timeAgo = $interval->y . ' year(s) ago';
                        elseif ($interval->m > 0)  $timeAgo = $interval->m . ' month(s) ago';
                        elseif ($interval->d > 0)  $timeAgo = $interval->d . ' day(s) ago';
                        elseif ($interval->h > 0)  $timeAgo = $interval->h . ' hour(s) ago';
                        elseif ($interval->i > 0)  $timeAgo = $interval->i . ' minute(s) ago';
                        else                       $timeAgo = 'just now';
                    ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= htmlspecialchars($row['title']); ?></td>
                            <td >
                                <button type="button"
                                        class="btn btn-sm btn-danger downloadpurchaseinfo">
                                    Download Credential
                                </button>
                                <input type="hidden"
                                       class="reference"
                                       value="<?= htmlspecialchars($row['reference']); ?>">
                            </td>
                            <td>₦<?= number_format($amount, 2); ?></td>
                            <td>
                                <span class="btn btn-<?= $color; ?> btn-sm">
                                    <?= ucfirst($status); ?>
                                </span>
                            </td>
                            <td><?= $timeAgo; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } else { ?>
            <div class="card border-0">
                <div class="card-body text-center p-4">
                    <h6>No data found</h6>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
 </div>
</div>

<script>
$(".downloadpurchaseinfo").on("click", function(){
    let reference = $(this).closest("tr").find(".reference").val();
    submitAction(reference, "downloadpurchaseinfo");
});

function submitAction(reference, actionType) {
    let form = document.createElement("form");
    form.method = "POST";
    form.action = "";

    let refInput = document.createElement("input");
    refInput.type = "hidden";
    refInput.name = "reference";
    refInput.value = reference;

    let actionInput = document.createElement("input");
    actionInput.type = "hidden";
    actionInput.name = "action";
    actionInput.value = actionType;

    form.appendChild(refInput);
    form.appendChild(actionInput);

    document.body.appendChild(form);
    form.submit();
}

</script>

<?php include "inc/footer2.php" ?>