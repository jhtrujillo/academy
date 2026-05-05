<?php
// Configuración de la Base de Datos (MAMP por defecto)
// Para desplegar en DreamHost/Hostinger, solo debes cambiar estas constantes con tus credenciales de producción.

define('DB_HOST', '127.0.0.1'); // En MAMP o Hostinger suele ser 'localhost' o '127.0.0.1'
define('DB_NAME', 'academy_db');
define('DB_USER', 'root');
define('DB_PASS', 'root'); // MAMP usa 'root' como contraseña por defecto en macOS

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // Evitamos mostrar detalles sensibles del servidor en producción
    die("Error de conexión: No se pudo conectar a la base de datos.");
}
