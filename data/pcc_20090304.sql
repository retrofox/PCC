-- phpMyAdmin SQL Dump
-- version 2.11.7-rc1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-03-2009 a las 17:08:17
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
  `user_id` int(11) default NULL,
  `cantidad` int(11) default '0',
  `fecha` datetime default NULL,
  `observaciones` text,
  `nota_recepcion_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `compra_estado_FI_1` (`compra_id`),
  KEY `compra_estado_FI_2` (`user_id`),
  KEY `compra_estado_FI_3` (`nota_recepcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `compra_estado`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `fecha` datetime default NULL,
  `descripcion` text,
  `cantidad` int(11) default NULL,
  `operacion` tinyint(4) default NULL COMMENT 'Operacion de Incremento/Decremento del stock del producto',
  PRIMARY KEY  (`id`),
  KEY `evento_FI_1` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `evento`
--


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
  `user_id` int(11) default NULL,
  `observaciones` text,
  `fecha` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `nota_pedido_estado_FI_1` (`nota_pedido_id`),
  KEY `nota_pedido_estado_FI_2` (`user_id`)
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
  `stock_critico` int(11) default '0',
  `stock_preaviso` int(11) default '0',
  `stock_reservado` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `producto_FI_1` (`producto_categoria_id`),
  KEY `producto_FI_2` (`producto_udm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `codigo`, `nombre`, `marca`, `descripcion`, `producto_categoria_id`, `producto_udm_id`, `ubicacion_fisica`, `stock_actual`, `stock_critico`, `stock_preaviso`, `stock_reservado`) VALUES
(1, 'COQ', 'Coque Calcinado de Petroleo', 'Loresco', 'Bolsa de Coque LORESCO. Cada Pallets cuenta con 45, cada una pesa 22.72 Kg.', 1, 6, 'Patio Exterior', 0, 0, 0, 0),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
(7, 'Unidad', 'u', 'u', 'Cantidad lineal unitaria para cuantificar productos que no tienen una magnitud particular, por ejemplo, bulones, bobinas de cable, etc.', 'Lineal');

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
(1, 'pamestic', 'sha1', '9a03d2c029b43fe2bd555204126a50fc', 'd6868106a07fdc8c29648d03b999d6594b8d64bf', '2009-03-04 16:46:41', NULL, 1, 0),
(2, 'cbandier', 'sha1', '9e1f145caae8efacc9133e7cbe94cc0c', '6ab7b7d89b8ae721045a6677c406fb1f31085905', '2009-03-04 16:46:41', NULL, 1, 0),
(3, 'dbandier', 'sha1', '7f5d4ad35e9015c0b54a53002405e7e9', '7c897dffba25a3b43e7213530eb08a78b5560438', '2009-03-04 16:46:41', NULL, 1, 0),
(4, 'mbandier', 'sha1', '8349dfe18f2810b61cb5b1f65ae745d0', '396929b792ff6c1b5a8380770b0824556b3f2653', '2009-03-04 16:46:41', NULL, 1, 0),
(5, 'Pbarros', 'sha1', '16ddfa26b492058a2320d2b165539b9e', 'd44cfb5f8c4efb73b75ad35810ce908b86c992af', '2009-03-04 16:46:41', NULL, 1, 0),
(6, 'cborella', 'sha1', '427ef24c4a243904ee7339eb90f95843', '8bbe0ce59bbb206bce912778722f65325232e78a', '2009-03-04 16:46:41', NULL, 1, 0),
(7, 'jbrion', 'sha1', '4796a4bc0dc9b13802b9d0c7cd1ff4eb', 'ca9187fa77da9369448b8574477ae6e2f112303f', '2009-03-04 16:46:41', NULL, 1, 0),
(8, 'dcaceres', 'sha1', '683537e8f14b80185107d69e3f1f1415', 'a9e2b59f70aabab63860e5bcd89f1cdd433c8851', '2009-03-04 16:46:41', NULL, 1, 0),
(9, 'rcastill', 'sha1', 'b0752e164d08a49fef10cd11c2c94f8c', '09b0f465a72e14afdaa260d41462dab555b861a0', '2009-03-04 16:46:41', NULL, 1, 0),
(10, 'ecastro', 'sha1', '49fa46978c0e9c5bec2d3cce868fa677', '2b48fdf55b372916442b6ad15050e29933d39fbf', '2009-03-04 16:46:41', NULL, 1, 0),
(11, 'mcataldo', 'sha1', '666468126b3046318bf7a3dd0afee3af', '77993435e9a300be93f393f98e86fd2053c94f28', '2009-03-04 16:46:41', NULL, 1, 0),
(12, 'ocaucama', 'sha1', '9e6cf2a1e7938a9f6e0470ac8d0dd42b', 'c9ac1379feaa2b416222ee0e3ea9da494b8f2d6d', '2009-03-04 16:46:41', NULL, 1, 0),
(13, 'jcedro', 'sha1', 'd3b94c3eee9644e5d58b4a4626ce6c64', '6d06741f6963814266a6d32dd6df1cb169bea86a', '2009-03-04 16:46:41', NULL, 1, 0),
(14, 'gcontrer', 'sha1', '1eb738c4242b95acecec35110442f303', '4258303fe6acaa40347b147c2722cf14e64a15a0', '2009-03-04 16:46:41', NULL, 1, 0),
(15, 'rcontrer', 'sha1', '7011f41675aa3d557711c4c827013473', 'fca6e738dd61f6d90ec81798b5979319c4ce1f87', '2009-03-04 16:46:41', NULL, 1, 0),
(16, 'ecortez', 'sha1', '88ec9d9e2a3253b3758dd7101223049e', '0cca105f01f4afa08bcf25594b059cddecd929e5', '2009-03-04 16:46:41', NULL, 1, 0),
(17, 'edemonte', 'sha1', 'cf3c4f9461a942b8df4704141bcfecc2', '0e135ccc7929640e8f4d257f7de12e696c668597', '2009-03-04 16:46:41', NULL, 1, 0),
(18, 'aescuder', 'sha1', 'd1a25a72ba387cd399f370ca79a43cd7', 'df4ce6f417eec4bffff59ed5924ef1c3c2f220e0', '2009-03-04 16:46:41', NULL, 1, 0),
(19, 'nflores', 'sha1', 'ad4a2b8d8d1915255d540fbb7505d4ed', '19aa74843219a8d44f55f37af198eb7b7d3a9d26', '2009-03-04 16:46:41', NULL, 1, 0),
(20, 'jgalera', 'sha1', '58025189cb0b9fd1f582c056fa937c4c', '9fdb6301c543cac61684c81df40cf33bb174234f', '2009-03-04 16:46:41', NULL, 1, 0),
(21, 'agasen', 'sha1', '4258788c4b2ddb5c613839ceab299985', '5e8eb5c0fac33309d60f8776f6dd3c2d20c8a882', '2009-03-04 16:46:41', NULL, 1, 0),
(22, 'jgonzale', 'sha1', '9becc25477cf6276ff2f741652c547a5', '92d41a50882c7afee9a3b8f13e646a1ec4d35927', '2009-03-04 16:46:41', NULL, 1, 0),
(23, 'egonzale', 'sha1', 'd9957b3649ce6c4fde43f758266580c4', 'd50f4c6133e8d743d3df0189cae3356053c59166', '2009-03-04 16:46:41', NULL, 1, 0),
(24, 'agrillo', 'sha1', 'a542eb3ea63334f23c7e72d8e2bcce91', '91cf8b8b291c09ce9d6aaae2556889abb0e1f1c4', '2009-03-04 16:46:41', NULL, 1, 0),
(25, 'ehermosi', 'sha1', '80f615c68ba20c977a589b5461174255', '6a0a98115665ee1b7670cd43c037732db1d51aa3', '2009-03-04 16:46:41', NULL, 1, 0),
(26, 'mhormaza', 'sha1', 'e6297a03b236269853a658e74d41c6d8', 'e3a287ace0a0081b9deef74230f2969feadf5453', '2009-03-04 16:46:41', NULL, 1, 0),
(27, 'jhuenchu', 'sha1', 'de6c757e6a943fd2ab1af0245c370834', 'e2ba13e865b63061bd342a8d6c31afa0a46aede9', '2009-03-04 16:46:41', NULL, 1, 0),
(28, 'firanzo', 'sha1', 'd61c66a21230c606c944e10997e5c087', '8e0f1809e83aed3e1e6cad86a3acc18e95178e3b', '2009-03-04 16:46:41', NULL, 1, 0),
(29, 'djaramil', 'sha1', 'a77f9ad71475e6434988ac96cbda0800', 'bb0fafadc7547dbb0c97d79de2a6487766a48459', '2009-03-04 16:46:41', NULL, 1, 0),
(30, 'gkutsche', 'sha1', '1838afd3b3fb2f1b639952f94e68beb0', '703367b9d3c754d62e13ce422fecb1f0652652cc', '2009-03-04 16:46:41', NULL, 1, 0),
(31, 'mlagos', 'sha1', 'd196eb3954acfba7e8ae2ecedd8a9a97', '048d49b36678123185c97acc6b0a43fad0b3f159', '2009-03-04 16:46:41', NULL, 1, 0),
(32, 'mlopez', 'sha1', 'fdaa875528762e90be79fbcbf98742e6', '358eb895e42657e6d07864deebefbeb59a85661a', '2009-03-04 16:46:41', NULL, 1, 0),
(33, 'pmamani', 'sha1', '747e2965360f59c9f4b5159dff964fe8', '28206937cf51f58dae66300fac29268b45751d5e', '2009-03-04 16:46:41', NULL, 1, 0),
(34, 'pmarinao', 'sha1', '688c4bad480ba5699cd0dc13daef0718', '3474944898a859e458e5b7fc8df35e1f4bb2ad8b', '2009-03-04 16:46:41', NULL, 1, 0),
(35, 'omartine', 'sha1', '60f7e5fd4977f3e81dbb47f2e1fbe5b7', '67d16307b41d6cfefda6ee8ec56982dd581f52af', '2009-03-04 16:46:41', NULL, 1, 0),
(36, 'amedina', 'sha1', 'c20bf86790efede3dbdfa0c2f1553a6a', '9a575d6aef0e8e9bae9d8695893b2d15352d410b', '2009-03-04 16:46:41', NULL, 1, 0),
(37, 'omenna', 'sha1', '1b1fe1057f67c53152bd31ddfe8f1c57', '9becb17aec911dfb4dab6c1ed1bb623e9c62796f', '2009-03-04 16:46:41', NULL, 1, 0),
(38, 'mmolina', 'sha1', '604f70712d64037e7940c3f414dde5b4', '867d184e5b4ccae0fdae513a1f23d6300c8b922b', '2009-03-04 16:46:41', NULL, 1, 0),
(39, 'rmolina', 'sha1', 'ab9a7438bca5d950ed1a98b9b45d67c9', '0789a8eb6a29da1590578de3d450b812b8a05dbd', '2009-03-04 16:46:41', NULL, 1, 0),
(40, 'mmorales', 'sha1', '7af2d10135863436d998d1c537b0fef7', '3f1fee3c878717bc8c63a1682f6486618a686f6c', '2009-03-04 16:46:41', NULL, 1, 0),
(41, 'mnavarre', 'sha1', '91c3eca4dd924126d05632742cfac676', '6987e8e752f1a3f474297003be9fbdfa03a1e516', '2009-03-04 16:46:41', NULL, 1, 0),
(42, 'dojeda', 'sha1', '6d7a1ae00eac81f68722a44293eee2d6', '5318357d4cf26320a7479c7ff9233fef0e193f03', '2009-03-04 16:46:41', NULL, 1, 0),
(43, 'cortega', 'sha1', '45be8c5762c758a07f3c4f785f8c4f1f', 'd80443c9f03d8d517af2b78c6d9d365ace0e0d58', '2009-03-04 16:46:41', NULL, 1, 0),
(44, 'rpacheco', 'sha1', '24431958227c0afc8c187cb7fa17a7fb', 'e88e8ee20a1199954c23c28d22becc279a97138b', '2009-03-04 16:46:41', NULL, 1, 0),
(45, 'cparedes', 'sha1', '8574e107688ea3ba016e8ffbde671016', '0a5cb432154351195f02cee7253a2fbb94d12f31', '2009-03-04 16:46:41', NULL, 1, 0),
(46, 'gperez', 'sha1', 'e45c5a2a585039c31627232ec84756c0', '96893c867560d32785db7d08ac3981c0d974ca4f', '2009-03-04 16:46:41', NULL, 1, 0),
(47, 'eplaate', 'sha1', '6700d6f0eb0b3a509cf8baeaa3409b3e', '3c96eb7637191e40f48cf926081a50e83c1aa292', '2009-03-04 16:46:41', NULL, 1, 0),
(48, 'dpulicar', 'sha1', '843a4d6db2bb7a6cb8203e62fab1a268', '7b2ef5bea4cac2c9c48be10966c0d78da7df14c3', '2009-03-04 16:46:41', NULL, 1, 0),
(49, 'jrodrigu', 'sha1', '09904666d906c1e738aec7d4f8c66b48', 'df52ee709ccd6dec03d110c43d5433bd5c0e5f15', '2009-03-04 16:46:41', NULL, 1, 0),
(50, 'asandova', 'sha1', '281fda6cecc6fd219c6fa06726a762f1', '9a8b147cafd2e6d6fe5ec9edb8aa7b3678fe92e2', '2009-03-04 16:46:41', NULL, 1, 0),
(51, 'asanrame', 'sha1', '48eac61454bf08023b93f83c7e30f902', 'bfb430698b9e018367a2ac49f2eba8919a6e135f', '2009-03-04 16:46:41', NULL, 1, 0),
(52, 'hsantill', 'sha1', 'b12abf04fa0ea831de45ddf024145368', '312dab19133377521cb19ea2891f9af470a218e1', '2009-03-04 16:46:41', NULL, 1, 0),
(53, 'msantill', 'sha1', 'd35195cbcd2497622b1acb3f63f4dd24', '13c8ac6373cfb9687fa167bd2de0447d2a655555', '2009-03-04 16:46:41', NULL, 1, 0),
(54, 'lschrott', 'sha1', 'b2d9c7bf687a1e2f7ccca8c578e86ae4', 'a2e530ee99c1463aaddee7ec4f64c84f72a365d4', '2009-03-04 16:46:41', NULL, 1, 0),
(55, 'gstuardo', 'sha1', '34be8bf32beec990322100a186f0b085', 'f2d2468abd80bd22e60eca9e83ecb52875c2ecab', '2009-03-04 16:46:41', NULL, 1, 0),
(56, 'atoro', 'sha1', 'd92d2cf03f03cb262c6c2720bb728bbf', '54b66c7dcfc99a34fa6ad36cdc0707bbff7cb794', '2009-03-04 16:46:41', NULL, 1, 0),
(57, 'gtorres', 'sha1', 'c3e8ea78bcafa4b8fc956d1a1933f135', '3ff249be53fe8b0dc7e30dca3166cbc315e0aa91', '2009-03-04 16:46:41', NULL, 1, 0),
(58, 'gtosi', 'sha1', '18aed6094c33fd7f00b746366471b594', 'c898a25a59812bfa1cfa4f239ba414ab9fa22382', '2009-03-04 16:46:41', NULL, 1, 0),
(59, 'pvelarde', 'sha1', '22cf33889e949d5a1dd2128a9508ae19', '552624b5075f08c9e5821e5684ba74fafb89eba9', '2009-03-04 16:46:41', NULL, 1, 0),
(60, 'azampa', 'sha1', '3c86c265f60092dd9b1beb970ccdb7f1', '3114724716b51252b55cb250d97e7574ed6559da', '2009-03-04 16:46:41', NULL, 1, 0),
(61, 'Diego', 'sha1', '0a406085f215f36cd331f09b6422e072', 'b302d475fdbd566f3576202c1eea995c36d2c8c7', '2009-03-04 16:46:41', NULL, 1, 1),
(62, 'German', 'sha1', '31763acbe645da840c49e76836eb7f6c', 'aa397bb7de1542a23dd9dd061913fdfbdf339411', '2009-03-04 16:46:41', NULL, 1, 0),
(63, 'Damian', 'sha1', 'e9ac90e7f5da7ca563c5fb7e3f322462', '5245eca4f4ea3f4fb146368b5daf07750283ff63', '2009-03-04 16:46:41', '2009-03-04 16:47:01', 1, 0);

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
  `user_id` int(11) default NULL,
  `observaciones` text,
  `fecha` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `venta_estado_FI_1` (`venta_id`),
  KEY `venta_estado_FI_2` (`user_id`)
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
  ADD CONSTRAINT `compra_estado_FK_2` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compra_estado_FK_3` FOREIGN KEY (`nota_recepcion_id`) REFERENCES `recepcion_pedido` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_FK_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `nota_pedido_estado_FK_2` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `venta_estado_FK_2` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
