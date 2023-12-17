<?php
session_start();
include '../app/Controller.php';
$controller = new Controller();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$tasks = $controller->displayUserTasks($userID);

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $controller->deleteTask($_GET['id']);
    header("Location: v_task.php");
    exit();
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
    <link rel="stylesheet" href="../resources/styleHomepage.css">
    <style>
        .bookmarked {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="brand">
            DeadlineMU
        </div>
        <a href="../resources/homepage.php" class="active">Home</a>
        <a href="../views/v_task.php">Task</a>
        <a href="../views/v_Category.php">Category</a>
        <a href="../views/v_taskandCategory.php">Task and Category</a>
        <a href="../views/v_activityLog.php">Task Log</a>
        <a href="../views/v_bookmark.php">Bookmark</a>
        <a href="../resources/logout.php">Logout</a>
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
                if (!empty($tasks)) {
                    $count = 1;
                    foreach ($tasks as $task) {
                        echo "<tr>
                        <td>{$count}</td>
                        <td>{$task['Title']}</td>
                        <td>{$task['Description']}</td>
                        <td>{$task['DueDate']}</td>
                        <td>" . ($task['Priority'] ? 'High' : 'Low') . "</td>
                        <td>" . ($task['Status'] ? 'Finish' : 'On Process') . "</td>
                        <td>{$task['UserID']}</td>
                        <td>{$task['CategoryID']}</td>
                        <td><a href='v_editTask.php?id={$task['TaskID']}' class='btn btn-warning'>Edit</a></td>";

                        $isBookmarked = $controller->isTaskBookmarked($userID, $task['TaskID']);
                        $bookmarkAction = $isBookmarked ? 'delete' : 'add';
                        $bookmarkText = $isBookmarked ? 'Bookmarked' : 'Bookmark';

                        echo "<td>
                                <a href='v_bookmark.php?action={$bookmarkAction}&id={$task['TaskID']}' class='btn " . ($isBookmarked ? 'btn-success bookmarked' : 'btn-primary') . "'>{$bookmarkText}</a>
                              </td>
                              <td><a href='v_task.php?action=delete&id={$task['TaskID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
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
