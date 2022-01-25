<?php
if($_SERVER['SERVER_NAME'] == "localhost"){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mpm";
}
else{
    $servername = "Https-8009";
    $username = "login8009";
    $password = "rrYADXxuSjGBrOV";
    $dbname = "dblogin8009";
}


try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
