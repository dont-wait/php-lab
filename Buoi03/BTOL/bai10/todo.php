<?php
$file = "data.json";

if (file_exists($file)) {
    $json = file_get_contents($file);
    $data = json_decode($json, true) ?? [];
} else {
    $data = [];
}

$action = $_POST["action"] ?? null;

// Post 
if ($action === "create" && isset($_POST["todo"])) {
    $todo = [
        "id" => date("YmdHis") . random_int(100, 999),
        "todo" => $_POST["todo"],
        "isDone" => false
    ];

    $data[] = $todo;
}

// Update
if ($action === "toggle" && isset($_POST["id"])) {
    foreach ($data as &$todo) {
        if ($todo["id"] == $_POST["id"]) {
            $todo["isDone"] = $_POST["isDone"] === "true";
            break;
        }
    }
    unset($todo);
}

// Delete
if ($action === "delete" && isset($_POST["id"])) {
    $data = array_values(
        array_filter($data, function ($todo) {
            return $todo["id"] != $_POST["id"];
        })
    );
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    file_put_contents(
        $file,
        json_encode(
            $data,
            JSON_PRETTY_PRINT
        )
    );
}

header("Content-Type: application/json");
echo json_encode($data);
?>