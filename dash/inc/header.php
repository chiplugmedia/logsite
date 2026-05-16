<html lang="en" class="light-style layout-menu-fixed " dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="horizontal-menu-template">

  
<head>
    <base href="https://apchi.thermo.com.ng/dash/">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?php echo $ptitle?> - <?php echo $sitename ?></title>
    <!-- Canonical SEO -->
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.png" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/fonts/tabler-icons.css"/>
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/libs/apex-charts/apex-charts.css" />
<link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/libs/swiper/swiper.css" />
<link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
<link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css">
<link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/css/pages/app-kanban.css" />
 <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/css/pages/ui-carousel.css" />
 <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/libs/toastr/toastr.css" />
    <!-- Page CSS -->
    <link rel="stylesheet" href="https://monify.net.ng/dash/assets/vendor/css/pages/cards-advance.css" />
    <!-- Helpers -->
    <script src="https://monify.net.ng/dash/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="assets/vendor/js/template-customiszer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/sweetalert2@11.4.24/dist/sweetalert2.min.css,npm/sweetalert2@11.4.24/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/combine/npm/sweetalert2@11.4.24/dist/sweetalert2.all.min.js,npm/sweetalert2@11.4.24,npm/sweetalert2@11.4.24/dist/sweetalert2.min.js,npm/sweetalert2@11.4.24/dist/sweetalert2.min.js"></script>

     <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
     <style>
         .absolute{
             position: absolute;
         }
         .relxative{
             position: relative;
         }
         .text-black{
             color: #000000 !important;
         }
     </style>
     <script type="text/javascript">
  ///  $(window).on('load', function() {
  //      $('#modalCongrats').modal('show');
 //   });
</script>
</head>

<body>

  
  <!-- Layout wrapper -->
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
  <div class="layout-container">

    
    



<!-- Navbar -->


  

  
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-xxl">
      

      
      
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="index" class="app-brand-link ">
          
          <span class="app-brand-text demo menu-text fw-bold"><img src="/20231015_153018.png" width="120" alt="" ></span>
        </a>

        
        
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
          <i class="ti ti-x ti-sm align-middle"></i>
        </a>
        
      </div>
      

      
      
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0  d-xl-none  ">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="ti ti-menu-2 ti-sm"></i>
        </a>
      </div>
      

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        
        

        

        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- Style Switcher -->
          <li class="nav-item me-2 me-xl-0">
            <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
              <i class='ti ti-md'></i>
            </a>
          </li>
          <!--/ Style Switcher -->
          

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="assets/img/profilephotos/avatar.png<?php echo $profileImg?>" alt class="h-auto rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="profile">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <img src="assets/img/profilephotos/avatar.png<?php echo $profileImg?>" alt class="h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-semibold d-block"><?php echo $fullname?></span>
                      <small class="text-muted"><?php echo $username?></small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="profile">
                  <i class="ti ti-user-check me-2 ti-sm"></i>
                  <span class="align-middle">My Profile</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="bank">
                  <i class="ti ti-settings me-2 ti-sm"></i>
                  <span class="align-middle">Settings</span>
                </a>
              </li>

              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="https://monify.net.ng/dash/logout" target="_blank">
                  <i class="ti ti-logout me-2 ti-sm"></i>
                  <span class="align-middle">Log Out</span>
                </a>
              </li>
            </ul>
          </li>
          <!--/ User -->
          


        </ul>
      </div>

      
     
      
      
    </div>
  </nav>
  
  
<!-- / Navbar -->

    

    <!-- Layout container -->
    <div class="layout-page">

      <!-- Content wrapper -->
      <div class="content-wrapper">
        
        





<!-- Menu -->
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal  menu bg-menu-theme flex-grow-0">
  <div class="container-xxl d-flex h-100">
    
    
    <ul class="menu-inner">

      <!-- Dashboards -->
      <li class="menu-item">
        <a href="https://monify.net.ng/dash/" class="menu-link">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>
      
      <li class="menu-item">
        <a href="https://monify.net.ng/dash/tasks" class="menu-link">
          <i class="menu-icon tf-icons ti ti-list-details"></i>
          <div data-i18n="Daily Tasks">Daily Tasks</div>
        </a>
      </li>
      
      <li class="menu-item">
        <a href="https://monify.net.ng/dash/sppost" class="menu-link">
          <i class="menu-icon tf-icons ti ti-ad-2"></i>
          <div data-i18n="Sponsored Ads">Sponsored Ads</div>
        </a>
      </li>
      
      <li class="menu-item">
        <a href="https://monify.net.ng/dash/spin" class="menu-link">
          <i class="menu-icon tf-icons ti ti-fidget-spinner"></i>
          <div data-i18n="Spin Wheel">Spin Wheel</div>
        </a>
      </li>
      
      <!-- Pages -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-file-invoice"></i>

          <div data-i18n="Pay Bills">Pay Bills</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="https://monify.net.ng/dash/data" class="menu-link">
              <i class="menu-icon tf-icons ti ti-wifi"></i>
              <div data-i18n="Buy Data">Buy Data</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="https://monify.net.ng/dash/airtime" class="menu-link">
              <i class="menu-icon tf-icons ti ti-phone"></i>
              <div data-i18n="Buy Airtime">Buy Airtime</div>
            </a>
          </li>
        </ul>
       </li>
       
      <li class="menu-item">
        <a href="https://monify.net.ng/dash/top-earners" class="menu-link">
          <i class="menu-icon tf-icons ti ti-users"></i>
          <div data-i18n="Top Earners">Top Earners</div>
        </a>
      </li>
      
      
      <li class="menu-item">
        <a href="https://monify.net.ng/dash/withdraw" class="menu-link">
          <i class="menu-icon tf-icons ti ti-wallet"></i>
          <div data-i18n="Withdrawal">Withdrawal</div>
        </a>
      </li>
      
      <!-- Pages -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-settings"></i>

          <div data-i18n="Account Settings">Account Settings</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="https://monify.net.ng/dash/profile" class="menu-link">
              <i class="menu-icon tf-icons ti ti-user-circle"></i>
              <div data-i18n="Profile">Profile</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="https://monify.net.ng/dash/bank" class="menu-link">
              <i class="menu-icon tf-icons ti ti-cash-banknote"></i>
              <div data-i18n="Bank">Bank</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="https://monify.net.ng/dash/social" class="menu-link">
              <i class="menu-icon tf-icons ti ti-brand-facebook"></i>
              <div data-i18n="Social">Social</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="https://monify.net.ng/dash/security" class="menu-link">
              <i class="menu-icon tf-icons ti ti-lock"></i>
              <div data-i18n="Security">Security</div>
            </a>
          </li>
        </ul>
       </li>
       
       <?php if($role =="vendor"){ ?>
       <li class="menu-item">
        <a href="https://monify.net.ng/dash/vendor" class="menu-link">
          <i class="menu-icon tf-icons ti ti-tags"></i>
          <div data-i18n="Vendors Lounge">Vendors Lounge</div>
        </a>
      </li>
      <?php } ?>
      
    <!--  <li class="menu-item">
        <a href="https://monify.net.ng/dash/shop" class="menu-link">
          <i class="menu-icon tf-icons ti ti-building-store"></i>
          <div data-i18n="Marketplace">Marketplace</div>
        </a>
      </li>-->
            
            
        
      

    </ul>
    
    
  </div>
</aside>
<!-- / Menu -->

