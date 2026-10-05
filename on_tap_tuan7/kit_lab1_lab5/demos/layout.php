<?php
function page(string $title): void
{
    echo '<!doctype html><html lang="vi"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>'.LabKit\escape($title).'</title></head><body>';
    echo '<p><a href="index.php">Mục lục kit</a></p><h1>'.LabKit\escape($title).'</h1>';
}
function endPage(): void { echo '</body></html>'; }
