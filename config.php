<?php
$servername = "mysql.railway.internal";
$username = "root";
$password = "QZvdYmzGvEcRPTbeNmpMMdwCyLUajrZo";
$dbname = "railway";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
