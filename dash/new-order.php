<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/topup.php";

// Call the function to get the list of services
$response = getCategoriesAndProducts();


$ptitle="Products";

$genMsg="";


include "inc/header2.php" ;

?>

 <div><?php echo $genMsg?></div>
 
<div class='pc-container'>
    <div class='pc-content'>
        <div class='dashboard-body__content'>
            <div class='dashboard-body__item-wrapper'>
            <div>
                    <div class="carousel my-3 mb-4">
                        <div class="carousel-images">
                            <a href="#"><img src="/young/imag/3.png" alt="Banner 1"></a>
                            <a href="#"><img src="/young/imag/2.png" alt="Banner 2"></a>
                            <!--<a href="#"><img src="https://fadded.tomitechltd.com/assets/assets/images/slider/Banner3.jpg" alt="Banner 3"></a>
                            <a href="#"><img src="https://fadded.tomitechltd.com/assets/assets/images/slider/Banner4.jpg" alt="Banner 4"></a>
                            <a href="#"><img src="https://fadded.tomitechltd.com/assets/assets/images/slider/Banner5.jpg" alt="Banner 5"></a>-->
                        </div>
                        <div class="carousel-buttons">
                            <button id="prevBtn">&#10094;</button>
                            <button id="nextBtn">&#10095;</button>
                        </div>
                    </div>
                    <script>
                        const carouselImages = document.querySelector('.carousel-images');
                        const images = document.querySelectorAll('.carousel-images a');
                        const totalImages = images.length;
                        let currentIndex = 0;

                        function showNextImage() {
                            currentIndex = (currentIndex + 1) % totalImages;
                            updateCarousel();
                        }

                        function showPreviousImage() {
                            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                            updateCarousel();
                        }

                        function updateCarousel() {
                            const translateX = -currentIndex * 100;
                            carouselImages.style.transform = `translateX(${translateX}%)`;
                        }

                        document.getElementById('nextBtn').addEventListener('click', showNextImage);
                        document.getElementById('prevBtn').addEventListener('click', showPreviousImage);

                        setInterval(showNextImage, 3000);
                    </script>
                </div>
                <div>
                    
                   <!--<?php
// Check if the API call was successful
if (isset($response['status']) && $response['status'] == 'success' && !empty($response['categories'])): 
?>
    <!-- Category Filter 
    <div class="welcome-balance mt-4 mb-5">
        <div class="row">
            <div class="col-12 d-flex justify-content-center flex-md-row align-items-center">
                <h4 class="d-flex justify-content-start mt-5">Search By Categories</h4>
                <div class="p-3 mt-3 mt-md-0">
                    <select id="urlSelect" onchange="redirectToUrl()" class="form-select form-select-sm filter-select" style="min-width: 130px">
                        <option value="">Select a Category</option>
                        <?php foreach ($response['categories'] as $category): ?>
                            <!-- Add the correct link for each category here 
                            <option value="">
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- Category Filter Ends 
<?php endif; ?>

<script>
    // Redirect to the selected category's URL
    function redirectToUrl() {
        const selectElement = document.getElementById('urlSelect');
        const selectedUrl = selectElement.value;
        if (selectedUrl) {
            window.location.href = selectedUrl;
        }
    }
</script>-->

                     
                <?php
echo "<h5 class='d-flex justify-content-start mt-5'>Our Recent Products ❤</h5>";

// Check if the API call was successful
if (isset($response['status']) && $response['status'] == 'success') {
    foreach ($response['categories'] as $category) {
        // Category Display Section
        echo "<div class='col-12'>
                <div class='catalog-item-wrapper mb-2'>
                    <div class='d-grid gap-2 mb-2'>
                        <strong>
                            <p style='font-size: 11px; background: linear-gradient(90deg, #f55366 0%, #000 100%); border-radius:10px; color: white' class='p-2'>"
                            . htmlspecialchars($category['name']) . 
                            "</p>
                        </strong>
                    </div>
                </div>
            </div>";

        // Product Display Section
        foreach ($category['products'] as $product) {
        // Convert amount to target currency using custom exchange rate
      $productPrice = isset($product['price']) ? $product['price'] : 0; // Default to 0 if price is missing

// Double the original price

// Convert the doubled price to the desired currency
$convertedAmount = convertCurrency($productPrice, isset($exchangeRates[$targetCountry]['USD']) ? $exchangeRates[$targetCountry]['USD'] : 1);

            $amount = isset($product['amount']) && $product['amount'] > 0 ? htmlspecialchars($product['amount']) . " pcs" : "OUT OF STOCK";
            $isInStock = isset($product['amount']) && $product['amount'] > 0;

            echo "<div class='col-lg-12 col-md-12'>
                    <div class='card'>
                        <div class='card-body'>
                            <ul class='list-group list-group-flush'>
                                <li class='list-group-item px-0 py-2'>
                                    <div class='d-flex align-items-center'>
                                        <div class='flex-shrink-0'>
                                            <img src='" . htmlspecialchars($category['icon']) . "' alt='img' class='wid-35 rounded-circle'>
                                        </div>
                                        <div class='flex-grow-1 mx-3'>
                                            <p class='mb-1'>
                                                <a class='text-small text-dark' ' style='font-size: 12px;'>"
                                                . htmlspecialchars($product['name']) . 
                                                "</a>
                                            </p>
                                            <p class='mb-0 text-muted'>
                                                <a class='text-white btn btn-dark btn-rounded btn-sm' style='font-size: 12px; font-weight: bolder'>"
                                                 . $currencySymbol . number_format($convertedAmount, 2) . 
                                                "</a> | 
                                                <a class='text-white btn btn-dark btn-rounded btn-sm' style='font-size: 12px; font-weight: bolder'>
                                                    " . ($isInStock ? $amount : "0") . "
                                                </a>
                                            </p>
                                        </div>
                                        <div class='col-2'>
                                            <div class='d-flex justify-content-center row'>
                                                <div class='col-12'>
                                                    <span class='text-small col-sm-12 badge bg-dark mb-1'></span>
                                                </div>
                                                <div class='col-12 d-flex justify-content-center'>
                                                    " . ($isInStock ? "
                                                    <a href='p2preg.php?id=" . htmlspecialchars($product['id']) . "' style='font-size: 8px' class='btn btn-sm'>
                                                        <svg width='22' height='22' viewBox='0 0 20 20' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                            <g clip-path='url(#clip0_206_491)'>
                                                                <path d='M18.4615 4.9659H14.6154C14.6154 3.7335 14.1291 2.55156 13.2636 1.68011C12.398 0.808664 11.2241 0.319092 10 0.319092C8.77592 0.319092 7.60198 0.808664 6.73643 1.68011C5.87087 2.55156 5.38462 3.7335 5.38462 4.9659H1.53846C1.13044 4.9659 0.739123 5.12909 0.450604 5.41958C0.162087 5.71005 0 6.10403 0 6.51484V18.1319C0 18.5427 0.162087 18.9366 0.450604 19.2271C0.739123 19.5176 1.13044 19.6808 1.53846 19.6808H18.4615C18.8696 19.6808 19.2609 19.5176 19.5494 19.2271C19.8379 18.9366 20 18.5427 20 18.1319V6.51484C20 6.10403 19.8379 5.71005 19.5494 5.41958C19.2609 5.12909 18.8696 4.9659 18.4615 4.9659ZM6.92309 8.83824C6.92309 9.04365 6.84204 9.24062 6.69777 9.38588C6.55351 9.53111 6.35785 9.61271 6.15385 9.61271C5.94983 9.61271 5.75417 9.53111 5.60992 9.38588C5.46566 9.24062 5.38462 9.04365 5.38462 8.83824V7.2893C5.38462 7.0839 5.46566 6.88692 5.60992 6.74167C5.75417 6.59643 5.94983 6.51484 6.15385 6.51484C6.35785 6.51484 6.55351 6.59643 6.69777 6.74167C6.84204 6.88692 6.92309 7.0839 6.92309 7.2893V8.83824ZM10 1.86803C10.816 1.86803 11.5987 2.19441 12.1757 2.77537C12.7527 3.35635 13.0769 4.14428 13.0769 4.9659H6.92309C6.92309 4.14428 7.24726 3.35635 7.82428 2.77537C8.40132 2.19441 9.18396 1.86803 10 1.86803ZM14.6154 8.83824C14.6154 9.04365 14.5343 9.24062 14.3901 9.38588C14.2458 9.53111 14.0502 9.61271 13.8461 9.61271C13.6421 9.61271 13.4465 9.53111 13.3022 9.38588C13.158 9.24062 13.0769 9.04365 13.0769 8.83824V7.2893C13.0769 7.0839 13.158 6.88692 13.3022 6.74167C13.4465 6.59643 13.6421 6.51484 13.8461 6.51484C14.0502 6.51484 14.2458 6.59643 14.3901 6.74167C14.5343 6.88692 14.6154 7.0839 14.6154 7.2893V8.83824Z' fill='#20CCB4'/>
                                                            </g>
                                                            <defs>
                                                                <clipPath id='clip0_206_491'>
                                                                    <rect width='20' height='20' fill='white'/>
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                        </a>
                                                    " : "<span class='text-danger'>OUT OF STOCK</span>") . "
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>";
        }
    }
}
?>


  <!--<?php
// Ensure the database connection $link is established before this script

// Fetch one active product name, its category, and category ID
$sql = $link->prepare("
    SELECT p.name, p.category, c.id AS category_id
    FROM products p
    JOIN categories c ON p.category = c.name
    WHERE p.status = 'active' AND p.category = 'AGED RANDOM COUNTRY FACEBOOK' LIMIT 1
");
$sql->execute();
$result = $sql->get_result();
$categoryrow = $result->fetch_assoc();

if ($categoryrow) {
    $name = $categoryrow['name'];
    $category = $categoryrow['category'];
    $categoryId = $categoryrow['category_id']; // Fetch the category ID

    // Query to fetch products for the specified category, ordered by id descending
    $sql = $link->prepare("SELECT * FROM products WHERE category = ? AND status = 'active' ORDER BY id DESC");
    $sql->bind_param("s", $category);
    $sql->execute();
    $result = $sql->get_result();
    $numrow = $result->num_rows;

    if ($numrow > 0) {
        echo '<div class="row">
            <div class="col-12">
                <div class="catalog-item-wrapper mb-2">
                    <div class="d-grid gap-2 mb-2">
                        <strong>
                            <p style="font-size: 11px; background: linear-gradient(90deg, #f65365 0%, #f65365 100%); border-radius:10px; color: white" class="p-2">' . htmlspecialchars($category) . '</p>
                        </strong>
                    </div>
                </div>'; // Start a row

        // Initialize variables
        $uniqueProducts = [];
        $isFirstProduct = true;

        // Product listing
        while ($row = $result->fetch_assoc()) {
            $productName = $row['name'];
            $price = $row['price'];
            $id = $row['id'];
            $type = $row['type'];

            // Skip duplicate product names
            if (in_array($productName, $uniqueProducts)) {
                continue;
            }

            // Add product name to the uniqueProducts array
            $uniqueProducts[] = $productName;

            // Query to get the total quantity of a specific product within a category
            $quantityStmt = $link->prepare("SELECT COUNT(*) AS total FROM products WHERE category = ? AND name = ? AND status = 'active'");
            $quantityStmt->bind_param("ss", $category, $productName);
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
            echo '<div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="img/' . htmlspecialchars($imageSrc) . '" alt="img" class="wid-35 rounded-circle">
                                        </div>
                                        <div class="flex-grow-1 mx-3">
                                            <p class="mb-1">
                                                <a class="text-small text-dark" href="details.php?id=' . htmlspecialchars($id) . '" style="font-size: 12px;">
                                                    ' . htmlspecialchars($productName) . '
                                                </a>
                                            </p>
                                            <p class="mb-0 text-muted">
                                                <a class="text-white btn btn-dark btn-rounded btn-sm" style="font-size: 12px; font-weight: bolder"> Price:₦' . number_format($price, 2) . '</a>
                                             | <a class="text-white btn btn-dark btn-rounded btn-sm"
                                 style="font-size: 12px; font-weight: bolder">' . htmlspecialchars($totalQuantity) . ' </a></p>
                                        </div>
                                        <div class="col-2">
                                            <div class="d-flex justify-content-center row">
                                                <div class="col-12">
                                                    <span class="text-small col-sm-12 badge bg-dark mb-1"></span>
                                                </div>
                                                <div class="col-12 d-flex justify-content-center">
                                                    <a href="details.php?id=' . htmlspecialchars($id) . '" style="font-size: 8px" class="btn btn-sm">
                                                        <svg width="22" height="22" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_206_491)">
                                                                <path d="M18.4615 4.9659H14.6154C14.6154 3.7335 14.1291 2.55156 13.2636 1.68011C12.398 0.808664 11.2241 0.319092 10 0.319092C8.77592 0.319092 7.60198 0.808664 6.73643 1.68011C5.87087 2.55156 5.38462 3.7335 5.38462 4.9659H1.53846C1.13044 4.9659 0.739123 5.12909 0.450604 5.41958C0.162087 5.71005 0 6.10403 0 6.51484V18.1319C0 18.5427 0.162087 18.9366 0.450604 19.2271C0.739123 19.5176 1.13044 19.6808 1.53846 19.6808H18.4615C18.8696 19.6808 19.2609 19.5176 19.5494 19.2271C19.8379 18.9366 20 18.5427 20 18.1319V6.51484C20 6.10403 19.8379 5.71005 19.5494 5.41958C19.2609 5.12909 18.8696 4.9659 18.4615 4.9659ZM6.92309 8.83824C6.92309 9.04365 6.84204 9.24062 6.69777 9.38588C6.55351 9.53111 6.35785 9.61271 6.15385 9.61271C5.94983 9.61271 5.75417 9.53111 5.60992 9.38588C5.46566 9.24062 5.38462 9.04365 5.38462 8.83824V7.2893C5.38462 7.0839 5.46566 6.88692 5.60992 6.74167C5.75417 6.59643 5.94983 6.51484 6.15385 6.51484C6.35785 6.51484 6.55351 6.59643 6.69777 6.74167C6.84204 6.88692 6.92309 7.0839 6.92309 7.2893V8.83824ZM10 1.86803C10.816 1.86803 11.5987 2.19441 12.1757 2.77537C12.7527 3.35635 13.0769 4.14428 13.0769 4.9659H6.92309C6.92309 4.14428 7.24726 3.35635 7.82428 2.77537C8.40132 2.19441 9.18396 1.86803 10 1.86803ZM14.6154 8.83824C14.6154 9.04365 14.5343 9.24062 14.3901 9.38588C14.2458 9.53111 14.0502 9.61271 13.8461 9.61271C13.6421 9.61271 13.4465 9.53111 13.3022 9.38588C13.158 9.24062 13.0769 9.04365 13.0769 8.83824V7.2893C13.0769 7.0839 13.158 6.88692 13.3022 6.74167C13.4465 6.59643 13.6421 6.51484 13.8461 6.51484C14.0502 6.51484 14.2458 6.59643 14.3901 6.74167C14.5343 6.88692 14.6154 7.0839 14.6154 7.2893V8.83824Z" fill="#20CCB4"></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_206_491">
                                                                    <rect width="20" height="20" fill="white"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                    </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>'; // Close col-lg-12 col-md-12
        }

        echo ' </section>'; // Close the last row

        // Add "View All" button
        echo '<a style="background: linear-gradient(90deg, #000000 0%, #000000 100%); border-radius:10px; color: white" href="spin.php?id=' . urlencode($categoryId) . '" class="btn btn-main btn-lg w-100 pill">
            View All
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
            </svg>
        </a>';
    }
    // Removed the else block that shows "No available product for this Category."
} else {
    echo '';
}
?>
 
 </div>
    </div>
</div>-->
 
  <br> 


<?php
// Ensure the database connection $link is established before this script

// Fetch one active product name, its category, and category ID
$sql = $link->prepare("
    SELECT p.name, p.category, c.id AS category_id
    FROM products p
    JOIN categories c ON p.category = c.name
    WHERE p.status = 'active' AND p.category = 'TOOLS' LIMIT 1
");
$sql->execute();
$result = $sql->get_result();
$categoryrow = $result->fetch_assoc();

if ($categoryrow) {
    $name = $categoryrow['name'];
    $category = $categoryrow['category'];
    $categoryId = $categoryrow['category_id']; // Fetch the category ID

    // Query to fetch products for the specified category, ordered by id descending
    $sql = $link->prepare("SELECT * FROM products WHERE category = ? AND status = 'active' ORDER BY id DESC");
    $sql->bind_param("s", $category);
    $sql->execute();
    $result = $sql->get_result();
    $numrow = $result->num_rows;

    if ($numrow > 0) {
        echo '<div class="row">
            <div class="col-12">
                <div class="catalog-item-wrapper mb-2">
                    <div class="d-grid gap-2 mb-2">
                        <strong>
                            <p style="font-size: 11px; background: linear-gradient(90deg, #f65365 0%, #f65365 100%); border-radius:10px; color: white" class="p-2">' . htmlspecialchars($category) . '</p>
                        </strong>
                    </div>
                </div>'; // Start a row

        // Initialize variables
        $uniqueProducts = [];
        $isFirstProduct = true;

        // Product listing
        while ($row = $result->fetch_assoc()) {
            $productName = $row['name'];
            $price = $row['price'];
            $id = $row['id'];
            $type = $row['type'];

            // Skip duplicate product names
            if (in_array($productName, $uniqueProducts)) {
                continue;
            }

            // Add product name to the uniqueProducts array
            $uniqueProducts[] = $productName;

            // Query to get the total quantity of a specific product within a category
            $quantityStmt = $link->prepare("SELECT COUNT(*) AS total FROM products WHERE category = ? AND name = ? AND status = 'active'");
            $quantityStmt->bind_param("ss", $category, $productName);
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
            echo '<div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="img/' . htmlspecialchars($imageSrc) . '" alt="img" class="wid-35 rounded-circle">
                                        </div>
                                        <div class="flex-grow-1 mx-3">
                                            <p class="mb-1">
                                                <a class="text-small text-dark" href="details.php?id=' . htmlspecialchars($id) . '" style="font-size: 12px;">
                                                    ' . htmlspecialchars($productName) . '
                                                </a>
                                            </p>
                                            <p class="mb-0 text-muted">
                                                <a class="text-white btn btn-dark btn-rounded btn-sm" style="font-size: 12px; font-weight: bolder"> Price: ₦' . number_format($price, 2) . '</a>
                                             | <a class="text-white btn btn-dark btn-rounded btn-sm"
                                 style="font-size: 12px; font-weight: bolder">' . htmlspecialchars($totalQuantity) . ' </a></p>
                                        </div>
                                        <div class="col-2">
                                            <div class="d-flex justify-content-center row">
                                                <div class="col-12">
                                                    <span class="text-small col-sm-12 badge bg-dark mb-1"></span>
                                                </div>
                                                <div class="col-12 d-flex justify-content-center">
                                                    <a href="details.php?id=' . htmlspecialchars($id) . '" style="font-size: 8px" class="btn btn-sm">
                                                        <svg width="22" height="22" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_206_491)">
                                                                <path d="M18.4615 4.9659H14.6154C14.6154 3.7335 14.1291 2.55156 13.2636 1.68011C12.398 0.808664 11.2241 0.319092 10 0.319092C8.77592 0.319092 7.60198 0.808664 6.73643 1.68011C5.87087 2.55156 5.38462 3.7335 5.38462 4.9659H1.53846C1.13044 4.9659 0.739123 5.12909 0.450604 5.41958C0.162087 5.71005 0 6.10403 0 6.51484V18.1319C0 18.5427 0.162087 18.9366 0.450604 19.2271C0.739123 19.5176 1.13044 19.6808 1.53846 19.6808H18.4615C18.8696 19.6808 19.2609 19.5176 19.5494 19.2271C19.8379 18.9366 20 18.5427 20 18.1319V6.51484C20 6.10403 19.8379 5.71005 19.5494 5.41958C19.2609 5.12909 18.8696 4.9659 18.4615 4.9659ZM6.92309 8.83824C6.92309 9.04365 6.84204 9.24062 6.69777 9.38588C6.55351 9.53111 6.35785 9.61271 6.15385 9.61271C5.94983 9.61271 5.75417 9.53111 5.60992 9.38588C5.46566 9.24062 5.38462 9.04365 5.38462 8.83824V7.2893C5.38462 7.0839 5.46566 6.88692 5.60992 6.74167C5.75417 6.59643 5.94983 6.51484 6.15385 6.51484C6.35785 6.51484 6.55351 6.59643 6.69777 6.74167C6.84204 6.88692 6.92309 7.0839 6.92309 7.2893V8.83824ZM10 1.86803C10.816 1.86803 11.5987 2.19441 12.1757 2.77537C12.7527 3.35635 13.0769 4.14428 13.0769 4.9659H6.92309C6.92309 4.14428 7.24726 3.35635 7.82428 2.77537C8.40132 2.19441 9.18396 1.86803 10 1.86803ZM14.6154 8.83824C14.6154 9.04365 14.5343 9.24062 14.3901 9.38588C14.2458 9.53111 14.0502 9.61271 13.8461 9.61271C13.6421 9.61271 13.4465 9.53111 13.3022 9.38588C13.158 9.24062 13.0769 9.04365 13.0769 8.83824V7.2893C13.0769 7.0839 13.158 6.88692 13.3022 6.74167C13.4465 6.59643 13.6421 6.51484 13.8461 6.51484C14.0502 6.51484 14.2458 6.59643 14.3901 6.74167C14.5343 6.88692 14.6154 7.0839 14.6154 7.2893V8.83824Z" fill="#20CCB4"></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_206_491">
                                                                    <rect width="20" height="20" fill="white"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                    </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>'; // Close col-lg-12 col-md-12
        }

        echo ' </section>'; // Close the last row

        // Add "View All" button
        echo '<a style="background: linear-gradient(90deg, #000000 0%, #000000 100%); border-radius:10px; color: white" href="spin.php?id=' . urlencode($categoryId) . '" class="btn btn-main btn-lg w-100 pill">
            View All
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
            </svg>
        </a>';
    }
    // Removed the else block that shows "No available product for this Category."
} else {
    echo '';
}
?>
 
 </div>
    </div>
</div>
 </div>
    </div>
</div>
  <br> 
<?php include "inc/footer2.php" ?>