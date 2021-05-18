-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2021 a las 17:48:08
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `Id` int(11) NOT NULL,
  `CodIdentificacion` varchar(5) NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `Id` int(11) NOT NULL,
  `ClienteId` int(11) NOT NULL,
  `MesaId` int(11) NOT NULL,
  `EmpleadoId` int(11) NOT NULL,
  `ProductoId` int(11) NOT NULL,
  `FechaAlta` date NOT NULL,
  `FechaFinalizacion` date NOT NULL,
  `Importe` double NOT NULL,
  `EstadoFinal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio` double NOT NULL,
  `codigoBarra` varchar(50) NOT NULL,
  `FechaRegistro` date NOT NULL,
  `FechaUltimaModificacion` date NOT NULL,
  `FechaBaja` date NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `rubro` varchar(50) NOT NULL,
  `fechaRegistro` date NOT NULL,
  `fechaBaja` date NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `clave`, `email`, `localidad`, `rubro`, `fechaRegistro`) VALUES
(1, 'Franco','Gomez', 'Hsu23sDsjseWs', 'FrancoGimenez@gmail.com', 'Avellaneda', 'bartender', '2021/12/30'),
(2, 'Pedro', 'Perez', 'dasdqsdw2sd23', 'PedroPerez@gmail.com', 'Adrogue', 'mozo', '2021/12/30'),
(3, 'Jorge', 'Lopez', 'sda2s2f332f2', 'JorgeLopez@gmail.com', 'Burzaco', 'socio', '2021/12/30');


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `CodIdentificacion` (`CodIdentificacion`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
