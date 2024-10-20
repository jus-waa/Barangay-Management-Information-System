<?php
    $servername='localhost';
    $db_port = '3306';
    try {
        $dbh = new PDO("mysql:host=$servername;dbname=db_mis;port=$db_port", 'root', '' );
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "success";
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        exit();
    }
?>