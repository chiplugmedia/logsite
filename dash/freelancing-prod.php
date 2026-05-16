<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";

$ptitle="Products";
include "inc/eader21.php" ?>

<div class="page-content-wrapper py-3">
    <div class="container">
       
 <div class="standard-tab">
    <ul class="nav rounded-lg mb-2 p-2 shadow-sm" id="affanTabs1" role="tablist">
        <li class="transaction-name" role="presentation">
            <a href="freelanc-ad"> <!-- Link for Upload Product tab -->
                <button class="btn active" id="bootstrap-tab" data-bs-toggle="tab" data-bs-target="#bootstrap" type="button" role="tab" aria-controls="bootstrap" aria-selected="true">Upload Product</button>
            </a>
        </li>
        <li class="transaction-name" role="presentation">
            <a href="freelancing-prod"> <!-- Link for My Product tab -->
                <button class="btn" id="pwa-tab" data-bs-toggle="tab" data-bs-target="#pwa" type="button" role="tab" aria-controls="pwa" aria-selected="false">My Product</button>
            </a>
        </li>
    </ul>
</div>

<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="row g-3 justify-content-center">
            <?php
            $sql = $link->prepare("SELECT * FROM products WHERE username=? ORDER BY id DESC LIMIT 100");
            $sql->bind_param("s", $username);
            $sql->execute();
            $result = $sql->get_result();
            $numrow = $result->num_rows;
            if ($numrow > 0) {
                $idCount = 0;
                while ($row = $result->fetch_assoc()) {
                    $idCount++;
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image = $row['image1'];
                    $status = $row['status'];

                    if ($status == "pending") {
                        $statusColor = "warning";
                    } elseif ($status == "rejected") {
                        $statusColor = "danger";
                    } else {
                        $statusColor = "success";
                    }
            ?>
                    <!-- Single Blog Card -->
                    <div class="top-products-area">
                        <div class="container">
                            <div class="row g-3">
                                <!-- Affiliate Card -->
                                <div class="col-6">
                                    <div class="transaction-box d-flex p-3">
                                        <div class="service-box" style="background-image: url('img/products/<?php echo htmlspecialchars($image); ?>'); background-size: cover; background-position: center; width: 100px; height: 100px;"></div>
                                        <div class="transaction-details d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="transfer-details">
                                                    <h5 class="fw-semibold dark-text"><?php echo htmlspecialchars($title); ?></h5>
                                                    <h6 class="value text-success"><?php echo $dollar ?><?php echo $price; ?></h6>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="badge bg-<?php echo $statusColor ?> rounded"><?php echo $status ?></span>
                                                <a class="badge bg-danger rounded deleteuserspd" data-id="<?php echo $id; ?>" data-image="<?php echo $image; ?>">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            <?php
                }
            }
            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(".deleteuserspd").on("click", function(){
        let id = $(this).data("id");
        let image = $(this).data("image");
        deleteuserspd(id, image);
    });

    function deleteuserspd(id, image){
        let form = document.createElement('form');
        let input = document.createElement('input');
        let inputID = document.createElement('input');
        let inputImg = document.createElement('input');
        let body = document.querySelector('body');
        form.method = "POST";
        input.type = "hidden";
        input.value = "deleteuserspd";
        input.name = "deleteuserspd";

        inputID.type = "hidden";
        inputID.value = id;
        inputID.name = "id";

        inputImg.type = "hidden";
        inputImg.value = image;
        inputImg.name = "image";

        form.appendChild(inputImg);
        form.appendChild(inputID);
        form.appendChild(input);
        body.appendChild(form);
        form.submit();
    }
</script>


<script>
    // Get all the tab buttons
    const tabButtons = document.querySelectorAll('.standard-tab .nav .btn');

    // Get all the tab content sections
    const tabContents = document.querySelectorAll('.tab-content .tab-pane');

    // Add click event listener to each tab button
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to the clicked button
            button.classList.add('active');

            // Get the target tab content id
            const targetId = button.getAttribute('data-bs-target');

            // Hide all tab content sections
            tabContents.forEach(content => {
                content.classList.remove('show', 'active');
            });

            // Show the target tab content section
            const targetContent = document.querySelector(targetId);
            targetContent.classList.add('show', 'active');
        });
    });
</script>



<?php include "inc/footer2.php" ?>