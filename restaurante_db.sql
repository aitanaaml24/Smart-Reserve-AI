-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-08-2026 a las 04:46:18
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
(2, 2, 2, 'Ventana', 'Disponible'),
(3, 3, 4, 'Centro', 'Ocupada'),
(4, 4, 4, 'Centro', 'Disponible'),
(5, 5, 6, 'Centro', 'Disponible'),
(6, 6, 6, 'Centro', 'Ocupada'),
(7, 7, 2, 'Terraza', 'Disponible'),
(8, 8, 2, 'Terraza', 'Disponible'),
(9, 9, 4, 'Terraza', 'Reservada'),
(10, 10, 4, 'Terraza', 'Disponible'),
(11, 11, 6, 'Ventana', 'Reservada'),
(12, 12, 6, 'Ventana', 'Disponible'),
(13, 13, 2, 'Privada', 'Ocupada'),
(14, 14, 2, 'Privada', 'Disponible'),
(15, 15, 4, 'Privada', 'Disponible'),
(16, 16, 4, 'Privada', 'Disponible'),
(17, 17, 8, 'Salón Principal', 'Ocupada'),
(18, 18, 8, 'Salón Principal', 'Reservada'),
(19, 19, 10, 'Salón Principal', 'Reservada'),
(20, 20, 10, 'Salón Principal', 'Disponible');

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
  `hora` time NOT NULL,
  `id_reservacion` int(11) DEFAULT NULL,
  `estado` enum('Abierta','Cerrada','Cancelada') NOT NULL DEFAULT 'Abierta',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`id_orden`, `id_cliente`, `id_mesa`, `id_usuario`, `fecha`, `hora`, `id_reservacion`, `estado`, `total`) VALUES
(1, 1, 1, 2, '2023-01-01', '11:38:36', NULL, 'Cerrada', 31.90),
(2, 2, 2, 3, '2023-01-01', '11:57:40', NULL, 'Cerrada', 0.00),
(3, 3, 3, 6, '2023-01-01', '12:12:28', NULL, 'Cerrada', 0.00),
(4, 4, 4, 8, '2023-01-01', '12:16:31', NULL, 'Cerrada', 0.00),
(5, 5, 5, 2, '2023-01-01', '12:21:30', NULL, 'Cerrada', 0.00),
(6, 6, 6, 3, '2023-01-01', '12:29:36', NULL, 'Cerrada', 0.00),
(7, 7, 7, 6, '2023-01-01', '12:50:37', NULL, 'Cerrada', 0.00),
(8, 8, 8, 8, '2023-01-01', '12:51:37', NULL, 'Cerrada', 0.00),
(9, 9, 9, 2, '2023-01-01', '12:52:01', NULL, 'Cerrada', 0.00),
(10, 10, 10, 3, '2023-01-01', '13:00:15', NULL, 'Cerrada', 0.00),
(11, 11, 11, 6, '2023-01-01', '13:02:59', NULL, 'Cerrada', 0.00),
(12, 12, 12, 8, '2023-01-01', '13:04:41', NULL, 'Cerrada', 0.00),
(13, 13, 13, 2, '2023-01-01', '13:11:55', NULL, 'Cerrada', 0.00),
(14, 14, 14, 3, '2023-01-01', '13:14:19', NULL, 'Cerrada', 0.00),
(15, 15, 15, 6, '2023-01-01', '13:33:00', NULL, 'Cerrada', 0.00),
(16, 16, 16, 8, '2023-01-01', '13:34:07', NULL, 'Cerrada', 0.00),
(17, 17, 17, 2, '2023-01-01', '13:53:00', NULL, 'Cerrada', 0.00),
(18, 18, 18, 3, '2023-01-01', '13:57:08', NULL, 'Cerrada', 0.00),
(19, 19, 19, 6, '2023-01-01', '13:59:09', NULL, 'Cerrada', 0.00),
(20, 20, 20, 8, '2023-01-01', '14:03:08', NULL, 'Cerrada', 0.00),
(21, 21, 1, 2, '2023-01-01', '14:14:29', NULL, 'Cerrada', 0.00),
(22, 22, 2, 3, '2023-01-01', '14:16:26', NULL, 'Cerrada', 0.00),
(24, 24, 14, 1, '2026-08-06', '18:00:00', 8, 'Cerrada', 0.00),
(25, 22, 18, 1, '2026-08-09', '19:00:00', 10, 'Cerrada', 66.90),
(26, 38, 2, 1, '2026-08-07', '18:00:00', 11, 'Cerrada', 0.00),
(27, 23, 17, 1, '2026-08-14', '20:00:00', 12, 'Abierta', 256.40),
(28, 14, 3, 1, '2026-08-18', '12:00:00', 16, 'Abierta', 104.90),
(29, 39, 13, 1, '2026-08-10', '18:30:00', 13, 'Abierta', 41.90),
(30, 15, 6, 1, '2026-08-09', '16:00:00', 14, 'Abierta', 88.75);

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
(60, 22, '2023-01-01', '14:16:26', 110),
(61, 25, '2026-08-09', '19:00:00', 125),
(62, 25, '2026-08-09', '19:00:00', 125),
(63, 25, '2026-08-09', '19:00:00', 129),
(64, 25, '2026-08-09', '19:00:00', 129),
(65, 1, '2023-01-01', '11:38:36', 102),
(66, 30, '2026-08-09', '16:00:00', 104),
(67, 30, '2026-08-09', '16:00:00', 111),
(68, 30, '2026-08-09', '16:00:00', 111),
(69, 30, '2026-08-09', '16:00:00', 101),
(70, 30, '2026-08-09', '16:00:00', 101),
(71, 30, '2026-08-09', '16:00:00', 101),
(72, 30, '2026-08-09', '16:00:00', 128),
(73, 29, '2026-08-10', '18:30:00', 102),
(74, 29, '2026-08-10', '18:30:00', 102),
(75, 29, '2026-08-10', '18:30:00', 106),
(76, 29, '2026-08-10', '18:30:00', 106),
(77, 28, '2026-08-18', '12:00:00', 124),
(78, 28, '2026-08-18', '12:00:00', 124),
(79, 28, '2026-08-18', '12:00:00', 124),
(80, 28, '2026-08-18', '12:00:00', 124),
(81, 28, '2026-08-18', '12:00:00', 117),
(82, 28, '2026-08-18', '12:00:00', 117),
(83, 28, '2026-08-18', '12:00:00', 121),
(84, 28, '2026-08-18', '12:00:00', 121),
(85, 27, '2026-08-14', '20:00:00', 129),
(86, 27, '2026-08-14', '20:00:00', 129),
(87, 27, '2026-08-14', '20:00:00', 129),
(88, 27, '2026-08-14', '20:00:00', 125),
(89, 27, '2026-08-14', '20:00:00', 125),
(90, 27, '2026-08-14', '20:00:00', 125),
(91, 27, '2026-08-14', '20:00:00', 125),
(92, 27, '2026-08-14', '20:00:00', 125),
(93, 27, '2026-08-14', '20:00:00', 125),
(94, 27, '2026-08-14', '20:00:00', 125),
(95, 27, '2026-08-14', '20:00:00', 125),
(96, 27, '2026-08-14', '20:00:00', 116),
(97, 27, '2026-08-14', '20:00:00', 116),
(98, 27, '2026-08-14', '20:00:00', 116),
(99, 27, '2026-08-14', '20:00:00', 116),
(100, 27, '2026-08-14', '20:00:00', 104);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservacion`
--

CREATE TABLE `reservacion` (
  `id_reservacion` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `numero_personas` int(11) NOT NULL,
  `estado` enum('Pendiente','Confirmada','Cancelada','Completada') DEFAULT 'Pendiente',
  `observaciones` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservacion`
--

INSERT INTO `reservacion` (`id_reservacion`, `id_cliente`, `id_mesa`, `fecha`, `hora`, `numero_personas`, `estado`, `observaciones`, `fecha_registro`) VALUES
(1, 18, 9, '2026-08-05', '13:30:00', 4, 'Completada', 'Celebración de cumpleaños', '2026-08-04 22:34:41'),
(4, 23, 7, '2026-08-08', '11:00:00', 2, 'Completada', 'Alergia a las nueces', '2026-08-04 22:42:38'),
(5, 45, 1, '2026-08-07', '12:00:00', 2, 'Completada', '', '2026-08-04 22:43:51'),
(6, 4, 1, '2026-08-10', '15:30:00', 2, 'Cancelada', '', '2026-08-04 22:44:50'),
(7, 37, 20, '2026-08-15', '14:00:00', 10, 'Completada', '', '2026-08-04 22:48:32'),
(8, 26, 16, '2026-08-05', '09:00:00', 4, 'Completada', '', '2026-08-05 08:00:33'),
(9, 24, 14, '2026-08-06', '18:00:00', 2, 'Completada', '', '2026-08-05 08:05:30'),
(10, 22, 18, '2026-08-09', '19:00:00', 8, 'Completada', '', '2026-08-05 08:20:09'),
(11, 38, 2, '2026-08-07', '18:00:00', 2, 'Completada', '', '2026-08-05 08:20:41'),
(12, 23, 17, '2026-08-14', '20:00:00', 8, 'Confirmada', '', '2026-08-06 18:10:10'),
(13, 39, 13, '2026-08-10', '18:30:00', 2, 'Confirmada', '', '2026-08-06 18:10:56'),
(14, 15, 6, '2026-08-09', '16:00:00', 6, 'Confirmada', '', '2026-08-06 18:12:16'),
(15, 46, 19, '2026-08-12', '14:30:00', 10, 'Pendiente', 'Celebración de cumpleaños', '2026-08-06 18:13:50'),
(16, 14, 3, '2026-08-18', '12:00:00', 4, 'Confirmada', '', '2026-08-06 18:15:44'),
(17, 44, 9, '2026-08-16', '11:00:00', 4, 'Pendiente', 'Alergia a las nueces', '2026-08-06 18:16:53'),
(18, 45, 18, '2026-08-20', '19:00:00', 8, 'Pendiente', '', '2026-08-06 18:17:24'),
(19, 16, 11, '2026-08-12', '19:30:00', 6, 'Pendiente', '', '2026-08-06 18:25:26');

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
  ADD UNIQUE KEY `uk_orden_reservacion` (`id_reservacion`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `order_details_ibfk_1` (`order_id`);

--
-- Indices de la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD PRIMARY KEY (`id_reservacion`),
  ADD UNIQUE KEY `uk_mesa_fecha_hora` (`id_mesa`,`fecha`,`hora`),
  ADD KEY `fk_reservacion_cliente` (`id_cliente`);

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
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `reservacion`
--
ALTER TABLE `reservacion`
  MODIFY `id_reservacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  ADD CONSTRAINT `fk_orden_reservacion` FOREIGN KEY (`id_reservacion`) REFERENCES `reservacion` (`id_reservacion`),
  ADD CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `orden_ibfk_2` FOREIGN KEY (`id_mesa`) REFERENCES `mesa` (`id_mesa`),
  ADD CONSTRAINT `orden_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orden` (`id_orden`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`menu_item_id`);

--
-- Filtros para la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD CONSTRAINT `fk_reservacion_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_reservacion_mesa` FOREIGN KEY (`id_mesa`) REFERENCES `mesa` (`id_mesa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
