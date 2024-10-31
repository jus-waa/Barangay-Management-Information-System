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
            $stmt->bindParam(':first_name', $data[0]);
            $stmt->bindParam(':middle_name', $data[1]);
            $stmt->bindParam(':last_name', $data[2]);
            $stmt->bindParam(':suffix', $data[3]);
            $stmt->bindParam(':age', $data[4], PDO::PARAM_INT); 
            $stmt->bindParam(':address', $data[5]);
            $stmt->bindParam(':sex', $data[6]);
            $stmt->bindParam(':birth_date', $data[7]);
            $stmt->bindParam(':birth_place', $data[8]);
            $stmt->bindParam(':civil_status', $data[9]);
            $stmt->bindParam(':citizenship', $data[10]);
            $stmt->bindParam(':occupation', $data[11]);
            for($i=0;$i<=11;$i++) {
                if($data[$i] == null) {
                    $data[$i] = "";
                }
            }
            $stmt->execute();
            $rowCount = $stmt->rowCount(); // Increment rowCount
        } catch (PDOException $e) {
            echo "Error on row $i: " . $e->getMessage() . "<br/>";
        }
    }
    fclose($file);
    ?>
    <div class="success_message absolute top-52 right-32 pl-6 mt-0.5 text-xs bg-lg w-28">
        Data Added
    <?php 
    
    if($rowCount > 0) {
        echo "<div class='ml-3 bg-lg'>". number_format($i)." rows</div>";
 
    ?>
    </div>
    <script>
        let form = document.querySelector("form");
        form.style.display = 'none';
    </script>
    <?php 
        } else {
        echo 'Nothing was inserted, please refresh';
        } 
    }else {
        echo "Invalid file. This only accepts CSV file format, please refresh.";
    }
?>