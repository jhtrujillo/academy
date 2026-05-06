<?php
// Inicialización de Sesiones
session_start();

// Control de Acceso: Redirigir al login si no hay sesión activa
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /login.php');
    exit;
}

// Carga de Configuración de Base de Datos
$db_connected = false;
if (file_exists(__DIR__ . '/../config/db.php')) {
    try {
        require_once __DIR__ . '/../config/db.php';
        if (isset($pdo)) {
            $db_connected = true;
        }
    } catch (Exception $e) {
        // Fallback si no está importado el schema.sql
        $db_connected = false;
    }
}

// Enrutador de Páginas
$page = isset($_GET['page']) ? $_GET['page'] : 'dojo';
$valid_pages = ['dojo', 'cursos', 'comunidad', 'eventos', 'clasificacion', 'leccion'];

if (!in_array($page, $valid_pages)) {
    $page = 'dojo';
}

// Configuración de Título de Página
$page_titles = [
    'dojo' => 'Dashboard Dojo',
    'cursos' => 'Programas de Aprendizaje',
    'comunidad' => 'Growth Partner Club',
    'eventos' => 'Eventos y Mentorías',
    'clasificacion' => 'Tabla de Clasificación',
    'leccion' => 'Aula Virtual'
];
$page_title = $page_titles[$page];

// Incluir Cabecera Común
require_once __DIR__ . '/../includes/header.php';

// Incluir Barra Lateral de Navegación
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <header class="top-bar">
        <h1 class="page-title"><?php echo $page_title; ?></h1>
        <div class="action-buttons">
            <?php if (!$db_connected): ?>
                <span class="btn" style="background-color: #ef4444; color: #fff; cursor: default;">
                    <i class="lucide-database-backup"></i> DB Desconectada (Modo Demostración)
                </span>
            <?php endif; ?>
            <a href="#" class="btn btn-primary">
                <i class="lucide-plus"></i> Nueva Publicación
            </a>
        </div>
    </header>

    <div class="content-body">
        <?php
        // Cargar vista de la página activa de forma dinámica
        switch ($page) {
            case 'dojo':
                ?>
                <div class="grid-layout" style="grid-template-columns: 2fr 1fr;">
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <div class="card" style="background: linear-gradient(135deg, var(--bg-secondary), rgba(234, 179, 8, 0.05)); border-color: var(--accent);">
                            <h2 style="font-family: var(--font-title); font-size: 1.5rem; margin-bottom: 12px; color: var(--accent);">
                                ¡Bienvenido al Dojo, <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Estudiante'); ?>! 🥋🔥
                            </h2>
                            <p style="color: var(--text-secondary); margin-bottom: 20px;">
                                Aquí empieza tu camino para convertirte en un Growth Partner profesional de primer nivel. Completa las lecciones, participa activamente en la comunidad para ganar XP y sube de nivel.
                            </p>
                            <a href="/index.php?page=cursos" class="btn btn-primary">Ver mis cursos</a>
                        </div>
                        
                        <div class="card">
                            <h3 style="font-family: var(--font-title); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                                <i class="lucide-flame" style="color: var(--accent);"></i> Actividad Reciente del Club
                            </h3>
                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                <div style="display: flex; align-items: flex-start; gap: 12px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
                                    <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=Cesar" style="width: 36px; height: 36px; border-radius: 50%;" alt="User">
                                    <div>
                                        <h5 style="font-weight: 600;">Cesar A.</h5>
                                        <p style="font-size: 0.9rem; color: var(--text-secondary);">"¡Acabo de agendar mi primera llamada de prospección usando los scripts del Dojo!"</p>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: flex-start; gap: 12px;">
                                    <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=Maria" style="width: 36px; height: 36px; border-radius: 50%;" alt="User">
                                    <div>
                                        <h5 style="font-weight: 600;">María José</h5>
                                        <p style="font-size: 0.9rem; color: var(--text-secondary);">"El módulo de automatización me voló la cabeza. ¡Recomendado!"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <div class="card">
                            <h3 style="font-family: var(--font-title); margin-bottom: 16px; font-size: 1.2rem;">Tu Progreso</h3>
                            <div style="background-color: var(--bg-tertiary); height: 10px; border-radius: 5px; overflow: hidden; margin-bottom: 10px;">
                                <div style="background-color: var(--accent); width: 15%; height: 100%;"></div>
                            </div>
                            <span style="font-size: 0.85rem; color: var(--text-secondary);">15% Completado del Dojo Inicial</span>
                        </div>
                        
                        <div class="card">
                            <h3 style="font-family: var(--font-title); margin-bottom: 16px; font-size: 1.2rem; display: flex; align-items: center; gap: 8px;">
                                <i class="lucide-calendar" style="color: var(--accent);"></i> Siguiente Evento
                            </h3>
                            <h4 style="font-weight: 600; margin-bottom: 4px;">Mentoría Grupal en Directo</h4>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px;">Hoy a las 6:00 PM</p>
                            <a href="#" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.85rem; width: fit-content;">Unirme a Zoom</a>
                        </div>
                    </div>
                </div>
                <?php
                break;

            case 'cursos':
                ?>
                <div class="grid-layout">
                    <!-- Tarjeta de Curso 1 -->
                    <div class="card" style="padding: 0; overflow: hidden;">
                        <div style="height: 160px; background: linear-gradient(135deg, #1e3a8a, #0f172a); display: flex; align-items: center; justify-content: center; font-family: var(--font-title); font-size: 1.5rem; font-weight: 700; color: var(--accent);">
                            PRIMEROS PASOS
                        </div>
                        <div style="padding: 20px;">
                            <h3 style="font-family: var(--font-title); margin-bottom: 8px;">Growth Partner: Primeros Pasos</h3>
                            <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 16px;">Por Andreti Page. Fundamentos, mentalidad y modelo de negocio del socio de crecimiento.</p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 0.8rem; color: var(--accent);">12 Lecciones</span>
                                <a href="/index.php?page=leccion&id=1" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.85rem;">Acceder</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta de Curso 2 -->
                    <div class="card" style="padding: 0; overflow: hidden;">
                        <div style="height: 160px; background: linear-gradient(135deg, #5b21b6, #1e1b4b); display: flex; align-items: center; justify-content: center; font-family: var(--font-title); font-size: 1.5rem; font-weight: 700; color: var(--accent);">
                            LAS HERRAMIENTAS
                        </div>
                        <div style="padding: 20px;">
                            <h3 style="font-family: var(--font-title); margin-bottom: 8px;">Growth Partner: Herramientas</h3>
                            <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 16px;">Por Santi Jiménez. Configuración técnica, integraciones de software y automatizaciones.</p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 0.8rem; color: var(--accent);">8 Lecciones</span>
                                <a href="/index.php?page=leccion&id=5" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.85rem;">Acceder</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta de Curso 3 -->
                    <div class="card" style="padding: 0; overflow: hidden;">
                        <div style="height: 160px; background: linear-gradient(135deg, #155e75, #083344); display: flex; align-items: center; justify-content: center; font-family: var(--font-title); font-size: 1.5rem; font-weight: 700; color: var(--accent);">
                            CAMPAÑAS
                        </div>
                        <div style="padding: 20px;">
                            <h3 style="font-family: var(--font-title); margin-bottom: 8px;">Growth Partner: Campañas</h3>
                            <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 16px;">Por David Parada. Estrategias de adquisición de tráfico y campañas de publicidad.</p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 0.8rem; color: var(--accent);">10 Lecciones</span>
                                <a href="/index.php?page=leccion&id=7" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.85rem;">Acceder</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                break;

            case 'comunidad':
                ?>
                <div class="feed-layout">
                    <div>
                        <!-- Creador de Publicación -->
                        <div class="post-composer">
                            <textarea rows="3" placeholder="¿Qué tienes en mente hoy, Blue Reach? Comparte tus ideas..."></textarea>
                            <div class="composer-actions">
                                <span style="font-size: 0.85rem; color: var(--text-muted);">Usa un tono constructivo y profesional</span>
                                <button class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">Publicar</button>
                            </div>
                        </div>
                        
                        <!-- Lista de Posts -->
                        <div class="card post-card">
                            <div class="post-header">
                                <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=Edison" class="post-author-avatar" alt="Avatar">
                                <div class="post-meta">
                                    <span class="post-author-name">Edison Anzola</span>
                                    <span class="post-time">Hace 2 horas • Categoría: General</span>
                                </div>
                            </div>
                            <div class="post-body">
                                <h3>¡Objetivo cumplido esta semana! 🎉</h3>
                                <p style="margin-top: 10px;">Acabo de cerrar un trato de Growth Partner con un e-commerce local. Vamos a trabajar a un esquema de fee base + 10% del incremento de las ventas mensuales. ¡Los scripts de venta funcionan a la perfección!</p>
                            </div>
                            <div class="post-footer">
                                <a href="#" class="action-link"><i class="lucide-thumbs-up"></i> <span>15 Likes</span></a>
                                <a href="#" class="action-link"><i class="lucide-message-square"></i> <span>4 Comentarios</span></a>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="card">
                            <h3 style="font-family: var(--font-title); margin-bottom: 16px;">Canales</h3>
                            <ul style="list-style: none; display: flex; flex-direction: column; gap: 10px;">
                                <li><a href="#" style="color: var(--accent); text-decoration: none; font-weight: 600;">📣 Conversación General</a></li>
                                <li><a href="#" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition);">💻 Preguntas Técnicas</a></li>
                                <li><a href="#" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition);">🤖 Automatizaciones & IA</a></li>
                                <li><a href="#" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition);">🏆 Casos de Éxito</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                break;

            case 'eventos':
                ?>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div class="card" style="display: flex; justify-content: space-between; align-items: center; gap: 20px;">
                        <div>
                            <span style="background-color: var(--accent-glow); color: var(--accent); padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 700;">HOY</span>
                            <h3 style="font-family: var(--font-title); margin-top: 10px;">Sesión de Preguntas y Respuestas (Q&A)</h3>
                            <p style="color: var(--text-secondary); margin-top: 4px;">Mentoría grupal para resolver dudas técnicas de automatizaciones e integraciones.</p>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 8px;">Hora: 6:00 PM • Enlace: Zoom</p>
                        </div>
                        <a href="#" class="btn btn-primary">Unirse</a>
                    </div>
                    
                    <div class="card" style="display: flex; justify-content: space-between; align-items: center; gap: 20px; opacity: 0.7;">
                        <div>
                            <span style="background-color: var(--bg-tertiary); color: var(--text-secondary); padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 700;">MAÑANA</span>
                            <h3 style="font-family: var(--font-title); margin-top: 10px;">Masterclass: Publicidad Digital de Alto Retorno</h3>
                            <p style="color: var(--text-secondary); margin-top: 4px;">Impartido por David Parada. Técnicas avanzadas de optimización de anuncios.</p>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 8px;">Hora: 5:00 PM • Enlace: Zoom</p>
                        </div>
                        <a href="#" class="btn btn-primary" style="background-color: var(--bg-tertiary); color: var(--text-primary); cursor: default;">Registrado</a>
                    </div>
                </div>
                <?php
                break;

            case 'clasificacion':
                ?>
                <div class="card" style="padding: 0;">
                    <div style="padding: 24px; border-bottom: 1px solid var(--border);">
                        <h3 style="font-family: var(--font-title); font-size: 1.25rem;">Tabla de Clasificación Histórica</h3>
                        <p style="font-size: 0.85rem; color: var(--text-secondary);">Gana puntos de experiencia (XP) ayudando a otros y completando módulos de la plataforma.</p>
                    </div>
                    <div class="leaderboard-table">
                        <div class="leaderboard-row">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <span class="member-rank rank-gold">#1</span>
                                <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=ADR" style="width: 40px; height: 40px; border-radius: 50%;" alt="User">
                                <span style="font-weight: 600;">ADR AC</span>
                            </div>
                            <span style="font-weight: 700; color: var(--accent);">+2054 XP</span>
                        </div>
                        <div class="leaderboard-row">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <span class="member-rank rank-silver">#2</span>
                                <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=Juan" style="width: 40px; height: 40px; border-radius: 50%;" alt="User">
                                <span style="font-weight: 600;">Juan Carlos</span>
                            </div>
                            <span style="font-weight: 700; color: var(--text-secondary);">+858 XP</span>
                        </div>
                        <div class="leaderboard-row">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <span class="member-rank rank-bronze">#3</span>
                                <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=Axel" style="width: 40px; height: 40px; border-radius: 50%;" alt="User">
                                <span style="font-weight: 600;">Axel Gonzalez</span>
                            </div>
                            <span style="font-weight: 700; color: #D97706;">+799 XP</span>
                        </div>
                    </div>
                </div>
                <?php
                break;

            case 'leccion':
                // Datos estáticos de alta fidelidad para Cursos, Módulos y Lecciones
                $all_courses = [
                    1 => [
                        'titulo' => 'Growth Partner: Primeros Pasos',
                        'modulos' => [
                            1 => [
                                'titulo' => 'Módulo 1: Introducción y Mentalidad',
                                'lecciones' => [
                                    1 => ['id' => 1, 'titulo' => '¿Qué es un Growth Partner?', 'video' => 'https://assets.mixkit.co/videos/preview/mixkit-working-with-a-drawing-tablet-in-office-43037-large.mp4', 'desc' => 'Fundamentos y definición del rol del socio de crecimiento para negocios locales e infoproductores.'],
                                    2 => ['id' => 2, 'titulo' => 'La mentalidad del Socio de Crecimiento', 'video' => 'https://assets.mixkit.co/videos/preview/mixkit-corporate-woman-working-on-her-laptop-42354-large.mp4', 'desc' => 'Cómo pasar de ser un simple prestador de servicios transaccionales a un socio estratégico de alto valor.']
                                ]
                            ],
                            2 => [
                                'titulo' => 'Módulo 2: El Modelo de Negocios',
                                'lecciones' => [
                                    3 => ['id' => 3, 'titulo' => 'Estructuración de Ofertas High-Ticket', 'video' => 'https://assets.mixkit.co/videos/preview/mixkit-business-partners-working-on-a-presentation-43015-large.mp4', 'desc' => 'Diseño de ofertas irresistibles basadas en resultados para atraer clientes premium.'],
                                    4 => ['id' => 4, 'titulo' => 'Esquemas de Ganancia Variable', 'video' => 'https://assets.mixkit.co/videos/preview/mixkit-woman-working-at-office-with-dual-monitors-42995-large.mp4', 'desc' => 'Fórmulas y contratos legales para asegurar comisiones recurrentes sobre la facturación de tus clientes.']
                                ]
                            ]
                        ]
                    ],
                    5 => [
                        'titulo' => 'Growth Partner: Herramientas',
                        'modulos' => [
                            3 => [
                                'titulo' => 'Módulo 1: Automatizaciones con Make',
                                'lecciones' => [
                                    5 => ['id' => 5, 'titulo' => 'Introducción a Make y APIs', 'video' => 'https://assets.mixkit.co/videos/preview/mixkit-woman-hands-typing-on-laptop-keyboard-41718-large.mp4', 'desc' => 'Aprende los fundamentos de las automatizaciones de procesos de negocios usando Make.com.'],
                                    6 => ['id' => 6, 'titulo' => 'Automatización de Agenda con Calendly', 'video' => 'https://assets.mixkit.co/videos/preview/mixkit-close-up-of-hands-typing-on-a-keyboard-43017-large.mp4', 'desc' => 'Configuración de embudos de agendamiento automatizado sin intervención humana.']
                                ]
                            ]
                        ]
                    ],
                    7 => [
                        'titulo' => 'Growth Partner: Campañas',
                        'modulos' => [
                            4 => [
                                'titulo' => 'Módulo 1: Publicidad en Meta',
                                'lecciones' => [
                                    7 => ['id' => 7, 'titulo' => 'Estructura de Campaña Ganadora', 'video' => 'https://assets.mixkit.co/videos/preview/mixkit-designing-a-mobile-app-interface-on-computer-43034-large.mp4', 'desc' => 'Configuración de públicos, presupuestos y anuncios optimizados en Facebook & Instagram Ads.'],
                                    8 => ['id' => 8, 'titulo' => 'Análisis de Métricas Clave', 'video' => 'https://assets.mixkit.co/videos/preview/mixkit-hands-typing-on-laptop-with-analytics-on-screen-43026-large.mp4', 'desc' => 'Lectura e interpretación de ROAS, CTR, y CPC para optimizar tus anuncios digitales de forma correcta.']
                                ]
                            ]
                        ]
                    ]
                ];

                $active_lesson_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
                $active_course = null;
                $active_module = null;
                $active_lesson = null;

                foreach ($all_courses as $c_id => $course) {
                    foreach ($course['modulos'] as $m_id => $mod) {
                        if (isset($mod['lecciones'][$active_lesson_id])) {
                            $active_course = $course;
                            $active_module = $mod;
                            $active_lesson = $mod['lecciones'][$active_lesson_id];
                            break 2;
                        }
                    }
                }

                // Fallback si no existe la lección
                if (!$active_lesson) {
                    $active_course = $all_courses[1];
                    $active_module = $all_courses[1]['modulos'][1];
                    $active_lesson = $all_courses[1]['modulos'][1]['lecciones'][1];
                    $active_lesson_id = 1;
                }
                ?>
                <div class="grid-layout" style="grid-template-columns: 2fr 1fr; gap: 30px; align-items: start;">
                    <!-- LADO IZQUIERDO: Reproductor y Detalles -->
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <div class="card" style="padding: 0; overflow: hidden; border-color: var(--border);">
                            <div style="position: relative; padding-top: 56.25%; background: #000; width: 100%;">
                                <video id="lessonVideo" controls style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="<?php echo $active_lesson['video']; ?>"></video>
                            </div>
                            <div style="padding: 24px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; gap: 16px; flex-wrap: wrap;">
                                    <h2 style="font-family: var(--font-title); font-size: 1.6rem; font-weight: 700; color: var(--text-primary); margin: 0;"><?php echo htmlspecialchars($active_lesson['titulo']); ?></h2>
                                    <button id="completeBtn" onclick="markCompleted()" class="btn btn-primary" style="padding: 10px 20px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                                        <i class="lucide-check-circle"></i> <span>Marcar como Completada</span>
                                    </button>
                                </div>
                                <span style="background-color: var(--bg-tertiary); color: var(--accent); padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; margin-bottom: 16px; display: inline-block;">
                                    <?php echo htmlspecialchars($active_course['titulo']); ?>
                                </span>
                                <p style="color: var(--text-secondary); line-height: 1.6; font-size: 1rem;"><?php echo htmlspecialchars($active_lesson['desc']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- LADO DERECHO: Plan de Estudios (Syllabus) -->
                    <div style="display: flex; flex-direction: column; gap: 24px; position: sticky; top: 20px;">
                        <div class="card" style="padding: 24px;">
                            <h3 style="font-family: var(--font-title); margin-bottom: 20px; font-size: 1.25rem; font-weight: 700; color: var(--text-primary); border-bottom: 1px solid var(--border); padding-bottom: 12px; display: flex; align-items: center; gap: 10px;">
                                <i class="lucide-book-open" style="color: var(--accent);"></i> Contenido del Curso
                            </h3>
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <?php foreach ($active_course['modulos'] as $m_id => $mod): ?>
                                    <div>
                                        <h4 style="font-family: var(--font-title); font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin-bottom: 10px;"><?php echo htmlspecialchars($mod['titulo']); ?></h4>
                                        <ul style="list-style: none; display: flex; flex-direction: column; gap: 8px; padding-left: 8px; border-left: 2px solid var(--border);">
                                            <?php foreach ($mod['lecciones'] as $l_id => $lecc): ?>
                                                <li class="menu-item" style="border: none; padding: 0;">
                                                    <a href="/index.php?page=leccion&id=<?php echo $lecc['id']; ?>" style="display: flex; align-items: center; justify-content: space-between; text-decoration: none; padding: 8px 12px; border-radius: var(--radius-sm); font-size: 0.85rem; width: 100%; transition: var(--transition); <?php echo $lecc['id'] == $active_lesson_id ? 'color: var(--accent); background-color: var(--accent-glow); border-left: 3px solid var(--accent); font-weight: 600;' : 'color: var(--text-secondary);'; ?>">
                                                        <span style="display: flex; align-items: center; gap: 8px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                            <i class="<?php echo $lecc['id'] == $active_lesson_id ? 'lucide-play' : 'lucide-play-circle'; ?>" style="width: 14px; height: 14px; flex-shrink: 0;"></i>
                                                            <span><?php echo htmlspecialchars($lecc['titulo']); ?></span>
                                                        </span>
                                                        <i class="lucide-circle" style="width: 12px; height: 12px; color: var(--text-muted); flex-shrink: 0;"></i>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Efecto visual premium e interactividad al completar lección -->
                <script>
                    function markCompleted() {
                        const btn = document.getElementById('completeBtn');
                        btn.style.backgroundColor = '#10b981'; // Esmeralda de completado
                        btn.style.boxShadow = '0 0 15px rgba(16, 185, 129, 0.3)';
                        btn.innerHTML = '<i class="lucide-check-circle-2"></i> <span>¡Completada! +50 XP</span>';
                        btn.disabled = true;

                        // Crear animación de confeti o felicitación flotante premium
                        const container = document.querySelector('.main-content');
                        const toast = document.createElement('div');
                        toast.style.position = 'fixed';
                        toast.style.bottom = '24px';
                        toast.style.right = '24px';
                        toast.style.backgroundColor = '#10b981';
                        toast.style.color = '#fff';
                        toast.style.padding = '16px 24px';
                        toast.style.borderRadius = 'var(--radius-md)';
                        toast.style.boxShadow = '0 10px 15px -3px rgba(0,0,0,0.1)';
                        toast.style.display = 'flex';
                        toast.style.alignItems = 'center';
                        toast.style.gap = '12px';
                        toast.style.zIndex = '1000';
                        toast.style.fontFamily = 'var(--font-title)';
                        toast.style.fontWeight = '700';
                        toast.innerHTML = '<i class="lucide-trophy"></i> <span>¡Felicidades! +50 XP ganados</span>';
                        document.body.appendChild(toast);

                        setTimeout(() => {
                            toast.style.opacity = '0';
                            toast.style.transition = 'opacity 0.5s ease';
                            setTimeout(() => toast.remove(), 500);
                        }, 3000);
                    }
                </script>
                <?php
                break;
        }
        ?>
    </div>
</main>

<?php
// Incluir Pie de Página Común
require_once __DIR__ . '/../includes/footer.php';
?>
