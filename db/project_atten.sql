-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-11-2023 a las 17:50:46
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `project_atten`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `Insert_Actividad`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_Actividad` (IN `tipoactividad` INT, IN `fechainicio` DATE, IN `fechafin` DATE, IN `descripcion` VARCHAR(200), IN `hora` TIME, IN `motivo` VARCHAR(100))   BEGIN
	DECLARE fechaactual DATE;  
    SET fechaactual = fechainicio;
    CREATE TEMPORARY TABLE IF NOT EXISTS tmpactividad (
        id INT AUTO_INCREMENT PRIMARY KEY,
        Fecha_Actividad DATE, 
        Desc_Actividad VARCHAR(200) NULL,
        Dia_Actividad INT, 
        Hora_Ingreso TIME,
        Mot_Actividad VARCHAR(100)
    );
    IF tipoactividad = 1 THEN
        WHILE fechaactual <= fechafin DO
            IF DAYOFWEEK(fechaactual) BETWEEN 2 AND 6 THEN
                INSERT INTO tmpactividad(Fecha_Actividad, Desc_Actividad, Dia_Actividad, Hora_Ingreso, Mot_Actividad)
                VALUES (fechaactual,descripcion,DAYOFWEEK(fechaactual),hora,motivo);
            END IF;
            SET fechaactual  = DATE_ADD(fechaactual , INTERVAL 1 DAY);
        END WHILE;
    ELSE
    	INSERT INTO tmpactividad(Fecha_Actividad, Desc_Actividad, Dia_Actividad, Hora_Ingreso, Mot_Actividad)
        VALUES (fechaactual,descripcion,DAYOFWEEK(fechaactual),hora,motivo);
    END IF;
    INSERT INTO actividad(Fecha_Actividad, Dia_Actividad, Desc_Actividad, Hora_Ingreso, Mot_Actividad)
    SELECT Fecha_Actividad, Dia_Actividad, Desc_Actividad,  Hora_Ingreso, Mot_Actividad FROM tmpactividad;
    DROP TEMPORARY TABLE IF EXISTS tmpactividad;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

DROP TABLE IF EXISTS `actividad`;
CREATE TABLE IF NOT EXISTS `actividad` (
  `Id_Actividad` int NOT NULL AUTO_INCREMENT,
  `Fecha_Actividad` date NOT NULL,
  `Dia_Actividad` int NOT NULL,
  `Desc_Actividad` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `Hora_Ingreso` time NOT NULL,
  `Mot_Actividad` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`Id_Actividad`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`Id_Actividad`, `Fecha_Actividad`, `Dia_Actividad`, `Desc_Actividad`, `Hora_Ingreso`, `Mot_Actividad`) VALUES
(30, '2023-10-23', 2, 'Programación anual', '08:00:00', 'Clases semanales'),
(31, '2023-10-24', 3, 'Programación anual', '08:00:00', 'Clases semanales'),
(32, '2023-10-25', 4, 'Programación anual', '08:00:00', 'Clases semanales'),
(33, '2023-10-26', 5, 'Programación anual', '08:00:00', 'Clases semanales'),
(34, '2023-10-27', 6, 'Programación anual', '08:00:00', 'Clases semanales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

DROP TABLE IF EXISTS `alumno`;
CREATE TABLE IF NOT EXISTS `alumno` (
  `Id_Alumno` int NOT NULL AUTO_INCREMENT,
  `Dni_Alumno` char(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `Nom_Alumno` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `Id_Aula` int NOT NULL,
  `Ape_Alumno` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `Foto_Alumno` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `Qr_Alumno` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Alumno`),
  UNIQUE KEY `Dni_Alumno` (`Dni_Alumno`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`Id_Alumno`, `Dni_Alumno`, `Nom_Alumno`, `Id_Aula`, `Ape_Alumno`, `Foto_Alumno`, `Qr_Alumno`) VALUES
(2, '74499448', 'zarai lucero', 1, 'quispe ramos', 'photo_74499448.jpg', NULL),
(4, '77777777', 'que tal', 1, 'que tal', NULL, NULL),
(25, '74499797', 'brayam', 1, 'quispe ramos', '', 'hola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

DROP TABLE IF EXISTS `aula`;
CREATE TABLE IF NOT EXISTS `aula` (
  `Id_Aula` int NOT NULL AUTO_INCREMENT,
  `Grado_Aula` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `Seccion_Aula` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`Id_Aula`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`Id_Aula`, `Grado_Aula`, `Seccion_Aula`) VALUES
(1, 'PRIMERO', 'UNICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feriado`
--

DROP TABLE IF EXISTS `feriado`;
CREATE TABLE IF NOT EXISTS `feriado` (
  `Id_Feriado` int NOT NULL AUTO_INCREMENT,
  `Fecha_Feriado` date NOT NULL,
  `Dia_Feriado` int NOT NULL,
  `Mot_Feriado` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `Desc_Feriado` varchar(200) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `Rec_Feriado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Id_Feriado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

DROP TABLE IF EXISTS `ingreso`;
CREATE TABLE IF NOT EXISTS `ingreso` (
  `Id_Ingreso` int NOT NULL AUTO_INCREMENT,
  `Fecha_Hora` datetime NOT NULL,
  `Id_Alumno` int NOT NULL,
  PRIMARY KEY (`Id_Ingreso`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE IF NOT EXISTS `tipousuario` (
  `Id_TipoUsuario` int NOT NULL AUTO_INCREMENT,
  `Desc_TipoUsuario` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`Id_TipoUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`Id_TipoUsuario`, `Desc_TipoUsuario`) VALUES
(1, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `Id_Usuario` int NOT NULL AUTO_INCREMENT,
  `Cod_Usuario` char(8) COLLATE utf8mb3_spanish_ci NOT NULL,
  `Nom_Usuario` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `Ape_Usuario` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `Tel_Usuario` char(9) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `Email_Usuario` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `Dir_Usuario` varchar(200) COLLATE utf8mb3_spanish_ci NOT NULL,
  `Id_TipoUsuario` int NOT NULL,
  `User_Usuario` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `Pass_Usuario` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  PRIMARY KEY (`Id_Usuario`),
  UNIQUE KEY `Email_Usuario` (`Email_Usuario`),
  UNIQUE KEY `Tel_Usuario` (`Tel_Usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id_Usuario`, `Cod_Usuario`, `Nom_Usuario`, `Ape_Usuario`, `Tel_Usuario`, `Email_Usuario`, `Dir_Usuario`, `Id_TipoUsuario`, `User_Usuario`, `Pass_Usuario`) VALUES
(20, '74499797', 'brayam', 'quispe ramos', '918474850', 'brayam@gmail.com', 'calle real 140', 1, 'admin', 'admin'),
(28, '66666666', 'como estas', 'como estas', '555555555', 'comoestas@gmail.com', 'como estas', 1, 'comoestas', 'comoestas'),
(27, '66666666', 'que tal', 'que tal', '888888888', 'quetal@gmail.com', 'que tal', 1, 'quetal', 'quetal'),
(26, '77777777', 'hola', 'hola', '999999999', 'hola@hola.com', 'hola', 1, 'hola', 'hola');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
