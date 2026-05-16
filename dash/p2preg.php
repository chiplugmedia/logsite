<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/topup.php";

$response = getCategoriesAndProducts();

$ptitle="Product Details";

include "inc/header2.php" ?>





   <div class="pc-container">
    <div class="pc-content">
         <div><?php echo $genMsg?></div>
         
         
<?php
// Fetch product details for a given product ID
$productID = $_GET['id'] ?? null;

if ($productID) {
    // Get product details using the provided function
    $response = getProductDetails($productID);

    if (isset($response['status']) && $response['status'] === 'success') {
        if (!empty($response['product'])) {
            // If product details exist, display them
            $product = $response['product'][0]; // Assuming the product data is an array of one item
            $productPrice = $product['price'] ?? 0; // Default to 0 if price is missing
            $amountInStock = $product['amount'] ?? 0;

            // Convert the doubled price to the desired currency
$convertedAmount = convertCurrency(
    $productPrice, 
    isset($exchangeRates[$targetCountry]['USD']) ? $exchangeRates[$targetCountry]['USD'] : 1
);

// Add 2000 after the conversion
$convertedAmount += $sitetag;

            $categoryIcon = $category['icon'] ?? '/young/pricetag.png'; // Fallback to a default icon if not found
            ?>
            <div class="d-flex justify-content-center my-4">
                <img class="my-2" src="<?php echo htmlspecialchars($categoryIcon); ?>" width="100" height="100" alt="Category Icon">
            </div>

            <div class="dashboard-body__item my-2">
                <div class="detail-content">
                    <div class="flex-1">
                        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                        <div class="content-mota" style="font-size:13px; line-height:1.6; color:rgb(0,0,0); font-family:Roboto, sans-serif;">
                            <div><?php echo htmlspecialchars($product['description']); ?></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6 d-flex justify-content-start">
                        <h6><?php echo htmlspecialchars($currencySymbol) . number_format($convertedAmount, 2); ?>/Pcs</h6>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <button type="button" style="background: #d5d5d5; color: #ffffff;" class="btn text-dark btn-sm">
                            <?php echo htmlspecialchars($amountInStock); ?> Available in stock
                        </button>
                    </div>
                </div>
                <hr>
                
                <!-- Form for purchasing -->
                <form class="p-3" action="" method="POST">
                    <!-- Hidden input fields -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($productID); ?>">
                    <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amountInStock); ?>">
                    <input type="hidden" name="cost" value="<?php echo htmlspecialchars($convertedAmount); ?>">
                      <input type="hidden" name="purchaseapi" value="1">
                    <div class="row">
                        <div class="col-6">
                            <input type="number" name="quantity" style="width: 70px; text-align: center; border-radius: 10px;" id="quantity" class="input-quantity" value="1" min="1" max="<?php echo htmlspecialchars($amountInStock); ?>">
                        </div>
                        <div class="col-6 d-flex justify-content-end mb-4">
                            <button type="button" style="background: #20CCB4; color:#ffffff;" class="btn btn-main btn-sm w-70 pill" id="totalPriceButton">
                              <?php echo htmlspecialchars($currencySymbol); ?><span id="total"><?php echo number_format($convertedAmount, 2); ?></span>
                            </button>
                        </div>
                    </div>
                    <style>
  #social-links ul {
      list-style: none;
      display: flex;
      gap: 10px;
      padding: 0;
      margin: 0;
  }

  #social-links li {
      display: inline-block;
  }

  #social-links a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #f0f0f0;
      transition: background-color 0.3s ease, transform 0.3s ease;
  }

  #social-links a:hover {
      background-color: #f55366;
      transform: scale(1.2);
  }

  #social-links svg {
      width: 20px;
      height: 20px;
      fill: #555;
      transition: fill 0.3s ease;
  }

  #social-links a:hover svg {
      fill: #fff;
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
      const currentPageUrl = encodeURIComponent(window.location.href);
      const socialLinks = document.querySelectorAll("#social-links a");

      // Update dynamic URLs for sharing
      socialLinks.forEach(link => {
          const shareType = link.dataset.share;
          if (shareType === "facebook") {
              link.href = `https://www.facebook.com/sharer/sharer.php?u=${currentPageUrl}`;
          } else if (shareType === "whatsapp") {
              link.href = `https://wa.me/?text=Checkout+this+page:+${currentPageUrl}`;
          } else if (shareType === "telegram") {
              link.href = `https://t.me/share/url?url=${currentPageUrl}&text=Checkout+this+page!`;
          }

          // Open link in a new window
          link.addEventListener("click", function (event) {
              event.preventDefault();
              window.open(this.href, '_blank', 'noopener,noreferrer,width=600,height=400');
          });
      });
  });
</script>

<div class="col-12 mt-3">
   <h6 class="mb-3">Share product</h6>
   <div id="social-links">
       <ul>
           <li><a href="#" data-share="facebook" target="_blank" rel="noopener noreferrer">
               <!-- Facebook Icon -->
               <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="16" cy="16" r="14" fill="url(#paint0_linear_87_7208)"></circle> <path d="M21.2137 20.2816L21.8356 16.3301H17.9452V13.767C17.9452 12.6857 18.4877 11.6311 20.2302 11.6311H22V8.26699C22 8.26699 20.3945 8 18.8603 8C15.6548 8 13.5617 9.89294 13.5617 13.3184V16.3301H10V20.2816H13.5617V29.8345C14.2767 29.944 15.0082 30 15.7534 30C16.4986 30 17.2302 29.944 17.9452 29.8345V20.2816H21.2137Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_87_7208" x1="16" y1="2" x2="16" y2="29.917" gradientUnits="userSpaceOnUse"> <stop stop-color="#18ACFE"></stop> <stop offset="1" stop-color="#0163E0"></stop> </linearGradient> </defs> </g></svg>
           </a></li>
           <li><a href="#" data-share="whatsapp" target="_blank" rel="noopener noreferrer">
               <!-- WhatsApp Icon -->
              <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 31C23.732 31 30 24.732 30 17C30 9.26801 23.732 3 16 3C8.26801 3 2 9.26801 2 17C2 19.5109 2.661 21.8674 3.81847 23.905L2 31L9.31486 29.3038C11.3014 30.3854 13.5789 31 16 31ZM16 28.8462C22.5425 28.8462 27.8462 23.5425 27.8462 17C27.8462 10.4576 22.5425 5.15385 16 5.15385C9.45755 5.15385 4.15385 10.4576 4.15385 17C4.15385 19.5261 4.9445 21.8675 6.29184 23.7902L5.23077 27.7692L9.27993 26.7569C11.1894 28.0746 13.5046 28.8462 16 28.8462Z" fill="#BFC8D0"></path> <path d="M28 16C28 22.6274 22.6274 28 16 28C13.4722 28 11.1269 27.2184 9.19266 25.8837L5.09091 26.9091L6.16576 22.8784C4.80092 20.9307 4 18.5589 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16Z" fill="url(#paint0_linear_87_7264)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 18.5109 2.661 20.8674 3.81847 22.905L2 30L9.31486 28.3038C11.3014 29.3854 13.5789 30 16 30ZM16 27.8462C22.5425 27.8462 27.8462 22.5425 27.8462 16C27.8462 9.45755 22.5425 4.15385 16 4.15385C9.45755 4.15385 4.15385 9.45755 4.15385 16C4.15385 18.5261 4.9445 20.8675 6.29184 22.7902L5.23077 26.7692L9.27993 25.7569C11.1894 27.0746 13.5046 27.8462 16 27.8462Z" fill="white"></path> <path d="M12.5 9.49989C12.1672 8.83131 11.6565 8.8905 11.1407 8.8905C10.2188 8.8905 8.78125 9.99478 8.78125 12.05C8.78125 13.7343 9.52345 15.578 12.0244 18.3361C14.438 20.9979 17.6094 22.3748 20.2422 22.3279C22.875 22.2811 23.4167 20.0154 23.4167 19.2503C23.4167 18.9112 23.2062 18.742 23.0613 18.696C22.1641 18.2654 20.5093 17.4631 20.1328 17.3124C19.7563 17.1617 19.5597 17.3656 19.4375 17.4765C19.0961 17.8018 18.4193 18.7608 18.1875 18.9765C17.9558 19.1922 17.6103 19.083 17.4665 19.0015C16.9374 18.7892 15.5029 18.1511 14.3595 17.0426C12.9453 15.6718 12.8623 15.2001 12.5959 14.7803C12.3828 14.4444 12.5392 14.2384 12.6172 14.1483C12.9219 13.7968 13.3426 13.254 13.5313 12.9843C13.7199 12.7145 13.5702 12.305 13.4803 12.05C13.0938 10.953 12.7663 10.0347 12.5 9.49989Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_87_7264" x1="26.5" y1="7" x2="4" y2="28" gradientUnits="userSpaceOnUse"> <stop stop-color="#5BD066"></stop> <stop offset="1" stop-color="#27B43E"></stop> </linearGradient> </defs> </g></svg>
           </a></li>
           <li><a href="#" data-share="telegram" target="_blank" rel="noopener noreferrer">
               <!-- Telegram Icon -->
               <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="16" cy="16" r="14" fill="url(#paint0_linear_87_7225)"></circle> <path d="M22.9866 10.2088C23.1112 9.40332 22.3454 8.76755 21.6292 9.082L7.36482 15.3448C6.85123 15.5703 6.8888 16.3483 7.42147 16.5179L10.3631 17.4547C10.9246 17.6335 11.5325 17.541 12.0228 17.2023L18.655 12.6203C18.855 12.4821 19.073 12.7665 18.9021 12.9426L14.1281 17.8646C13.665 18.3421 13.7569 19.1512 14.314 19.5005L19.659 22.8523C20.2585 23.2282 21.0297 22.8506 21.1418 22.1261L22.9866 10.2088Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_87_7225" x1="16" y1="2" x2="16" y2="30" gradientUnits="userSpaceOnUse"> <stop stop-color="#37BBFE"></stop> <stop offset="1" stop-color="#007DBB"></stop> </linearGradient> </defs> </g></svg>
           </a></li>
       </ul>
   </div>
</div>

                    
                    <div class="card my-5">
                        <div class="card-body">
                            <div class="card-title mt-3 text-center">
                                <h6>Disclaimer</h6>
                            </div>
                            <div class="text-center">
                                <p>By purchasing any product, you agree that you are fully aware of these terms/conditions and agree to follow them! 👉🏽<a href="#" data-bs-toggle="modal" data-bs-target="#TermsModal">TERMS AND CONDITIONS</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="col-12 d-flex justify-content-end">
                        <button type="submit" style="background: #F65365; color: #ffffff;" class="btn btn-main btn-lg w-100 pill">Buy Now</button>
                    </div>
                </form>
                <hr>
                
            <script>
                // JavaScript to calculate total price dynamically based on quantity
                document.getElementById('quantity').addEventListener('input', function() {
                    let quantity = parseInt(this.value);
                    let pricePerUnit = <?php echo $convertedAmount; ?>;
                    let totalPrice = quantity * pricePerUnit;
                    document.getElementById('total').textContent = totalPrice.toFixed(2);
                });
            </script>
            <?php
        } else {
            echo "<p>No product found</p>";
        }
    } else {
        echo "<p>Failed to retrieve product details</p>";
    }
}
?>


  <?php include "inc/footer2.php" ?>