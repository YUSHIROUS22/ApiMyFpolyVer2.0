<?php
// localhost/myfplserver/database/connection.php
$conn = new mysqli('localhost', 'root', '', 'myfpl');

if ($conn->connect_error) {
    echo("Kết nối thất bại: " + $conn->connect_error);
}