<?php
session_start();
include 'config.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users(name, email, password) VALUES (:name,:email,:password)");
    if(!$stmt){
        die("Prepare failed:".$conn->error);
    }

        if($stmt->execute([':name'=>$name,':email'=> $email,':password'=> $password])){
            $_SESSION['message'] = "Registration Successful!";
            header("Location:login.php");
            exit();
        }
        else{
            $error = "Email already exists";
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-md w-96">
        <h2 class="text-2xl font-bold text-center mb-4 text-blue-600">Register </h2>

        <?php if(!empty($error)): ?>
            <p class="text-red-600 text-center mb-4"><?=  $error ?></p>
        <?php endif; ?>
      <form action="" method="POST" class="space-y-4">
          <input type="text" name="name" placeholder="Full Name" required class="w-full p-2 border rounded-lg">
          <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded-lg">
          <input type="password" name="password" placeholder="password" class="w-full p-2 border rounded-lg">
  
          <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
              Register
          </button>
      </form>
      <p class="mt-4 text-center text-sm">Already have an account?
          <a href="index.php" class="text-blue-600 font-semibold">Login</a>
      </p>
    </div>
</body>
</html>