<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/sp-posts.php";

$ptitle="Support";
include "inc/header2.php" ?>

<div class="pc-container">
        <div class="pc-content">
<div class="support-container">

    <!-- Header -->
    <div class="support-header">
        <div class="support-icon">
            <i class="fas fa-headset"></i>
        </div>
        <h1>Customer Support</h1>
        <p>We're here to help! Choose your preferred support channel below and our team will assist you promptly.</p>
    </div>

   <!-- Support Options -->
<div class="support-grid">

    <!-- Telegram Announcement -->
    <a href="https://t.me/+z08Q3Sw7n2ZiMGE0" target="_blank" class="support-card">
        <div class="support-card-icon telegram-bg">
            <i class="fab fa-telegram-plane"></i>
        </div>
        <div class="support-card-content">
            <h3>Telegram Announcement Group</h3>
            <p>Get latest updates, announcements and news</p>
            <div class="support-link">
                <span>Click to Join Group</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </a>

    <!-- Telegram Support -->
    <!--<a href="https://t.me/YourSupportUsername" target="_blank" class="support-card">-->
    <!--    <div class="support-card-icon telegram-bg">-->
    <!--        <i class="fab fa-telegram"></i>-->
    <!--    </div>-->
    <!--    <div class="support-card-content">-->
    <!--        <h3>Telegram Support</h3>-->
    <!--        <p>Chat with our support team 24/7</p>-->
    <!--        <div class="support-link">-->
    <!--            <span>Start Telegram Chat</span>-->
    <!--            <i class="fas fa-arrow-right"></i>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</a>-->

    <!-- WhatsApp Channel -->
    <!--<a href="https://wa.me/YourWhatsAppChannelLink" target="_blank" class="support-card">-->
    <!--    <div class="support-card-icon whatsapp-bg">-->
    <!--        <i class="fab fa-whatsapp"></i>-->
    <!--    </div>-->
    <!--    <div class="support-card-content">-->
    <!--        <h3>WhatsApp Channel</h3>-->
    <!--        <p>Join our WhatsApp community for instant support</p>-->
    <!--        <div class="support-link">-->
    <!--            <span>Click to Join WhatsApp Channel</span>-->
    <!--            <i class="fas fa-arrow-right"></i>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</a>-->

</div>

    <!-- 24/7 Support Box -->
    <div class="support-box">
        <div class="support-box-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="support-box-text">
            <h3>24/7 Support Available</h3>
            <p>Our support team responds within 24 hours. For urgent matters, please use Telegram or WhatsApp for faster response.</p>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="tips-container">
        <h3><i class="fas fa-lightbulb"></i> Quick Tips for Better Support</h3>

        <div class="tips-grid">
            <div class="tip"><i class="fas fa-check-circle"></i> Include your order number in all support requests</div>
            <div class="tip"><i class="fas fa-check-circle"></i> Provide screenshots for technical issues</div>
            <div class="tip"><i class="fas fa-check-circle"></i> Check FAQ section before contacting support</div>
            <div class="tip"><i class="fas fa-check-circle"></i> Use Telegram/WhatsApp for urgent matters</div>
        </div>
    </div>

</div>
<!-- FONT AWESOME ICONS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<?php include "inc/footer2.php" ?>