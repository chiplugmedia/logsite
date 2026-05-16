<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/actions/currency_rates.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/topup.php";

// Call the function to get the list of services
$response = getCategoriesAndProducts();

$ptitle="Products";

$genMsg="";


include "includes/authhead.php" ;

?>
<!-- Modal -->
        
      
      
           <div><?php echo $genMsg?></div>
           

   <div class="pc-container">
    <div class="pc-content">
        <div class="dashboard-body__content">
            <div class="dashboard-body__item-wrapper">
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
 <!-- CATEGORY MENU -->
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

<!-- PRODUCTS -->
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
                <a href="login.php">See More <i class="fas fa-arrow-right" style="font-size: 10px;"></i></a>
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
                        'name' => $product['name'],
                        'image' => $product['image'] ?? $category['icon'],
                        'price' => $convertedAmount,
                        'currency' => $currencySymbol,
                        'stock' => $stock,
                        'description' => $product['description'] ?? 'No description.'
                    ], JSON_HEX_APOS | JSON_HEX_QUOT);
                ?>
                    <div class="vpn-card <?php echo $isInStock ? 'in-stock' : 'out-of-stock'; ?>"
                         <?php if ($isInStock): ?>
                             data-product='<?php echo $productData; ?>'
                             onclick="openProductModal(JSON.parse(this.dataset.product))"
                         <?php endif; ?>>
                        <div class="card-content">
                            <div class="left-side-container">
                                <img src="<?php echo htmlspecialchars($product['image'] ?? $category['icon']); ?>" alt="">
                                <div class="product-info">
                                    <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                                    <div class="info-container">
                                        <div class="info-box">
                                            <p>Stock</p>
                                            <p><?php echo $stock; ?></p>
                                        </div>
                                        <div class="info-box price">
                                            <p>Price</p>
                                            <p><?php echo $formattedPrice; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($isInStock): ?>
                                <button class="buy-btn"
                                    onclick="event.stopPropagation(); openProductModal(JSON.parse(this.closest('.vpn-card').dataset.product));">
                                    <i class="fas fa-shopping-cart"></i> Purchase
                                </button>
                            <?php else: ?>
                                <button class="buy-btn" disabled>
                                    <i class="fas fa-ban"></i> Out of Stock
                                </button>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
<?php
    }
}
?>

<!-- MODAL -->
<div class="modal-overlay" id="productModal">
    <div class="modal-container">
        <button class="modal-close" id="closeModal">&times;</button>
        <div class="modal-header">
            <h2>Buy Product</h2>
        </div>
        <div class="modal-content">
            <h3>Order Details</h3>
            <div class="modal-product-info">
                <div class="modal-product-image"><img id="modalProductImage" src="" alt=""></div>
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
            <button type="button" class="modal-cancel-btn" id="cancelPurchase">
                <i class="fas fa-times"></i> CANCEL
            </button>
            <a class="modal-purchase-btn" href="login.php">
                <i class="fas fa-shopping-bag"></i> PROCEED TO PURCHASE
            </a>
        </div>
    </div>
</div>

<!-- JS -->
<script>
let currentQuantity = 1;
let currentProductData = null;

/* CATEGORY FILTER */
function showCategory(slug) {
    document.querySelectorAll('.btn-category-home').forEach(btn => btn.classList.remove('active'));
    const activeBtn = document.querySelector(`[data-category-slug="${slug}"]`);
    if (activeBtn) activeBtn.classList.add('active');

    document.querySelectorAll('.vpn-section').forEach(section => {
        const cat = section.getAttribute('data-category');
        section.style.display = (slug === 'all' || cat === slug) ? 'block' : 'none';
    });
}

/* MODAL */
function openProductModal(product) {
    currentProductData = product;
    currentQuantity = 1;

    document.getElementById('quantityDisplay').textContent = 1;
    document.getElementById('modalProductImage').src = product.image;
    document.getElementById('modalProductName').textContent = product.name;
    document.getElementById('modalProductStock').textContent = product.stock;
    document.getElementById('modalProductDescription').textContent = product.description;

    updatePrice();
    document.getElementById('productModal').classList.add('active');
}

function updatePrice() {
    const total = Number(currentProductData.price) * currentQuantity;
    document.getElementById('modalProductPrice').textContent =
        currentProductData.currency + total.toFixed(2);
}

document.getElementById('increaseQuantity').onclick = () => {
    if (currentQuantity < currentProductData.stock) {
        currentQuantity++;
        document.getElementById('quantityDisplay').textContent = currentQuantity;
        updatePrice();
    }
};

document.getElementById('decreaseQuantity').onclick = () => {
    if (currentQuantity > 1) {
        currentQuantity--;
        document.getElementById('quantityDisplay').textContent = currentQuantity;
        updatePrice();
    }
};

document.getElementById('closeModal').onclick = closeModal;
document.getElementById('cancelPurchase').onclick = closeModal;

function closeModal() {
    document.getElementById('productModal').classList.remove('active');
}
</script>
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
            $description = $row['description'] ?? 'No description available.';

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
            
            // Prepare product data for JavaScript
            $productData = [
                'name' => $productName,
                'price' => $price,
                'stock' => $totalQuantity,
                'description' => $description,
                'image' => '/dash/img/' . $imageSrc,
                'currency' => '₦'
            ];
            $productDataJson = htmlspecialchars(json_encode($productData), ENT_QUOTES, 'UTF-8');
            
            echo '
            <div class="vpn-card" onclick="openProductModal(' . $productDataJson . ')" style="cursor: pointer;">
                <div class="card-content">
                    <div class="left-side-container">
                        <img src="/dash/img/' . htmlspecialchars($imageSrc) . '" alt="' . htmlspecialchars($productName) . '">
                        <div class="product-info">
                            <div class="product-name">' . htmlspecialchars($productName) . '</div>
                            <div class="info-container">
                                <div class="info-box"><p>Stock</p><p>' . htmlspecialchars($totalQuantity) . '</p></div>
                                <div class="info-box price"><p>Price</p><p>₦' . number_format($price, 2) . '</p></div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <a href="javascript:void(0);" class="buy-btn" onclick="event.stopPropagation(); openProductModal(' . $productDataJson . ');">
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

<!-- Modal HTML -->
<div class="modal-overlay" id="productModal">
    <div class="modal-container">
        <button class="modal-close" id="closeModal">&times;</button>
        <div class="modal-header">
            <h2>Buy Product</h2>
        </div>
        <div class="modal-content">
            <h3>Order Details</h3>
            <div class="modal-product-info">
                <div class="modal-product-image"><img id="modalProductImage" src="" alt=""></div>
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
            <div class="modal-actions">
                <button type="button" class="modal-cancel-btn" id="cancelPurchase">
                    <i class="fas fa-times"></i> CANCEL
                </button>
                <a class="modal-purchase-btn" href="login.php">
                    <i class="fas fa-shopping-bag"></i> PROCEED TO PURCHASE
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let currentQuantity = 1;
let currentProductData = null;

function openProductModal(productData) {
    currentProductData = productData;
    currentQuantity = 1;
    document.getElementById('quantityDisplay').textContent = currentQuantity;
    document.getElementById('modalProductImage').src = productData.image;
    document.getElementById('modalProductImage').alt = productData.name;
    document.getElementById('modalProductName').textContent = productData.name;
    document.getElementById('modalProductStock').textContent = productData.stock;
    document.getElementById('modalProductDescription').textContent = productData.description || 'No description available.';

    const totalPrice = productData.price * currentQuantity;
    document.getElementById('modalProductPrice').textContent = productData.currency + totalPrice.toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2});

    document.getElementById('productModal').classList.add('active');
    document.body.style.overflow = 'hidden';
    updateQuantityControls();
}

function updateQuantityControls() {
    const decreaseBtn = document.getElementById('decreaseQuantity');
    const increaseBtn = document.getElementById('increaseQuantity');
    const stock = currentProductData?.stock || 0;
    decreaseBtn.disabled = currentQuantity <= 1;
    increaseBtn.disabled = currentQuantity >= stock;
    if (currentProductData) {
        const totalPrice = currentProductData.price * currentQuantity;
        const formattedPrice = currentProductData.currency + totalPrice.toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2});
        document.getElementById('modalProductPrice').textContent = formattedPrice;
    }
}

function closeModal() {
    document.getElementById('productModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    document.getElementById('decreaseQuantity').addEventListener('click', function(e) {
        e.stopPropagation();
        if (currentQuantity > 1) { 
            currentQuantity--; 
            document.getElementById('quantityDisplay').textContent = currentQuantity; 
            updateQuantityControls(); 
        }
    });
    
    document.getElementById('increaseQuantity').addEventListener('click', function(e) {
        e.stopPropagation();
        if (currentQuantity < currentProductData?.stock) { 
            currentQuantity++; 
            document.getElementById('quantityDisplay').textContent = currentQuantity; 
            updateQuantityControls(); 
        }
    });
    
    // Cancel button
    document.getElementById('cancelPurchase').addEventListener('click', function(e) {
        e.stopPropagation();
        closeModal();
    });
    
    // Close button
    document.getElementById('closeModal').addEventListener('click', function(e) {
        e.stopPropagation();
        closeModal();
    });
    
    // Close modal when clicking overlay
    document.getElementById('productModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
    
    // Prevent clicks inside modal from closing it
    document.querySelector('.modal-container').addEventListener('click', function(e) {
        e.stopPropagation();
    });
});

// Popular tag buttons submit search
document.querySelectorAll(".popular-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        document.getElementById("searchInput").value = btn.textContent.trim();
        document.getElementById("searchForm").submit();
    });
});

// Pressing Enter submits search
document.getElementById("searchInput")?.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("searchForm").submit();
    }
});
</script>
 </div>
                                        </div>
  <br> 
<?php include "includes/authfoot.php" ?>