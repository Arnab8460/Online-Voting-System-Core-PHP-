<?php
session_start();
include "connect.php";

if ($_SESSION['userdata']['role'] != 1) {
    exit('Only voters can vote');
}


if (isset($_POST['votebtn'])) {

    $uid = (int) $_SESSION['userdata']['id'];
    $gid = (int) $_POST['gid'];

    // 🔒 Check already voted
    $check = mysqli_query(
        $connect,
        "SELECT id FROM votes WHERE user_id = $uid"
    );

    if (mysqli_num_rows($check) > 0) {
        echo "<script>
                alert('You have already voted!');
                window.location='../routes/dashboard.php';
              </script>";
        exit();
    }

    // 1️⃣ Insert vote
    $insertVote = mysqli_query(
        $connect,
        "INSERT INTO votes (user_id, group_id)
         VALUES ($uid, $gid)"
    );

    // 2️⃣ Increase group vote count
    $updateGroup = mysqli_query(
        $connect,
        "UPDATE user SET votes = votes + 1 
         WHERE id = $gid AND role = 2"
    );

    // 3️⃣ Update user status
    $updateUser = mysqli_query(
        $connect,
        "UPDATE user SET status = 1 WHERE id = $uid"
    );

    if ($insertVote && $updateGroup && $updateUser) {

        $_SESSION['userdata']['status'] = 1;

        // reload groups
        $groups = mysqli_query($connect, "SELECT * FROM user WHERE role = 2");
        $_SESSION['groupsdata'] = mysqli_fetch_all($groups, MYSQLI_ASSOC);

        echo "<script>
                alert('Vote submitted successfully!');
                window.location='../routes/dashboard.php';
              </script>";
    }
    else{
        echo "<script>
                alert('Some error occured!');
                window.location='../routes/dashboard.php';
              </script>";

    }
}
?>
