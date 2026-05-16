<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
// require $_SERVER['DOCUMENT_ROOT']."$stream/includes/topup.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/topup.php";

// Call the function to get the list of services
$response = getCategoriesAndProducts();


$ptitle="Products";



include "inc/header2.php" ;

?>

 
<div class='pc-container'>
    <div class='pc-content'>
        <div class='dashboard-body__content'>
            <div class='dashboard-body__item-wrapper'>
            <div>
                    <div class="carousel my-3 mb-4">
                        <div class="carousel-images">
                             <a href="#"><img src="/young/imag/2.png" alt="Banner 1"></a>
                            <a href="#"><img src="/young/imag/3.png" alt="Banner 2"></a>
                            <a href="#"><img src="/young/imag/4.png" alt="Banner 3"></a>
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
                    
                   <div><?php echo $genMsg?></div>

<style>
 /* Container */
.custom-button-list {
    display: flex;
    flex-wrap: wrap; /* same on all screens */
    gap: 10px;
    padding: 0;
    margin-bottom: 20px;
    list-style: none;
}

/* Button Style */
.btn-category-home {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 999px;
    background: #f5f5f5;
    color: #333;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    white-space: nowrap;
}

/* Icon image */
.btn-category-home img {
    width: 20px;
    height: 20px;
    object-fit: contain;
}

/* Hover */
.btn-category-home:hover {
    background: #000;
    color: #fff;
    transform: translateY(-2px);
}

/* Active */
.btn-category-home.active {
    background: #000;
    color: #fff;
    border-color: #000;
}

.modal-cancel-btn {
    background: #FF0000;
    color: #fff;
    padding: 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    margin-bottom: 10px;
    width: 100%;
}

.modal-cancel-btn:hover {
    background: #bbb;
}
</style>

<div class="box1">
    <p class="p1">Need a website?</p>
    <button class="btn1" onclick="location.href='https://wa.me/2348132888447?text=Hello%20Am%20from%20pinatexlogs'">CLICK HERE</button>
</div>
<!-- CATEGORY MENU -->
<ul class="custom-button-list" id="home-categories-container">

<?php
$hasAnyStock = false;
if (!empty($response['categories'])) {
    foreach ($response['categories'] as $cat) {
        foreach ($cat['products'] as $p) {
            if (!empty($p['amount']) && (int)$p['amount'] > 0) {
                $hasAnyStock = true;
                break 2;
            }
        }
    }
}
if ($hasAnyStock): ?>
<li>
    <a class="btn-category-home active"
       href="javascript:void(0);"
       onclick="showCategory('all')"
       data-category-slug="all">
        <i class="fa-solid fa-cart-shopping"></i> All Products
    </a>
</li>
<?php endif; ?>

<?php
if (!empty($response['status']) && $response['status'] === 'success') {
    foreach ($response['categories'] as $category) {
        // Only show category if it has products in stock
        $hasStock = false;
        foreach ($category['products'] as $p) {
            if (!empty($p['amount']) && (int)$p['amount'] > 0) {
                $hasStock = true;
                break;
            }
        }
        if (!$hasStock) continue;

        $catName = htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8');
        $catSlug = strtolower(str_replace(' ', '-', trim($category['name'])));
        $catIcon = htmlspecialchars($category['icon'], ENT_QUOTES, 'UTF-8');
        ?>
<li>
    <a class="btn-category-home"
       href="javascript:void(0);"
       onclick="showCategory('<?php echo $catSlug; ?>')"
       data-category-slug="<?php echo $catSlug; ?>">
        <img src="<?php echo $catIcon; ?>" alt="<?php echo $catName; ?>" />
        <?php echo $catName; ?>
    </a>
</li>
<?php
    }
}
?>
</ul>

<?php
// Admin prices
$adminPrices = [];
$sql = $link->prepare("SELECT product_id, override_price FROM adminprices");
$sql->execute();
$result = $sql->get_result();
while ($row = $result->fetch_assoc()) {
    $adminPrices[$row['product_id']] = $row['override_price'];
}

// Currency conversion
$usdToNairaRate = is_numeric($sitetag) ? $sitetag : 1;
$currencySymbol = "₦";
?>

<?php
if (!empty($response['status']) && $response['status'] === 'success') {
    foreach ($response['categories'] as $category) {
        // Only products in stock
        $products = array_filter($category['products'], function($p) {
            return !empty($p['amount']) && (int)$p['amount'] > 0;
        });
        if (empty($products)) continue;

        $catSlug = strtolower(str_replace(' ', '-', trim($category['name'])));
?>
<section class="vpn-section" data-category="<?php echo $catSlug; ?>">
    <div class="vpn-section-header">
        <h2><?php echo htmlspecialchars($category['name']); ?></h2>
    </div>

    <div class="vpn-products">
        <?php foreach ($products as $product): 
            $productID = $product['id'] ?? null;
            $apiPrice = $product['price'] ?? 0;
            $stock = (int)$product['amount'];
            $isInStock = $stock > 0;

            // Admin override price
            $finalPriceUSD = ($productID && isset($adminPrices[$productID]) && $adminPrices[$productID] !== null)
                ? (float)$adminPrices[$productID]
                : (float)$apiPrice;

            $convertedAmount = $finalPriceUSD * $usdToNairaRate;
            $formattedPrice = $currencySymbol . rtrim(rtrim(sprintf('%.2f', $convertedAmount), '0'), '.');

            $productData = json_encode([
                'id' => $productID,
                'name' => $product['name'],
                'image' => $product['image'] ?? $category['icon'],
                'price' => $convertedAmount,
                'currency' => $currencySymbol,
                'stock' => $stock,
                'description' => $product['description'] ?? 'No description.'
            ], JSON_HEX_APOS | JSON_HEX_QUOT);
        ?>
        <div class="vpn-card <?php echo $isInStock ? 'in-stock' : 'out-of-stock'; ?>" 
             <?php if($isInStock) echo "data-product='$productData'"; ?>>
            <div class="card-content">
                <div class="left-side-container">
                    <img src="<?php echo htmlspecialchars($product['image'] ?? $category['icon']); ?>" alt="">
                    <div class="product-info">
                        <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                        <div class="info-container">
                            <div class="info-box"><p>Stock</p><p><?php echo $stock; ?></p></div>
                            <div class="info-box price"><p>Price</p><p><?php echo $formattedPrice; ?></p></div>
                        </div>
                    </div>
                </div>
                <button class="buy-btn" <?php echo $isInStock ? "" : "disabled"; ?>>
                    <i class="fas <?php echo $isInStock ? 'fa-shopping-cart' : 'fa-ban'; ?>"></i> Purchase
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php
    }
}
?>

<script>
// CATEGORY FILTER
function showCategory(slug) {
    document.querySelectorAll('.btn-category-home').forEach(btn => btn.classList.remove('active'));
    const activeBtn = document.querySelector(`[data-category-slug="${slug}"]`);
    if (activeBtn) activeBtn.classList.add('active');

    document.querySelectorAll('.vpn-section').forEach(section => {
        if (slug === 'all' || section.dataset.category === slug) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
}

// Initialize: show all
showCategory('all');
</script>

<!-- ————————————————————————————————
     🔎 PRODUCT MODAL
——————————————————————————————— -->
<div class="modal-overlay" id="productModal">
    <div class="modal-container">
        <button class="modal-close" id="closeModal">&times;</button>

        <div class="modal-header"><h2>Buy Product</h2></div>
        <div class="modal-content">
            <div class="modal-product-info">
                <div class="modal-product-image">
                    <img id="modalProductImage" src="" alt="">
                </div>
                <div class="modal-product-details">
                    <h4 id="modalProductName"></h4>
                    <div class="modal-stock-info">
                        <span class="modal-stock-label">Stock:</span>
                        <span class="modal-stock-value" id="modalProductStock"></span>
                    </div>
                </div>
            </div>

            <div class="modal-description">
                <p class="modal-description-label">Product Description:</p>
                <p class="modal-description-text" id="modalProductDescription"></p>
            </div>

            <div class="modal-quantity-section">
                <div class="quantity-controls">
                    <button class="quantity-btn" id="decreaseQuantity">-</button>
                    <div class="quantity-display" id="quantityDisplay">1</div>
                    <button class="quantity-btn" id="increaseQuantity">+</button>
                </div>
                <div class="modal-price-section">
                    <p class="modal-price-label">Total Price</p>
                    <p class="modal-price-value" id="modalProductPrice"></p>
                </div>
            </div>

            <form action="" method="POST" id="purchaseForm">
    <input type="hidden" name="purchaseapi" value="1">
    <input type="hidden" name="id" id="modalProductID" value="">
    <input type="hidden" name="quantity" id="modalProductQuantity" value="1">
    <input type="hidden" name="cost" id="modalProductCostInput" value="">

    <button type="button" class="modal-cancel-btn" id="cancelPurchase">
        <i class="fas fa-times"></i> CANCEL
    </button>

    <button type="submit" class="modal-purchase-btn">
        <i class="fas fa-shopping-bag"></i> PROCEED TO PURCHASE
    </button>
</form>

        </div>
    </div>
</div>

<script>
// ————————————————————————————————
// JS: MODAL + QUANTITY + SEARCH
// ————————————————————————————————
let currentQuantity = 1;
let currentProductData = null;

// Open modal
document.querySelectorAll('.vpn-card.in-stock').forEach(card => {
    card.addEventListener('click', function(){
        const productData = JSON.parse(card.dataset.product);
        openProductModal(productData);
    });
});

function openProductModal(productData) {
    currentProductData = productData;
    currentQuantity = 1;

    document.getElementById("modalProductImage").src = productData.image;
    document.getElementById("modalProductName").textContent = productData.name;
    document.getElementById("modalProductStock").textContent = productData.stock;
    document.getElementById("modalProductDescription").textContent = productData.description || "No description available.";
    document.getElementById("quantityDisplay").textContent = currentQuantity;

    document.getElementById('modalProductID').value = productData.id;
    document.getElementById('modalProductQuantity').value = currentQuantity;
    document.getElementById('modalProductCostInput').value = productData.price;

    updateQuantityControls();

    document.getElementById("productModal").classList.add("active");
    document.body.style.overflow = 'hidden';
    document.getElementById('cancelPurchase').addEventListener('click', () => {
    closeModal();
});

}

function updatePriceDisplay() {
    if (!currentProductData) return;
    const total = parseFloat(currentProductData.price) * currentQuantity;
    const formatted = currentProductData.currency + rtrim(total.toFixed(12));
    document.getElementById("modalProductPrice").textContent = formatted;
    document.getElementById('modalProductQuantity').value = currentQuantity;
}

// Helper to trim trailing zeros & dot
function rtrim(numberStr) {
    return numberStr.replace(/(\.\d*?[1-9])0+$/,'$1').replace(/\.0+$/,'');
}

function updateQuantityControls() {
    const stock = currentProductData?.stock || 0;
    document.getElementById('decreaseQuantity').disabled = currentQuantity <= 1;
    document.getElementById('increaseQuantity').disabled = currentQuantity >= stock;
    updatePriceDisplay();
}

document.getElementById('decreaseQuantity').addEventListener('click', ()=>{
    if(currentQuantity>1){currentQuantity--; document.getElementById('quantityDisplay').textContent=currentQuantity; updateQuantityControls();}
});
document.getElementById('increaseQuantity').addEventListener('click', ()=>{
    if(currentQuantity<currentProductData.stock){currentQuantity++; document.getElementById('quantityDisplay').textContent=currentQuantity; updateQuantityControls();}
});

function closeModal() {
    document.getElementById('productModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    currentProductData=null;
    currentQuantity=1;
}

document.getElementById('closeModal').addEventListener('click', closeModal);
document.getElementById('productModal').addEventListener('click', e=>{if(e.target===this) closeModal();});
document.addEventListener('keydown', e=>{if(e.key==='Escape') closeModal();});

// Form validation
document.getElementById('purchaseForm').addEventListener('submit', function(e){
    const quantity = parseInt(document.getElementById('modalProductQuantity').value);
    const stock = parseInt(document.getElementById('modalProductStock').textContent);

    if(quantity<1){e.preventDefault(); alert('Quantity must be at least 1'); return false;}
    if(quantity>stock){e.preventDefault(); alert('Quantity exceeds available stock'); return false;}

    const submitBtn = this.querySelector('.modal-purchase-btn');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    submitBtn.disabled = true;
});

// Popular tags
document.querySelectorAll(".popular-btn").forEach(btn=>{
    btn.addEventListener("click", ()=> {
        document.getElementById("searchInput").value = btn.textContent.trim();
        document.getElementById("searchForm").submit();
    });
});

// Enter submits search
document.getElementById("searchInput").addEventListener("keydown", (e)=>{
    if(e.key==="Enter"){e.preventDefault(); document.getElementById("searchForm").submit();}
});
</script>



<style>



/* POPUP OVERLAY */
.popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.65);
    display: flex; /* Automatically visible */
    justify-content: center;
    align-items: center;
    z-index: 99999;
}

/* POPUP BOX */
.popup-box {
    background: #fff;
    width: 90%;
    max-width: 700px;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    overflow-y: auto;
    max-height: 85vh;
    position: relative;
    animation: popupFadeIn .5s ease;
    font-family: "Poppins", sans-serif;
}

/* CLOSE BUTTON */
.close-popup {
    position: absolute;
    top: 15px;
    right: 18px;
    font-size: 35px;
    color: #444;
    cursor: pointer;
    transition: .2s;
}
.close-popup:hover {
    color: #000;
}

/* TITLES */
.popup-title {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
    color: #d60000;
}

.popup-subtitle {
    font-size: 1.3rem;
    margin-top: 1.8rem;
    margin-bottom: .5rem;
    font-weight: 600;
}

/* TEXT */
.popup-text {
    font-size: 1rem;
    line-height: 1.7;
    margin-bottom: 1rem;
}

/* LIST */
.popup-list {
    margin-left: 1.2rem;
    margin-bottom: 1rem;
}
.popup-list li {
    margin-bottom: .5rem;
}

/* LINKS */
.popup-link {
    display: block;
    margin: .5rem 0;
    font-weight: 600;
    color: #0078ff;
    text-decoration: underline;
}

/* ANIMATION */
@keyframes popupFadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>


<?php
// Ensure the database connection $link is established before this script

// Fetch one active product name, its category, and category ID
$sql = $link->prepare("
    SELECT p.name, p.category, c.id AS category_id
    FROM products p
    JOIN categories c ON p.category = c.name
    WHERE p.status = 'active' AND p.category = 'TOOLS'
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
                        <div class="vpn-section-header">
                            <h2>' . htmlspecialchars($category) . '</h2>
                        </div>
                    </div>
                </div>';

        // Initialize variables
        $uniqueProducts = [];

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
            $quantityStmt->close();

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
            
            echo '
            <div class="vpn-card">
                <div class="card-content">
                    <div class="left-side-container">
                        <img src="img/' . htmlspecialchars($imageSrc) . '" alt="' . htmlspecialchars($productName) . '">
                        <div class="product-info">
                            <div class="product-name">' . htmlspecialchars($productName) . '</div>
                            <div class="info-container">
                                <div class="info-box"><p>Stock</p><p>' . htmlspecialchars($totalQuantity) . '</p></div>
                                <div class="info-box price"><p>Price</p><p>₦' . number_format($price, 2) . '</p></div>
                            </div>
                        </div>
                    </div>
                    
                    <div >
                        <a href="details.php?id=' . htmlspecialchars($id) . '" class="buy-btn">
                            <i class="fas fa-shopping-cart"></i> Purchase
                        </a>
                    </div>
                </div>
            </div>';
        }
        
        echo '</div>'; // Close the row div
    }
    
    $sql->close();
}
?>
 </div>
                                        </div>
                                        
                                        
                                        
<div id="popup-overlay" class="popup-overlay">
    <div class="popup-box">
        <span class="close-popup">&times;</span>

        <h2 class="popup-title">DISCLAIMER</h2>
        <p class="popup-text">
            We do not guarantee secondary sales and accounts sold here are not to be used for illegal activities, 
            we are not responsible for any problems caused by misuse.<br><br>
            Please note that accounts on the website delete after 30 days. We will not be responsible for 
            lost account information.
        </p>

    
        <h3 class="popup-subtitle">RULES AND REGULATIONS</h3>
        <ul class="popup-list">
            <li>We do NOT teach how to use accounts — we only sell to experts.</li>
            <li>Test a few accounts before buying bulk.</li>
            <li>No warranty for accounts that get suspended/disabled after purchase.</li>
            <li>Website warranty is 2 weeks only — no support after warranty expires.</li>
        </ul>

        <h3 class="popup-subtitle">HOW TO REPORT A PROBLEM:</h3>
        <ul class="popup-list">
            <li>Send login details and transaction ID.</li>
            <li>Send video evidence of the problem.</li>
            <li>Describe the problem clearly to the admin.</li>
        </ul>

        <p class="popup-text">
            Use <strong>https://mbasic.facebook.com/</strong> to log in Facebook or use the app.<br>
            Use <strong>https://lay2fa.com/</strong> to get Facebook login codes.<br><br>
            Spam countries require high‑quality IP for Facebook login.<br><br>

            Instagram requires email confirmation — use <strong>mail.ru, hotmail.com, gmail.com</strong> and correct IP.<br><br>

            Accounts with issues are responsible for replacement — terms and conditions apply.
        </p>
 
        <a href="https://t.me/+z08Q3Sw7n2ZiMGE0" class="popup-link">Telegram Community Support</a>
    </div>
</div>

<script>
// Close Popup
document.querySelector(".close-popup").addEventListener("click", function () {
    document.getElementById("popup-overlay").style.display = "none";
});

// Optional: Close when clicking outside the popup
document.getElementById("popup-overlay").addEventListener("click", function (e) {
    if (e.target === this) {
        this.style.display = "none";
    }
});
</script>


<?php include "inc/footer2.php" ?>