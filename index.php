<?php
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 10- AJAX Student Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-content-center items-center h-screen">

<div class="bg-white p-8 rounded-2xl shadow-md w-96">
    <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Student Form</h1>
    
    <form method="post" action="add_student.php" class="space-y-4">
        <input type="post" name="id" id="studentId">
        
      <input type="text" name="name" placeholder="NAME" class="w-full p-2 border rounded-lg">
      <input type="email" name="email" placeholder="EMAIL" class="w-full p-2 border rounded-lg">
      <input type="number" name="age" placeholder="AGE" class="w-full p-2 border rounded-lg">
      
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
          Submit
      </button>
    </form>
</div>
<div class="bg-white p-6 rounded-2xl shadow-md mt-8 w-full max-w-lg">
    <h2 class="text-xl font-bold mb-4 text-gray-700">Student list</h2>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
               <th class="p-2 border">ID</th>
               <th class="p-2 border">Name</th>
               <th class="p-2 border">Email</th>
               <th class="p-2 border">Age</th>
            </tr>
        </thead>
        <tbody id="studentTable"></tbody>
    </table>
</div>
</body>

<script>
    //querySelector takes the first element i.e. the first form it finds in this scenario 
    const form = document.querySelector('form');
    const tableBody = document.getElementById('studentTable');

    //fetch all the students when the page loads
    fetchStudent();

    form.addEventListener('submit', async(e) =>{
        e.preventDefault();  //stops the normal page reload

        //all the data from form is collected and packaged into an easy to send object called FormData
        const formData = new FormData(form);  

        //form data are parse the formData into the php file -> add_student.php
        const response = await fetch('add_student.php',{
            method: 'POST',
            body: formData
        });

        //await-> waits(pause execution) until  a code until a promise finishes(either success or failure)
        const result = await response.json();
        console.log(response);
        alert(result.message);

        
        if(result.status === 'success'){
            form.reset();            //resets the form (clear the inputs)
            fetchStudent();          
        }
    });

    async function fetchStudent() {
        const response = await fetch('fetch_student.php');
        const students = await response.json();

        //clear old data
        tableBody.innerHTML = '';

        students.forEach(student =>{
         const row =`
         <tr>
            <td class = "border p-2">${student.id}</td>
            <td class = "border p-2">${student.name}</td>
            <td class = "border p-2">${student.email}</td>
            <td class = "border p-2">${student.age}</td>
            <td class="border p-2 space-x-2">
              <button onclick="editStudent(${student.id}, '${student.name}','${student.email}',${student.age})" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
              <button onclick="deleteStudent(${student.id})" class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
            </td>
         </tr> `;
         tableBody.innerHTML += row;
        });
        
    }

    function editStudent(id, name, email, age){
        document.getElementById('studentId').value = id;
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('age').value = age;
    }

    async function deleteStudent(id){
        if(confirm('Are you sure you want to delete this student?')){
            const response = await fetch('delete_student.php?id=' +id);
            const result = await response.json();
            alert(result.message);
            fetchStudent();
        }
    }
</script>
</html>