<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/flutterwave/pay.php";



$ptitle="Add Funds";
include "inc/header2.php" ?>

              <div class="pc-container">
    <div class="pc-content">

        <!-- General Message -->
       <div><?php echo $genMsg?></div>

        <!-- Wallet Top-Up Section -->
        <div class="dashboard-body__content">
            <div class="dashboard-body__item-wrapper">
                <div class="p-3">
                    <p class="mt-3 p-3">Top up your wallet easily</p>
                    <a href="#" class="btn btn-dark btn-sm w-20 p-2" 
                       style="background: #28bf62; border: 0;" 
                       data-bs-toggle="modal" data-bs-target="#videoModal">
                        Learn how to fund your wallet
                    </a>
                </div>
            </div>
        </div>

        <!-- Video Modal -->
        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #333;">
                        <h5 class="modal-title" id="videoModalLabel" style="color: #fff;">How to Fund Your Wallet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <video id="tutorialVideo" width="100%" controls>
                            <source src="#" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

        <script>
            const videoModal = document.getElementById('videoModal');
            const tutorialVideo = document.getElementById('tutorialVideo');

            videoModal.addEventListener('shown.bs.modal', () => {
                tutorialVideo.play();
            });

            videoModal.addEventListener('hidden.bs.modal', () => {
                tutorialVideo.pause();
                tutorialVideo.currentTime = 0;
            });
        </script>

       <div class="wallet-balance-wrapper" style="display: flex; flex-wrap: wrap; gap: 24px; margin-top: 24px;">
    
    <!-- Fund Wallet Form (Left) -->
    <div class="col-lg-12 col-md-12" style="flex: 1; min-width: 300px;">
    <div class="card">
        <div class="card-body">
            <ul class="list-group list-group-flush">

                <li class="list-group-item px-0 py-2">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-direct-inbox"></use>
                                </svg>
                            </span>
                        </div>
                        <div class="flex-grow-1 mx-3">
                            <p class="mb-1">
                                <a class="text-small text-dark fs-6" href="auto_deposit.php">
                                    Auto Deposit
                                </a>
                            </p>
                        </div>
                    </div>
                </li>

               

            </ul>
        </div>
    </div>
     <div class="card" >
        <div class="card-body">
            <ul class="list-group list-group-flush">

              <li class="list-group-item px-0 py-2">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-direct-inbox"></use>
                                </svg>
                            </span>
                        </div>
                        <div class="flex-grow-1 mx-3">
                            <p class="mb-1">
                                <a class="text-small text-dark fs-6" href="manual_deposit.php">
                                    Manual Deposit
                                </a>
                            </p>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>



    <!-- Balance & Info Section (Right) -->
    <div class="balance-info" style="flex: 1; min-width: 300px;">
        <div class="container">

            <!-- Current Balance Card -->
            <div class="balance-card">
                <div class="balance-header">
                    <p class="balance-label">Current Balance</p>
                    <div class="balance-actions">
                        <button class="refresh-btn" title="Refresh balance">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <i class="fas fa-wallet walleting-icon"></i>
                    </div>
                </div>
                <p class="balance-amount"><?php echo $dollar . number_format((int) $funds, 2); ?></p>
                <p class="balance-subtext">Available for spending</p>
            </div>

            <!-- Why Add Funds Card -->
            <div class="funds-card">
                <h3 class="funds-title">Why Add Funds?</h3>
                <div class="funds-features">
                    <div class="feature">
                        <i class="fas fa-bolt feature-icon"></i>
                        <div>
                            <p class="feature-title">Instant Purchase</p>
                            <p class="feature-desc">Buy accounts instantly without delays</p>
                        </div>
                    </div>
                    <div class="feature">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <div>
                            <p class="feature-title">Secure Transactions</p>
                            <p class="feature-desc">Your funds are safe and encrypted</p>
                        </div>
                    </div>
                    <div class="feature">
                        <i class="fas fa-tags feature-icon"></i>
                        <div>
                            <p class="feature-title">Exclusive Deals</p>
                            <p class="feature-desc">Access special pricing and offers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<br>

        <!-- CSS -->
        <style>
            .container {
                display: grid;
                grid-template-columns: 1fr;
                gap: 24px;
                font-family: sans-serif;
            }

            .balance-card {
                background: linear-gradient(135deg, #00a857 0%, #e6a84e 100%);
                border-radius: 20px;
                padding: 24px;
                color: white;
                box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            }

            .balance-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 16px;
            }

            .balance-label {
                color: rgba(255,255,255,0.8);
                font-size: 0.875rem;
            }

            .balance-actions {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .refresh-btn {
                background: none;
                border: none;
                color: rgba(255,255,255,0.8);
                cursor: pointer;
                font-size: 1rem;
                transition: color 0.3s;
            }

            .refresh-btn:hover { color: #fff; }

            .walleting-icon { font-size: 2rem; color: rgba(255,255,255,0.8); }
            .balance-amount { font-size: 2rem; font-weight: 700; margin-bottom: 8px; }
            .balance-subtext { color: rgba(255,255,255,0.7); font-size: 0.75rem; }

            .funds-card {
                background: #fff;
                border-radius: 20px;
                padding: 24px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.05);
                border: 1px solid #e5e7eb;
                color: #000;
            }

            .funds-title { font-weight: 700; margin-bottom: 16px; }
            .funds-features { display: flex; flex-direction: column; gap: 12px; }
            .feature { display: flex; align-items: flex-start; gap: 12px; }
            .feature-icon { font-size: 1.25rem; color: #28bf62; margin-top: 4px; }
            .feature-title { font-weight: 600; font-size: 0.875rem; color: #1f2937; margin: 0; }
            .feature-desc { font-size: 0.75rem; color: #4b5563; margin: 0; }
        </style>

        <script>
            document.getElementById('fundWalletForm').addEventListener('submit', function (event) {
                const email = event.target.email.value.trim();
                const amount = event.target.amount.value.trim();

                if (!email || !amount || isNaN(amount) || amount <= 0) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please enter a valid email and a positive amount!',
                    });
                }
            });
        </script>

        <!-- Transaction History -->
        <div class="col-xl-12 col-sm-12 p-2" style="background-color: #fff; padding: 20px; border-radius: 15px;">
            <div class="dashboard-widget">
                <h5 class="mt-4 mb-4">Transaction History</h5>
                <div class="dashboard-body__item">
                    <div class="table-responsive">
                        <table class="table style-two">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>References</th>
                                    <th>Balance Before</th>
                                    <th>Balance After</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $link->prepare("SELECT * FROM fundwallet WHERE username = ? ORDER BY id DESC");
                                $stmt->bind_param("s", $username);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $amount = htmlspecialchars($row['amount']);
                                        $status = htmlspecialchars($row['status']);
                                        $initiatedFrom = htmlspecialchars($row['initiatedfrom']);
                                        $balanceBefore = htmlspecialchars($row['balancebefore']);
                                        $balanceAfter = htmlspecialchars($row['balanceafter']);
                                        $message = htmlspecialchars($row['message']);
                                        $trxid = htmlspecialchars($row['trxid']);

                                        $color = match($status) {
                                            "pending" => "warning",
                                            "rejected" => "danger",
                                            "successful" => "success",
                                            default => "secondary"
                                        };

                                        $symbol = "₦";
                                        $dateTime = new DateTime($row['date']);
                                        $currentTime = new DateTime();
                                        $interval = $dateTime->diff($currentTime);

                                        if ($interval->y > 0) $timeAgo = $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
                                        elseif ($interval->m > 0) $timeAgo = $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
                                        elseif ($interval->d > 0) $timeAgo = $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
                                        elseif ($interval->h > 0) $timeAgo = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
                                        elseif ($interval->i > 0) $timeAgo = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
                                        else $timeAgo = 'just now';
                                ?>
                                <tr>
                                    <td><?= $initiatedFrom ?></td>
                                    <td><span class="btn btn-<?= $color ?> btn-sm"><?= $status ?></span></td>
                                    <td><?= $symbol . number_format((float)$amount, 2) ?></td>
                                    <td><?= $trxid ?></td>
                                    <td><?= $symbol . number_format((float)$balanceBefore, 2) ?></td>
                                    <td><?= $symbol . number_format((float)$balanceAfter, 2) ?></td>
                                    <td><?= $message ?></td>
                                    <td><?= $timeAgo ?></td>
                                </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No transactions found.</td></tr>";
                                }
                                $stmt->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<?php include "inc/footer2.php" ?>