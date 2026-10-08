-- Base de datos: `nexus_escolar`

CREATE DATABASE IF NOT EXISTS `nexus_escolar` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `nexus_escolar`;

-- --------------------------------------------------------

-- Tabla `usuarios`
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `rol` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password es admin123 (hasheado con bcrypt)
INSERT INTO `usuarios` (`usuario`, `password`, `nombre`, `rol`) VALUES
('admin', '$2y$10$1CWuTyqnFFeUmhlHm3APq.CJbB7ZmgJyJtWmXfZY8Y4VIbWMeSloK', 'Administrador Principal', 'Administrador');

-- --------------------------------------------------------

-- Tabla `alumnos`
CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `grupo_asignado` varchar(20) DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `alumnos` (`matricula`, `nombre`, `apellido_paterno`, `apellido_materno`, `fecha_nacimiento`, `sexo`, `correo`, `telefono`, `grupo_asignado`, `estado`) VALUES
('ALU001', 'Juan', 'Pérez', 'García', '2005-03-15', 'Masculino', 'juan.perez@email.com', '5551234567', '1A', 'Activo'),
('ALU002', 'María', 'López', 'Martínez', '2005-06-22', 'Femenino', 'maria.lopez@email.com', '5552345678', '1A', 'Activo'),
('ALU003', 'Carlos', 'González', 'Rodríguez', '2004-11-10', 'Masculino', 'carlos.gonzalez@email.com', '5553456789', '1B', 'Activo'),
('ALU004', 'Ana', 'Hernández', 'Sánchez', '2005-01-05', 'Femenino', 'ana.hernandez@email.com', '5554567890', '1B', 'Activo'),
('ALU005', 'Luis', 'Ramírez', 'Flores', '2004-08-30', 'Masculino', 'luis.ramirez@email.com', '5555678901', '2A', 'Activo'),
('ALU006', 'Laura', 'Torres', 'Rivera', '2004-12-12', 'Femenino', 'laura.torres@email.com', '5556789012', '2A', 'Activo'),
('ALU007', 'Diego', 'Gómez', 'Díaz', '2003-05-20', 'Masculino', 'diego.gomez@email.com', '5557890123', '2B', 'Activo'),
('ALU008', 'Sofía', 'Vázquez', 'Reyes', '2003-09-08', 'Femenino', 'sofia.vazquez@email.com', '5558901234', '2B', 'Activo'),
('ALU009', 'Jorge', 'Morales', 'Cruz', '2005-02-28', 'Masculino', 'jorge.morales@email.com', '5559012345', '1A', 'Inactivo'),
('ALU010', 'Elena', 'Ortiz', 'Méndez', '2004-07-16', 'Femenino', 'elena.ortiz@email.com', '5550123456', '1B', 'Activo');

-- --------------------------------------------------------

-- Tabla `docentes`
CREATE TABLE `docentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_empleado` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `especialidad` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_empleado` (`numero_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `docentes` (`numero_empleado`, `nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `telefono`, `especialidad`, `estado`) VALUES
('DOC001', 'Roberto', 'Silva', 'Castro', 'roberto.silva@email.com', '5551112222', 'Matemáticas', 'Activo'),
('DOC002', 'Patricia', 'Rojas', 'Molina', 'patricia.rojas@email.com', '5553334444', 'Ciencias', 'Activo'),
('DOC003', 'Miguel', 'Jiménez', 'Ruiz', 'miguel.jimenez@email.com', '5555556666', 'Historia', 'Activo'),
('DOC004', 'Carmen', 'Herrera', 'Salazar', 'carmen.herrera@email.com', '5557778888', 'Literatura', 'Activo'),
('DOC005', 'Fernando', 'Aguilar', 'Soto', 'fernando.aguilar@email.com', '5559990000', 'Informática', 'Activo');

-- --------------------------------------------------------

-- Tabla `materias`
CREATE TABLE `materias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(20) NOT NULL,
  `nombre_materia` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `creditos` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `clave` (`clave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `materias` (`clave`, `nombre_materia`, `descripcion`, `creditos`, `estado`) VALUES
('MAT101', 'Álgebra', 'Introducción al álgebra básica', 8, 'Activo'),
('CIE101', 'Biología', 'Estudio de los seres vivos', 8, 'Activo'),
('HIS101', 'Historia Universal', 'Historia desde la antigüedad hasta la era moderna', 6, 'Activo'),
('LIT101', 'Taller de Lectura y Redacción', 'Desarrollo de habilidades de escritura y lectura', 6, 'Activo'),
('INF101', 'Computación Básica', 'Introducción a la informática y ofimática', 4, 'Activo'),
('MAT102', 'Geometría', 'Geometría plana y del espacio', 8, 'Activo');

-- --------------------------------------------------------

-- Tabla `grupos`
CREATE TABLE `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(20) NOT NULL,
  `grado` int(11) NOT NULL,
  `semestre` varchar(20) NOT NULL,
  `turno` varchar(20) NOT NULL,
  `docente_responsable_id` int(11) DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`),
  KEY `docente_responsable_id` (`docente_responsable_id`),
  CONSTRAINT `fk_grupo_docente` FOREIGN KEY (`docente_responsable_id`) REFERENCES `docentes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `grupos` (`nombre_grupo`, `grado`, `semestre`, `turno`, `docente_responsable_id`, `estado`) VALUES
('1A', 1, 'Primero', 'Matutino', 1, 'Activo'),
('1B', 1, 'Primero', 'Vespertino', 2, 'Activo'),
('2A', 2, 'Tercero', 'Matutino', 3, 'Activo'),
('2B', 2, 'Tercero', 'Vespertino', 4, 'Activo');

-- --------------------------------------------------------

-- Tabla `inscripciones`
CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`),
  KEY `alumno_id` (`alumno_id`),
  KEY `grupo_id` (`grupo_id`),
  CONSTRAINT `fk_inscripcion_alumno` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_inscripcion_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `inscripciones` (`alumno_id`, `grupo_id`, `fecha_inscripcion`, `estado`) VALUES
(1, 1, '2023-08-15', 'Activo'),
(2, 1, '2023-08-15', 'Activo'),
(3, 2, '2023-08-16', 'Activo'),
(4, 2, '2023-08-16', 'Activo'),
(5, 3, '2023-08-17', 'Activo'),
(6, 3, '2023-08-17', 'Activo'),
(7, 4, '2023-08-18', 'Activo'),
(8, 4, '2023-08-18', 'Activo');

-- --------------------------------------------------------

-- Tabla `calificaciones`
CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `parcial_1` decimal(5,2) DEFAULT 0.00,
  `parcial_2` decimal(5,2) DEFAULT 0.00,
  `parcial_3` decimal(5,2) DEFAULT 0.00,
  `promedio` decimal(5,2) DEFAULT 0.00,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alumno_id` (`alumno_id`),
  KEY `materia_id` (`materia_id`),
  KEY `docente_id` (`docente_id`),
  CONSTRAINT `fk_calificacion_alumno` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_calificacion_materia` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_calificacion_docente` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `calificaciones` (`alumno_id`, `materia_id`, `docente_id`, `parcial_1`, `parcial_2`, `parcial_3`, `promedio`, `observaciones`) VALUES
(1, 1, 1, 8.50, 9.00, 8.00, 8.50, 'Buen desempeño'),
(1, 2, 2, 7.00, 8.00, 7.50, 7.50, 'Regular'),
(2, 1, 1, 9.50, 10.00, 9.00, 9.50, 'Excelente'),
(3, 3, 3, 6.00, 7.00, 6.50, 6.50, 'Requiere apoyo'),
(4, 4, 4, 10.00, 9.50, 10.00, 9.83, 'Sobresaliente');
