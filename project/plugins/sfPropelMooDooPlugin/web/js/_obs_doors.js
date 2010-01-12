var nodeAct = false;
var ventanas;

/*
 * Configuracion inicial del proyecto.
 */
window.addEvent ('domready', function () {

	// Codigo HTML
	var htmlIni = $$('body')[0];

	// Escaneamos helpers de AJAX
	render_text_to_Ajax_link (htmlIni);

	var nodosVentanas = $$('.vtnPopUp');
	ventanas = new DxD (nodosVentanas);

});


/*
 * render_text_to_Ajax_link (html, options)
 * Funcion que agrega comportamientos dentro del html pasado como parámetro para convertir los enlaces a comportamiento de AJAX.
 */
function render_text_to_Ajax_link (html) {
	// Links de AJAX
	// Generamos referencia links incluyendo aquellos elementos/nodos que tengan definida la clase (.moo_remote_win)
	var $nodeAjaxLinks = html.getElements ('.ajax_btn_to');

	$nodeAjaxLinks.each (function ($nodeAjaxLink, $iL) {
		$nodeAjaxLink.addEvents({
			'click': function() {
				var newWin = new mooWin.vtnEdit ($nodeAjaxLink);
			}
		});
	});

    // Links normales
    var $nodeLinks = html.getElements ('.btn_admin_td_actions');
    $nodeLinks.each (function ($nodeLink, $iL) {
		$nodeLink.addEvents({
			'click': function() {
				location.href = this.getProperty('enlace')
			}
		});
	});
};