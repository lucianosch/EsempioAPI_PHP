<?php
$database_file = 'esempio.db';

try {
    $pdo = new PDO("sqlite:$database_file");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Creazione della tabella se non esiste già
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        eta INTEGER NOT NULL
    )");
    } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
