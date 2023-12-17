<?php
session_start();
include '../app/Controller.php';
$controller = new Controller();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $controller->addBookmark($userID, $_GET['id']);
    header("Location: v_task.php?notification=added");
    exit();
}


// Handle delete bookmark
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $controller->deleteBookmark($_GET['id']);
    header("Location: v_bookmark.php");
    exit();
}

// NOTIF
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $taskID = $_GET['id'];

    if (!$controller->isTaskBookmarked($userID, $taskID)) {
        $controller->addBookmark($userID, $taskID);
        $redirectUrl = "v_task.php?notification=added";
    } else {
        $redirectUrl = "v_task.php?notification=exists";
    }

    header("Location: $redirectUrl");
    exit();
}

// Get bookmarks and categories
$bookmarks = $controller->displayBookmarks($userID);
$categories = $controller->displayUserCategories($userID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlineMU - Bookmark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="../resources/styleHomepage.css">
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
        <h2 class="mt-5 mb-3">Bookmarks</h2>
        <?php foreach ($categories as $categoryRow): ?>
            <h3><?= htmlspecialchars($categoryRow['CategoryName']); ?></h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($bookmarks as $bookmark) {
                        $taskDetails = $controller->getTaskDetails($bookmark['TaskID']);
                        if ($taskDetails['CategoryID'] == $categoryRow['CategoryID']) {
                            echo "<tr>
                                    <td>{$count}</td>
                                    <td>".htmlspecialchars($taskDetails['Title'])."</td>
                                    <td>".htmlspecialchars($taskDetails['Description'])."</td>
                                    <td>".htmlspecialchars($taskDetails['DueDate'])."</td>
                                    <td><a href='v_bookmark.php?action=delete&id={$bookmark['TaskID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                                  </tr>";
                            $count++;
                        }
                    }
                    if ($count == 1) {
                        echo "<tr><td colspan='5'>No bookmarks found for this category</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</body>
</html>