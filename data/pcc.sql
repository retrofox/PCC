-- phpMyAdmin SQL Dump
-- version 2.11.7-rc1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 15-04-2009 a las 21:23:49
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.4-2ubuntu5.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pcc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo`
--

CREATE TABLE IF NOT EXISTS `archivo` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del Archivo (255)',
  `tipo` varchar(20) default NULL COMMENT 'Tipo del Archivo (20)',
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `archivo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
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
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nota_pedido_producto` (`nota_pedido_id`,`producto_id`),
  KEY `compra_FI_1` (`producto_id`),
  KEY `compra_FI_2` (`proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `compra`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_estado`
--

CREATE TABLE IF NOT EXISTS `compra_estado` (
  `id` int(11) NOT NULL auto_increment,
  `compra_id` int(11) default NULL,
  `estado_id` tinyint(4) default NULL,
  `user_id` int(11) default NULL,
  `cantidad` int(11) default '0',
  `fecha` datetime default NULL,
  `observaciones` text,
  `nota_recepcion_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `compra_estado_FI_1` (`compra_id`),
  KEY `compra_estado_FI_2` (`estado_id`),
  KEY `compra_estado_FI_3` (`user_id`),
  KEY `compra_estado_FI_4` (`nota_recepcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `compra_estado`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id` tinyint(4) NOT NULL auto_increment,
  `orden` tinyint(4) NOT NULL COMMENT 'Indica el orden que puede tener un estado dentro de los diferentes estados',
  `tipo` tinyint(4) NOT NULL COMMENT 'Define si es estado para una compra (0), venta (1), nota de pedido (2), etc',
  `descripcion` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Volcar la base de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `orden`, `tipo`, `descripcion`) VALUES
(1, 0, 0, 'Iniciado. Siempre qu'),
(2, 1, 0, 'Aceptado. Una compra'),
(3, 2, 0, 'Rechazado. Este esta'),
(4, 3, 0, 'Pausado. La compra q'),
(5, 4, 0, 'Realizado. La compra'),
(6, 5, 0, 'Entrega Parcial.'),
(7, 0, 1, 'Iniciado'),
(8, 1, 1, 'Aceptado'),
(9, 2, 1, 'Rechazado'),
(10, 3, 1, 'Pausado'),
(11, 4, 1, 'Realizado'),
(12, 5, 1, 'Reservado'),
(13, 1, 2, 'Administración - Ini'),
(14, 2, 2, 'Administración - Can'),
(15, 3, 2, 'Administración - Mod'),
(16, 4, 2, 'Control de Costos - '),
(17, 5, 2, 'Control de Costos - '),
(18, 6, 2, 'Control de Costos - '),
(19, 7, 2, 'Autorización - Deneg'),
(20, 8, 2, 'Autorización - Acept'),
(21, 9, 2, 'Autorización - En Es');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `user_id` int(11) default NULL COMMENT 'Estable que usuario ha realizado el evento',
  `fecha` datetime default NULL,
  `descripcion` text,
  `cantidad` int(11) default NULL,
  `operacion` tinyint(4) default NULL COMMENT 'Operacion de Incremento/Decremento del stock del producto',
  PRIMARY KEY  (`id`),
  KEY `evento_FI_1` (`producto_id`),
  KEY `evento_FI_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `producto_id`, `user_id`, `fecha`, `descripcion`, `cantidad`, `operacion`) VALUES
(1, 1, NULL, '2009-03-08 14:54:00', '', NULL, 0),
(2, 1, NULL, '2009-03-08 15:03:00', 'Stock Inicial', 20, 0),
(3, 1, NULL, '2009-03-09 18:51:00', '', NULL, 1),
(4, 2, NULL, '2009-03-09 18:54:00', '', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formas_de_pago`
--

CREATE TABLE IF NOT EXISTS `formas_de_pago` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) default NULL,
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `formas_de_pago`
--

INSERT INTO `formas_de_pago` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Contado en Pesos', 'Pago al contado en Pesos Argentinos.'),
(2, 'Cuenta Corriente', 'Pago a trevés de Cuenta Corriente.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geo_localidad`
--

CREATE TABLE IF NOT EXISTS `geo_localidad` (
  `id` int(11) NOT NULL auto_increment,
  `provincia_id` int(11) default NULL,
  `nombre` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `geo_localidad_FI_1` (`provincia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `geo_localidad`
--

INSERT INTO `geo_localidad` (`id`, `provincia_id`, `nombre`) VALUES
(1, 12, 'Neuquén Capital'),
(2, 12, 'Plottier'),
(3, 12, 'Centenario'),
(4, 11, 'Cipolletti'),
(5, 11, 'Cinco Saltos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geo_pais`
--

CREATE TABLE IF NOT EXISTS `geo_pais` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `codigo` varchar(2) default NULL COMMENT 'Codigo ISO de Pais (2)',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `geo_pais`
--

INSERT INTO `geo_pais` (`id`, `nombre`, `codigo`) VALUES
(1, 'Argentina', 'AR'),
(2, 'Chile', 'CH'),
(3, 'Paraguay', 'PY'),
(4, 'Brasil', 'BR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geo_provincia`
--

CREATE TABLE IF NOT EXISTS `geo_provincia` (
  `id` int(11) NOT NULL auto_increment,
  `pais_id` varchar(2) default NULL,
  `nombre` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Volcar la base de datos para la tabla `geo_provincia`
--

INSERT INTO `geo_provincia` (`id`, `pais_id`, `nombre`) VALUES
(1, 'ar', 'Capital Federal'),
(2, 'ar', 'Gran Buenos Aires'),
(3, 'ar', 'Buenos Aires'),
(4, 'ar', 'Catamarca'),
(5, 'ar', 'Cordoba'),
(6, 'ar', 'Chaco'),
(7, 'ar', 'Corrientes'),
(8, 'ar', 'Entre Rios'),
(9, 'ar', 'Santa Cruz'),
(10, 'ar', 'Formosa'),
(11, 'ar', 'Rio Negro'),
(12, 'ar', 'Neuquen'),
(13, 'ar', 'Santa Fe'),
(14, 'ar', 'Jujuy'),
(15, 'ar', 'Mendoza'),
(16, 'ar', 'Tucumán'),
(17, 'ar', 'Salta'),
(18, 'ar', 'Misiones'),
(19, 'ar', 'Santiago del Estero'),
(20, 'ar', 'San Juan'),
(21, 'ar', 'Chubut'),
(22, 'ar', 'San Luis'),
(23, 'ar', 'La Rioja'),
(24, 'ar', 'La Pampa'),
(25, 'ar', 'Tierra del Fuego');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_pedido`
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
  `Otros` tinyint(4) default '0',
  `otros_descripcion` varchar(50) default NULL,
  `fecha_entrega` date default NULL,
  `administra_id` int(11) default NULL,
  `solicita_id` int(11) default NULL,
  `controla_id` int(11) default NULL,
  `autoriza_id` int(11) default NULL,
  `recepcion_total` tinyint(4) default '0',
  `bloqueada` tinyint(4) default '0',
  `ultima_revision` tinyint(4) default '1',
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
-- Volcar la base de datos para la tabla `nota_pedido`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_pedido_estado`
--

CREATE TABLE IF NOT EXISTS `nota_pedido_estado` (
  `id` int(11) NOT NULL auto_increment,
  `nota_pedido_id` int(11) default NULL,
  `estado_id` tinyint(4) default NULL,
  `user_id` int(11) default NULL,
  `observaciones` text,
  `fecha` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `nota_pedido_estado_FI_1` (`nota_pedido_id`),
  KEY `nota_pedido_estado_FI_2` (`estado_id`),
  KEY `nota_pedido_estado_FI_3` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `nota_pedido_estado`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
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
-- Volcar la base de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `codigo`, `nombre`, `marca`, `descripcion`, `producto_categoria_id`, `producto_udm_id`, `ubicacion_fisica`, `stock_actual`, `stock_reservado`, `stock_preaviso`, `stock_critico`) VALUES
(1, 'COQ', 'Coque Calcinado de Petroleo', 'Loresco', 'Bolsa de Coque LORESCO. Cada Pallets cuenta con 45, cada una pesa 22.72 Kg.', 1, 6, 'Patio Exterior', NULL, NULL, 20, 0),
(2, 'PPGD FXG 371', 'Eje de Mando', '', 'Eje de mando Parte Nº PPGD FXG 371', 2, 7, 'BOX 1', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_archivo`
--

CREATE TABLE IF NOT EXISTS `producto_archivo` (
  `producto_id` int(11) NOT NULL,
  `archivo_id` int(11) NOT NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`producto_id`,`archivo_id`),
  KEY `producto_archivo_FI_2` (`archivo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `producto_archivo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_categoria`
--

CREATE TABLE IF NOT EXISTS `producto_categoria` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre de la Categoria (50)',
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `producto_categoria`
--

INSERT INTO `producto_categoria` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Coque', 'El coque es un combustible obtenido de la destilación de la hulla calentada a temperaturas muy altas en hornos cerrados, que la aislan del aire, y que sólo contiene una pequeña fracción de las materias volátiles que forman parte de la misma. Es producto de la descomposición térmica de carbones bituminosos en ausencia de aire. Cuando la hulla se calienta desprende gases que son muy útiles industrialmente; el sólido resultante es el carbón de coque, que es liviano y poroso.'),
(2, 'Repuesto de Bomba G.Denver 5x6', 'Repuesto de Bomba G.Denver 5x6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_proveedor`
--

CREATE TABLE IF NOT EXISTS `producto_proveedor` (
  `producto_id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  PRIMARY KEY  (`producto_id`,`proveedor_id`),
  KEY `producto_proveedor_FI_2` (`proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `producto_proveedor`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_udm`
--

CREATE TABLE IF NOT EXISTS `producto_udm` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre de la Unidad de Medida (50)',
  `unidad` varchar(15) default NULL COMMENT 'Unidad propiamente dicha, Por ejemplo "m"',
  `unidad_mas_multi` varchar(15) default NULL COMMENT 'Es la unidad mas el multiplo o submultiplo, por ejemplo, Kg.',
  `descripcion` text,
  `dimension` varchar(15) default NULL COMMENT 'Dimension de la unidad. Puede ser lineal, cuadrÃ¡tica, Ä‡ubica, etc.',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `producto_udm`
--

INSERT INTO `producto_udm` (`id`, `nombre`, `unidad`, `unidad_mas_multi`, `descripcion`, `dimension`) VALUES
(1, 'Metro', 'm', 'm', 'El metro es la unidad de longitud del Sistema Internacional de Unidades. Se define como la longitud del trayecto recorrido en el vacío por la luz durante un tiempo de 1/299 792 458 de segundo (unidad de tiempo) (aproximadamente 3,34 ns).', 'Lineal'),
(2, 'Kilometro', 'm', 'Km', 'Si bien la unidad es el metro, definimos km como unidad indendiente para aquellos casos en que el uso del km es más frecuente.', 'Lineal'),
(3, 'mts2', NULL, NULL, 'Metros Cuadrados. Superficie. Magntud Cuadrática.', NULL),
(4, 'mts3', NULL, NULL, 'Metros Cubicos. Volúmen. Magnitud Cúbica.', NULL),
(5, 'unidad', NULL, NULL, 'Unidades. Cantidad. Magnitud Lineal.', NULL),
(6, 'Bolsa', 'bls', 'bls', 'Se define ''bolsa'' como unidad de medida para aquellos productos que se cuantifican en bolsas, por ejemplo, Coque, Yeso, etc.', 'Lineal'),
(7, 'Unidad', 'u', 'u', 'Cantidad lineal unitaria para cuantificar productos que no tienen una magnitud particular, por ejemplo, bulones, bobinas de cable, etc.', 'Lineal'),
(8, 'gramos', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE IF NOT EXISTS `proveedor` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) default NULL COMMENT 'Nombre del Proveedor (244)',
  `cuit` varchar(20) default NULL COMMENT 'Cuit del Proveedor (50)',
  `rubro_id` int(11) default NULL,
  `telefono` varchar(100) default NULL COMMENT 'Telefono del Proveedor (100)',
  `fax` varchar(100) default NULL COMMENT 'Fax del Proveedor (100)',
  `movil` varchar(100) default NULL COMMENT 'Celular del Proveedor (100)',
  `email` varchar(255) default NULL,
  `user_id` int(11) default NULL,
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
  KEY `proveedor_FI_2` (`user_id`),
  KEY `proveedor_FI_3` (`localidad_id`),
  KEY `proveedor_FI_4` (`provincia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `nombre`, `cuit`, `rubro_id`, `telefono`, `fax`, `movil`, `email`, `user_id`, `direccion_calle`, `direccion_numero`, `direccion_manzana`, `direccion_barrio`, `direccion_piso`, `direccion_depto`, `localidad_id`, `provincia_id`) VALUES
(1, 'Arauco Camiones', NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Comercial Argentina SRL', NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Chasqui SRL', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Distribuidora Leo', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'El Quijote SRL', NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor_formas_de_pago`
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
-- Volcar la base de datos para la tabla `proveedor_formas_de_pago`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor_rubro`
--

CREATE TABLE IF NOT EXISTS `proveedor_rubro` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) default NULL COMMENT 'Rubro del Proveedor (2)',
  `descripcion` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `proveedor_rubro`
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
-- Estructura de tabla para la tabla `recepcion_pedido`
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
-- Volcar la base de datos para la tabla `recepcion_pedido`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sf_guard_group_U_1` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `sf_guard_group`
--

INSERT INTO `sf_guard_group` (`id`, `name`, `description`) VALUES
(1, 'Administración', 'Grupo de Usuarios de Administración. Pueden acceder a todos los módulos de la aplicación'),
(2, 'Stock', 'Usuarios relacionados con acciones para el control de stock de la empresa. Pueden dar de alta/baja productos, seguimiento del control stock, etc.'),
(3, 'Contaduría', 'Usuarios pertenecientes al sector contable de la empresa.'),
(4, 'Recursos Humanos', 'Usuarios pertenecientes al sector de Recursos Humanos.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_group_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group_permission` (
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY  (`group_id`,`permission_id`),
  KEY `sf_guard_group_permission_FI_2` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `sf_guard_group_permission`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_permission` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sf_guard_permission_U_1` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `sf_guard_permission`
--

INSERT INTO `sf_guard_permission` (`id`, `name`, `description`) VALUES
(1, 'Administrador', 'Usuario administrador de toda la aplicación'),
(2, 'Administrador de Usuario', 'Usuario que puede administrador los usuarios de la aplicacion'),
(3, 'Stock', 'Usuario administrador con los modulos relacionados con el stock de la empresa'),
(4, 'Tesorería', 'Usuario con provilegios para administrar modulos contables');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_remember_key`
--

CREATE TABLE IF NOT EXISTS `sf_guard_remember_key` (
  `user_id` int(11) NOT NULL,
  `remember_key` varchar(32) default NULL,
  `ip_address` varchar(50) NOT NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`user_id`,`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `sf_guard_remember_key`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_user`
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
-- Volcar la base de datos para la tabla `sf_guard_user`
--

INSERT INTO `sf_guard_user` (`id`, `username`, `algorithm`, `salt`, `password`, `created_at`, `last_login`, `is_active`, `is_super_admin`) VALUES
(1, 'pamestic', 'sha1', '42c2b7f920b762f70ad6e77c0f05dc25', 'c93dde102cab53d5776306e0866d18608fceeb53', '2009-03-08 14:14:25', NULL, 1, 0),
(2, 'cbandier', 'sha1', 'f407acf5ecef4b9dfe08e3628afa4e3f', '3c87fca75e1f971d83ab63979a4c0eef7cae87a5', '2009-03-08 14:14:25', NULL, 1, 0),
(3, 'dbandier', 'sha1', '351e59fe33b41862ce856d6958ca7f05', 'eca54284be403426cd4104a17b2bebe2de389ae3', '2009-03-08 14:14:25', NULL, 1, 0),
(4, 'mbandier', 'sha1', '47bb73884f70d7716fd9b27698b261f6', 'a18c471f612ecdf65a7cb330c7e5f74298cb06bb', '2009-03-08 14:14:25', NULL, 1, 0),
(5, 'Pbarros', 'sha1', '0fa1bbe3501988cfd86459208bc23738', '2072698e395c1390786930daa1974ad4e396c98b', '2009-03-08 14:14:25', NULL, 1, 0),
(6, 'cborella', 'sha1', '5b7e0412b234922f4d2dc385f685a40f', '548f665f4e10ac6fa7c321eb68a279fbb14f6e61', '2009-03-08 14:14:25', NULL, 1, 0),
(7, 'jbrion', 'sha1', 'b779314035399a4b93e1cc43fc6d4cdb', 'b1423a7168d55d51605824718ee777cddc07b537', '2009-03-08 14:14:25', NULL, 1, 0),
(8, 'dcaceres', 'sha1', 'c4447c5e7f46d5b761a8cb99628df85b', '649692dba2d8330e4585ddf0b88815aa5daa70d7', '2009-03-08 14:14:25', NULL, 1, 0),
(9, 'rcastill', 'sha1', '5a7572e950afa0727f0a896940bdba8d', '2ed31894500699d3871613b4b376c8e015f20db9', '2009-03-08 14:14:25', NULL, 1, 0),
(10, 'ecastro', 'sha1', 'f9b1d22e1fa6282d87262b55a32d064f', 'ae672bcc68e2c835bdb75c07d81b744167663ed4', '2009-03-08 14:14:25', NULL, 1, 0),
(11, 'mcataldo', 'sha1', 'ed5528ebf483bd81f816b42e6c92ecca', '7fd2cd4d17a8d3f6429d07195e8cb65573dd1a48', '2009-03-08 14:14:25', NULL, 1, 0),
(12, 'ocaucama', 'sha1', '891fafc5b0da8addbaf3419a0fb16aa5', '750f850add30692ca7447aff075d8a516d148397', '2009-03-08 14:14:25', NULL, 1, 0),
(13, 'jcedro', 'sha1', '4117ab8c31d56f4c47873b813e307055', '445a6f08f154117c58f770f79370d476b704a3a3', '2009-03-08 14:14:25', NULL, 1, 0),
(14, 'gcontrer', 'sha1', 'e426c7aac33d2cec90a9a67eaa5ca1da', 'b8ac65d29f12d4d4f31821bfdb0df41d3fefc1e7', '2009-03-08 14:14:25', NULL, 1, 0),
(15, 'rcontrer', 'sha1', '3ad5be0b4187c3091b850a6082057771', 'e7187a958653b795147aae7ab56a02c3156b2f28', '2009-03-08 14:14:25', NULL, 1, 0),
(16, 'ecortez', 'sha1', '5e01bc633cc3e81521340a8817fe0321', '5e7c4846bd90f0b5f80835c7e3d488ddca69784a', '2009-03-08 14:14:25', NULL, 1, 0),
(17, 'edemonte', 'sha1', '8c50c2c71c046904731dade29d57e90a', 'bc76ed8192c869e87a2b3a23789a37f48247e677', '2009-03-08 14:14:25', NULL, 1, 0),
(18, 'aescuder', 'sha1', '6e9168dae0c32bf212bf0622924c0715', '9129b04b58c96f8bf84966d7601a8f4a8bcb1911', '2009-03-08 14:14:25', NULL, 1, 0),
(19, 'nflores', 'sha1', '02c5ff62a4f82918181e8d1c0d3a3bcc', '6ad1cd1f09a7b684165a61811d42a649fec40ea4', '2009-03-08 14:14:25', NULL, 1, 0),
(20, 'jgalera', 'sha1', 'e97433f5d8aebeacae4d1e5f43772e55', '84c59d6f2f5fb2cd847d7f2165b61292ce106b25', '2009-03-08 14:14:25', NULL, 1, 0),
(21, 'agasen', 'sha1', '818bb925dd2b60bd78e64c025a0ef75b', 'e5a26be01da93b0aec846790b8856a1840dfd1fe', '2009-03-08 14:14:25', NULL, 1, 0),
(22, 'jgonzale', 'sha1', '82f96a9db11c4f1ed2fb582b6f822f9e', 'c03f3af9aaea9e4a663502b214c55a6e0cd67c88', '2009-03-08 14:14:25', NULL, 1, 0),
(23, 'egonzale', 'sha1', 'd2d15ea96c4e38d2f07683f966f33df4', '08eb50254198f094370e5362745f59986d3fed18', '2009-03-08 14:14:25', NULL, 1, 0),
(24, 'agrillo', 'sha1', '06923847b4afafb1db88d2e3f67e4177', '3aa77c6c581541e09ec6c10983bd8806cfa58b23', '2009-03-08 14:14:25', NULL, 1, 0),
(25, 'ehermosi', 'sha1', '527c69dbbc1b1eaa9003c6ea440e9639', '4384682f8d225f2d080a9d70a4a695e6edcbef8a', '2009-03-08 14:14:25', NULL, 1, 0),
(26, 'mhormaza', 'sha1', 'd546cfe8b0bd419dcb117feeb7f77183', '11b957bac5f78d914a93e601ee7150235d395028', '2009-03-08 14:14:25', NULL, 1, 0),
(27, 'jhuenchu', 'sha1', '2e479cd4aa9ddf21f09a503f0e6b283d', 'c82dca2d3d5c78b04f92a1e85d706424e5ed2e14', '2009-03-08 14:14:25', NULL, 1, 0),
(28, 'firanzo', 'sha1', '4359ed4cd96080027e2c5c5390868155', '06f14b7648c0880684e3ee3f373cd6cc239f39a2', '2009-03-08 14:14:25', NULL, 1, 0),
(29, 'djaramil', 'sha1', '8843af77ac13592eae5481617737dcbb', '7d1923de5a43263b38d7de15581c9b4aacd6204c', '2009-03-08 14:14:25', NULL, 1, 0),
(30, 'gkutsche', 'sha1', '123e2623686d858595d9250e6bc0c378', 'ffff86fc3086650b17983a550a7e2d40511a413c', '2009-03-08 14:14:25', NULL, 1, 0),
(31, 'mlagos', 'sha1', 'd3983908a79ec942e85a0d83610ef4ba', '24d775e7d7f1782c7210fd1f0fd07553444df8e6', '2009-03-08 14:14:25', NULL, 1, 0),
(32, 'mlopez', 'sha1', '89a78a7dcb4baf51bf0e65c4f7613142', '6bd5fb0634c25a47ba8e0862891857d319b76222', '2009-03-08 14:14:25', NULL, 1, 0),
(33, 'pmamani', 'sha1', 'c6d64c73247deda3d8ca2482645ca938', 'dbb6c7c239a283fc1531803ba51c8aa73acf3c7c', '2009-03-08 14:14:25', NULL, 1, 0),
(34, 'pmarinao', 'sha1', 'db8994169e118080efecb7164c3039a5', '7ac14dd89717cd1398c50dfdc245112dae570eb7', '2009-03-08 14:14:25', NULL, 1, 0),
(35, 'omartine', 'sha1', '5719350d4dc52ca6474f911e3f1c5555', '3ad73fbc4b9f9619fa2f56003561b6d1f95b3a16', '2009-03-08 14:14:25', NULL, 1, 0),
(36, 'amedina', 'sha1', '3faa93406d7583a49dc74d6529c24981', '48e209559997b704e1700b92b2b3c87448e3b5c3', '2009-03-08 14:14:25', NULL, 1, 0),
(37, 'omenna', 'sha1', '837a18ed230760c257e0be576df40671', 'ff740963b411d551c0a98a6fc76b7ffd2d3afb95', '2009-03-08 14:14:25', NULL, 1, 0),
(38, 'mmolina', 'sha1', 'bb981f7c608e2133aa454168a7026bb2', '818900f943277635793ebd9cee7df56de7981ce1', '2009-03-08 14:14:25', NULL, 1, 0),
(39, 'rmolina', 'sha1', '054d9d10fa3803502a96ad375ab4a986', '365164dfff8f578dd46863477439a3bff7c091be', '2009-03-08 14:14:25', NULL, 1, 0),
(40, 'mmorales', 'sha1', '810a9f4cdfcec1630018fd801320d066', '22230a5efbf5850cd9452058d229b450e5f90138', '2009-03-08 14:14:25', NULL, 1, 0),
(41, 'mnavarre', 'sha1', 'd6beffd4634ffdd695407082ab6f1e28', '246f3bf3e64ff61d0bcd66d22326da7e0c3e7cbc', '2009-03-08 14:14:25', NULL, 1, 0),
(42, 'dojeda', 'sha1', 'b8ec03cc9bc2a1eef5d37a2c0a350793', '158cf9ca85f9bd4a1cd5b7da4be6a3414fdca4d7', '2009-03-08 14:14:25', NULL, 1, 0),
(43, 'cortega', 'sha1', '1845039a62aa13c084037ec38be8a007', '2989e90816deefa597f780a8a64c017298cee789', '2009-03-08 14:14:25', NULL, 1, 0),
(44, 'rpacheco', 'sha1', '81de50ab5cba4ee6fcf41e563a4744fd', '8eb88cd6ab1915d1115271b71a6829a2b12e813c', '2009-03-08 14:14:25', NULL, 1, 0),
(45, 'cparedes', 'sha1', '6ce896f93030158ab378ff7bd59641b1', '4fbd6735a22c39ad8c1a08401edd1bedeecd035e', '2009-03-08 14:14:25', NULL, 1, 0),
(46, 'gperez', 'sha1', '666087cf3d05edc7ff5393fd3112e969', 'ae734ef18095920e0c10c43d36360e2c2e520c67', '2009-03-08 14:14:25', NULL, 1, 0),
(47, 'eplaate', 'sha1', 'a950f59e58e5cef1526d22f6fa9073e5', '01201371a1b37f4677de5d675b7f23a48efd2b05', '2009-03-08 14:14:25', NULL, 1, 0),
(48, 'dpulicar', 'sha1', 'a58d86123283c4f30c310629d6aa8743', '2678b35cf386e8a7abc1f1434cd3ad09470446ef', '2009-03-08 14:14:25', NULL, 1, 0),
(49, 'jrodrigu', 'sha1', 'a6eae875eeb51b7ff47fe0d476458ee1', '0c5e61b9548108dc1aa9c9fff6c4689532d823c7', '2009-03-08 14:14:25', NULL, 1, 0),
(50, 'asandova', 'sha1', 'cf5d63ffcbf3d7cffb6279747e13ff0b', '322604a225b8154d3c87994df974205d2ddbc768', '2009-03-08 14:14:25', NULL, 1, 0),
(51, 'asanrame', 'sha1', 'b8037587a54e86eaae69810be9bc7590', '03f12b773be1548fd9277ed31533626e591c83d6', '2009-03-08 14:14:25', NULL, 1, 0),
(52, 'hsantill', 'sha1', '4d959d7a8d935aeb7af6cb23cb7795cf', '66e37f6841dff79a98afb65dfecaa5a3784ddcd2', '2009-03-08 14:14:25', NULL, 1, 0),
(53, 'msantill', 'sha1', '39101043b4316c529d24a7d33225d210', 'dd2fa250e315233a665afc20fc3c465bf596fe07', '2009-03-08 14:14:25', NULL, 1, 0),
(54, 'lschrott', 'sha1', '539631a02d12df82662352d29ce60037', '5a3d9242a7788dd0c7eba3c465ce3312f95e4ffa', '2009-03-08 14:14:25', NULL, 1, 0),
(55, 'gstuardo', 'sha1', 'cb98adc477ee78fe4aba96a00d90d935', 'be01349a4b98e97166801bf2b1b755600120bb7a', '2009-03-08 14:14:25', NULL, 1, 0),
(56, 'atoro', 'sha1', '734fec67209570ec71e732838137fa32', 'dff5b0f3c562d663908d49121fb4d592c8d33dae', '2009-03-08 14:14:25', NULL, 1, 0),
(57, 'gtorres', 'sha1', '0c87edcbf823cce325ce4935a1147d3f', '761d09f6aeccb0b055aefb89cfc8810da0b48f29', '2009-03-08 14:14:25', NULL, 1, 0),
(58, 'gtosi', 'sha1', '65d02dc7c7fb62d6d246799ab59bbd64', 'cef0aa54437248fd58662e28e66be46434fbe57a', '2009-03-08 14:14:25', NULL, 1, 0),
(59, 'pvelarde', 'sha1', 'c3d1e66369fd5dbfec6a9f2edbd27214', '3a264d00820de49fc01d5cbd25ef6c68baea7ab8', '2009-03-08 14:14:25', NULL, 1, 0),
(60, 'azampa', 'sha1', 'e8bbb64b5f7d4250455b6653b1c1840d', '435f976261caf2daee8b3c574846a9cecd4675d6', '2009-03-08 14:14:25', NULL, 1, 0),
(61, 'Diego', 'sha1', '912bfd57ff267a36359c696f8465a5f2', '8eef806e10e64499cd87a0e9eb386fccd4835b08', '2009-03-08 14:14:25', NULL, 1, 1),
(62, 'German', 'sha1', 'e74562365a2a7c56fe3a0e2ddf1b00d1', '7ca69b62e61913c35728a96189a4f70d3e0d11c4', '2009-03-08 14:14:25', NULL, 1, 0),
(63, 'Damian', 'sha1', 'b4558222156b2203741d3cc39467a870', '8a1ca6130207046d13f93936840a5d0bd1ef592c', '2009-03-08 14:14:25', '2009-04-15 20:12:15', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_user_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`,`group_id`),
  KEY `sf_guard_user_group_FI_2` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `sf_guard_user_group`
--

INSERT INTO `sf_guard_user_group` (`user_id`, `group_id`) VALUES
(5, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_user_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_permission` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`,`permission_id`),
  KEY `sf_guard_user_permission_FI_2` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `sf_guard_user_permission`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_user_profile`
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
-- Volcar la base de datos para la tabla `sf_guard_user_profile`
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
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
  `id` int(11) NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `cantidad` int(11) default NULL,
  `numero_remito` varchar(20) default NULL,
  `transportista_interno_id` int(11) default NULL,
  `transportista_externo_id` int(11) default NULL,
  `fecha` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `venta_FI_1` (`producto_id`),
  KEY `venta_FI_2` (`transportista_interno_id`),
  KEY `venta_FI_3` (`transportista_externo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `venta`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_estado`
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
-- Volcar la base de datos para la tabla `venta_estado`
--


--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_FK_2` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_FK_3` FOREIGN KEY (`nota_pedido_id`) REFERENCES `nota_pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra_estado`
--
ALTER TABLE `compra_estado`
  ADD CONSTRAINT `compra_estado_FK_1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_estado_FK_2` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_estado_FK_3` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_estado_FK_4` FOREIGN KEY (`nota_recepcion_id`) REFERENCES `recepcion_pedido` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evento_FK_2` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `geo_localidad`
--
ALTER TABLE `geo_localidad`
  ADD CONSTRAINT `geo_localidad_FK_1` FOREIGN KEY (`provincia_id`) REFERENCES `geo_provincia` (`id`);

--
-- Filtros para la tabla `nota_pedido`
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
-- Filtros para la tabla `nota_pedido_estado`
--
ALTER TABLE `nota_pedido_estado`
  ADD CONSTRAINT `nota_pedido_estado_FK_1` FOREIGN KEY (`nota_pedido_id`) REFERENCES `nota_pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_estado_FK_2` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_pedido_estado_FK_3` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_FK_1` FOREIGN KEY (`producto_categoria_id`) REFERENCES `producto_categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_FK_2` FOREIGN KEY (`producto_udm_id`) REFERENCES `producto_udm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_archivo`
--
ALTER TABLE `producto_archivo`
  ADD CONSTRAINT `producto_archivo_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_archivo_FK_2` FOREIGN KEY (`archivo_id`) REFERENCES `archivo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_proveedor`
--
ALTER TABLE `producto_proveedor`
  ADD CONSTRAINT `producto_proveedor_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_proveedor_FK_2` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_FK_1` FOREIGN KEY (`rubro_id`) REFERENCES `proveedor_rubro` (`id`),
  ADD CONSTRAINT `proveedor_FK_2` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `proveedor_FK_3` FOREIGN KEY (`localidad_id`) REFERENCES `geo_localidad` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proveedor_FK_4` FOREIGN KEY (`provincia_id`) REFERENCES `geo_provincia` (`id`);

--
-- Filtros para la tabla `proveedor_formas_de_pago`
--
ALTER TABLE `proveedor_formas_de_pago`
  ADD CONSTRAINT `proveedor_formas_de_pago_FK_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proveedor_formas_de_pago_FK_2` FOREIGN KEY (`fdp_id`) REFERENCES `proveedor_formas_de_pago` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recepcion_pedido`
--
ALTER TABLE `recepcion_pedido`
  ADD CONSTRAINT `recepcion_pedido_FK_1` FOREIGN KEY (`nota_pedido_id`) REFERENCES `nota_pedido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recepcion_pedido_FK_2` FOREIGN KEY (`recibe_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recepcion_pedido_FK_3` FOREIGN KEY (`controla_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recepcion_pedido_FK_4` FOREIGN KEY (`administra_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recepcion_pedido_FK_5` FOREIGN KEY (`transportista_id`) REFERENCES `proveedor` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `sf_guard_group_permission`
--
ALTER TABLE `sf_guard_group_permission`
  ADD CONSTRAINT `sf_guard_group_permission_FK_1` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_group_permission_FK_2` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sf_guard_remember_key`
--
ALTER TABLE `sf_guard_remember_key`
  ADD CONSTRAINT `sf_guard_remember_key_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sf_guard_user_group`
--
ALTER TABLE `sf_guard_user_group`
  ADD CONSTRAINT `sf_guard_user_group_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_group_FK_2` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sf_guard_user_permission`
--
ALTER TABLE `sf_guard_user_permission`
  ADD CONSTRAINT `sf_guard_user_permission_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_permission_FK_2` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sf_guard_user_profile`
--
ALTER TABLE `sf_guard_user_profile`
  ADD CONSTRAINT `sf_guard_user_profile_FK_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_profile_FK_2` FOREIGN KEY (`nacionalidad`) REFERENCES `geo_pais` (`id`),
  ADD CONSTRAINT `sf_guard_user_profile_FK_3` FOREIGN KEY (`localidad_id`) REFERENCES `geo_localidad` (`id`),
  ADD CONSTRAINT `sf_guard_user_profile_FK_4` FOREIGN KEY (`provincia_id`) REFERENCES `geo_provincia` (`id`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_FK_2` FOREIGN KEY (`transportista_interno_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_FK_3` FOREIGN KEY (`transportista_externo_id`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta_estado`
--
ALTER TABLE `venta_estado`
  ADD CONSTRAINT `venta_estado_FK_1` FOREIGN KEY (`venta_id`) REFERENCES `venta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_estado_FK_2` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_estado_FK_3` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
