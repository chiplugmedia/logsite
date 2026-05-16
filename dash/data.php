<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/topup.php";

// Call the function to get the list of services
$ptitle="Dashboard";

$genMsg="";


$totaldepositamt = 0; // Initialize with default value

$sql = $link->prepare("SELECT SUM(amount) AS totaldepositamt FROM fundwallet WHERE (status = 'success' OR status = 'successful') AND username = ?");
if ($sql) {
    $sql->bind_param('s', $username);
    $sql->execute();
    $result = $sql->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row) {
            $totaldepositamt = $row['totaldepositamt'] ?? 0; // Use null coalescing operator to ensure it defaults to 0
        }
    }
    $sql->close();
} else {
    // Handle error if the statement preparation failed
    // Error handling code here if needed
}

// Now $totaldepositamt will be 0 if no records are found or if any error occurs


include "inc/header2.php" ;

?>
<!-- Modal -->
        
      
      
           <div><?php echo $genMsg?></div>
           

   <div class="pc-container">
    <div class="pc-content">
        
  <style>
              
     .mt-5 {
    margin-top: 20px;
}

.flex {
    display: flex;
}

.gap-4 {
    gap: 16px; /* Adjusts the spacing between buttons */
}

.btn {
    padding: 10px 15px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.variant-filled-surface {
    background-color: #F65365; /* Light background color for the button */
    color: #000; /* Text color */
}

.btn:hover {
    background-color: #000; /* Change background on hover */
    color: #fff; /* Text color */
}
.rounded-xl {
    border-radius: 15px; /* Large border radius */
}

.text-[12px] {
    font-size: 12px;
}

.leading-3 {
    line-height: 1.2; /* Tight line-height */
}

.min-w-24 {
    min-width: 96px; /* Sets minimum width for buttons */
}

.gap-y-1 {
    gap: 4px; /* Vertical spacing between text and icon */
}

svg {
    width: 16px;
    height: 16px;
    fill: currentColor; /* Makes the SVG inherit the text color */
}

.text-center {
    text-align: center;
}
</style>

           
<div class="mt-5">
  <div class="flex gap-4">
    <!-- Buy Accounts Button
    <a href="new-order.php">
      <button class="btn variant-filled-surface rounded-xl flex flex-col justify-center items-center text-[12px] leading-3 gap-y-1 min-w-24">
        <span class="text-center flex justify-center items-center w-full">
          <svg version="1.1" class="fa-icon w-[16px] leading-[6px]" width="14.86" height="16" role="presentation" viewBox="0 0 1664 1792">
            <path d="M1216 704q0-26-19-45t-45-19h-128v-128q0-26-19-45t-45-19-45 19-19 45v128h-128q-26 0-45 19t-19 45 19 45 45 19h128v128q0 26 19 45t45 19 45-19 19-45v-128h128q26 0 45-19t19-45zM640 1536q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zM1536 1536q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zM1664 448v512q0 24-16 42.5t-41 21.5l-1044 122q1 7 4.5 21.5t6 26.5 2.5 22q0 16-24 64h920q26 0 45 19t19 45-19 45-45 19h-1024q-26 0-45-19t-19-45q0-14 11-39.5t29.5-59.5 20.5-38l-177-823h-204q-26 0-45-19t-19-45 19-45 45-19h256q16 0 28.5 6.5t20 15.5 13 24.5 7.5 26.5 5.5 29.5 4.5 25.5h1201q26 0 45 19t19 45z"></path>
          </svg>
        </span>
        Buy Accounts
      </button>
    </a> -->

    <!-- Social Boost Button -->
    <a href="https://youngsocials.com.ng">
      <button class="btn variant-filled-surface rounded-xl flex flex-col justify-center items-center text-[12px] leading-3 gap-y-1 min-w-24">
        <span class="text-center flex justify-center items-center w-full">
          <svg version="1.1" class="fa-icon w-[16px] leading-[6px]" width="14.86" height="16" role="presentation" viewBox="0 0 1664 1792">
            <path d="M1216 704q0-26-19-45t-45-19h-128v-128q0-26-19-45t-45-19-45 19-19 45v128h-128q-26 0-45 19t-19 45 19 45 45 19h128v128q0 26 19 45t45 19 45-19 19-45v-128h128q26 0 45-19t19-45zM640 1536q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zM1536 1536q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zM1664 448v512q0 24-16 42.5t-41 21.5l-1044 122q1 7 4.5 21.5t6 26.5 2.5 22q0 16-24 64h920q26 0 45 19t19 45-19 45-45 19h-1024q-26 0-45-19t-19-45q0-14 11-39.5t29.5-59.5 20.5-38l-177-823h-204q-26 0-45-19t-19-45 19-45 45-19h256q16 0 28.5 6.5t20 15.5 13 24.5 7.5 26.5 5.5 29.5 4.5 25.5h1201q26 0 45 19t19 45z"></path>
          </svg>
        </span>
        Social Boost
      </button>
    </a>

    <!-- Purchase Numbers Button -->
    <a href="https://api.whatsapp.com/send?phone=13855420784&text=Hello%20Young%2C%0AI%20want%20to....">
      <button class="btn variant-filled-surface rounded-xl flex flex-col justify-center items-center text-[12px] leading-3 gap-y-1 min-w-24">
        <span class="text-center flex justify-center items-center w-full">
          <svg version="1.1" class="fa-icon w-[16px] leading-[6px]" width="14.86" height="16" role="presentation" viewBox="0 0 1664 1792">
            <path d="M1216 704q0-26-19-45t-45-19h-128v-128q0-26-19-45t-45-19-45 19-19 45v128h-128q-26 0-45 19t-19 45 19 45 45 19h128v128q0 26 19 45t45 19 45-19 19-45v-128h128q26 0 45-19t19-45zM640 1536q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zM1536 1536q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zM1664 448v512q0 24-16 42.5t-41 21.5l-1044 122q1 7 4.5 21.5t6 26.5 2.5 22q0 16-24 64h920q26 0 45 19t19 45-19 45-45 19h-1024q-26 0-45-19t-19-45q0-14 11-39.5t29.5-59.5 20.5-38l-177-823h-204q-26 0-45-19t-19-45 19-45 45-19h256q16 0 28.5 6.5t20 15.5 13 24.5 7.5 26.5 5.5 29.5 4.5 25.5h1201q26 0 45 19t19 45z"></path>
          </svg>
        </span>
       Gift Deliveries & Selling Of PI
      </button>
    </a>
  </div>
</div>

<br>

                    <div class="col-xl-12 col-sm-12">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
    <div class="card border-0  p-4">
      <div class="h6">Balance</div>
      <div class="h4 font-extrabold"><?php echo $dollar ?><?php echo number_format((int) $funds, 2) ?></div>
    </div>
    <div class="card border-0  p-4">
      <div class="h6">Total Transactions</div>
      <div class="h4 font-extrabold"><?php echo $dollar ?><?php echo number_format((int) $totaldepositamt, 2) ?></div>
    </div>
    <div class="card border-0  p-4">
      <div class="h6">Total Orders</div>
      <div class="h4 font-extrabold"><?php echo $totalorde?></div>
    </div>
  </div>
</div>


<div class="col-xl-12 col-sm-12 p-2">
    <div class="dashboard-widget">
        <h5 class="mt-4 mb-4">Recent Orders</h5>
        <?php
        // Prepare and execute query to fetch recent orders
        $sql = $link->prepare("SELECT * FROM userpurchases WHERE username=? ORDER BY id DESC LIMIT 5");
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
                                <th>Order ID</th>
                                <th>Products</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orderID = 1; // Initialize order ID counter
                            while ($row = $result->fetch_assoc()) {
                                $id = $orderID++;
                                $amount = $row['amount'];
                                $status = $row['status'];
                                $description = $row['description'];
                                $color = "";
                                switch ($status) {
                                    case "pending":
                                        $color = "warning";
                                        break;
                                    case "rejected":
                                        $color = "danger";
                                        break;
                                    case "Completed":
                                        $color = "success";
                                        break;
                                }

                                $symbol = "₦";
                                
                                $dateTime = new DateTime($row['date']);
                                $currentTime = new DateTime();

                                // Calculate the time difference
                                $interval = $dateTime->diff($currentTime);

                                // Format the "ago" time
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
                                    <td><?php echo htmlspecialchars($id); ?></td>
                                    <td><?php echo htmlspecialchars($description); ?></td>
                                    <td><?php echo $symbol . number_format($amount, 2); ?></td>
                                    <td>
                                <a href="#" class="btn btn-<?php echo $color; ?> btn-sm"><?php echo $status; ?></a>
                            </td>
                                    <td><?php echo htmlspecialchars($timeAgo); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="card border-0">
                <div class="card-body text-center p-4">
                    <svg width="40" height="40" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.699126 22.1299L11.4851 0.936473C11.6065 0.697285 11.7856 0.49768 12.0036 0.358621C12.2215 0.219562 12.4703 0.146179 12.7237 0.146179C12.9772 0.146179 13.2259 0.219562 13.4439 0.358621C13.6618 0.49768 13.841 0.697285 13.9624 0.936473L24.7483 22.1299C24.8658 22.3607 24.9253 22.6205 24.9209 22.8835C24.9165 23.1466 24.8484 23.4039 24.7234 23.6301C24.5983 23.8562 24.4206 24.0434 24.2078 24.1732C23.995 24.303 23.7543 24.3708 23.5097 24.3701H1.93781C1.69314 24.3708 1.45252 24.303 1.23968 24.1732C1.02684 24.0434 0.849131 23.8562 0.724084 23.6301C0.599037 23.4039 0.530969 23.1466 0.526592 22.8835C0.522216 22.6205 0.581682 22.3607 0.699126 22.1299ZM14.2252 14.2749L14.9815 9.39487C15.0039 9.25037 14.9967 9.10237 14.9605 8.96116C14.9243 8.81995 14.8599 8.6889 14.7719 8.57713C14.6838 8.46536 14.5742 8.37554 14.4506 8.31391C14.327 8.25228 14.1925 8.22033 14.0563 8.22026H11.3912C11.255 8.22033 11.1204 8.25228 10.9969 8.31391C10.8733 8.37554 10.7637 8.46536 10.6756 8.57713C10.5876 8.6889 10.5232 8.81995 10.487 8.96116C10.4508 9.10237 10.4436 9.25037 10.466 9.39487L11.2223 14.2749H14.2252ZM14.7882 18.1096C14.7882 17.5208 14.5707 16.9561 14.1835 16.5398C13.7964 16.1234 13.2713 15.8895 12.7237 15.8895C12.1762 15.8895 11.6511 16.1234 11.2639 16.5398C10.8768 16.9561 10.6593 17.5208 10.6593 18.1096C10.6593 18.6984 10.8768 19.2631 11.2639 19.6794C11.6511 20.0957 12.1762 20.3296 12.7237 20.3296C13.2713 20.3296 13.7964 20.0957 14.1835 19.6794C14.5707 19.2631 14.7882 18.6984 14.7882 18.1096Z" fill="#EA4335"/>
                    </svg>
                    <br><br>
                    <h6>No data found</h6>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>


<!--<div class="d-flex justify-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination common-pagination mt-0">
            <li class="page-item"> </li>
            <li class="page-item active"></li>
        </ul>
    </nav>
</div>


<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <svg version="1.1" class="fa-icon" width="82.29" height="96" aria-label="telegram icon" role="presentation" viewBox="0 0 1536 1792" style="font-size: 6em">
                    <path d="M1024 1376v-160q0-14-9-23t-23-9h-96v-512q0-14-9-23t-23-9h-320q-14 0-23 9t-9 23v160q0 14 9 23t23 9h96v320h-96q-14 0-23 9t-9 23v160q0 14 9 23t23 9h448q14 0 23-9t9-23zM896 480v-160q0-14-9-23t-23-9h-192q-14 0-23 9t-9 23v160q0 14 9 23t23 9h192q14 0 23-9t9-23zM1536 896q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z"></path>
                </svg>
            </div>
            <div class="modal-body">
                <h1 class="text-center">Join Our Telegram Channel</h1>
                <p class="text-center">Join our Telegram channel for constant account updates and free accounts.</p>
                <div class="d-flex gap-3 justify-content-center align-items-center">
                    <a href="https://t.me/+huq-AgqvOU0wMzg0" target="_blank" class="btn btn-primary rounded-lg">Join Telegram Channel</a>
                    <button class="btn btn-danger rounded-lg" onclick="$('#postModal').modal('hide')">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#postModal').modal('show'); // Show the modal when the document is ready
    });
</script>-->


                        
<?php include "inc/footer2.php" ?>