<?php
if(isset($_GET['id'])){

    $id =$_GET['id'];

$servername = "localhost";
$username = "root";
$password ="";
$database ="fhm_data";


             //creating my connection
$connection = new mysqli($servername, $username, $password, $database); 


$sql = "DELETE  FROM clientsss WHERE id=$id";
$connection->query($sql);
}

header("location: /FHM-DATA/index.php");
exit;
?>