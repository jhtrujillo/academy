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
    
    <div class="user-profile-widget">
        <div class="avatar-wrapper">
            <img src="/uploads/default-avatar.png" alt="Avatar" class="user-avatar" onerror="this.src='https://api.dicebear.com/7.x/bottts/svg?seed=BlueReach'">
            <span class="level-badge">1</span>
        </div>
        <div class="profile-info">
            <span class="profile-name">Blue Reach</span>
            <span class="profile-xp">Nivel 1 • 5 XP</span>
        </div>
    </div>
</aside>
