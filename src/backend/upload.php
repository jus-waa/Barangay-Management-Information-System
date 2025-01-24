<?php 
include_once("connection.php");
$file_name = $_FILES["file"]["tmp_name"];
if(empty($file_name)) {
    echo "<div class=error_message> Upload File.</div>";
    exit();
}
//caluate age
function calculateAge($birthdate) {
    try {
        $birthDate = new DateTime($birthdate);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthDate)->y; //get the difference in years
        return $age;
    } catch (Exception $e) {
        return "Invalid date: " . $e->getMessage();
    }
    
}
$expectedHeaders = [
    'first name', 
    'middle name', 
    'last name', 
    'suffix', 
    'gender', 
    'date of birth', 
    'birthplace (municipality/city)', 
    'birthplace (province)', 
    'father\'s name', 
    'mother\'s maiden name', 
    'contact number', 
    'email address', 
    'house number', 
    'street name', 
    'purok', 
    'civil status', 
    'citizenship', 
    'ethnicity', 
    'occupation', 
    'residency type', 
    'status', 
    'height', 
    'weight', 
    'eye color', 
    'blood type', 
    'religion'
];

if($_FILES["file"]["size"] > 0) {
    $file = fopen($file_name, "r");

    $header = fgetcsv($file, 10000, ",");
    if ($header === false || array_map('strtolower', $header) !== $expectedHeaders) {
        echo "<div id='notif-del' class='grid grid-cols-2 text-sm items-center p-4 rounded-md bg-[#FFF2D0] text-[#937E43] opacity-100 transition-opacity duration-100'>
            <p>Invalid file format. Check the manual for Expected headers.</p>
            <img src='../img/notif-del.png' alt='X' class='justify-self-end cursor-pointer' onclick='notifDel();'>
        </div>";
        fclose($file);
        exit();
    }

    $rowCount = 0;
    while(($data = fgetcsv($file, 10000, ",")) !== FALSE) {
        if (count($data) < count($expectedHeaders)) {
            echo "<div id='notif-del' class='grid grid-cols-2 text-sm items-center p-4 rounded-md bg-[#FFF2D0] text-[#937E43] opacity-100 transition-opacity duration-100'>
                <p>Data Incomplete. Error on row " . $rowCount + 2 . " Incomplete data.</p>
                <img src='../img/notif-del.png' alt='X' class='justify-self-end cursor-pointer' onclick='notifDel();'>
            </div>";
            exit();
        }
        //calculate age using the birth date
        $age = calculateAge($data[5]); 
        //default values for brgy, municipalit city, province, zipcode
        $brgy = "Barangay Buna Cerca";
        $city = "Indang";
        $prov = "Cavite";
        $zip = "4122";
        $query = "INSERT INTO `resident_info`(`first_name`, `middle_name`, `last_name`, `suffix`, `gender`, `age`, `birth_date`, `birthplace_municipality_city`, `birthplace_province`, `father_name`, `mother_maiden_name`, `contact_num`, `email_address`, `house_num`, `street_name`, `purok`, `barangay_name`, `municipality_city`, `province`, `zip_code`, `civil_status`, `citizenship`, `ethnicity`, `occupation`, `residency_type`, `status`, `height`, `weight`, `eye_color`, `blood_type`, `religion`) 
        VALUES (:first_name, :middle_name, :last_name, :suffix, :gender, :age, :birth_date, :birthplace_municipality_city, :birthplace_province, :father_name, :mother_maiden_name, :contact_num, :email_address, :house_num, :street_name, :purok, :barangay_name, :municipality_city, :province, :zip_code, :civil_status, :citizenship, :ethnicity, :occupation, :residency_type, :status, :height, :weight, :eye_color, :blood_type, :religion)";
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
            $stmt->bindParam(':purok', $data[14], PDO::PARAM_STR);
            $stmt->bindParam(':barangay_name', $brgy, PDO::PARAM_STR);
            $stmt->bindParam(':municipality_city', $city, PDO::PARAM_STR);
            $stmt->bindParam(':province', $prov, PDO::PARAM_STR);
            $stmt->bindParam(':zip_code', $zip, PDO::PARAM_STR);
            $stmt->bindParam(':civil_status', $data[15], PDO::PARAM_STR);
            $stmt->bindParam(':citizenship', $data[16], PDO::PARAM_STR);
            $stmt->bindParam(':ethnicity', $data[17], PDO::PARAM_STR);
            $stmt->bindParam(':occupation', $data[18], PDO::PARAM_STR);
            $stmt->bindParam(':residency_type', $data[19], PDO::PARAM_STR);
            $stmt->bindParam(':status', $data[20], PDO::PARAM_STR);
            $stmt->bindParam(':height', $data[21], PDO::PARAM_INT);
            $stmt->bindParam(':weight', $data[22], PDO::PARAM_INT);
            $stmt->bindParam(':eye_color', $data[23], PDO::PARAM_STR);
            $stmt->bindParam(':blood_type', $data[24], PDO::PARAM_STR);
            $stmt->bindParam(':religion', $data[25], PDO::PARAM_STR);
            for($i=0;$i<=25;$i++) {
                if($data[$i] == null) {
                    $data[$i] = "";
                }
            }
            $stmt->execute();
            $rowCount++; // Increment rowCount
        } catch (PDOException $e) {
            echo "Error on row $i: " . $e->getMessage() . "<br/>";
        }
    }
    fclose($file);
    
    if ($rowCount > 0) {
        echo "<div id='notif-del' class='grid grid-cols-2 text-sm items-center p-4 rounded-md bg-[#FFF2D0] text-[#937E43] opacity-100 transition-opacity duration-100'>
            <p>File uploaded successfully, $rowCount rows inserted.</p>
            <img src='../img/notif-del.png' alt='X' class='justify-self-end cursor-pointer' onclick='notifDel();'>
        </div>";
        exit();
    } else {
        echo "<div id='notif-del' class='grid grid-cols-2 text-sm items-center p-4 rounded-md bg-[#FFF2D0] text-[#937E43] opacity-100 transition-opacity duration-100'>
            <p>No rows were inserted. Please check the file and try again.</p>
            <img src='../img/notif-del.png' alt='X' class='justify-self-end cursor-pointer' onclick='notifDel();'>
        </div>";
    }
} else {
    echo "<div id='notif-del' class='grid grid-cols-2 text-sm items-center p-4 rounded-md bg-[#FFF2D0] text-[#937E43] opacity-100 transition-opacity duration-100'>
            <p>Invalid file. This only accepts CSV file format. Please refresh and try again.</p>
            <img src='../img/notif-del.png' alt='X' class='justify-self-end cursor-pointer' onclick='notifDel();'>
        </div>";
}
?>