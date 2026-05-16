<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/tasks.php";

$ptitle="Product Details";
//$taskStatus="no";
include "inc/header2.php" ?>





<div><?php echo $genMsg?></div>
  

<?php

// Check if the category ID is set in the URL
if (!isset($_GET['id'])) {
    echo 'Category ID not specified.';
    exit();
}

$product_id = $_GET['id'];

// Prepare and execute the query to fetch the product details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = mysqli_prepare($link, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $productRow = mysqli_fetch_assoc($result);
        $productName = $productRow['name'];
        $price = $productRow['price'];
        $description = $productRow['description'];
        $id = $productRow['id'];
        $type = $productRow['type'];
        $reference = $productRow['reference'];
        $categoryName = $productRow['category']; // Assuming 'category' is a column in your products table

        // Query to get the total quantity of a specific product within a category
        $quantityStmt = $link->prepare("SELECT COUNT(*) AS total FROM products WHERE category = ? AND name = ? AND status = 'active'");
        $quantityStmt->bind_param("ss", $categoryName, $productName);
        $quantityStmt->execute();
        $quantityResult = $quantityStmt->get_result();
        $totalQuantity = $quantityResult->fetch_assoc()['total'];

        // Determine image based on type
        $imageMap = [
            "facebook" => "facebook.png",
            "instagram" => "instagram.png",
            "twitter" => "twitter.png",
            "youtube" => "youtube.png",
            "telegram" => "telegram.png",
            "whatsapp" => "whatsapp.png",
            "textnow" => "textnow.png",
            "mail" => "mail.jpeg",
            "outlook" => "outlook.png",
            "piavpn" => "piavpn.png",
            "nordvpn" => "nordvpn.png",
            "ipvanishvpn" => "ipvanishvpn.png",
            "expressvpn" => "expressvpn.png",
            "surfshark" => "surfshark.png",
            "snapchat" => "snapchat.png",
            "oldreddit" => "oldreddit.png",
            "applemusic" => "applemusic.png",
            "netflix" => "netflix.png",
            "textplus" => "textplus.png",
            "googlevoice" => "googlevoice.png",
            "textfree" => "textfree.png",
            "talkatone" => "talkatone.png",
            "yellowupdate" => "yellowupdate.png",
            "fakeflightticket" => "fakeflightticket.png",
        ];

        $imageSrc = $imageMap[$type] ?? 'default.png';
        ?>
        <div class="pc-container">
    <div class="pc-content">
        <div class="d-flex justify-content-center my-4">
            <img class="my-2" src="img/<?php echo htmlspecialchars($imageSrc); ?>" width="100px" height="100px" alt="<?php echo htmlspecialchars($productName); ?>">
        </div>
        <div class="response"><?php echo $genMsg; ?></div>
        <div class="dashboard-body__item my-2">
            <div class="detail-content">
                <div class="flex-1">
                    <h4><?php echo htmlspecialchars($productName); ?></h4>
                    <div class="content-mota" style="font-size: 13px; line-height: 1.6; color: rgb(0,0,0); font-family: Roboto, sans-serif;">
                        <div><?php echo htmlspecialchars($description); ?></div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6 d-flex justify-content-start">
                    <h6 class="">₦<?php echo number_format($price, 2); ?>/Pcs</h6>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <button type="button" style="background: #d5d5d5; color: #ffffff;" class="btn text-dark btn-sm">
                        <?php echo htmlspecialchars($totalQuantity); ?> pcs in stock
                    </button>
                </div>
            </div>
            <hr>
            <form class="p-3" action="" method="POST">
                <div class="row">
                    <div class="col-6">
                        <input type="number" name="quantity" style="width: 70px; text-align: center; border-radius: 10px;" id="quantity" class="input-quantity" value="1" min="1">
                    </div>
                    <div class="col-6 d-flex justify-content-end mb-4">
                        <button type="button" style="background: #1dbf63; color: #ffffff;" class="btn btn-main btn-sm w-70 pill">
                            ₦<span id="total">10.00</span>
                        </button>
                    </div>
                </div>

            

                <input type="hidden" id="purchaseQuantity" name="quantity" value="1">
                <input type="hidden" name="reference" value="<?php echo htmlspecialchars($reference); ?>">

                <div class="container">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" name="purchaseprod" style="display: block; text-align: center;" class="buy-btn w-100">
                            <i class="fas fa-shopping-cart"></i> Buy Now
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    } else {
        echo 'No products found for this category.';
    }
} else {
    echo 'Error preparing the SQL statement.';
}
?>

<script>
    const quantityInput = document.getElementById('quantity');
    const totalSpan = document.getElementById('total');
    const purchaseFormQuantity = document.getElementById('purchaseQuantity');
    const unitPrice = <?php echo json_encode($price); ?>;

    function updateTotal() {
        const quantity = parseInt(quantityInput.value, 10);
        const total = unitPrice * quantity;
        totalSpan.textContent = total.toFixed(2);
        purchaseFormQuantity.value = quantity;
    }

    quantityInput.addEventListener('input', updateTotal);
    updateTotal();
</script>


<?php include "inc/footer2.php" ?>