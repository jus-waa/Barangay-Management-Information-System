<?php
include("connection.php");
//for resident info
$stmt = $dbh->prepare("SELECT * FROM `resident_info`");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//total Residents
$totalRes = 0;

//gender breakdown
$male = 0;
$female = 0;

//status
$active = 0;
$inactive = 0;

$household = 0;

//residency type
$permanent = 0;
$temporary = 0;
$student = 0;

//age brackets
$infant = 0;
$toddler = 0;
$child = 0;
$teenager = 0;
$youngAdult = 0;
$middleAgedAdult = 0;
$seniorAdult = 0;

//civil status
$single = 0;
$married = 0;
$divorced = 0;
$separated = 0;
$widowed = 0;

//blood types
$a_plus = 0;
$b_plus = 0;
$ab_plus = 0;
$o_plus = 0;
$a_minus = 0;
$b_minus = 0;
$ab_minus = 0;
$o_minus = 0;
foreach ($result as $row) {
    // for total residents
    $totalRes++;
    if (strtolower($row['gender']) == 'male') {
        $male++;
    } else if (strtolower($row['gender']) == 'female') {
        $female++;
    }
    
    // for active residents
    if (strtolower($row['status']) == 'active') {
        $active++;
    } else if (strtolower($row['status']) == 'inactive') {
        $inactive++;
    }
    
    // for residency type
    if (strtolower($row['residency_type']) == 'permanent') {
        $permanent++;
    } else if (strtolower($row['residency_type']) == 'temporary') {
        $temporary++;
    } else if (strtolower($row['residency_type']) == 'student') {
        $student++;
    }
    
    // for age bracket
    if ($row['age'] >= 0 && $row['age'] <= 1) {
        $infant++;
    } else if ($row['age'] >= 2 && $row['age'] <= 4) {
        $toddler++; 
    } else if ($row['age'] >= 5 && $row['age'] <= 12) {
        $child++;
    } else if ($row['age'] >= 13 && $row['age'] <= 19) {
        $teenager++;
    } else if ($row['age'] >= 20 && $row['age'] <= 39) {
        $youngAdult++;
    } else if ($row['age'] >= 40 && $row['age'] <= 59) {
        $middleAgedAdult++;
    } else if ($row['age'] >= 60) {
        $seniorAdult++;
    }
    
    // for civil status
    if (strtolower($row['civil_status']) == "single") {
        $single++;
    } else if (strtolower($row['civil_status']) == "married") {
        $married++;
    } else if (strtolower($row['civil_status']) == "divorced") {
        $divorced++;
    } else if (strtolower($row['civil_status']) == "separated") {
        $separated++;
    } else if (strtolower($row['civil_status']) == "widowed") {
        $widowed++;
    }
    
    // for blood types 
    if (strtolower($row['blood_type']) == "a+") {
        $a_plus++;
    } else if (strtolower($row['blood_type']) == "b+") {
        $b_plus++;
    } else if (strtolower($row['blood_type']) == "ab+") {
        $ab_plus++;
    } else if (strtolower($row['blood_type']) == "o+") {
        $o_plus++;
    } else if (strtolower($row['blood_type']) == "a-") {
        $a_minus++;
    } else if (strtolower($row['blood_type']) == "b-") {
        $b_minus++;
    } else if (strtolower($row['blood_type']) == "ab-") {
        $ab_minus++;
    } else if (strtolower($row['blood_type']) == "o-") {
        $o_minus++;
    }
}
$maleJSON = json_encode($male); 
$femaleJSON = json_encode($female);

$infantJSON = json_encode($infant);
$toddlerJSON = json_encode($toddler);
$childJSON = json_encode($child);
$teenagerJSON = json_encode($teenager);
$youngAdultJSON = json_encode($youngAdult);
$middleAgedAdultJSON = json_encode($middleAgedAdult);
$seniorAdultJSON = json_encode($seniorAdult);

$totalResJSON = json_encode($totalRes);


//House Hold
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
$totalHouseHold = $arr_length - $household;
//for checking
/*
if (!empty($duplicates)) {
    foreach ($duplicates as $duplicate) {
        echo "{$duplicate['house_num']} is a duplicate and appears {$duplicate['count']} times.<br>";
    }
} else {
    echo "No duplicates found.";
}
*/

//Documents Breakdown
$stmt = $dbh->prepare("SELECT * FROM `print_history`");
$stmt->execute();
$result_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
//from print history
$totalDocs = 0; //total number of printed docs
$brgyclr = 0;
$certIndigency = 0;
$certResidency = 0;
foreach ($result_history as $rows) {
    $totalDocs++;
    if($rows['document_type'] === 'Barangay Clearance') {
        $brgyclr++;
    } else if ($rows['document_type'] === 'Certificate of Indigency') {
        $certIndigency++;
    } else if ($rows['document_type'] === 'Certificate of Residency') {
        $certResidency++;
    }
}
$totalDocsJson = json_encode($totalDocs);
// Document Issuance Data
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
//fetch document counts by day of the week
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