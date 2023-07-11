<?php

// On remote sql database
// $hostname = "remotemysql.com";
// $username = "iFzsNLpxHA";
// $password = "IEBRA2zmnU";
// $database = "iFzsNLpxHA";

//This is local database down here
$hostname = "localhost";
$username = "linuxhint";
$password = "new_password";
$database = "leave-management-php";

$con = mysqli_connect("$hostname","$username","$password","$database");

if(!$con){
  header("Location:../errors/dberror.php");
  die();
} 

 
?>

  