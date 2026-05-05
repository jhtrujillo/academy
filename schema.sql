-- Base de datos para la Academia - Growth Partner System Replica
-- Compatible con MySQL local (MAMP) y servidores de producción (DreamHost/Hostinger)

CREATE DATABASE IF NOT EXISTS `academy_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `academy_db`;

-- 1. Tabla de Usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol` ENUM('estudiante', 'instructor', 'admin') DEFAULT 'estudiante',
  `puntos` INT DEFAULT 0,
  `nivel` INT DEFAULT 1,
  `avatar` VARCHAR(255) DEFAULT 'default-avatar.png',
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabla de Cursos (LMS)
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255) NOT NULL,
  `descripcion` TEXT,
  `miniatura` VARCHAR(255) DEFAULT 'course-default.png',
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabla de Módulos (LMS)
CREATE TABLE IF NOT EXISTS `modulos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `curso_id` INT NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  `orden` INT DEFAULT 0,
  FOREIGN KEY (`curso_id`) REFERENCES `cursos`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabla de Lecciones (LMS)
CREATE TABLE IF NOT EXISTS `lecciones` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `modulo_id` INT NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  `video_url` VARCHAR(255) NOT NULL, -- URL de Vimeo, YouTube, Wistia o local
  `descripcion` TEXT,
  `orden` INT DEFAULT 0,
  FOREIGN KEY (`modulo_id`) REFERENCES `modulos`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabla de Progreso de Lecciones (LMS)
CREATE TABLE IF NOT EXISTS `progreso_lecciones` (
  `usuario_id` INT NOT NULL,
  `leccion_id` INT NOT NULL,
  `completado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`, `leccion_id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`leccion_id`) REFERENCES `lecciones`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabla de Categorías de la Comunidad
CREATE TABLE IF NOT EXISTS `categorias_comunidad` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL UNIQUE,
  `slug` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabla de Publicaciones (Community Feed)
CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT NOT NULL,
  `categoria_id` INT NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  `contenido` TEXT NOT NULL,
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`categoria_id`) REFERENCES `categorias_comunidad`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabla de Comentarios de Publicaciones
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `post_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `contenido` TEXT NOT NULL,
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tabla de Reacciones (Likes en Posts)
CREATE TABLE IF NOT EXISTS `reacciones` (
  `usuario_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`, `post_id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`post_id`) REFERENCES `posts`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Tabla de Eventos (Calendario)
CREATE TABLE IF NOT EXISTS `eventos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255) NOT NULL,
  `descripcion` TEXT,
  `fecha_evento` DATETIME NOT NULL,
  `enlace_reunion` VARCHAR(255) NOT NULL, -- Enlace de Zoom, Meet, etc.
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- INSERCIÓN DE DATOS DE PRUEBA / SEMILLA INICIAL

-- Insertar Administrador por defecto (Contraseña inicial: 'admin123' hasheada con bcrypt)
-- En producción, el usuario cambiará la contraseña.
INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`, `puntos`, `nivel`) VALUES
('Administrador', 'admin@academia.com', '$2y$10$tZ2pB/89tPcoM7u4V7L/AOHXGZ5E/805IBy9vI5K/Esz0yMh7.H1y', 'admin', 500, 3);

-- Insertar Categorías Básicas de Comunidad
INSERT INTO `categorias_comunidad` (`nombre`, `slug`) VALUES
('Conversación General', 'general'),
('Preguntas Técnicas', 'tecnico'),
('Automatizaciones & IA', 'ia-automatizaciones'),
('Casos de Éxito', 'casos-exito');
