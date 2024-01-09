<?php
//connect to database
$connection = mysqli_connect('localhost', 'root', '', 'fhm_data');
$servername = "localhost";
$username = "root";
$password ="";
$database ="fhm_data";


             //creating my connection
$connection = new mysqli($servername, $username, $password, $database);

$name ="";
$email ="";
$phone="";
$address ="";

$errorMessage ="";
$successMessage ="";
//retrieve sorting option from GET request
$sort = $_GET['sort'];

//generate SQL query based on sorting option
if ($sort == 'name') {
	$sql = "SELECT * FROM users ORDER BY name ASC";
} elseif ($sort == 'email') {
	$sql = "SELECT * FROM users ORDER BY email ASC";
} elseif ($sort == 'id') {
	$sql = "SELECT * FROM users ORDER BY id ASC";
} else {
	$sql = "SELECT * FROM users";
}

$result = mysqli_query($connection, $sql);
?>