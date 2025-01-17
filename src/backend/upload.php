<?php 
include_once("connection.php");
$file_name = $_FILES["file"]["tmp_name"];
if(empty($file_name)) {
    echo "<div class=error_message> Upload File.</div>";
    exit();
}
$i = 0; //for header
//caluate age
function calculateAge($birthdate) {
    $birthDate = new DateTime($birthdate);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y; //get the difference in years
    return $age;
}

if($_FILES["file"]["size"] > 0) {
    $file = fopen($file_name, "r");
    while(($data = fgetcsv($file, 10000, ",")) !== FALSE) {
        if ($i === 0) {
            $i++;
            continue; // Skip the header row
        }
        //calculate age using the birth date
        $age = calculateAge($data[5]); 
        //default values for brgy, municipalit city, province, zipcode
        $brgy = "Barangay Buna Cerca";
        $city = "Indang";
        $prov = "Cavite";
        $zip = "4122";
        $query = "INSERT INTO `resident_info`(`first_name`, `middle_name`, `last_name`, `suffix`, `gender`, `age`, `birth_date`, `birthplace_municipality_city`, `birthplace_province`, `father_name`, `mother_maiden_name`, `contact_num`, `email_address`, `house_num`, `street_name`, `barangay_name`, `municipality_city`, `province`, `zip_code`, `civil_status`, `citizenship`, `ethnicity`, `occupation`, `residency_type`, `status`, `height`, `weight`, `eye_color`, `blood_type`, `religion`) 
        VALUES (:first_name, :middle_name, :last_name, :suffix, :gender, :age, :birth_date, :birthplace_municipality_city, :birthplace_province, :father_name, :mother_maiden_name, :contact_num, :email_address, :house_num, :street_name, :barangay_name, :municipality_city, :province, :zip_code, :civil_status, :citizenship, :ethnicity, :occupation, :residency_type, :status, :height, :weight, :eye_color, :blood_type, :religion)";
        $stmt = $dbh->prepare($query);
        try {
            $stmt->bindParam(':first_name', $data[0], PDO::PARAM_STR);
            $stmt->bindParam(':middle_name', $data[1], PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $data[2], PDO::PARAM_STR);
            $stmt->bindParam(':suffix', $data[3], PDO::PARAM_STR);
            $stmt->bindParam(':gender', $data[4], PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);
            $stmt->bindParam(':birth_date', $data[5], PDO::PARAM_STR);  // Date format as string
            $stmt->bindParam(':birthplace_municipality_city', $data[6], PDO::PARAM_STR);
            $stmt->bindParam(':birthplace_province', $data[7], PDO::PARAM_STR);
            $stmt->bindParam(':father_name', $data[8], PDO::PARAM_STR);
            $stmt->bindParam(':mother_maiden_name', $data[9], PDO::PARAM_STR);
            $stmt->bindParam(':contact_num', $data[10], PDO::PARAM_STR);
            $stmt->bindParam(':email_address', $data[11], PDO::PARAM_STR);
            $stmt->bindParam(':house_num', $data[12], PDO::PARAM_STR);
            $stmt->bindParam(':street_name', $data[13], PDO::PARAM_STR);
            $stmt->bindParam(':barangay_name', $brgy, PDO::PARAM_STR);
            $stmt->bindParam(':municipality_city', $city, PDO::PARAM_STR);
            $stmt->bindParam(':province', $prov, PDO::PARAM_STR);
            $stmt->bindParam(':zip_code', $zip, PDO::PARAM_STR);
            $stmt->bindParam(':civil_status', $data[14], PDO::PARAM_STR);
            $stmt->bindParam(':citizenship', $data[15], PDO::PARAM_STR);
            $stmt->bindParam(':ethnicity', $data[16], PDO::PARAM_STR);
            $stmt->bindParam(':occupation', $data[17], PDO::PARAM_STR);
            $stmt->bindParam(':residency_type', $data[18], PDO::PARAM_STR);
            $stmt->bindParam(':status', $data[19], PDO::PARAM_STR);
            $stmt->bindParam(':height', $data[20], PDO::PARAM_INT);
            $stmt->bindParam(':weight', $data[21], PDO::PARAM_INT);
            $stmt->bindParam(':eye_color', $data[22], PDO::PARAM_STR);
            $stmt->bindParam(':blood_type', $data[23], PDO::PARAM_STR);
            $stmt->bindParam(':religion', $data[24], PDO::PARAM_STR);
            for($i=0;$i<=24;$i++) {
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
    <div class="success_message absolute top-52 right-32 pl-6 mt-0.5 text-xs bg-sg w-16">
    <?php 
    
    if($rowCount > 0) {
        echo '<script>window.location.href = "residentpage.php";</script>';
        exit();
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
} else {
    echo "Invalid file. This only accepts CSV file format, please refresh.";
}
?>