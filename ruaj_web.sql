-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql204.infinityfree.com
-- Tiempo de generación: 17-12-2025 a las 15:07:33
-- Versión del servidor: 11.4.7-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_40399050_ruaj`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_cat` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
(10, 'Roperos'),
(11, 'Mesas de Comedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL,
  `comentarios` text NOT NULL,
  `subtotal` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `metodo_envio` varchar(30) NOT NULL DEFAULT 'retiro',
  `direccion_envio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `nombre`, `mail`, `telefono`, `producto`, `altura`, `ancho`, `profundidad`, `imagen`, `pintado`, `comentarios`, `fecha`) VALUES
(21, 'nicolas', 'arineuach@gmail.com', '1122223333', 'bilioteca', '150', '70', '46', '20251119_155232_691e2e10605bd.jpg', 1, 'hola', '2025-11-19 23:52:32');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_prod`, `precio`, `descripcion`, `foto_frente`, `foto_costado`, `foto_zoom`, `id_categoria`, `activo`) VALUES
(1, 'Banco Bariloche', 150000, '', '../img/bari_frente.png', '../img/bari_costado.png', '../img/bari_zoom.png', 1, 0),
(2, 'Biblioteca Petra', 0, 'Biblioteca Petra', '../img/petra_frente.png', '../img/petra_costado.png', '../img/petra_zoom.png', 2, 1),
(3, 'Comoda Venecia 4 Cajones', 0, 'Cómoda de álamo teñida simil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas disponibles: 1,20 m, 1,40 m y 1,60 m de ancho, con 40 cm de profundidad y 80 cm de alto.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.', '../img/comoda_4_frente.png', '../img/comoda_4_costado.png', '../img/comoda_4_zoom.png', 3, 1),
(4, 'Comoda Venecia 6 Cajones', 0, 'Cómoda de álamo teñida simil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas disponibles: 1,20 m, 1,40 m y 1,60 m de ancho, con 40 cm de profundidad y 80 cm de alto.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.', '../img/comoda_6_frente.png', '../img/comoda_6_costado.png', '../img/comoda_6_zoom.png', 3, 1),
(5, 'Escritorio Brujas', 0, 'Escritorio Brujas', '../img/brujas_frente.png', '../img/brujas_costado.png', '../img/brujas_zoom.png', 4, 0),
(6, 'Escritorio Milan', 0, 'Milan', '../img/milan_frente.png', '../img/milan_costado.png', '../img/milan_zoom.png', 4, 1),
(7, 'Mesa Ratona Chicago', 0, 'Chicago', '..img/chicago_frente.png', '..img/chicago_costado.png', '..img/chicago_zoom.png', 4, 0),
(8, 'Mesa de Luz Siena', 70000, 'Mesa de luz de álamo macizo teñido símil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas: 50 cm de ancho x 40 cm de profundidad x 70 cm de alto.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.\r\n', '../img/siena_frente.png', '../img/siena_costado.png', '../img/siena_zoom.png', 5, 1),
(9, 'Mesa de Luz Roma', 0, 'Mesa de luz de álamo macizo teñido símil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas: 70 cm de ancho x 40 cm de profundidad x 60 cm de alto.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.\r\n', '../img/roma_frente.png', '../img/roma_costado.png', '../img/roma_zoom.png', 5, 1),
(10, 'Mesa de Luz Habana', 53000, 'Mesa de luz de álamo macizo teñido símil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas: 50 cm de ancho x 40 cm de profundidad x 65 cm de alto.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.\r\n', '../img/habana_frente.png', '../img/habana_costado.png', '../img/habana_zoom.png', 5, 1),
(11, 'Mesa de Luz Pekin', 0, 'Pekin', '../img/pekin_frente.png', '../img/pekin_costado.png', '../img/pekin_zoom.png', 5, 0),
(12, 'Mesa de Luz Verona', 0, 'Mesa de luz de álamo macizo teñido símil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas: 50 cm de ancho x 40 cm de profundidad x 70 cm de alto.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.\r\n', '../img/verona_frente.png', '../img/verona_costado.png', '../img/verona_zoom.png', 5, 1),
(13, 'Mesa de Luz Dubai', 0, 'Mesa de luz de álamo macizo teñido símil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas: 50 cm de ancho x 40 cm de profundidad x 65 cm de alto.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.\r\n', '../img/dubai_frente.png', '../img/dubai_costado.png', '../img/dubai_zoom.png', 5, 1),
(14, 'Mesa Ratona Niza', 0, 'Niza', '../img/niza_frente.png', '../img/niza_costado.png', '../img/niza_zoom.png', 6, 0),
(15, 'Mesa Ratona Génova', 0, 'Génova', '../img/genova_frente.png', '../img/genova_costado.png', '../img/genova_zoom.png', 6, 0),
(16, 'Mesa Ratona Oporto', 0, 'Mesa Ratona recta 1.20 x 0.60 x 0.45', '../img/oporto_frente.png', '../img/oporto_costado.png', '../img/oporto_zoom.png', 6, 1),
(17, 'Mesa Ratona Nápoles', 0, 'Mesa de comedor de petiribí macizo con tapa de porcelanato.\r\n\r\nMedida única: 1,24 m de ancho x 0,64 m de profundidad x 0,50 m de alto.\r\nNota: la altura es la única dimensión que se puede modificar bajo pedido.\r\n\r\nCada mesa es única: al ser fabricada en madera natural, pueden presentarse variaciones en las vetas, los nudos o el color del tinte.', '../img/napoles_frente.png', '../img/napoles_costado.png', '../img/napoles_zoom.png', 6, 1),
(18, 'Mesa de Comedor Zanzibar', 0, 'Mesa de comedor redonda teñido simil petiribi.\r\n\r\nMedidas: 1,00 de diametro x 0,80 de alto.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.', '../img/zanzibar_frente.png', '../img/zanzibar_costado.png', '../img/zanzibar_zoom.png', 11, 1),
(19, 'Perchero Turín', 0, 'Turín', '../img/turin_frente.png', '../img/turin_costado.png', '../img/turin_zoom.png', 7, 0),
(20, 'Rack Palermo', 0, 'Rack 3 cajones de álamo macizo teñido símil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas disponibles: 1,60 m, 1,80 m o 2,00 m de largo.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.\r\n', '../img/palermo_frente.png', '../img/palermo_costado.png', '../img/palermo_zoom.png', 8, 1),
(21, 'Rack Bolonia', 0, 'Bolonia', '../img/bolonia_frente.png', '../img/bolonia_costado.png', '../img/bolonia_zoom.png', 8, 0),
(22, 'Rack Moscú', 0, 'Moscú', '../img/moscu_frente.png', '../img/moscu_costado.png', '../img/moscu_zoom.png', 8, 0),
(23, 'Rack Singapur', 0, 'Singapur', '../img/singapur_frente.png', '../img/singapur_costado.png', '../img/singapur_zoom.png', 8, 0),
(24, 'Rack Montreal', 0, 'Montreal', '../img/montreal_frente.png', '../img/montreal_costado.png', '../img/montreal_zoom.png', 8, 0),
(25, 'Rack Tokio', 777, 'Rack 4 puertas combinadas de melamina y álamo macizo teñido símil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas: 1.40, 1.60 y 1.80 m de ancho x 0.40 m de profundidad x 0.70 m de alto.\r\n\r\nPara la medida 1.40 el mueble cuanta con 3 puertas.', '../img/tokio_frente.png', '../img/tokio_costado.png', '../img/tokio_zoom.png', 8, 1),
(26, 'Recibidor Toronto', 0, 'Toronto', '../img/toronto_frente.png', '../img/toronto_costado.png', '../img/toronto_zoom.png', 9, 0),
(27, 'Recibidor Londres', 0, 'Mesa de luz de álamo macizo teñido símil petiribi, cajones con \"correderas telescópicas\".\r\n\r\nMedidas: 1,00 m de largo x 0,40 m de profundidad x 0,80 m de alto.\r\n\r\nTerminación en laca y cera para una mayor durabilidad y suavidad al tacto.\r\n', '../img/londres_frente.png', '../img/londres_costado.png', '../img/londres_zoom.png', 9, 1),
(28, 'Ropero Atenas', 0, 'Atenas', '../img/atenas_frente.png', '../img/atenas_costado.png', '../img/atenas_zoom.png', 10, 0),
(29, 'Ropero Samoa', 0, 'Samoa', '../img/_samoa_frente.png', '../img/samoa_costado.png', '../img/samoa_zoom.png', 10, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_medidas`
--

CREATE TABLE `producto_medidas` (
  `id_medida` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `medida` varchar(50) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_medidas`
--

INSERT INTO `producto_medidas` (`id_medida`, `id_producto`, `medida`, `precio`) VALUES
(1, 3, '1.20, 4 cajones', 439000),
(2, 3, '1.40, 4 cajones', 543629),
(3, 3, '1.60, 4 cajones', 598309),
(4, 4, '1.20, 6 cajones', 508729),
(5, 4, '1.40, 6 cajones', 606178),
(6, 4, '1.60, 6 cajones', 687300),
(7, 20, '1.60', 767625),
(8, 20, '1.80', 918160),
(9, 20, '2.00', 1016618),
(10, 25, '1.40', 570100),
(11, 25, '1.60', 631195),
(12, 25, '1.80', 754880),
(13, 10, '0.50', 216385),
(14, 13, '0.50', 216385),
(15, 9, '0.70', 291115),
(18, 8, '0.50', 201505),
(19, 12, '0.50', 207505),
(27, 27, '1.00', 375238),
(124, 2, '0.80', 553690),
(125, 16, '0.80', 185333),
(126, 17, '1.24', 333700),
(127, 18, '1.00', 367333),
(128, 6, '1.20', 379707);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`);

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
-- Indices de la tabla `producto_medidas`
--
ALTER TABLE `producto_medidas`
  ADD PRIMARY KEY (`id_medida`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3127;

--
-- AUTO_INCREMENT de la tabla `producto_medidas`
--
ALTER TABLE `producto_medidas`
  MODIFY `id_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `producto_medidas`
--
ALTER TABLE `producto_medidas`
  ADD CONSTRAINT `producto_medidas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
