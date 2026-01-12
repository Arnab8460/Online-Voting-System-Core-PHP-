<?php
include "connect.php";

$name    = $_POST['name'];
$mobile  = $_POST['mobile'];
$address = $_POST['address'];

$image    = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];

$password = $_POST['password'];
$confirm  = $_POST['confirm_password'];
$role     = $_POST['role'];

if ($password !== $confirm) {
    echo "<script>
        alert('Password and Confirm Password do not match!');
        window.location='../routes/register.html';
    </script>";
    exit();
}

// 🔐 hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// upload image
move_uploaded_file($tmp_name, "../uploads/images/$image");

// insert user
$insert = mysqli_query($connect,
    "INSERT INTO user 
    (name,mobile,address,image,password,role,status,votes)
    VALUES
    ('$name','$mobile','$address','$image','$hashedPassword','$role',0,0)"
);

if ($insert) {
    echo "<script>
        alert('Registration Successful');
        window.location='../';
    </script>";
} else {
    echo "<script>
        alert('Something went wrong!');
        window.location='../routes/register.html';
    </script>";
}
?>
