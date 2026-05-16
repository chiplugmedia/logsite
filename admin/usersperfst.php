<?php 
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/socialask.php";

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
            <h4 class="title mb-0">Social Tasks</h4>
        </div>
        <?php echo $genMsg; ?>
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
                            <th scope="col" class="border-bottom">View Proof</th>
                            <th scope="col" class="border-bottom">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = $link->prepare("SELECT * FROM usersocaltasks ORDER BY id DESC");
                        $sql->execute();
                        $result = $sql->get_result();

                        $idCount = 0;
                        while ($row = $result->fetch_assoc()) {
                            $idCount++;
                            $username = ucwords($row['username']);
                            $title = ucwords($row['title']);
                            $amount = $row['amount'];
                            $image = $row['image'];
                            $status = ucwords($row['status']);
                            $id = $row['id'];
                            $url = $row['url'];
                            $date = $row['date'];

                            $statusColor = "";
                            switch ($status) {
                                case "Pending":
                                    $statusColor = "danger";
                                    break;
                                case "Completed":
                                    $statusColor = "success";
                                    break;
                                case "Rejected":
                                    $statusColor = "warning";
                                    break;
                                default:
                                    $statusColor = "primary";
                                    break;
                            }
                        ?>
                        <tr>
                            <th scope="row"><?php echo $idCount; ?></th>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $amount; ?></td>
                            <td><a href="<?php echo $url; ?>" target="_blank">Link</a></td>
                            <td>
                                <div class="badge bg-soft-<?php echo $statusColor; ?> rounded px-3 py-1">
                                    <?php echo $status; ?>
                                </div>
                            </td>
                            <td><?php echo $date; ?></td>
                            <td class="text-end p-3">
                                <a href="/dash/img/userstask/<?php echo $image; ?>" class="btn btn-sm btn-primary" target="_blank">View Image</a>
                            </td>
                            <td class="text-end p-3">
                                <button class="btn btn-sm btn-primary approve" data-id="<?php echo $id; ?>">Approve</button>
                                <button class="btn btn-sm btn-danger decline" data-id="<?php echo $id; ?>">Decline</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- end col -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $(".approve, .decline").on("click", function() {
            let id = $(this).data("id");
            let action = $(this).hasClass("approve") ? "approve" : "decline";
            actionRequest(id, action);
        });

        function actionRequest(id, action) {
            let form = $("<form>")
                .attr("method", "POST")
                .appendTo("body");
            $("<input>").attr("type", "hidden").attr("name", "id").val(id).appendTo(form);
            $("<input>").attr("type", "hidden").attr("name", action).appendTo(form);
            form.submit();
        }
    });
</script>




                <?php include"inc/footer.php" ?>