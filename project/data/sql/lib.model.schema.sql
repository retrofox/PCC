
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- nota_pedido
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `nota_pedido`;


CREATE TABLE `nota_pedido`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`numero` VARCHAR(8),
	`revision` TINYINT default 0,
	`fecha` DATE,
	`fecha_plazo_entrega` DATE,
	`proveedor_id` INTEGER,
	`plazo_entrega` VARCHAR(100),
	`condicion_pago` INTEGER,
	`condicion_pago_detalle` VARCHAR(200),
	`condicion_lugar_entrega` VARCHAR(100),
	`remitir_doc_a` VARCHAR(100) default 'Carlos Pellegrini Lote \'10 J\'. PIN Este - C.P. 8300 - Neuquen',
	`transporte_id` INTEGER,
	`lugar_entrega` VARCHAR(100) default 'Carlos Pellegrini Lote \'10 J\'. PIN Este - C.P. 8300 - Neuquen',
	`remito_proveedor` TINYINT default 0,
	`certificado_calidad` TINYINT default 0,
	`factura` TINYINT default 0,
	`manuales` TINYINT default 0,
	`ensayos` TINYINT default 0,
	`cert_conformidad` TINYINT default 0,
	`MSDS` TINYINT default 0,
	`otros` TINYINT default 0,
	`otros_descripcion` VARCHAR(50),
	`fecha_entrega` DATE,
	`administra_id` INTEGER,
	`solicita_id` INTEGER,
	`controla_id` INTEGER,
	`autoriza_id` INTEGER,
	`recepcion_total` TINYINT default 0,
	`bloqueada` TINYINT default 0,
	`ultima_revision` TINYINT default 1,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `numero_revision` (`numero`, `revision`),
	INDEX `nota_pedido_FI_1` (`proveedor_id`),
	CONSTRAINT `nota_pedido_FK_1`
		FOREIGN KEY (`proveedor_id`)
		REFERENCES `proveedor` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `nota_pedido_FI_2` (`condicion_pago`),
	CONSTRAINT `nota_pedido_FK_2`
		FOREIGN KEY (`condicion_pago`)
		REFERENCES `formas_de_pago` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `nota_pedido_FI_3` (`transporte_id`),
	CONSTRAINT `nota_pedido_FK_3`
		FOREIGN KEY (`transporte_id`)
		REFERENCES `proveedor` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `nota_pedido_FI_4` (`administra_id`),
	CONSTRAINT `nota_pedido_FK_4`
		FOREIGN KEY (`administra_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `nota_pedido_FI_5` (`solicita_id`),
	CONSTRAINT `nota_pedido_FK_5`
		FOREIGN KEY (`solicita_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `nota_pedido_FI_6` (`controla_id`),
	CONSTRAINT `nota_pedido_FK_6`
		FOREIGN KEY (`controla_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `nota_pedido_FI_7` (`autoriza_id`),
	CONSTRAINT `nota_pedido_FK_7`
		FOREIGN KEY (`autoriza_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- nota_pedido_estado
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `nota_pedido_estado`;


CREATE TABLE `nota_pedido_estado`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nota_pedido_id` INTEGER,
	`estado_id` TINYINT,
	`user_id` INTEGER,
	`observaciones` TEXT,
	`fecha` DATETIME,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `nota_pedido_estado_FI_1` (`nota_pedido_id`),
	CONSTRAINT `nota_pedido_estado_FK_1`
		FOREIGN KEY (`nota_pedido_id`)
		REFERENCES `nota_pedido` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `nota_pedido_estado_FI_2` (`estado_id`),
	CONSTRAINT `nota_pedido_estado_FK_2`
		FOREIGN KEY (`estado_id`)
		REFERENCES `estado` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `nota_pedido_estado_FI_3` (`user_id`),
	CONSTRAINT `nota_pedido_estado_FK_3`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- estado
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `estado`;


CREATE TABLE `estado`
(
	`id` TINYINT  NOT NULL AUTO_INCREMENT,
	`orden` TINYINT  NOT NULL COMMENT 'Indica el orden que puede tener un estado dentro de los diferentes estados',
	`tipo` TINYINT  NOT NULL COMMENT 'Define si es estado para una compra (0), venta (1), nota de pedido (2), etc',
	`nombre` VARCHAR(30) COMMENT 'Nombre del tipo de estado',
	`descripcion` VARCHAR(200),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- archivo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `archivo`;


CREATE TABLE `archivo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(255)  NOT NULL COMMENT 'Nombre del Archivo (255)',
	`tipo` VARCHAR(20) COMMENT 'Tipo del Archivo (20)',
	`descripcion` TEXT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- evento
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `evento`;


CREATE TABLE `evento`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`producto_id` INTEGER,
	`user_id` INTEGER COMMENT 'Estable que usuario ha realizado el evento',
	`fecha` DATETIME,
	`descripcion` TEXT,
	`cantidad` INTEGER,
	`operacion` TINYINT COMMENT 'Operacion de Incremento/Decremento del stock del producto',
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `evento_FI_1` (`producto_id`),
	CONSTRAINT `evento_FK_1`
		FOREIGN KEY (`producto_id`)
		REFERENCES `producto` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `evento_FI_2` (`user_id`),
	CONSTRAINT `evento_FK_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- compra
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `compra`;


CREATE TABLE `compra`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`producto_id` INTEGER,
	`cantidad` INTEGER,
	`proveedor_id` INTEGER,
	`nota_pedido_id` INTEGER,
	`precio` FLOAT,
	`moneda` VARCHAR(10),
	`fecha` DATETIME,
	`fecha_entrega` DATETIME,
	`comentario` TEXT,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `compra_FI_1` (`producto_id`),
	CONSTRAINT `compra_FK_1`
		FOREIGN KEY (`producto_id`)
		REFERENCES `producto` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `compra_FI_2` (`proveedor_id`),
	CONSTRAINT `compra_FK_2`
		FOREIGN KEY (`proveedor_id`)
		REFERENCES `proveedor` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `compra_FI_3` (`nota_pedido_id`),
	CONSTRAINT `compra_FK_3`
		FOREIGN KEY (`nota_pedido_id`)
		REFERENCES `nota_pedido` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- compra_estado
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `compra_estado`;


CREATE TABLE `compra_estado`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`compra_id` INTEGER,
	`user_id` INTEGER COMMENT 'Estable que usuario ha realizado la venta.',
	`estado_id` TINYINT,
	`cantidad` INTEGER default 0,
	`fecha` DATETIME,
	`observaciones` TEXT,
	`nota_recepcion_id` INTEGER,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `compra_estado_FI_1` (`compra_id`),
	CONSTRAINT `compra_estado_FK_1`
		FOREIGN KEY (`compra_id`)
		REFERENCES `compra` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `compra_estado_FI_2` (`user_id`),
	CONSTRAINT `compra_estado_FK_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `compra_estado_FI_3` (`estado_id`),
	CONSTRAINT `compra_estado_FK_3`
		FOREIGN KEY (`estado_id`)
		REFERENCES `estado` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `compra_estado_FI_4` (`nota_recepcion_id`),
	CONSTRAINT `compra_estado_FK_4`
		FOREIGN KEY (`nota_recepcion_id`)
		REFERENCES `recepcion_pedido` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- venta
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `venta`;


CREATE TABLE `venta`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`producto_id` INTEGER,
	`cantidad` INTEGER,
	`numero_remito` VARCHAR(20),
	`transportista_interno_id` INTEGER,
	`transportista_externo_id` INTEGER,
	`fecha` DATETIME,
	`comentario` TEXT,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `venta_FI_1` (`producto_id`),
	CONSTRAINT `venta_FK_1`
		FOREIGN KEY (`producto_id`)
		REFERENCES `producto` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `venta_FI_2` (`transportista_interno_id`),
	CONSTRAINT `venta_FK_2`
		FOREIGN KEY (`transportista_interno_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `venta_FI_3` (`transportista_externo_id`),
	CONSTRAINT `venta_FK_3`
		FOREIGN KEY (`transportista_externo_id`)
		REFERENCES `proveedor` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- venta_estado
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `venta_estado`;


CREATE TABLE `venta_estado`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`venta_id` INTEGER,
	`estado_id` TINYINT,
	`user_id` INTEGER,
	`observaciones` TEXT,
	`fecha` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `venta_estado_FI_1` (`venta_id`),
	CONSTRAINT `venta_estado_FK_1`
		FOREIGN KEY (`venta_id`)
		REFERENCES `venta` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `venta_estado_FI_2` (`estado_id`),
	CONSTRAINT `venta_estado_FK_2`
		FOREIGN KEY (`estado_id`)
		REFERENCES `estado` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `venta_estado_FI_3` (`user_id`),
	CONSTRAINT `venta_estado_FK_3`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- geo_pais
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `geo_pais`;


CREATE TABLE `geo_pais`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(50),
	`codigo` VARCHAR(2) COMMENT 'Codigo ISO de Pais (2)',
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- geo_provincia
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `geo_provincia`;


CREATE TABLE `geo_provincia`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`pais_id` INTEGER,
	`nombre` VARCHAR(50),
	PRIMARY KEY (`id`),
	INDEX `geo_provincia_FI_1` (`pais_id`),
	CONSTRAINT `geo_provincia_FK_1`
		FOREIGN KEY (`pais_id`)
		REFERENCES `geo_pais` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- geo_localidad
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `geo_localidad`;


CREATE TABLE `geo_localidad`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`provincia_id` INTEGER,
	`nombre` VARCHAR(50),
	PRIMARY KEY (`id`),
	INDEX `geo_localidad_FI_1` (`provincia_id`),
	CONSTRAINT `geo_localidad_FK_1`
		FOREIGN KEY (`provincia_id`)
		REFERENCES `geo_provincia` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- recepcion_pedido
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `recepcion_pedido`;


CREATE TABLE `recepcion_pedido`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nota_pedido_id` INTEGER,
	`fecha` DATE,
	`recibe_id` INTEGER,
	`controla_id` INTEGER,
	`administra_id` INTEGER,
	`proveedor_factura` VARCHAR(30),
	`proveedor_remito` VARCHAR(30),
	`transportista_id` INTEGER,
	`transportista_numero_guia` VARCHAR(30),
	`transportista_bultos` TINYINT,
	`remito_proveedor` TINYINT,
	`certificado_calidad` TINYINT,
	`factura` TINYINT,
	`manuales` TINYINT,
	`ensayos` TINYINT,
	`cert_conformidad` TINYINT,
	`MSDS` TINYINT,
	`otros` TINYINT,
	`otros_descripcion` VARCHAR(50),
	`error_envio` TINYINT,
	`error_envio_desc` VARCHAR(100),
	`rechazado` TINYINT,
	`rechazado_desc` VARCHAR(100),
	`control_items` TINYINT default 0,
	`control_precios` TINYINT default 0,
	`control_calidad` TINYINT default 0,
	`control_cantidad` TINYINT default 0,
	`cerrada` TINYINT default 0,
	PRIMARY KEY (`id`),
	INDEX `recepcion_pedido_FI_1` (`nota_pedido_id`),
	CONSTRAINT `recepcion_pedido_FK_1`
		FOREIGN KEY (`nota_pedido_id`)
		REFERENCES `nota_pedido` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `recepcion_pedido_FI_2` (`recibe_id`),
	CONSTRAINT `recepcion_pedido_FK_2`
		FOREIGN KEY (`recibe_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `recepcion_pedido_FI_3` (`controla_id`),
	CONSTRAINT `recepcion_pedido_FK_3`
		FOREIGN KEY (`controla_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `recepcion_pedido_FI_4` (`administra_id`),
	CONSTRAINT `recepcion_pedido_FK_4`
		FOREIGN KEY (`administra_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `recepcion_pedido_FI_5` (`transportista_id`),
	CONSTRAINT `recepcion_pedido_FK_5`
		FOREIGN KEY (`transportista_id`)
		REFERENCES `proveedor` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- producto_categoria
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `producto_categoria`;


CREATE TABLE `producto_categoria`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(50)  NOT NULL COMMENT 'Nombre de la Categoria (50)',
	`descripcion` TEXT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- producto_udm
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `producto_udm`;


CREATE TABLE `producto_udm`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(50)  NOT NULL COMMENT 'Nombre de la Unidad de Medida (50)',
	`unidad` VARCHAR(15) COMMENT 'Unidad propiamente dicha, Por ejemplo \"m\"',
	`unidad_mas_multi` VARCHAR(15) COMMENT 'Es la unidad mas el multiplo o submultiplo, por ejemplo, Kg.',
	`descripcion` TEXT,
	`dimension` VARCHAR(15) COMMENT 'Dimension de la unidad. Puede ser lineal, cuadrática, ćubica, etc.',
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- producto
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `producto`;


CREATE TABLE `producto`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`codigo` VARCHAR(20)  NOT NULL COMMENT 'Codigo del Producto (20)',
	`nombre` VARCHAR(100)  NOT NULL COMMENT 'Nombre del Producto (100)',
	`marca` VARCHAR(80) COMMENT 'Marca del Producto (80)',
	`descripcion` TEXT COMMENT 'Descripcion del Producto',
	`producto_categoria_id` INTEGER COMMENT 'Refrencia la categoria del producto',
	`producto_udm_id` INTEGER COMMENT 'Unidad de Medida',
	`ubicacion_fisica` VARCHAR(20),
	`stock_actual` INTEGER default 0,
	`stock_reservado` INTEGER default 0,
	`stock_preaviso` INTEGER default 0,
	`stock_critico` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `producto_FI_1` (`producto_categoria_id`),
	CONSTRAINT `producto_FK_1`
		FOREIGN KEY (`producto_categoria_id`)
		REFERENCES `producto_categoria` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `producto_FI_2` (`producto_udm_id`),
	CONSTRAINT `producto_FK_2`
		FOREIGN KEY (`producto_udm_id`)
		REFERENCES `producto_udm` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- producto_archivo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `producto_archivo`;


CREATE TABLE `producto_archivo`
(
	`producto_id` INTEGER  NOT NULL,
	`archivo_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`producto_id`,`archivo_id`),
	CONSTRAINT `producto_archivo_FK_1`
		FOREIGN KEY (`producto_id`)
		REFERENCES `producto` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `producto_archivo_FI_2` (`archivo_id`),
	CONSTRAINT `producto_archivo_FK_2`
		FOREIGN KEY (`archivo_id`)
		REFERENCES `archivo` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- producto_proveedor
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `producto_proveedor`;


CREATE TABLE `producto_proveedor`
(
	`producto_id` INTEGER  NOT NULL,
	`proveedor_id` INTEGER  NOT NULL,
	PRIMARY KEY (`producto_id`,`proveedor_id`),
	CONSTRAINT `producto_proveedor_FK_1`
		FOREIGN KEY (`producto_id`)
		REFERENCES `producto` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `producto_proveedor_FI_2` (`proveedor_id`),
	CONSTRAINT `producto_proveedor_FK_2`
		FOREIGN KEY (`proveedor_id`)
		REFERENCES `proveedor` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- user_profile
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user_profile`;


CREATE TABLE `user_profile`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`language` VARCHAR(5) default 'es' COMMENT 'Lenguaje nativo del usuario',
	`nombre` VARCHAR(255),
	`apellido` VARCHAR(255),
	`fdn` DATE,
	`nacionalidad` INTEGER,
	`documento_tipo` TINYINT,
	`documento_numero` VARCHAR(15),
	`cuil` VARCHAR(13),
	`legajo` VARCHAR(5),
	`telefono` VARCHAR(255) COMMENT 'Telefono fijo del usuario',
	`movil` VARCHAR(255),
	`email` VARCHAR(255),
	`domicilio_calle` VARCHAR(50),
	`domicilio_numero` VARCHAR(5),
	`domicilio_manzana` VARCHAR(5),
	`domicilio_barrio` VARCHAR(50),
	`domicilio_piso` VARCHAR(2),
	`domicilio_depto` VARCHAR(2),
	`localidad_id` INTEGER,
	`provincia_id` INTEGER,
	`comentario` TEXT,
	PRIMARY KEY (`id`),
	INDEX `user_profile_FI_1` (`user_id`),
	CONSTRAINT `user_profile_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `user_profile_FI_2` (`nacionalidad`),
	CONSTRAINT `user_profile_FK_2`
		FOREIGN KEY (`nacionalidad`)
		REFERENCES `geo_pais` (`id`),
	INDEX `user_profile_FI_3` (`localidad_id`),
	CONSTRAINT `user_profile_FK_3`
		FOREIGN KEY (`localidad_id`)
		REFERENCES `geo_localidad` (`id`),
	INDEX `user_profile_FI_4` (`provincia_id`),
	CONSTRAINT `user_profile_FK_4`
		FOREIGN KEY (`provincia_id`)
		REFERENCES `geo_provincia` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- proveedor_rubro
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `proveedor_rubro`;


CREATE TABLE `proveedor_rubro`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(255) COMMENT 'Rubro del Proveedor (2)',
	`descripcion` TEXT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- proveedor
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `proveedor`;


CREATE TABLE `proveedor`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(255) COMMENT 'Nombre del Proveedor (255)',
	`cuit` VARCHAR(20) COMMENT 'Cuit del Proveedor (50)',
	`rubro_id` INTEGER,
	`telefono` VARCHAR(100) COMMENT 'Telefono del Proveedor (100)',
	`fax` VARCHAR(100) COMMENT 'Fax del Proveedor (100)',
	`movil` VARCHAR(100) COMMENT 'Celular del Proveedor (100)',
	`email` VARCHAR(255),
	`persona_nombre` VARCHAR(100) COMMENT 'Nombre de la persona de contacto del proveedor (100)',
	`persona_apellido` VARCHAR(100) COMMENT 'Apellido de la persona de contacto del proveedor (100)',
	`direccion_calle` VARCHAR(50) COMMENT 'Direccioon / Calle del Proveedor (50)',
	`direccion_numero` VARCHAR(5) COMMENT 'Direccioon / Numero de Calle del Proveedor (2)',
	`direccion_manzana` VARCHAR(5) COMMENT 'Direccioon / Manzana del Proveedor (5)',
	`direccion_barrio` VARCHAR(50) COMMENT 'Direccioon / Barrio del Proveedor (50)',
	`direccion_piso` VARCHAR(2) COMMENT 'Direccioon / Piso del Proveedor (2)',
	`direccion_depto` VARCHAR(2) COMMENT 'Direccioon / Departamento del Proveedor (2)',
	`localidad_id` INTEGER,
	`provincia_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `proveedor_FI_1` (`rubro_id`),
	CONSTRAINT `proveedor_FK_1`
		FOREIGN KEY (`rubro_id`)
		REFERENCES `proveedor_rubro` (`id`),
	INDEX `proveedor_FI_2` (`localidad_id`),
	CONSTRAINT `proveedor_FK_2`
		FOREIGN KEY (`localidad_id`)
		REFERENCES `geo_localidad` (`id`)
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	INDEX `proveedor_FI_3` (`provincia_id`),
	CONSTRAINT `proveedor_FK_3`
		FOREIGN KEY (`provincia_id`)
		REFERENCES `geo_provincia` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- formas_de_pago
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `formas_de_pago`;


CREATE TABLE `formas_de_pago`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nombre` VARCHAR(255),
	`moneda` VARCHAR(20),
	`descripcion` TEXT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- proveedor_formas_de_pago
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `proveedor_formas_de_pago`;


CREATE TABLE `proveedor_formas_de_pago`
(
	`proveedor_id` INTEGER,
	`fdp_id` INTEGER,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	INDEX `proveedor_formas_de_pago_FI_1` (`proveedor_id`),
	CONSTRAINT `proveedor_formas_de_pago_FK_1`
		FOREIGN KEY (`proveedor_id`)
		REFERENCES `proveedor` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	INDEX `proveedor_formas_de_pago_FI_2` (`fdp_id`),
	CONSTRAINT `proveedor_formas_de_pago_FK_2`
		FOREIGN KEY (`fdp_id`)
		REFERENCES `proveedor_formas_de_pago` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
