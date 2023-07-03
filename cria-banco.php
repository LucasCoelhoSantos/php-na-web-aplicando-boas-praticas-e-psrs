<?php

$dbPath = __DIR__ . "/banco.sqlite";
$pdo = new PDO("sqlite:$dbPath");

$createTableSql = "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY,
        email TEXT,
        password TEXT
    );

    CREATE TABLE IF NOT EXISTS videos (
        id INTEGER PRIMARY KEY,
        url TEXT,
        title TEXT,
        image_path TEXT
    );
";

$pdo->exec($createTableSql);
