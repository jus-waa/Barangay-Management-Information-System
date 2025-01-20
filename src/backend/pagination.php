<?php
session_start();
include("connection.php");

// Get the current date
$currentDate = date('Y-m-d');

// Calculate the start of the week (Sunday)
if (date('l', strtotime($currentDate)) === 'Sunday') {
    $startOfWeek = $currentDate;
} else {
    $startOfWeek = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));
}

// Calculate the end of the week (Saturday)
if (date('l', strtotime($currentDate)) === 'Saturday') {
    $endOfWeek = $currentDate;
} else {
    $endOfWeek = date('Y-m-d', strtotime('next saturday', strtotime($currentDate)));
}

try {
    $records = 10;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $prevRecordPage = isset($_GET['prevRecordPage']) ? (int)$_GET['prevRecordPage'] : 1;
    $futureRecordPage = isset($_GET['futureRecordPage']) ? (int)$_GET['futureRecordPage'] : 1;

    $offset = ($page - 1) * $records;
    $prevRecordOffset = ($prevRecordPage - 1) * $records;
    $futureRecordOffset = ($futureRecordPage - 1) * $records;
    
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $prevSearch = isset($_GET['prevSearch']) ? $_GET['prevSearch'] : '';
    $futureSearch = isset($_GET['futureSearch']) ? $_GET['futureSearch'] : '';

    // Count total records based on the query
    if (empty($search)) {
        $total_sql = "SELECT COUNT(*) AS total FROM `resident_info`";
        $print_total_sql = "SELECT COUNT(*) AS print_total FROM `print_history` WHERE DATE(print_date) BETWEEN :startOfWeek AND :endOfWeek";
        
        $stmt_total = $dbh->prepare($total_sql);
        $print_stmt_total = $dbh->prepare($print_total_sql);
        $print_stmt_total->bindParam(':startOfWeek', $startOfWeek);
        $print_stmt_total->bindParam(':endOfWeek', $endOfWeek);
    } else {
        $total_sql = "SELECT COUNT(*) AS total
                    FROM `resident_info`
                    WHERE
                        first_name LIKE :search OR
                        middle_name LIKE :search OR
                        last_name LIKE :search";
        $print_total_sql = "SELECT COUNT(*) AS print_total
                            FROM `print_history` 
                            WHERE (
                                first_name LIKE :search OR
                                middle_name LIKE :search OR
                                last_name LIKE :search OR
                                suffix LIKE :search OR
                                print_date LIKE :search OR
                                control_number LIKE :search OR
                                document_type LIKE :search OR
                                issued_by LIKE :search
                            ) AND DATE(print_date) BETWEEN :startOfWeek AND :endOfWeek";

        $stmt_total = $dbh->prepare($total_sql);
        $stmt_total->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        
        $print_stmt_total = $dbh->prepare($print_total_sql);
        $print_stmt_total->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $print_stmt_total->bindParam(':startOfWeek', $startOfWeek);
        $print_stmt_total->bindParam(':endOfWeek', $endOfWeek);
    }

    // Handling prevSearch for previous page count
    if (empty($prevSearch)) {
        $prev_total_sql = "SELECT COUNT(*) AS prev_total FROM `print_history` WHERE DATE(print_date) < :startOfWeek ";
        $prev_stmt_total = $dbh->prepare($prev_total_sql);
        $prev_stmt_total->bindParam(':startOfWeek', $startOfWeek);
    } else {
        $prev_total_sql = "SELECT COUNT(*) AS prev_total
                            FROM `print_history`
                            WHERE (
                                first_name LIKE :prevSearch OR
                                middle_name LIKE :prevSearch OR
                                last_name LIKE :prevSearch OR
                                suffix LIKE :prevSearch OR
                                print_date LIKE :prevSearch OR
                                control_number LIKE :prevSearch OR
                                document_type LIKE :prevSearch OR
                                issued_by LIKE :prevSearch
                            ) AND DATE(print_date) < :startOfWeek";
        $prev_stmt_total = $dbh->prepare($prev_total_sql);
        $prev_stmt_total->bindValue(':prevSearch', '%' . $prevSearch . '%', PDO::PARAM_STR);
        $prev_stmt_total->bindParam(':startOfWeek', $startOfWeek);
    }

    // Handling futureSearch for future page count
    if (empty($futureSearch)) {
        $future_total_sql = "SELECT COUNT(*) AS future_total FROM `print_history` WHERE DATE(print_date) > :endOfWeek ";
        $future_stmt_total = $dbh->prepare($future_total_sql);
        $future_stmt_total->bindParam(':endOfWeek', $endOfWeek);
    } else {
        $future_total_sql = "SELECT COUNT(*) AS future_total
                            FROM `print_history`
                            WHERE (
                                first_name LIKE :futureSearch OR
                                middle_name LIKE :futureSearch OR
                                last_name LIKE :futureSearch OR
                                suffix LIKE :futureSearch OR
                                print_date LIKE :futureSearch OR
                                control_number LIKE :futureSearch OR
                                document_type LIKE :futureSearch OR
                                issued_by LIKE :futureSearch
                            ) AND DATE(print_date) > :endOfWeek";
        $future_stmt_total = $dbh->prepare($future_total_sql);
        $future_stmt_total->bindValue(':futureSearch', '%' . $futureSearch . '%', PDO::PARAM_STR);
        $future_stmt_total->bindParam(':endOfWeek', $endOfWeek);
    }

    // Execute the total counts
    $stmt_total->execute();
    $print_stmt_total->execute();
    $prev_stmt_total->execute();
    $future_stmt_total->execute();

    // Fetching total row count
    $total_row = $stmt_total->fetch(PDO::FETCH_ASSOC);
    $print_total_row = $print_stmt_total->fetch(PDO::FETCH_ASSOC);
    $prev_total_row = $prev_stmt_total->fetch(PDO::FETCH_ASSOC);
    $future_total_row = $future_stmt_total->fetch(PDO::FETCH_ASSOC);

    $total_records = $total_row['total']; // Total number of records for resident page
    $print_total_records = $print_total_row['print_total']; // Total number of records for print page this week
    $prev_total_records = $prev_total_row['prev_total']; // Total records for previous page this week
    $future_total_records = $future_total_row['future_total']; // Total records for previous page this week

    // Pagination calculations
    $total_pages = ceil($total_records / $records);
    $print_total_pages = ceil($print_total_records / $records);
    $prev_total_pages = ceil($prev_total_records / $records);
    $future_total_pages = ceil($future_total_records / $records);

    // fetch data based on query for resident and print history (current)
    if (empty($search)) {
        $stmt2 = $dbh->prepare("SELECT * FROM `resident_info` LIMIT :limit OFFSET :offset");
        $stmt3 = $dbh->prepare("SELECT * FROM `print_history` WHERE DATE(print_date) BETWEEN :startOfWeek AND :endOfWeek LIMIT :limit OFFSET :offset");

        $stmt2->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt2->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt3->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt3->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt3->bindParam(':startOfWeek', $startOfWeek);
        $stmt3->bindParam(':endOfWeek', $endOfWeek);
    } else {
        $stmt2 = $dbh->prepare("SELECT * FROM `resident_info`
                                WHERE 
                                    first_name LIKE :search OR
                                    middle_name LIKE :search OR
                                    last_name LIKE :search
                                LIMIT :limit OFFSET :offset");
        $stmt3 = $dbh->prepare("SELECT * FROM `print_history`
                                WHERE (
                                    first_name LIKE :search OR
                                    middle_name LIKE :search OR
                                    last_name LIKE :search OR
                                    suffix LIKE :search OR
                                    print_date LIKE :search OR
                                    control_number LIKE :search OR
                                    document_type LIKE :search OR
                                    issued_by LIKE :search
                                ) AND DATE(print_date) BETWEEN :startOfWeek AND :endOfWeek LIMIT :limit OFFSET :offset");

        $stmt2->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt2->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt2->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt3->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt3->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt3->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt3->bindParam(':startOfWeek', $startOfWeek);
        $stmt3->bindParam(':endOfWeek', $endOfWeek);
    }
    // fetch data based on query for print history (previous)
    if (empty($prevSearch)) {
        $stmt4 = $dbh->prepare("SELECT * FROM `print_history` WHERE DATE(print_date) < :startOfWeek LIMIT :limit OFFSET :offset"); 
        $stmt4->bindParam(':startOfWeek', $startOfWeek);
        $stmt4->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt4->bindParam(':offset', $prevRecordOffset, PDO::PARAM_INT);
    } else {
        $stmt4 = $dbh->prepare("SELECT * FROM `print_history`
                                WHERE (
                                    first_name LIKE :prevSearch OR
                                    middle_name LIKE :prevSearch OR
                                    last_name LIKE :prevSearch OR
                                    suffix LIKE :prevSearch OR
                                    print_date LIKE :prevSearch OR
                                    control_number LIKE :prevSearch OR
                                    document_type LIKE :prevSearch OR
                                    issued_by LIKE :prevSearch
                                ) AND DATE(print_date) < :startOfWeek LIMIT :limit OFFSET :offset");
        $stmt4->bindValue(':prevSearch', '%' . $prevSearch . '%', PDO::PARAM_STR);
        $stmt4->bindParam(':startOfWeek', $startOfWeek);
        $stmt4->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt4->bindParam(':offset', $prevRecordOffset, PDO::PARAM_INT);
    }
    // fetch data based on query for print history (future)
    if (empty($futureSearch)) {
        $stmt5 = $dbh->prepare("SELECT * FROM `print_history` WHERE DATE(print_date) > :endOfWeek LIMIT :limit OFFSET :offset"); 
        $stmt5->bindParam(':endOfWeek', $endOfWeek);
        $stmt5->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt5->bindParam(':offset', $futureRecordOffset, PDO::PARAM_INT);
    } else {
        $stmt5 = $dbh->prepare("SELECT * FROM `print_history`
                                WHERE (
                                    first_name LIKE :futureSearch OR
                                    middle_name LIKE :futureSearch OR
                                    last_name LIKE :futureSearch OR
                                    suffix LIKE :futureSearch OR
                                    print_date LIKE :futureSearch OR
                                    control_number LIKE :futureSearch OR
                                    document_type LIKE :futureSearch OR
                                    issued_by LIKE :futureSearch
                                    ) AND DATE(print_date) > :endOfWeek LIMIT :limit OFFSET :offset");
        $stmt5->bindValue(':futureSearch', '%' . $futureSearch . '%', PDO::PARAM_STR);
        $stmt5->bindParam(':endOfWeek', $endOfWeek);
        $stmt5->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt5->bindParam(':offset', $futureRecordOffset, PDO::PARAM_INT);
    }

    // Execute the final queries
    $stmt2->execute();
    $stmt3->execute();
    $stmt4->execute();
    $stmt5->execute();
    
    // Fetch results
    $searchResult = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $printSearchResult = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    $prevSearchResult = $stmt4->fetchAll(PDO::FETCH_ASSOC);
    $futureSearchResult = $stmt5->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
