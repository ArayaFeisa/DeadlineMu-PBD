<?php
// Model.php
class Model {
    private $connection;

    public function __construct() {
        include '../database/connection.php';
        $this->connection = $connection;
    }

    public function getUserCategories($userID) {
        $sql = "SELECT * FROM deadlinemu7.Category WHERE UserID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function addCategory($categoryName, $userID) {
        $sql = "INSERT INTO deadlinemu7.Category (CategoryName, UserID) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "si", $categoryName, $userID);
        mysqli_stmt_execute($stmt);
    }

    public function getCategoryDetails($categoryID) {
        $sql = "SELECT * FROM deadlinemu7.Category WHERE CategoryID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $categoryID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function updateCategory($categoryID, $categoryName) {
        $sql = "UPDATE deadlinemu7.Category SET CategoryName = ? WHERE CategoryID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "si", $categoryName, $categoryID);
        mysqli_stmt_execute($stmt);
    }

    public function deleteCategory($categoryID) {
        $sql = "DELETE FROM deadlinemu7.Category WHERE CategoryID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $categoryID);
        mysqli_stmt_execute($stmt);
    }

    public function getUserTasks($userID) {
        $sql = "SELECT * FROM deadlinemu7.Task WHERE UserID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function addTask($title, $description, $dueDate, $priority, $status, $userID, $categoryID) {
        $sql = "INSERT INTO deadlinemu7.Task (Title, Description, DueDate, Priority, Status, UserID, CategoryID) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "sssiiii", $title, $description, $dueDate, $priority, $status, $userID, $categoryID);
        mysqli_stmt_execute($stmt);
    }

    public function updateTask($taskId, $title, $description, $dueDate, $priority, $status, $categoryID) {
        $sql = "UPDATE deadlinemu7.Task SET Title = ?, Description = ?, DueDate = ?, Priority = ?, Status = ?, CategoryID = ? WHERE TaskID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "sssiiii", $title, $description, $dueDate, $priority, $status, $categoryID, $taskId);
        mysqli_stmt_execute($stmt);
    }

    public function getTaskDetails($taskId) {
        $sql = "SELECT * FROM deadlinemu7.Task WHERE TaskID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $taskId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function deleteTask($taskId) {
        $sql = "DELETE FROM deadlinemu7.Task WHERE TaskID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $taskId);
        mysqli_stmt_execute($stmt);
    }
    
    public function getTasksByCategory($categoryID) {
        $sql = "SELECT * FROM deadlinemu7.Task WHERE CategoryID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $categoryID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function addBookmark($userID, $taskID) {
        $sql = "INSERT INTO  deadlinemu7.Bookmark (UserID, TaskID) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $userID, $taskID);
        mysqli_stmt_execute($stmt);
    }

    public function getBookmarks($userID) {
        $sql = "SELECT BookmarkID, TaskID FROM  deadlinemu7.Bookmark WHERE UserID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function deleteBookmark($taskId) {
        $sql = "DELETE FROM  deadlinemu7.Bookmark WHERE TaskID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $taskId);
        mysqli_stmt_execute($stmt);
    }

    public function isTaskBookmarked($userID, $taskID) {
        $sql = "SELECT * FROM  deadlinemu7.Bookmark WHERE UserID = ? AND TaskID = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $userID, $taskID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result) ? true : false;
    }

    public function logActivity($userID, $taskID, $categoryID, $logType) {
        $dateTime = date("Y-m-d H:i:s");

        $sql = "INSERT INTO deadlinemu7.ActivityLog (UserID, TaskID, DateTimes, LogType) VALUES (?, NULL, ?, ?, ?)";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $userID, $taskID, $dateTime, $logType);
        mysqli_stmt_execute($stmt);
    }
}
?>
