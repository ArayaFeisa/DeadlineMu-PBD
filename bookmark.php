<?php
// bookmark.php
require_once("connection.php");

// Function to get bookmarks for a specific user
function getBookmarks($userId, $connection){
    $query = "SELECT BookmarkID, TaskID FROM Bookmark WHERE UserID = $userId";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fungsi untuk menghapus bookmark
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $taskId = $_GET['id'];
    $deleteSql = "DELETE FROM deadlinemu.Bookmark WHERE TaskID = $taskId";

    if (mysqli_query($connection, $deleteSql)) {
        header("Location: task.php");
        exit();
    } else {
        die("Error deleting bookmark: " . mysqli_error($connection));
    }
}


// Assuming you have a user ID, you can get bookmarks for that user
$userId = 1; // Replace with the actual user ID (you should get it from your authentication system)

$bookmarks = getBookmarks($userId, $connection);

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
    <h2 class="mt-5 mb-3">Bookmarks</h2>
    <table class="table">
            <?php
            // Assuming you have a successful query execution here to get $categoryResult
            $categoryResult = mysqli_query($connection, "SELECT * FROM category");

            if (!$categoryResult) {
                die("Error fetching categories: " . mysqli_error($connection));
            }

            while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                $categoryID = $categoryRow['CategoryID'];
                $categoryName = $categoryRow['CategoryName'];

                echo "<h3>$categoryName</h3>";

                // Query to get bookmarks by category
                $bookmarkSql = "SELECT b.*, t.Title as TaskTitle, t.Description as TaskDescription, t.DueDate
                        FROM deadlinemu.Bookmark b
                        INNER JOIN deadlinemu.Task t ON b.TaskID = t.TaskID
                        WHERE t.CategoryID = $categoryID";  // Change b.CategoryID to t.CategoryID
                $bookmarkResult = mysqli_query($connection, $bookmarkSql);

                if (!$bookmarkResult) {
                    die("Error fetching bookmarks: " . mysqli_error($connection));
                }

                echo "<table class='table'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>";

                // Display bookmarks in the table
                $count = 1;
                while ($bookmarkRow = mysqli_fetch_assoc($bookmarkResult)) {
                    echo "<tr>
                            <td>{$count}</td>
                            <td>{$bookmarkRow['TaskTitle']}</td>
                            <td>{$bookmarkRow['TaskDescription']}</td>
                            <td>{$bookmarkRow['DueDate']}</td>
                            <td><a href='bookmark.php?action=delete&id={$bookmarkRow['TaskID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                          </tr>";
                    $count++;
                }

                echo "</tbody></table>";
            }

            // Don't forget to free the result set
            mysqli_free_result($categoryResult);
            ?>
        </tbody>
    </table>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</body>

</html>