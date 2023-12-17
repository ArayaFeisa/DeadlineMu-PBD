<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST["category_name"];

    // Gantilah nilai UserID sesuai kebutuhan
    $user_id = 1;

    $sql = "INSERT INTO deadlinemu.Category (CategoryName, UserID) VALUES ('$category_name', $user_id)";

    // Contoh di dalam addCategory.php
if ($connection->query($sql) === TRUE) {
    $categoryID = mysqli_insert_id($connection);

    header("Location: category.php");
    exit();
} else {
    $error_message = "Error: ";
}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlineMU - Add New Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/stylecategory.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5 mb-3">Add New Category</h2>

        <?php
        if (isset($error_message)) {
            echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
        }
        ?>

        <form method="post" action="">
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name:</label>
                <input type="text" class="form-control" name="category_name" required>
            </div>
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
