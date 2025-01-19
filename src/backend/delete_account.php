<?php
include("connection.php");
    try{
        $id = $_GET["id"];
        $query = "DELETE FROM users WHERE `id` = :id";
        $stmt = $dbh->prepare($query);
        $stmt->execute(['id' => $id]);
        if($stmt) {
            $sql = "ALTER TABLE `users` AUTO_INCREMENT=1";
            $sth = $dbh->prepare($sql);
            $sth->execute();
            header("location: ../accountmanagement.php?msg= account removed successfully");
        } else {
            echo "Error: " . $e->getMessage();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }//
?>