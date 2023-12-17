<?php
// Controller.php
include 'Model.php';

class Controller {
    private $model;

    public function __construct() {
        $this->model = new Model();
    }

    public function displayUserCategories($userID) {
        return $this->model->getUserCategories($userID);
    }

    public function addCategory($categoryName, $userID) {
        $this->model->addCategory($categoryName, $userID);
    }

    public function editCategory($categoryID) {
        return $this->model->getCategoryDetails($categoryID);
    }

    public function updateCategory($categoryID, $categoryName) {
        $this->model->updateCategory($categoryID, $categoryName);
    }

    public function deleteCategory($categoryID) {
        $this->model->deleteCategory($categoryID);
    }

    public function displayUserTasks($userID) {
        return $this->model->getUserTasks($userID);
    }

    public function addNewTask($title, $description, $dueDate, $priority, $status, $userID, $categoryID) {
        $this->model->addTask($title, $description, $dueDate, $priority, $status, $userID, $categoryID);
    }

    public function updateTask($taskId, $title, $description, $dueDate, $priority, $status, $categoryID) {
        $this->model->updateTask($taskId, $title, $description, $dueDate, $priority, $status, $categoryID);
    }

    public function getTaskDetails($taskId) {
        return $this->model->getTaskDetails($taskId);
    }

    public function deleteTask($taskId) {
        $this->model->deleteTask($taskId);
    }

    public function displayTasksByCategory($categoryID) {
        return $this->model->getTasksByCategory($categoryID);
    }

    public function addBookmark($userID, $taskID) {
        $this->model->addBookmark($userID, $taskID);
    }

    public function displayBookmarks($userID) {
        return $this->model->getBookmarks($userID);
    }

    public function deleteBookmark($taskId) {
        $this->model->deleteBookmark($taskId);
    }

    public function isTaskBookmarked($userID, $taskID) {
        return $this->model->isTaskBookmarked($userID, $taskID);
    }

}
?>
