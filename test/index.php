<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "_covid19";

// Establish a database connection
$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the selected option (1, 2, or 3 days)
$option = isset($_GET['option']) ? $_GET['option'] : 1; // Default to 1 day

// Calculate the start date based on the selected option
$currentTime = date("Y-m-d H:i:s");
$startDate = date("Y-m-d H:i:s", strtotime("-$option days", strtotime($currentTime)));

// Query to fetch data within the selected date range
$query = "SELECT * FROM reports WHERE report_timing >= '$startDate' AND report_timing <= '$currentTime'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Generate a CSV file for exporting the data
$filename = "$startDate _ $currentTime.csv";
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=$filename");

$output = fopen("php://output", "w");

// Add headers to the CSV file (modify as per your data structure)
fputcsv($output, array("Column1", "Column2", "Column3"));

// Fetch and write data to the CSV file
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close the database connection
mysqli_close($connection);
?>
