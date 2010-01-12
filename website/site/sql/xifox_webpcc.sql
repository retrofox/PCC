-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 25-06-2009 a las 12:30:15
-- Versión del servidor: 5.0.67
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `xifox_webpcc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) default NULL,
  `seftitle` varchar(100) default NULL,
  `text` longtext,
  `date` datetime default NULL,
  `category` int(8) NOT NULL default '0',
  `position` int(6) default NULL,
  `extraid` varchar(8) default NULL,
  `page_extra` varchar(8) default NULL,
  `displaytitle` char(3) NOT NULL default 'YES',
  `displayinfo` char(3) NOT NULL default 'YES',
  `commentable` varchar(5) NOT NULL default '',
  `published` int(3) NOT NULL default '1',
  `description_meta` varchar(255) default NULL,
  `keywords_meta` varchar(255) default NULL,
  `show_on_home` enum('YES','NO') default 'YES',
  `show_in_subcats` enum('YES','NO') default 'NO',
  `artorder` smallint(6) NOT NULL default '0',
  `visible` varchar(6) default 'YES',
  `default_page` varchar(6) default 'NO',
  PRIMARY KEY  (`id`),
  KEY `show_on_home` (`show_on_home`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Volcar la base de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `title`, `seftitle`, `text`, `date`, `category`, `position`, `extraid`, `page_extra`, `displaytitle`, `displayinfo`, `commentable`, `published`, `description_meta`, `keywords_meta`, `show_on_home`, `show_in_subcats`, `artorder`, `visible`, `default_page`) VALUES
(2, 'home', 'home', '<div id="welcomecontacienr">\r\n<h2 class="welcome">Bienvenidos a nuestro sitio web</h2>\r\n<img src="images/protcat1.jpg" alt="Proteccion catodica" />\r\n<h3>ProtecciÃ³n catÃ³dica</h3>\r\n<p>ProtecciÃ³n catÃ³dica es un metodo basado en un principio electroquÃ­mico, que permite preservar contra la corrosiÃ³n galvÃ¡nica, estructuras metÃ¡licas, enterradas Ã³ sumergidas.</p>\r\n<a href="proteccion-catodica" title="Leer mÃ¡s">leer mÃ¡s...</a>\r\n<br class="spacer" />\r\n</div>\r\n<div id="bodybttom">\r\n<div id="bleft">\r\n<div id="newscontainer">\r\n<h2 class="news-events">Ãšltimos Proyectos</h2>\r\n<p><span>17/05/06</span>\r\nLorem ipsum dolor sit amet, orci mauris, neque lacinia nibh ullamcorper\r\n<a href="#" title="more">...mÃ¡s</a>\r\n<br class="spacer" /></p>\r\n<p><span>18/05/06</span>\r\nLorem ipsum dolor sit amet, orci mauris, neque lacinia nibh ullamcorper <a href="#" title="more">...mÃ¡s</a><br class="spacer" /></p>\r\n</div>\r\n</div>\r\n<div id="bright">\r\n<div>\r\n<img src="images/LogoBureauVeritas.jpg" alt="Certificacion" />\r\n<p>Sistema de gestiÃ³n de la calidad certificado IRAM-ISO 9001-2000 RI 9000-845 <a href="la-empresa/sistema-de-gestion-integrado" title="mÃ¡s">... mÃ¡s</a> </p></div>\r\n<div>\r\n<img src="images/bandera.png" alt="Argentino" />\r\n<br />\r\n<br />\r\n<h3>Producto Argentino</h3>\r\n</div>\r\n</div>\r\n<br class="spacer" />\r\n</div>', '2009-06-19 14:33:47', 0, 3, '', '', 'NO', 'NO', 'NO', 1, '', '', 'YES', 'NO', 1, 'YES', 'NO'),
(25, 'Sistema de GestiÃ³n Integrado', 'sistema-de-gestion-integrado', '', '2009-06-19 19:14:39', 0, 3, '', '', 'YES', 'NO', 'NO', 1, '', '', 'YES', 'NO', 3, 'NO', 'NO'),
(24, 'ProtecciÃ³n CatÃ³dica', 'proteccion-catodica', '<p>ProtecciÃ³n catÃ³dica es un metodo basado en un principio electroquÃ­mico, que permite preservar contra la corrosiÃ³n galvÃ¡nica, estructuras metÃ¡licas, enterradas Ã³ sumergidas.</p>', '2009-06-19 18:42:51', 0, 3, '', '', 'YES', 'NO', 'NO', 1, '', '', 'YES', 'NO', 2, 'YES', 'NO'),
(3, 'Quienes Somos', 'quienes-somos', '<p>ProtecciÃ³n CatÃ³dica del Comahue naciÃ³ en Junio del aÃ±o 1987 con la finalidad de ofrecer los servicios de la especialidad en la Patagonia Argentina; zona de mayor explotaciÃ³n y producciÃ³n de gas y petrÃ³leo del paÃ­s.\r\n</p>\r\n<img src="images/gente.png" alt="Gente" class="left" />\r\n<p>Sin interrupciones durante todo este tiempo ha evolucionado tÃ©cnica y estructuralmente acorde a las exigencias del mercado argentino. Durante su evoluciÃ³n ha logrado equiparse con mÃ¡quinas, herramientas, instrumental y equipos de Ãºltima tecnologÃ­a, que la posicionan dentro de las mÃ¡s preparadas para desarrollar los trabajos de la especialidad.\r\n</p>\r\n\r\n<p>Hoy no solo cuenta con trayectoria nacional, sino tambiÃ©n es reconocida y requerida, por distintos Clientes de paÃ­ses de SudamÃ©rica.</p>\r\n', '2009-06-19 14:47:25', 2, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 1, 'YES', 'NO'),
(4, 'Que Hacemos', 'que-hacemos', '<p>Nos especializamos en ProtecciÃ³n CatÃ³dica. ProtecciÃ³n catÃ³dica es un mÃ©todo, basado en un principio electroquÃ­mico, que permite preservar contra la corrosiÃ³n galvÃ¡nica, estructuras metÃ¡licas, enterradas Ã³ sumergidas.</p><img src="images/tanque.png" alt="Tanques" class="right"/>\r\n<p>Por lo tanto es aplicable a tanques, caÃ±erÃ­as y toda estructura metÃ¡lica, en contacto con un electrolito (sÃ³lido o lÃ­quido) agresivo.</p>\r\n<p>Para todas las estructuras que lo requieran, PCC cuenta con capacidad tÃ©cnica y el equipamiento necesario para canalizar las necesidades de los Clientes.</p>\r\n<p>Como una actividad secundaria, basada en la disponibilidad del equipamiento necesario, se realizan pozos de prospecciÃ³n sÃ­smica, pozos de monitoreo de napas profundas, pozos de producciÃ³n de agua y puestas a tierra.</p>\r\n', '2009-06-19 14:48:06', 2, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 2, 'YES', 'NO'),
(5, 'Proyectos', 'proyectos', '<p>Se realizan bajo Recomendaciones PrÃ¡cticas de NACE (National Association of Corrosion Engineers) y/o la experiencia con que cuentan nuestros profesionales.</p>\r\n<p>\r\nTodo proyecto cuenta con las memorias tÃ©cnicas, de cÃ¡lculos y planos de las instalaciones proyectadas</p>\r\n', '2009-06-19 14:50:09', 3, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 1, 'YES', 'NO'),
(6, 'Estudios especÃ­ficos', 'estudios-especificos', '<h3>Estudios de resistividad de suelos</h3>\r\n<p>Se realizan sobre el terreno, con la aplicaciÃ³n del mÃ©todo de Wenner (mÃ©todo de cuatro electrodos) Ã³ en cajas de ensayo, dependiendo de las caracterÃ­sticas del electrolito.</p>\r\n\r\n<p>Foto Nilsson + caja ensayos</p>\r\n<h3>Estudios de PH de suelos</h3>\r\n\r\n<p>Las mediciones de PH se realizan directamente sobre el electrolito, con electrodos de referencia portÃ¡tiles.\r\n</p>\r\n\r\n<p>Foto Phmetro y electrodo</p>\r\n\r\n\r\n \r\n\r\n<h3>Estudios CIPS</h3><img src="images/gente2.png" alt="Estudios CIPS" class="left" /> <p><em>(Relevamientos de Potencial a intervalos cortos Ã³ Paso a Paso)</em></p>\r\n\r\n<p>Consiste en el relevamiento de potenciales de protecciÃ³n catÃ³dica, con un distanciamiento de aproximadamente un metro entre lecturas.</p>\r\n<p>Permite establecer el cumplimiento del criterio de protecciÃ³n catÃ³dica buscado.</p>\r\n\r\n\r\n<h3>Estudios DCVG</h3> <p><em>(Gradientes de Potencial en Corriente Continua)\r\n</em>\r\n</p>\r\n\r\n<p>Consiste en la mediciÃ³n desde la superficie del terreno, de los gradientes de potencial, en un ducto enterrado.\r\n</p>\r\n\r\n<p>Las deformaciones de las lÃ­neas de campo elÃ©ctrico, muestran distinta magnitud de gradiente de potencial que indica la existencia de una falla de cobertura.</p>\r\n\r\n\r\n<p>Permite ubicar fÃ­sicamente, la existencia de una falla del revestimiento aislante de una tuberÃ­a enterrada.\r\n</p>\r\n<img src="images/gente3.png" alt="Estudios DCVG" class="right" />\r\n<h3>Estudios PCM</h3><p><em> (Mapeo de corriente en ductos)</em>\r\n</p>\r\n\r\n\r\n<p>Consiste en la mediciÃ³n desde la superficie, de la magnitud y direcciÃ³n de una corriente inyectada a ex profeso.</p>\r\n\r\n\r\n<p>Permite en forma rÃ¡pida ubicar contactos con estructuras ajenas a los sistemas o secciones de tuberÃ­a enterrada, que demandan consumos diferenciales de corriente, induciendo los sectores del ducto, con posibles fallas de cobertura.</p>\r\n\r\n\r\n<h3>Estudios ACVG</h3>\r\n<img src="images/gente4.png" alt="Estudios ACVG" class="left" />\r\n<p><em>(Gradiente de Voltaje de Corriente Alterna)\r\n</em>\r\n</p>\r\n\r\n<p>Consiste en la mediciÃ³n desde la superficie del terreno, de los gradientes de potencial, en un ducto enterrado.</p>\r\n\r\n\r\n<p>Las deformaciones de las lÃ­neas de campo electromagnÃ©tico, muestran distinta magnitud de gradiente de potencial que indica la existencia de una falla de cobertura.\r\n</p>\r\n\r\n<p>Permite ubicar fÃ­sicamente, la existencia de una falla del revestimiento aislante de una tuberÃ­a enterrada.</p>\r\n\r\n\r\n\r\n\r\n<h3>Estudios de interferencias elÃ©ctricas</h3>\r\n\r\n<p>Las instalaciones metÃ¡licas enterradas Ã³ sumergidas, con Ã³ sin sistema de protecciÃ³n catÃ³dica, estÃ¡n expuestas a quedar interferidas por sistemas de protecciÃ³n catÃ³dica ajenos Ã³ vecinos Ã³ inducciÃ³n de corriente alterna, generada fundamentalmente por el paralelismo con lÃ­neas de alta tensiÃ³n.\r\n</p>\r\n\r\n<p>Todos estos fenÃ³menos pueden ser riesgosos tanto para las estructuras en sÃ­ mismas, como para el ser humano.</p>\r\n\r\n<p>\r\nPCC cuenta con el instrumental, personal capacitado y una vasta experiencia para el estudio y mitigaciÃ³n de estos fenÃ³menos elÃ©ctricos. </p>\r\n\r\n', '2009-06-19 14:51:00', 3, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 2, 'YES', 'NO'),
(8, 'NeuquÃ©n', 'neuquen', '<p>Carlos Pellegrini Manzana "G" Lote 10J </p>\r\n\r\n<p>Parque Industrial NeuquÃ©n Este (PIN Este)</p>\r\n\r\n<p>TelÃ©fonos: LÃ­neas rotativas: (0299) 441 3981 | Fax: (0299) 441 3984</p>\r\n<p>\r\ne-mail: pcc@pccomahue.com.ar | www.pccomahue.com.ar</p>\r\n', '2009-06-19 14:57:50', 5, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 1, 'YES', 'NO'),
(9, 'Varias', 'varias', '', '2009-06-19 16:07:08', 6, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 1, 'YES', 'NO'),
(10, 'ConfÃ­an en nosotros', 'confian-en-nosotros', '', '2009-06-19 16:07:50', 4, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 1, 'YES', 'NO'),
(16, 'Sistemas de Puesta a Tierra', 'sistemas-de-puesta-a-tierra', '<h3>DiseÃ±o y montaje</h3> \r\n<p>PCC proyecta y construye sistemas de puesta a tierra, acordes a las exigencias de seguridad de cada Cliente en particular y a las normas elÃ©ctricas que rigen la materia. </p>\r\n<h3>AnÃ¡lisis de compatibilidad con sistemas de puesta a tierra</h3>\r\n<p>Los sistemas de puesta a tierra de las instalaciones, por diversos factores, no siempre son compatibles con los sistemas de protecciÃ³n catÃ³dica. Una de las razones puede ser la mezcla de distintos metales.</p>\r\n<p>ProtecciÃ³n CatÃ³dica del Comahue, cuenta con el instrumental, personal capacitado y experiencia para determinar la compatibilidad de interacciÃ³n entre estos sistemas.</p>\r\n', '2009-06-19 17:53:06', 3, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 3, 'YES', 'NO'),
(23, 'MisiÃ³n y VisiÃ³n', 'mision-y-vision', '<h3>MisiÃ³n</h3>\r\n<p>Teniendo en cuenta las necesidades de nuestros Clientes, tenemos como prioridad satisfacer estas necesidades a travÃ©s de soluciones adecuadas a sus proyectos, proveer un servicio adecuado a sus instalaciones, con un equipo de trabajo comprometido, orientado a resultados tangibles, con Ã©nfasis en la satisfacciÃ³n al cliente.</p>\r\n\r\n<h3>VisiÃ³n</h3>\r\n<p>Convertirnos en aliados estratÃ©gicos de nuestros Clientes para la obtenciÃ³n de resultados, con productos de calidad, desarrollando proyectos, servicios y asesorÃ­as, contando con una amplia experiencia y un grupo humano altamente profesional, logrando de esta manera permanencia en el mercado, permanente ampliaciÃ³n del mismo y destacarnos como la mejor prestadora en la especialidad.</p>\r\n', '2009-06-19 18:34:37', 2, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 3, 'YES', 'NO'),
(19, 'Mantenimiento en general', 'mantenimiento-en-general', '<p>En la actualidad PCC, es la encargada del mantenimiento de los sistemas de protecciÃ³n catÃ³dica, en diversos Yacimientos productores de gas y petrÃ³leo, de la cuenca Neuquina.</p>\r\n', '2009-06-19 17:55:32', 3, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 5, 'YES', 'NO'),
(20, 'CapacitaciÃ³n de Personal', 'capacitacion-de-personal', '<img src="images/gente5.png" alt="Capacitaciones" class="left"/>\r\n<p>Nuestro plantel de profesionales y tÃ©cnicos, concurren periÃ³dicamente a cursos, congresos o seminarios sobre la materia, normalmente encuadrados en la Normativa de NACE y dictados tanto en nuestro PaÃ­s como en el extranjero.</p>\r\n\r\n<p>PCC ofrece capacitaciÃ³n, sin cargo, a los Clientes que asÃ­ lo soliciten.</p>\r\n', '2009-06-19 17:56:14', 3, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 6, 'YES', 'NO'),
(21, 'PerforaciÃ³n y armado de dispersores profundos. ', 'perforacion-y-armado-de-dispersores-profundos-', '<p>Para ello contamos con tres equipos de perforaciÃ³n propios, con todo su herramental y logÃ­stica complementaria.</p>\r\n<img src="images/columna.png" alt="Dispersores Profundos" />', '2009-06-19 17:57:42', 3, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 7, 'YES', 'NO'),
(22, 'Relevamiento de coordenadas geogrÃ¡ficas submÃ©tricas', 'relevamiento-de-coordenadas-geograficas-submetricas', '<p></p>\r\n', '2009-06-19 17:58:16', 3, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 8, 'YES', 'NO'),
(26, 'Sistema de GestiÃ³n Integrado', 'sistema-de-gestion-integrado', '<p><strong>Sistema de gestiÃ³n de la calidad certificado IRAM-ISO 9001-2000 RI 9000-845</strong>\r\n</p>\r\n\r\n[break]\r\n<h3>Calidad</h3>\r\n<p>Desde el aÃ±o 1998, la Firma viene trabajando bajo procedimientos escritos, procurando estandarizar los procesos constructivos de los productos ofrecidos.</p>\r\n<p>PCC se caracteriza por ofrecer a sus Clientes todo el apoyo necesario, para lograr su absoluta conformidad.</p>\r\n<p>Desde Julio de 200 PCC ha certificado su Sistema de GestiÃ³n de Calidad siendo la <strong>primer</strong> Empresa Argentina de la especialidad en conseguirlo.\r\n</p>\r\n<h3>Seguridad</h3>\r\n<p>PCC cuenta con un manual de seguridad aprobado  por la aseguradora de Riesgos del Trabajo y Calificado en Nivell III.</p>\r\n<p>Esta calificaciÃ³n implica el reconocimiento al bajo nivel de accidentalidad y motiva a toda la organizaciÃ³n para su mantenimiento en el tiempo.</p>\r\n<p> Independientemente de lo expuesto, tambiÃ©n se cumple con todas las exigencias de la legislaciÃ³n vigente y/o particulares de cada cliente.</p>\r\n<h3>Medio Ambiente</h3>\r\n<p>Dado el tipo de actividad que se desarrolla, y que la misma estÃ¡ ligada a yacimientos o Ã¡reas de producciÃ³n o transporte de gas y petrÃ³leo, es que se presta especial atenciÃ³n al cuidado del Medio Ambiente.</p>\r\n<p>PCC no tiene como meta certificar normas sobre la materia. La diversidad de Clientes con los que opera obliga a una adaptaciÃ³n dinÃ¡mica a cada uno en particular, por lo tanto, adopta las medidas y procedimientos aplicados por el Cliente.</p>\r\n<ul><li>\r\n<a href="files/Politica%20del%20Sistema%20de%20Gestion%20Integral%20Rev%20003.pdf" title="PolÃ­tica del Sistema de GestiÃ³n Integral">PolÃ­tica del Sistema de GestiÃ³n Integral</a><br /></li>\r\n<li>\r\n<a href="http://localhost/pcc/trunk/website/snews17/files/PROTECCION%20CATODICA%20DEL%20COMAHUE%20(OHSAS%2018001-2007)%20CERTIFICATE#175.pdf" title="Certificados OHSAS 18001-2007">Certificados OHSAS 18001-2007</a><br /></li>\r\n<li>\r\n<a href="http://localhost/pcc/trunk/website/snews17/files/PROTECCION%20CATODICA%20DEL%20COMAHUE%20(OAA%2014001-2004)%20CERTIFICATE#AR-230552.pdf" title="Certificados OAA 14001-2004">Certificados OAA 14001-2004</a><br /></li>\r\n<li>\r\n<a href="http://localhost/pcc/trunk/website/snews17/files/PROTECCION%20CATODICA%20DEL%20COMAHUE%20(OAA%209001-2000)%20CERTIFICATE#AR-230551.pdf" title="Certificados OAA 9001-2000">Certificados OAA 9001-2000</a><br /></li>\r\n</ul>', '2009-06-24 11:23:31', 2, 1, '', '', 'YES', 'NO', 'NO', 1, '', '', 'NO', 'NO', 4, 'YES', 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(8) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `seftitle` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `published` varchar(4) NOT NULL default 'YES',
  `catorder` smallint(6) NOT NULL default '0',
  `subcat` int(8) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `seftitle`, `description`, `published`, `catorder`, `subcat`) VALUES
(1, 'Uncategorized', 'uncategorized', '', 'NO', 6, 0),
(2, 'La empresa', 'la-empresa', '', 'YES', 1, 0),
(3, 'Productos y Servicios', 'productos-y-servicios', '', 'YES', 2, 0),
(4, 'Clientes', 'clientes', '', 'YES', 4, 0),
(5, 'Contacto', 'contacto', '', 'YES', 5, 0),
(6, 'Notas TÃ©cnicas', 'notas-tecnicas', '', 'YES', 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL auto_increment,
  `articleid` int(11) default '0',
  `name` varchar(50) default NULL,
  `url` varchar(100) NOT NULL,
  `comment` text,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `approved` varchar(5) NOT NULL default 'True',
  PRIMARY KEY  (`id`),
  KEY `articleid` (`articleid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `comments`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `extras`
--

CREATE TABLE IF NOT EXISTS `extras` (
  `id` int(8) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL,
  `seftitle` varchar(100) default NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `extras`
--

INSERT INTO `extras` (`id`, `name`, `seftitle`, `description`) VALUES
(1, 'Extra', 'extra', 'The default extra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(8) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Volcar la base de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'website_title', 'ProtecciÃ³n CatÃ³dica del Comahue'),
(2, 'home_sef', 'home'),
(3, 'website_description', 'SOLUCIONES INTEGRALES A LOS PROBLEMAS DE CORROSIÃ“N GALVÃNICA'),
(4, 'website_keywords', 'protecciÃ³n catÃ³dica, corrosiÃ³n galvanica'),
(5, 'website_email', 'pcc@pccomahue.com.ar'),
(6, 'contact_subject', 'Contacto'),
(7, 'language', 'ES'),
(8, 'charset', 'UTF-8'),
(9, 'date_format', 'd.m.Y. H:i'),
(10, 'article_limit', '3'),
(11, 'rss_limit', '5'),
(12, 'display_page', '2'),
(13, 'display_new_on_home', ''),
(14, 'display_pagination', ''),
(15, 'num_categories', 'on'),
(16, 'show_cat_names', ''),
(17, 'approve_comments', 'on'),
(18, 'mail_on_comments', ''),
(19, 'comment_repost_timer', '20'),
(20, 'comments_order', 'ASC'),
(21, 'comment_limit', '30'),
(22, 'enable_comments', 'NO'),
(23, 'freeze_comments', 'NO'),
(24, 'word_filter_enable', ''),
(25, 'word_filter_file', ''),
(26, 'word_filter_change', ''),
(27, 'username', '5476095dd508f6304acab0212672df09'),
(28, 'password', '4615c9efd5cb12358ab91fe7f1a4ef3a'),
(29, 'enable_extras', 'NO'),
(30, 'last_date', '2009-06-25 12:05:07'),
(31, 'file_extensions', 'phps,php,txt,inc,htm,html'),
(32, 'allowed_files', 'php,htm,html,txt,inc,css,js,swf,pdf'),
(33, 'allowed_images', 'gif,jpg,jpeg,png');
