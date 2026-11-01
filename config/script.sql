-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2026 a las 20:26:32
-- Versión del servidor: 10.11.16-MariaDB
-- Versión de PHP: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemas_stock`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Electrónica', 'Dispositivos y componentes electrónicos'),
(2, 'Hogar', 'Artículos para el hogar y decoración'),
(3, 'Oficina', 'Suministros y mobiliario de oficina'),
(4, 'Deportes', 'Equipamiento y ropa deportiva para entrenar'),
(5, 'Alimentos', 'Productos alimenticios no perecederos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` enum('entrada','salida','ajuste') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `id_producto`, `id_usuario`, `tipo`, `cantidad`, `fecha`, `observaciones`) VALUES
(1, 1, 1, 'entrada', 10, '2026-10-28 17:37:06', 'Compra inicial a TechWorld'),
(2, 2, 1, 'entrada', 50, '2026-10-28 17:37:06', 'Compra inicial a TechWorld'),
(3, 3, 1, 'entrada', 30, '2026-10-28 17:37:06', 'Compra inicial a TechWorld'),
(4, 4, 2, 'entrada', 40, '2026-10-28 17:37:06', 'Compra inicial a HogarTotal'),
(5, 5, 2, 'entrada', 25, '2026-10-28 17:37:06', 'Compra inicial a HogarTotal'),
(6, 6, 2, 'entrada', 15, '2026-10-28 17:37:06', 'Compra inicial a HogarTotal'),
(7, 7, 1, 'entrada', 100, '2026-10-28 17:37:06', 'Compra inicial a Distribuidora Norte'),
(8, 8, 1, 'entrada', 80, '2026-10-28 17:37:06', 'Compra inicial a Distribuidora Norte'),
(9, 9, 1, 'entrada', 60, '2026-10-28 17:37:06', 'Compra inicial a Distribuidora Norte'),
(10, 10, 2, 'entrada', 40, '2026-10-28 17:37:06', 'Compra inicial a Distribuidora Norte'),
(11, 11, 2, 'entrada', 20, '2026-10-28 17:37:06', 'Compra inicial a Distribuidora Norte'),
(12, 12, 2, 'entrada', 100, '2026-10-28 17:37:06', 'Compra inicial a Distribuidora Norte'),
(13, 13, 1, 'entrada', 10, '2026-10-28 17:37:06', 'Compra inicial a Distribuidora Norte'),
(14, 14, 1, 'entrada', 10, '2026-10-28 17:37:06', 'Compra inicial a Distribuidora Norte'),
(15, 15, 1, 'entrada', 45, '2026-10-28 17:37:06', 'Compra inicial a Distribuidora Norte'),
(16, 1, 2, 'salida', 2, '2026-10-28 17:37:06', 'Venta a cliente minorista'),
(17, 2, 2, 'salida', 5, '2026-10-28 17:37:06', 'Venta a cliente minorista'),
(18, 7, 2, 'salida', 20, '2026-10-28 17:37:06', 'Venta a empresa XYZ'),
(19, 13, 2, 'ajuste', -5, '2026-10-28 17:37:06', 'Mercadería vencida, se da de baja'),
(20, 14, 2, 'ajuste', -7, '2026-10-28 17:37:06', 'Mercadería dañada en depósito'),
(21, 1, 1, 'entrada', 5, '2026-11-01 15:00:14', ''),
(22, 1, 1, 'entrada', 5, '2026-11-01 15:04:26', ''),
(23, 1, 1, 'salida', 5, '2026-11-01 15:09:11', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `sku`, `nombre`, `descripcion`, `id_categoria`, `id_proveedor`, `precio_compra`, `precio_venta`, `stock`, `stock_minimo`, `activo`, `fecha_alta`) VALUES
(1, 'ELEC-001', 'Notebook 15\"', 'Notebook i5 8GB RAM', 1, 1, 50000.00, 75000.00, 15, 5, 1, '2026-10-28 20:37:06'),
(2, 'ELEC-002', 'Mouse Inalámbrico', 'Mouse ergonómico USB', 1, 1, 2000.00, 3500.00, 50, 20, 1, '2026-10-28 20:37:06'),
(3, 'ELEC-003', 'Teclado Mecánico', 'Teclado RGB switches azules', 1, 1, 8000.00, 12000.00, 30, 10, 1, '2026-10-28 20:37:06'),
(4, 'HOG-001', 'Lámpara LED', 'Lámpara de escritorio LED', 2, 2, 3000.00, 5000.00, 40, 15, 1, '2026-10-28 20:37:06'),
(5, 'HOG-002', 'Juego de Sábanas', 'Sábanas queen size algodón', 2, 2, 4000.00, 6500.00, 25, 10, 1, '2026-10-28 20:37:06'),
(6, 'HOG-003', 'Cortinas Blackout', 'Cortinas para ventana 2m', 2, 2, 5000.00, 8000.00, 15, 5, 1, '2026-10-28 20:37:06'),
(7, 'OFI-001', 'Resma Papel A4', 'Papel blanco 500 hojas', 3, 3, 800.00, 1200.00, 100, 50, 1, '2026-10-28 20:37:06'),
(8, 'OFI-002', 'Bolígrafo Azul x10', 'Pack 10 bolígrafos', 3, 3, 500.00, 900.00, 80, 30, 1, '2026-10-28 20:37:06'),
(9, 'OFI-003', 'Carpeta Anillada', 'Carpeta 2cm negra', 3, 3, 1500.00, 2500.00, 60, 20, 1, '2026-10-28 20:37:06'),
(10, 'DEP-001', 'Pelota Fútbol', 'Pelota tamaño 5 oficial', 4, 3, 3000.00, 5000.00, 40, 15, 1, '2026-10-28 20:37:06'),
(11, 'DEP-002', 'Mancuernas 5kg', 'Par de mancuernas', 4, 3, 8000.00, 12000.00, 20, 5, 1, '2026-10-28 20:37:06'),
(12, 'DEP-003', 'Botella Deportiva', 'Botella 750ml libre BPA', 4, 3, 1000.00, 2000.00, 99, 40, 1, '2026-10-28 20:37:06'),
(13, 'ALI-001', 'Café Molido 500g', 'Café tostado suave', 5, 3, 1500.00, 2500.00, 5, 10, 1, '2026-10-28 20:37:06'),
(14, 'ALI-002', 'Galletitas Surtidas', 'Pack familiar 300g', 5, 3, 800.00, 1500.00, 3, 10, 1, '2026-10-28 20:37:06'),
(15, 'ALI-003', 'Mermelada Frutilla', 'Frasco 450g', 5, 3, 1200.00, 2000.00, 45, 15, 1, '2026-10-28 20:37:06'),
(17, 'DEP-006', 'prueba', 'para probr', 3, 3, 5.00, 4.00, 10, 5, 0, '2026-10-31 21:45:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `contacto`, `telefono`, `email`) VALUES
(1, 'TechWorld S.A.', 'Juan Pérez', '11-1234-5678', 'ventas@techworld.com'),
(2, 'HogarTotal', 'María González', '11-8765-4321', 'contacto@hogartotal.com'),
(3, 'Distribuidora Norte', 'Carlos López', '11-5555-6667', 'pedidos@norte.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','operador') NOT NULL DEFAULT 'operador',
  `activo` tinyint(1) DEFAULT 1,
  `creado_en` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `activo`, `creado_en`) VALUES
(1, 'Administrador', 'admin@stock.com', '$2y$10$V78xD9e44aQcuJaQNOCRgeDmlt8xaXSiJWSONpU9fHDMKdIv36r8O', 'admin', 1, '2026-10-28 20:37:06'),
(2, 'Operador Uno', 'operador@stock.com', '$2y$10$V78xD9e44aQcuJaQNOCRgeDmlt8xaXSiJWSONpU9fHDMKdIv36r8O', 'operador', 1, '2026-10-28 20:37:06');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
