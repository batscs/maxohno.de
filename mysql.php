<?php
$host = "X";
$name = "X";
$user = "X";
$password = "X";

try {
    $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $password);
    
} catch (PDOException $e) {
    echo "SQL Error: " .$e->getMessage();
}

?>