<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST["category_id"];
    $new_category_name = $_POST["new_category_name"];

    $updateSql = "UPDATE deadlinemu.Category SET CategoryName = '$new_category_name' WHERE CategoryID = $category_id";

    if (mysqli_query($connection, $updateSql)) {
        header("Location: category.php");
        exit();
    } else {
        die("Error updating category: " . mysqli_error($connection));
    }
}

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $selectSql = "SELECT * FROM deadlinemu.Category WHERE CategoryID = $category_id";
    $result = mysqli_query($connection, $selectSql);

    if (!$result) {
        die("Error fetching category details: " . mysqli_error($connection));
    }

    $row = mysqli_fetch_assoc($result);
} else {
    // Redirect if no category ID is provided
    header("Location: category.php");
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
    <link rel="stylesheet" href="../css/stylecategory.css">
</head>

<body>
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
