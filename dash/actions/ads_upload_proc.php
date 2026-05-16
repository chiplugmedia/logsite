<?php
include '../config/config.php';
print_r($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ads_images_dir = '../ads_images/';

    $username = $_POST['username'];
    $title = $_POST['title'];
    $text = $_POST['post-text'];
    $contact_link = $_POST['contact-link'];

    $upload_ads_image_data = $ads_images_dir . basename($_FILES["ads_image"]["name"]);

    if (empty($title) || empty($text) || empty($contact_link)) {
        header('Location: ../ads/?ads=empty');
    }else {
        if (move_uploaded_file($_FILES["ads_image"]["tmp_name"], $upload_ads_image_data)) {
            $sql = "INSERT INTO ads(ads_image, username, title, text, contact_link)
            VALUES ('$upload_ads_image_data', '$username', '$title', '$text', '$contact_link')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "Ads Posted";
                header('Location: ../ads/?ads=inreview');
            }else {
                echo "Error: Somthing went wrong" . connect_error($conn);
                header('Location: ../ads/?ads=error');
            }
        }
    }
}