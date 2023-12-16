<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for editing an existing task
    $taskId = $_POST['taskId'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];
    $userID = $_POST['userID'];
    $categoryID = $_POST['categoryID'];

    $updateSql = "UPDATE deadlinemu.Task 
                  SET Title='$title', Description='$description', DueDate='$dueDate', 
                      Priority='$priority', Status='$status', UserID='$userID', CategoryID='$categoryID'
                  WHERE TaskID = $taskId";

    if (mysqli_query($connection, $updateSql)) {
        header("Location: task.php");
        exit();
    } else {
        die("Error updating task: " . mysqli_error($connection));
    }
} elseif (isset($_GET['id'])) {
    // Fetch existing task data for pre-filling the form
    $taskId = $_GET['id'];
    $selectSql = "SELECT * FROM deadlinemu.Task WHERE TaskID = $taskId";
    $result = mysqli_query($connection, $selectSql);

    if (!$result) {
        die("Error fetching task data: " . mysqli_error($connection));
    }

    $taskData = mysqli_fetch_assoc($result);
} else {
    // Redirect to task.php if no task ID is provided
    header("Location: task.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlineMU - Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Tambahkan stylesheet lain jika diperlukan -->
</head>

<body>
    <div class="container">
        <h2 class="mt-5 mb-3">Edit Task</h2>
        <form method="post">
            <!-- Form input fields for editing an existing task -->
            <!-- Pastikan nama input dan atribut 'name' sesuai dengan kolom dalam tabel 'Task' -->
            <input type="hidden" name="taskId" value="<?php echo $taskId; ?>">

            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" value="<?php echo $taskData['Title']; ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required><?php echo $taskData['Description']; ?></textarea>

            <label for="dueDate">Due Date:</label>
            <input type="date" name="dueDate" class="form-control" value="<?php echo $taskData['DueDate']; ?>" required>

            <label for="priority">Priority:</label>
            <input type="text" name="priority" class="form-control" value="<?php echo $taskData['Priority']; ?>" required>

            <label for="status">Status:</label>
            <input type="text" name="status" class="form-control" value="<?php echo $taskData['Status']; ?>" required>

            <label for="userID">User ID:</label>
            <input type="number" name="userID" class="form-control" value="<?php echo $taskData['UserID']; ?>" required>

            <label for="categoryID">Category ID:</label>
            <input type="number" name="categoryID" class="form-control" value="<?php echo $taskData['CategoryID']; ?>" required>

            <br>
            <button type="submit" class="btn btn-primary">Save Changes</button>
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
