CREATE DATABASE `porvenir` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `celular` VARCHAR(255) NOT NULL,
  `dni` INT NOT NULL,
  `numeroSocio` INT,
  `habilitado` BOOLEAN,
  'ultimaReserva' TIMESTAMP
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `fotos_dni` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
  `id_usuario` INT NOT NULL,
  `ruta_frente` VARCHAR(255),
  `ruta_dorso` VARCHAR(255),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `canchas` (
  `id` INT UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255),
  'habilitada' BOOLEAN
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `reservas` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
  `id_usuario` INT NOT NULL,
  `fechaReserva` TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  'fechaEvento' DATE,
  'horaInicio' TIME,
  'horaFin' TIME,
  'numeroJugadores' INT,
  'id_cancha' INT,
  FOREIGN KEY (id_cancha) REFERENCES canchas(id),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `pagos_mensuales` (
  `id` INT UNIQUE PRIMARY KEY NOT NULL AUTO_INCREMENT,
  'id_usuario' INT NOT NULL,
  'fecha' TIMESTAMP NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE = InnoDB;
