<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/actions/topup.php";



$ptitle="Product Purchase";

?>




 <div><?php echo $genMsg?></div>
  <form action="" method="POST">
    <div>
        <label for="service">Service:</label>
        <input type="text" id="service" name="service" required>
    </div>
    <div>
        <label for="year">Year:</label>
        <input type="text" id="year" name="year" required>
    </div>
    <div>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" required>
    </div>
    <div>
        <label for="cost">Cost:</label>
        <input type="number" id="cost" name="cost" min="0" step="0.01" required>
    </div>
    <div>
        <input type="hidden" name="purchaseapi" value="1">
        <button type="submit">Purchase</button>
    </div>
</form>






  <?php include "inc/footer2.php" ?>