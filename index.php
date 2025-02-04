PHP Folder Content Reader & Image Lister

This PHP program scans a specified main folder and lists its subfolders and the image files within them. The output is displayed as a structured table in the terminal, making it easy to visualize and manage folder contents.
This program will help you if you need to update the images and gallery of your ecommerce website.
This is a PHP Version Code, the Nodejs version is also available in the same repository.
Key Features:
Reads the contents of a given directory.
Detects subfolders and lists images (or any files) inside them.
Outputs a formatted table with folder names and corresponding image lists in JSON format.
Simple, clean, and highly portable code for future customization.


<?php
function getFolderContents($mainFolder)
{
    $data = [];

    // Check if directory exists
    if (!is_dir($mainFolder)) {
        echo "Main folder '$mainFolder' does not exist.";
        return [];
    }

    // Read the main directory
    $subFolders = array_filter(glob($mainFolder . '/*'), 'is_dir');

    foreach ($subFolders as $folderPath) {
        $folderName = basename($folderPath);
        $images = [];

        // Read all files inside the current subfolder
        $files = glob($folderPath . '/*.*');
        // Optional if you need only a single image
        $image = basename($files[0]); // for single image
        foreach ($files as $file) {
            if (is_file($file)) {
                $images[] = ['sub_image' => basename($file)];
            }
        }

        // Store data for the current subfolder
        $data[] = ['folder' => $folderName, 'image' => $image, 'sub_image' => $images];
    }

    return $data;
}

function renderTable($data)
{
    if (empty($data)) {
        echo "<p>No folders or images found.</p>";
        return;
    }

    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<thead><tr><th>sku</th><th>image</th><th>sub_image</th></tr></thead><tbody>";

    foreach ($data as $item) {
        echo "<tr>";
        echo "<td>{$item['folder']}</td>";
        echo "<td>{$item['image']}</td>";
        echo "<td>";
        echo json_encode($item['sub_image'], JSON_PRETTY_PRINT);
        echo "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
}

$mainFolder = "MyImages"; // Replace with your actual main folder name
$data = getFolderContents($mainFolder);
renderTable($data);
?>
