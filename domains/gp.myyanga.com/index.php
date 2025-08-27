<?php
// URL of the file to be downloaded
$file_url = 'https://greenpages.com.ng/Archive2.zip';

// Check if the file exists remotely
$headers = get_headers($file_url);
if ($headers && strpos($headers[0], '200') !== false) {
    // Set headers to initiate file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="Archive.zip"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . $headers["Content-Length"]);

    // Output the file content
    readfile($file_url);
    exit;
} else {
    echo "File not found.";
}
?>
