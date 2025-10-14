-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-10-2025 a las 05:31:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ruaj`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_cat` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_cat`) VALUES
(1, 'Bancos'),
(2, 'Bibliotecas'),
(3, 'Comodas'),
(4, 'Escritorios'),
(5, 'Mesas de Luz'),
(6, 'Mesas Ratona'),
(7, 'Percheros'),
(8, 'Racks'),
(9, 'Recibidores'),
(10, 'Roperos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `altura` varchar(50) DEFAULT NULL,
  `ancho` varchar(50) DEFAULT NULL,
  `profundidad` varchar(50) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `pintado` tinyint(1) DEFAULT 0,
  `comentarios` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_prod` varchar(45) NOT NULL,
  `precio` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `foto_frente` varchar(255) DEFAULT NULL,
  `foto_costado` varchar(255) DEFAULT NULL,
  `foto_zoom` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_prod`, `precio`, `descripcion`, `foto_frente`, `foto_costado`, `foto_zoom`, `id_categoria`, `activo`) VALUES
(1, 'Banco Bariloche', 150000, 'Banco Bariloche', '../img/bari_frente.png', '../img/bari_costado.png', '../img/bari_zoom.png', 1, 0),
(2, 'Biblioteca Petra', 0, 'Biblioteca Petra', '../img/petra_frente.png', '../img/petra_costado.png', '../img/petra_zoom.png', 2, 0),
(3, 'Comoda 4 Cajones', 0, 'Cómoda Venecia 4 Cajones', '../img/comoda_4_frente.png', '../img/comoda_4_costado.png', '../img/comoda_4_zoom.png', 3, 1),
(4, 'Comoda 6 Cajones', 0, 'Cómoda Venecia 6 Cajones', '../img/comoda_6_frente.png', '../img/comoda_6_costado.png', '../img/comoda_6_zoom.png', 3, 1),
(5, 'Escritorio Brujas', 0, 'Escritorio Brujas', '../img/brujas_frente.png', '../img/brujas_costado.png', '../img/brujas_zoom.png', 4, 0),
(6, 'Escritorio Milan', 0, 'Milan', '../img/milan_frente.png', '../img/milan_costado.png', '../img/milan_zoom.png', 4, 0),
(7, 'Mesa Ratona Chicago', 0, 'Chicago', '..img/chicago_frente.png', '..img/chicago_costado.png', '..img/chicago_zoom.png', 4, 0),
(8, 'Mesa de Luz Siena', 70000, 'Siena', '../img/siena_frente.png', '../img/siena_costado.png', '../img/siena_zoom.png', 5, 1),
(9, 'Mesa de Luz Roma', 0, 'Roma', '../img/roma_frente.png', '../img/roma_costado.png', '../img/roma_zoom.png', 5, 1),
(10, 'Mesa de Luz Habana', 53000, 'Habana', '../img/habana_frente.png', '../img/habana_costado.png', '../img/habana_zoom.png', 5, 1),
(11, 'Mesa de Luz Pekin', 0, 'Pekin', '../img/pekin_frente.png', '../img/pekin_costado.png', '../img/pekin_zoom.png', 5, 0),
(12, 'Mesa de Luz Verona', 0, 'Verona', '../img/verona_frente.png', '../img/verona_costado.png', '../img/verona_zoom.png', 5, 1),
(13, 'Mesa de Luz Dubai', 0, 'Dubai', '../img/dubai_frente.png', '../img/dubai_costado.png', '../img/dubai_zoom.png', 5, 1),
(14, 'Mesa Ratona Niza', 0, 'Niza', '../img/niza_frente.png', '../img/niza_costado.png', '../img/niza_zoom.png', 6, 0),
(15, 'Mesa Ratona Génova', 0, 'Génova', '../img/genova_frente.png', '../img/genova_costado.png', '../img/genova_zoom.png', 6, 0),
(16, 'Mesa Ratona Oporto', 0, 'Ratona Oporto', '../img/oporto_frente.png', '../img/oporto_costado.png', '../img/oporto_zoom.png', 6, 1),
(17, 'Mesa Ratona Nápoles', 0, 'Nápoles', '../img/napoles_frente.png', '../img/napoles_costado.png', '../img/napoles_zoom.png', 6, 0),
(18, 'Mesa Ratona Zanzibar', 0, 'Zanzibar', '..img/zanzibar_frente.png', '..img/zanzibar_costado.png', '..img/zanzibar_zoom.png', 6, 0),
(19, 'Perchero Turín', 0, 'Turín', '../img/turin_frente.png', '../img/turin_costado.png', '../img/turin_zoom.png', 7, 0),
(20, 'Rack Palermo', 0, 'Palermo', '../img/palermo_frente.png', '../img/palermo_costado.png', '../img/palermo_zoom.png', 8, 1),
(21, 'Rack Bolonia', 0, 'Bolonia', '../img/bolonia_frente.png', '../img/bolonia_costado.png', '../img/bolonia_zoom.png', 8, 0),
(22, 'Rack Moscú', 0, 'Moscú', '../img/moscu_frente.png', '../img/moscu_costado.png', '../img/moscu_zoom.png', 8, 0),
(23, 'Rack Singapur', 0, 'Singapur', '../img/singapur_frente.png', '../img/singapur_costado.png', '../img/singapur_zoom.png', 8, 1),
(24, 'Rack Montreal', 0, 'Montreal', '../img/montreal_frente.png', '../img/montreal_costado.png', '../img/montreal_zoom.png', 8, 0),
(25, 'Rack Tokio', 0, 'Tokio', '..img/tokio_frente.png', '..img/tokio_costado.png', '..img/tokio_zoom.png', 8, 0),
(26, 'Recibidor Toronto', 0, 'Toronto', '../img/toronto_frente.png', '../img/toronto_costado.png', '../img/toronto_zoom.png', 9, 0),
(27, 'Recibidor Londres', 0, 'Londres', '../img/londres_frente.png', '../img/londres_costado.png', '../img/londres_zoom.png', 9, 1),
(28, 'Ropero Atenas', 0, 'Atenas', '../img/atenas_frente.png', '../img/atenas_costado.png', '../img/atenas_zoom.png', 10, 0),
(29, 'Ropero Samoa', 0, 'Samoa', '../img/_samoa_frente.png', '../img/samoa_costado.png', '../img/samoa_zoom.png', 10, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_categoria` (`id_categoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3126;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
