-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-05-2025 a las 05:16:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nutricia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antropometria`
--

CREATE TABLE `antropometria` (
  `NUMANTROPO` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `FECHAANTRO` date DEFAULT NULL,
  `PESOACT` float DEFAULT NULL,
  `PESOHAB` float DEFAULT NULL,
  `ESTATURA` float DEFAULT NULL,
  `PCT` float DEFAULT NULL,
  `PCB` float DEFAULT NULL,
  `PCS` float DEFAULT NULL,
  `CB` float DEFAULT NULL,
  `CCIN` float DEFAULT NULL,
  `CCAD` float DEFAULT NULL,
  `CABS` float DEFAULT NULL,
  `COMPLEX` varchar(32) DEFAULT NULL,
  `PESOIDEAL` float DEFAULT NULL,
  `IMC` float DEFAULT NULL,
  `PESOAJUST` float DEFAULT NULL,
  `GRASACORP` float DEFAULT NULL,
  `MASALG` float DEFAULT NULL,
  `ICINCAD` float DEFAULT NULL,
  `AMUSCB` float DEFAULT NULL,
  `AGUACT` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bioq`
--

CREATE TABLE `bioq` (
  `FOLIOBIOQ` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `SoliAnalis` tinyint(1) DEFAULT NULL,
  `Data` varchar(350) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carbos`
--

CREATE TABLE `carbos` (
  `IDCARBOS` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `FECHACARBOS` date DEFAULT NULL,
  `PERCENT` float DEFAULT NULL,
  `KCAL` float DEFAULT NULL,
  `GRS` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `ID_cita` int(11) NOT NULL,
  `Nombre` varchar(200) DEFAULT NULL,
  `TELEFONO` varchar(200) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `HORA` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dh`
--

CREATE TABLE `dh` (
  `idDH` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `Momento` varchar(10) DEFAULT NULL,
  `FOOD` varchar(150) DEFAULT NULL,
  `Hora` varchar(10) DEFAULT NULL,
  `Lugar` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ec`
--

CREATE TABLE `ec` (
  `folioEC` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `diabetes` tinyint(1) DEFAULT NULL,
  `HTA` tinyint(1) DEFAULT NULL,
  `COLESTEROL` tinyint(1) DEFAULT NULL,
  `TRIGLICERIDOS` tinyint(1) DEFAULT NULL,
  `ERENAL` tinyint(1) DEFAULT NULL,
  `CANCER` tinyint(1) DEFAULT NULL,
  `HG` tinyint(1) DEFAULT NULL,
  `TCA` tinyint(1) DEFAULT NULL,
  `OTRO` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `energnutri`
--

CREATE TABLE `energnutri` (
  `NumENERGNUTRI` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `FECHANEC` date DEFAULT NULL,
  `GEB` float DEFAULT NULL,
  `ETA` float DEFAULT NULL,
  `AFFE` float DEFAULT NULL,
  `GETO` float DEFAULT NULL,
  `kcalprop` float DEFAULT NULL,
  `ACTFISICA` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faf`
--

CREATE TABLE `faf` (
  `idFAF` int(11) NOT NULL,
  `Factor` float DEFAULT NULL,
  `ACTIVIDAD` varchar(50) DEFAULT NULL,
  `DEFINICION` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `faf`
--

INSERT INTO `faf` (`idFAF`, `Factor`, `ACTIVIDAD`, `DEFINICION`) VALUES
(1, 1.2, 'Sedentaria', 'Trabajo sentado;\nsedentario'),
(2, 1.375, 'Ligera', 'Ej. leve 1-3\nveces/semana'),
(3, 1.55, 'Activa', 'Ej. mod 3-5\nveces/sem'),
(4, 1.725, 'Muy activa', 'Ej. intenso 6-7\nveces por sem'),
(5, 1.9, 'Extemadamente\nactiva', 'Ej. intenso y\ntrabajo fisico diario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generall`
--

CREATE TABLE `generall` (
  `NUMGRAL` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `FECHAGRAL` date DEFAULT NULL,
  `OBS` varchar(500) DEFAULT NULL,
  `DIAGN` varchar(500) DEFAULT NULL,
  `TRATA` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gral`
--

CREATE TABLE `gral` (
  `FOLIO` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `DATA` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `healthstate`
--

CREATE TABLE `healthstate` (
  `folioState` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `nauseas` tinyint(1) DEFAULT NULL,
  `vomito` tinyint(1) DEFAULT NULL,
  `diarrea` tinyint(1) DEFAULT NULL,
  `estreñimiento` tinyint(1) DEFAULT NULL,
  `reflujo` tinyint(1) DEFAULT NULL,
  `gastritis` tinyint(1) DEFAULT NULL,
  `disfagia` tinyint(1) DEFAULT NULL,
  `otro` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hf`
--

CREATE TABLE `hf` (
  `folioHF` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `CANCER` tinyint(1) DEFAULT NULL,
  `DIABETES` tinyint(1) DEFAULT NULL,
  `TA` tinyint(1) DEFAULT NULL,
  `OBESIDAD` tinyint(1) DEFAULT NULL,
  `GENETICA` tinyint(1) DEFAULT NULL,
  `GASTRO` tinyint(1) DEFAULT NULL,
  `OTRO` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ibqm`
--

CREATE TABLE `ibqm` (
  `NUMBQM` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `FECHAIBQM` date DEFAULT NULL,
  `SIBQM` tinyint(1) DEFAULT NULL,
  `BQM` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kcal`
--

CREATE TABLE `kcal` (
  `IdKCAL` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `KCAL` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lipidos`
--

CREATE TABLE `lipidos` (
  `IDLIPIDOS` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `FECHALIPIDOS` date DEFAULT NULL,
  `PERCENT` float DEFAULT NULL,
  `KCAL` float DEFAULT NULL,
  `GRS` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `med`
--

CREATE TABLE `med` (
  `idMed` int(11) NOT NULL,
  `idPac` int(11) NOT NULL,
  `medicamento` varchar(100) NOT NULL,
  `dosis` varchar(100) DEFAULT NULL,
  `via` varchar(100) DEFAULT NULL,
  `frecuencia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nutricion`
--

CREATE TABLE `nutricion` (
  `idNutricion` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `apetito` varchar(50) DEFAULT NULL,
  `haModificadoAlimentacion` tinyint(1) DEFAULT NULL,
  `quienPrepara` varchar(200) DEFAULT NULL,
  `motivoPreparacion` text DEFAULT NULL,
  `alimentosPreferidos` text DEFAULT NULL,
  `alimentosNoPreferidos` text DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  `suplementos` text DEFAULT NULL,
  `consumoSal` varchar(50) DEFAULT NULL,
  `variaCuandoEmocional` tinyint(1) DEFAULT NULL,
  `grasaUsada` text DEFAULT NULL,
  `haSeguidoDieta` tinyint(1) DEFAULT NULL,
  `haUsadoMedicamentos` tinyint(1) DEFAULT NULL,
  `TipoDieta` varchar(255) DEFAULT NULL,
  `TiempoDieta` varchar(255) DEFAULT NULL,
  `DuracionDieta` varchar(255) DEFAULT NULL,
  `MedDieta` varchar(255) DEFAULT NULL,
  `ResDieta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proteina`
--

CREATE TABLE `proteina` (
  `IDPROTE` int(11) NOT NULL,
  `idPac` int(11) DEFAULT NULL,
  `FECHAPROTE` date DEFAULT NULL,
  `PERCENT` float DEFAULT NULL,
  `KCAL` float DEFAULT NULL,
  `GRS` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pxreg`
--

CREATE TABLE `pxreg` (
  `idPac` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `Born` date DEFAULT NULL,
  `TEL` varchar(20) DEFAULT NULL,
  `ConsDate` date DEFAULT NULL,
  `consult` varchar(500) DEFAULT NULL,
  `ocupacion` varchar(100) DEFAULT NULL,
  `sexo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `IdUser` int(11) NOT NULL,
  `NombreCompleto` varchar(128) DEFAULT NULL,
  `USER` varchar(32) NOT NULL,
  `password` varchar(8) NOT NULL,
  `UserBorn` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`IdUser`, `NombreCompleto`, `USER`, `password`, `UserBorn`) VALUES
(1, 'Metzli Citlali Vargas Castro', 'Meli2003', 'Meli2003', '2025-04-27'),
(3, 'Metzli Citlali Vargas Castro', 'Meli2000', 'meli123', '2025-04-27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antropometria`
--
ALTER TABLE `antropometria`
  ADD PRIMARY KEY (`NUMANTROPO`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `bioq`
--
ALTER TABLE `bioq`
  ADD PRIMARY KEY (`FOLIOBIOQ`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `carbos`
--
ALTER TABLE `carbos`
  ADD PRIMARY KEY (`IDCARBOS`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`ID_cita`);

--
-- Indices de la tabla `dh`
--
ALTER TABLE `dh`
  ADD PRIMARY KEY (`idDH`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `ec`
--
ALTER TABLE `ec`
  ADD PRIMARY KEY (`folioEC`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `energnutri`
--
ALTER TABLE `energnutri`
  ADD PRIMARY KEY (`NumENERGNUTRI`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `faf`
--
ALTER TABLE `faf`
  ADD PRIMARY KEY (`idFAF`);

--
-- Indices de la tabla `generall`
--
ALTER TABLE `generall`
  ADD PRIMARY KEY (`NUMGRAL`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `gral`
--
ALTER TABLE `gral`
  ADD PRIMARY KEY (`FOLIO`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `healthstate`
--
ALTER TABLE `healthstate`
  ADD PRIMARY KEY (`folioState`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `hf`
--
ALTER TABLE `hf`
  ADD PRIMARY KEY (`folioHF`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `ibqm`
--
ALTER TABLE `ibqm`
  ADD PRIMARY KEY (`NUMBQM`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `kcal`
--
ALTER TABLE `kcal`
  ADD PRIMARY KEY (`IdKCAL`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `lipidos`
--
ALTER TABLE `lipidos`
  ADD PRIMARY KEY (`IDLIPIDOS`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `med`
--
ALTER TABLE `med`
  ADD PRIMARY KEY (`idMed`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `nutricion`
--
ALTER TABLE `nutricion`
  ADD PRIMARY KEY (`idNutricion`);

--
-- Indices de la tabla `proteina`
--
ALTER TABLE `proteina`
  ADD PRIMARY KEY (`IDPROTE`),
  ADD KEY `idPac` (`idPac`);

--
-- Indices de la tabla `pxreg`
--
ALTER TABLE `pxreg`
  ADD PRIMARY KEY (`idPac`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IdUser`),
  ADD UNIQUE KEY `USER` (`USER`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antropometria`
--
ALTER TABLE `antropometria`
  MODIFY `NUMANTROPO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `bioq`
--
ALTER TABLE `bioq`
  MODIFY `FOLIOBIOQ` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carbos`
--
ALTER TABLE `carbos`
  MODIFY `IDCARBOS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `ID_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `dh`
--
ALTER TABLE `dh`
  MODIFY `idDH` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ec`
--
ALTER TABLE `ec`
  MODIFY `folioEC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `energnutri`
--
ALTER TABLE `energnutri`
  MODIFY `NumENERGNUTRI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `faf`
--
ALTER TABLE `faf`
  MODIFY `idFAF` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `generall`
--
ALTER TABLE `generall`
  MODIFY `NUMGRAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `gral`
--
ALTER TABLE `gral`
  MODIFY `FOLIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `healthstate`
--
ALTER TABLE `healthstate`
  MODIFY `folioState` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `hf`
--
ALTER TABLE `hf`
  MODIFY `folioHF` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ibqm`
--
ALTER TABLE `ibqm`
  MODIFY `NUMBQM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `kcal`
--
ALTER TABLE `kcal`
  MODIFY `IdKCAL` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lipidos`
--
ALTER TABLE `lipidos`
  MODIFY `IDLIPIDOS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `med`
--
ALTER TABLE `med`
  MODIFY `idMed` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `nutricion`
--
ALTER TABLE `nutricion`
  MODIFY `idNutricion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proteina`
--
ALTER TABLE `proteina`
  MODIFY `IDPROTE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pxreg`
--
ALTER TABLE `pxreg`
  MODIFY `idPac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `antropometria`
--
ALTER TABLE `antropometria`
  ADD CONSTRAINT `antropometria_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `bioq`
--
ALTER TABLE `bioq`
  ADD CONSTRAINT `bioq_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `carbos`
--
ALTER TABLE `carbos`
  ADD CONSTRAINT `carbos_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `dh`
--
ALTER TABLE `dh`
  ADD CONSTRAINT `dh_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ec`
--
ALTER TABLE `ec`
  ADD CONSTRAINT `ec_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `energnutri`
--
ALTER TABLE `energnutri`
  ADD CONSTRAINT `energnutri_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `generall`
--
ALTER TABLE `generall`
  ADD CONSTRAINT `generall_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `gral`
--
ALTER TABLE `gral`
  ADD CONSTRAINT `gral_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `healthstate`
--
ALTER TABLE `healthstate`
  ADD CONSTRAINT `healthstate_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `hf`
--
ALTER TABLE `hf`
  ADD CONSTRAINT `hf_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `ibqm`
--
ALTER TABLE `ibqm`
  ADD CONSTRAINT `ibqm_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `kcal`
--
ALTER TABLE `kcal`
  ADD CONSTRAINT `kcal_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `lipidos`
--
ALTER TABLE `lipidos`
  ADD CONSTRAINT `lipidos_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);

--
-- Filtros para la tabla `med`
--
ALTER TABLE `med`
  ADD CONSTRAINT `med_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proteina`
--
ALTER TABLE `proteina`
  ADD CONSTRAINT `proteina_ibfk_1` FOREIGN KEY (`idPac`) REFERENCES `pxreg` (`idPac`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
