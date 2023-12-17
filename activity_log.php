<?php
include('connection.php');

// Fungsi untuk mencatat aktivitas
function logActivity($userId, $logType, $taskId = null) {
    global $connection;

    // Mencatat timestamp saat ini
    $timestamp = date('Y-m-d H:i:s');

    // Menyiapkan query untuk menyimpan log
    $insertSql = "INSERT INTO deadlinemu.activityLog (UserID, TaskID, Timestamp, LogType) 
                  VALUES ('$userId', '$taskId', '$timestamp', '$logType')";

    // Menjalankan query
    if (mysqli_query($connection, $insertSql)) {
        // Log berhasil disimpan
    } else {
        // Gagal menyimpan log
        echo "Error logging activity: " . mysqli_error($connection);
    }
}

// Query untuk mengambil data aktivitas
$activityLogSql = "SELECT * FROM deadlinemu.activityLog";
$activityLogResult = mysqli_query($connection, $activityLogSql);

// Memeriksa apakah query berhasil dieksekusi
if (!$activityLogResult) {
    die("Error fetching activity log: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlineMU - Activity Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="stylecategory.css">
</head>

<body>
    <div class="sidebar">
        <div class="brand">
            DeadlineMU
        </div>
        <a href="homepage.php" class="active">Home</a>
        <a href="task.php">Task</a>
        <a href="category.php">Category</a>
        <a href="task_and_category.php">Task and Category</a>
        <a href="activity_log.php">Task Log</a>
        <a href="bookmark.php">Bookmark</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h2 class="mt-5 mb-3">Activity Log</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User ID</th>
                    <th>Task ID</th>
                    <th>Timestamp</th>
                    <th>Log Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data log aktivitas
                if (mysqli_num_rows($activityLogResult) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($activityLogResult)) {
                        echo "<tr>
                                <td>{$count}</td>
                                <td>{$row['UserID']}</td>
                                <td>{$row['TaskID']}</td>
                                <td>{$row['Timestamp']}</td>
                                <td>{$row['LogType']}</td>
                              </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No activity log found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</body>

</html>

