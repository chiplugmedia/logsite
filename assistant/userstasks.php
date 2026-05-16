<?php 
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
$amount="";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/tasks.php";

include"inc/header.php" ;

?>






<div class="container-fluid">

                    <div class="layout-specing">

                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Upload Task</h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    

                                    <li class="breadcrumb-item text-capitalize"><a href="profile">Activity </a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page"> Perfomed Task</li>

                                </ul>

                            </nav>

                        </div>







<!-- User Tasks Section -->
<div class="col mt-4 pt-2" id="tables">
    <div class="component-wrapper rounded shadow">
        <div class="p-4 border-bottom">
            <h4 class="title mb-0">Tasks </h4>
        </div>
        <?php echo $genMsg?>
        <div class="p-4">
            <div class="table-responsive bg-white shadow rounded">
                <table class="table mb-0 table-center">
                    <thead>
                        <tr>
                            <th scope="col" class="border-bottom">#</th>
                            <th scope="col" class="border-bottom">Username</th>
                            <th scope="col" class="border-bottom">Title</th>
                            <th scope="col" class="border-bottom">Amount</th>
                            <th scope="col" class="border-bottom">Link</th>
                            <th scope="col" class="border-bottom">Status</th>
                            <th scope="col" class="border-bottom">Date</th>
                            <th scope="col" class="border-bottom">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql=$link->prepare("SELECT * FROM usertasks ORDER BY id DESC");
                        $sql->execute();
                        $result=$sql->get_result();
                        
                        $numrow=$result->num_rows;
                        if($numrow > 0){
                            $idCount=0;
                            while($row=$result->fetch_assoc()){
                                $idCount++;
                                $username = $row['username'];
                                $title= $row['title'];
                                $amount = $row['amount'];
                                $status = $row['status'];
                                $id = $row['id'];
                                $url = $row['url'];
                                $reference = $row['reference'];
                                $date=$row['date'];
                                
                                $statusColor = "";
                                if($status == "pending"){
                                    $statusColor = "danger";
                                }
                                else if($status == "completed"){
                                    $statusColor = "success";
                                }
                        ?>
                        <tr>
                            <th scope="row"><?php echo $id?></th>
                            <td><?php echo ucwords($username)?></td>
                            <td><?php echo ucwords($title)?></td>
                            <td><?php echo $amount?></td>
                            <!-- Assuming the user tasks table has a 'url' column -->
                            <td><?php echo $url?></td>
                            <td>
                                <div class="badge bg-soft-<?php echo $statusColor?> rounded px-3 py-1">
                                    <?php echo $status?>
                                </div>
                            </td>
                            <!-- Assuming the user tasks table has a 'date' column -->
                            <td><?php echo $date?></td>
                            <td>
                                <!-- <button class="btn btn-sm btn-success completePost">Mark Complete</button> -->
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

<!-- ... (previous HTML code) -->

<script>
    $(".completePost").on("click", function(){
        let id = $(this).closest("tr").find(".id").val();
        postAction(id, "completePost");
        // Update the status to "Completed" immediately
        $(this).closest("tr").find(".status").text("Completed");
    })

    // ... (similar event listener for other actions)

    function postAction(id, action){
        let form = document.createElement('form');
        let input = document.createElement('input');
        let inputID = document.createElement('input');
        let body = document.querySelector('body');
        form.method = "POST";
        input.type = "hidden";
        input.value = action;
        input.name = action;

        inputID.type = "hidden";
        inputID.value = id;
        inputID.name = "id";

        form.appendChild(inputID);
        form.appendChild(input);
        body.appendChild(form);
        form.submit();
    }
</script>


                <?php include"inc/footer.php" ?>