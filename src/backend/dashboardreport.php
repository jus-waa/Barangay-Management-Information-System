<?php
include("connection.php");
//Display 1. Population overview and 3. community metrics
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
$activeJSON = json_encode($active);
//for household computation
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
$totalHouseHoldJSON = json_encode($totalHouseHold);
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
//end of display popu overview and community metrics



//Documents breakdown
$stmt = $dbh->prepare("SELECT * FROM `print_history`");
$stmt->execute();
$result_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
//from print history
$totalDocs = 0;
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
//end of documents breakdown
// 2. Document Issuance Data
//Global Values
date_default_timezone_set('Asia/Manila');
$currentDate = date('Y-m-d');
//$currentDate = '2025-1-13'; test for prev week
$currentFormatDate = new DateTime();
$formattedDate = $currentFormatDate->format('F d, Y, g:i A');
// Flter for weeks =============================================================================================
// Get the day of the week (1 = Monday, 7 = Sunday in PHP)
$dayOfWeek = date("w", strtotime($currentDate)); // 0 = Sunday, 6 = Saturday
// Get the start and end of the current week (Sunday to Saturday)
$startOfWeek = date('Y-m-d', strtotime($currentDate . ' -' . $dayOfWeek . ' days'));
$endOfWeek = date('Y-m-d', strtotime($startOfWeek . ' +6 days'));

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
//to display current dates of the week
$sundayCurrentWeek = $startOfWeek;
$mondayCurrentWeek = date('Y-m-d', strtotime($startOfWeek . ' +1 day'));
$tuesdayCurrentWeek = date('Y-m-d', strtotime($startOfWeek . ' +2 days'));
$wednesdayCurrentWeek = date('Y-m-d', strtotime($startOfWeek . ' +3 days'));
$thursdayCurrentWeek = date('Y-m-d', strtotime($startOfWeek . ' +4 days'));
$fridayCurrentWeek = date('Y-m-d', strtotime($startOfWeek . ' +5 days'));
$saturdayCurrentWeek = $endOfWeek;

$sundayJson = json_encode($sundayCurrentWeek);
$mondayJson = json_encode($mondayCurrentWeek);
$tuesdayJson = json_encode($tuesdayCurrentWeek);
$wednesdayJson = json_encode($wednesdayCurrentWeek);
$thursdayJson = json_encode($thursdayCurrentWeek);
$fridayJson = json_encode($fridayCurrentWeek);
$saturdayJson = json_encode($saturdayCurrentWeek);
// Get the total document count for the week
$sqlTotalWeekly = "SELECT COUNT(*) AS total_documents 
                   FROM print_history 
                   WHERE DATE(print_date) BETWEEN :startOfWeek AND :endOfWeek";

$stmtTotalWeekly = $dbh->prepare($sqlTotalWeekly);
$stmtTotalWeekly->bindParam(':startOfWeek', $startOfWeek);
$stmtTotalWeekly->bindParam(':endOfWeek', $endOfWeek);
$stmtTotalWeekly->execute();
$totalWeeklyDocuments = $stmtTotalWeekly->fetchColumn(); // Fetch total count
// Get document counts by type for the current week
$sqlDocTypesWeekly = 'SELECT document_type, COUNT(*) AS count 
                      FROM print_history 
                      WHERE DATE(print_date) BETWEEN :startOfWeek AND :endOfWeek 
                      GROUP BY document_type';

$stmtDocTypesWeekly = $dbh->prepare($sqlDocTypesWeekly);
$stmtDocTypesWeekly->bindParam(':startOfWeek', $startOfWeek);
$stmtDocTypesWeekly->bindParam(':endOfWeek', $endOfWeek);
$stmtDocTypesWeekly->execute();
$resultDocTypes = $stmtDocTypesWeekly->fetchAll(PDO::FETCH_ASSOC);

// Initialize counts
$docTypeCounts = [
    'Barangay Clearance' => 0,
    'Certificate of Indigency' => 0,
    'Certificate of Residency' => 0
];

// Assign values from the query result
foreach ($resultDocTypes as $row) {
    $docTypeCounts[$row['document_type']] = $row['count'];
}

// Assign values to variables
$brgyclrWeekly = $docTypeCounts['Barangay Clearance'];
$certIndigencyWeekly = $docTypeCounts['Certificate of Indigency'];
$certResidencyWeekly = $docTypeCounts['Certificate of Residency'];
//filter for months ==============================================================================================
// Get the current month and year
$currentYear = date('Y');
$currentMonth = date('m');
// Get the first and last day of the month
$firstDayOfMonth = date('Y-m-01');
$lastDayOfMonth = date('Y-m-t');
// Find the total number of weeks in the month
$weeks = [];
$firstDayWeekday = date('w', strtotime($firstDayOfMonth)); // 0 = Sunday, 6 = Saturday

if ($firstDayWeekday != 0) {
    // If the month does NOT start on a Sunday, count the first few days as Week 1
    $firstWeekEnd = strtotime('next saturday', strtotime($firstDayOfMonth));

    if ($firstWeekEnd > strtotime($lastDayOfMonth)) {
        $firstWeekEnd = strtotime($lastDayOfMonth);
    }

    $weeks[] = [
        'start' => $firstDayOfMonth,
        'end' => date('Y-m-d', $firstWeekEnd)
    ];

    // Move to the first Sunday after these initial days
    $startOfWeekMonthly = strtotime('+1 day', $firstWeekEnd);
} else {
    // If the month starts on a Sunday, begin counting weeks normally
    $startOfWeekMonthly = strtotime($firstDayOfMonth);
}

// Iterate through the weeks of the month
while ($startOfWeekMonthly <= strtotime($lastDayOfMonth)) {
    $endOfWeekMonthly = strtotime('next saturday', $startOfWeekMonthly);
    
    if ($endOfWeekMonthly > strtotime($lastDayOfMonth)) {
        $endOfWeekMonthly = strtotime($lastDayOfMonth);
    }

    $weeks[] = [
        'start' => date('Y-m-d', $startOfWeekMonthly),
        'end' => date('Y-m-d', $endOfWeekMonthly)
    ];

    $startOfWeekMonthly = strtotime('+1 week', $startOfWeekMonthly);
}
// Fetch document counts per week
$weeklyCounts = [];
foreach ($weeks as $index => $week) {
    $sql = "SELECT COUNT(*) AS documents_count 
            FROM print_history 
            WHERE DATE(print_date) BETWEEN :startOfWeek AND :endOfWeek";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':startOfWeek', $week['start']);
    $stmt->bindParam(':endOfWeek', $week['end']);
    $stmt->execute();
    
    $resultWeek = $stmt->fetch(PDO::FETCH_ASSOC);
    $weeklyCounts[] = $resultWeek['documents_count'] ?? 0;
}
$totalDocsMonth = array_sum($weeklyCounts);
$weeksJson = json_encode(array_map(fn($week) => $week['start'] . ' - ' . $week['end'], $weeks));
$weeklyCountsJson = json_encode($weeklyCounts);
//filter quarterly =============================================================================================
$currentYear = date('Y');
$currentMonth = date('m');

// Store results per month
$monthlyCounts = [];
$monthNames = [];
// Loop through the last 3 months (including the current one)
for ($i = 2; $i >= 0; $i--) {
    $monthStart = date('Y-m-01', strtotime("-$i months"));
    $monthEnd = date('Y-m-t', strtotime("-$i months"));
    $year = date('Y', strtotime("-$i months"));
    $monthName = date('F', strtotime($monthStart)); 

    $sqlQuarterly = "SELECT COUNT(*) AS documents_count 
            FROM print_history 
            WHERE DATE(print_date) BETWEEN :startDate AND :endDate";

    $stmtQuarterly = $dbh->prepare($sqlQuarterly);
    $stmtQuarterly->bindParam(':startDate', $monthStart);
    $stmtQuarterly->bindParam(':endDate', $monthEnd);
    $stmtQuarterly->execute();

    $resultQuarterly = $stmtQuarterly->fetch(PDO::FETCH_ASSOC);
    //STore month name and count 
    $months[] = $monthName . ' ' . $year;
    $monthlyCounts[] = $resultQuarterly['documents_count'] ?? 0; 
}
$totalDocsQuarterly = array_sum($monthlyCounts);
$monthsJson = json_encode($months);
$monthlyCountsJson = json_encode($monthlyCounts);
//filter for annually ==========================================================================================
$monthlyCountsAnnually = [];
$monthsAnnually = [];

// Loop through the last 3 months (including the current one)
for ($i = 1; $i <= 12; $i++) {
    $monthStartAnnually = date("$currentYear-$i-01", strtotime("-$i months"));
    $monthEndAnnually = date("$currentYear-$i-t", strtotime("-$i months"));

    $monthNameAnnually = date('F', strtotime($monthStartAnnually)); 

    $sqlAnnually = "SELECT COUNT(*) AS documents_count_annually 
            FROM print_history 
            WHERE DATE(print_date) BETWEEN :startDate AND :endDate";

    $stmtAnnually = $dbh->prepare($sqlAnnually);
    $stmtAnnually->bindParam(':startDate', $monthStartAnnually);
    $stmtAnnually->bindParam(':endDate', $monthEndAnnually);
    $stmtAnnually->execute();

    $resultAnnually = $stmtAnnually->fetch(PDO::FETCH_ASSOC);
    //STore month name and count 
    $monthsAnnually[] = $monthNameAnnually . ' ' . $year;
    $monthlyCountsAnnually[] = $resultAnnually['documents_count_annually'] ?? 0; 
}
$totalDocsAnnually = array_sum($monthlyCountsAnnually);
$monthsAnnuallyJson = json_encode($monthsAnnually);
$monthlyCountsAnnuallyJson = json_encode($monthlyCountsAnnually);



// Filter purok for 1. popu overview and 3. community metrics
// Purok type filter total residents
$purokType = isset($_GET['purokType']) ? $_GET['purokType'] : 'Overall'; // Global overall as default

if (isset($_GET['purokType'])) {
    $purokType = $_GET['purokType'];
    if ($purokType === 'Overall') {
        $stmt = $dbh->prepare('SELECT COUNT(*) AS total FROM `resident_info`');
    } else {
        $stmt = $dbh->prepare('SELECT COUNT(*) AS total FROM `resident_info` WHERE `purok` = :purok');
        $stmt->bindValue(':purok', $purokType, PDO::PARAM_STR);
    }
    $stmt->execute();
    $totalRes = $stmt->fetchColumn();
}

// Purok type filter total household
$selectedPurok = isset($_GET['purokType']) ? $_GET['purokType'] : 'Overall';

$household_per_purok = [];

foreach ($result as $row) {
    $purok = $row['purok']; // Ensure 'purok' exists in your database
    $house_num = $row['house_num'];

    if (!isset($household_per_purok[$purok])) {
        $household_per_purok[$purok] = [];
    }
    $household_per_purok[$purok][] = $house_num;
}

$totalHouseHoldPerPurok = [];

foreach ($household_per_purok as $purok => $house_nums) {
    $house_count = [];
    $household = 0;

    foreach ($house_nums as $house_num) {
        if (isset($house_count[$house_num])) {
            $house_count[$house_num]++;
        } else {
            $house_count[$house_num] = 1;
        }
    }

    foreach ($house_count as $house_num => $count) {
        if ($count > 1 && ($house_num !== null && $house_num !== '')) {
            $household++;
        }
    }

    $totalHouseHoldPerPurok[$purok] = count($house_nums) - $household;
}

// Purok type filter total active
if ($purokType === 'Overall') {
    $stmt = $dbh->prepare('SELECT COUNT(*) AS total FROM `resident_info` WHERE `status` = "Active"');
} else {
    $stmt = $dbh->prepare('SELECT COUNT(*) AS total FROM `resident_info` WHERE `purok` = :purok AND `status` = "Active"');
    $stmt->bindValue(':purok', $purokType, PDO::PARAM_STR);
}
$stmt->execute();
$totalActiveRes = $stmt->fetchColumn(); 

// Purok type filter total resident type
$types = ['Permanent', 'Temporary', 'Student'];
$counts = [];

foreach ($types as $type) {
    if ($purokType === 'Overall') {
        $stmt = $dbh->prepare('SELECT COUNT(*) AS total FROM `resident_info` WHERE `residency_type` = :residentType');
    } else {
        $stmt = $dbh->prepare('SELECT COUNT(*) AS total FROM `resident_info` WHERE `residency_type` = :residentType AND `purok` = :purokType');
        $stmt->bindValue(':purokType', $purokType, PDO::PARAM_STR);
    }
    $stmt->bindValue(':residentType', $type, PDO::PARAM_STR);
    $stmt->execute();
    $counts[$type] = $stmt->fetchColumn();
}

// Assign counts to variables
$permanent = $counts['Permanent'] ?? 0;
$temporary = $counts['Temporary'] ?? 0;
$student = $counts['Student'] ?? 0;

// Purok type filter age group brackets
if ($purokType === 'Overall') {
    $stmt = $dbh->prepare('SELECT `age` FROM `resident_info`');
} else {
    $stmt = $dbh->prepare('SELECT `age` FROM `resident_info` WHERE `purok` = :purok');
    $stmt->bindValue(':purok', $purokType, PDO::PARAM_STR);
}
$stmt->execute();
$residentAges = $stmt->fetchAll(PDO::FETCH_ASSOC);

$infant = $toddler = $child = $teenager = $youngAdult = $middleAgedAdult = $seniorAdult = 0;

foreach ($residentAges as $rowAge) {
    if ($rowAge['age'] >= 0 && $rowAge['age'] <= 1) {
        $infant++;
    } else if ($rowAge['age'] >= 2 && $rowAge['age'] <= 4) {
        $toddler++; 
    } else if ($rowAge['age'] >= 5 && $rowAge['age'] <= 12) {
        $child++;
    } else if ($rowAge['age'] >= 13 && $rowAge['age'] <= 19) {
        $teenager++;
    } else if ($rowAge['age'] >= 20 && $rowAge['age'] <= 39) {
        $youngAdult++;
    } else if ($rowAge['age'] >= 40 && $rowAge['age'] <= 59) {
        $middleAgedAdult++;
    } else if ($rowAge['age'] >= 60) {
        $seniorAdult++;
    }
}
$infantJSON = json_encode($infant);
$toddlerJSON = json_encode($toddler);
$childJSON = json_encode($child);
$teenagerJSON = json_encode($teenager);
$youngAdultJSON = json_encode($youngAdult);
$middleAgedAdultJSON = json_encode($middleAgedAdult);
$seniorAdultJSON = json_encode($seniorAdult);
$totalResJSON = json_encode($totalRes);

// Purok type filter gender
if ($purokType === 'Overall') {
    $stmt = $dbh->prepare('SELECT `gender` FROM `resident_info`');
} else {
    $stmt = $dbh->prepare('SELECT `gender` FROM `resident_info` WHERE `purok` = :purok');
    $stmt->bindValue(':purok', $purokType, PDO::PARAM_STR);
}
$stmt->execute();
$residentGenders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$male = 0;
$female = 0;

foreach ($residentGenders as $rowGender) {
    if (strtolower($rowGender['gender']) == 'male') {
        $male++;
    } else if (strtolower($rowGender['gender']) == 'female') {
        $female++;
    }
}
$maleJSON = json_encode($male); 
$femaleJSON = json_encode($female);

// Purok type filter civil status
if ($purokType === 'Overall') {
    $stmt = $dbh->prepare('SELECT `civil_status` FROM `resident_info`');
} else {
    $stmt = $dbh->prepare('SELECT `civil_status` FROM `resident_info` WHERE `purok` = :purok');
    $stmt->bindValue(':purok', $purokType, PDO::PARAM_STR);
}
$stmt->execute();
$residentCivilStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);

$single = 0;
$married = 0;
$divorced = 0;
$separated = 0;
$widowed = 0;

foreach ($residentCivilStatus as $rowCivil) {
    if (strtolower($rowCivil['civil_status']) == "single") {
        $single++;
    } else if (strtolower($rowCivil['civil_status']) == "married") {
        $married++;
    } else if (strtolower($rowCivil['civil_status']) == "divorced") {
        $divorced++;
    } else if (strtolower($rowCivil['civil_status']) == "separated") {
        $separated++;
    } else if (strtolower($rowCivil['civil_status']) == "widowed") {
        $widowed++;
    }
}

// Purok type filter Blood type
if ($purokType === 'Overall') {
    $stmt = $dbh->prepare('SELECT `blood_type` FROM `resident_info`');
} else {
    $stmt = $dbh->prepare('SELECT `blood_type` FROM `resident_info` WHERE `purok` = :purok');
    $stmt->bindValue(':purok', $purokType, PDO::PARAM_STR);
}
$stmt->execute();
$residentBloodType = $stmt->fetchAll(PDO::FETCH_ASSOC);

$a_plus = 0;
$b_plus = 0;
$ab_plus = 0;
$o_plus = 0;
$a_minus = 0;
$b_minus = 0;
$ab_minus = 0;
$o_minus = 0;

foreach ($residentBloodType as $rowBlood) {
    if (strtolower($rowBlood['blood_type']) == "a+") {
        $a_plus++;
    } else if (strtolower($rowBlood['blood_type']) == "b+") {
        $b_plus++;
    } else if (strtolower($rowBlood['blood_type']) == "ab+") {
        $ab_plus++;
    } else if (strtolower($rowBlood['blood_type']) == "o+") {
        $o_plus++;
    } else if (strtolower($rowBlood['blood_type']) == "a-") {
        $a_minus++;
    } else if (strtolower($rowBlood['blood_type']) == "b-") {
        $b_minus++;
    } else if (strtolower($rowBlood['blood_type']) == "ab-") {
        $ab_minus++;
    } else if (strtolower($rowBlood['blood_type']) == "o-") {
        $o_minus++;
    }
}
?>