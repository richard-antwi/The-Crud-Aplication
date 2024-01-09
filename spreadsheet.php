<?php
$servername = "localhost";
$username = "root";
$password ="";
$database ="fhm_data";


          //creating my connections
        $connection = new mysqli($servername, $username, $password, $database);
        $name ="";
        $email ="";
        $phone="";
        $address ="";
        $errorMessage ="";
        $successMessage ="";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Import Excel to Database</title>
</head>
<body style="background-color: #e6eeff;
            justify-content: center;
            align-items: center;
            /* display: grid; */
            place-items: center;
            ">

<div style="
            background-color: white;
            margin-left:23em;
            margin-top:10em;
            margin-bottom:4em;
            padding: 0.5em;
            align-items: center;
            place-items: center;
            transform: translate(-50%, -50%);
            width: 450px;
            height: 100px;
            background: white;
            border-radius: 10px;
            box-shadow: 10px 10px 15px #1aa3ff; ">

    <form  class="" action="" method="post" enctype = "multipart/form-data"  style="
    margin-top:40px;
    margin-left:25px;">
        <input type="file" name="excel" value="" required>
        <button class='btn btn-info btn-sm' type="submit" name="import">Import</button>


        <?php
        if(isset($_POST["import"])){
            $fileName = $_FILES["excel"]["name"];
            $fileExtension = explode('.', $fileName);
            $fileExtension = strtolower(end($fileExtension));

            $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

            $targetDirectory = "uploads/" .$newFileName;
            move_uploaded_file($_FILES["excel"]["tmp_name"], $targetDirectory);

            error_reporting(0);
            ini_set('display_errors', 0);

            require "excelReader/excel_reader2.php";
            require "excelReader/SpreadsheetReader.php";

            $reader = new SpreadsheetReader($targetDirectory);
            foreach($reader as $key =>$row){
                $name = $row[0];
                $email = $row[1];
                $phone = $row[2];
                $address = $row[3];

                $sql = "INSERT INTO clientsss (name, email, phone, address)".
                "VALUES ('$name','$email','$phone','$address')";
        $result =$connection->query($sql);

           //  mysqli_query($conn, "INSERT INTO clientsss VALUES ('$name','$email','$phone','$address')");
            }

            echo
            "
            <script>
            aleat('Successfully Impoted);
            document.location.href = 'index.php';
            </script>
            ";
        }
        
        ?>
    </form>
    </div>
</body>
</html>
