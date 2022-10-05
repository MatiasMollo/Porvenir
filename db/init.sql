CREATE DATABASE IF NOT EXISTS `porvenir` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

use porvenir;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `celular` VARCHAR(255) NOT NULL,
  `dni` INT NOT NULL,
  `fechaNacimiento` DATE NOT NULL,
  `numeroSocio` INT,
  `habilitado` BOOLEAN,
  `ultimaReserva` TIMESTAMP DEFAULT 0
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `fotos_dni` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_usuario` INT NOT NULL,
  `ruta_frente` VARCHAR(255),
  `ruta_dorso` VARCHAR(255),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `canchas` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255),
  `habilitada` BOOLEAN
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `reservas` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_usuario` INT NOT NULL,
  `fechaReserva` TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  `fechaEvento` DATE,
  `horaInicio` TIME,
  `horaFin` TIME,
  `numeroJugadores` INT,
  `id_cancha` INT,
  FOREIGN KEY (id_cancha) REFERENCES canchas(id),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `pagos_mensuales` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `fecha` TIMESTAMP NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE = InnoDB;
