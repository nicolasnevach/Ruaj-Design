-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2025 a las 23:48:46
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

-- Tabla: categorias
CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_cat` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

-- Tabla: pedidos
CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
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

-- Tabla: producto
CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_prod` varchar(45) NOT NULL,
  `precio` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `foto_alt` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `producto` (`id_producto`, `nombre_prod`, `precio`, `descripcion`, `foto`, `foto_alt`, `id_categoria`) VALUES
(1, 'Banco Veronica', 150000, 'Banco', '../img/mueble.jpg', '../img/fondo.jpg', 1),
(2, 'Biblioteca', 0, 'Biblioteca', '../img/mueble.jpg', '../img/fondo.jpg', 2),
(3, 'Comoda 4 Cajones', 0, 'Comoda 4 Cajones', '../img/mueble.jpg', '../img/fondo.jpg', 3),
(4, 'Comoda 6 Cajones', 0, 'Comoda 6 Cajones', '../img/mueble.jpg', '../img/fondo.jpg', 3),
(5, 'Escritorio Cajon y Hueco', 0, 'Escritorio Cajon y Hueco', '../img/mueble.jpg', '../img/fondo.jpg', 4),
(6, 'Escritorio María', 0, 'María', '../img/mueble.jpg', '../img/fondo.jpg', 4),
(7, 'Escritorio Olivia', 0, 'Olivia', '../img/mueble.jpg', '../img/fondo.jpg', 4),
(8, 'Mesa de Luz Azucena', 0, 'Azucena', '../img/mueble.jpg', '../img/fondo.jpg', 5),
(9, 'Mesa de Luz Amelia', 0, 'Amelia', '../img/mueble.jpg', '../img/fondo.jpg', 5),
(10, 'Mesa de Luz Jacinta', 0, 'Jacinta', '../img/mueble.jpg', '../img/fondo.jpg', 5),
(11, 'Mesa de Luz Mateo', 0, 'Mateo', '../img/mueble.jpg', '../img/fondo.jpg', 5),
(12, 'Mesa de Luz Milagros', 0, 'Milagros', '../img/mueble.jpg', '../img/fondo.jpg', 5),
(13, 'Mesa de Luz Nesta', 0, 'Nesta', '../img/mueble.jpg', '../img/fondo.jpg', 5),
(14, 'Mesa Ratona Varillada', 0, 'Varillada', '../img/mueble.jpg', '../img/fondo.jpg', 6),
(15, 'Mesa Ratona Fini', 0, 'Fini', '../img/mueble.jpg', '../img/fondo.jpg', 6),
(16, 'Mesa Ratona Pi', 0, 'Pi', '../img/mueble.jpg', '../img/fondo.jpg', 6),
(17, 'Mesa Ratona Porcelanato', 0, 'Porcelanato', '../img/mueble.jpg', '../img/fondo.jpg', 6),
(18, 'Perchero Juana', 0, 'Juana', '../img/mueble.jpg', '../img/fondo.jpg', 7),
(19, 'Rack Felicitas', 0, 'Felicitas', '../img/mueble.jpg', '../img/fondo.jpg', 8),
(20, 'Rack Fino Flotante', 0, 'Fino Flotante', '../img/mueble.jpg', '../img/fondo.jpg', 8),
(21, 'Rack Ovalado', 0, 'Ovalado', '../img/mueble.jpg', '../img/fondo.jpg', 8),
(22, 'Rack Puertas Rebatibles', 0, 'Puertas Rebatibles', '../img/mueble.jpg', '../img/fondo.jpg', 8),
(23, 'Rack Varillado', 0, 'Varillado', '../img/mueble.jpg', '../img/fondo.jpg', 8),
(24, 'Recibidor Bahia', 0, 'Bahia', '../img/mueble.jpg', '../img/fondo.jpg', 9),
(25, 'Recibidor con Deck', 0, 'con Deck', '../img/mueble.jpg', '../img/fondo.jpg', 9),
(26, 'Ropero Atenas', 0, 'Atenas', '../img/mueble.jpg', '../img/fondo.jpg', 10),
(27, 'Ropero Varillado', 0, 'Varillado', '../img/mueble.jpg', '../img/fondo.jpg', 10);

-- Índices
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`);

ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_categoria` (`id_categoria`);

-- AUTO_INCREMENT
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

-- Relaciones
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

-- NUEVA TABLA: usuarios
CREATE TABLE `usuarios` (
  `id_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `es_admin` TINYINT(1) DEFAULT 0,
  `baneado` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;