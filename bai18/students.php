<?php

function addStudent(array &$students, string $name, float $score): void
{
    $students[] = [
        'name' => $name,
        'score' => $score,
    ];
}

function findTopStudent(array $students): ?array
{
    if ($students === []) {
        return null;
    }

    $topStudent = $students[0];
    foreach ($students as $student) {
        if ($student['score'] > $topStudent['score']) {
            $topStudent = $student;
        }
    }

    return $topStudent;
}

$students = [];
addStudent($students, 'Nguyen Van A', 8.5);
addStudent($students, 'Tran Thi B', 9.25);
addStudent($students, 'Le Van C', 7.75);
addStudent($students, 'Pham Thi D', 9.0);

$topStudent = findTopStudent($students);

echo '<h3>Danh sách sinh viên</h3>';
echo '<table border="1" cellpadding="6" cellspacing="0">';
echo '<tr><th>Họ tên</th><th>Điểm</th></tr>';

foreach ($students as $student) {
    echo '<tr>';
    echo '<td>'.htmlspecialchars($student['name']).'</td>';
    echo '<td>'.htmlspecialchars((string) $student['score']).'</td>';
    echo '</tr>';
}

echo '</table>';

if ($topStudent !== null) {
    echo '<p>Sinh viên có điểm cao nhất: <strong>'.htmlspecialchars($topStudent['name']).'</strong> - '.htmlspecialchars((string) $topStudent['score']).'</p>';
}
