-- Base de datos institucional: plataforma_proyecto
CREATE DATABASE IF NOT EXISTS plataforma_proyecto;
USE plataforma_proyecto;

-- Tabla: cursos
CREATE TABLE cursos (
  idCurso BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT
  codigo VARCHAR(20) NOT NULL UNIQUE COMMENT,
  nombre VARCHAR(100) NOT NULL COMMENT,
  requisitos TEXT DEFAULT NULL COMMENT,
  creditos INT(11) NOT NULL COMMENT,
  horario VARCHAR(100) NOT NULL COMMENT,
  idProfesor BIGINT(20) UNSIGNED DEFAULT NULL COMMENT,
  PRIMARY KEY (idCurso),
  KEY fk_cursos_profesor (idProfesor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Datos de ejemplo: cursos
INSERT INTO cursos (codigo, nombre, requisitos, creditos, horario, idProfesor) VALUES
('INF-101', 'Introducción a la Informática', '', 3, 'L 6:00pm a 9:00pm', 2),
('ARQ-112', 'Diseño Arquitectónico', 'INQ', 4, 'S 10:00pm a 1:00pm', 5);


-- Tabla: profesores
CREATE TABLE profesores (
  idProfesor BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT,
  tipoIdentificacion VARCHAR(100) NOT NULL COMMENT,
  identificacion VARCHAR(20) NOT NULL COMMENT,
  nombre VARCHAR(100) NOT NULL COMMENT,
  gradoAcademico VARCHAR(100) NOT NULL COMMENT,
  fechaNacimiento DATE DEFAULT NULL COMMENT,
  correo VARCHAR(100) DEFAULT NULL COMMENT,
  telefono VARCHAR(20) DEFAULT NULL COMMENT,
  horarioAtencion VARCHAR(100) DEFAULT NULL COMMENT,
  genero VARCHAR(10) NOT NULL COMMENT,
  id_curso BIGINT(20) UNSIGNED DEFAULT NULL COMMENT,
  PRIMARY KEY (idProfesor),
  KEY fk_profesor_curso (id_curso)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Datos de ejemplo: profesores
INSERT INTO profesores (tipoIdentificacion, identificacion, nombre, gradoAcademico, correo, telefono, horarioAtencion, genero, id_curso) VALUES
('Cédula Física Nacional', '119753630', 'Marcela Barahona Fernández', 'Lic. en Administración de Empresas', 'MbarahonafA@uc.cr', '70651789', 'L a V 3:00 pm a 6:00 pm', 'mujer', 6),
('Cédula Física Nacional', '113874563', 'Karina Zamora Tercero', 'M.Sc. en Lengua Extranjera con énfasis en educación.', 'Kzamorat@uc.cr', '60397412', 'J a V 5:00 pm a 7:00 pm', 'mujer', 5);


-- Tabla: estudiantes
CREATE TABLE estudiantes (
  idEstudiante BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT,
  tipoIdentificacion VARCHAR(100) NOT NULL COMMENT,
  identificacion VARCHAR(20) NOT NULL COMMENT,
  carnet VARCHAR(20) NOT NULL UNIQUE COMMENT,
  nombre VARCHAR(100) NOT NULL COMMENT,
  apellido VARCHAR(100) NOT NULL COMMENT,
  fechaNacimiento DATE DEFAULT NULL COMMENT,
  correo VARCHAR(100) DEFAULT NULL COMMENT ,
  carrera VARCHAR(100) DEFAULT NULL COMMENT,
  genero VARCHAR(20) NOT NULL COMMENT,
  idCurso BIGINT(20) UNSIGNED DEFAULT NULL COMMENT,
  PRIMARY KEY (idEstudiante),
  KEY fk_estudiantes_curso (idCurso)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Datos de ejemplo: estudiantes
INSERT INTO estudiantes (tipoIdentificacion, identificacion, carnet, nombre, apellido, correo, carrera, genero, idCurso) VALUES
('Cédula Física Nacional', '118744597', 'SM1975364', 'María', 'Fernandez Angulo Pérez', 'MperezA@uc.cr', 'Administración de Empresas', 'mujer', 6),
('Cédula Física Nacional', '118744598', 'AL2175413', 'Juan Carlos', 'Gómez Rodriguez', 'jgomezp@uc.cr', 'Ingeniería Informática', 'hombre', 3);


-- Tabla: matricula
CREATE TABLE matricula (
  idMatricula INT(11) NOT NULL AUTO_INCREMENT COMMENT,
  idEstudiante VARCHAR(20) NOT NULL COMMENT,
  nombreEstudiante VARCHAR(100) NOT NULL COMMENT,
  carrera VARCHAR(100) DEFAULT NULL COMMENT,
  codigoCurso VARCHAR(20) NOT NULL COMMENT,
  nombreCurso VARCHAR(100) NOT NULL COMMENT,
  semestre VARCHAR(10) DEFAULT NULL COMMENT,
  anio YEAR NOT NULL COMMENT,
  fechaMatricula DATE NOT NULL COMMENT,
  observaciones TEXT DEFAULT NULL COMMENT,
  registradoPor VARCHAR(100) DEFAULT NULL COMMENT,
  PRIMARY KEY (idMatricula)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Datos de ejemplo: matricula
INSERT INTO matricula (idEstudiante, nombreEstudiante, carrera, codigoCurso, nombreCurso, semestre, anio, fechaMatricula, observaciones, registradoPor) VALUES
('5', 'Jimena Patricia', 'Ingeniería Informática', 'IN-20', 'Inglés II', '3', 2025, '2025-08-27', '', 'Milagros'),
('2', 'Juan Carlos', 'Ingeniería Informática', 'II-60', 'Sistemas Computacionales', '2', 2025, '2025-08-27', '', 'Milagros');


-- Tabla: usuarios
CREATE TABLE usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT COMMENT,
  tipoIdentificacion VARCHAR(50) NOT NULL COMMENT,
  identificacion VARCHAR(20) NOT NULL COMMENT,
  nombre VARCHAR(100) NOT NULL COMMENT,
  fechaNacimiento DATE DEFAULT NULL COMMENT,
  correo VARCHAR(100) NOT NULL UNIQUE COMMENT,
  genero VARCHAR(20) NOT NULL COMMENT 
  tipoUsuario VARCHAR(20) NOT NULL COMMENT,
  idUsuario VARCHAR(20) NOT NULL COMMENT,
  telefono1 VARCHAR(15) NOT NULL COMMENT,
  telefono2 VARCHAR(15) DEFAULT NULL COMMENT,
  password VARCHAR(255) NOT NULL COMMENT,
  fechaRegistro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Datos de ejemplo: usuarios
INSERT INTO usuarios (tipoIdentificacion, identificacion, nombre, fechaNacimiento, correo, genero, tipoUsuario, idUsuario, telefono1, telefono2, password) VALUES
('Cédula Física Nacional', '119040136', 'Milagros', '0000-00-00', 'mhernandezj@edu.uc.ac.cr', 'mujer', 'administrador', 'ADM-007', '11223344', '', '$2y$10$pQy3AhjCKt6a8MQ9zIOiYOZJ4RDl3gw/olFtWAaS5mIR5Ih4Wg9cC'),
('Cédula Física Nacional', '119753630', 'Marcela Barahona Fernández', '0000-00-00', 'MbarahonafA@uc.cr', 'mujer', 'profesor', 'PRF-004', '70651789', '', '$2y$10$QGa6nI/J2FUY9Htk1kiNiuTQzjk8UGUfBro/tUCNH/JFdKLstZ4Fi');


-- Relaciones entre tablas
ALTER TABLE cursos
  ADD CONSTRAINT fk_cursos_profesor FOREIGN KEY (idProfesor) REFERENCES profesores(idProfesor);

ALTER TABLE profesores
  ADD CONSTRAINT fk_profesor_curso FOREIGN KEY (id_curso) REFERENCES cursos(idCurso);

ALTER TABLE estudiantes
  ADD CONSTRAINT fk_estudiantes_curso FOREIGN KEY (idCurso) REFERENCES cursos(idCurso);