<?php
session_start();
include "../api/connect.php";

if ($_SESSION['userdata']['role'] != 1) {
    header("Location: ../");
    exit();
}

$userdata   = $_SESSION['userdata'];
$groupsdata = $_SESSION['groupsdata'];

$uid = $userdata['id'];

// 🔑 find voted group (if any)
$votedGroup = null;
$voteRes = mysqli_query(
    $connect,
    "SELECT group_id FROM votes WHERE user_id = $uid"
);

if (mysqli_num_rows($voteRes) > 0) {
    $row = mysqli_fetch_assoc($voteRes);
    $votedGroup = $row['group_id'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Voting System</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    .greenbox{
            background-color: #3b19b5;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
}
#voted{
      background-color: #2ab519;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;

}
    </style>
</head>
<body class="bg-gray-100">

<!-- HEADER -->
<div class="bg-blue-900 text-white p-4 flex justify-between items-center">
    <!-- <button onclick="window.location='../';"
        class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600">
        Back
    </button> -->

    <h1 class="text-2xl font-bold">Online Voting System</h1>

    <a href="../api/logout.php" id="logoutbtn"
   class="bg-red-500 text-white px-4 py-2 rounded">
   Logout
</a>
</div>

<!-- MAIN CONTENT -->
<div class="max-w-7xl mx-auto mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- PROFILE SECTION (LEFT) -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold text-center mb-4 text-blue-700">My Profile</h2>

        <div class="flex flex-col items-center">
            <img src="../uploads/images/<?php echo $userdata['image']; ?>"
                 class="h-28 w-28 rounded-full border-4 border-blue-500 object-cover">

            <div class="mt-4 text-center">
                <p><b>Name:</b> <?php echo $userdata['name']; ?></p>
                <p><b>Mobile:</b> <?php echo $userdata['mobile']; ?></p>
                <p><b>Address:</b> <?php echo $userdata['address']; ?></p>
                <p class="mt-2">
                    <b>Status:</b>
                    <?php
                    if ($userdata['status'] == 0) {
                        echo "<span class='text-red-600 font-semibold'>Not Voted</span>";
                    } else {
                        echo "<span class='text-green-600 font-semibold'>Voted</span>";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>

    <!-- GROUP SECTION (RIGHT) -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-bold text-center mb-4 text-blue-700">Voting Groups</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <?php
            if ($groupsdata) {
                for ($i = 0; $i < count($groupsdata); $i++) {
            ?>
            <div class="border rounded-lg p-4 text-center shadow hover:shadow-md">
                <img src="../uploads/images/<?php echo $groupsdata[$i]['image']; ?>"
                     class="h-20 w-20 mx-auto rounded-full border object-cover">

                <h3 class="mt-2 font-bold text-lg">
                    <?php echo $groupsdata[$i]['name']; ?>
                </h3>

                <p class="text-gray-600">
                    Votes: <b><?php echo $groupsdata[$i]['votes']; ?></b>
                </p>

                <form action="../api/vote.php" method="POST" class="mt-3">
                <input type="hidden" name="gid" value="<?php echo $groupsdata[$i]['id']; ?>">

                <?php
                if ($votedGroup == $groupsdata[$i]['id']) {
                    ?>
                    <button disabled id="voted">Voted</button>
                    <?php
                } elseif ($userdata['status'] == 0) {
                    ?>
                    <input type="submit" name="votebtn" class="greenbox" value="Vote">
                    <?php
                } else {
                    ?>
                    <button disabled class="bg-gray-400 text-white px-4 py-2 rounded">
                        Vote
                    </button>
                    <?php
                }
                ?>
            </form>


            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

</div>

</body>
</html>
