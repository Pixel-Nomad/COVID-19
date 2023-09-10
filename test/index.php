<?php
// Include the PhpSpreadsheet classes
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = '_covid19';

// Connect to the database
$mysqli = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// SQL query to fetch data from the database (modify this query as per your needs)
$sql = "SELECT * FROM reports";
$result = $mysqli->query($sql);

// Create a new PhpSpreadsheet instance
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add headers to the Excel file
$columnIndex = 'A';
$headers = ['report_id', 'report_timing', 'type']; // Replace with your column names
foreach ($headers as $header) {
    $sheet->setCellValue($columnIndex . '1', $header);
    $columnIndex++;
}

// Fetch data from the database and add it to the Excel file
$rowIndex = 2; // Start from row 2 after headers
while ($row = $result->fetch_assoc()) {
    $columnIndex = 'A';
    foreach ($row as $column) {
        $sheet->setCellValue($columnIndex . $rowIndex, $column);
        $columnIndex++;
    }
    $rowIndex++;
}

// Create a writer for Excel (XLSX)
$writer = new Xlsx($spreadsheet);
$filename = 'exported_data.xlsx'; // Specify the desired filename

// Set the appropriate headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Output the file to the browser
$writer->save('php://output');

// Close the database connection
$mysqli->close();
?>
