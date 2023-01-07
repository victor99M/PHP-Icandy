-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-01-2023 a las 20:52:51
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `icandy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_CA` int(11) NOT NULL,
  `cantidad_CA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierre_caja`
--

CREATE TABLE `cierre_caja` (
  `id_CC` int(11) NOT NULL,
  `id_C` int(11) NOT NULL,
  `hora_CC` time NOT NULL,
  `fecha_CC` date NOT NULL,
  `caja_CC` int(11) NOT NULL,
  `monto_CC` int(11) NOT NULL,
  `diferencia_CC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cierre_caja`
--

INSERT INTO `cierre_caja` (`id_CC`, `id_C`, `hora_CC`, `fecha_CC`, `caja_CC`, `monto_CC`, `diferencia_CC`) VALUES
(0, 2, '14:42:52', '2022-04-09', 1303, 902, 150),
(0, 2, '15:05:35', '2022-04-09', 39, 24, 0),
(0, 2, '01:16:59', '2022-05-11', 1731, 829, 218);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_C` int(11) NOT NULL,
  `correo_C` varchar(50) NOT NULL,
  `contrasena_C` varchar(255) NOT NULL,
  `telefono_C` varchar(10) NOT NULL,
  `nombre_C` varchar(50) NOT NULL,
  `apellidos_C` varchar(50) NOT NULL,
  `foto_C` text NOT NULL,
  `fecha_C` date NOT NULL,
  `direccion_C` varchar(100) NOT NULL,
  `colonia_C` varchar(100) NOT NULL,
  `cp_C` int(11) NOT NULL,
  `tipo_C` varchar(15) NOT NULL,
  `activo_C` tinyint(1) NOT NULL,
  `token_C` varchar(300) NOT NULL,
  `token_password_C` int(255) DEFAULT NULL,
  `password_request_C` varchar(255) DEFAULT NULL,
  `last_session_C` date DEFAULT NULL,
  `password_requested_C` varchar(355) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_C`, `correo_C`, `contrasena_C`, `telefono_C`, `nombre_C`, `apellidos_C`, `foto_C`, `fecha_C`, `direccion_C`, `colonia_C`, `cp_C`, `tipo_C`, `activo_C`, `token_C`, `token_password_C`, `password_request_C`, `last_session_C`, `password_requested_C`) VALUES
(1, 'jorge@solorzano', '123', '3310445566', 'Jorge', 'Solorzano', 'null', '2022-03-21', 'Zapopan, San Juan de Dios, Colinas de San Javier #577, 33142', 'jardines de la barranca', 0, 'Administrador', 1, '', NULL, NULL, NULL, NULL),
(2, 'Pablo@Gomez', '456', '5467782532', 'Pablo', 'Gómez', 'null', '2022-03-21', 'Tlaquepaque, Experiencia, Barranquitas #756, 64578', 'real de las magnolias', 0, 'Cliente', 1, '', NULL, NULL, NULL, NULL),
(3, 'victor@icandymx.com', '$2y$10$7WcvohuoycFd0McZF.Yu9eeG7srZj/EzVTDyCGIyoxhO8n2tLYzuK', '3314142136', 'Victor', 'Sandoval', 'clientes/editar.png', '2022-05-05', 'Federico Allende #3928', 'Jardines de la barranca', 44729, 'Administrador', 1, '697ea1361eff017722f1dabc8b0169e1', 2147483647, '0', NULL, '$2y$10$l.Qs7tLNm28.uH0V0UgOiOcYjD4AdCn3lEycfvpuIfctc3z9b1YBy'),
(4, 'manuel@gmail.com', '$2y$10$XhP2hw7i.UHOURSe7ndySeT/mlfHx1eeyUbg9CScaYbyRPOTKgyLW', '3314142136', 'Manuel', 'Amaral', 'clientes/detalles.png', '2022-05-06', 'Federico Allende #3928', 'Jaridnes del oro', 44729, 'Cliente', 1, '80ee7f41b4c14664a7a960cb82cac3f8', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corte_caja`
--

CREATE TABLE `corte_caja` (
  `id_corte` int(11) NOT NULL,
  `usuario_corte` varchar(50) NOT NULL,
  `fecha_corte` date NOT NULL,
  `hora_corte` time NOT NULL,
  `caja_corte` int(11) NOT NULL,
  `monto_corte` int(11) NOT NULL,
  `diferencia_corte` int(11) NOT NULL,
  `token_corte` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles`
--

CREATE TABLE `detalles` (
  `id_D` int(11) NOT NULL,
  `cantidad_D` int(11) NOT NULL,
  `id_PR` int(11) NOT NULL,
  `total_D` double NOT NULL,
  `inversion_D` double NOT NULL,
  `id_VP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalles`
--

INSERT INTO `detalles` (`id_D`, `cantidad_D`, `id_PR`, `total_D`, `inversion_D`, `id_VP`) VALUES
(1, 2, 1, 120, 114, 1),
(38, 2, 4, 80, 74, 84),
(39, 1, 5, 40, 37, 85),
(40, 1, 4, 40, 37, 86),
(41, 1, 5, 40, 37, 87),
(42, 1, 6, 40, 37, 87),
(43, 1, 9, 45, 40, 87),
(44, 1, 2, 62, 62, 88),
(45, 1, 3, 45, 42, 88),
(46, 1, 4, 40, 37, 88),
(47, 2, 12, 128, 120, 89),
(48, 3, 23, 93, 78, 90),
(49, 1, 12, 64, 60, 91),
(50, 2, 23, 62, 52, 92),
(51, 1, 8, 45, 40, 93),
(52, 5, 3, 225, 210, 93),
(53, 1, 2, 62, 62, 93),
(54, 3, 6, 120, 111, 93),
(55, 1, 2, 62, 62, 94),
(56, 1, 4, 40, 37, 95),
(57, 1, 7, 38, 32, 95),
(58, 2, 12, 128, 120, 96),
(59, 1, 20, 24, 19, 96),
(60, 1, 2, 62, 62, 97),
(61, 2, 12, 128, 120, 98),
(62, 1, 3, 45, 42, 99),
(63, 1, 2, 62, 62, 99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fondo`
--

CREATE TABLE `fondo` (
  `id_FC` int(11) NOT NULL,
  `cantidad_FC` int(11) NOT NULL,
  `token_FC` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fondo`
--

INSERT INTO `fondo` (`id_FC`, `cantidad_FC`, `token_FC`) VALUES
(1, 20, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genera_carrito`
--

CREATE TABLE `genera_carrito` (
  `id_CA` int(11) NOT NULL,
  `id_C` int(11) NOT NULL,
  `id_PR` int(11) NOT NULL,
  `cantidad_CA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genera_carrito`
--

INSERT INTO `genera_carrito` (`id_CA`, `id_C`, `id_PR`, `cantidad_CA`) VALUES
(365, 4, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_PR` int(11) NOT NULL,
  `nombre_PR` varchar(50) NOT NULL,
  `precio_PR` int(11) NOT NULL,
  `inversion_PR` int(11) NOT NULL,
  `foto_PR` text NOT NULL,
  `cantidad_PR` int(11) NOT NULL,
  `novedad_PR` tinyint(1) NOT NULL,
  `discontinuo_PR` tinyint(1) NOT NULL,
  `descripcion_PR` text NOT NULL,
  `fecha_PR` date NOT NULL,
  `unidadPeso_PR` varchar(20) NOT NULL,
  `nombreDescripcion_PR` varchar(200) NOT NULL,
  `piezasCaja_PR` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_PR`, `nombre_PR`, `precio_PR`, `inversion_PR`, `foto_PR`, `cantidad_PR`, `novedad_PR`, `discontinuo_PR`, `descripcion_PR`, `fecha_PR`, `unidadPeso_PR`, `nombreDescripcion_PR`, `piezasCaja_PR`) VALUES
(1, 'Mazapan original', 60, 57, 'https://m.media-amazon.com/images/I/51ahH94w1yL._SL1000_.jpg', 1, 0, 0, 'Delicioso dulce tradicional hecho con pequeños trozos de cacahuate.', '2022-03-21', 'Caja', '640 g', 30),
(2, 'Mazapan gigante', 62, 62, 'https://cdn.shopify.com/s/files/1/0706/6309/products/mayoreototal-caja-mazapan-super-gigante-la-rosa-con-16-paquetes-de-20-piezas-la-rosa-mazapan-la-rosa-sku_358x.jpg?v=1563810787', 5, 0, 0, 'Delicioso dulce tradicional hecho con pequeños trozos de cacahuate.', '2022-03-21', 'Caja', '750 g', 20),
(3, 'Mazapan chico', 45, 42, 'http://cdn.shopify.com/s/files/1/0103/7529/9138/products/IMG_4440_burned_1024x1024.png?v=1588612164', 3, 1, 0, 'Delicioso dulce tradicional hecho con pequeños trozos de cacahuate.', '2022-03-21', 'Caja', '750 g', 60),
(4, 'Nugs', 40, 37, 'https://http2.mlstatic.com/D_NQ_NP_990026-MLM47008230513_082021-W.jpg', 4, 0, 0, 'Delicioso chocolate relleno de cajeta y cacahuate.', '2022-03-21', 'Caja', '336 g', 12),
(5, 'Ranita Croa!', 40, 37, 'https://http2.mlstatic.com/D_NQ_NP_990026-MLM47008230513_082021-W.jpg', 4, 0, 1, 'Chocolate con maiz inflado y con figura de una rana.', '2022-03-21', 'Caja', '192 g', 12),
(6, 'Nugs recreo', 40, 37, 'http://cdn.shopify.com/s/files/1/0232/4417/products/Recreo_grande.jpg?v=1523729280', 9, 0, 0, 'Chocolate relleno de cajeta y delicisiosa crema de cachuate y pequeños trozos de cacahuate.', '2022-03-21', 'Caja', '560 g', 10),
(7, 'Mini nugs', 38, 32, 'https://www.heb.com.mx/media/catalog/product/cache/9f5ec31302878493d9ed0ac40a398e12/4/6/466593_image.jpg', 19, 1, 0, 'Delicioso chocolate con pequeños trozos de cachuate y cajeta.', '2022-03-21', 'Caja', '260 g', 24),
(8, 'Bubu Lubu', 45, 40, 'https://www.laranitadelapaz.com.mx/images/thumbs/0004973_chocolate-bubulubu-12-piezas-de-420-g-ieps-inc_510.jpeg', 18, 0, 0, 'Deliciosa goma de fresa cubierta de chocolate.', '2022-03-21', 'Caja', '500g', 12),
(9, 'Kranky', 45, 40, 'https://cdn.shopify.com/s/files/1/0084/5214/5229/products/Ricolino-Kranky-Display-8-10.png?v=1573604828', 19, 0, 0, 'Es un delicioso snack que está elaborado con crujientes hojuelas de maíz con una dulce cobertura de chocolate para disfrutar en todo momento y en cualquier época.', '2022-03-21', 'Caja', '375 g', 25),
(10, 'Picafresa', 35, 30, 'https://m.media-amazon.com/images/I/91be40-s0RL._AC_SL1500_.jpg', 19, 1, 0, 'Son diminutos dulces hechos de grenetina con frutal sabor a fresa y con una suculenta cubierta picosita de chile.', '2022-03-21', 'Caja', '500 g', 100),
(11, 'Pica fresa grande', 60, 55, 'http://cdn.shopify.com/s/files/1/0590/3928/5431/products/ScreenShot2021-08-10at7.47.20PM.png?v=16286429377', 15, 0, 0, 'Son dulces hechos de grenetina con frutal sabor a fresa y con una suculenta cubierta picosita de chile.', '2022-03-21', 'Caja', '720 g', 50),
(12, 'Pica gomas', 64, 60, 'https://m.media-amazon.com/images/I/712QhuoIjOL._AC_SX385_.jpg', 3, 0, 0, 'Gomita sabor fresa cubierta de dulce picosito.', '2022-03-21', 'Caja', '600 g', 100),
(13, 'Rockaleta', 57, 52, 'https://m.media-amazon.com/images/I/61kXNBHWjjL._AC_SX679_.jpg', 13, 0, 0, 'Es una original paleta con múltiples capas de distintos sabores dulces y picantes, que conforme las comes van descubriendo en el centro de la paleta una deliciosa goma de mascar.', '2022-03-21', 'Caja', '480 g', 20),
(14, 'Bolitocha', 100, 95, 'https://s.cornershopapp.com/product-images/198383.jpg?versionId=QgqwDC27X2D7r4B8NIujovszz_Hyviiw', 15, 0, 0, 'Es un caramelo gustado por muchos. Es un producto 100% mexicano elaborado con los mejores estándares de calidad.', '2022-03-21', 'Caja', '540 g', 60),
(15, 'm&m\'s', 150, 145, 'https://m.media-amazon.com/images/I/411e4lsegUL.jpg', 15, 0, 0, 'Son pequeños pedazos de chocolate con leche revestidos de azúcar, populares en muchos países alrededor del mundo. ', '2022-03-21', 'Caja', '900 g', 6),
(16, 'Pulparindo', 34, 31, 'https://dulcesdelarosa.com.mx/assets/imagenes/productos/dlr-tamarindo-1pulparindogrande.png', 7, 0, 1, 'Deliciosas barritas de tamarindo natural, con un sabor acidito en una exquisita combinación con sal y chile.', '2022-03-21', 'Caja', '280 g', 20),
(17, 'Skittles', 56, 53, 'https://cdn.shopify.com/s/files/1/0706/6309/products/000116046m_1000x.jpg?v=1569307301', 10, 0, 0, 'Son dulces suaves confitados de diferentes sabores frutales como: fresa, melón, frambuesa, cereza, mora, mango, mandarina, kiwi, limón, piña entre otros.', '2022-03-21', 'Caja', '1.107 kg', 10),
(18, 'Duvalín Avellana Vainilla', 24, 19, 'https://cdn.shopify.com/s/files/1/0084/5214/5229/products/Ricolino-Duvalin-Avellana-Vainilla_850x.png?v=1564523502', 7, 0, 0, 'Es el dulce cremoso de dos sabores, avellana y vainilla, ideal para las fiestas infantiles.', '2022-03-21', 'Caja', '270 g', 18),
(19, 'Duvalín Fresa Vainilla', 24, 19, 'https://www.heb.com.mx/media/catalog/product/cache/9f5ec31302878493d9ed0ac40a398e12/d/u/dulce-ducalin-crema-fresa-vainilla-18-pz_x1.jpg', 7, 0, 0, 'Es el dulce cremoso de dos sabores, fresa y vainilla, ideal para las fiestas infantiles.', '2022-03-21', 'Caja', '270 g', 18),
(20, 'Duvalín Fresa Vainilla', 24, 19, 'https://s.cornershopapp.com/product-images/1357008.jpg?versionId=cTurnlISMlbGVNdPLDOk8lVbC_BLJsiC', 9, 0, 0, 'Es el dulce cremoso de tres sabores, avellana, fresa y vainilla, ideal para las fiestas infantiles.', '2022-03-21', 'Caja', '270 g', 18),
(21, 'Duvalin 4 sabores', 24, 19, 'https://http2.mlstatic.com/D_NQ_NP_945004-MLM42326785913_062020-O.jpg', 10, 0, 0, 'Es el dulce cremoso de cuatro sabores, avellana, fresa, vainilla y cajeta, ideal para las fiestas infantiles.', '2022-03-21', 'Caja', '270 g', 18),
(22, 'Paleta payaso', 95, 90, 'https://assets.sams.com.mx/image/upload/f_auto,q_auto:eco,w_350,c_scale,dpr_auto/mx/images/product-images/img_medium/000897521m.jpg', 20, 1, 0, 'Una divertida paleta que ofrece una deliciosa experiencia de sabor, al mezclar una suave base de malvavisco, cubierta sabor a chocolate y carita de gomitas. Es un detonador de juego al momento de comerla.', '2022-03-21', 'Caja', '270 g', 18),
(23, 'Ferrero Rocher 3', 31, 26, 'https://lambetadas.com/wp-content/uploads/2020/10/T3-Checkout.png', 2, 0, 1, 'Chocolate con trozos de almendras y delicioso relleno de avellana.', '2022-03-21', 'Caja', '37.5 g', 3),
(24, 'Ferrero Rocher 8', 67, 62, 'https://res.cloudinary.com/walmart-labs/image/upload/w_960,dpr_auto,f_auto,q_auto:best/gr/images/product-images/img_large/00786100290011L.jpg', 20, 0, 0, 'Chocolate con trozos de almendras y delicioso relleno de avellana', '2022-03-21', 'Caja', '100 g', 9),
(25, 'Ferrero Rocher 12', 100, 95, 'https://res.cloudinary.com/walmart-labs/image/upload/w_960,dpr_auto,f_auto,q_auto:best/gr/images/product-images/img_large/00800050022774L.jpg', 20, 0, 0, 'Chocolate con trozos de almendras y delicioso relleno de avellana', '2022-03-21', 'Caja', '150 g', 12),
(26, 'Ferrero Rocher 24', 170, 165, 'https://res.cloudinary.com/walmart-labs/image/upload/w_960,dpr_auto,f_auto,q_auto:best/gr/images/product-images/img_large/00789802439533L.jpg', 19, 0, 0, 'Chocolate con trozos de almendras y delicioso relleno de avellana', '2022-03-21', 'Caja', '300 g', 24),
(27, 'Lucas Muecas', 57, 52, 'https://http2.mlstatic.com/D_NQ_NP_959973-MLM43365758659_092020-O.jpg', 15, 0, 0, 'Es la paleta de caramelo sabor sandía con chile en polvo que les encanta a todos los niños, gracias a su gran sabor picoso y dulce.', '2022-03-21', 'Caja', '250 g', 10),
(28, 'Tamborines', 42, 37, 'https://http2.mlstatic.com/D_NQ_NP_923506-MLM40989790755_032020-O.webp', 15, 0, 0, 'Es la golosina enchilada más conocida popularmente como Tamborcitos, permanece en el gusto de todas las edades al disfrutar su sabor tamarindo acidito y picante en su forma tan única que se deshace en la boca.', '2022-03-21', 'Caja', '135 g', 30),
(29, 'Kinder delice', 99, 94, 'https://www.sams.com.mx/images/product-images/img_small/000083219s.jpg', 10, 0, 1, 'Es un pastelito cubierto de delicioso cacao con un rico relleno a base de leche.', '2022-03-21', 'Caja', '390 g', 10),
(30, 'Kinder bueno', 230, 225, 'https://dulceriasyabarroterasvazquez.com/wp-content/uploads/2021/04/facebook-frente-2.jpg', 15, 0, 0, 'Son dos barritas rellenas de crema de avellanas, cubiertas con una fina capa de chocolate con leche. Ideales para compartir y disfrutar en cualquier momento del día.', '2022-03-21', 'Caja', '430 g', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `id_T` int(11) NOT NULL,
  `fecha_T` date NOT NULL,
  `nombreFiscal_T` varchar(50) NOT NULL,
  `leyenda_T` text NOT NULL,
  `municipio_T` varchar(50) NOT NULL,
  `calle_T` varchar(50) NOT NULL,
  `colonia_T` varchar(50) NOT NULL,
  `numExt_T` int(11) NOT NULL,
  `codPos_T` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_carrito`
--

CREATE TABLE `venta_carrito` (
  `id_C` int(11) NOT NULL,
  `id_VP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `venta_carrito`
--

INSERT INTO `venta_carrito` (`id_C`, `id_VP`) VALUES
(1, 1),
(2, 84),
(2, 85),
(2, 86),
(2, 87),
(2, 88),
(2, 89),
(2, 90),
(2, 91),
(2, 92),
(2, 93),
(4, 94),
(3, 95),
(4, 96),
(4, 97),
(4, 98),
(4, 99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_pedido`
--

CREATE TABLE `venta_pedido` (
  `id_VP` int(11) NOT NULL,
  `fecha_VP` date NOT NULL,
  `fechaDeEntrega_VP` date NOT NULL,
  `tipoVenta_VP` varchar(10) NOT NULL,
  `estado_VP` varchar(20) NOT NULL,
  `inversion_VP` double NOT NULL,
  `total_VP` double NOT NULL,
  `corte_VP` tinyint(1) NOT NULL,
  `cierre_VP` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `venta_pedido`
--

INSERT INTO `venta_pedido` (`id_VP`, `fecha_VP`, `fechaDeEntrega_VP`, `tipoVenta_VP`, `estado_VP`, `inversion_VP`, `total_VP`, `corte_VP`, `cierre_VP`) VALUES
(1, '2022-03-29', '2022-03-27', 'Digital', 'Entregado', 262, 280, 1, 1),
(2, '2022-03-29', '2022-03-23', 'Digital', 'Pendiente', 114, 120, 1, 1),
(3, '2022-04-07', '2022-04-07', 'Fisica', 'Entregado', 238, 244, 1, 0),
(15, '2022-04-07', '2022-04-07', 'Fisica', 'Entregado', 119, 122, 1, 0),
(16, '2022-04-08', '2022-04-08', 'Fisica', 'Entregado', 38, 48, 1, 0),
(17, '2022-04-08', '2022-04-08', 'Fisica', 'Entregado', 300, 318, 1, 0),
(18, '2022-04-08', '2022-04-08', 'Fisica', 'Entregado', 165, 170, 1, 0),
(19, '2022-04-09', '2022-04-09', 'Fisica', 'Entregado', 19, 24, 1, 0),
(84, '2022-04-20', '2022-04-20', 'Digital', 'Pendiente', 148, 160, 1, 1),
(85, '2022-04-26', '2022-04-26', 'Digital', 'Pendiente', 114, 125, 1, 1),
(86, '2022-04-26', '2022-04-26', 'Digital', 'Pendiente', 114, 125, 1, 1),
(87, '2022-04-26', '2022-04-26', 'Digital', 'Pendiente', 114, 125, 1, 1),
(88, '2022-04-26', '2022-04-26', 'Digital', 'Pendiente', 141, 147, 1, 1),
(89, '2022-05-03', '2022-05-03', 'Fisica', 'Entregado', 120, 128, 1, 0),
(90, '2022-05-03', '2022-05-03', 'Fisica', 'Entregado', 78, 93, 1, 0),
(91, '2022-05-03', '2022-05-03', 'Fisica', 'Entregado', 60, 64, 1, 0),
(92, '2022-05-03', '2022-05-03', 'Fisica', 'Entregado', 52, 62, 1, 0),
(93, '2022-05-05', '2022-05-05', 'Digital', 'Pendiente', 423, 452, 1, 1),
(94, '2022-05-08', '2022-05-08', 'Fisica', 'Entregado', 62, 62, 1, 0),
(95, '2022-05-08', '2022-05-08', 'Fisica', 'Entregado', 69, 78, 1, 0),
(96, '2022-05-11', '2022-05-11', 'Fisica', 'Entregado', 139, 152, 1, 0),
(97, '2022-05-11', '2022-05-11', 'Fisica', 'Entregado', 62, 62, 1, 0),
(98, '2022-05-11', '2022-05-11', 'Fisica', 'Entregado', 120, 128, 1, 0),
(99, '2022-07-20', '2022-07-20', 'Digital', 'Pendiente', 104, 107, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_CA`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_C`);

--
-- Indices de la tabla `corte_caja`
--
ALTER TABLE `corte_caja`
  ADD PRIMARY KEY (`id_corte`);

--
-- Indices de la tabla `detalles`
--
ALTER TABLE `detalles`
  ADD PRIMARY KEY (`id_D`),
  ADD KEY `detalles_id_VP` (`id_VP`);

--
-- Indices de la tabla `genera_carrito`
--
ALTER TABLE `genera_carrito`
  ADD PRIMARY KEY (`id_CA`),
  ADD KEY `genera1` (`id_C`),
  ADD KEY `genera2` (`id_PR`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_PR`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_T`);

--
-- Indices de la tabla `venta_carrito`
--
ALTER TABLE `venta_carrito`
  ADD KEY `venta` (`id_C`),
  ADD KEY `venta2` (`id_VP`);

--
-- Indices de la tabla `venta_pedido`
--
ALTER TABLE `venta_pedido`
  ADD PRIMARY KEY (`id_VP`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_CA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_C` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `corte_caja`
--
ALTER TABLE `corte_caja`
  MODIFY `id_corte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `detalles`
--
ALTER TABLE `detalles`
  MODIFY `id_D` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `genera_carrito`
--
ALTER TABLE `genera_carrito`
  MODIFY `id_CA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=366;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_PR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_T` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta_pedido`
--
ALTER TABLE `venta_pedido`
  MODIFY `id_VP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles`
--
ALTER TABLE `detalles`
  ADD CONSTRAINT `detalles_id_VP` FOREIGN KEY (`id_VP`) REFERENCES `venta_pedido` (`id_VP`);

--
-- Filtros para la tabla `genera_carrito`
--
ALTER TABLE `genera_carrito`
  ADD CONSTRAINT `genera1` FOREIGN KEY (`id_C`) REFERENCES `cliente` (`id_C`),
  ADD CONSTRAINT `genera2` FOREIGN KEY (`id_PR`) REFERENCES `producto` (`id_PR`);

--
-- Filtros para la tabla `venta_carrito`
--
ALTER TABLE `venta_carrito`
  ADD CONSTRAINT `venta` FOREIGN KEY (`id_C`) REFERENCES `cliente` (`id_C`),
  ADD CONSTRAINT `venta2` FOREIGN KEY (`id_VP`) REFERENCES `venta_pedido` (`id_VP`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
