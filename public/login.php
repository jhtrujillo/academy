<?php
session_start();

// Si se envía el formulario por POST, incluir el controlador de autenticación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_GET['action'] = 'login';
    require_once __DIR__ . '/../controllers/auth.php';
}

// Redirigir al index si ya hay sesión activa
if (isset($_SESSION['usuario_id'])) {
    header('Location: /index.php');
    exit;
}

$error = isset($_SESSION['auth_error']) ? $_SESSION['auth_error'] : '';
unset($_SESSION['auth_error']); // Limpiar error
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Academy Dojo</title>
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="/css/style.css">
    
    <style>
        .auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: var(--bg-primary);
            padding: 20px;
        }

        .auth-card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .auth-logo {
            width: 50px;
            height: 50px;
            background-color: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            font-family: var(--font-title);
            font-weight: 800;
            font-size: 1.8rem;
            margin: 0 auto 20px;
            box-shadow: 0 0 20px var(--accent-glow);
        }

        .auth-title {
            font-family: var(--font-title);
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .auth-subtitle {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            width: 18px;
            height: 18px;
        }

        .form-input {
            width: 100%;
            background-color: var(--bg-tertiary);
            border: 1px solid var(--border);
            color: var(--text-primary);
            font-family: var(--font-sans);
            font-size: 0.95rem;
            padding: 12px 12px 12px 42px;
            border-radius: var(--radius-sm);
            outline: none;
            transition: var(--transition);
        }

        .form-input:focus {
            border-color: var(--accent);
            background-color: var(--bg-secondary);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .auth-btn {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            font-weight: 700;
            margin-top: 10px;
            border-radius: var(--radius-sm);
            border: none;
            background-color: var(--accent);
            color: #fff;
            cursor: pointer;
            transition: var(--transition);
        }

        .auth-btn:hover {
            background-color: var(--accent-hover);
            box-shadow: 0 0 15px var(--accent-glow);
        }

        .auth-error-msg {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #ef4444;
            padding: 12px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
        }

        .auth-link {
            display: block;
            margin-top: 24px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
        }

        .auth-link strong {
            color: var(--accent);
        }

        .auth-link:hover {
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">B</div>
            <h2 class="auth-title">Bienvenido al Dojo 🥋</h2>
            <p class="auth-subtitle">Ingresa tus credenciales para acceder a la academia.</p>
            
            <?php if (!empty($error)): ?>
                <div class="auth-error-msg">
                    <i class="lucide-alert-circle" style="width: 18px; height: 18px;"></i>
                    <span><?php echo $error; ?></span>
                </div>
            <?php endif; ?>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label class="form-label" for="email">Correo Electrónico</label>
                    <div class="input-wrapper">
                        <i class="lucide-mail input-icon"></i>
                        <input class="form-input" type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <i class="lucide-lock input-icon"></i>
                        <input class="form-input" type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
                
                <button type="submit" class="auth-btn">Iniciar Sesión</button>
            </form>
            
            <a href="/registro.php" class="auth-link">¿No tienes una cuenta? <strong>Regístrate aquí</strong></a>
        </div>
    </div>
    
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
