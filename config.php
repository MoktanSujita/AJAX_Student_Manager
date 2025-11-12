<?php
define('BASEURL','config.php');

try{
    $conn = new PDO("mysql:host=localhost;dbname=backend_db","root","");
    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e){
    header('Content-Type: application/json', true, 500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection error: ' . $e->getMessage()]);
    exit();
}
?>