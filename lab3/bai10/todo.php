<?php

$file = 'data.json';
$data = file_exists($file) ? json_decode(file_get_contents($file), true) ?? [] : [];
$action = $_POST['action'] ?? null;

if ($action === 'create' && isset($_POST['todo'])) {
    $data[] = [
        'id' => date('YmdHis').random_int(100, 999),
        'todo' => trim($_POST['todo']),
        'isDone' => false,
    ];
}

if ($action === 'toggle' && isset($_POST['id'])) {
    foreach ($data as &$todo) {
        if ($todo['id'] == $_POST['id']) {
            $todo['isDone'] = $_POST['isDone'] === 'true';
            break;
        }
    }
    unset($todo);
}

if ($action === 'delete' && isset($_POST['id'])) {
    $data = array_values(array_filter($data,
        fn ($todo) => $todo['id'] != $_POST['id']
    ));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
}

header('Content-Type: application/json');
echo json_encode($data);
