<?php
include('connection.php');
include('addActivityLog.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for adding a new task
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];
    $userID = $_POST['userID'];
    $categoryID = $_POST['categoryID'];

    $insertSql = "INSERT INTO deadlinemu.Task (Title, Description, DueDate, Priority, Status, UserID, CategoryID) 
                  VALUES ('$title', '$description', '$dueDate', '$priority', '$status', '$userID', '$categoryID')";

        // Contoh di dalam addTask.php
    if (mysqli_query($connection, $insertSql)) {
        $taskID = mysqli_insert_id($connection);
        addTaskActivityLog($userID, $taskID, 'Create Task');

        header("Location: task.php");
        exit();
    } else {
        die("Error adding task: " . mysqli_error($connection));
    }
}

// Query untuk mengambil semua kategori
$categorySql = "SELECT * FROM deadlinemu.Category";
$categoryResult = mysqli_query($connection, $categorySql);

// Memeriksa apakah query berhasil dieksekusi
if (!$categoryResult) {
    die("Error fetching categories: " . mysqli_error($connection));
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
    <!-- Tambahkan stylesheet lain jika diperlukan -->
</head>

<body>
    <div class="container">
        <h2 class="mt-5 mb-3">Add New Task</h2>
        <form method="post">
            <!-- Form input fields for adding a new task -->
            <!-- Pastikan nama input dan atribut 'name' sesuai dengan kolom dalam tabel 'Task' -->
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" required>

            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required></textarea>

            <label for="dueDate">Due Date:</label>
            <input type="date" name="dueDate" class="form-control" required>

            <label for="priority">Priority:</label>
            <input type="text" name="priority" class="form-control" required>

            <label for="status">Status:</label>
            <input type="text" name="status" class="form-control" required>

            <label for="userID">User ID:</label>
            <input type="number" name="userID" class="form-control" required>

            <label for="categoryID">Category:</label>
            <select name="categoryID" class="form-control" required>
                <?php
                // Menampilkan nama kategori sebagai opsi dropdown
                while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
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
