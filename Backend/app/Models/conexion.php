<?php
$host = "localhost";  
$usuario = "root";         
$password = "";             
$dbname = "futcol1";  


$conn = new mysqli($host, $usuario, $password, $dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
else{
    echo "";
}
?>