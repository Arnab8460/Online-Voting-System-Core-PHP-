<?php
session_start();
include "../api/connect.php";

if (!isset($_SESSION['userdata']) || $_SESSION['userdata']['role'] != 2) {
    header("Location: ../");
    exit();
}

$groupId = $_SESSION['userdata']['id'];

// total votes from votes table
$res = mysqli_query(
    $connect,
    "SELECT COUNT(*) AS total_votes 
     FROM votes 
     WHERE group_id = $groupId"
);

$data = mysqli_fetch_assoc($res);
$totalVotes = $data['total_votes'];
$userdata = $_SESSION['userdata'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Group Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8 text-center relative">

        <!-- Avatar -->
        <div class="w-28 h-28 mx-auto rounded-full bg-indigo-600 flex items-center justify-center shadow-lg -mt-20 overflow-hidden">

        <?php if (!empty($userdata['image']) && file_exists("../uploads/images/".$userdata['image'])) { ?>

            <img src="../uploads/images/<?php echo $userdata['image']; ?>"
                class="h-full w-full object-cover">

        <?php } else { ?>

            <span class="text-white text-3xl font-bold">
                <?php echo strtoupper(substr($userdata['name'],0,1)); ?>
            </span>

        <?php } ?>

    </div>


        <!-- Group Name -->
        <h2 class="mt-4 text-2xl font-bold text-gray-800">
            <?php echo $_SESSION['userdata']['name']; ?>
        </h2>
        <p class="text-gray-500 text-sm mb-6">Group Dashboard</p>

        <!-- Votes Card -->
        <div class="bg-gradient-to-r from-green-400 to-green-600 text-white rounded-xl p-6 shadow-lg mb-6">
            <p class="text-lg font-semibold">Total Votes Received</p>
            <h1 class="text-5xl font-bold mt-2">
                <?php echo $totalVotes; ?>
            </h1>
        </div>

        <!-- Actions -->
        <a href="../api/logout.php"
           class="inline-block w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl transition duration-300">
            Logout
        </a>

    </div>

</body>
</html>

