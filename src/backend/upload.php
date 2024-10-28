<?php 
$file_name = $_FILES["file"]["tmp_name"];
if(empty($file_name)) {
    echo "<div class=error_message> Upload File.</div>";
    exit();
}
include_once("connection.php");
$i = 0;
if($_FILES["file"]["size"] > 0) {
    $file = fopen($file_name, "r");
    while(($data = fgetcsv($file, 10000, ",")) !== FALSE) {
        $i++;
        $query = "INSERT INTO `resident_info`(`first_name`, `middle_name`, `last_name`, `suffix`, `age`, `address`, `sex`, `birth_date`, `birth_place`, `civil_status`, `citizenship`, `occupation`) 
                VALUES (:first_name, :middle_name, :last_name, :suffix, :age, :address, :sex , :birth_date , :birth_place , :civil_status , :citizenship, :occupation)";
        $stmt = $dbh->prepare($query);
        try {
            $stmt->execute([
                "first_name" => $data[0],
                "middle_name" => $data[1],
                "last_name" => $data[2],
                "suffix" => $data[3],
                "age" => (int)$data[4], // Cast to integer for age
                "address" => $data[5],
                "sex" => $data[6],
                "birth_date" => $data[7],
                "birth_place" => $data[8],
                "civil_status" => $data[9],
                "citizenship" => $data[10],
                "occupation" => $data[11]
            ]);
            $rowCount = $stmt->rowCount(); // Increment rowCount
        } catch (PDOException $e) {
            echo "Error on row $i: " . $e->getMessage() . "<br/>";
        }
    }
    fclose($file);
    ?>
    <div class="success_message">
        Data Uploaded Successfully
    <?php 
    if($rowCount > 0) {
        echo "<br/>". number_format($i)." rows inserted";
    ?>
    </div>
    <script>
        let form = document.querySelector("form");
        form.style.display = 'none';
    </script>
    <?php 
        } else {
        echo 'Nothing was inserted';
        } 
    }else {
        echo "Invalid file. This only accepts CSV file format.";
    }
?>