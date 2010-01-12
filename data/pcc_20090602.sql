-- phpMyAdmin SQL Dump
-- version 3.1.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 02, 2009 at 07:48 AM
-- Server version: 5.0.75
-- PHP Version: 5.2.6-3ubuntu4.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pcc`
--

-- --------------------------------------------------------

--
-- Table structure for table `archivo`
--

CREATE TABLE IF NOT EXISTS `archivo` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del Archivo (255)',
  `tipo` varchar(20) default NULL COMMENT 'Tipo del Archivo (20)',
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `archivo`
--


-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

CREATE TABLE IF NOT EXISTS `compra` (
  `id` int(11) NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `cantidad` int(11) default NULL,
  `proveedor_id` int(11) default NULL,
  `nota_pedido_id` int(11) default NULL,
  `precio` float default NULL,
  `moneda` varchar(10) default NULL,
  `fecha` datetime default NULL,
  `fecha_entrega` datetime default NULL,
  `comentario` text,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `compra_FI_1` (`producto_id`),
  KEY `compra_FI_2` (`proveedor_id`),
  KEY `compra_FI_3` (`nota_pedido_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `compra`
--

INSERT INTO `compra` (`id`, `producto_id`, `cantidad`, `proveedor_id`, `nota_pedido_id`, `precio`, `moneda`, `fecha`, `fecha_entrega`, `comentario`, `created_at`) VALUES
(1, 1, 100, 2, NULL, 120, 'peso', '2009-03-10 00:00:00', '2009-03-20 00:00:00', NULL, '2009-06-01 20:30:51'),
(2, 2, 14, 4, NULL, 140, 'peso', '2009-04-05 00:00:00', '2009-04-22 00:00:00', NULL, '2009-06-01 20:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `compra_estado`
--

CREATE TABLE IF NOT EXISTS `compra_estado` (
  `id` int(11) NOT NULL auto_increment,
  `compra_id` int(11) default NULL,
  `user_id` int(11) default NULL COMMENT 'Estable que usuario ha realizado la venta.',
  `estado_id` tinyint(4) default NULL,
  `cantidad` int(11) default '0',
  `fecha` datetime default NULL,
  `observaciones` text,
  `nota_recepcion_id` int(11) default NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `compra_estado_FI_1` (`compra_id`),
  KEY `compra_estado_FI_2` (`user_id`),
  KEY `compra_estado_FI_3` (`estado_id`),
  KEY `compra_estado_FI_4` (`nota_recepcion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `compra_estado`
--

INSERT INTO `compra_estado` (`id`, `compra_id`, `user_id`, `estado_id`, `cantidad`, `fecha`, `observaciones`, `nota_recepcion_id`, `created_at`) VALUES
(1, 1, 63, 1, 200, '2009-03-12 00:00:00', 'Compra implementada por el fixture', NULL, '2009-06-01 20:30:51'),
(2, 1, 63, 2, 200, '2009-03-12 00:00:00', 'Compra implementada por el fixture', NULL, '2009-06-01 20:30:51'),
(3, 1, 63, 3, 200, '2009-03-12 00:00:00', 'Compra implementada por el fixture.', NULL, '2009-06-01 20:30:51'),
(4, 2, 46, 5, 180, '2009-04-07 00:00:00', 'Compra implementada por el fixture.', NULL, '2009-06-01 20:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id` tinyint(4) NOT NULL auto_increment,
  `orden` tinyint(4) NOT NULL COMMENT 'Indica el orden que puede tener un estado dentro de los diferentes estados',
  `tipo` tinyint(4) NOT NULL COMMENT 'Define si es estado para una compra (0), venta (1), nota de pedido (2), etc',
  `nombre` varchar(30) default NULL COMMENT 'Nombre del tipo de estado',
  `descripcion` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `estado`
--

INSERT INTO `estado` (`id`, `orden`, `tipo`, `nombre`, `descripcion`) VALUES
(1, 0, 0, 'Iniciado', 'Siempre que se inicie la compra de un producto su estado inicial es ''Iniciado''.'),
(2, 1, 0, 'Aceptado', 'Una compra es aceptada cuando cumple con condiciones financieras.'),
(3, 2, 0, 'Rechazado', 'Este estado se produce a causa de un rechazo administrativo.'),
(4, 3, 0, 'Pausado', 'La compra queda en un estado de ''espera'' hasta que se resuelvan ciertos inconvenientes en su proceso.'),
(5, 4, 0, 'Realizado', 'La compra se ha llevado a cabo con exito.'),
(6, 5, 0, 'Entrega Parcial.', 'Entrega Parcial.'),
(7, 0, 0, 'Compra Inmediata.', 'Una compra inmediata no pasa por el proceso normal de compra generalmente asociado a una nota de pedido. Las compras se hacen comunmente en pequeñas cantidades.'),
(8, 0, 1, 'Iniciado', 'Iniciado.'),
(9, 1, 1, 'Aceptado', 'Aceptado.'),
(10, 2, 1, 'Rechazado', 'Rechazado.'),
(11, 3, 1, 'Pausado', 'Pausado.'),
(12, 4, 1, 'Realizado', 'Realizado.'),
(13, 5, 1, 'Reservado', 'Reservado.'),
(14, 1, 2, 'Administración - Iniciada', 'Administración - Iniciada.'),
(15, 2, 2, 'Administración - Cancelada', 'Administración - Cancelada.'),
(16, 3, 2, 'Administración - Modificada', 'Administración - Modificada.'),
(17, 4, 2, 'Control de Costos - Visada', 'Control de Costos - Visada.'),
(18, 5, 2, 'Control de Costos - Denegada', 'Control de Costos - Denegada.'),
(19, 6, 2, 'Control de Costos - Aceptada', 'Control de Costos - Aceptada.'),
(20, 7, 2, 'Autorización - Denegada', 'Autorización - Denegada.'),
(21, 8, 2, 'Autorización - Aceptada', 'Autorización - Aceptada.'),
(22, 9, 2, 'Autorización - En Espera', 'Autorización - En Espera.');

-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `user_id` int(11) default NULL COMMENT 'Estable que usuario ha realizado el evento',
  `fecha` datetime default NULL,
  `descripcion` text,
  `cantidad` int(11) default NULL,
  `operacion` tinyint(4) default NULL COMMENT 'Operacion de Incremento/Decremento del stock del producto',
  `created_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `evento_FI_1` (`producto_id`),
  KEY `evento_FI_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `evento`
--

INSERT INTO `evento` (`id`, `producto_id`, `user_id`, `fecha`, `descripcion`, `cantidad`, `operacion`, `created_at`) VALUES
(1, 1, 46, '2009-02-18 00:00:00', 'Evento Incremental cargado a traves del fix 140_Eventos.yml', 100, 1, '2009-06-01 20:30:51'),
(2, 1, 7, '2009-02-25 00:00:00', 'Evento Decremental cargado a traves del fix 140_Eventos.yml', 28, 0, '2009-06-01 20:30:51'),
(3, 1, 63, '2009-05-03 00:00:00', 'Evento Incremental cargado a traves del fix 140_Eventos.yml', 180, 1, '2009-06-01 20:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `formas_de_pago`
--

CREATE TABLE IF NOT EXISTS `formas_de_pago` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) default NULL,
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `formas_de_pago`
--

INSERT INTO `formas_de_pago` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Contado en Pesos', 'Pago al contado en Pesos Argentinos.'),
(2, 'Cuenta Corriente', 'Pago a trevés de Cuenta Corriente.');

-- --------------------------------------------------------

--
-- Table structure for table `geo_localidad`
--

CREATE TABLE IF NOT EXISTS `geo_localidad` (
  `id` int(11) NOT NULL auto_increment,
  `provincia_id` int(11) default NULL,
  `nombre` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `geo_localidad_FI_1` (`provincia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `geo_localidad`
--

INSERT INTO `geo_localidad` (`id`, `provincia_id`, `nombre`) VALUES
(1, 12, 'Neuquén Capital'),
(2, 12, 'Plottier'),
(3, 12, 'Centenario'),
(4, 11, 'Cipolletti'),
(5, 11, 'Cinco Saltos');

-- --------------------------------------------------------

--
-- Table structure for table `geo_pais`
--

CREATE TABLE IF NOT EXISTS `geo_pais` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `codigo` varchar(2) default NULL COMMENT 'Codigo ISO de Pais (2)',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `geo_pais`
--

INSERT INTO `geo_pais` (`id`, `nombre`, `codigo`) VALUES
(1, 'Argentina', 'AR'),
(2, 'Chile', 'CH'),
(3, 'Paraguay', 'PY'),
(4, 'Brasil', 'BR');

-- --------------------------------------------------------

--
-- Table structure for table `geo_provincia`
--

CREATE TABLE IF NOT EXISTS `geo_provincia` (
  `id` int(11) NOT NULL auto_increment,
  `pais_id` int(11) default NULL,
  `nombre` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `geo_provincia_FI_1` (`pais_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `geo_provincia`
--

INSERT INTO `geo_provincia` (`id`, `pais_id`, `nombre`) VALUES
(1, 1, 'Capital Federal'),
(2, 1, 'Gran Buenos Aires'),
(3, 1, 'Buenos Aires'),
(4, 1, 'Catamarca'),
(5, 1, 'Cordoba'),
(6, 1, 'Chaco'),
(7, 1, 'Corrientes'),
(8, 1, 'Entre Rios'),
(9, 1, 'Santa Cruz'),
(10, 1, 'Formosa'),
(11, 1, 'Rio Negro'),
(12, 1, 'Neuquen'),
(13, 1, 'Santa Fe'),
(14, 1, 'Jujuy'),
(15, 1, 'Mendoza'),
(16, 1, 'Tucumán'),
(17, 1, 'Salta'),
(18, 1, 'Misiones'),
(19, 1, 'Santiago del Estero'),
(20, 1, 'San Juan'),
(21, 1, 'Chubut'),
(22, 1, 'San Luis'),
(23, 1, 'La Rioja'),
(24, 1, 'La Pampa'),
(25, 1, 'Tierra del Fuego');

-- --------------------------------------------------------

--
-- Table structure for table `nota_pedido`
--

CREATE TABLE IF NOT EXISTS `nota_pedido` (
  `id` int(11) NOT NULL auto_increment,
  `numero` varchar(8) default NULL,
  `revision` tinyint(4) default '0',
  `fecha` date default NULL,
  `proveedor_id` int(11) default NULL,
  `plazo_entrega` varchar(100) default NULL,
  `condicion_pago` int(11) default NULL,
  `condicion_pago_detalle` varchar(200) default NULL,
  `condicion_lugar_entrega` varchar(100) default NULL,
  `remitir_doc_a` varchar(100) default 'Carlos Pellegrini Mza ''G'' Lote ''10 J''. PIN Este - C.P. 8300 - Neuquen',
  `transporte_id` int(11) default NULL,
  `lugar_entrega` varchar(100) default 'Carlos Pellegrini Mza ''G'' Lote ''10 J''. PIN Este - C.P. 8300 - Neuquen',
  `remito_proveedor` tinyint(4) default '0',
  `certificado_calidad` tinyint(4) default '0',
  `factura` tinyint(4) default '0',
  `manuales` tinyint(4) default '0',
  `ensayos` tinyint(4) default '0',
  `cert_conformidad` tinyint(4) default '0',
  `MSDS` tinyint(4) default '0',
  `otros` tinyint(4) default '0',
  `otros_descripcion` varchar(50) default NULL,
  `fecha_entrega` date default NULL,
  `administra_id` int(11) default NULL,
  `solicita_id` int(11) default NULL,
  `controla_id` int(11) default NULL,
  `autoriza_id` int(11) default NULL,
  `recepcion_total` tinyint(4) default '0',
  `bloqueada` tinyint(4) default '0',
  `ultima_revision` tinyint(4) default '1',
  `created_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `numero_revision` (`numero`,`revision`),
  KEY `nota_pedido_FI_1` (`proveedor_id`),
  KEY `nota_pedido_FI_2` (`condicion_pago`),
  KEY `nota_pedido_FI_3` (`transporte_id`),
  KEY `nota_pedido_FI_4` (`administra_id`),
  KEY `nota_pedido_FI_5` (`solicita_id`),
  KEY `nota_pedido_FI_6` (`controla_id`),
  KEY `nota_pedido_FI_7` (`autoriza_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `nota_pedido`
--


-- --------------------------------------------------------

--
-- Table structure for table `nota_pedido_estado`
--

CREATE TABLE IF NOT EXISTS `nota_pedido_estado` (
  `id` int(11) NOT NULL auto_increment,
  `nota_pedido_id` int(11) default NULL,
  `estado_id` tinyint(4) default NULL,
  `user_id` int(11) default NULL,
  `observaciones` text,
  `fecha` datetime default NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `nota_pedido_estado_FI_1` (`nota_pedido_id`),
  KEY `nota_pedido_estado_FI_2` (`estado_id`),
  KEY `nota_pedido_estado_FI_3` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `nota_pedido_estado`
--


-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL auto_increment,
  `codigo` varchar(20) NOT NULL COMMENT 'Codigo del Producto (20)',
  `nombre` varchar(100) NOT NULL COMMENT 'Nombre del Producto (100)',
  `marca` varchar(80) default NULL COMMENT 'Marca del Producto (80)',
  `descripcion` text COMMENT 'Descripcion del Producto',
  `producto_categoria_id` int(11) default NULL COMMENT 'Refrencia la categoria del producto',
  `producto_udm_id` int(11) default NULL COMMENT 'Unidad de Medida',
  `ubicacion_fisica` varchar(20) default NULL,
  `stock_actual` int(11) default '0',
  `stock_reservado` int(11) default '0',
  `stock_preaviso` int(11) default '0',
  `stock_critico` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `producto_FI_1` (`producto_categoria_id`),
  KEY `producto_FI_2` (`producto_udm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id`, `codigo`, `nombre`, `marca`, `descripcion`, `producto_categoria_id`, `producto_udm_id`, `ubicacion_fisica`, `stock_actual`, `stock_reservado`, `stock_preaviso`, `stock_critico`) VALUES
(1, 'COQ', 'Coque Calcinado de Petroleo', 'Loresco', 'Bolsa de Coque LORESCO. Cada Pallets cuenta con 45, cada una pesa 22.72 Kg.', 1, 6, 'Patio Exterior', 524, 0, 0, 0),
(2, 'PPGD FXG 371', 'Eje de Mando', '', 'Eje de mando Parte Nº PPGD FXG 371', 2, 7, 'BOX 1', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `producto_archivo`
--

CREATE TABLE IF NOT EXISTS `producto_archivo` (
  `producto_id` int(11) NOT NULL,
  `archivo_id` int(11) NOT NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`producto_id`,`archivo_id`),
  KEY `producto_archivo_FI_2` (`archivo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `producto_archivo`
--


-- --------------------------------------------------------

--
-- Table structure for table `producto_categoria`
--

CREATE TABLE IF NOT EXISTS `producto_categoria` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre de la Categoria (50)',
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `producto_categoria`
--

INSERT INTO `producto_categoria` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Coque', 'El coque es un combustible obtenido de la destilación de la hulla calentada a temperaturas muy altas en hornos cerrados, que la aislan del aire, y que sólo contiene una pequeña fracción de las materias volátiles que forman parte de la misma. Es producto de la descomposición térmica de carbones bituminosos en ausencia de aire. Cuando la hulla se calienta desprende gases que son muy útiles industrialmente; el sólido resultante es el carbón de coque, que es liviano y poroso.'),
(2, 'Repuesto de Bomba G.Denver 5x6', 'Repuesto de Bomba G.Denver 5x6');

-- --------------------------------------------------------

--
-- Table structure for table `producto_proveedor`
--

CREATE TABLE IF NOT EXISTS `producto_proveedor` (
  `producto_id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  PRIMARY KEY  (`producto_id`,`proveedor_id`),
  KEY `producto_proveedor_FI_2` (`proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `producto_proveedor`
--


-- --------------------------------------------------------

--
-- Table structure for table `producto_udm`
--

CREATE TABLE IF NOT EXISTS `producto_udm` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre de la Unidad de Medida (50)',
  `unidad` varchar(15) default NULL COMMENT 'Unidad propiamente dicha, Por ejemplo "m"',
  `unidad_mas_multi` varchar(15) default NULL COMMENT 'Es la unidad mas el multiplo o submultiplo, por ejemplo, Kg.',
  `descripcion` text,
  `dimension` varchar(15) default NULL COMMENT 'Dimension de la unidad. Puede ser lineal, cuadrÃ¡tica, Ä‡ubica, etc.',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `producto_udm`
--

INSERT INTO `producto_udm` (`id`, `nombre`, `unidad`, `unidad_mas_multi`, `descripcion`, `dimension`) VALUES
(1, 'Metro', 'm', 'm', 'El metro es la unidad de longitud del Sistema Internacional de Unidades. Se define como la longitud del trayecto recorrido en el vacío por la luz durante un tiempo de 1/299 792 458 de segundo (unidad de tiempo) (aproximadamente 3,34 ns).', 'Lineal'),
(2, 'Kilometro', 'm', 'Km', 'Si bien la unidad es el metro, definimos km como unidad indendiente para aquellos casos en que el uso del km es más frecuente.', 'Lineal'),
(3, 'mts2', NULL, NULL, 'Metros Cuadrados. Superficie. Magntud Cuadrática.', NULL),
(4, 'mts3', NULL, NULL, 'Metros Cubicos. Volúmen. Magnitud Cúbica.', NULL),
(5, 'unidad', NULL, NULL, 'Unidades. Cantidad. Magnitud Lineal.', NULL),
(6, 'Bolsa', 'bls', 'bls', 'Se define ''bolsa'' como unidad de medida para aquellos productos que se cuantifican en bolsas, por ejemplo, Coque, Yeso, etc.', 'Lineal'),
(7, 'Unidad', 'u', 'u', 'Cantidad lineal unitaria para cuantificar productos que no tienen una magnitud particular, por ejemplo, bulones, bobinas de cable, etc.', 'Lineal');

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) default NULL COMMENT 'Nombre del Proveedor (255)',
  `cuit` varchar(20) default NULL COMMENT 'Cuit del Proveedor (50)',
  `rubro_id` int(11) default NULL,
  `telefono` varchar(100) default NULL COMMENT 'Telefono del Proveedor (100)',
  `fax` varchar(100) default NULL COMMENT 'Fax del Proveedor (100)',
  `movil` varchar(100) default NULL COMMENT 'Celular del Proveedor (100)',
  `email` varchar(255) default NULL,
  `persona_nombre` varchar(100) default NULL COMMENT 'Nombre de la persona de contacto del proveedor (100)',
  `persona_apellido` varchar(100) default NULL COMMENT 'Apellido de la persona de contacto del proveedor (100)',
  `direccion_calle` varchar(50) default NULL COMMENT 'Direccioon / Calle del Proveedor (50)',
  `direccion_numero` varchar(5) default NULL COMMENT 'Direccioon / Numero de Calle del Proveedor (2)',
  `direccion_manzana` varchar(5) default NULL COMMENT 'Direccioon / Manzana del Proveedor (5)',
  `direccion_barrio` varchar(50) default NULL COMMENT 'Direccioon / Barrio del Proveedor (50)',
  `direccion_piso` varchar(2) default NULL COMMENT 'Direccioon / Piso del Proveedor (2)',
  `direccion_depto` varchar(2) default NULL COMMENT 'Direccioon / Departamento del Proveedor (2)',
  `localidad_id` int(11) default NULL,
  `provincia_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `proveedor_FI_1` (`rubro_id`),
  KEY `proveedor_FI_2` (`localidad_id`),
  KEY `proveedor_FI_3` (`provincia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`id`, `nombre`, `cuit`, `rubro_id`, `telefono`, `fax`, `movil`, `email`, `persona_nombre`, `persona_apellido`, `direccion_calle`, `direccion_numero`, `direccion_manzana`, `direccion_barrio`, `direccion_piso`, `direccion_depto`, `localidad_id`, `provincia_id`) VALUES
(1, 'Arauco Camiones', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Comercial Argentina SRL', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Chasqui SRL', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Distribuidora Leo', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'El Quijote SRL', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'XiFOX.net', NULL, 8, NULL, NULL, NULL, NULL, 'Damian', 'Suarez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proveedor_formas_de_pago`
--

CREATE TABLE IF NOT EXISTS `proveedor_formas_de_pago` (
  `proveedor_id` int(11) default NULL,
  `fdp_id` int(11) default NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `proveedor_formas_de_pago_FI_1` (`proveedor_id`),
  KEY `proveedor_formas_de_pago_FI_2` (`fdp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `proveedor_formas_de_pago`
--


-- --------------------------------------------------------

--
-- Table structure for table `proveedor_rubro`
--

CREATE TABLE IF NOT EXISTS `proveedor_rubro` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) default NULL COMMENT 'Rubro del Proveedor (2)',
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `proveedor_rubro`
--

INSERT INTO `proveedor_rubro` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Transportista', NULL),
(2, 'Electricidad - Baja Tensión.', NULL),
(3, 'Electricidad - Medio Tensión.', NULL),
(4, 'Electrónica - General.', NULL),
(5, 'Vehiculos Pesados', NULL),
(6, 'Seguridad Industrial', NULL),
(7, 'Control de Plagas', NULL),
(8, 'Insumos de Librería', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recepcion_pedido`
--

CREATE TABLE IF NOT EXISTS `recepcion_pedido` (
  `id` int(11) NOT NULL auto_increment,
  `nota_pedido_id` int(11) default NULL,
  `fecha` date default NULL,
  `recibe_id` int(11) default NULL,
  `controla_id` int(11) default NULL,
  `administra_id` int(11) default NULL,
  `proveedor_factura` varchar(30) default NULL,
  `proveedor_remito` varchar(30) default NULL,
  `transportista_id` int(11) default NULL,
  `transportista_numero_guia` varchar(30) default NULL,
  `transportista_bultos` tinyint(4) default NULL,
  `remito_proveedor` tinyint(4) default NULL,
  `certificado_calidad` tinyint(4) default NULL,
  `factura` tinyint(4) default NULL,
  `manuales` tinyint(4) default NULL,
  `ensayos` tinyint(4) default NULL,
  `cert_conformidad` tinyint(4) default NULL,
  `MSDS` tinyint(4) default NULL,
  `otros` tinyint(4) default NULL,
  `otros_descripcion` varchar(50) default NULL,
  `error_envio` tinyint(4) default NULL,
  `error_envio_desc` varchar(100) default NULL,
  `rechazado` tinyint(4) default NULL,
  `rechazado_desc` varchar(100) default NULL,
  `control_items` tinyint(4) default '1',
  `control_precios` tinyint(4) default '1',
  `control_calidad` tinyint(4) default '1',
  `control_cantidad` tinyint(4) default '1',
  `cerrada` tinyint(4) default '0',
  PRIMARY KEY  (`id`),
  KEY `recepcion_pedido_FI_1` (`nota_pedido_id`),
  KEY `recepcion_pedido_FI_2` (`recibe_id`),
  KEY `recepcion_pedido_FI_3` (`controla_id`),
  KEY `recepcion_pedido_FI_4` (`administra_id`),
  KEY `recepcion_pedido_FI_5` (`transportista_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `recepcion_pedido`
--


-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sf_guard_group_U_1` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sf_guard_group`
--

INSERT INTO `sf_guard_group` (`id`, `name`, `description`) VALUES
(1, 'Administración', 'Grupo de Usuarios de Administración. Pueden acceder a todos los módulos de la aplicación'),
(2, 'Stock', 'Usuarios relacionados con acciones para el control de stock de la empresa. Pueden dar de alta/baja productos, seguimiento del control stock, etc.'),
(3, 'Contaduría', 'Usuarios pertenecientes al sector contable de la empresa.'),
(4, 'Recursos Humanos', 'Usuarios pertenecientes al sector de Recursos Humanos.');

-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_group_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group_permission` (
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY  (`group_id`,`permission_id`),
  KEY `sf_guard_group_permission_FI_2` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sf_guard_group_permission`
--


-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_permission` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sf_guard_permission_U_1` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sf_guard_permission`
--

INSERT INTO `sf_guard_permission` (`id`, `name`, `description`) VALUES
(1, 'Administrador', 'Usuario administrador de toda la aplicación'),
(2, 'Administrador de Usuario', 'Usuario que puede administrador los usuarios de la aplicacion'),
(3, 'Stock', 'Usuario administrador con los modulos relacionados con el stock de la empresa'),
(4, 'Tesorería', 'Usuario con provilegios para administrar modulos contables');

-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_remember_key`
--

CREATE TABLE IF NOT EXISTS `sf_guard_remember_key` (
  `user_id` int(11) NOT NULL,
  `remember_key` varchar(32) default NULL,
  `ip_address` varchar(50) NOT NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`user_id`,`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sf_guard_remember_key`
--


-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_user`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(128) NOT NULL,
  `algorithm` varchar(128) NOT NULL default 'sha1',
  `salt` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `created_at` datetime default NULL,
  `last_login` datetime default NULL,
  `is_active` tinyint(4) NOT NULL default '1',
  `is_super_admin` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sf_guard_user_U_1` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `sf_guard_user`
--

INSERT INTO `sf_guard_user` (`id`, `username`, `algorithm`, `salt`, `password`, `created_at`, `last_login`, `is_active`, `is_super_admin`) VALUES
(1, 'pamestic', 'sha1', '0cabbabfbfb2c602609a4ecdec2b8e32', '613581d3f3244076a5f1704c08d98370f9aac140', '2009-06-01 20:30:51', NULL, 1, 0),
(2, 'cbandier', 'sha1', '0a4f0f2b77c74101b7b1a72ef1a4a50a', '01cb14db6e959a46851d46eab1c37078d9b141ee', '2009-06-01 20:30:51', NULL, 1, 0),
(3, 'dbandier', 'sha1', '0f253b92218ecfcc76450f93b1813819', 'c1e2eb130f0153c089f33891b189a54030001254', '2009-06-01 20:30:51', NULL, 1, 0),
(4, 'mbandier', 'sha1', '0131f75e7a669b56cc41c407a3fc13d3', '6d42877d3994f37419abc9cf99416757ccd6a3d6', '2009-06-01 20:30:51', NULL, 1, 0),
(5, 'Pbarros', 'sha1', '9143ae6823047612204fc4eac439d3ba', 'b7e92c474007995a86e6a537667f5400167e4f63', '2009-06-01 20:30:51', NULL, 1, 0),
(6, 'cborella', 'sha1', '1651ee460a28286f10501878960ad98e', '0cfc538a933c31bcc59cddb9d1abb95beb3f4f01', '2009-06-01 20:30:51', NULL, 1, 0),
(7, 'jbrion', 'sha1', '61cf11032078900f4c0238070b1f622a', 'abb3492d8f2a56be72dff595a7630985400771d5', '2009-06-01 20:30:51', NULL, 1, 0),
(8, 'dcaceres', 'sha1', '8fcd5e459035ee89411056cf589022dd', '5ad8a68494c9b110934766f52243100db542ceac', '2009-06-01 20:30:51', NULL, 1, 0),
(9, 'rcastill', 'sha1', 'a821dc656152f1586560f67a6a8be093', 'fda74a6db75fa0d2aa7ba79767f2a9f1ef54a54e', '2009-06-01 20:30:51', NULL, 1, 0),
(10, 'ecastro', 'sha1', '52e13c3cd6eac1d7b72bdf55f1026b33', '2ea48d3001597def1c80f22e1b876c2991e6294a', '2009-06-01 20:30:51', NULL, 1, 0),
(11, 'mcataldo', 'sha1', '92b92aa80de1f70a4bf5e7a2f79f9811', '20a008ddaf1515dc49fad6a480b7ca65c6170097', '2009-06-01 20:30:51', NULL, 1, 0),
(12, 'ocaucama', 'sha1', '161a1232d8e38d3b235b73f9fa6985eb', '8ece38e79a9f6d1299c38474e9a486078c2935f1', '2009-06-01 20:30:51', NULL, 1, 0),
(13, 'jcedro', 'sha1', 'ff05f91f9a17e947759ea3c2c889cb34', '1e3545762b5c3df680b1e9dad32b51b4480e522f', '2009-06-01 20:30:51', NULL, 1, 0),
(14, 'gcontrer', 'sha1', 'f040c4543e826c8508e7706e9960ff26', 'd7fa0bf659e51f4a92b26a013ab2ab7276829e87', '2009-06-01 20:30:51', NULL, 1, 0),
(15, 'rcontrer', 'sha1', '66feb3b469340b10c8dc66781c0774f0', '7e971ae29bc2eb2cd456ec315ce79f8bb5e5e05d', '2009-06-01 20:30:51', NULL, 1, 0),
(16, 'ecortez', 'sha1', '75f11e2ec78ff211d31873e3b4467e4e', 'ca582937f2fa2859be49a77d69e476b917e0cba5', '2009-06-01 20:30:51', NULL, 1, 0),
(17, 'edemonte', 'sha1', '5ace413e6d3c709fa5016214d9815f4e', 'a1d1e84dbccbacaec684b1f56072768567a97005', '2009-06-01 20:30:51', NULL, 1, 0),
(18, 'aescuder', 'sha1', '116c46183626b5583c86c5ec2ce1ff64', '8c868c79ba06282faf641f7c6890c7d6ead303c5', '2009-06-01 20:30:51', NULL, 1, 0),
(19, 'nflores', 'sha1', '6baa871877fcd5fd1b11c2638e9ab918', '5db7b5b3f93ab1d5c62b6710d71948c57006a7cc', '2009-06-01 20:30:51', NULL, 1, 0),
(20, 'jgalera', 'sha1', '29f9c868d6dab760d68a36c94f68d0f0', 'bb4a8ef0b68a129ced65f1641d5a7769a22ad200', '2009-06-01 20:30:51', NULL, 1, 0),
(21, 'agasen', 'sha1', '4fc2354b6db04cc51f7740b7b5d703f7', 'a84e6d2260e83bff69c32b100e0ab97381af9e96', '2009-06-01 20:30:51', NULL, 1, 0),
(22, 'jgonzale', 'sha1', 'a9405d85824a566f4b7072de98badce7', '8e648d6e5bda9684e8745ba0dbe9ee9d5db115a6', '2009-06-01 20:30:51', NULL, 1, 0),
(23, 'egonzale', 'sha1', '828e123040abe39fea27aef5c7a145e5', '1833ce61d40dcc3d68432510ca03843d0e728f41', '2009-06-01 20:30:51', NULL, 1, 0),
(24, 'agrillo', 'sha1', '3e43d5014b0d0d8e629cf866397db4cc', '3a0f98bf610e5627d2910e45de1809e2821753b8', '2009-06-01 20:30:51', NULL, 1, 0),
(25, 'ehermosi', 'sha1', 'aa15bbb699c1c51bd29011a0b6194888', '05a0a0447627b81c77fe54cbf94f9bb0949d9efa', '2009-06-01 20:30:51', NULL, 1, 0),
(26, 'mhormaza', 'sha1', '233963c40fdf7242d4d20824db65b6d2', '624f70b3ab46a57a0001ffd34ab54b8a21b5d51e', '2009-06-01 20:30:51', NULL, 1, 0),
(27, 'jhuenchu', 'sha1', 'e616f4ead2467026cd8784164f18dd8d', 'ef557149ec93164d43a86a125460bece40330a94', '2009-06-01 20:30:51', NULL, 1, 0),
(28, 'firanzo', 'sha1', 'ac7d1ce2b9d3254de7c711f00ca2b491', '90e23f8cf77acb8f43d9d26bd419e127f8bfea48', '2009-06-01 20:30:51', NULL, 1, 0),
(29, 'djaramil', 'sha1', '222c450605c9ce31c2a076fa3ce3fbc5', '601b7d26f68e2d806db8d4003599d27dbc0fb7a1', '2009-06-01 20:30:51', NULL, 1, 0),
(30, 'gkutsche', 'sha1', '4634036fec267b70642916b2a93c76d1', '911b611cfb1611f7175acc8af546c46c2e803de3', '2009-06-01 20:30:51', NULL, 1, 0),
(31, 'mlagos', 'sha1', 'd0a77ea32c6288975060dd4064d97bac', 'c1b88461ebc3eb43ffc0bf6c14feb0880ba5dcdf', '2009-06-01 20:30:51', NULL, 1, 0),
(32, 'mlopez', 'sha1', '548f9baf41308b2a8d32a3b7a9414e18', '80e3ac65dbf7a91a1b44e5d1b314b18532f039ac', '2009-06-01 20:30:51', NULL, 1, 0),
(33, 'pmamani', 'sha1', '4f2215181ba9f640e270173fc5a38596', '18f2b9de058be882054ee85314369d2187f15f2d', '2009-06-01 20:30:51', NULL, 1, 0),
(34, 'pmarinao', 'sha1', '83b33a0d652574f4cb3fbb9c2f5ef122', '17640f8d56f2bb04a17077e3ac7aea7c49728d23', '2009-06-01 20:30:51', NULL, 1, 0),
(35, 'omartine', 'sha1', 'a04f43fdc7baaf6e62b8ff593d8ef8b1', '5113beb0344b8702a7b8e43ccbb0d57cc6e62510', '2009-06-01 20:30:51', NULL, 1, 0),
(36, 'amedina', 'sha1', 'b4cca64c1e55dc0d1bc3c02963d6ce9c', '7bf64413c5a792136151354e6b6b060d790b1fc2', '2009-06-01 20:30:51', NULL, 1, 0),
(37, 'omenna', 'sha1', 'd0d496645248f678f39602e5411a6b94', '07e790b8064645bbdb27b14c7676780639196c80', '2009-06-01 20:30:51', NULL, 1, 0),
(38, 'mmolina', 'sha1', '46f5f944e473747332be87a5592b4c52', 'b52c3a9fbbe117cd3364ac9f5e8346cf15d84e99', '2009-06-01 20:30:51', NULL, 1, 0),
(39, 'rmolina', 'sha1', '003ac2029898d88faf755763039ad77b', 'fc12bbdc47b3a9a6adddde619d75538bbc822729', '2009-06-01 20:30:51', NULL, 1, 0),
(40, 'mmorales', 'sha1', 'ce80baa737f196373d14ea4bea45ff48', '41619cb58363efac0c31c41fd2c105e08ddc5f4a', '2009-06-01 20:30:51', NULL, 1, 0),
(41, 'mnavarre', 'sha1', '0e27869e503628b18fcb18d92846ebb7', '64316ce38c0b5dc1eb21ff7d9711ce3a5304b049', '2009-06-01 20:30:51', NULL, 1, 0),
(42, 'dojeda', 'sha1', '8296db6f6b0e38ca4e95dd6ce1e73355', '136b0fdd3c61391cfd2676f3e2fd89835e275f3c', '2009-06-01 20:30:51', NULL, 1, 0),
(43, 'cortega', 'sha1', 'cc2b6153314b8a6768b34122c46ebe66', '8b3ff67dd01d0da238993db97f76dd1d0a6fb8cf', '2009-06-01 20:30:51', NULL, 1, 0),
(44, 'rpacheco', 'sha1', '81d6bf97be469a9973002c70f07824d7', 'a4ae6ee09788498baf2876a68cc384d046a354e2', '2009-06-01 20:30:51', NULL, 1, 0),
(45, 'cparedes', 'sha1', 'f1c2773afb5998f93baed40d921f7812', '614e2e6c1eee4ca9f1623d73b4630486c6b6ff43', '2009-06-01 20:30:51', NULL, 1, 0),
(46, 'gperez', 'sha1', 'e468593e06641d9ebafda5f9cc1d36f4', '09e35bc3c8a474caecd4cbdac646411368e520c6', '2009-06-01 20:30:51', NULL, 1, 0),
(47, 'eplaate', 'sha1', '28b0fb0d2ece8aece158c306eed08abd', '0f214df666c6bf4e7c1f63207d43f0fec2c5b272', '2009-06-01 20:30:51', NULL, 1, 0),
(48, 'dpulicar', 'sha1', '0be3ff43bcbfa2bdf1f070c06bf35413', 'cc6c94fda413394d39ab748661bffd516ab96aaa', '2009-06-01 20:30:51', NULL, 1, 0),
(49, 'jrodrigu', 'sha1', 'e249f198a32e31213864774a224ee5bb', '2c33aa3952b1c73dbc4078f5c142f165db29433a', '2009-06-01 20:30:51', NULL, 1, 0),
(50, 'asandova', 'sha1', 'ae563cf0a4f06bd685a54ec63fc38392', '58f97ee9b8f84bf2f38cda60b64b726c9116f41b', '2009-06-01 20:30:51', NULL, 1, 0),
(51, 'asanrame', 'sha1', '9d312759c785666e9d86c7419b91f12f', '003a617465ffa3317c9a621e58135ee5d25aebec', '2009-06-01 20:30:51', NULL, 1, 0),
(52, 'hsantill', 'sha1', '72034654e225cd4aceb60fa6b1c63852', '4c00e19b75a9dc33314ee8b25e1b57d8a237ef13', '2009-06-01 20:30:51', NULL, 1, 0),
(53, 'msantill', 'sha1', '4a3eab9975a6d48b34b6a0b4cdec24be', '6c069b61a040246183b4ac325999a6259fa448cf', '2009-06-01 20:30:51', NULL, 1, 0),
(54, 'lschrott', 'sha1', 'db3a35bdba123867f9c6be17edcbc943', '5d50ea1650e550d89ad585b80bb23f2224c46b63', '2009-06-01 20:30:51', NULL, 1, 0),
(55, 'gstuardo', 'sha1', 'c84839b9a044ab0824a2026d5f435258', 'cb5be12a52ac49965e8b900790d002023abbebef', '2009-06-01 20:30:51', NULL, 1, 0),
(56, 'atoro', 'sha1', '0493f66921be0aa5d2c5821b89e2f232', 'c631da33b6c35dc2ebd12caeae8333ca9d8122af', '2009-06-01 20:30:51', NULL, 1, 0),
(57, 'gtorres', 'sha1', '688ae7d39c6f33b2904406f72b39c33b', '4b809ae884cbb10b70b1fc7413656a24bbba691a', '2009-06-01 20:30:51', NULL, 1, 0),
(58, 'gtosi', 'sha1', '051329876f398a9ae1327cda2895aaab', 'db27e5c39c997218d9a1418edbf9d4afd3477ded', '2009-06-01 20:30:51', NULL, 1, 0),
(59, 'pvelarde', 'sha1', '021d037ff01554883f4593f60df60edf', '772a4c2bebc0dbf8ea6fe999e07245d57221221f', '2009-06-01 20:30:51', NULL, 1, 0),
(60, 'azampa', 'sha1', '004495c401b7e02b7ba3437a23a1ac6f', '3f6a3ed4c107185d74d324aa749bc8ed94734010', '2009-06-01 20:30:51', NULL, 1, 0),
(61, 'Diego', 'sha1', 'bf24ccbdf992f03eaa4c77af101052f9', 'a1eccda351491fe5f081e5c7c53e8681ba79e624', '2009-06-01 20:30:51', NULL, 1, 1),
(62, 'German', 'sha1', 'a5262d0e5680761760010b299b873557', 'e47a1fd12efd7f63e6dea4b93dde87cbbc39cc60', '2009-06-01 20:30:51', NULL, 1, 0),
(63, 'Damian', 'sha1', '80056fb5feff8d31468fb329230b1a75', 'a6a23b5fbec4b2b91168631e0e1c0f74b89aa5b1', '2009-06-01 20:30:51', '2009-06-02 07:37:40', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_user_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`,`group_id`),
  KEY `sf_guard_user_group_FI_2` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sf_guard_user_group`
--


-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_user_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_permission` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`,`permission_id`),
  KEY `sf_guard_user_permission_FI_2` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sf_guard_user_permission`
--


-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_user_profile`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_profile` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `language` varchar(5) default 'es' COMMENT 'Lenguaje nativo del usuario',
  `nombre` varchar(255) default NULL,
  `apellido` varchar(255) default NULL,
  `fdn` date default NULL,
  `nacionalidad` int(11) default NULL,
  `documento_tipo` tinyint(4) default NULL,
  `documento_numero` varchar(15) default NULL,
  `cuil` varchar(13) default NULL,
  `legajo` varchar(5) default NULL,
  `telefono` varchar(255) default NULL COMMENT 'Telefono fijo del usuario',
  `movil` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `domicilio_calle` varchar(50) default NULL,
  `domicilio_numero` varchar(5) default NULL,
  `domicilio_manzana` varchar(5) default NULL,
  `domicilio_barrio` varchar(50) default NULL,
  `domicilio_piso` varchar(2) default NULL,
  `domicilio_depto` varchar(2) default NULL,
  `localidad_id` int(11) default NULL,
  `provincia_id` int(11) default NULL,
  `comentario` text,
  PRIMARY KEY  (`id`),
  KEY `sf_guard_user_profile_FI_1` (`user_id`),
  KEY `sf_guard_user_profile_FI_2` (`nacionalidad`),
  KEY `sf_guard_user_profile_FI_3` (`localidad_id`),
  KEY `sf_guard_user_profile_FI_4` (`provincia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `sf_guard_user_profile`
--

INSERT INTO `sf_guard_user_profile` (`id`, `user_id`, `language`, `nombre`, `apellido`, `fdn`, `nacionalidad`, `documento_tipo`, `documento_numero`, `cuil`, `legajo`, `telefono`, `movil`, `email`, `domicilio_calle`, `domicilio_numero`, `domicilio_manzana`, `domicilio_barrio`, `domicilio_piso`, `domicilio_depto`, `localidad_id`, `provincia_id`, `comentario`) VALUES
(1, 1, 'es', 'Patricio', 'Amestica', NULL, NULL, NULL, NULL, '20-26854797-6', '183', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'es', 'Carlos Raul', 'Bandieri', NULL, NULL, NULL, NULL, '20-13477054-7', '145', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'es', 'Diego Raul', 'Bandieri', NULL, NULL, NULL, NULL, '23-24876475-9', '70', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 'es', 'Monica', 'Bandieri', NULL, NULL, NULL, NULL, '23-27516842-4', '94', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, 'es', 'Pablo Andres', 'Barros', NULL, NULL, NULL, NULL, '20-33316070-7', '170', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 'es', 'Cristian Jonatan', 'Borella Rodriguez', NULL, NULL, NULL, NULL, '20-25308900-9', '135', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, 'es', 'Juan José', 'Brion', NULL, NULL, NULL, NULL, '20-25087034-6', '61', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, 'es', 'Dominga Marina', 'Caceres', NULL, NULL, NULL, NULL, '27-17932115-2', '71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, 'es', 'Rafael Jesús', 'Castillo', NULL, NULL, NULL, NULL, '20-24023991-5', '56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, 'es', 'Gustavo Enrique', 'Castro', NULL, NULL, NULL, NULL, '20-27719737-6', '99', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 11, 'es', 'María Cristina', 'Cataldo', NULL, NULL, NULL, NULL, '27-22520891-9', '160', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 12, 'es', 'Osvaldo', 'Caucaman', NULL, NULL, NULL, NULL, '23-27406491-9', '165', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 13, 'es', 'Jose', 'Cedro Durán', NULL, NULL, NULL, NULL, '20-18689836-3', '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 14, 'es', 'Gustavo Ariel', 'Contreras', NULL, NULL, NULL, NULL, '20-25139717-2', '144', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 15, 'es', 'Rodolfo Sebastian', 'Contreras', NULL, NULL, NULL, NULL, '23-25860680-9', '179', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 16, 'es', 'Eduardo Hilario', 'Cortez', NULL, NULL, NULL, NULL, '20-31756303-6', '127', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 17, 'es', 'Edgardo Luis', 'Demonte', NULL, NULL, NULL, NULL, '20-14610685-5', '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 18, 'es', 'Ana Alejandra', 'Escudero', NULL, NULL, NULL, NULL, '27-23004689-7', '175', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 19, 'es', 'Nazario', 'Flores', NULL, NULL, NULL, NULL, '20-18804724-7', '48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 20, 'es', 'Juan Carlos', 'Galera', NULL, NULL, NULL, NULL, '20-14470733-9', '10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 21, 'es', 'Angel Israel', 'Gasen', NULL, NULL, NULL, NULL, '20-25599370-5', '134', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 22, 'es', 'Juan Pablo', 'Gonzalez Rios', NULL, NULL, NULL, NULL, '20-24825424-7', '147', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 23, 'es', 'Ezequiel', 'Gonzalez', NULL, NULL, NULL, NULL, '20-31327518-4', '178', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 24, 'es', 'Antonio Luis', 'Grillo', NULL, NULL, NULL, NULL, '20-28413690-0', '105', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 25, 'es', 'Eduardo Rolando', 'Hermosilla', NULL, NULL, NULL, NULL, '20-12283825-1', '117', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 26, 'es', 'Margot Tamara', 'Hormazabal', NULL, NULL, NULL, NULL, '27-27109628-9', '175', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 27, 'es', 'Juan', 'Huenchullanca Juan', NULL, NULL, NULL, NULL, '20-92708633-7', '15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 28, 'es', 'Fernando Damián', 'Iranzo', NULL, NULL, NULL, NULL, '20-30174979-2', '68', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 29, 'es', 'Diego Ubaldo', 'Jaramillo', NULL, NULL, NULL, NULL, '20-29206249-5', '77', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 30, 'es', 'Guillermo Cesar', 'Kutscher', NULL, NULL, NULL, NULL, '20-25216153-9', '131', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 31, 'es', 'Monica Beatriz', 'Lagos', NULL, NULL, NULL, NULL, '27-26356944-5', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 32, 'es', 'Mario Eduardo', 'Lopez', NULL, NULL, NULL, NULL, '20-26575979-4', '54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 33, 'es', 'Pedro Nicolás', 'Mamani', NULL, NULL, NULL, NULL, '20-30725842-1', '67', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 34, 'es', 'Pedro Daniel', 'Marinao', NULL, NULL, NULL, NULL, '20-27232892-8', '106', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 35, 'es', 'Octavio Eduardo', 'Martinez', NULL, NULL, NULL, NULL, '20-31613937-0', '169', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 36, 'es', 'Ariel Andres', 'Medina', NULL, NULL, NULL, NULL, '20-26331196-6', '184', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 37, 'es', 'Osvaldo Omar', 'Menna', NULL, NULL, NULL, NULL, '20-08397662-5', '136', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 38, 'es', 'Marcelo Juan Victor', 'Molina', NULL, NULL, NULL, NULL, '20-30770747-1', '97', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 39, 'es', 'Rodrigo', 'Molina Moyano', NULL, NULL, NULL, NULL, '20-31284016-3', '146', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 40, 'es', 'Mario Cesar', 'Morales', NULL, NULL, NULL, NULL, '23-30131334-9', '93', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 41, 'es', 'Marcelo Alejandro', 'Navarrete', NULL, NULL, NULL, NULL, '20-30144579-3', '133', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 42, 'es', 'Diego Gaston', 'Ojeda', NULL, NULL, NULL, NULL, '20-29382759-2', '101', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 43, 'es', 'Claudio Rubén', 'Ortega', NULL, NULL, NULL, NULL, '20-24102073-9', '103', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 44, 'es', 'Ramón Carlos', 'Pacheco', NULL, NULL, NULL, NULL, '20-26989104-2', '76', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 45, 'es', 'Carlos Luciano', 'Paredes', NULL, NULL, NULL, NULL, '20-29973452-9', '89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 46, 'es', 'Gustavo Cesar', 'Perez', NULL, NULL, NULL, NULL, '20-18395750-4', '21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 47, 'es', 'Enzo Fernando', 'Plaate', NULL, NULL, NULL, NULL, '20-25679161-8', '60', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 48, 'es', 'Diego Alfredo', 'Pulicari', NULL, NULL, NULL, NULL, '20-30412897-7', '80', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 49, 'es', 'Julio Cesar', 'Rodriguez', NULL, NULL, NULL, NULL, '20-20612642-7', '78', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 50, 'es', 'Alfredo Juan', 'Sandoval', NULL, NULL, NULL, NULL, '23-31359087-9', '143', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 51, 'es', 'Ana Roberta ', 'Sanrame', NULL, NULL, NULL, NULL, '27-21756492-7', '166', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 52, 'es', 'Hector Omar', 'Santillan', NULL, NULL, NULL, NULL, '20-25540996-5', '181', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 53, 'es', 'Manuel Patricio', 'Santillan', NULL, NULL, NULL, NULL, '20-24009262-0', '182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 54, 'es', 'Luis Ricardo', 'Schrott', NULL, NULL, NULL, NULL, '20-11789011-3', '96', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 55, 'es', 'Gabriel', 'Stuardo', NULL, NULL, NULL, NULL, '20-29736102-4', '158', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 56, 'es', 'Angel Mauricio', 'Toro', NULL, NULL, NULL, NULL, '23-31483540-9', '125', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 57, 'es', 'Graciela Beatriz', 'Torres', NULL, NULL, NULL, NULL, '27-13786219-6', '98', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 58, 'es', 'Guillermo Andres', 'Tosi Dealbera', NULL, NULL, NULL, NULL, '23-24581246-9', '115', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 59, 'es', 'Pablo Daniel', 'Velardez', NULL, NULL, NULL, NULL, '23-29786090-9', '180', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 60, 'es', 'Adrian Guillermo', 'Zampa', NULL, NULL, NULL, NULL, '20-24271891-8', '53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 63, 'es', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
  `id` int(11) NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `cantidad` int(11) default NULL,
  `numero_remito` varchar(20) default NULL,
  `transportista_interno_id` int(11) default NULL,
  `transportista_externo_id` int(11) default NULL,
  `fecha` datetime default NULL,
  `comentario` text,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `venta_FI_1` (`producto_id`),
  KEY `venta_FI_2` (`transportista_interno_id`),
  KEY `venta_FI_3` (`transportista_externo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `venta`
--


-- --------------------------------------------------------

--
-- Table structure for table `venta_estado`
--

CREATE TABLE IF NOT EXISTS `venta_estado` (
  `id` int(11) NOT NULL auto_increment,
  `venta_id` int(11) default NULL,
  `estado_id` tinyint(4) default NULL,
  `user_id` int(11) default NULL,
  `observaciones` text,
  `fecha` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `venta_estado_FI_1` (`venta_id`),
  KEY `venta_estado_FI_2` (`estado_id`),
  KEY `venta_estado_FI_3` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `venta_estado`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_FK_2` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_FK_3` FOREIGN KEY (`nota_pedido_id`) REFERENCES `nota_pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `compra_estado`
--
ALTER TABLE `compra_estado`
  ADD CONSTRAINT `compra_estado_FK_1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_estado_FK_2` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_estado_FK_3` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_estado_FK_4` FOREIGN KEY (`nota_recepcion_id`) REFERENCES `recepcion_pedido` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evento_FK_2` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `geo_localidad`
--
ALTER TABLE `geo_localidad`
  ADD CONSTRAINT `geo_localidad_FK_1` FOREIGN KEY (`provincia_id`) REFERENCES `geo_provincia` (`id`);

--
-- Constraints for table `geo_provincia`
--
ALTER TABLE `geo_provincia`
  ADD CONSTRAINT `geo_provincia_FK_1` FOREIGN KEY (`pais_id`) REFERENCES `geo_pais` (`id`);

--
-- Constraints for table `nota_pedido`
--
ALTER TABLE `nota_pedido`
  ADD CONSTRAINT `nota_pedido_FK_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_FK_2` FOREIGN KEY (`condicion_pago`) REFERENCES `formas_de_pago` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_FK_3` FOREIGN KEY (`transporte_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_FK_4` FOREIGN KEY (`administra_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_FK_5` FOREIGN KEY (`solicita_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_FK_6` FOREIGN KEY (`controla_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_FK_7` FOREIGN KEY (`autoriza_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nota_pedido_estado`
--
ALTER TABLE `nota_pedido_estado`
  ADD CONSTRAINT `nota_pedido_estado_FK_1` FOREIGN KEY (`nota_pedido_id`) REFERENCES `nota_pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_estado_FK_2` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_estado_FK_3` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_FK_1` FOREIGN KEY (`producto_categoria_id`) REFERENCES `producto_categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_FK_2` FOREIGN KEY (`producto_udm_id`) REFERENCES `producto_udm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `producto_archivo`
--
ALTER TABLE `producto_archivo`
  ADD CONSTRAINT `producto_archivo_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_archivo_FK_2` FOREIGN KEY (`archivo_id`) REFERENCES `archivo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `producto_proveedor`
--
ALTER TABLE `producto_proveedor`
  ADD CONSTRAINT `producto_proveedor_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_proveedor_FK_2` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_FK_1` FOREIGN KEY (`rubro_id`) REFERENCES `proveedor_rubro` (`id`),
  ADD CONSTRAINT `proveedor_FK_2` FOREIGN KEY (`localidad_id`) REFERENCES `geo_localidad` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proveedor_FK_3` FOREIGN KEY (`provincia_id`) REFERENCES `geo_provincia` (`id`);

--
-- Constraints for table `proveedor_formas_de_pago`
--
ALTER TABLE `proveedor_formas_de_pago`
  ADD CONSTRAINT `proveedor_formas_de_pago_FK_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proveedor_formas_de_pago_FK_2` FOREIGN KEY (`fdp_id`) REFERENCES `proveedor_formas_de_pago` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recepcion_pedido`
--
ALTER TABLE `recepcion_pedido`
  ADD CONSTRAINT `recepcion_pedido_FK_1` FOREIGN KEY (`nota_pedido_id`) REFERENCES `nota_pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recepcion_pedido_FK_2` FOREIGN KEY (`recibe_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recepcion_pedido_FK_3` FOREIGN KEY (`controla_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recepcion_pedido_FK_4` FOREIGN KEY (`administra_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recepcion_pedido_FK_5` FOREIGN KEY (`transportista_id`) REFERENCES `proveedor` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sf_guard_group_permission`
--
ALTER TABLE `sf_guard_group_permission`
  ADD CONSTRAINT `sf_guard_group_permission_FK_1` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_group_permission_FK_2` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sf_guard_remember_key`
--
ALTER TABLE `sf_guard_remember_key`
  ADD CONSTRAINT `sf_guard_remember_key_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sf_guard_user_group`
--
ALTER TABLE `sf_guard_user_group`
  ADD CONSTRAINT `sf_guard_user_group_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_group_FK_2` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sf_guard_user_permission`
--
ALTER TABLE `sf_guard_user_permission`
  ADD CONSTRAINT `sf_guard_user_permission_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_permission_FK_2` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sf_guard_user_profile`
--
ALTER TABLE `sf_guard_user_profile`
  ADD CONSTRAINT `sf_guard_user_profile_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_profile_FK_2` FOREIGN KEY (`nacionalidad`) REFERENCES `geo_pais` (`id`),
  ADD CONSTRAINT `sf_guard_user_profile_FK_3` FOREIGN KEY (`localidad_id`) REFERENCES `geo_localidad` (`id`),
  ADD CONSTRAINT `sf_guard_user_profile_FK_4` FOREIGN KEY (`provincia_id`) REFERENCES `geo_provincia` (`id`);

--
-- Constraints for table `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_FK_2` FOREIGN KEY (`transportista_interno_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_FK_3` FOREIGN KEY (`transportista_externo_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `venta_estado`
--
ALTER TABLE `venta_estado`
  ADD CONSTRAINT `venta_estado_FK_1` FOREIGN KEY (`venta_id`) REFERENCES `venta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_estado_FK_2` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_estado_FK_3` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
