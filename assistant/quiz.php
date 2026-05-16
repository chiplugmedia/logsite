<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/add_question.php";

?>

<?php include"inc/header.php" ?>

<div class="container-fluid">
    <div class="layout-spacing">
        <div class="d-md-flex justify-content-between align-items-center">
            <h5 class="mb-0">Questions</h5>
            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">
                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">
                    <li class="breadcrumb-item text-capitalize"><a href="profile.php">Activity</a></li>
                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Post</li>
                </ul>
            </nav>
        </div>
        
        <div class="col-lg-4 mt-4">
            <?php echo $genMsg; ?>
            <div class="card border-0 rounded shadow">
                <div class="card-body">
                    <h5 class="text-md-start text-center mb-0">Question Post:</h5>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Question</label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <input id="question_text" type="text" class="form-control ps-5" placeholder="Question :" name="question_text" value="<?php echo isset($question_text) ? $question_text : ''; ?>" required>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Correct Answer</label>
                                    <div class="form-icon position-relative">
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <input id="correct_answer" type="text" class="form-control ps-5" placeholder="Correct Answer :" name="correct_answer" value="<?php echo isset($correct_answer) ? $correct_answer : ''; ?>" required>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Answers To Choose</label>
                                    <div class="form-icon position-relative">
    <i data-feather="user" class="fea icon-sm icons"></i>
    <input type="text" class="form-control ps-5" id="answer1" name="answers[]" placeholder="Answer 1">
</div>
<div class="form-icon position-relative">
    <i data-feather="user" class="fea icon-sm icons"></i>
    <input type="text" class="form-control ps-5" id="answer2" name="answers[]" placeholder="Answer 2">
</div>
<div class="form-icon position-relative">
    <i data-feather="user" class="fea icon-sm icons"></i>
    <input type="text" class="form-control ps-5" id="answer3" name="answers[]" placeholder="Answer 3">
    </div>
<div class="form-icon position-relative">
    <i data-feather="user" class="fea icon-sm icons"></i>
    <input type="text" class="form-control ps-5" id="answer4" name="answers[]" placeholder="Answer 4">
    </div>
<div class="form-icon position-relative">
    <i data-feather="user" class="fea icon-sm icons"></i>
    <input type="text" class="form-control ps-5" id="answer5" name="answers[]" placeholder="Answer 5">

                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" id="submit" name="addquestion" class="btn btn-primary" value="Upload Question">
                            </div><!--end col-->
                        </div><!--end row-->
                    </form><!--end form-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-lg-4-->
    </div><!--end layout-spacing-->
</div><!--end container-fluid-->



 <!-- ... (previous HTML code) -->

<div class="col mt-4 pt-2" id="tables">
    <div class="component-wrapper rounded shadow">
        <div class="p-4 border-bottom">
            <h4 class="title mb-0"> Recent </h4>
        </div>

        <div class="p-4">
            <div class="table-responsive bg-white shadow rounded">
                <table class="table mb-0 table-center">
                    <thead>
                        <tr>
                            <th scope="col" class="border-bottom">#</th>
                            <th scope="col" class="border-bottom">Question</th>
                            <th scope="col" class="border-bottom">Correct Answer</th>
                            <th scope="col" class="border-bottom">Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $sql=$link->prepare("SELECT * FROM questions ORDER BY id DESC");
                        $sql->execute();
                        $result=$sql->get_result();
                        
                        $numrow=$result->num_rows;
                        if($numrow > 0){
                            $idCount=0;
                            while($row=$result->fetch_assoc()){
                                $idCount++;
                                $question_text=$row['question_text'];
                                $date=$row['date'];
                                $correct_answer=$row['correct_answer'];
                                $id=$row['id'];
                                $reference=$row['reference'];
                                
                                $statusColor="";
                                if($status == "active"){
                                    $statusColor="success";
                                }
                                else if($status == "completed"){
                                    $statusColor="danger";
                                }
                        ?>
                        <tr>
                            <th scope="row"><?php echo $idCount?></th>
                            <td><?php echo ucwords($question_text)?></td>
                            <td><?php echo $correct_answer?></td>
                            
                            <td><?php echo $date?></td>
                            <td>
                                
                                <input type="hidden" value="<?php echo $id?>" class="id">
                                <input type="hidden" value="<?php echo $reference?>" class="reference">
                            </td>
                        </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--end col-->



<?php include"inc/footer.php" ?>
