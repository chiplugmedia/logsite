<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/api.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/update_status.php";

$response = getCategoriesAndProducts(); 



?>

<?php include"inc/header.php" ?>


 <div class="container-fluid">

                    <div class="layout-specing">

                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Product</h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    

                                    <li class="breadcrumb-item text-capitalize"><a href="#">Home </a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Product</li>

                                </ul>

                            </nav>

                        </div>
                        
                        <?php echo $genMsg; ?>
<?php
// ========================
// LOAD ADMIN OVERRIDE PRICES
// ========================
$adminPrices = [];
$sql = $link->prepare("SELECT product_id, override_price FROM adminprices");
$sql->execute();
$result = $sql->get_result();
while ($row = $result->fetch_assoc()) {
    $adminPrices[$row['product_id']] = $row['override_price'];
}
?>
<div class="col-xl-12 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">Admin Product Price Manager</h5>

        <input type="text" id="searchInput" class="form-control w-25"
               placeholder="Search category, product or price...">
    </div>

    <div class="table-responsive">
        <table id="productTable" class="table table-center bg-white mb-0">
            <thead>
                <tr>
                    <th class="border-bottom p-3">No.</th>
                    <th class="border-bottom p-3">Category</th>
                    <th class="text-center border-bottom p-3">Product</th>
                    <th class="text-center border-bottom p-3">API Price ($)</th>
                    <th class="text-center border-bottom p-3">Your Price ($)</th>
                    <th class="text-end border-bottom p-3">Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                <?php 
                $rowNumber = 0;
                foreach ($response['categories'] as $cat):
                    foreach ($cat['products'] as $p):
                        $pid = $p['id'];
                        $apiPrice = $p['price'];
                        $override = $adminPrices[$pid] ?? "";
                        $rowNumber++;
                ?>
                <tr>
                    <td class="p-3">#<?php echo $rowNumber; ?></td>
                    <td class="p-3"><?php echo htmlspecialchars($cat['name']); ?></td>
                    <td class="p-3 text-center"><?php echo htmlspecialchars($p['name']); ?></td>
                    <td class="p-3 text-center">$<?php echo number_format($apiPrice, 2); ?></td>

                    <td class="p-3 text-center">
                        <form method="POST" class="priceForm d-flex justify-content-center gap-2">
                            <input type="number" step="0.01" min="0" name="override_price"
                                   value="<?php echo htmlspecialchars($override); ?>"
                                   class="form-control text-center" style="width: 120px;"
                                   placeholder="Enter price">

                            <input type="hidden" name="product_id" value="<?php echo $pid; ?>">

                            <button type="submit" name="saveprice"
                                    class="btn btn-sm btn-primary px-3">Save</button>
                        </form>
                    </td>

                    <td class="p-3 text-end">
                        <span class="text-muted">—</span>
                    </td>
                </tr>
                <?php endforeach; endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav class="mt-3">
        <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const rowsPerPage = 10;
    const tableBody = document.getElementById("tableBody");
    const pagination = document.getElementById("pagination");
    const searchInput = document.getElementById("searchInput");
    let currentPage = 1;

    function updateTable() {
        let rows = Array.from(tableBody.querySelectorAll("tr"));
        let query = searchInput.value.toLowerCase().trim();

        // Filter rows by search
        let filtered = rows.filter(row => {
            return row.innerText.toLowerCase().includes(query);
        });

        // Pagination logic
        let totalPages = Math.ceil(filtered.length / rowsPerPage);
        currentPage = Math.min(currentPage, totalPages || 1);

        // Hide all rows first
        rows.forEach(r => r.style.display = "none");

        // Show rows for current page
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        filtered.slice(start, end).forEach(r => r.style.display = "");

        // Build pagination buttons
        pagination.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
            let li = document.createElement("li");
            li.className = "page-item " + (i === currentPage ? "active" : "");
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener("click", function (e) {
                e.preventDefault();
                currentPage = i;
                updateTable();
            });
            pagination.appendChild(li);
        }
    }

    searchInput.addEventListener("keyup", () => {
        currentPage = 1;
        updateTable();
    });

    updateTable();

});
</script>

<?php include"inc/footer.php" ?>
