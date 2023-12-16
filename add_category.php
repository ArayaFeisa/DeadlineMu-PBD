<head>
    <title>Tambah Kategori dan Task</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
include 'connection.php';

// Fungsi untuk mengambil semua kategori
function getAllCategories($connection) {
    $result = mysqli_query($connection, "SELECT * FROM Category");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mengambil semua task
function getAllTasks($connection) {
    $result = mysqli_query($connection, "SELECT Task.*, Category.CategoryName FROM Task JOIN Category ON Task.CategoryID = Category.CategoryID");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Proses submit kategori
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitCategory'])) {
    $categoryName = $_POST['categoryName'];
    $userId = 1; // Contoh, asumsi ID pengguna adalah 1

    $stmt = $connection->prepare("INSERT INTO Category (CategoryName, UserID) VALUES (?, ?)");
    $stmt->bind_param("si", $categoryName, $userId);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Kategori baru berhasil dibuat</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Proses submit task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitTask'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];
    $userId = 1; // Contoh, asumsi ID pengguna adalah 1
    $categoryId = $_POST['categoryId'];

    $stmt = $connection->prepare("INSERT INTO Task (Title, Description, DueDate, Priority, Status, UserID, CategoryID) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiii", $title, $description, $dueDate, $priority, $status, $userId, $categoryId);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Task baru berhasil dibuat</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$categories = getAllCategories($connection);
$tasks = getAllTasks($connection);
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap dan metadata -->
</head>
<body>
<div class="container">
    <h2>Tambah Kategori</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            Nama Kategori: <input type="text" class="form-control" name="categoryName">
        </div>
        <input type="submit" class="btn btn-primary" name="submitCategory" value="Tambah Kategori">
    </form>

    <h2>Daftar Kategori</h2>
    <ul class="list-group">
        <?php foreach($categories as $category): ?>
            <li class="list-group-item"><?php echo $category['CategoryName']; ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Tambah Task</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            Judul: <input type="text" class="form-control" name="title">
            Deskripsi: <textarea class="form-control" name="description"></textarea>
            Tanggal Berakhir: <input type="date" class="form-control" name="dueDate">
            Prioritas: <input type="text" class="form-control" name="priority">
            Status: <select class="form-control" name="status">
                        <option value="0">Belum Selesai</option>
                        <option value="1">Selesai</option>
                    </select>
            Kategori: <select class="form-control" name="categoryId">
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['CategoryID']; ?>"><?php echo $category['CategoryName']; ?></option>
                        <?php endforeach; ?>
                      </select>
        </div>
        <input type="submit" class="btn btn-primary" name="submitTask" value="Tambah Task">
    </form>

    <h2>Daftar Task</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal Berakhir</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tasks as $task): ?>
            <tr>
                <td><?php echo $task['Title']; ?></td>
                <td><?php echo $task['Description']; ?></td>
                <td><?php echo $task['DueDate']; ?></td>
                <td><?php echo $task['Priority']; ?></td>
                <td><?php echo $task['Status'] ? 'Selesai' : 'Belum Selesai'; ?></td>
                <td><?php echo $task['CategoryName']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
