-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2026 a las 06:13:20
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
-- Base de datos: `restaurante_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `nombre`, `telefono`, `correo`) VALUES
(1, 'Juan Pérez', '7711000001', 'juan.perez@gmail.com'),
(2, 'María López', '7711000002', 'maria.lopez@gmail.com'),
(3, 'Carlos Hernández', '7711000003', 'carlos.hernandez@gmail.com'),
(4, 'Ana Martínez', '7711000004', 'ana.martinez@gmail.com'),
(5, 'Luis García', '7711000005', 'luis.garcia@gmail.com'),
(6, 'Fernanda Ruiz', '7711000006', 'fernanda.ruiz@gmail.com'),
(7, 'Diego Torres', '7711000007', 'diego.torres@gmail.com'),
(8, 'Sofía Morales', '7711000008', 'sofia.morales@gmail.com'),
(9, 'Miguel Castro', '7711000009', 'miguel.castro@gmail.com'),
(10, 'Valeria Jiménez', '7711000010', 'valeria.jimenez@gmail.com'),
(11, 'Ricardo Flores', '7711000011', 'ricardo.flores@gmail.com'),
(12, 'Andrea Cruz', '7711000012', 'andrea.cruz@gmail.com'),
(13, 'Jorge Reyes', '7711000013', 'jorge.reyes@gmail.com'),
(14, 'Paola Vargas', '7711000014', 'paola.vargas@gmail.com'),
(15, 'Daniel Romero', '7711000015', 'daniel.romero@gmail.com'),
(16, 'Natalia Soto', '7711000016', 'natalia.soto@gmail.com'),
(17, 'Eduardo Luna', '7711000017', 'eduardo.luna@gmail.com'),
(18, 'Camila Mendoza', '7711000018', 'camila.mendoza@gmail.com'),
(19, 'José Ramírez', '7711000019', 'jose.ramirez@gmail.com'),
(20, 'Daniela Ortiz', '7711000020', 'daniela.ortiz@gmail.com'),
(21, 'Pedro Silva', '7711000021', 'pedro.silva@gmail.com'),
(22, 'Karen Aguilar', '7711000022', 'karen.aguilar@gmail.com'),
(23, 'Alejandro Peña', '7711000023', 'alejandro.pena@gmail.com'),
(24, 'Brenda Ríos', '7711000024', 'brenda.rios@gmail.com'),
(25, 'Sergio Molina', '7711000025', 'sergio.molina@gmail.com'),
(26, 'Patricia Navarro', '7711000026', 'patricia.navarro@gmail.com'),
(27, 'Gabriel Chávez', '7711000027', 'gabriel.chavez@gmail.com'),
(28, 'Claudia Herrera', '7711000028', 'claudia.herrera@gmail.com'),
(29, 'Manuel Salas', '7711000029', 'manuel.salas@gmail.com'),
(30, 'Lucía Vega', '7711000030', 'lucia.vega@gmail.com'),
(31, 'Oscar Pineda', '7711000031', 'oscar.pineda@gmail.com'),
(32, 'Mónica Fuentes', '7711000032', 'monica.fuentes@gmail.com'),
(33, 'Arturo Campos', '7711000033', 'arturo.campos@gmail.com'),
(34, 'Verónica León', '7711000034', 'veronica.leon@gmail.com'),
(35, 'Hugo Miranda', '7711000035', 'hugo.miranda@gmail.com'),
(36, 'Diana Cabrera', '7711000036', 'diana.cabrera@gmail.com'),
(37, 'Raúl Guzmán', '7711000037', 'raul.guzman@gmail.com'),
(38, 'Jessica Bautista', '7711000038', 'jessica.bautista@gmail.com'),
(39, 'Iván Castillo', '7711000039', 'ivan.castillo@gmail.com'),
(40, 'Melissa Franco', '7711000040', 'melissa.franco@gmail.com'),
(41, 'Kevin Méndez', '7711000041', 'kevin.mendez@gmail.com'),
(42, 'Erika Valencia', '7711000042', 'erika.valencia@gmail.com'),
(43, 'Mauricio Flores', '7711000043', 'mauricio.flores@gmail.com'),
(44, 'Sandra Guerrero', '7711000044', 'sandra.guerrero@gmail.com'),
(45, 'Cristian Luna', '7711000045', 'cristian.luna@gmail.com'),
(46, 'Rosa Medina', '7711000046', 'rosa.medina@gmail.com'),
(47, 'Emilio Ortega', '7711000047', 'emilio.ortega@gmail.com'),
(48, 'Mariana Ibarra', '7711000048', 'mariana.ibarra@gmail.com'),
(49, 'Alberto Zamora', '7711000049', 'alberto.zamora@gmail.com'),
(50, 'Gabriela Serrano', '7711000050', 'gabriela.serrano@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_items`
--

CREATE TABLE `menu_items` (
  `menu_item_id` int(11) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu_items`
--

INSERT INTO `menu_items` (`menu_item_id`, `item_name`, `category`, `price`) VALUES
(101, 'Hamburger', 'American', 12.95),
(102, 'Cheeseburger', 'American', 13.95),
(103, 'Hot Dog', 'American', 9.00),
(104, 'Veggie Burger', 'American', 10.50),
(105, 'Mac & Cheese', 'American', 7.00),
(106, 'French Fries', 'American', 7.00),
(107, 'Orange Chicken', 'Asian', 16.50),
(108, 'Tofu Pad Thai', 'Asian', 14.50),
(109, 'Korean Beef Bowl', 'Asian', 17.95),
(110, 'Pork Ramen', 'Asian', 17.95),
(111, 'California Roll', 'Asian', 11.95),
(112, 'Salmon Roll', 'Asian', 14.95),
(113, 'Edamame', 'Asian', 5.00),
(114, 'Potstickers', 'Asian', 9.00),
(115, 'Chicken Tacos', 'Mexican', 11.95),
(116, 'Steak Tacos', 'Mexican', 13.95),
(117, 'Chicken Burrito', 'Mexican', 12.95),
(118, 'Steak Burrito', 'Mexican', 14.95),
(119, 'Chicken Torta', 'Mexican', 11.95),
(120, 'Steak Torta', 'Mexican', 13.95),
(121, 'Cheese Quesadilla', 'Mexican', 10.50),
(122, 'Chips & Salsa', 'Mexican', 7.00),
(123, 'Chips & Guacamole', 'Mexican', 9.00),
(124, 'Spaghetti', 'Italian', 14.50),
(125, 'Spaghetti & Meatballs', 'Italian', 17.95),
(126, 'Fettuccine Alfredo', 'Italian', 14.50),
(127, 'Meat Lasagna', 'Italian', 17.95),
(128, 'Cheese Lasagna', 'Italian', 15.50),
(129, 'Mushroom Ravioli', 'Italian', 15.50),
(130, 'Shrimp Scampi', 'Italian', 19.95),
(131, 'Chicken Parmesan', 'Italian', 17.95),
(132, 'Eggplant Parmesan', 'Italian', 16.95);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id_mesa` int(11) NOT NULL,
  `numero_mesa` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `ubicacion` varchar(50) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`id_mesa`, `numero_mesa`, `capacidad`, `ubicacion`, `estado`) VALUES
(1, 1, 2, 'Ventana', 'Disponible'),
(2, 2, 2, 'Ventana', 'Ocupada'),
(3, 3, 4, 'Centro', 'Disponible'),
(4, 4, 4, 'Centro', 'Ocupada'),
(5, 5, 6, 'Centro', 'Disponible'),
(6, 6, 6, 'Centro', 'Reservada'),
(7, 7, 2, 'Terraza', 'Disponible'),
(8, 8, 2, 'Terraza', 'Ocupada'),
(9, 9, 4, 'Terraza', 'Disponible'),
(10, 10, 4, 'Terraza', 'Ocupada'),
(11, 11, 6, 'Ventana', 'Disponible'),
(12, 12, 6, 'Ventana', 'Reservada'),
(13, 13, 2, 'Privada', 'Disponible'),
(14, 14, 2, 'Privada', 'Ocupada'),
(15, 15, 4, 'Privada', 'Disponible'),
(16, 16, 4, 'Privada', 'Reservada'),
(17, 17, 8, 'Salón Principal', 'Disponible'),
(18, 18, 8, 'Salón Principal', 'Ocupada'),
(19, 19, 10, 'Salón Principal', 'Disponible'),
(20, 20, 10, 'Salón Principal', 'Reservada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id_orden` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`id_orden`, `id_cliente`, `id_mesa`, `id_usuario`, `fecha`, `hora`) VALUES
(1, 1, 1, 2, '2023-01-01', '11:38:36'),
(2, 2, 2, 3, '2023-01-01', '11:57:40'),
(3, 3, 3, 6, '2023-01-01', '12:12:28'),
(4, 4, 4, 8, '2023-01-01', '12:16:31'),
(5, 5, 5, 2, '2023-01-01', '12:21:30'),
(6, 6, 6, 3, '2023-01-01', '12:29:36'),
(7, 7, 7, 6, '2023-01-01', '12:50:37'),
(8, 8, 8, 8, '2023-01-01', '12:51:37'),
(9, 9, 9, 2, '2023-01-01', '12:52:01'),
(10, 10, 10, 3, '2023-01-01', '13:00:15'),
(11, 11, 11, 6, '2023-01-01', '13:02:59'),
(12, 12, 12, 8, '2023-01-01', '13:04:41'),
(13, 13, 13, 2, '2023-01-01', '13:11:55'),
(14, 14, 14, 3, '2023-01-01', '13:14:19'),
(15, 15, 15, 6, '2023-01-01', '13:33:00'),
(16, 16, 16, 8, '2023-01-01', '13:34:07'),
(17, 17, 17, 2, '2023-01-01', '13:53:00'),
(18, 18, 18, 3, '2023-01-01', '13:57:08'),
(19, 19, 19, 6, '2023-01-01', '13:59:09'),
(20, 20, 20, 8, '2023-01-01', '14:03:08'),
(21, 21, 1, 2, '2023-01-01', '14:14:29'),
(22, 22, 2, 3, '2023-01-01', '14:16:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

CREATE TABLE `order_details` (
  `order_details_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  `order_time` time DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `order_id`, `order_date`, `order_time`, `item_id`) VALUES
(1, 1, '2023-01-01', '11:38:36', 109),
(2, 2, '2023-01-01', '11:57:40', 108),
(3, 2, '2023-01-01', '11:57:40', 124),
(4, 2, '2023-01-01', '11:57:40', 117),
(5, 2, '2023-01-01', '11:57:40', 129),
(6, 2, '2023-01-01', '11:57:40', 106),
(7, 3, '2023-01-01', '12:12:28', 117),
(8, 3, '2023-01-01', '12:12:28', 119),
(9, 4, '2023-01-01', '12:16:31', 117),
(10, 5, '2023-01-01', '12:21:30', 117),
(11, 6, '2023-01-01', '12:29:36', 101),
(12, 6, '2023-01-01', '12:29:36', 114),
(13, 7, '2023-01-01', '12:50:37', 123),
(14, 8, '2023-01-01', '12:51:37', 123),
(15, 9, '2023-01-01', '12:52:01', 108),
(16, 9, '2023-01-01', '12:52:01', 126),
(17, 9, '2023-01-01', '12:52:01', 110),
(18, 9, '2023-01-01', '12:52:01', 117),
(19, 9, '2023-01-01', '12:52:01', 117),
(20, 9, '2023-01-01', '12:52:01', 129),
(21, 9, '2023-01-01', '12:52:01', 122),
(22, 9, '2023-01-01', '12:52:01', 130),
(23, 9, '2023-01-01', '12:52:01', 132),
(24, 10, '2023-01-01', '13:00:15', 129),
(25, 10, '2023-01-01', '13:00:15', 105),
(26, 11, '2023-01-01', '13:02:59', 101),
(27, 11, '2023-01-01', '13:02:59', 102),
(28, 11, '2023-01-01', '13:02:59', 102),
(29, 11, '2023-01-01', '13:02:59', 113),
(30, 12, '2023-01-01', '13:04:41', 102),
(31, 12, '2023-01-01', '13:04:41', 102),
(32, 12, '2023-01-01', '13:04:41', 104),
(33, 12, '2023-01-01', '13:04:41', 117),
(34, 13, '2023-01-01', '13:11:55', 129),
(35, 14, '2023-01-01', '13:14:19', 114),
(36, 15, '2023-01-01', '13:33:00', 107),
(37, 15, '2023-01-01', '13:33:00', 124),
(38, 15, '2023-01-01', '13:33:00', 121),
(39, 15, '2023-01-01', '13:33:00', 114),
(40, 16, '2023-01-01', '13:34:07', 125),
(41, 16, '2023-01-01', '13:34:07', 111),
(42, 16, '2023-01-01', '13:34:07', 106),
(43, 17, '2023-01-01', '13:53:00', 101),
(44, 17, '2023-01-01', '13:53:00', 116),
(45, 17, '2023-01-01', '13:53:00', 124),
(46, 17, '2023-01-01', '13:53:00', 125),
(47, 17, '2023-01-01', '13:53:00', 117),
(48, 17, '2023-01-01', '13:53:00', 127),
(49, 17, '2023-01-01', '13:53:00', 128),
(50, 17, '2023-01-01', '13:53:00', 129),
(51, 17, '2023-01-01', '13:53:00', 118),
(52, 17, '2023-01-01', '13:53:00', 131),
(53, 18, '2023-01-01', '13:57:08', 111),
(54, 19, '2023-01-01', '13:59:09', 110),
(55, 19, '2023-01-01', '13:59:09', 120),
(56, 20, '2023-01-01', '14:03:08', 107),
(57, 20, '2023-01-01', '14:03:08', 124),
(58, 21, '2023-01-01', '14:14:29', 110),
(59, 22, '2023-01-01', '14:16:26', 124),
(60, 22, '2023-01-01', '14:16:26', 110);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `correo`, `contraseña`, `rol`) VALUES
(1, 'Laura Gómez', 'laura.gomez@restaurante.com', 'admin123', 'Administrador'),
(2, 'Pedro Sánchez', 'pedro.sanchez@restaurante.com', 'mesero123', 'Mesero'),
(3, 'Karla Díaz', 'karla.diaz@restaurante.com', 'mesero456', 'Mesero'),
(4, 'Roberto Vega', 'roberto.vega@restaurante.com', 'cajero123', 'Cajero'),
(5, 'Elena Flores', 'elena.flores@restaurante.com', 'super123', 'Supervisor'),
(6, 'Miguel Ramos', 'miguel.ramos@restaurante.com', 'mesero789', 'Mesero'),
(7, 'Patricia León', 'patricia.leon@restaurante.com', 'cajero456', 'Cajero'),
(8, 'Javier Torres', 'javier.torres@restaurante.com', 'mesero321', 'Mesero'),
(9, 'Andrea Ruiz', 'andrea.ruiz@restaurante.com', 'recep123', 'Recepcionista'),
(10, 'Fernando Cruz', 'fernando.cruz@restaurante.com', 'admin456', 'Administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`menu_item_id`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`id_mesa`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `orden_ibfk_2` FOREIGN KEY (`id_mesa`) REFERENCES `mesa` (`id_mesa`),
  ADD CONSTRAINT `orden_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orden` (`id_orden`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`menu_item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
