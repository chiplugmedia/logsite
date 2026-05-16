<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/process_answer.php";

$ptitle="Brain Teaser (quiz)";
include "inc/eader21.php" ?>


<?php
$date = date("Y-m-d");
$sql = $link->prepare("SELECT * FROM questions WHERE reference NOT IN (SELECT reference FROM user_answers WHERE username=?) AND SUBSTRING(date, 1, 10) = ?");
$sql->bind_param("ss", $username, $date);
$sql->execute();
$result = $sql->get_result();
$numrow = $result->num_rows;

if ($numrow > 0) {
    while ($row = $result->fetch_assoc()) {
        $question_text = htmlspecialchars($row['question_text']);
        $reference = htmlspecialchars($row['reference']);
?>
<div class="container">
        <div class="content">
            <div class="row">
                                    <div class="col-lg-6 mb-3">
                        <div class="card shadow-lg">
                            <div class="card-header" style="background-image: url('/Flowtrex/user/mPay/assets/images/background/auth-bg.jpg');">
                                <h4 class="mt-2 text-white balance"><?php echo $question_text; ?></h4>
                            </div>
                            <div class="card-body" style="background-image: url('/Flowtrex/user/mPay/assets/images/background/auth-bg.jpg');">
                                <p class="mt-2 text-white balance" ><strong>Instruction:</strong> Answer this question by choosing a correct option from (a) to (e)

Note: it will cost you NP1000 activities point either you win or not</p>
                            </div>
                        </div>

                <div><?php echo $genMsg; ?></div>
        
               

                                <div class="card-body">
                                     <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="fw-bold" for="predict">Choose One Answer:</label>
                                            <?php
                                $sql_answers = $link->prepare("SELECT * FROM answers WHERE question_id = ?");
                                $sql_answers->bind_param("i", $row['id']);
                                $sql_answers->execute();
                                $result_answers = $sql_answers->get_result();
                                if ($result_answers->num_rows > 0) {
                                    while ($row_answer = $result_answers->fetch_assoc()) {
                                        $answer_text = htmlspecialchars($row_answer['answer_text']);
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="correct_answer" id="<?php echo $answer_text; ?>" value="<?php echo $answer_text; ?>">
                                            <label class="form-check-label" for="<?php echo $answer_text; ?>">
                                                <?php echo $answer_text; ?>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <input name="reference" id="reference" value="<?php echo $reference; ?>" type="hidden">
                                        <button name="questionqize" class="btn theme-btn w-100" type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
<?php
    }
} else {
    echo '
    <div class="container">
    <div class="alert alert-warning">No questions at the moment, check back later.</div>';
}
?>

<div class="container">
    <section class="section-b-space">
        <div class="custom-container">
            <div class="title">
                <h2>Prediction History</h2>
            </div>

            <div class="tab-content rounded-lg p-3 shadow-sm" id="affanTabs1Content">
                <div class="tab-pane fade show active" id="bootstrap" role="tabpanel" aria-labelledby="bootstrap-tab">
                    <?php
                    $sql = $link->prepare("SELECT * FROM user_answers WHERE username=? ORDER BY id DESC");
                    $sql->bind_param("s", $username);
                    $sql->execute();
                    $result = $sql->get_result();
                    $numrow = $result->num_rows;
                    if ($numrow > 0) {
                        $idCount = 0;
                        while ($row = $result->fetch_assoc()) {
                            $idCount++;
                            $id = $row['id'];
                            $question_text = $row['question_text'];
                            $amount = $row['amount'];
                            $date = $row['date'];
                            $correct_answer = $row['correct_answer'];

                            $color = "";
                            $symbol = "";
                            if ($amount == "0") {
                                $color = "danger";
                                $symbol = "-NP";
                            } elseif ($amount == "200") {
                                $color = "success";
                                $symbol = "+NP";
                            }
                            
                            
                    ?>
                            <div class="row gy-3">
                                <div class="col-12">
                                    <div class="transaction-box">
                                        <a href="#transaction-detail" data-bs-toggle="modal" class="d-flex gap-3">
                                            <div class="transaction-image">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle sidebar-icon">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="M9.09 9a3 3 0 1 1 5.83 1c0 1.5-1.36 2.71-3 2.71h-.16v1.29"></path>
                                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                                </svg>
                                            </div>
                                            <div class="transaction-details">
                                                <div class="transaction-name">
                                                    <h5><?php echo htmlspecialchars($question_text); ?></h5>
                                                    <h3 class="text-truncate text-<?php echo $color; ?>"><?php echo htmlspecialchars($symbol . $amount); ?> </h3>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="text-<?php echo $color; ?>">Your Answer - <?php echo $correct_answer; ?> </h5>
                                                    <h5 class="light-text"><?php echo htmlspecialchars($date); ?></h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>No History found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .img-avatar {
        width: 50px; /* Adjust as per your design */
        height: 50px; /* Adjust as per your design */
        border-radius: 50%; /* Ensures the image is circular */
        object-fit: cover; /* Ensures the image covers the area */
    }
</style>


      
  <?php include "inc/footer2.php" ?>