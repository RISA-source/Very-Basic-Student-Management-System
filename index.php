<?php
include 'db.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

// Handle Add Student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    
    $stmt = $conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $course]);
    header("Location: index.php");
    exit();
}

// Get all students
$stmt = $conn->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        input[type=text], input[type=email] { width: 200px; padding: 5px; }
        button { padding: 8px 15px; margin: 5px; cursor: pointer; }
        .add-btn { background-color: #4CAF50; color: white; border: none; }
        .edit-btn { background-color: #008CBA; color: white; border: none; }
        .delete-btn { background-color: #f44336; color: white; border: none; }
        .form-container { background-color: #f9f9f9; padding: 20px; margin-bottom: 20px; }
    </style>
</head>
<body>

<h1>Student Management System</h1>

<!-- Add Student Form -->
<div class="form-container">
    <h2>Add New Student</h2>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="course" placeholder="Course" required>
        <button type="submit" name="add" class="add-btn">Add Student</button>
    </form>
</div>

<!-- Student List Table -->
<h2>Student List</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($students as $student): ?>
    <tr>
        <td><?php echo $student['id']; ?></td>
        <td><?php echo htmlspecialchars($student['name']); ?></td>
        <td><?php echo htmlspecialchars($student['email']); ?></td>
        <td><?php echo htmlspecialchars($student['course']); ?></td>
        <td>
            <a href="edit.php?id=<?php echo $student['id']; ?>">
                <button class="edit-btn">Edit</button>
            </a>
            <a href="index.php?delete=<?php echo $student['id']; ?>" 
               onclick="return confirm('Are you sure you want to delete this student?')">
                <button class="delete-btn">Delete</button>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>