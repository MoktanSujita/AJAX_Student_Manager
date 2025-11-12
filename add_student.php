<?php

header('Content-Type: application/json');

include 'config.php';
//if there is any value show it else blank
$id = $_POST['id'];
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$age = $_POST['age'] ?? '';

//if all the fields are filled
/*if($name && $email && $age){
    $stmt = $conn->prepare("INSERT INTO students (name, email, age) VALUES (?,?,?)");
    $stmt ->execute([$name, $email, $age]);

    //convert php array into JSON (sends and receives data between the server and client->browser/JS)
    echo json_encode(['status' => 'success', 'message' => 'Student added successfully']);
    exit;
}else{
    echo json_encode(['status' => 'error' , 'message' => 'All the fields are required']);
exit;

}
*/
if($id){
    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, age=? WHERE id=?");
    $stmt -> execute([$name,$email,$age,$id]);
    echo json_encode(['status' => 'success', 'message' => 'Student updated successfully']);
}
else{
    $stmt = $conn->prepare("INSERT INTO students(name,email,age) VALUES (?,?,?)");
    $stmt ->execute([$name,$email,$age]);
    echo json_encode(['status' => 'success','message' => 'Student added successfully']);
}
?>