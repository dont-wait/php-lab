<?php
namespace LabKit;
// Lab 4/bai1/connect.php; Lab 5/buoi5/connect.php.
function config(): array
{
    static $config;
    return $config ??= require dirname(__DIR__).'/config.php';
}
function db(): \PDO
{
    static $connection;
    if (!$connection) {
        $c = config()['database'];
        $connection = new \PDO(
            "mysql:host={$c['host']};port={$c['port']};dbname={$c['name']};charset=utf8mb4",
            $c['username'], $c['password'],
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
             \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
             \PDO::ATTR_EMULATE_PREPARES => false]
        );
    }
    return $connection;
}
