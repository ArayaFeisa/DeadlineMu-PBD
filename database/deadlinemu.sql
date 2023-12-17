create database deadlinemu7;

-- Create 'User' table
CREATE TABLE deadlinemu7.User (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255),
    Password VARCHAR(255)
);

-- Create 'Category' table
CREATE TABLE deadlinemu7.Category (
    CategoryID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(255),
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES User(UserID)
);

-- Create 'Task' table
CREATE TABLE deadlinemu7.Task (
    TaskID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255),
    Description TEXT,
    DueDate DATE,
    Priority BOOLEAN,
    Status BOOLEAN,
    UserID INT,
    CategoryID INT,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (CategoryID) REFERENCES Category(CategoryID) ON DELETE SET NULL
);

-- Create 'ActivityLog' table
CREATE TABLE deadlinemu7.ActivityLog (
    LogID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    TaskID INT,
    Timestamp TIMESTAMP,
    LogType VARCHAR(50),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (TaskID) REFERENCES Task(TaskID)
);

-- Create 'Bookmark' table
CREATE TABLE deadlinemu7.Bookmark (
    BookmarkID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    TaskID INT,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (TaskID) REFERENCES Task(TaskID)
);

INSERT INTO deadlinemu7.User (UserID, Username, Password)
VALUES (1, 'Raya', 'rayabadut'),
       (2, 'Yusuf', 'yusuf123'),
       (3, 'Uji', 'stopbromo');

INSERT INTO deadlinemu7.Category (CategoryName, UserID) VALUES
    ('Work', 1),
    ('Personal', 2),
    ('Study', 1);

INSERT INTO deadlinemu7.Task (Title, Description, DueDate, Priority, Status, UserID, CategoryID) VALUES
    ('Finish Project', 'Complete the project before the deadline', '2023-01-15', true, false, 1, 1),
    ('Grocery Shopping', 'Buy groceries for the week', '2023-01-20', false, false, 2, 2),
    ('Study for Exam', 'Prepare for upcoming exams', '2023-02-10', true, false, 1, 3);