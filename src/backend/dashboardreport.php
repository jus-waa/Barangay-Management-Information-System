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
$household = 0;
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
//Check for duplcates (household)
$house_nums = [];
foreach ($result as $row) {
    $house_nums[] = $row['house_num'];
}

$arr_length = count($house_nums);

// Track occurrences of each house number
$house_count = [];
for ($i = 0; $i < $arr_length; $i++) {
    if (isset($house_count[$house_nums[$i]])) {
        $house_count[$house_nums[$i]]++;  // Increment count if already in the array
    } else {
        $house_count[$house_nums[$i]] = 1;  // Initialize count if first time encountering
    }
}

// Track duplicates and display with count
$duplicates = [];
foreach ($house_count as $house_num => $count) {
    if ($count > 1) {  // Check if count is more than 1, which means it's a duplicate
        $duplicates[] = ["house_num" => $house_num, "count" => $count];
    }
}

$household = 0;

if (!empty($duplicates)) {
    foreach ($duplicates as $duplicate) {
        if(($duplicate['house_num'] != null) || ($duplicate['house_num'] == '')) {
            $household++;
        } 
    }
    //echo $household . "<br>";
} 

/*
if (!empty($duplicates)) {
    foreach ($duplicates as $duplicate) {
        echo "{$duplicate['house_num']} is a duplicate and appears {$duplicate['count']} times.<br>";
    }
} else {
    echo "No duplicates found.";
}
*/
$maleJSON = json_encode($male); 
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
$brgyclrJSON = json_encode($brgyclr); 

// Get the current date
$currentDate = date('Y-m-d');

// start of the week (Sunday) and end of the week (Saturday)\
if (date('l', strtotime($currentDate)) === 'Sunday') {
    $startOfWeek = $currentDate;
} else {
    $startOfWeek = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));
}

if (date('l', strtotime($currentDate)) === 'Saturday') {
    $endOfWeek = $currentDate;
} else {
    $endOfWeek = date('Y-m-d', strtotime('next saturday', strtotime($currentDate)));
}

//  SQL query to fetch document counts by day of the week
$sql = "SELECT DAYOFWEEK(print_date) AS day_of_week, COUNT(*) AS documents_count
        FROM print_history
        WHERE DATE(print_date) BETWEEN :startOfWeek AND :endOfWeek
        GROUP BY day_of_week";


$stmt = $dbh->prepare($sql);
$stmt->bindParam(':startOfWeek', $startOfWeek);
$stmt->bindParam(':endOfWeek', $endOfWeek);
$stmt->execute();

// array for storing document counts for each day
$documentCounts = array_fill(0, 7, 0); // Default 0 for each day

// Fetch the results and update the document counts array
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dayIndex = $row['day_of_week'] - 1; // MySQL DAYOFWEEK() returns 1 for Sunday, 7 for Saturday
    $documentCounts[$dayIndex] = $row['documents_count'];
}
?>