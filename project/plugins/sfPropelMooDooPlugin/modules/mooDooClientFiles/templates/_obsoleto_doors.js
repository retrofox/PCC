


var nodeAct = false;
//var wins = new Array ();
var newWin;

/*
 * Configuracion inicial del proyecto.
 */
window.addEvent ('domready', function () {

  /*var myHTMLRequest = new Request.HTML({
        url:$('prueba_Ajax').get('alink'),
        method: 'GET',
        onSuccess: function (a, b, c, d) {
            $('content').set ('html', c);
            console.debug ('llego todo bien');
        }
    });
    
    $('prueba_Ajax').addEvents ({
        'mouseenter': function () {
            $('prueba_Ajax').addClass ('atroden');
        },
        'mouseleave': function () {
            $('prueba_Ajax').removeClass ('atroden');
        },
        'click': function () {
            console.debug (this.get('alink'));
            myHTMLRequest.send();
            //.get({'user_id': 25});


        }
    })
    */

  // Codigo HTML
  var htmlIni = $$('body')[0];

  // Escaneamos helpers de AJAX
  render_text_to_Ajax_link (htmlIni);

//var nodosVentanas = $$('.vtnPopUp');
//ventanas = new DxD (nodosVentanas);

});


/*
 * render_text_to_Ajax_link (html, options)
 * Funcion que agrega evetos a elementos html que tengan definida una clase css '.ajax_btn_to'
 */
function render_text_to_Ajax_link (html) {
  // Links de AJAX
  var $nodeAjaxLinks = html.getElements ('.ajax_btn_to');

/*
  $nodeAjaxLinks.each (function ($nodeAjaxLink, $iL) {
    $nodeAjaxLink.addEvents({
      'click': function() {
        newWin = new mooWin.vtnEdit ($nodeAjaxLink);
      }
    });
  });
  */

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