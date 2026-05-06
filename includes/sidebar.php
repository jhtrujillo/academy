<?php
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dojo';
?>
<aside class="sidebar">
    <div class="logo-section">
        <div class="logo-icon">B</div>
        <div class="logo-text">Blue Reach</div>
    </div>
    
    <nav>
        <ul class="sidebar-menu">
            <li class="menu-item <?php echo $current_page == 'dojo' ? 'active' : ''; ?>">
                <a href="/index.php?page=dojo">
                    <i class="lucide-home"></i>
                    <span>Dojo (Inicio)</span>
                </a>
            </li>
            <li class="menu-item <?php echo $current_page == 'cursos' ? 'active' : ''; ?>">
                <a href="/index.php?page=cursos">
                    <i class="lucide-book-open"></i>
                    <span>Cursos</span>
                </a>
            </li>
            <li class="menu-item <?php echo $current_page == 'comunidad' ? 'active' : ''; ?>">
                <a href="/index.php?page=comunidad">
                    <i class="lucide-users"></i>
                    <span>Comunidad</span>
                </a>
            </li>
            <li class="menu-item <?php echo $current_page == 'eventos' ? 'active' : ''; ?>">
                <a href="/index.php?page=eventos">
                    <i class="lucide-calendar"></i>
                    <span>Eventos</span>
                </a>
            </li>
            <li class="menu-item <?php echo $current_page == 'clasificacion' ? 'active' : ''; ?>">
                <a href="/index.php?page=clasificacion">
                    <i class="lucide-trophy"></i>
                    <span>Clasificación</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="user-profile-widget" style="flex-direction: column; align-items: stretch; gap: 14px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div class="avatar-wrapper">
                <img src="/uploads/default-avatar.png" alt="Avatar" class="user-avatar" onerror="this.src='https://api.dicebear.com/7.x/bottts/svg?seed=<?php echo urlencode($_SESSION['usuario_nombre'] ?? 'User'); ?>'">
                <span class="level-badge"><?php echo $_SESSION['usuario_nivel'] ?? 1; ?></span>
            </div>
            <div class="profile-info">
                <span class="profile-name"><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Estudiante'); ?></span>
                <span class="profile-xp">Nivel <?php echo $_SESSION['usuario_nivel'] ?? 1; ?> • <?php echo $_SESSION['usuario_puntos'] ?? 0; ?> XP</span>
            </div>
        </div>
        <a href="/logout.php" class="action-link" style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #ef4444; border-top: 1px solid var(--border); padding-top: 10px; width: 100%;">
            <i class="lucide-log-out" style="width: 14px; height: 14px;"></i>
            <span>Cerrar Sesión</span>
        </a>
    </div>
</aside>
