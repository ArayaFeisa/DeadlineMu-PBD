<?php
include '../app/Controller.php';
$controller = new Controller();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryID = $_POST["category_id"];
    $newCategoryName = $_POST["new_category_name"];

    // Update the category
    $controller->updateCategory($categoryID, $newCategoryName);

    // Redirect to category list page
    header("Location: v_Category.php");
    exit();
}

// Get category details for editing
$row = null;
if (isset($_GET['id'])) {
    $row = $controller->editCategory($_GET['id']);
    if (!$row) {
        // Redirect if category is not found
        header("Location: v_Category.php");
        exit();
    }
} else {
    // Redirect if no category ID is provided
    header("Location: v_Category.php");
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
        <h2 class="mt-5 mb-3">Edit Category</h2>

        <form method="post" action="">
            <input type="hidden" name="category_id" value="<?php echo $row['CategoryID']; ?>">

            <div class="mb-3">
                <label for="new_category_name" class="form-label">New Category Name:</label>
                <input type="text" class="form-control" name="new_category_name" value="<?php echo $row['CategoryName']; ?>" required>
            </div>
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