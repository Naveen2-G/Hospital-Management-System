<?php
// Read .env to find DB config
$envPath = __DIR__ . '/.env';
if (!file_exists($envPath)) { die(".env not found\n"); }

$env = [];
foreach (file($envPath) as $line) {
    $line = trim($line);
    if ($line && !str_starts_with($line, '#') && str_contains($line, '=')) {
        [$k, $v] = explode('=', $line, 2);
        $env[trim($k)] = trim($v, '"\'');
    }
}

$conn = $env['DB_CONNECTION'] ?? 'sqlite';

try {
    if ($conn === 'sqlite') {
        $dbFile = $env['DB_DATABASE'] ?? __DIR__ . '/database/database.sqlite';
        if (!str_starts_with($dbFile, '/') && !preg_match('/^[A-Z]:/i', $dbFile)) {
            $dbFile = __DIR__ . '/database/' . $dbFile;
        }
        if (!file_exists($dbFile)) { die("SQLite file not found: $dbFile\n"); }
        $pdo = new PDO("sqlite:$dbFile");
    } else {
        $host = $env['DB_HOST'] ?? '127.0.0.1';
        $port = $env['DB_PORT'] ?? '3306';
        $db   = $env['DB_DATABASE'] ?? 'hms';
        $user = $env['DB_USERNAME'] ?? 'root';
        $pass = $env['DB_PASSWORD'] ?? '';
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to $conn database.\n";

    // Check existing columns
    if ($conn === 'sqlite') {
        $cols = $pdo->query("PRAGMA table_info(patients)")->fetchAll(PDO::FETCH_COLUMN, 1);
    } else {
        $cols = $pdo->query("SHOW COLUMNS FROM patients")->fetchAll(PDO::FETCH_COLUMN);
    }

    $needed = ['allergies' => 'TEXT', 'chronic_diseases' => 'TEXT', 'avatar' => 'VARCHAR(255)'];
    $added = [];
    foreach ($needed as $col => $type) {
        if (!in_array($col, $cols)) {
            $pdo->exec("ALTER TABLE patients ADD COLUMN $col $type");
            $added[] = $col;
        }
    }

    echo empty($added) ? "All columns already exist. No changes made.\n"
        : "Successfully added: " . implode(', ', $added) . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
