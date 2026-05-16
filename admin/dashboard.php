<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/main.php";

// Example usage: Get account information
$accountInfo = getAccountInformation();


$sql=$link->prepare("SELECT * FROM users WHERE role != 'admin' ");
$sql->execute();
$result=$sql->get_result();
$totalUsers=$result->num_rows;

$sql=$link->prepare("SELECT * FROM users WHERE acctype = 'standard' ");
$sql->execute();
$result=$sql->get_result();
$totalUpgraded=$result->num_rows;

$sql = $link->prepare("SELECT SUM(funds) AS totalFunds FROM users WHERE funds != '0'");
$sql->execute();
$result = $sql->get_result();
$totalFunds = $result->fetch_assoc()['totalFunds'];

if ($totalFunds === NULL) {
    $totalFunds = 0;
}



$sql=$link->prepare("SELECT * FROM userpurchases WHERE status = 'Completed' ");
$sql->execute();
$result=$sql->get_result();
$totalsold=$result->num_rows;


$sql = $link->prepare("SELECT COALESCE(SUM(amount), 0) AS totalFunding FROM fundwallet WHERE status = 'successful'");
$sql->execute();
$result = $sql->get_result();
$totalFunding = $result->fetch_assoc()['totalFunding'];




?>

<?php include"inc/header.php" ?>



              <div class="container-fluid">
    <div class="layout-specing">
        <br>
        <?php echo $genMsg ?>
        
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h6 class="text-muted mb-1">Welcome back, <?php echo $greeting ?></h6>
                <h5 class="mb-0">Admin</h5>
            </div>
            <div>
                      <a id="currencyDropdownNavbar" class="input-group">
                        <form id="currencyForm" method="post">
                          <select class="form-control" id="targetCountry" name="targetCountry" onchange="document.getElementById('currencyForm').submit()">
                            <option><?php echo $currencySymbol ?></option>
                            <?php
                              foreach ($exchangeRates as $country => $rates) {
                                echo '<option value="' . htmlspecialchars($country) . '"' . ($country == $countryname ? ' selected' : '') . '>' . htmlspecialchars($country) . '</option>';
                              }
                            ?>
                          </select>
                        </form>
                      </a>
                    </div>
        </div>

        <div class="row row-cols-xl-5 row-cols-md-2 row-cols-1 mt-4">
            <!-- Visitor -->
            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-user-circle fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Users</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"><span><?php echo number_format($totalUsers)?></span></p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Revenue -->
            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-usd-circle fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Users Funds</h6>
                          <p class="fs-5 text-dark fw-bold mb-0"><span>₦<?php echo number_format($totalFunds, 2)?></span></p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Orders -->
            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-store fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Orders</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"><span><?php echo number_format($totalsold)?></span></p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Items -->
            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-usd-circle fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Deposits</h6>
                             <p class="fs-5 text-dark fw-bold mb-0"><span>₦<?php echo number_format($totalFunding, 2)?></span></p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Users -->
            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center bg-white rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-wallet fs-1 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">API Balance</h6>
                            <p class="mb-0 text-muted"><span><?php echo $myapiusername ?></span></p>
                            <p class="fs-5 text-dark fw-bold mb-0"><span><?php echo $currencySymbol ?><?php echo number_format($convertedAmount, 2)?></span></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <hr>

       

      <!-- All Transactions Table -->
<div class="col mt-4 pt-2">
    <div class="component-wrapper rounded shadow">
        <div class="p-4 border-bottom">
            <h4 class="title mb-0">All Transactions</h4>
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
                        $sql = $link->prepare("SELECT * FROM fundwallet ORDER BY id DESC");
                        $sql->execute();
                        $result = $sql->get_result();
                        $id = 1; // Initialize $id to start from 1
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $email = $row['email'];
                                $amount = $row['amount'];
                                $date = $row['date'];
                                $status = $row['status'];
                                $username = $row['username'];
                                $initiatedfrom = $row['initiatedfrom'];
                                $statusColor = ($status == "success" || $status == "successful") ? "success" : "danger";
                       $dateTime = new DateTime($date);
$currentTime = new DateTime();

// Calculate the time difference
$interval = $dateTime->diff($currentTime);

// Create the "ago" format
if ($interval->y > 0) {
    $timeAgo = $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
} elseif ($interval->m > 0) {
    $timeAgo = $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
} elseif ($interval->d > 0) {
    $timeAgo = $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
} elseif ($interval->h > 0) {
    $timeAgo = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
} elseif ($interval->i > 0) {
    $timeAgo = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
} else {
    $timeAgo = 'just now';
}
                
                                
                        ?>
                        <tr>
                            <td><?php echo $id++; ?></td> <!-- Increment $id with each row -->
                            <td><?php echo htmlspecialchars($username); ?></td>
                            <td><?php echo htmlspecialchars($email); ?></td>
                            <td><?php echo htmlspecialchars($initiatedfrom); ?></td>
                            <td><?php echo htmlspecialchars($timeAgo); ?></td>
                            <td>₦<?php echo number_format($amount, 2); ?></td>
                            <td>
                                <a href="#" class="btn btn-<?php echo $statusColor; ?> btn-sm">
                                    <?php echo htmlspecialchars($status); ?>
                                </a>
                            </td>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="7" class="text-center">No transactions found.</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    document.getElementById('currencyDropdownNavbarLink').addEventListener('click', function () {
        var dropdown = document.getElementById('currencyDropdownNavbar');
        var expanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !expanded);
        this.setAttribute('data-state', expanded ? 'closed' : 'open');
        dropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function (event) {
        var dropdown = document.getElementById('currencyDropdownNavbar');
        var toggle = document.getElementById('currencyDropdownNavbarLink');

        if (!dropdown.contains(event.target) && !toggle.contains(event.target)) {
            dropdown.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('data-state', 'closed');
        }
    });

  
</script>

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