<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $ptitle ?> - <?php echo $sitename ?></title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo $sitename ?> Log store">
    <meta name="keywords" content="<?php echo $sitename ?>">
    <meta name="author" content="Chiplugmdia">
    
    <!-- Favicon -->
    <link rel="icon" href="/young/Pinatexlogs.svg" type="image/x-icon">
    
    <!-- Page specific CSS -->
    <link rel="stylesheet" href="/young/css/datepicker-bs5.min.css">
    <link rel="stylesheet" href="/young/sweet.css">
    <!-- Font Family -->
    <link rel="stylesheet" href="/young/css/inter.css" id="main-font-link">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="/young/css/tabler-icons.min.css">
    
    <!-- Feather Icons -->
    <link rel="stylesheet" href="/young/css/feather.css">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/young/css/fontawesome.css">
    
    <!-- Material Icons -->
    <link rel="stylesheet" href="/young/css/material.css">
    
    <!-- Template CSS Files -->
    <link rel="stylesheet" href="/young/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="/young/css/style-preset.css">

    <!-- jQuery and Bootstrap Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <!-- Inline CSS -->
    <style>
        .carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .carousel-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
        }

        .carousel-images a {
            flex: 0 0 100%;
            text-align: center;
        }

        .carousel-images img {
            width: 100%;
            height: auto;
        }

        .carousel-buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .carousel-buttons button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .carousel-buttons button:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css">
             <style>
   /* -------------------------
   VPN Section & Cards
--------------------------- */
.vpn-section { margin-bottom: 2rem; }

.vpn-section-header {
    background: linear-gradient(90deg, #00bf63 0%, #ffbd59 50%, #ffbd59 100%);
    border-radius: 0.5rem;
    padding: 0.75rem 1.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
    margin-bottom: 0.75rem;
}
.vpn-section-header h2 {
    font-weight: 700;
    font-size: 1.125rem;
    margin: 0;
    display: flex;
    color: #fff; 
    align-items: center;
    gap: 0.5rem;
}
.vpn-section-header a {
    background: #fff;
    color: #000;
    font-weight: 600;
    font-size: 0.75rem;
    padding: 0.375rem 0.875rem;
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    text-decoration: none;
    transition: all 0.3s ease;
}
.vpn-section-header a:hover {
    background: #f8fafc;
    transform: translateX(2px);
}

/* Cards */
.vpn-card {
    background: #fff;
    border: 1px solid #ffbd59;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 0.75rem;
    width: 100%;
    transition: all 0.2s ease;
    cursor: pointer;
}
.vpn-card:last-child { margin-bottom: 0; }

.vpn-card.in-stock:hover {
    border-color: #ffbd59;
    box-shadow: 0 4px 12px rgba(255, 189, 89, 0.3);
    transform: translateY(-2px);
}
.vpn-card.out-of-stock {
    border-color: #d1d5db;
    opacity: 0.8;
    cursor: not-allowed;
}
.vpn-card .card-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.vpn-card img {
    width: 64px;
    height: 64px;
    border-radius: 0.5rem;
    object-fit: cover;
    border: 1px solid #e5e7eb;
    flex-shrink: 0;
}
.vpn-card.out-of-stock img { filter: grayscale(50%); opacity: 0.7; }
.vpn-card .left-side-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}
.vpn-card .product-info { flex: 1; display: flex; flex-direction: column; justify-content: center; gap: 0.5rem; }
.vpn-card .product-name {
    font-size: 0.90rem;
    color: #1f2937;
    font-weight: 500;
    margin: 0;
    line-height: 1.3;
    white-space: normal;
    overflow-wrap: break-word;
    word-break: break-word;
}
.vpn-card.out-of-stock .product-name { color: #6b7280; }
.vpn-card .info-container { display: flex; align-items: center; gap: 0.75rem; }
.vpn-card .info-box {
    display: flex; flex-direction: column; align-items: center;
    background: #eff6ff; padding: 0.5rem 0.75rem; border-radius: 0.375rem;
    font-size: 0.75rem; min-width: 80px; flex-shrink: 0;
}
.vpn-card .info-box p { margin: 0; line-height: 1.2; }
.vpn-card .info-box p:first-child {
    font-weight: 500; color: #4b5563; font-size: 0.6875rem; text-transform: uppercase;
}
.vpn-card .info-box.price p:last-child { font-weight: 700; color: #111827; font-size: 0.875rem; }
.vpn-card.in-stock .info-box:not(.price) { background: #f0f9ff; }
.vpn-card.in-stock .info-box:not(.price) p:last-child { font-weight: 600; color: #0369a1; }
.vpn-card.out-of-stock .info-box:not(.price) { background: #f3f4f6; }
.vpn-card.out-of-stock .info-box:not(.price) p:last-child { font-weight: 600; color: #ef4444; }
.vpn-card.out-of-stock .info-box.price p:last-child { color: #9ca3af; text-decoration: line-through; }

/* Buy Button */
.buy-btn {
    background: linear-gradient(135deg, #00bf63 0%, #ffbd59 100%);
    color: #fff; font-size: 0.875rem; font-weight: 600; padding: 0.75rem 1.5rem;
    border-radius: 0.5rem; border: none; display: flex; align-items: center; gap: 0.5rem;
    transition: all 0.3s ease; white-space: nowrap; box-shadow: 0 2px 4px rgba(0, 191, 99, 0.2); flex-shrink: 0;
}
.buy-btn:hover { background: linear-gradient(135deg, #00a857 0%, #e6a84e 100%); transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0, 191, 99, 0.3); }
.buy-btn:active { transform: translateY(0); box-shadow: 0 1px 2px rgba(0, 191, 99, 0.2); }
.vpn-card.out-of-stock .buy-btn { background: linear-gradient(135deg, #9ca3af 0%, #d1d5db 100%); color: #6b7280; cursor: not-allowed; border: 1px solid #d1d5db; box-shadow: none; }
.vpn-card.out-of-stock .buy-btn:hover { transform: none; }

/* -------------------------
   Modal Popup
--------------------------- */
.modal-overlay {
    display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center;
}
.modal-overlay.active { display: flex; animation: fadeIn 0.3s ease; }
.modal-container {
    background: white; border-radius: 0.75rem; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: slideUp 0.3s ease; position: relative;
}
.modal-header { background: linear-gradient(90deg, #00bf63 0%, #ffbd59 50%, #ffbd59 100%); padding: 1.5rem 1.5rem 1rem; color: white; }
.modal-header h2 { font-size: 1.5rem; margin:0 0 0.25rem 0; color:#fff; }
.modal-header p { opacity:0.9; font-size:0.875rem; margin:0; }
.modal-close {
    position:absolute; top:1rem; right:1rem; background:rgba(255,255,255,0.2); border:none; color:white;
    width:2rem; height:2rem; border-radius:50%; display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:all 0.2s ease;
}
.modal-close:hover { background:rgba(255,255,255,0.3); transform:rotate(90deg); }
.modal-content { padding:1.5rem; }
.modal-content h3 { font-size:1.25rem; font-weight:700; margin:0 0 1rem 0; }
.modal-product-info { display:flex; gap:1rem; margin-bottom:1.5rem; }
.modal-product-image { width:5rem; height:5rem; border-radius:0.5rem; overflow:hidden; flex-shrink:0; background:#f3f4f6; border:1px solid #e5e7eb; }
.modal-product-image img { width:100%; height:100%; object-fit:cover; }
.modal-product-details h4 { font-size:0.95rem; font-weight:600; margin:0 0 0.5rem 0; line-height:1.4; color:#000; }
.modal-stock-info { display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; }
.modal-stock-label { color:#6b7280; }
.modal-stock-value { color:#000; font-weight:600; }
.modal-description { background:#f9fafb; border:1px solid #e5e7eb; border-radius:0.5rem; padding:1rem; margin-bottom:1.5rem; }
.modal-description-label { color:#374151; font-weight:600; font-size:0.875rem; margin:0 0 0.5rem 0; }
.modal-description-text { color:#6b7280; font-size:0.875rem; line-height:1.5; margin:0; }
.modal-quantity-section { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; }
.quantity-controls { display:flex; align-items:center; gap:0.75rem; }
.quantity-btn { width:3rem; height:3rem; border-radius:50%; border:2px solid #d1d5db; background:white; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.2s ease; }
.quantity-btn:hover { border-color:#00bf63; background: #00bf6361; }
.quantity-btn.disabled { opacity:0.5; cursor:not-allowed; }
.quantity-display { width:4rem; height:3rem; border-radius:0.5rem; background:#f3f4f6; border:1px solid #d1d5db; display:flex; align-items:center; justify-content:center; font-size:1.25rem; font-weight:600; color:#000; }
.modal-price-section { text-align:right; }
.modal-price-label { color:#6b7280; font-size:0.875rem; margin:0 0 0.25rem 0; }
.modal-price-value { color:#00bf63; font-size:1.5rem; font-weight:700; margin:0; }
.modal-purchase-btn { width:100%; height:3.5rem; background: linear-gradient(90deg, #00bf63 0%, #ffbd59 50%, #ffbd59 100%); color:white; border:none; border-radius:0.75rem; font-size:1.125rem; font-weight:600; display:flex; align-items:center; justify-content:center; gap:0.5rem; cursor:pointer; transition:all 0.3s ease; }
.modal-purchase-btn:hover { background: linear-gradient(90deg, #00bf63 0%, #ffbd59 50%, #ffbd59 100%);; transform:translateY(-2px); box-shadow:0 10px 25px #ffbd59; }
.modal-purchase-btn:disabled { background: linear-gradient(90deg,#9ca3af 0%,#6b7280 100%); cursor:not-allowed; transform:none; box-shadow:none; }

/* Animations */
@keyframes fadeIn { from{opacity:0;} to{opacity:1;} }
@keyframes slideUp { from{opacity:0; transform:translateY(20px);} to{opacity:1; transform:translateY(0);} }

/* -------------------------
   Responsive
--------------------------- */
@media (max-width: 640px) {
    /* Section Header */
    .vpn-section-header {
        padding: 0.5rem 1rem;
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
    
    .vpn-section-header h2 {
        font-size: 1rem;
        gap: 0.375rem;
    }
    
    .vpn-section-header a {
        font-size: 0.7rem;
        padding: 0.25rem 0.625rem;
        align-self: flex-end;
        margin-top: -1.75rem;
    }
    
    /* VPN Card Layout */
    .vpn-card {
        padding: 0.75rem;
    }
    
    .vpn-card img {
        width: 40px;
        height: 40px;
    }
    
    /* Show only 1 line (half) of product name */
    .vpn-card .product-name {
        font-size: 0.7rem;
        line-height: 1.2;
        max-height: 1.2em; /* Only show 1 line */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        margin-bottom: 0.25rem;
    }
    
    /* Info boxes - make them fit better */
    .vpn-card .info-container {
        gap: 0.375rem;
        flex-wrap: nowrap;
        width: 100%;
    }
    
    .vpn-card .info-box {
        min-width: 60px; /* Reduced width */
        padding: 0.25rem 0.375rem;
        font-size: 0.65rem;
        flex: 1;
    }
    
    .vpn-card .info-box p:first-child {
        font-size: 0.6rem;
        margin-bottom: 0.125rem;
    }
    
    .vpn-card .info-box.price p:last-child {
        font-size: 0.75rem;
        font-weight: 700;
    }
    
    .vpn-card .info-box p:last-child {
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    /* Product info container */
    .vpn-card .product-info {
        gap: 0.25rem;
        width: 100%;
    }
    
    /* Buy button scaling */
    .vpn-card button.buy-btn {
        font-size: 0.65rem;
        padding: 0.375rem 0.5rem;
        min-width: 70px;
    }
    
    .vpn-card button.buy-btn i {
        font-size: 9px;
    }
    
    /* Left side container */
    .vpn-card .left-side-container {
        gap: 0.5rem;
        flex: 1;
        min-width: 0; /* Allow text truncation */
    }
    
    /* Card content layout */
    .vpn-card .card-content {
        gap: 0.5rem;
        align-items: center;
    }
    
    /* Modal - Keep desktop structure but smaller */
    .modal-container {
        width: 90%;
        max-width: 400px;
        margin: 1rem auto;
        border-radius: 8px;
        padding: 0;
    }
    
    .modal-header {
        padding: 1rem 1rem 0.75rem;
    }
    
    .modal-header h2 {
        font-size: 1.25rem;
    }
    
    .modal-content {
        padding: 1rem;
    }
    
    .modal-content h3 {
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }
    
    /* Modal product info - keep side-by-side */
    .modal-product-info {
        flex-direction: row;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .modal-product-image {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
    }
    
    .modal-product-details h4 {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    
    .modal-stock-info {
        font-size: 0.8rem;
    }
    
    /* Quantity section */
    .modal-quantity-section {
        margin-bottom: 1rem;
    }
    
    .quantity-btn {
        width: 2.5rem;
        height: 2.5rem;
    }
    
    .quantity-display {
        width: 3rem;
        height: 2.5rem;
        font-size: 1rem;
    }
    
    /* Price section - keep on right */
    .modal-price-section {
        text-align: right;
        margin-top: 0;
    }
    
    .modal-price-value {
        font-size: 1.25rem;
    }
    
    /* Purchase button */
    .modal-purchase-btn { 
        height: 2.75rem;
        font-size: 0.9rem;
    }
    
    /* Close button */
    .modal-close {
        top: 0.5rem;
        right: 0.5rem;
        width: 28px;
        height: 28px;
        font-size: 1.1rem;
    }
    
    /* Description */
    .modal-description {
        padding: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .modal-description-label,
    .modal-description-text {
        font-size: 0.8rem;
    }
}
</style>

</head><!-- [Head] end --><!-- [Body] Start -->
<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
      data-pc-theme_contrast="" data-pc-theme="light"><!-- [ Pre-loader ] start -->
<div class="page-loader">
    <div class="bar"></div>
</div><!-- [ Pre-loader ] End --><!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">


        
                    <div class="navbar-content">
                        <div class="card pc-user-card">


                            <div class="card">
                                <div class="card-body">
                                 <a href="login.php"
   class="buy-btn"
   style="
       background: #fff;
       color: #000;
       border: 3px solid #00bf63; /* Set your desired border color */
       border-radius: 5px;      /* Optional: rounded corners */
       margin-bottom: 15px;     /* Set the bottom margin */
       padding: 10px 20px;      /* Optional: add padding for better look */
       text-decoration: none;   /* Optional: remove underline */
   ">
   Login
</a>



                                    <a href="signup.php" class="buy-btn">Register</a>
                                </div>


                            </div>

                        </div>

                    </div>

                            </div>
</nav><!-- [ Sidebar Menu ] end --><!-


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/themify-icons@0.1.2/css/themify-icons.css">

    <header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu Collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-menu"></use>
                            </svg>
                        </span>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-menu"></use>
                            </svg>
                        </span>
                    </a>
                </li>
                <li class="pc-h-item">
                   <img src="/young/Pinatexlogs.png" alt="logo" width="200" height="auto">
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block] end -->
   
            
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item">
                       <a href="login.php" class="btn btn-dark btn-sm" 
   style="background: #28bf62; color: #f2eb9b; border: 0;">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
        <path fill-rule="evenodd" d="M14 14s-1-4-6-4-6 4-6 4 1 0 6 0 6 0 6 0z"/>
    </svg>
</a>


                    </li>
                </ul>
            </div>

            </div>
</header>