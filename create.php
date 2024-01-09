<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fhm_data";

// Creating a connection
$connection = new mysqli($servername, $username, $password, $database);

$name = "";
$email = "";
$phone = "";
$address = "";
$imagePath = ""; // Add a variable to store the image path

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    // Check if an image was uploaded
    if (isset($_FILES["image"])) {
        $targetDirectory = "uploads/images/";
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the uploaded file is an image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Check file size (adjust as needed)
            if ($_FILES["image"]["size"] <= 5000000) { // 5MB
                // Allow certain file formats (you can add more formats)
                $allowedFormats = ["jpg", "jpeg", "png", "gif"];
                if (in_array($imageFileType, $allowedFormats)) {
                    // Generate a unique file name
                    $uniqueFileName = uniqid() . "_" . $_FILES["image"]["name"];
                    $targetFile = $targetDirectory . $uniqueFileName;

                    // Try to upload the file
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                        // Store the file path in the database
                        $imagePath = $targetFile;
                    } else {
                        $errorMessage = "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $errorMessage = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                }
            } else {
                $errorMessage = "Sorry, your file is too large.";
            }
        } else {
            $errorMessage = "File is not an image.";
        }
    }

    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $errorMessage = "All fields are required";
    } elseif (empty($imagePath)) {
        $errorMessage = "Please upload an image.";
    } else {
        // Add the new client to the database
        $sql = "INSERT INTO clientsss (name, email, phone, address, image_path) VALUES ('$name', '$email', '$phone', '$address', '$imagePath')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
        } else {
            $name = "";
            $email = "";
            $phone = "";
            $address = "";
            $imagePath = "";

            $successMessage = "Client added correctly";
        }
    }
}
?>

<!-- The rest of your HTML code remains the same -->




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color: #e6eeff;
            justify-content: center;
            align-items: center;
            place-items: center;
            ;">

    <div class=""
    style="
            /* border-collapse: collapse; */
            /* border-radius: 8px;
            max-width: 40%;
            max-height: 80%;
            background-color: white;
            margin-left:23em;
            margin-top:4em;
            margin-buttom:4em;
            padding: 0.5em;
            box-shadow: 0 3px 7px #1aa3ff; */
            /* display: grid; */
            /* justify-content: center;
            align-items: center;
            place-items: center; */

            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 10px 10px 15px rgba(0,0,0,0.05);
            ">
        




        <?php
            if(!empty($errorMessage)){
                echo"
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }
        ?>



            
        <form method="post" enctype="multipart/form-data" style="padding: 0 40px;
                             box-sizing: border-box;">
        <h4 style="text-align: left;
                    padding: 10px 0;
                    margin-top: 40px;
                    " > New Person to Add</h4>

                    <div class="">
                <label class="col-sm-3 col-form-label">Name</label>
                 <div class="col-sm-14">
                        <input type="text" class="form-control" name="name" value="<?php echo $name;?>">
                </div>
            </div>
               
            <div class="">
                <label class="col-sm-3 col-form-label">Email</label>
                 <div class="col-sm-14">
                        <input type="email" class="form-control" name="email" value="<?php echo $email;?>">
                </div>
            </div>
            
            <div class="">
                <label class="col-sm-3 col-form-label">Phone</label>
                 <div class="col-sm-14">
                        <input type="text" max="10" class="form-control" name="phone" value="<?php echo $phone;?>">
                </div>
            </div>

            <div class="">
                <label class="col-sm-3 col-form-label">Address</label>
                 <div class="col-sm-14">
                        <input type="text" class="form-control" name="address" value="<?php echo $address;?>">
                </div>
            </div>
            <div class="">
                <label class="col-sm-3 col-form-label">Profile</label>
                 <div class="col-sm-14">
                        <input type="file" class="form-control" name="image" accept="image/*" value="<?php echo $image;?>">
                </div>
            </div>


            <?php
             if(!empty($successMessage)){
                echo"
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
                ";}
            ?>



                
            <div style="
                    display:flex;
                    justify-content:space-between;
                    margin-top:10px;
                    margin-bottom:50px;
                    gap:12px;
                    text-align: center;
                    ">
                <div >
                    <button type="submit" class="btn btn-info btn-sm">Submit</button>
                </div>
                <div>
                    <a class="btn btn-danger btn-sm" href="/FHM-DATA/index.php" role="button">Cancel</a>
                </div>
            </div>
            
        </form>
        </div>
        
    </div>
    
   

    
</body>
</html>