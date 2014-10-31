DROP TABLE IF EXISTS `#__eventosrecursos_eventos`;
DROP TABLE IF EXISTS `#__eventosrecursos_recursos`;
DROP TABLE IF EXISTS `#__eventosrecursos_recursoseventos`;
DROP TABLE IF EXISTS `#__eventosrecursos_salas`;

CREATE TABLE IF NOT EXISTS `#__eventosrecursos_recursos`(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(45),
	descripcion VARCHAR(500)	
)ENGINE=InnoDB DEFAULT CHARSET=utf8; -- ENGINE = MyISAM

CREATE TABLE IF NOT EXISTS `#__eventosrecursos_salas` (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(45),
	descripcion VARCHAR(500)	
)ENGINE=InnoDB DEFAULT CHARSET=utf8; -- ENGINE = MyISAM

CREATE TABLE IF NOT EXISTS `#__eventosrecursos_eventos`(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	titulo VARCHAR(45),
	descripcion VARCHAR(255),
	fechaInicio DATE,
	fechaFinal  DATE,
	horaInicio  TIME,
	horaFinal   TIME,
	usuario  INT NOT NULL,	
	sala INT NOT NULL,
	CONSTRAINT `fk_sala` FOREIGN KEY (`sala`) REFERENCES `#__eventosrecursos_salas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8; -- ENGINE = MyISAM


CREATE TABLE IF NOT EXISTS `#__eventosrecursos_recursoseventos`(
  `recurso` INT NOT NULL,
  `evento` INT NOT NULL,
  KEY `fk_recurso` (`recurso`),
  KEY `fk_evento` (`evento`),
  CONSTRAINT `fk_evento` FOREIGN KEY (`evento`) REFERENCES `#__eventosrecursos_eventos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_recurso` FOREIGN KEY (`recurso`) REFERENCES `#__eventosrecursos_recursos`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8; -- ENGINE = MyISAM