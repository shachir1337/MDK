<?php
// Проверка, была ли отправлена форма
if (isset($_POST['task'])) {
    // Получаем текущий список задач из Cookie
    $tasks = isset($_COOKIE['tasks']) ? json_decode($_COOKIE['tasks'], true) : [];

    // Добавляем новую задачу
    $newTask = htmlspecialchars($_POST['task']);
    $tasks[] = $newTask;

    // Сохраняем обновленный список задач в Cookie
    setcookie('tasks', json_encode($tasks), time() + (86400 * 30), "/"); // Cookie будет храниться 30 дней
    header("Location: " . $_SERVER['PHP_SELF']); // Перезагружаем страницу
    exit();
}

// Получаем список задач из Cookie
$tasks = isset($_COOKIE['tasks']) ? json_decode($_COOKIE['tasks'], true) : [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список дел (To-Do List)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
    </style>
</head>
<body>
    <h1>Список дел</h1>

    <form method="post">
        <input type="text" name="task" placeholder="Введите задачу" required>
        <button type="submit">Добавить задачу</button>
    </form>

    <h2>Ваши задачи:</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li><?php echo htmlspecialchars($task); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
