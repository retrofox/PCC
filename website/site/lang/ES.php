<?php

	// Language File

	// global variable - do not edit
    global $l;
	// Editing may begin here

	# SITE LANGUAGE VARIABLES
	$l['home'] = 'Inicio';
	// default value is used only if "home_SEF" is not set in the database
	// allowed characters are [a-z] [A-Z] [0-9] [-] [_]
	$l['home_sef'] = 'Inicio';
	$l['archive'] = 'Archivo';
	$l['contact'] = 'Contacto';
	$l['sitemap'] = 'Mapa del Sitio';

	# categories
	$l['month_names'] = 'Enero, Febrero, Marzo, Abril, Mayo, Junio, Julio, Agosto, Septiembre, Octubre, Noviembre, Diciembre';
	$l['none_yet'] = 'Sin contenido todavía...';

	# search
	$l['search_keywords'] = 'Palabras de búsqueda';
	$l['search_button'] = 'Buscar';
	$l['search_results'] = 'Resultados de la búsqueda';
	$l['charerror'] = 'Se necesitan por lo menos 4 caracteres para realizar una búsqueda.';
	$l['noresults'] = 'No hay resultado para su búsqueda.';
	$l['resultsfound'] = 'resultados encontrados para la consulta';

	#comments
	$l['addcomment'] = 'Escribe un comentario';
	$l['comment'] = 'Comentario';
	$l['comment_info'] = 'Comentario creado en';
	$l['page'] = 'Página';
	// preposition word used in comments infoline
	$l['on'] = 'en';

	#paginator
	$l['first_page'] = 'Primera';
	$l['last_page'] = 'Última';
	$l['previous_page'] = 'Anterior';
	$l['next_page'] = 'Próximo';
	$l['name'] = 'Nombre';

	#comments
	$l['comment_sent'] = 'Su comentario fue enviado.';
	$l['comment_sent_approve'] = 'Su comentario está en espera de moderación.';
	$l['comment_error'] = 'Su comentario no fue enviado.';
	$l['no_comment'] = 'Este artículo no tiene comentarios aún.';
	$l['no_comments'] = 'Sin comentarios aún.';
	$l['ce_reasons'] = '<strong>Razones posibles:</strong><br />
		<ul>
			<li>Falta completar un campo requerido.</li>
			<li>El comentario es muy corto.</li>
			<li>No ha ingresado el codigo captcha correcto.</li>
			<li>O ha intentado enviar mensajes indenticos muy rápido en este artículo.</li>
		</ul>';
	$l['url'] = 'URL Website';
	$l['enable_comments'] = 'Habilitar comentarios (Configuración por defecto para nuevos artículos)';
	$l['freeze_comments'] = 'Congelar todos los comentarios (Todo el sitio)';
	$l['frozen_comments'] = 'Ya no se permiten comentarios.';

	#contact
	$l['required'] = '* = Campos requeridos';
	$l['email'] = 'Email';
	$l['message'] = 'Mensaje';
	$l['math_captcha'] = 'Por favor ingrese la suma correcta de esos dos numeros';
	$l['contact_sent'] = 'Gracias, su mensaje ha sido enviado.';
	$l['contact_not_sent'] = 'Su mensaje no fue enviado';
	$l['message_error'] = '<strong>Razones posibles:</strong> Ha dejado el campo nombre o mensaje vacio, o la dirección de email no existe.';

	#generic links
	$l['backhome'] = 'Volver al inicio';
	$l['read_more'] = 'Continuar leyendo';

	#contents error
	$l['article_not_exist'] = 'El artículo solicitado no existe.';
	$l['category_not_exist'] = 'La categoría solicitada no existe.';
	$l['not_found'] = 'No se encontré el contenido.';
	$l['no_content_for_filter'] = 'No hay contenido que corresponda al filtro aplicado.';
	$l['no_category_set'] = 'Los ítems requieren tener la categoría establecida.';

	#rss links
	$l['rss_articles'] = 'RSS Articulos';
	$l['rss_pages'] = 'RSS Páginas';
	$l['rss_comments'] = 'RSS Comentarios';
	$l['rss_comments_article'] = 'RSS Comentarios de este artículo';
	$l['no_rss'] = 'Sin cananles RSS';

	# ADMINISTRATION LANGUAGE VARIABLES
	$l['uncategorised'] = 'Sin categoría';
	$l['new_content'] = 'Crear nuevo contenido';
	$l['home_if_used'] = 'Inicio por defectp (si es usado)';

	#breadcrumbs in admin
	$l['snews_articles'] = 'Artículos de PCC';
	$l['snews_pages'] = 'Páginas de PCC';
	$l['snews_categories'] = 'Categorías de PCC';
	$l['snews_settings'] = 'Configuraciones de PCC';
	$l['snews_files'] = 'Archivos de PCC';

	#administration
	$l['administration'] = 'Administración';
	$l['articles'] = 'Artículos';
	$l['extra_contents'] = 'Contenidos Extras';
	$l['pages'] = 'Páginas';
	$l['all_pages'] = 'Todas las páginas';

	#basic buttons
	$l['view'] = 'Ver';
	$l['add_new'] = 'Agregar';
	$l['admin_category'] = 'Agregar Categoría';
	$l['article_new'] = 'Artículo nuevo';
	$l['extra_new'] = 'Contenido extra nuevo';
	$l['page_new'] = 'Página nueva';
	$l['edit'] = 'Editar';
	$l['delete'] = 'Borrar';
	$l['save'] = 'Guardar';
	$l['submit'] = 'Aceptar';

	#settings
	$l['settings'] = 'Configuraciones';
	$l['site_settings'] = 'Sitio';

	#login
	$l['login_status'] = 'Estado del Login';
	$l['login'] = 'Login';
	$l['username'] = 'Usuario';
	$l['password'] = 'Contraseña';
	$l['login_limit'] = 'Limitaciones de Usuario/contraseña: 4-13 caracteres alfanuméricos solamente';
	$l['logged_in'] = 'Usted esta logueado';
	$l['log_out'] = 'Saliendo';
	$l['logout'] = 'Salir';

	#categories
	$l['categories'] = 'Categorías';
	$l['category'] = 'Categoría';
	$l['subcategory'] = 'Subcategoría de';
	$l['not_sub'] = 'Sin subcategoría';
	$l['show_in_subcats'] = 'Mostrar en Subcategorías?';
	$l['add_subcategory'] = 'Agregar subcategoría';
	$l['publish_subcategory'] = 'Publicar subcategoría';
	$l['appear_category'] = 'Aparece solo en Categoría';
	$l['appear_page'] = 'Aparece solo en página';
	$l['add_category'] = 'Nueva categoría';
	$l['category_order'] = 'Orden de categoría';
	$l['order_category'] = 'Reordenar';
	$l['description'] = 'Descripción';
	$l['publish_category'] = 'Publicar categoría';
	$l['status'] = 'Estado:';
	$l['published'] = 'Publicar';
	$l['unpublished'] = '<span style="color: #FF0000">Sin publicar</span>';
	$l['create_cat'] = '<em>Debe crear una categira antes de agregar artículos.</em>';
	$l['no_categories'] = 'Sin categorías';

	#articles
	$l['article'] = 'Artículo';
	$l['article_date'] = 'Fecha del artículo (ingrese una fecha futura para publicaciones posteriores)';
	$l['preview'] = 'Vista preliminar';
	$l['no_articles'] = 'Sin artículos';
	$l['show_on_home'] = 'Mostrar al inicio';
	$l['filter'] = 'Filtrar por:';

	#customize article
	$l['customize'] = 'Personalizaciones';
	$l['display_title'] = 'Mostrar título';
	$l['display_info'] = 'Mostrar línea de información (leer más / comentarios / fecha)';
	$l['server_time'] = 'Tiempo en servidor';
	$l['future_posting'] = '<span style="color: #FF9900;">Artículos futuros</span>';
	$l['publish_date'] = 'Fecha de publicación';
	$l['day'] = 'Día';
	$l['month'] = 'Mes';
	$l['year'] = 'Año';
	$l['hour'] = 'Hora';
	$l['minute'] = 'Minutos';
	$l['publish_article'] = 'Publicar ahora';
	$l['operation_completed'] = 'Operación completada exitosamente!';
	$l['deleted_success'] = 'Borrado exitosamente';

	#files
	$l['files'] = 'Archivos';
	$l['upload'] = 'Subir';
	$l['uploadto'] = 'Subir archivo a:';
	$l['uploadfrom'] = 'Subir archivo desde:';
	$l['view_files'] = 'Ver archivos en';
	$l['file_error'] = 'El archivo no pudo ser copiado!';
	$l['deleted'] = 'Archivo borrado!';
	#comments
	$l['comments'] = 'Comentarios';
	$l['enable_commenting'] = 'Habilitar comentarios';
	$l['edit_comment'] = 'Editar comentarios';
	$l['freeze_comments'] = 'Congelar comentarios';
	$l['enable'] = 'Habilitar';
	$l['approved'] = 'Aprobado';
	$l['enabled'] = 'Habilitado';
	$l['disabled'] = 'Inhabilitados';
	$l['unapproved'] = 'Comentarios no aprobados';
	$l['wait_approval'] = 'Comentarios en espera de aprobación';

	#article structure
	$l['title'] = 'Titúlo';
	$l['sef_title'] = 'Título amigable para los búscadores (va a ser usado como link del artículo)';
	$l['sef_title_cat'] = 'Título amigable para los búscadores (va a ser usado como link de la categoría)';
	$l['text'] = 'Texto';
	$l['position'] = 'Posición';
	$l['display_page'] = 'Página';
	$l['center'] = 'Centro';
	$l['contents'] = 'Contenidos';
	$l['side'] = 'Contenidos Extra';
	$l['advanced'] = 'Configuraciones avazadas';
	$l['enable_extras'] = 'Habilitar opciones extra múltiples';
	$l['extra_title'] = 'Título del grupo extra (usado en el index.php para mostrar el grupo - ej. extra(\'extra\') )';
	$l['define_extra'] = 'Aparecer en la agrupación extra:';
	$l['page_only'] = 'Ninguna - Solo página';
	$l['groupings'] = 'Agrupación extra';
	$l['group_not_exist'] = 'No existe agrupación extra';
	$l['add_groupings'] = 'Agrupación extra nueva';
	$l['file_extensions'] = 'Extensiones de archivos permitidas para includes (Separados por coma)';
	$l['allowed_files'] = 'Extensiones de archivos permitidas para Uploads (Separados por coma)';
	$l['allowed_images'] = 'Extensiones de archivos de imagen permitidas para Uploads (Separados por coma)';

	#errors
	//Database error message
	$l['dberror'] = '<strong>Hay un error al conectarse a la base de datos.</strong>
		<br /> Verifique las configuraciones de la base de datos.';
	//Database table error message
	$l['db_tables_error'] = '<strong>El "prefijo" de tabla de su base de datos es incorrecto ó no han sido creadas las tablas de su base de datos.</strong>
		<br /> Verifique la configuracion del "prefijo" de su base de datos ó cree las tablas de su base de datoss (vea el <a href="'._SITE.'readme.html">readme.html</a>).';
	$l['error_404'] = 'No se pueden encontrar los contenidos solicitados. Por favor vuelva a intentarlo o utilice las características de búsqueda.';
	$l['error_not_logged_in'] = 'No puede hacer eso si no está logueado.';
	$l['admin_error'] = 'Error';
	$l['back'] = 'Volver';
	$l['err_TitleEmpty'] = 'El título no puede ser vacío.';
	$l['err_TitleExists'] = 'El título ya existe.';
	$l['err_SEFEmpty'] = 'El título SEF no puede ser vacío.';
	$l['err_SEFExists'] = 'El título SEF ya existe.';
	$l['err_SEFIllegal'] = 'El título SEF que ingresó contiene caracteres no permitidos.<br />
		Solo puede usar <strong>a-z 0-9_-</strong><br />Un nueva url SEF ha sido seleccionada desde el título, por favor verifíquela.';
	$l['errNote'] = '<br /><strong>Sea cuidadoso:</strong>
		Dado que algo salió mal, muchas de las opciones de los artículos se perdieron, por favor verifique antes de publicar nuevamente.
		Due to the fact that when something goes wrong most posting options are lost, please check them before posting again.';
	$l['warning'] = '<span style="color: #FF0000; font-weight: 700;">Cuidado!</span>';
	$l['empty_cat'] = 'Borrar contenidos';
	$l['warn_catnotempty'] = 'La categoría que intenta borrar no está vacía!<br />
		Usted puede ingresar a <strong>"'.$l['administration'].'"</strong> para mover los ítems asociados a esta categoría<br />
		ó ingresar a <strong>"'.$l['empty_cat'].'"</strong> para borrarlos <span style="color: #FF0000; font-weight: 700;">TODOS</span>
		subcategorías, artículos, Contenido extra y comentarios asociados a esta categoría.<br /><br />
		<span style="color: #FF0000; font-weight: 700;">La información borrada no se podrá recuperar ..... usted ha sido advertido.</span><br />';
	$l['extra_error_cp'] = 'La opción de categoria no fue establecida para la página';
	$l['extra_error_selection'] = 'No hay una categoría o selección de página';

	#settings form
	$l['create_new'] = 'Quiere crear nuevo contenido?';
	$l['none'] = 'Ninguno';
	$l['change_up'] = 'Cambiar Usuario y Contraseña';
	$l['newer_top'] = 'Los más nuevos arriba';
	$l['newer_bottom'] = 'Los más nuevos abajo';
	$l['err_Login'] = 'Usuario y/o contraseña y/o suma ingresados erroneos.';
	$l['pass_mismatch'] = 'Contraseñas estan fuera del límite de largo o no coincide';
	$l['a_username'] = 'Usuario';
	$l['a_password'] = 'Contraseña';
	$l['a_password2'] = 'Repetir contraseña';
	$l['a_display_page'] = 'Usar esta página como página de Inicio';
	$l['a_display_new_on_home'] = 'Mostrar artículos nuevos en el Inicio';
	$l['a_display_pagination'] = 'Mostrar paginación en los artículos';
	$l['a_website_title'] = 'Tìtulo del sitio web';
	$l['a_home_sef'] = 'SEF del Inicio (usado como link a <em>Inicio</em>)';
	$l['a_website_email'] = 'Email';
	$l['a_description'] = 'Descripción por defecto Etiqueta META (para buscadores)';
	$l['a_keywords'] = 'Palabras clave por defecto para etiqueta META (Palabras clave separadas por coma)';
	$l['a_contact_info'] = 'Información de contacto';
	$l['a_contact_subject'] = 'Asunto del formulario de contacto';
	$l['a_word_filter_file'] = 'Archivo de filtro de malas palabras';
	$l['a_word_filter_change'] = 'Palabra de reemplazo de malas palabras';
	$l['a_word_filter_enable'] = 'Habilitar filtro de malas palabras';
	$l['error_file_name'] = '<br /><span style="color: #FF0000; font-weight: 700;">Include Error: Nombre de Archivo prohibido</span><br />';
	$l['error_file_exists'] = '<br /><span style="color: #FF0000; font-weight: 700;">Include Error: El archivo no existe</span><br />';
	$l['a_num_categories'] = 'Mostrar el numero de artículos al lado de la categoría';
	$l['charset'] = 'Charset por defecto';
	$l['a_time_settings'] = 'Configuración de Hora y reginal';
	$l['a_date_format'] = 'Formato de fecha';
	$l['a_comments_order'] = 'Orden de comentarios';
	$l['a_comment_limit'] = 'Cantidad de comentarios por página';
	$l['a_show_category_name'] = 'Mostrar nombre de categoría en la lista de nuevos artículos';
	$l['comment_repost_timer'] = 'Tiempo entre comentarios - Demora antes de que el usuarios pueda publicar un nuevo comentario en el mismo artículo';
	$l['a_rss_limit'] = 'Límite de RSS de artículos';
	$l['a_approve_comments'] = 'Aprobar comentarios antes de publicarlos';
	$l['a_article_limit'] = 'Limite de artículos por página';
	$l['a_language'] = 'sNews Lenguaje';
	$l['description_meta'] = 'Descripción etiqueta META (para buscadores)';
	$l['keywords_meta'] = 'Palabras clave etiqueta META (Palabras clave separadas por coma)';
	$l['see'] = 'Ver:';
	$l['all'] = 'Todos:';

	#formatting buttons:
  	$l['formatting'] = 'Formato';
  	$l['insert'] = 'Insertar';
  	$l['strong'] = 'Negritas';
  	$l['strong_value'] = 'B';
  	$l['em'] = 'Cursiva';
  	$l['em_value'] = 'I';
  	$l['underline'] = 'Subrayar';
  	$l['underline_value'] = 'U';
  	$l['del'] = 'Tachar';
  	$l['del_value'] = 'S';
  	$l['p'] = 'Parrafo';
  	// no need to translate
  	$l['p_value'] = '&para;';
  	$l['br'] = 'Salto de línea';
  	$l['br_value'] = 'Salto de línea';
  	$l['intro'] = 'Salto introducción';
  	$l['intro_value'] = 'Salto introducción';
 	$l['img'] = 'Inserta imagen';
  	$l['img_value'] = 'Imagen';
  	$l['link'] = 'Insertar vínculo';
  	$l['link_value'] = 'vinculo';
  	$l['include'] = 'Insertar Archivo';
  	$l['include_value'] = 'Archivo';
  	$l['func'] = 'Insertar función de PHP';
  	$l['func_value'] = 'Función';

  	#javascript
	$l['function']='Nombre de la función - sin corchetes.';
	$l['parameters']='Parámetros - Si se necesita más de uno, separar con una coma.
		No use comillas para parámetros vacíos.';

  	#js alert prompts
  	$l['js_func1'] = 'Nombre de la función, no use corchetes.';
  	$l['js_func2'] = "Parámetros - Si se necesita más de uno, separar con una coma. (sin espacios). No use comillas para parámetros vacíos, solo comas vacias.";
  	$l['js_file'] = 'Ingresar el URL del archivo';
  	$l['js_image1'] = 'Ingresar el URL de la imagen';
  	$l['js_image2'] = 'Ingresar el tecto alternativo de la imagen';
  	$l['js_link1'] = 'Ingresar el URL del vínculo';
  	$l['js_link2'] = 'Ingresar el título del vínculo';
  	$l['js_delete1'] = 'Último aviso: La información borrada NO se puede recuperar!';
  	$l['warn_cat_last'] = 'Último aviso: La información borrada NO se puede recuperar!';
	$l['warning_delete'] = '¿Está seguro que quiere borar esto?';
	$l['image_url'] = 'Ingresar la URL de la imagen';
	$l['image_alt'] = 'Ingresar el texto alternativo de la imagen';
	$l['file_url'] = 'Ingresar URL del archivo';
	$l['link_url'] = 'Ingresar URL del vínculo';
	$l['link_title'] = 'Ingresar título del vínculo';
	$l['js_delete2'] = 'Está seguro que quiere borrar esto?';

  	#comment mailing
  	$l['a_mail_on_comments'] = '¿Enviar los comentarios publicados a su email? <br />
  		<i>Nota: Si está usando "Aprobar los comentarios antes de publicar" le será enviado un mensaje de notificación.</i>';
  	$l['subject_a'] = 'Un comentario necesita ser aprobado';
  	$l['subject_b'] = 'Un nuevo comentario ha sido publicado en si sitio';
  	$l['approved_text'] = 'Necesita aprobar un nuevo comentario publicado en su sitio. Esta es una copia: ';
  	$l['not_waiting_approved'] = 'Un nuevo comentario fue publicado en su sitio. Esta es una copia:';
  	$l['from'] = 'De: ';

  	#order contents
  	$l['order_content'] = 'Ordenar contenido';
  	$l['up'] = 'Arriba';
  	$l['down'] = 'Abajo';
  	$l['hide'] = 'Esconder';
  	$l['show'] = 'Mostrar';
	
	$l['divider'] = '>';


?>