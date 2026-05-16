<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="noxen">
  <meta name="keywords" content="noxen">
  <meta name="author" content="noxen">
  <link rel="manifest" href="/Flowtrex/user/mPay/manifest.json">
  <link rel="icon" href="/Flowtrex/user/mPay/assets/images/logo/logo.png" type="image/x-icon">
  <title><?php echo $ptitle?> - <?php echo $sitename ?></title>
  <link rel="apple-touch-icon" href="/Flowtrex/user/mPay/assets/images/logo/logo.png">
  <meta name="theme-color" content="#122636">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="noxen">
  <meta name="msapplication-TileImage" content="/Flowtrex/user/mPay/assets/images/logo/logo.png">
  <meta name="msapplication-TileColor" content="#FFFFFF">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!--Google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&amp;display=swap" rel="stylesheet">

  <!-- iconsax css -->
  <link rel="stylesheet" type="text/css" href="/Flowtrex/user/mPay/assets/css/vendors/iconsax.css">


  <!-- bootstrap css -->
   <link rel="stylesheet" type="text/css" href="/Flowtrex/user/mPay/assets/css/vendors/bootstrap.min.css">
  <link rel="stylesheet" id="rtl-link" type="text/css" href="/Flowtrex/user/mPay/assets/css/vendors/bootstrap.min.css" />

  <!-- swiper css -->
  <link rel="stylesheet" type="text/css" href="/Flowtrex/user/mPay/assets/css/vendors/swiper-bundle.min.css">

  <!-- Theme css -->
   <link rel="stylesheet" id="change-link" type="text/css" href="/Flowtrex/user/mPay/assets/css/style.css">
</head>

<body style=""><div id="ext-megabonus-main-content" class="ext-megabonus-top-line"></div>
  <!-- side bar start -->
  <div class="offcanvas sidebar-offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft">
    <div class="offcanvas-header sidebar-header">
      <div class="sidebar-logo">
        <img class="img-fluid logo" src="/Flowtrex/user/mPay/assets/images/logo/logo.png" alt="logo">
      </div>
      <div class="balance">
        <img class="img-fluid balance-bg" src="/Flowtrex/user/mPay/assets/images/background/auth-bg.jpg" alt="auth-bg">
        <h5>Available Balance</h5>
        <h2><?php echo $currencySymbol ?><?php echo number_format($convertedAmount, 2) ?></h2>
      </div>
    </div>
    <div class="offcanvas-body">
      <div class="sidebar-content">
        <ul class="link-section">
          <li>
            <a href="tasks" class="pages">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mouse-pointer sidebar-icon">
  <polyline points="3 3 21 21 3 21 3 3"></polyline>
  <circle cx="12" cy="12" r="6"></circle>
</svg>


              <h3>Daily Claim</h3>
            </a>
          </li>
          <li>
            <a href="sppost" class="pages">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings sidebar-icon">
  <circle cx="12" cy="12" r="3" />
  <path d="M19.39 12a7.5 7.5 0 0 1-1.2 4.07" />
  <path d="M2 12a10 10 0 0 1 10-10" />
  <path d="M17.94 4.06a9 9 0 0 1 1.74 4.94" />
</svg>

              <h3>Sponsored Post</h3>
            </a>
          </li>
          <li>
               <a href="socialask" class="pages">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"  class="feather feather-cart-check sidebar-icon">
            <path d="M12 1v2"></path>
            <path d="M17.657 4.929l-1.414 1.414"></path>
            <path d="M21 12h-2"></path>
            <path d="M17.657 19.071l-1.414-1.414"></path>
            <path d="M12 23v-2"></path>
            <path d="M6.343 19.071l1.414-1.414"></path>
            <path d="M3 12h2"></path>
            <path d="M6.343 4.929l1.414 1.414"></path>
            <path d="M12 8v8"></path>
            <path d="M15 12l3.5 3.5a2.5 2.5 0 0 1-3.536 3.536L12 17"></path>
            <path d="M9 12l-3.5 3.5a2.5 2.5 0 0 0 3.536 3.536L12 17"></path>
          </svg>
          <h3>Social Task</h3>
        </a>
      </li>
      <li>
            <a href="p2preg" class="pages">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw sidebar-icon">
  <polyline points="23 4 23 10 17 10"></polyline>
  <polyline points="1 20 1 14 7 14"></polyline>
  <path d="M3 8h5l-1.5-1.5"></path>
  <path d="M21 16h-5l1.5 1.5"></path>
</svg>

              <h3>P2p</h3>
            </a>
          </li>
          <li>
              
              <a href="downlines" class="pages">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-profiles sidebar-icon">
  <circle cx="7" cy="5" r="3"></circle>
  <path d="M14 4a3 3 0 1 1-6 0"></path>
  <circle cx="17" cy="5" r="3"></circle>
  <path d="M14 10a3 3 0 1 1-6 0"></path>
  <circle cx="7" cy="14" r="3"></circle>
  <path d="M14 13a3 3 0 1 1-6 0"></path>
  <circle cx="17" cy="14" r="3"></circle>
</svg>


              <h3>Downlines</h3>
            </a>
          </li>
          
          <li>  
              
            <a href="earning-history" class="pages">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock sidebar-icon">
  <circle cx="12" cy="12" r="10"></circle>
  <polyline points="12 6 12 12 16 14"></polyline>
</svg>

  <h3>History</h3>
</a>
          </li>
          
          <li>
              <a href="tiktok" class="pages">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"  class="feather feather-cart-check sidebar-icon">
            <g>
              <path d="M9.26 8.52c-2.68 0-4.86 2.18-4.86 4.86s2.18 4.86 4.86 4.86c2.68 0 4.86-2.18 4.86-4.86v-6.16c0-.18-.15-.32-.32-.32h-2.27c-.18 0-.32.15-.32.32v5.1c0 1.68-1.38 3.05-3.05 3.05s-3.05-1.38-3.05-3.05c0-1.68 1.38-3.05 3.05-3.05.72 0 1.38.26 1.89.69.13.11.33.11.45-.02l1.6-1.6c.12-.12.12-.32 0-.45-.97-.88-2.22-1.41-3.59-1.41z"></path>
              <path d="M15.37 3c-.18 0-.32.15-.32.32v2.27c0 .18.15.32.32.32 1.94 0 3.52 1.58 3.52 3.52 0 .18.15.32.32.32h2.27c.18 0 .32-.15.32-.32-.01-3.46-2.83-6.27-6.31-6.31z"></path>
            </g>
          </svg>
          <h3>Tiktok Pay</h3>
        </a>
      </li>
      <li>
          <a href="quiz" class="pages">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle sidebar-icon">
  <circle cx="12" cy="12" r="10"></circle>
  <path d="M9.09 9a3 3 0 1 1 5.83 1c0 1.5-1.36 2.71-3 2.71h-.16v1.29"></path>
  <line x1="12" y1="17" x2="12.01" y2="17"></line>
</svg>

          <h3>Brain Teaser(quiz)</h3>
        </a>
      </li>
      <li>
            <a href="freelanc-ad" class="pages">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cart-check sidebar-icon">
  <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
  <line x1="4" y1="8" x2="20" y2="8"></line>
  <line x1="4" y1="16" x2="20" y2="16"></line>
  <line x1="10" y1="12" x2="10" y2="20"></line>
  <line x1="14" y1="12" x2="14" y2="20"></line>
</svg>

              <h3>Sell Product</h3>
            </a>
          </li>
          
 <?php if($role =="vendor"){ ?>
<li>
   
            <a href="vendor" class="pages">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag sidebar-icon">
  <path d="M7.58 7.58a2 2 0 0 1 2.83 0L12 9.17l1.42-1.42a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83L14.83 12l1.42 1.42a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0L12 14.83l-1.42 1.42a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83L9.17 12 7.58 10.41a2 2 0 0 1 0-2.83zM9 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"></path>
  <path d="M17 11v6a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-6"></path>
  <line x1="12" y1="9" x2="12" y2="21"></line>
</svg>


              <h3>Vendors Lounge</h3>
            </a>
          </li>
<?php } ?>
          <li>
            <a href="profile" class="pages">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user sidebar-icon"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              <h3>Profile</h3>
            </a>
          </li>

          <li>
            <a href="logout" class="pages">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out sidebar-icon"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
              <h3>Log out</h3>
            </a>
          </li>
        </ul>
        <div class="mode-switch">
          <ul class="switch-section">
            <li>
              <h3>Dark</h3>
              <div class="switch-btn">
                <input id="dark-switch" type="checkbox">
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
 <!-- side bar end -->
<style>
    .fs-12{
        font-size: 12px;
    }
    .fs-14{
        font-size: 14px;
    }
    .fs-16{
        font-size: 16px;
    }
    .fs-18{
        font-size: 18px;
    }
</style>
<script>
    $(window).on('load', function() {
        $('#notifyModal').modal('show');
    });
</script>

  <!-- header start -->
  <header class="section-t-space">
    <div class="custom-container">
      <div class="header-panel">
        <a class="sidebar-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu menu-icon"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </a>
        <img class="img-fluid logo" src="/Flowtrex/user/mPay/assets/images/logo/logo.png" alt="logo">
<div id="currencyDropdownNavbarLink" aria-haspopup="menu" aria-expanded="false" data-state="closed" class="group flex cursor-pointer items-center gap-1 rounded-xl py-2 px-3 text-lg font-semibold hover:bg-token-main-surface-secondary radix-state-open:bg-token-main-surface-secondary juice:text-token-text-secondary juice:rounded-lg juice:py-1.5 overflow-hidden whitespace-nowrap">
    <div class="juice:text-token-text-secondary"><?php echo htmlspecialchars($currencySymbol); ?> <span class="text-token-text-secondary"></span></div>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" class="icon-md text-token-text-tertiary">
        <path fill="currentColor" fill-rule="evenodd" d="M5.293 9.293a1 1 0 0 1 1.414 0L12 14.586l5.293-5.293a1 1 0 1 1 1.414 1.414l-6 6a1 1 0 0 1-1.414 0l-6-6a1 1 0 0 1 0-1.414" clip-rule="evenodd"></path>
    </svg>
</div>

<div id="currencyDropdownNavbar"  class="form-group">
    <form id="currencyForm" method="post" >
        <select class="form-control" id="targetCountry" name="targetCountry" onchange="document.getElementById('currencyForm').submit()">
            <?php
            foreach ($exchangeRates as $country => $rates) {
                echo '<option value="' . htmlspecialchars($country) . '"' . ($country == $countryname ? ' selected' : '') . '>' . htmlspecialchars($country) . '</option>';
            }
            ?>
        </select>
    </form>
</div>

<script>
    document.getElementById('currencyDropdownNavbarLink').addEventListener('click', function () {
        var dropdown = document.getElementById('currencyDropdownNavbar');
        var expanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !expanded);
        this.setAttribute('data-state', expanded ? 'closed' : 'open');
        dropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function (event) {
        var dropdown = document.getElementById('currencyDropdownNavbar');
        var toggle = document.getElementById('currencyDropdownNavbarLink');

        if (!dropdown.contains(event.target) && !toggle.contains(event.target)) {
            dropdown.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('data-state', 'closed');
        }
    });
</script>



      </div>
    </div>
  </header>
  