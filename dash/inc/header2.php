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
    <meta name="author" content="Phoenixcoded">
    
    <!-- Favicon -->
    <link rel="icon" href="/young/Pinatexlogs.svg" type="image/x-icon">
    
    <!-- Page specific CSS -->
    <link rel="stylesheet" href="/young/css/datepicker-bs5.min.css">
    
    <!-- Font Family -->
    <link rel="stylesheet" href="/young/css/inter.css" id="main-font-link">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="/young/css/tabler-icons.min.css">
    
    <!-- Feather Icons -->
    <link rel="stylesheet" href="/young/css/feather.css">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/young/css/fontawesome.css">
    <link rel="stylesheet" href="/young/sweet.css">
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


</head><!-- [Head] end --><!-- [Body] Start -->

<!-- Snowflake Animation -->
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

<style>


    /* Main wrapper */
.search-box {
    margin-bottom: 24px;
}

/* Card */
.search-card {
    background: #fff;
    padding: 16px;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}

/* Input wrapper */
.search-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

/* Search icon */
.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 16px;
}

/* Input field */
.search-input {
    width: 100%;
    padding: 14px 16px 14px 46px;
    font-size: 15px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    outline: none;
    transition: border-color .25s ease;
}

.search-input:focus {
    border-color: #28bf62;
}

/* Popular Tags */
.popular-tags {
    margin-top: 16px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}

.popular-label {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
}

/* Tag buttons */
.tag-btn {
    padding: 6px 14px;
    font-size: 13px;
    background: #f3f4f6;
    color: #6b7280;
    border: none;
    border-radius: 999px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.2s;
}

.tag-btn:hover {
    background: #5bef441a;
    color: #28bf62;
}

/* -------------------------
   📱 MOBILE VIEW OPTIMIZED
--------------------------*/
@media (max-width: 640px) {

    .search-card {
        padding: 14px;
        border-radius: 12px;
    }

    .search-input {
        padding: 13px 14px 13px 44px;
        font-size: 14px;
        border-radius: 10px;
    }

    .search-icon {
        font-size: 14px;
        left: 14px;
    }

    .popular-tags {
        gap: 6px;
    }

    .popular-label {
        font-size: 12px;
    }

    .tag-btn {
        padding: 5px 12px;
        font-size: 12px;
        border-radius: 999px;
    }
}
  #snowflakeContainer {
    position: absolute;
    left: 0px;
    top: 0px;
    display: none;
  }

  .snowflake {
    position: fixed;
    background-color: #A020F0;
    user-select: none;
    z-index: 1000;
    pointer-events: none;
    border-radius: 50%;
    width: 10px;
    height: 10px;
  }
</style>



<style>

    /* Main wrapper */
.search-box {
    margin-bottom: 24px;
}

/* Card */
.search-card {
    background: #fff;
    padding: 16px;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}

/* Input wrapper */
.search-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

/* Search icon */
.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 16px;
}

/* Input field */
.search-input {
    width: 100%;
    padding: 14px 16px 14px 46px;
    font-size: 15px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    outline: none;
    transition: border-color .25s ease;
}

.search-input:focus {
    border-color: #28bf62;
}

/* Popular Tags */
.popular-tags {
    margin-top: 16px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}

.popular-label {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
}

/* Tag buttons */
.tag-btn {
    padding: 6px 14px;
    font-size: 13px;
    background: #f3f4f6;
    color: #6b7280;
    border: none;
    border-radius: 999px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.2s;
}

.tag-btn:hover {
    background: #5bef441a;
    color: #28bf62;
}

/* -------------------------
   📱 MOBILE VIEW OPTIMIZED
--------------------------*/
@media (max-width: 640px) {

    .search-card {
        padding: 14px;
        border-radius: 12px;
    }

    .search-input {
        padding: 13px 14px 13px 44px;
        font-size: 14px;
        border-radius: 10px;
    }

    .search-icon {
        font-size: 14px;
        left: 14px;
    }

    .popular-tags {
        gap: 6px;
    }

    .popular-label {
        font-size: 12px;
    }

    .tag-btn {
        padding: 5px 12px;
        font-size: 12px;
        border-radius: 999px;
    }
}

  .snowflake {
    color: white;
    font-size: 1em;
    font-family: Arial, sans-serif;
    text-shadow: 0 0 0px #000;
  }

  @-webkit-keyframes snowflakes-fall {
    0% { top: -10%; }
    100% { top: 100%; }
  }

  @-webkit-keyframes snowflakes-shake {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(80px); }
  }

  @keyframes snowflakes-fall {
    0% { top: -10%; }
    100% { top: 100%; }
  }

  @keyframes snowflakes-shake {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(80px); }
  }

  .snowflake {
    position: fixed;
    top: -10%;
    z-index: 9999;
    user-select: none;
    cursor: default;
    animation-name: snowflakes-fall, snowflakes-shake;
    animation-duration: 10s, 3s;
    animation-timing-function: linear, ease-in-out;
    animation-iteration-count: infinite;
    animation-play-state: running;
  }

  /* Customize each snowflake's starting point and animation delays */
  .snowflake:nth-of-type(1) { left: 10%; animation-delay: 1s, 1s; }
  .snowflake:nth-of-type(2) { left: 20%; animation-delay: 6s, .5s; }
  /* Add more rules as needed */
  
  .box1 {
    display: flex;
    align-items: center;
    gap: 10px;

    background: #19bf64;
    padding: 10px 14px;
    border-radius: 10px;

    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
    color: #fff;

    max-width: 420px;
    margin: 15px auto;
}

.box1 .p1 {
    font-size: 14px;
    font-weight: 500;
    margin: 0;
    flex: 1;
}

.box1 img {
    width: 35px;
    height: auto;
}

.btn1 {
    background-color: #fff;
    color: #fb7502;
    border: none;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s ease;
}

.btn1:hover {
    background-color: #222;
    color: #fff;
}

/* Mobile fine-tune */
@media (max-width: 480px) {
    .box1 {
        max-width: 100%;
        padding: 8px 12px;
    }

    .box1 .p1 {
        font-size: 13px;
    }

    .btn1 {
        padding: 5px 10px;
        font-size: 11px;
    }
}

</style>



<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
      data-pc-theme_contrast="" data-pc-theme="light"><!-- [ Pre-loader ] start -->
<div class="page-loader">
    <div class="bar"></div>
</div><!-- [ Pre-loader ] End --><!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">


                    <div class="navbar-content">
                <div class="card pc-user-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                  <?php if ($profileImg == "no-avatar.png") { ?>
                                <img src="/young/7.jpg" alt="user-image" class="user-avtar wid-45 rounded-circle">
                                 <?php } else { ?>
                                <img src="assets/img/profilephotos/<?php echo $profileImg ?>" alt="user-image"
                                     class="user-avtar wid-45 rounded-circle">
                                     <?php } ?>
                            </div>

                            <div class="flex-grow-1 ms-3 me-2">
                                <a href="profile.php"><h6 class="mb-0"><?php echo $username; ?><img class="ml-2" src="img/hand.gif" alt="hand-gif" width="32"></h6></a>
                                <small><?php echo $greeting; ?></small>
                            </div>

                        </div>
                    </div>
                    <ul class="pc-navbar">
                        <li class="pc-item">
                            <a href="/dash" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon"><use xlink:href="#custom-home"></use>
                                </svg> </span>
                                <span class="pc-mtext">Home</span>
                            </a>
                        </li>
<li class="pc-item">
                            <a href="https://t.me/marieplug" class="pc-link">
                            <span class="pc-micon"><svg version="1.1" class="fa-icon w-[16px] leading-[6px]" width="14.86" height="16" role="presentation" viewBox="0 0 1664 1792">
            <path d="M1216 704q0-26-19-45t-45-19h-128v-128q0-26-19-45t-45-19-45 19-19 45v128h-128q-26 0-45 19t-19 45 19 45 45 19h128v128q0 26 19 45t45 19 45-19 19-45v-128h128q26 0 45-19t19-45zM640 1536q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zM1536 1536q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zM1664 448v512q0 24-16 42.5t-41 21.5l-1044 122q1 7 4.5 21.5t6 26.5 2.5 22q0 16-24 64h920q26 0 45 19t19 45-19 45-45 19h-1024q-26 0-45-19t-19-45q0-14 11-39.5t29.5-59.5 20.5-38l-177-823h-204q-26 0-45-19t-19-45 19-45 45-19h256q16 0 28.5 6.5t20 15.5 13 24.5 7.5 26.5 5.5 29.5 4.5 25.5h1201q26 0 45 19t19 45z"></path>
          </svg>
                            </span>
                                <span class="pc-mtext">Gift Deliveries</span>
                            </a>

                        </li>
                        
                        <li class="pc-item">
                            <a href="deposit.php" class="pc-link">
                            <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-direct-inbox"></use>
                                </svg>
                            </span>
                                <span class="pc-mtext">Add Fund</span>
                            </a>

                        </li>

                        <li class="pc-item">
                            <a href="orders.php" class="pc-link">
                            <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-bag"></use>
                                </svg>
                            </span>
                                <span class="pc-mtext">My Orders</span>
                            </a>

                        </li>


                        <!--<li class="pc-item">-->
                        <!--    <a href="downlines.php" class="pc-link">-->
                        <!--    <span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">-->
                        <!--        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1c0 .55.45 1 1 1h14c.55 0 1-.45 1-1v-1c0-2.66-5.33-4-8-4z"></path>-->
                        <!--    </svg>-->
                        <!--    </span>-->
                        <!--        <span class="pc-mtext">Referral</span>-->
                        <!--    </a>-->

                        <!--</li>-->


                        <li class="pc-item">
                            <a href="sppost.php" class="pc-link">
                          <span class="pc-micon">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
         xmlns="http://www.w3.org/2000/svg">
        <path d="M12 1C6.477 1 2 5.477 2 11v4a3 3 0 003 3h1v-7H4v-1a8 8 0 0116 0v1h-2v7h1a3 3 0 003-3v-4c0-5.523-4.477-10-10-10zM7 17v2h10v-2H7z" fill="#919295"/>
    </svg>
</span>

                                <span class="pc-mtext">Support</span>
                            </a>

                        </li>


                        <li class="pc-item">
                            <a href="rules.php" class="pc-link">
                            <span class="pc-micon">
                                <svg width="24" height="24" viewBox="0 0 48 48" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_39_2" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="3"
                                      width="48" height="42">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M24 5L2 43H46L24 5Z" fill="white"
                                      stroke="white" stroke-width="4" stroke-linejoin="round"/>
                                <path d="M24 35V36M24 19L24.008 29" stroke="black" stroke-width="4"
                                      stroke-linecap="round"/>
                                </mask>
                                <g mask="url(#mask0_39_2)">
                                <path d="M0 0H48V48H0V0Z" fill="#878787"/>
                                </g>
                                </svg>


                            </span>
                                <span class="pc-mtext">Rules</span>
                            </a>

                        </li>



                        <li class="pc-item">
                            <a href="termofuse.php" class="pc-link">
                            <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-document-filter"></use>
                                </svg>
                            </span>
                                <span class="pc-mtext"> Terms Of Use</span>
                            </a>

                        </li>






                        <li class="pc-item">
                            <a href="profile.php" class="pc-link">
                           <span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1c0 .55.45 1 1 1h14c.55 0 1-.45 1-1v-1c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                            </span>
                                <span class="pc-mtext">Profile</span>
                            </a>

                        </li>

                        <li class="pc-item">
                            <a href="logout.php" class="pc-link">
                            <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-logout"></use>
                                </svg>
                            </span>
                                <span class="pc-mtext">Log Out</span>
                            </a>

                        </li>

                    </ul>
                </div>
                            </div>
</nav><!-- [ Sidebar Menu ] end --><!-- [ Header Topbar ] start -->


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
   <style>
        /* Style for the notification badge */
        .position-relative .badge {
            font-size: 0.75em;
            padding: 4px;
        }
    </style>


<!-- Notification Icon and Wallet Balance Button -->

<style>
.support-container {
    padding: 40px;
    max-width: 1100px;
    margin: auto;
}

/* Header */
.support-header {
    text-align: center;
    margin-bottom: 40px;
}

.support-icon {
    width: 80px;
    height: 80px;
    margin: auto;
    background: linear-gradient(135deg, #28bf62, #28bf62);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.support-icon i {
    color: white;
    font-size: 32px;
}

.support-header h1 {
    font-size: 34px;
    font-weight: 700;
    color: #000;
}

.support-header p {
    color: #666;
    max-width: 650px;
    margin: auto;
}

/* Grid Cards */
.support-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 22px;
}

.support-card {
    background: white;
    padding: 22px;
    border-radius: 15px;
    border: 2px solid transparent;
    display: flex;
    align-items: start;
    gap: 18px;
    transition: 0.3s;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0,0,0,0.06);
}

.support-card:hover {
    border-color: #28bf62;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

.support-card-icon {
    width: 55px;
    height: 55px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.support-card-icon i {
    font-size: 26px;
}

/* Icon Background Colors */
.telegram-bg {
    background: rgba(0, 136, 204, 0.1);
    color: #0088cc;
}

.whatsapp-bg {
    background: rgba(37, 211, 102, 0.1);
    color: #25D366;
}

.support-card-content h3 {
    font-weight: 600;
    color: #000;
}

.support-card:hover h3 {
    color: #28bf62;
}

.support-card-content p {
    color: #666;
    font-size: 14px;
    margin-bottom: 10px;
}

/* Link Row */
.support-link {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #28bf62;
    font-size: 14px;
    font-weight: 600;
    transition: 0.3s;
}

.support-card:hover .support-link {
    gap: 12px;
}

/* 24/7 Box */
.support-box {
    margin-top: 35px;
    padding: 30px;
    border-radius: 18px;
    background: linear-gradient(90deg, #28bf62, #ffbd59);
    color: white;
    display: flex;
    align-items: center;
    gap: 20px;
    text-align: left;
}

.support-box-icon {
    width: 65px;
    height: 65px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.support-box-icon i {
    font-size: 26px;
}

.support-box-text h3 {
    margin: 0;
    font-weight: 700;
    font-size: 20px;
    color: #fff;
}

/* Tips Section */
.tips-container {
    margin-top: 30px;
    background: white;
    padding: 25px;
    border-radius: 15px;
    border: 1px solid #ddd;
}

.tips-container h3 {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #000;
    margin-bottom: 18px;
}

.tips-container i {
    color: #facc15;
}

/* Tips Grid */
.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 12px;
}

.tip {
    display: flex;
    align-items: start;
    gap: 8px;
    color: #444;
    font-size: 14px;
}

.tip i {
    color: #22c55e;
    margin-top: 3px;
}

     /* Style for the dropdown container */
.ms-auto ul {
    display: flex;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
}

/* Style for each dropdown item */
.ms-auto li {
    margin-right: 15px;
}

/* Dropdown select styling */
#currencyDropdownNavbar .input-group {
    display: inline-block;
    position: relative;
}

#currencyForm select {
    border: 1px solid #ccc;
    padding: 5px 10px;
    background-color: #fff;
    font-size: 14px;
    border-radius: 5px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

/* Add arrow for select dropdown */
#currencyForm select:focus {
    outline: none;
    border-color: #007bff;
}

/* Optional: Add icon or arrow for select input */
#currencyForm select::-ms-expand {
    display: none;
}

/* Mobile view improvements */
@media (max-width: 768px) {
    .ms-auto ul {
        flex-direction: column;
    }

    .ms-auto li {
        margin-bottom: 10px;
    }
}

.wallet-box {
    display: flex;
    align-items: center;
    gap: 4px;
    background: #f3f4f6; /* gray-100 */
    padding: 4px 8px;
    border-radius: 10px;
}
.wallet-link {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}
.wallet-icon {
    color: #28bf62; /* red-500 */
    font-size: 14px;
}

.wallet-text {
    font-size: 10px;
    color: #4b5563; /* gray-700 */
}

.label {
    display: none; /* hidden on small screens */
}

.amount {
    font-weight: 600;
    color: #000;
}

/* Show label on larger screens (similar to Tailwind sm:) */
@media (min-width: 640px) {
    .wallet-box {
        padding: 8px 16px;
    }
    .wallet-icon {
        font-size: 16px;
    }
    .wallet-text {
        font-size: 14px;
    }
    .label {
        display: inline;
    }
}

    </style>
<div class="wallet-box">
    <i class="fas fa-wallet wallet-icon"></i>
    <a href="deposit.php" class="wallet-link">
        <span class="label">Balance: </span>
        <span class="amount"><?php echo $dollar; ?><?php echo number_format((float)$funds, 2); ?></span>
    </a>
</div>
    </header>