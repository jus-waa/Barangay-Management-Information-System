<?php
include("connection.php");
    try{
        $id = $_GET["id"];
        $query = "DELETE FROM resident_info WHERE `id` = :id";
        $stmt = $dbh->prepare($query);
        $stmt->execute(['id' => $id]);
        if($stmt) {
            $sql = "ALTER TABLE `resident_info` AUTO_INCREMENT=1";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            header("location: ../residentpage.php?msg= data removed successfully");
        } else {
            echo "Error: " . $e->getMessage();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>