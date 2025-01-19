<?php
session_start();
include("connection.php");
//pagination & search
try {
    $records = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $records;
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    //count total records based on based query
    if (empty($search)) {
        $total_sql = "SELECT COUNT(*) AS total FROM `resident_info`";
        $stmt_total = $dbh->prepare($total_sql);
    } else {
        $total_sql = "SELECT COUNT(*) AS total FROM `resident_info` WHERE first_name LIKE :search";
        $stmt_total = $dbh->prepare($total_sql);
        $stmt_total->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    }//
    $stmt_total->execute();
    $total_row = $stmt_total->fetch(PDO::FETCH_ASSOC);
    $total_records = $total_row['total']; // Total number of records
    $total_pages = ceil($total_records / $records); // Total number of pages
    //fetch based on query
    if (empty($search)) {
        $stmt2 = $dbh->prepare("SELECT * FROM `resident_info` LIMIT :limit OFFSET :offset");
        $stmt2->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt2->bindParam(':offset', $offset, PDO::PARAM_INT);
    } else {
        $stmt2 = $dbh->prepare("SELECT * FROM `resident_info` WHERE first_name LIKE :search LIMIT :limit OFFSET :offset");
        $stmt2->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
        $stmt2->bindParam(':limit', $records, PDO::PARAM_INT);
        $stmt2->bindParam(':offset', $offset, PDO::PARAM_INT);
    }
    $stmt2->execute();
    $searchResult = $stmt2->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>