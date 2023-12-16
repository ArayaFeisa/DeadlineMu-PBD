<?php
include('connection.php');


session_start();
// Fungsi add bookmark
// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    // Check if bookmark action is triggered
    if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
        $taskId = $_GET['id'];

        // Check if the task is not already bookmarked
        $checkBookmarkSql = "SELECT * FROM deadlinemu.Bookmark WHERE UserID = $userId AND TaskID = $taskId";
        $checkBookmarkResult = mysqli_query($connection, $checkBookmarkSql);

        if (!$checkBookmarkResult) {
            die("Error checking bookmark: " . mysqli_error($connection));
        }

        if (mysqli_num_rows($checkBookmarkResult) == 0) {
            // Task is not bookmarked, add bookmark
            $addBookmarkSql = "INSERT INTO deadlinemu.Bookmark (UserID, TaskID) VALUES ($userId, $taskId)";
            
            if (mysqli_query($connection, $addBookmarkSql)) {
                header("Location: task.php?notification=added");
                exit();
            } else {
                die("Error adding bookmark: " . mysqli_error($connection));
            }
        } else {
            // Task is already bookmarked, send notification
            header("Location: task.php?notification=exists");
            exit();
        }
    }
} 
else {
    header("Location: login.php");
    exit();
}

// Fungsi untuk menghapus tugas
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $taskId = $_GET['id'];
    $deleteSql = "DELETE FROM deadlinemu.Task WHERE TaskID = $taskId";

    if (mysqli_query($connection, $deleteSql)) {
        header("Location: task.php");
        exit();
    } else {
        die("Error deleting task: " . mysqli_error($connection));
    }
}


// Query untuk mengambil data tugas
$sql = "SELECT * FROM deadlinemu.Task";
$result = mysqli_query($connection, $sql);

// Memeriksa apakah query berhasil dieksekusi
if (!$result) {
    die("Error fetching tasks: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlineMU - Category</title>
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
        <h2 class="mt-5 mb-3">Task</h2>
        <a href="v_addtask.php" class="btn btn-primary my-3">Add New Task</a>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>User ID</th>
                    <th>Category ID</th>
                    <th>Edit</th>
                    <th>Bookmark</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data tugas
                if (mysqli_num_rows($result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$count}</td>
                                <td>{$row['Title']}</td>
                                <td>{$row['Description']}</td>
                                <td>{$row['DueDate']}</td>
                                <td>{$row['Priority']}</td>
                                <td>{$row['Status']}</td>
                                <td>{$row['UserID']}</td>
                                <td>{$row['CategoryID']}</td>
                                <td><a href='v_edittask.php?id={$row['TaskID']}' class='btn btn-warning'>Edit</a></td>                            
                                <td><a href='task.php?action=add&id={$row['TaskID']}' class='btn btn-primary'>Bookmark</a></td>                            
                                <td><a href='task.php?action=delete&id={$row['TaskID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                              </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='10'>No tasks found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="notification" class="alert alert-warning text-center" style="display: none;">
        <strong id="notificationMessage"></strong>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Check if there's a notification parameter in the URL
            const urlParams = new URLSearchParams(window.location.search);
            const notification = urlParams.get('notification');

            if (notification === 'added') {
                showNotification('Task bookmarked successfully!', 'alert-success');
            } else if (notification === 'exists') {
                showNotification('Task is already bookmarked.', 'alert-warning');
            }
        });

        function showNotification(message, alertClass) {
            const notificationElement = document.getElementById('notification');
            notificationElement.textContent = message;
            notificationElement.classList.add(alertClass);
            notificationElement.style.display = 'block';
            setTimeout(function () {
                notificationElement.style.display = 'none';
                notificationElement.classList.remove(alertClass);
            }, 2000);
        }
    </script>

</body>

</html>