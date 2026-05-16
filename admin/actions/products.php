<?php
$genMsg=$categoryName=$location=$desc=$productDescription=$price=$productName=$productPrice=$postPurchaseInfo=$prodNum="";

if(isset($_POST['addCategory'])){

    if(!empty($_POST['categoryName'])){
        $categoryName = filter_var($_POST['categoryName'], FILTER_SANITIZE_STRING);
    } else {
        $status = "error";
        $message = "Enter Category Name";
        $genMsg = sendResponse($status, $message);
        exit; // Exit to stop further execution if category name is empty
    }

    // Generate a unique reference
    $status = "active";
    $reference = get_rand_alphanumeric(10);
    $sql = $link->prepare("INSERT INTO categories(name, reference,status, date) VALUES(?, ?,?, ?)");
    $sql->bind_param("ssss", $categoryName, $reference,$status, $dateTime);

    if($sql->execute()){
        $status = "success";
        $message = "Category uploaded successfully";
        $genMsg = sendResponse($status, $message);
    } else {
        $status = "error";
        $message = "Failed to upload Category";
        $genMsg = sendResponse($status, $message);
    }
}



if (isset($_POST['updateCategory'])) {

    if (empty($_POST['categoryName'])) {
        $status = "error";
        $message = "Enter Category Name";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['reference'])) {
        $status = "error";
        $message = "Something went wrong";
        $genMsg = sendResponse($status, $message);
    } else {
        $categoryName = filter_var($_POST['categoryName'], FILTER_SANITIZE_STRING);
        $reference = filter_var($_POST['reference'], FILTER_SANITIZE_STRING);
        
        $sql = $link->prepare("UPDATE categories SET name=? WHERE reference=?");
        if ($sql === false) {
            $status = "error";
            $message = "SQL prepare failed: " . htmlspecialchars($link->error);
            $genMsg = sendResponse($status, $message);
            exit;
        }

        $sql->bind_param("ss", $categoryName, $reference);
        if ($sql->execute()) {
            $status = "success";
            $message = "Category updated successfully";
            $genMsg = sendResponse($status, $message);
        } else {
            $status = "error";
            $message = "Failed to update category";
            $genMsg = sendResponse($status, $message);
        }
    }
}


if (isset($_POST['deleteCategory'])) {
    if (empty($_POST['reference'])) {
        $status = "error";
        $message = "Something went wrong";
        $genMsg = sendResponse($status, $message);
    } else {
        $reference = filter_var($_POST['reference'], FILTER_SANITIZE_STRING);
        
        // Check if the reference exists
        $sql = $link->prepare("SELECT * FROM categories WHERE reference=?");
        if ($sql === false) {
            $status = "error";
            $message = "SQL prepare failed: " . htmlspecialchars($link->error);
            $genMsg = sendResponse($status, $message);
            exit;
        }
        $sql->bind_param("s", $reference);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            // Proceed with the deletion
            $sql = $link->prepare("DELETE FROM categories WHERE reference=?");
            if ($sql === false) {
                $status = "error";
                $message = "SQL prepare failed: " . htmlspecialchars($link->error);
                $genMsg = sendResponse($status, $message);
                exit;
            }
            $sql->bind_param("s", $reference);
            if ($sql->execute()) {
                $status = "success";
                $message = "Category deleted";
                $genMsg = sendResponse($status, $message);
            } else {
                $status = "error";
                $message = "Failed to delete category";
                $genMsg = sendResponse($status, $message);
            }
        } else {
            $status = "error";
            $message = "Category not found";
            $genMsg = sendResponse($status, $message);
        }
    }
}



if (isset($_POST['uploadProduct'])) {
    // Sanitize and validate inputs
    $productName = isset($_POST['productName']) ? trim($_POST['productName']) : '';
    $productDescription = isset($_POST['productDescription']) ? trim($_POST['productDescription']) : '';
    $productPrice = isset($_POST['productPrice']) ? trim($_POST['productPrice']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $postPurchaseInfo = isset($_POST['postPurchaseInfo']) ? trim($_POST['postPurchaseInfo']) : '';
    $type = isset($_POST['type']) ? trim($_POST['type']) : '';
    $prodNum = isset($_POST['prodNum']) ? trim($_POST['prodNum']) : '';

    // Initialize selected variables
$isSelectedFb = $isSelectedYt = $isSelectedTw = $isSelectedIg = $isSelectedTg = $isSelectedTn = $isSelectedM = $isSelectedO = $isSelectedP = $isSelectedN = $isSelectedIP = $isSelectedEX = $isSelectedSU = $isSelectedSN = $isSelectedOL = $isSelectedAP = $isSelectedNE = $isSelectedTP = $isSelectedGV = $isSelectedTF = $isSelectedTT = $isSelectedTnYU = $isSelectedTnFF = '';

if ($type) {
    switch ($type) {
        case 'facebook':
            $isSelectedFb = 'selected';
            break;
        case 'youtube':
            $isSelectedYt = 'selected';
            break;
        case 'twitter':
            $isSelectedTw = 'selected';
            break;
        case 'instagram':
            $isSelectedIg = 'selected';
            break;
        case 'telegram':
            $isSelectedTg = 'selected';
            break;
        case 'textnow':
            $isSelectedTn = 'selected';
            break;  
        case 'mail':
            $isSelectedM = 'selected';
            break;
        case 'outlook':
            $isSelectedO = 'selected';
            break;
        case 'piavpn':
            $isSelectedP = 'selected';
            break;
        case 'nordvpn':
            $isSelectedN = 'selected';
            break;
        case 'ipvanishvpn':
            $isSelectedIP = 'selected';
            break;
        case 'expressvpn':
            $isSelectedEX = 'selected';
            break;
        case 'surfshark':
            $isSelectedSU = 'selected';
            break;
        case 'snapchat':
            $isSelectedSN = 'selected';
            break;
        case 'oldreddit':
            $isSelectedOL = 'selected';
            break;
        case 'applemusic':
            $isSelectedAP = 'selected';
            break;
        case 'netflix':
            $isSelectedNE = 'selected';
            break;
        case 'textplus':
            $isSelectedTP = 'selected';
            break;
        case 'googlevoice':
            $isSelectedGV = 'selected';
            break;
        case 'textfree':
            $isSelectedTF = 'selected';
            break;
        case 'talkatone':
            $isSelectedTT = 'selected';
            break;
        case 'yellowupdate':
            $isSelectedTnYU = 'selected';
            break;
        case 'fakeflightticket':
            $isSelectedTnFF = 'selected';
            break;
    }
}



    // Validate inputs
    if (empty($productName)) {
        $status = "error";
        $message = "Enter Product Name";
    } elseif (empty($productDescription)) {
        $status = "error";
        $message = "Enter Product Description";
    } elseif (empty($productPrice)) {
        $status = "error";
        $message = "Enter Product Price";
    } elseif (empty($type)) {
        $status = "error";
        $message = "Enter Product Type";
    } elseif (empty($category)) {
        $status = "error";
        $message = "Choose Product Category";
    } elseif (empty($postPurchaseInfo)) {
        $status = "error";
        $message = "Enter what will be given after purchase";
    } elseif (empty($prodNum)) {
        $status = "error";
        $message = "Enter task quantity";
        $genMsg = sendResponse($status, $message);
    } elseif (!is_numeric($prodNum) || $prodNum <= 0) {
        $status = "error";
        $message = "Enter a valid task quantity greater than 0";
        $genMsg = sendResponse($status, $message);    
    } else {
       
        // Filter the inputs
        $productName = filter_string($productName);
        $productDescription = filter_string($productDescription);
        $productPrice = filter_string($productPrice);
        $type = filter_string($type);
        $category = filter_string($category);
        $postPurchaseInfo = filter_string($postPurchaseInfo);

        // Prepare SQL statement
        $status = 'active'; // Default status value
        $sql = $link->prepare("INSERT INTO products (name, description, price, type, status, reference, category, purchaseinfo, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("sssssssss", $productName, $productDescription, $productPrice, $type, $status, $reference, $category, $postPurchaseInfo, $dateTime);

        // Execute the query and handle success or failure
        $allSuccess = true;
        for ($i = 1; $i <= $prodNum; $i++) {
            $reference = get_rand_alphanumeric(10);
            if (!$sql->execute()) {
                $allSuccess = false;
                break;
            }
        }

        if ($allSuccess) {
            $status = "success";
            $message = "Product added successfully";
            $genMsg = sendResponse($status, $message);
        } else {
            $status = "error";
            $message = "Something went wrong adding the product";
            $genMsg = sendResponse($status, $message);
        }
    }
    // Send response
    
}

if (isset($_POST['editProduct'])) {

    // Check for empty required fields and send error response if any are missing
    if (empty($_POST['productName'])) {
        $status = "error";
        $message = "Enter Product Name";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['productDescription'])) {
        $status = "error";
        $message = "Enter Product Description";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['productPrice'])) {
        $status = "error";
        $message = "Enter Product Price";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['type'])) {
        $status = "error";
        $message = "Enter Product Type";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['category'])) {
        $status = "error";
        $message = "Choose Product Category";
        $genMsg = sendResponse($status, $message);
    } elseif (empty($_POST['postPurchaseInfo'])) {
        $status = "error";
        $message = "Enter what will be given after purchase";
        $genMsg = sendResponse($status, $message);
    } else {
        // Sanitize input values
        $name = filter_string($_POST['productName']);
        $description = filter_string($_POST['productDescription']);
        $price = filter_string($_POST['productPrice']);
        $category = filter_string($_POST['category']);
        $type = filter_string($_POST['type']);
        $purchaseinfo = filter_string($_POST['postPurchaseInfo']);

        // Initialize selected variables for product type
        $isSelectedFb = $isSelectedYt = $isSelectedTw = $isSelectedIg = $isSelectedTg = $isSelectedTn = $isSelectedM = 
        $isSelectedO = $isSelectedP = $isSelectedN = $isSelectedIP = $isSelectedEX = $isSelectedSU = $isSelectedSN = 
        $isSelectedOL = $isSelectedAP = $isSelectedNE = $isSelectedTP = $isSelectedGV = $isSelectedTF = $isSelectedTT = 
        $isSelectedTnYU = $isSelectedTnFF = '';

        // Set the selected option based on the type
        switch ($type) {
            case 'facebook': $isSelectedFb = 'selected'; break;
            case 'youtube': $isSelectedYt = 'selected'; break;
            case 'twitter': $isSelectedTw = 'selected'; break;
            case 'instagram': $isSelectedIg = 'selected'; break;
            case 'telegram': $isSelectedTg = 'selected'; break;
            case 'textnow': $isSelectedTn = 'selected'; break;
            case 'mail': $isSelectedM = 'selected'; break;
            case 'outlook': $isSelectedO = 'selected'; break;
            case 'piavpn': $isSelectedP = 'selected'; break;
            case 'nordvpn': $isSelectedN = 'selected'; break;
            case 'ipvanishvpn': $isSelectedIP = 'selected'; break;
            case 'expressvpn': $isSelectedEX = 'selected'; break;
            case 'surfshark': $isSelectedSU = 'selected'; break;
            case 'snapchat': $isSelectedSN = 'selected'; break;
            case 'oldreddit': $isSelectedOL = 'selected'; break;
            case 'applemusic': $isSelectedAP = 'selected'; break;
            case 'netflix': $isSelectedNE = 'selected'; break;
            case 'textplus': $isSelectedTP = 'selected'; break;
            case 'googlevoice': $isSelectedGV = 'selected'; break;
            case 'textfree': $isSelectedTF = 'selected'; break;
            case 'talkatone': $isSelectedTT = 'selected'; break;
            case 'yellowupdate': $isSelectedTnYU = 'selected'; break;
            case 'fakeflightticket': $isSelectedTnFF = 'selected'; break;
        }

        // Prepare and execute the SQL update statement
        $sql = $link->prepare("UPDATE products SET name=?, description=?, price=?, type=?, category=?, purchaseinfo=? WHERE reference=?");
        $sql->bind_param("sssssss", $name, $description, $price, $type, $category, $purchaseinfo, $reference);

        if ($sql->execute()) {
            $status = "success";
            $message = "Product updated successfully";
        } else {
            $status = "error";
            $message = "Failed to update product";
        }

        // Send the response
        $genMsg = sendResponse($status, $message);
    }
}




if (isset($_POST['deleteProduct'])) {
    if (empty($_POST['reference'])) {
        $status = "error";
        $message = "Something went wrong";
        $genMsg = sendResponse($status, $message);
    } else {
        $reference = filter_var($_POST['reference'], FILTER_SANITIZE_STRING);
        
        // Check if the reference exists
        $sql = $link->prepare("SELECT * FROM products WHERE reference=?");
        if ($sql === false) {
            $status = "error";
            $message = "SQL prepare failed: " . htmlspecialchars($link->error);
            $genMsg = sendResponse($status, $message);
        } else {
            $sql->bind_param("s", $reference);
            $sql->execute();
            $result = $sql->get_result();
            
            if ($result->num_rows > 0) {
                // Proceed with the deletion
                $sql = $link->prepare("DELETE FROM products WHERE reference=?");
                if ($sql === false) {
                    $status = "error";
                    $message = "SQL prepare failed: " . htmlspecialchars($link->error);
                    $genMsg = sendResponse($status, $message);
                } else {
                    $sql->bind_param("s", $reference);
                    if ($sql->execute()) {
                        $status = "success";
                        $message = "Product deleted successfully";
                        $genMsg = sendResponse($status, $message);
                    } else {
                        $status = "error";
                        $message = "Failed to delete product";
                        $genMsg = sendResponse($status, $message);
                    }
                }
            } else {
                $status = "error";
                $message = "Product not found";
                $genMsg = sendResponse($status, $message);
            }
        }
    }
}


?>