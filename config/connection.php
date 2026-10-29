<?php
    // Carrega as variáveis do arquivo .env (na raiz do projeto)
    $envPath = __DIR__ . "/../.env";

    if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            // Ignora comentários e linhas sem "="
            if ($line === "" || $line[0] === "#" || strpos($line, "=") === false) {
                continue;
            }
            list($key, $value) = explode("=", $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
            }
        }
    }

    $host = $_ENV["DB_HOST"] ?? "localhost";
    $dbname = $_ENV["DB_NAME"] ?? "agenda";
    $user = $_ENV["DB_USER"] ?? "root";
    $pass = $_ENV["DB_PASS"] ?? "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

        // Ativar o modo de erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        // erro na conexão
        $error = $e->getMessage();
        echo "Erro: $error";
    }
?>
