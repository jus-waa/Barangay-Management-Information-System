<?php
session_start();
include("connection.php");
//for resident info
$stmt = $dbh->prepare("SELECT * FROM `resident_info`");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//from resident info
$i = 0;
$male = 0;
$female = 0;
$active = 0;
$inactive = 0;
foreach ($result as $row) {
    // for total residents
    $i++;
    // for no. of male and female
    if ($row['gender'] == 'Male') {
        $male++;
    } else if ($row['gender'] == 'Female') {
        $female++;
    }
    // for active residents
    if ($row['status'] == 'Active') {
        $active++;
    } else if ($row['status'] == 'Inactive') {
        $inactive++;
    }
}
$maleJSON = json_encode($male); // convert into JSON
$femaleJSON = json_encode($female);

//for print history
$stmt = $dbh->prepare("SELECT * FROM `print_history`");
$stmt->execute();
$result_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
//from print history
$n = 0; //total number of printed docs
$brgyclr = 0;
foreach ($result_history as $rows) {
    $n++;
    //for no of brgy clearance
    if($rows['document_type'] === 'Barangay Clearance') {
        $brgyclr++;
    }
}
$brgyclrJSON = json_encode($brgyclr); // convert into JSON

// Get the current date
$currentDate = date('Y-m-d');
    
// Get the start of the week (Sunday) and end of the week (Saturday)
$startOfWeek = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));
$endOfWeek = date('Y-m-d', strtotime('next saturday', strtotime($currentDate)));

// Prepare the SQL query to fetch document counts by day of the week
$sql = "SELECT DAYOFWEEK(print_date) AS day_of_week, COUNT(*) AS documents_count
        FROM print_history
        WHERE print_date BETWEEN :startOfWeek AND :endOfWeek
        GROUP BY day_of_week";

// Prepare the statement
$stmt = $dbh->prepare($sql);

// Bind parameters
$stmt->bindParam(':startOfWeek', $startOfWeek);
$stmt->bindParam(':endOfWeek', $endOfWeek);

// Execute the statement
$stmt->execute();

// Initialize an array for storing document counts for each day
$documentCounts = array_fill(0, 7, 0); // Default 0 for each day

// Fetch the results and update the document counts array
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dayIndex = $row['day_of_week'] - 1; // MySQL DAYOFWEEK() returns 1 for Sunday, 7 for Saturday
    $documentCounts[$dayIndex] = $row['documents_count'];
}
?>