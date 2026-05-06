<?php
session_start();

// Carga de configuración de base de datos
$db_connected = false;
$pdo = null;
if (file_exists(__DIR__ . '/../config/db.php')) {
    require_once __DIR__ . '/../config/db.php';
    if (isset($pdo) && $pdo !== null) {
        $db_connected = true;
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'register') {
        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($nombre) || empty($email) || empty($password)) {
            $_SESSION['auth_error'] = 'Todos los campos son obligatorios.';
            header('Location: /registro.php');
            exit;
        }

        if ($db_connected) {
            // Verificar si el correo ya existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $_SESSION['auth_error'] = 'El correo electrónico ya está registrado.';
                header('Location: /registro.php');
                exit;
            }

            // Crear hash de la contraseña e insertar nuevo usuario
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, rol, puntos, nivel) VALUES (?, ?, ?, 'estudiante', 0, 1)");
            
            try {
                $stmt->execute([$nombre, $email, $password_hashed]);
                $usuario_id = $pdo->lastInsertId();

                // Guardar datos en sesión
                $_SESSION['usuario_id'] = $usuario_id;
                $_SESSION['usuario_nombre'] = $nombre;
                $_SESSION['usuario_email'] = $email;
                $_SESSION['usuario_rol'] = 'estudiante';
                $_SESSION['usuario_puntos'] = 0;
                $_SESSION['usuario_nivel'] = 1;

                header('Location: /index.php');
                exit;
            } catch (PDOException $e) {
                $_SESSION['auth_error'] = 'Error al registrar el usuario. Inténtalo de nuevo.';
                header('Location: /registro.php');
                exit;
            }
        } else {
            // MODO DEMOSTRACIÓN: Registrar usuario en sesión de forma ficticia
            $_SESSION['usuario_id'] = 999;
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_email'] = $email;
            $_SESSION['usuario_rol'] = 'estudiante';
            $_SESSION['usuario_puntos'] = 10;
            $_SESSION['usuario_nivel'] = 1;
            $_SESSION['demo_mode'] = true;

            header('Location: /index.php');
            exit;
        }
    } 
    
    elseif ($action === 'login') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $_SESSION['auth_error'] = 'Todos los campos son obligatorios.';
            header('Location: /login.php');
            exit;
        }

        if ($db_connected) {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Login exitoso
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nombre'] = $user['nombre'];
                $_SESSION['usuario_email'] = $user['email'];
                $_SESSION['usuario_rol'] = $user['rol'];
                $_SESSION['usuario_puntos'] = $user['puntos'];
                $_SESSION['usuario_nivel'] = $user['nivel'];

                header('Location: /index.php');
                exit;
            } else {
                $_SESSION['auth_error'] = 'Correo electrónico o contraseña incorrectos.';
                header('Location: /login.php');
                exit;
            }
        } else {
            // MODO DEMOSTRACIÓN: Permitir acceso con cualquier credencial para testing fluido
            // Si usan las credenciales de Blue Reach facilitadas por el usuario:
            if ($email === 'info.bluereach@gmail.com') {
                $_SESSION['usuario_nombre'] = 'Blue Reach';
                $_SESSION['usuario_puntos'] = 5;
            } else {
                $_SESSION['usuario_nombre'] = explode('@', $email)[0];
                $_SESSION['usuario_puntos'] = 0;
            }

            $_SESSION['usuario_id'] = 888;
            $_SESSION['usuario_email'] = $email;
            $_SESSION['usuario_rol'] = 'estudiante';
            $_SESSION['usuario_nivel'] = 1;
            $_SESSION['demo_mode'] = true;

            header('Location: /index.php');
            exit;
        }
    }
}
