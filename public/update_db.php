<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'djro_db';

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

    // Añadir columna lugares_trabajo si no existe
    $result = $conn->query("SHOW COLUMNS FROM perfiles_dj LIKE 'lugares_trabajo'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE perfiles_dj ADD COLUMN lugares_trabajo TEXT AFTER tipos_evento");
        echo "✅ Columna 'lugares_trabajo' añadida correctamente.";
    } else {
        echo "ℹ️ La columna ya existía.";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
