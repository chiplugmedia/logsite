<!-- Notification Drawer -->
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
.telegram-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #28bf62;
    color: #fff;
    border-radius: 25px;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                 Roboto, Helvetica, Arial, sans-serif;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    text-decoration: none;
}

.telegram-widget img {
    width: 24px;
    height: 24px;
}

.telegram-widget:hover {
    background-color: #007ab8;
}
</style>

<a href="https://wa.me/2348132888447?text=Hello%20Am%20from%20pinatexlogs"
   target="_blank"
   class="telegram-widget"
   aria-label="Chat on WhatsApp">
    
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
    <span>Contact Us</span>
</a>

<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="text-center">
            <h6 class="">2026 | Developed By <a href="https://chiplugs.vercel.app" target="_blank">Chi Plug</a> <?php echo $sitename ?></h6>  
        </div>
    </div>
</footer><!-- Required Js -->
<script src="/young/sweet.js"></script>

<script src="/young/js/popper.min.js"></script>
<script src="/young/js/simplebar.min.js"></script>
<script src="/young/js/bootstrap.min.js"></script>
<script src="/young/js/custom-font.js"></script>
<script src="/young/js/pcoded.js"></script>
<script src="/young/js/dz.js"></script>
<script src="/young/js/feather.min.js"></script>
<script src="/young/js/ac-slider.js"></script>
<script>layout_change('false');</script>

<script>layout_theme_contrast_change('false');</script>
<script>change_box_container('false');</script>
<script>layout_caption_change('true');</script>
<script>layout_rtl_change('false');</script>
<script>preset_change('preset-1');</script>
<script>main_layout_change('vertical');</script><!-- [Page Specific JS] start --><!-- bootstrap-datepicker -->
<script src="/young/js/datepicker-full.min.js"></script>
<script src="/young/js/apexcharts.min.js"></script>
<script src="/young/js/plugins/peity-vanilla.min.js"></script>
<script src="/young/js/course-dashboard.js"></script><!-- [Page Specific JS] end -->
<!-- [ Main Content ] end --><!-- Required Js -->
<script src="/young/js/popper.min.js"></script>
<script src="/young/js/simplebar.min.js"></script>
<script src="/young/js/bootstrap.min.js"></script>
<script src="/young/js/custom-font.js"></script>
<script src="/young/js/pcoded.js"></script>
<script src="/young/js/feathert.min.js"></script>
<script>
    layout_change("false");
</script>
<script>
    layout_theme_contrast_change("false");
</script>
<script>
    change_box_container("false");
</script>
<script>
    layout_caption_change("true");
</script>
<script>
    layout_rtl_change("false");
</script>
<script>
    preset_change("preset-1");
</script>
<script>
    main_layout_change("vertical");
</script>



</body><!-- [Body] end --></html>
