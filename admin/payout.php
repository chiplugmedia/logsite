<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/products.php";

?>

<?php include"inc/header.php" ?>

               <div class="container-fluid">

                    <div class="layout-specing">

                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Product Category</h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    

                                    <li class="breadcrumb-item text-capitalize"><a href="#">Home </a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Product Category</li>

                                </ul>

                            </nav>

                        </div>


<div class="row">
    <div class="col-lg-4 mt-4">
        <?php echo $genMsg; ?>
        <div class="card border-0 rounded shadow">
            <div class="card-body">
                <h5 class="text-md-start text-center mb-0">Add Product Category:</h5>
                <form method="POST" enctype="multipart/form-data">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <div class="form-icon position-relative">
                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                    <input id="title" type="text" class="form-control ps-5" placeholder="Category Name Title :" name="categoryName" value="<?php echo $categoryName; ?>">
                                </div>
                            </div>
                        </div><!--end col-->
                       
                    </div><!--end row-->
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="submit" id="submit" name="addCategory" class="btn btn-primary" value="Upload Category">
                        </div><!--end col-->
                    </div><!--end row-->
                </form><!--end form-->
            </div><!--end card-body-->
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->
   

<div class="col mt-4 pt-2" id="tables">
    <div class="component-wrapper rounded shadow">
        <div class="p-4 border-bottom">
            <h4 class="title mb-0"> Recent </h4>
        </div>
        <div class="p-4">
            <div class="table-responsive bg-white shadow rounded">
                <table class="table mb-0 table-center">
                    <thead>
                        <tr>
                            <th scope="col" class="border-bottom">Name</th>
                            <th scope="col" class="border-bottom">Status</th>
                            <th scope="col" class="border-bottom">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            $sql = $link->prepare("SELECT * FROM categories ORDER BY id DESC");
                            $sql->execute();
                            $result = $sql->get_result();
                            
                            $numrow = $result->num_rows;
                            if ($numrow > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $status = $row['status'];
                                    $date = $row['date'];
                                    $name = $row['name'];
                                    $reference = $row['reference'];
                        ?>
                        <tr>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $date; ?></td>
                            <td class="text-end p-3">
                                <a href="edit-product.php?reference=<?php echo $reference; ?>" class="btn btn-sm btn-success">Edit</a>
                                <button class="btn btn-danger deleteCategory">Delete</button>
                                <input type="hidden" value="<?php echo $reference; ?>" class="reference">
                            </td>
                        </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--end col-->


<script>
    // Attach click event listener to elements with class "deleteCategory"
    document.querySelectorAll(".deleteCategory").forEach(button => {
        button.addEventListener("click", function() {
            // Get the reference value from the closest table row
            let reference = this.closest("tr").querySelector(".reference").value;
            // Call the deleteCategory function with the reference value
            deleteCategory(reference);
        });
    });

    // Function to create and submit a form to delete the category
    function deleteCategory(reference) {
        // Create a form element
        let form = document.createElement('form');
        // Create input elements for deleteCategory and reference
        let input = document.createElement('input');
        let inputRef = document.createElement('input');
        // Get the body element to append the form
        let body = document.querySelector('body');

        // Set form method to POST
        form.method = "POST";

        // Set input type and value for deleteCategory
        input.type = "hidden";
        input.value = "deleteCategory";
        input.name = "deleteCategory";

        // Set input type and value for reference
        inputRef.type = "hidden";
        inputRef.value = reference;
        inputRef.name = "reference";

        // Append the inputs to the form
        form.appendChild(input);
        form.appendChild(inputRef);
        // Append the form to the body
        body.appendChild(form);
        // Submit the form
        form.submit();
    }
</script>





<?php include"inc/footer.php" ?>
                