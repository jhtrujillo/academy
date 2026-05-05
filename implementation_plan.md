# Plan de Implementación: Academia Growth Partner System 🎓🚀

Este documento detalla el plan estratégico para construir una plataforma educativa y comunitaria (tipo *Skool* o *Dojo*) con **PHP, MySQL, HTML5, CSS3 de alta gama y JavaScript reactivo**. El sistema estará optimizado para funcionar perfectamente en entornos locales con **MAMP** y será de fácil despliegue en hostings compartidos como **DreamHost** o **Hostinger**.

---

## 🛠️ Stack Tecnológico Seleccionado
Para garantizar compatibilidad absoluta con **DreamHost/Hostinger** (sin requerir servidores dedicados, Node.js ejecutándose continuamente o configuraciones complejas de VPS), utilizaremos:
1. **Backend:** PHP 8.x (Programación Orientada a Objetos, arquitectura MVC limpia, PDO para seguridad contra inyecciones SQL).
2. **Base de Datos:** MySQL (con soporte relacional completo e índices optimizados).
3. **Frontend:** HTML5 semántico, **Vanilla CSS con Custom Properties** (diseño oscuro premium, efectos glassmorphism, microanimaciones fluidas) y **JavaScript (ES6+) con Fetch API/AJAX** para interacciones dinámicas sin recargar la página.
4. **Almacenamiento de Video:** Integración con reproductores de video (YouTube, Vimeo, Wistia o almacenamiento en la nube).

---

## 🗺️ Mapa de Ruta del Desarrollo (Fases)

### Fase 1: Configuración de Entorno, Arquitectura y Base de Datos (MAMP)
*   **Paso 1.1:** Creación de la estructura modular de archivos (MVC o Estructura Modular Limpia):
    *   `/config` (Conexión PDO, constantes del sistema)
    *   `/public` (Punto de entrada `index.php`, CSS, JS, imágenes)
    *   `/includes` (Cabeceras, pies de página, componentes comunes)
    *   `/controllers` (Lógica de autenticación, cursos, comunidad)
    *   `/models` (Consultas seguras a la base de datos)
*   **Paso 1.2:** Diseño y ejecución del script SQL (`schema.sql`) para crear las tablas de base de datos en el phpMyAdmin de MAMP:
    *   `usuarios` (credenciales, rol, avatar, nivel, puntos_totales)
    *   `cursos`, `modulos`, `lecciones` (estructura del LMS)
    *   `lecciones_completadas` (control de progreso)
    *   `posts` y `comentarios` (muro de comunidad)
    *   `reacciones` (likes en posts)
    *   `categorias_comunidad` (canales de conversación)
    *   `eventos` (calendario de sesiones en vivo)

### Fase 2: Diseño UI Premium y Sistema de Estilos
*   **Paso 2.1:** Configuración de `variables.css` con la paleta de colores oscuros inspirada en *Growth Partner System* (negros profundos, dorados/amarillos vibrantes `#EAB308`, grises suaves, bordes semitransparentes).
*   **Paso 2.2:** Integración de tipografía de alta calidad (*Outfit* o *Inter* de Google Fonts) y un set de iconos moderno (como *Phosphor Icons* o *Lucide* cargados localmente o por CDN seguro).
*   **Paso 2.3:** Creación del Layout base responsivo con la barra lateral izquierda de navegación clásica de la plataforma.

### Fase 3: Sistema de Autenticación Seguro
*   **Paso 3.1:** Desarrollo de formularios de registro y login estéticamente deslumbrantes.
*   **Paso 3.2:** Lógica PHP para validación de campos, hash de contraseñas con `password_hash()` y manejo seguro de sesiones (`session_start()`).
*   **Paso 3.3:** Control de acceso por roles (Estudiante, Administrador).

### Fase 4: Módulo LMS (Cursos y Progreso)
*   **Paso 4.1:** Interfaz de visualización de cursos en formato de cuadrícula premium.
*   **Paso 4.2:** Vista detallada de lección con barra lateral de progreso, reproductor de video adaptable e instrucciones/descripción de la clase.
*   **Paso 4.3:** Lógica de "Marcar como completada" que actualice la base de datos de manera asíncrona mediante JavaScript (Fetch API) y asigne puntos de experiencia al usuario.

### Fase 5: Módulo de Comunidad (Growth Partner Club)
*   **Paso 5.1:** Muro de conversación (Feed principal) interactivo.
*   **Paso 5.2:** Creación de publicaciones (posts) y sección de comentarios con hilos de respuestas.
*   **Paso 5.3:** Sistema dinámico de "Likes" / "Me gusta" usando AJAX para una experiencia reactiva fluida.
*   **Paso 5.4:** Filtros rápidos por categorías de conversación ("General", "Preguntas Técnicas", "Automatizaciones").

### Fase 6: Gamificación (Niveles y Leaderboard)
*   **Paso 6.1:** Algoritmo de asignación de puntos (ej: Completar lección: +10 XP, Crear post: +5 XP, Comentar: +2 XP, Recibir like: +1 XP).
*   **Paso 6.2:** Sistema de rangos automáticos (Nivel 1 al Nivel 9) según los puntos acumulados.
*   **Paso 6.3:** Panel de clasificación dinámico con tres pestañas:
    *   *Últimos 7 días*
    *   *Últimos 30 días*
    *   *Histórico de puntos*

### Fase 7: Calendario de Eventos
*   **Paso 7.1:** Creación de una pestaña de "Eventos" interactiva que liste mentorías, directos o videollamadas programadas con un botón de acceso directo (Zoom / Google Meet).

### Fase 8: Panel de Administración (CMS)
*   **Paso 8.1:** Panel de control exclusivo para administradores desde el cual puedan:
    *   Crear, editar o eliminar Cursos, Módulos y Lecciones.
    *   Gestionar usuarios y otorgar roles o ajustar puntos manualmente.
    *   Crear nuevos eventos en el calendario.

### Fase 9: Despliegue e Integración en DreamHost / Hostinger
*   **Paso 9.1:** Configuración de `.htaccess` en Apache para URLs limpias (ej: `/cursos`, `/comunidad`, `/leccion/5`).
*   **Paso 9.2:** Migración de la base de datos de MAMP al phpMyAdmin de DreamHost o Hostinger.
*   **Paso 9.3:** Conexión segura en producción usando variables de configuración centralizadas.
