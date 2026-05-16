<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/products.php";


include"inc/header.php" ?>

 <div class="container-fluid">

                    <div class="layout-specing">

                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Product</h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    

                                    <li class="breadcrumb-item text-capitalize"><a href="#">Home </a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Product</li>

                                </ul>

                            </nav>

                        </div>
<a href="course.php" class="btn btn-sm btn-primary downloadactivity">Import Services</a>
<div class="col mt-4 pt-2" id="tables">
    <div class="component-wrapper rounded shadow">
        <div class="p-4 border-bottom">
            <h4 class="title mb-0"> Recent </h4>
        </div>
        <div class="p-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="border-bottom">Name</th>
                        <th scope="col" class="border-bottom">Price</th>
                        <th scope="col" class="border-bottom">Status</th>
                        <th scope="col" class="border-bottom">Date</th>
                        <th scope="col" class="border-bottom">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        $sql = $link->prepare("SELECT * FROM products ORDER BY id DESC");
                        $sql->execute();
                        $result = $sql->get_result();
                        
                        $numrow = $result->num_rows;
                        if ($numrow > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['id'];
                                $name = $row['name'];
                                $category = $row['category'];
                                $type = $row['type'];
                                $price = $row['price'];
                                $status = $row['status'];
                                $date = $row['date'];
                                $purchaseinfo = $row['purchaseinfo'];
                                $description = $row['description'];
                                $reference = $row['reference'];
                                
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
                                } elseif ($type == "textnow") {
                                    $imageSrc = "textnow.png";
                                } elseif ($type == "mail") {
                                    $imageSrc = "mail.jpeg";
                                } elseif ($type == "outlook") {
                                    $imageSrc = "outlook.png";
                                } elseif ($type == "piavpn") {
                                    $imageSrc = "piavpn.png";
                                } elseif ($type == "nordvpn") {
                                    $imageSrc = "nordvpn.png";
                                } elseif ($type == "ipvanishvpn") {
                                    $imageSrc = "ipvanishvpn.png";
                                } elseif ($type == "expressvpn") {
                                    $imageSrc = "expressvpn.png";
                                } elseif ($type == "surfshark") {
                                    $imageSrc = "surfshark.png";
                                } elseif ($type == "snapchat") {
                                    $imageSrc = "snapchat.png";
                                } elseif ($type == "oldreddit") {
                                    $imageSrc = "oldreddit.png";
                                } elseif ($type == "applemusic") {
                                    $imageSrc = "applemusic.png";
                                } elseif ($type == "netflix") {
                                    $imageSrc = "netflix.png";
                                } elseif ($type == "textplus") {
                                    $imageSrc = "textplus.png";
                                } elseif ($type == "googlevoice") {
                                    $imageSrc = "googlevoice.png";
                                } elseif ($type == "textfree") {
                                    $imageSrc = "textfree.png";
                                } elseif ($type == "talkatone") {
                                    $imageSrc = "talkatone.png";
                                } elseif ($type == "yellowupdate") {
                                    $imageSrc = "yellowupdate.png";
                                } elseif ($type == "fakeflightticket") {
                                    $imageSrc = "fakeflightticket.png";
                                }
                                
                                $statusColor = $status == "active" ? "success" : ($status == "sold" ? "danger" : "");
                                
                                // Convert the date into a DateTime object
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
                        <td>
                            <a class="text-primary">
                                <div class="d-flex align-items-center">
                                    <img src="/dash/img/<?php echo $imageSrc ?>" class="avatar avatar-ex-small rounded-circle shadow" alt="No image found">
                                    <span class="ms-2"><?php echo $name ?></span>
                                </div>
                            </a>
                        </td>
                        <td>₦<?php echo number_format($price); ?></td>
                        <td class="text-center">
                            <div class="badge bg-soft-<?php echo $statusColor; ?> rounded px-3 py-1">
                                <?php echo ucfirst($status); ?>
                            </div>
                        </td>
                        <td><?php echo $timeAgo; ?></td>
                        <td class="text-end">
                            <a href="data-prices.php?reference=<?php echo $reference; ?>" class="btn btn-sm btn-success">Edit</a>
                            <button class="btn btn-danger deleteProduct">Delete</button>
                            <input type="hidden" value="<?php echo $reference; ?>" class="reference">
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
</div><!--end col-->

<script>
    // Attach click event listener to elements with class "deleteProduct"
    document.querySelectorAll(".deleteProduct").forEach(button => {
        button.addEventListener("click", function() {
            // Get the reference value from the closest table row
            let reference = this.closest("tr").querySelector(".reference").value;
            // Call the deleteProduct function with the reference value
            deleteProduct(reference);
        });
    });

    // Function to create and submit a form to delete the product
    function deleteProduct(reference) {
        // Create a form element
        let form = document.createElement('form');
        // Create input elements for deleteProduct and reference
        let input = document.createElement('input');
        let inputRef = document.createElement('input');
        // Get the body element to append the form
        let body = document.querySelector('body');

        // Set form method to POST
        form.method = "POST";

        // Set input type and value for deleteProduct
        input.type = "hidden";
        input.value = "deleteProduct";
        input.name = "deleteProduct";

        // Set input type and value for reference
        inputRef.type = "hidden";
        inputRef.value = reference;
        inputRef.name = "reference";

        // Append the inputs to the form
        form.appendChild(input);
        form.appendChild(inputRef);
        // Append the form to the body
        body.appendChild(form);
        // Submit the form
        form.submit();
    }
</script>



<?php include"inc/footer.php" ?>
