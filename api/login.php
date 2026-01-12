<?php
session_start();
include "connect.php";

if (!isset($_POST['loginbtn'])) {
    header("Location: ../");
    exit();
}

$mobile   = $_POST['mobile'];
$password = $_POST['password'];

$sql = "SELECT * FROM user 
        WHERE mobile = '$mobile'";

$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0) {

    $userdata = mysqli_fetch_assoc($result);
    // 🔐 hashed password verify
    if (!password_verify($password, $userdata['password'])) {
        echo "<script>
            alert('Wrong password');
            window.location = '../';
        </script>";
        exit();
    }
    $_SESSION['userdata'] = $userdata;

    // 🔀 role based redirect
    if ($userdata['role'] == 1) {

        // voter → load all groups
        $groups = mysqli_query($connect,"SELECT * FROM user WHERE role = 2");
        $_SESSION['groupsdata'] = mysqli_fetch_all($groups, MYSQLI_ASSOC);

        header("Location: ../routes/dashboard.php");
        exit();

    } elseif ($userdata['role'] == 2) {

        // group / candidate
        header("Location: ../routes/group_dashboard.php");
        exit();
    }

} else {
    echo "<script>
        alert('Invalid Credential or User Not Found');
        window.location = '../';
    </script>";
}
?>
