<?php
$json_data = file_get_contents('php://input');

$tasks = json_decode($json_data, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Неверный JSON формат']);
    exit;
}

$incomplete_tasks = array_filter($tasks, function($task) {
    return isset($task['status']) && $task['status'] !== 'выполнено';
});

header('Content-Type: application/json');
echo json_encode(array_values($incomplete_tasks));
?>