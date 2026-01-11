<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection === null) {
            $host = env('DB_HOST', '127.0.0.1');
            $db = env('DB_NAME', 'tournament');
            $user = env('DB_USER', 'root');
            $pass = env('DB_PASS', '');
            $charset = 'utf8mb4';
            $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

            try {
                self::$connection = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo 'Database connection error.';
                exit;
            }
        }

        return self::$connection;
    }
}
