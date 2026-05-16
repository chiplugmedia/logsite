<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/socialask.php";

$ptitle="Social Tasks";
//$taskStatus="no";

$completedTotal = 0;
$pendingTotal = 0;

include "inc/header2.php" ?>



    
    
    <?php

$sql = $link->prepare("SELECT * FROM usersocaltasks WHERE username = ?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();
$numrow = $result->num_rows;

if ($numrow > 0) {
    while ($row = $result->fetch_assoc()) {
        $amount = $row['amount'];
        $status = $row['status'];

        if ($status == "completed") {
            $completedTotal += $amount;
        } elseif ($status == "pending") {
            $pendingTotal += $amount;
        }
    }
}

// Now you can use $completedTotal and $pendingTotal in your Tiny Slider section
?>

<section class="section-b-space">
    <div class="custom-container">
        <div class="profile-title" style="display: flex; align-items: center; margin-bottom: 20px;">
            <?php if ($profileImg == "no-avatar.png") { ?>
                <img class="img-fluid profile-pic" src="/Flowtrex/user/5.gif" alt="Avatar" width="40">
            <?php } else { ?>
                <img class="img-fluid profile-pic" src="assets/img/profilephotos/<?php echo $profileImg?>" alt="Avatar" width="40">
            <?php } ?>
            <div style="display: flex; flex-direction: column; margin-left: 10px;">
                <h2 class="dark-text" style="display: flex; align-items: center;">Hi, <?php echo $fullname; ?><img class="ml-2" src="img/hand.gif" alt="hand-gif" width="32"></h2>
                <h5 style="color: orange;"><?php echo $greeting; ?></h5>
            </div>
        </div>
        <div class="card-box">
            <div class="card-details">
                <div class="d-flex justify-content-between">
                    <h5 class="fw-semibold">Completed Tasks</h5>
                    <img src="/Flowtrex/user/mPay/assets/images/svg/ellipse.svg" alt="ellipse">
                </div>

                <h1 class="mt-2 text-white balance" id="balance"><?php echo $point ?><?php echo number_format((int)$completedTotal, 2) ?></h1>

                <div class="amount-details">
                    <div class="amount w-50 text-start">
                        <div class="d-flex align-items-center justify-content-start">
                            <h5>Pending Tasks</h5>
                        </div>
                        <h3 class="text-white"><?php echo $point ?><?php echo number_format((int)$pendingTotal, 2) ?></h3>
                    </div>
                    <div class="amount w-50 text-end border-0">
                        <div class="d-flex align-items-center justify-content-end">
                        </div>
                        <h3 class="text-white"></h3>
                    </div>
                </div>
            </div>
            <a href="#" class="add-money theme-color" onclick="toggleBalance()">View Balance</a>
        </div>
    </div>
</section>

<script>
    function toggleBalance() {
        var balanceElement = document.getElementById('balance');
        balanceElement.classList.toggle('hidden');
    }
</script>

<style>
    .hidden {
        display: none;
    }
</style>
<div class="notification-area">
    <div class="container">
        <section class="section-b-space">
            <div class="custom-container">
                <h4 class="dark-text"><?php echo $ptitle; ?></h4>
                <div><?php echo $genMsg; ?></div>
            </div>
        </section>

       <?php
$date = date("d-m-Y");

// Query to get all tasks for the current date
$sql = $link->prepare("SELECT * FROM socaltasks WHERE SUBSTRING(date, 1, 10) = ?");
$sql->bind_param("s", $date);
$sql->execute();
$result = $sql->get_result();
$numrow = $result->num_rows;

if ($numrow > 0) {
    $activeTasks = [];
    $otherTasks = [];

    while ($row = $result->fetch_assoc()) {
        $title = htmlspecialchars($row['title']);
        $desc = htmlspecialchars($row['description']);
        $amount = htmlspecialchars($row['amount']);
        $reference = htmlspecialchars($row['reference']);
        $status = htmlspecialchars($row['status']);
        $type = htmlspecialchars($row['type']);
        $url = htmlspecialchars($row['url']);
        $id = htmlspecialchars($row['id']);

        // Query to check if user has performed the task
        $userTaskSql = $link->prepare("SELECT status FROM usersocaltasks WHERE username=? AND reference=?");
        $userTaskSql->bind_param("ss", $username, $reference);
        $userTaskSql->execute();
        $userTaskResult = $userTaskSql->get_result();

        $userTaskPerformed = false;
        $userTaskStatus = $status;

        if ($userTaskResult->num_rows > 0) {
            // Task has been performed, fetch the status
            $taskData = $userTaskResult->fetch_assoc();
            $userTaskPerformed = true; 

            // Determine the status message based on the fetched status
            switch ($taskData['status']) {
                case 'completed':
                    $userTaskStatus = 'Task Completed';
                    break;
                case 'pending':
                    $userTaskStatus = 'Task Pending';
                    break;
                case 'rejected':
                    $userTaskStatus = 'Task Rejected';
                    break;
            }
        }

        $imageSrc = '';
        if ($type == "facebook") {
            $imageSrc = "facebook.png";
        } elseif ($type == "instagram") {
            $imageSrc = "instagram.png";
        } elseif ($type == "twitter") {
            $imageSrc = "twitter.png";
        } elseif ($type == "youtube") {
            $imageSrc = "youtube.png";
        } elseif ($type == "telegram") {
            $imageSrc = "telegram.png";
        } elseif ($type == "whatsapp") {
            $imageSrc = "whatsapp.png";
        }

        $taskRow = [
            'imageSrc' => $imageSrc,
            'title' => $title,
            'desc' => $desc,
            'amount' => $amount,
            'status' => $userTaskStatus,
            'date' => $date,
            'url' => $url,
            'reference' => $reference,
            'userTaskPerformed' => $userTaskPerformed
        ];

        if ($userTaskStatus == "active") {
            $activeTasks[] = $taskRow;
        } else {
            $otherTasks[] = $taskRow;
        }
    }

    function renderTable($tasks) {
        foreach ($tasks as $task) {
            $statusColor = '';
            if ($task['status'] == "active") {
                $statusColor = "success-color";
            } elseif ($task['status'] == "completed") {
                $statusColor = "success-color";
            } elseif ($task['status'] == "rejected") {
                $statusColor = "error-color";
            } elseif ($task['status'] == "pending") {
                $statusColor = "text-warning";
            }

            echo '<tr>';
            echo '<td class="dark-text"><img src="img/' . $task['imageSrc'] . '" width="40" alt="Avatar" class="rounded-circle mr-3"></td>';
            echo '<td class="dark-text">' . $task['title'] . '</td>';
            echo '<td class="dark-text">' . $task['desc'] . '</td>';
            echo '<td class="dark-text">NP' . $task['amount'] . '</td>';
            echo '<td class="' . $statusColor . '">' . ucfirst($task['status']) . '</td>';
            echo '<td class="dark-text">' . $task['date'] . '</td>';
            echo '<td class="dark-text">';
            if (!$task['userTaskPerformed']) {
                echo '<button type="button" class="btn theme-btn" data-bs-toggle="modal" data-bs-target="#modalTask" onclick="window.location.href = \'' . $task['url'] . '\'">Perform Task</button>';
            } else {
                echo '<span class="text-warning"></span>';
            }
            echo '</td>';
            echo '<td class="dark-text">';
            if (!$task['userTaskPerformed']) {
                echo '<form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="reference" value="' . $task['reference'] . '">
                        <input type="file" id="image" name="image" accept="image/*" required>
                        <input type="submit" name="addTask" class="btn theme-btn" value="Upload">
                      </form>';
            } else {
                echo '<span class="text-warning">Proof Uploaded</span>';
            }
            echo '</td>';
            echo '</tr>';
        }
    }
    ?>
    <div class="standard-tab">
        <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">
            <li class="transaction-name" role="presentation">
                <button class="btn active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab" aria-controls="active" aria-selected="true">Active Tasks</button>
            </li>
            <li class="transaction-name" role="presentation">
                <button class="btn" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="other" aria-selected="false">Performed Task</button>
            </li>
        </ul>
        <div class="tab-content" id="affanTabs1Content">
            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="dark-text">Image</th>
                                <th class="dark-text">Title</th>
                                <th class="dark-text">Description</th>
                                <th class="dark-text">Amount</th>
                                <th class="dark-text">Status</th>
                                <th class="dark-text">Date</th>
                                <th class="dark-text">Action</th>
                                <th class="dark-text">Upload Proof Of Performed Task</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php renderTable($activeTasks); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="dark-text">Image</th>
                                <th class="dark-text">Title</th>
                                <th class="dark-text">Description</th>
                                <th class="dark-text">Amount</th>
                                <th class="dark-text">Status</th>
                                <th class="dark-text">Date</th>
                                <th class="dark-text">Action</th>
                                <th class="dark-text">Upload Proof Of Performed Task</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php renderTable($otherTasks); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    echo '<tr class="dark-text"><td colspan="7">No tasks available for today.</td></tr>';
}
?>
</div>
</div>

<?php include "inc/footer2.php" ?>