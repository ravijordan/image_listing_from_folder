Node.js Folder Content Reader & Image Lister

This Node.js program scans a specified main folder and lists its subfolders and the image files within them. The output is displayed as a structured table in the terminal, making it easy to visualize and manage folder contents.
This program will help you if you need to update the images and gallery of your ecommerce website.
This is a Node.js Version Code, the PHP version is also available in the same repository.
Key Features:
Reads the contents of a given directory.
Detects subfolders and lists images (or any files) inside them.
Outputs a formatted table with folder names and corresponding image lists in JSON format.
Simple, clean, and highly portable code for future customization.

const fs = require('fs');
const path = require('path');

// Function to read folder contents
async function getFolderContents(mainFolder) {
  if (!fs.existsSync(mainFolder)) {
    console.log(`Main folder '${mainFolder}' does not exist.`);
    return [];
  }

  const subFolders = fs.readdirSync(mainFolder).filter(file =>
    fs.lstatSync(path.join(mainFolder, file)).isDirectory()
  );

  const folderData = subFolders.map(folderName => {
    const folderPath = path.join(mainFolder, folderName);
    const images = fs.readdirSync(folderPath)
      .filter(file => fs.lstatSync(path.join(folderPath, file)).isFile())
      .map(file => ({ sub_image: file }));

    return { folder: folderName, images };
  });

  return folderData;
}

// Render data as a table
function renderTable(data) {
  if (data.length === 0) {
    console.log('No folders or images found.');
    return;
  }

  console.log('Folder | Images');
  console.log('---------------------------');
  data.forEach(item => {
    console.log(`${item.folder} | ${JSON.stringify(item.images, null, 2)}`);
  });
}

async function main() {
  const mainFolder = 'GPImages'; // Replace with your actual main folder
  const data = await getFolderContents(mainFolder);
  renderTable(data);
}

main();
