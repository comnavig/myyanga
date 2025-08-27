<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Your PHP code here

// Assuming you have a database connection established

// Connect to the database
$servername = 'localhost';
$username = 'myyanga_myyanga';
$password = '@myyanga123#$';
$dbname = 'myyanga_myyanga';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch all products from the database
$sql = 'SELECT * FROM products';
$result = $conn->query($sql);
$c = 0;
// Loop through each product
// while ($row = $result->fetch_assoc()) {
    
//     $productId = $row['id'];

//     // Check if at least one picture exists for the product
//     $pictureExists = false;
    
//     $pictureSql = "SELECT * FROM product_pictures WHERE product_id = $productId";
//     $pictureResult = $conn->query($pictureSql);
    
//     $x = 1;

//     while ($pictureRow = $pictureResult->fetch_assoc()) {
//         $pictureUrl = $pictureRow['url'];

//         // Extract the filename from the picture URL
//         $filename = basename($pictureUrl);

//         // Specify the local directory where the picture files are stored
//         $localDirectory = './public/storage/products';
        
//         $filename = str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "", $filename);
    
//         // Construct the local file path
//         $localFilePath = $localDirectory . '/' . $filename;
        
//         var_dump($localFilePath.'<br>');
        
//         var_dump($x++);
        
//         // Check if the file exists locally
//         if (file_exists($localFilePath)) {
//             $pictureExists = true;
//             var_dump($pictureExists);
//             break;
//         }
//     }
//     // Check if the file exists locally
//     if (!$pictureExists) {
        
//         // File does not exist, update the product availability to 0
//         $productId = $row['product_id'];
//         $updateSql = "UPDATE products SET available = 0 WHERE id = $productId";
//         $conn->query($updateSql);
//         $c++;
        
//     }
// }

$conn->close();

// // Fetch all product pictures from the database
// $sql = 'SELECT * FROM product_pictures';
// $result = $conn->query($sql);
// $c =0;
// // Loop through each product picture
// while ($row = $result->fetch_assoc()) {
//     $pictureId = $row['id'];
//     $pictureUrl = $row['url'];

//     // Extract the filename from the picture URL
//     $filename = basename($pictureUrl);

//     // Specify the local directory where the picture files are stored
//     $localDirectory = './public/storage/products';
    
//     $filename = str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "", $filename);

//     // Construct the local file path
//     $localFilePath = $localDirectory . '/' . $filename;
    
//     var_dump($localFilePath.'<br>');
    
//     // Check if the file exists locally
//     if (!file_exists($localFilePath)) {
//         // Update the product picture availability to 0
//         $updateSql = "UPDATE product_pictures SET available = 0 WHERE id = $pictureId";
//         $conn->query($updateSql);
//         $c++;
//     }
// }

// $conn->close();

// echo 'Script executed successfully!';

$sql = 'UPDATE products SET available = 1 WHERE id IN (
    SELECT product_id FROM product_pictures WHERE available = 1
)';

$conn->query($sql);

echo 'Script executed successfully!'.$c;
