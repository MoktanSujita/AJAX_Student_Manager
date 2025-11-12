<?php
include 'config.php';

$id = $_GET['id'] ?? '';

if($id){
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt -> execute([$id]);
    echo json_encode(['status' => 'success' , 'message' => 'Student deleted successfully']);
}
else{
    echo json_encode(['status' => 'success' , 'message' => 'Invalid ID']);
}
?>