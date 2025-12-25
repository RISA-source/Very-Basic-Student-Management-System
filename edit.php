<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Handle Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    
    $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?");
    $stmt->execute([$name, $email, $course, $id]);
    header("Location: index.php");
    exit();
}

// Get student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        input[type=text], input[type=email] { width: 300px; padding: 8px; margin: 5px 0; }
        button { padding: 10px 20px; margin: 10px 5px; cursor: pointer; }
        .save-btn { background-color: #4CAF50; color: white; border: none; }
        .cancel-btn { background-color: #999; color: white; border: none; }
        .form-container { background-color: #f9f9f9; padding: 20px; max-width: 400px; }
    </style>
</head>
<body>

<h1>Edit Student</h1>

<div class="form-container">
    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br>
        
        <label>Course:</label><br>
        <input type="text" name="course" value="<?php echo htmlspecialchars($student['course']); ?>" required><br>
        
        <button type="submit" class="save-btn">Save Changes</button>
        <a href="index.php"><button type="button" class="cancel-btn">Cancel</button></a>
    </form>
</div>

</body>
</html>