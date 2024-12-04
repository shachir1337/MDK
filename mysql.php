<?php
$host = "localhost";
$username = "root"; // Имя пользователя
$password = "";     // Пустой пароль
$database = "school_management";

// Подключение к базе данных
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Форма добавления студента
if (isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO students (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->close();
}

// Вывод студентов
$result = $conn->query("SELECT * FROM students");
echo "<table><tr><th>ID</th><th>Имя</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row['id']."</td><td>".$row['name']."</td></tr>";
}
echo "</table>";

// Добавление группы
if (isset($_POST['add_group'])) {
    $group_name = $_POST['group_name'];
    $stmt = $conn->prepare("INSERT INTO groups (name) VALUES (?)");
    $stmt->bind_param("s", $group_name);
    $stmt->execute();
    $stmt->close();
}

// Форма привязки студента к группе
if (isset($_POST['assign_student'])) {
    $student_id = $_POST['student_id'];
    $group_id = $_POST['group_id'];
    $stmt = $conn->prepare("UPDATE students SET group_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $group_id, $student_id);
    $stmt->execute();
    $stmt->close();
}

// Вывод студентов с группами
$sql = "SELECT students.name AS student_name, groups.name AS group_name FROM students LEFT JOIN groups ON students.group_id = groups.id";
$result = $conn->query($sql);
echo "<table><tr><th>Студент</th><th>Группа</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row['student_name']."</td><td>".$row['group_name']."</td></tr>";
}
echo "</table>";
?>

<!-- Форма для добавления студента -->
<form action="" method="POST">
    Имя студента: <input type="text" name="name">
    <input type="submit" name="add_student" value="Добавить студента">
</form>

<!-- Форма для добавления группы -->
<form action="" method="POST">
    Название группы: <input type="text" name="group_name">
    <input type="submit" name="add_group" value="Добавить группу">
</form>

<!-- Форма для привязки студента -->
<form action="" method="POST">
    Студент: <select name="student_id">
        <?php
        $result = $conn->query("SELECT * FROM students");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
    </select>
    Группа: <select name="group_id">
        <?php
        $result = $conn->query("SELECT * FROM groups");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
    </select>
    <input type="submit" name="assign_student" value="Привязать студента к группе">
</form>