<?php
session_start();
include '../app/Controller.php';
$controller = new Controller();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$categoryResult = $controller->displayUserCategories($userID);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    $priority = $_POST['priority'] == '1' ? true : false;
    $status = $_POST['status'] == '1' ? true : false;
    $categoryID = $_POST['categoryID'];

    $controller->addNewTask($title, $description, $dueDate, $priority, $status, $userID, $categoryID);

    header("Location: v_task.php"); // Redirect setelah menambah task
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlineMU - Add Task</title>
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
        <h2 class="mt-5 mb-3">Add New Task</h2>
        <form method="post">
            <!-- Form input fields for adding a new task -->
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" required>

            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required></textarea>

            <label for="dueDate">Due Date:</label>
            <input type="date" name="dueDate" class="form-control" required>

            <label for="priority">Priority:</label>
            <select name="priority" class="form-control" required>
                <option value="0">Low</option>
                <option value="1">High</option>
            </select>
            
            <label for="status">Status:</label>
            <select name="status" class="form-control" required>
                <option value="0">On Process</option>
                <option value="1">Finish</option>
            </select>

            <label for="categoryID">Category:</label>
            <select name="categoryID" class="form-control" required>
                <?php
                foreach ($categoryResult as $categoryRow) {
                    $categoryID = $categoryRow['CategoryID'];
                    $categoryName = $categoryRow['CategoryName'];
                    echo "<option value='$categoryID'>$categoryName</option>";
                }
                ?>
</select>

            <br>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</body>

</html>
