-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2018 a las 20:24:55
-- Versión del servidor: 10.1.33-MariaDB
-- Versión de PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asistencia_2018_2`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `horario_dia` ()  BEGIN
SELECT dni,CONCAT(apePaterno,' ',apeMaterno,', ',nombres) as nomCompleto,horEntrada,IFNULL(horSalida,'<i>Aun no Sale</i>') as horSalida 
FROM practicantes p inner join detalle_asistencia d on p.dni=d.codPracticante_fk where fecha=DATE_FORMAT(NOW(), "%Y-%m-%d");
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listaAlumnos` ()  BEGIN
SELECT dni,CONCAT(codTurno_fk,' - ',apePaterno,' ',apeMaterno,', ',nombres)as nomCompleto,fecha,horEntrada,horSalida FROM practicantes p left join detalle_asistencia d 
on p.dni=d.codPracticante_fk where fecha=DATE_FORMAT(NOW(), "%Y-%m-%d") or fecha<=>null;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `marcarAsistencia` (`codigo` CHAR(8), `accion` VARCHAR(100))  BEGIN
if(accion="ingreso") then
insert into detalle_asistencia(codPracticante_fk,fecha,horEntrada) value(codigo,DATE_FORMAT(NOW(), "%Y-%m-%d"),DATE_FORMAT(NOW(), "%h:%i:%s"));
elseif (accion="salida") then
update detalle_asistencia set horSalida=DATE_FORMAT(NOW(), "%h:%i:%s") where codPracticante_fk=codigo;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verificar_asistencia` (`dni2` CHAR(8))  BEGIN
declare btnIngreso varchar(100);
declare btnSalida varchar(100);
declare conIngreso int;
declare conSalida int;
declare count int;
set count =(SELECT count(*) FROM practicantes WHERE dni=dni2);
if(count=0) then
select * from practicantes where 1=0;
else
set conIngreso=(select count(*) from detalle_asistencia where fecha=DATE_FORMAT(NOW(), "%Y-%m-%d") and NOT (horEntrada <=> NULL) and codPracticante_fk=dni2);
set conSalida=(select count(*) from detalle_asistencia where fecha=DATE_FORMAT(NOW(), "%Y-%m-%d") and NOT (horSalida <=> NULL) and codPracticante_fk=dni2);
select DATE_FORMAT(NOW(), "%Y-%m-%d") as fecha,conIngreso,conSalida;
end if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_asistencia`
--

CREATE TABLE `detalle_asistencia` (
  `id` int(11) NOT NULL,
  `codPracticante_fk` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date DEFAULT NULL,
  `horEntrada` time DEFAULT NULL,
  `horSalida` time DEFAULT NULL,
  `horTotales` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `practicantes`
--

CREATE TABLE `practicantes` (
  `dni` char(8) COLLATE utf8_spanish_ci NOT NULL,
  `apePaterno` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `apeMaterno` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fecNacimiento` date NOT NULL,
  `sexo` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `codTurno_fk` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` mediumtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `practicantes`
--

INSERT INTO `practicantes` (`dni`, `apePaterno`, `apeMaterno`, `nombres`, `fecNacimiento`, `sexo`, `codTurno_fk`, `descripcion`) VALUES
('48472688', 'Lopez', 'Chile', 'Mario Alfredo', '1994-03-04', 'M', 'T1', ''),
('71061478', 'Trujillo ', 'Ibañez', 'Alexander Piero', '2018-12-02', 'M', 'T1', ''),
('74779087', 'Espinoza', 'Correa', 'Bryan Wilder', '1999-04-24', 'M', 'T2', ''),
('76180544', 'Montalvo', 'Fiestas', 'Cristhofer', '1999-08-24', 'M', 'T1', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `codigo` char(2) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` mediumtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`codigo`, `nombre`, `descripcion`) VALUES
('T1', 'Turno Mañana', ''),
('T2', 'Turno Tarde', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_asistencia`
--
ALTER TABLE `detalle_asistencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codPracticante_fk` (`codPracticante_fk`);

--
-- Indices de la tabla `practicantes`
--
ALTER TABLE `practicantes`
  ADD PRIMARY KEY (`dni`),
  ADD KEY `codTurno_fk` (`codTurno_fk`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_asistencia`
--
ALTER TABLE `detalle_asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_asistencia`
--
ALTER TABLE `detalle_asistencia`
  ADD CONSTRAINT `practicantes -> detalle` FOREIGN KEY (`codPracticante_fk`) REFERENCES `practicantes` (`dni`);

--
-- Filtros para la tabla `practicantes`
--
ALTER TABLE `practicantes`
  ADD CONSTRAINT `practicantes -> turnos` FOREIGN KEY (`codTurno_fk`) REFERENCES `turnos` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
