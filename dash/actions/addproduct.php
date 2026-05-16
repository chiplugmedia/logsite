<?php
$genMsg=$title=$location=$desc=$sellerName=$price=$contact="";



if (isset($_POST['action']) && $_POST['action'] === 'downloadpurchaseinfo') {

    if (empty($_POST['reference'])) {
        echo sendResponse("error", "Invalid purchase reference");
        exit;
    }

    $reference = $_POST['reference'];

    $sql = $link->prepare(
        "SELECT purchaseinfo 
         FROM userpurchases 
         WHERE reference = ? 
           AND username = ? 
           AND status = 'completed'"
    );
    $sql->bind_param("ss", $reference, $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();
        $mypurchaseinfo = $row['purchaseinfo'];

        // Set success message
        $genMsg = sendResponse("success", "Account Details Downloaded Successfully\n\n");

        // Download file
        header("Content-Type: text/plain");
        header("Content-Disposition: attachment; filename=purchaseinfo.txt");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "Account Details\n\n";
        echo $mypurchaseinfo;
        exit;

    } else {
        echo sendResponse("error", "Purchase not found or not completed");
        exit;
    }
}



if (isset($_POST['userspd'])) {
    // Sanitize and retrieve input data
    $username = !empty($_POST['username']) ? filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS) : "";
    $title = !empty($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS) : "";
    $price = !empty($_POST['price']) ? filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : "";
    $contact = !empty($_POST['contact']) ? filter_var($_POST['contact'], FILTER_SANITIZE_URL) : "";
    $desc = !empty($_POST['desc']) ? filter_var($_POST['desc'], FILTER_SANITIZE_SPECIAL_CHARS) : "";

    // Validate inputs
    if (empty($title) || empty($price) || empty($contact) || empty($desc)) {
        $genMsg = sendResponse("error", "All fields are required");
    } elseif (!is_numeric($price)) {
        $genMsg = sendResponse("error", "Enter a valid product price");
    } elseif (!filter_var($contact, FILTER_VALIDATE_URL)) {
        $genMsg = sendResponse("error", "Enter a valid contact link");
    } else {
        // Sanitize inputs again before using them
        $username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
        $title = filter_var($title, FILTER_SANITIZE_SPECIAL_CHARS);
        $price = floatval($price); // Convert to float
        $contact = filter_var($contact, FILTER_SANITIZE_URL);
        $desc = filter_var($desc, FILTER_SANITIZE_SPECIAL_CHARS);
        $reference = get_rand_alphanumeric(20);

        $imgArr = array();
        $imgSuccessCount = $imgCountAll = 0;

        // Loop through uploaded images
        for ($i = 1; $i <= 4; $i++) {
            $imageName = "img$i";
            if (isset($_FILES[$imageName]['name']) && $_FILES[$imageName]['error'] == 0) {
                $imgCountAll++;

                // Move uploaded file to desired location
                $uploadDir = "img/products/";
                $uploadFile = $uploadDir . basename($_FILES[$imageName]['name']);
                if (move_uploaded_file($_FILES[$imageName]['tmp_name'], $uploadFile)) {
                    $imgStatus = "success";
                    $imgMessage = "File is valid, and was successfully uploaded.";
                    $imgArr[$imageName]['status'] = $imgStatus;
                    $imgArr[$imageName]['message'] = $imgMessage;
                    ${"imageName$i"} = $_FILES[$imageName]['name']; // Store file name
                    $imgSuccessCount++;
                } else {
                    $imgStatus = "error";
                    $imgMessage = "Failed to move uploaded file.";
                    $imgArr[$imageName]['status'] = $imgStatus;
                    $imgArr[$imageName]['message'] = $imgMessage;
                }
            }
        }

        // If all images were successfully uploaded
        if ($imgSuccessCount == $imgCountAll) {
            // Set seller name and location (assuming they are defined elsewhere)
            $sellerName = ""; // Define this variable
            $location = ""; // Define this variable
            $showInHomePage = true; // Or false depending on your logic
            $showInDashboard = true; // Or false depending on your logic

            // Prepare and bind parameters for the SQL statement
            $sql = $link->prepare("INSERT INTO products (username, title, price, sellername, location, contact, image1, image2, image3, description, showhome, showdash, reference, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $sql->bind_param("sssssssssssss", $username, $title, $price, $sellerName, $location, $contact, $imageName1, $imageName2, $imageName3, $desc, $showInHomePage, $showInDashboard, $reference);

            if ($sql->execute()) {
                // Insert into product view
                $sql_view = $link->prepare("INSERT INTO productview(reference, date) VALUES(?, NOW())");
                $sql_view->bind_param("s", $reference);
                $sql_view->execute();

                $genMsg = sendResponse("success", "Product uploaded successfully");
            } else {
                $genMsg = sendResponse("error", "Failed to upload product");
            }
        } else {
            // If not all images were successfully uploaded, delete uploaded images and show error message
            $delImages = array($imageName1, $imageName2, $imageName3, $imageName4);
            deleteAllUploadedImage($delImages);
            $genMsg = sendResponse("error", "Failed to upload one or more images");
        }
    }
}





if(isset($_POST['deleteuserspd'])){
    if(empty($_POST['id'])){
        $status="error";
        $message="Something went wrongk"; 
        $spostMsg=sendResponse($status, $message);
    } 
    if(empty($_POST['image'])){
        $status="error";
        $message="Something went wrong"; 
        $spostMsg=sendResponse($status, $message);
    } 
    else{
        $id=filter_string($_POST['id']);
        $image=filter_string($_POST['image']);
        $sql=$link->prepare("DELETE FROM products WHERE id=?");
        $sql->bind_param("i", $id);
        if($sql->execute()){
            $path=$_SERVER['DOCUMENT_ROOT']."$stream/dash/img/products/$image";
            unlink($path);
            $status="success";
            $message="products deleted";
            $spostMsg=sendResponse($status, $message);
        }
        else{
            $status="error";
            $message="Something went wrong";
            $spostMsg=sendResponse($status, $message);
        }    
    } 
}




?>
