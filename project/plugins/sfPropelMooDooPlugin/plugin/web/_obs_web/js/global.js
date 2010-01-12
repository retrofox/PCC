/*
 * En esta funcion global se agregan comportamietos tipo boton.
 */
var render_behavior_buttons = function ($textHtmlNode, $selectorString) {

	/***********************************************
	 * comportameto general para TODOS los botones *
	 ***********************************************/
	if ($($textHtmlNode) != null) {
		var $btns = $($textHtmlNode).getElements($selectorString);
		$btns.each(function($btn, $iB){

			var bgPos = $btn.getStyle('background-position').split(' ');
			var colorIni = $btn.getStyle('color');

			$btn.addEvents({
				'mouseenter': function(){
					this.setStyle('background-position', bgPos[0] + ' ' + (bgPos[1].toInt() - 30).toString() + 'px');
				},
				'mouseleave': function(){
					this.setStyle('background-position', bgPos[0] + ' ' + bgPos[1]);
				},
				'mousedown': function(){

					this.setStyles({
						'background-position': bgPos[0] + ' ' + (bgPos[1].toInt() - 60).toString() + 'px',
						'color': '#FFF'
					});
				},
				'mouseup': function(){
					this.setStyles({
						'background-position': bgPos[0] + ' ' + bgPos[1],
						'color': colorIni
					})
				},
				'click': function(e){
					//e.stop();
					if (this.get('enlace') != null) {
                        $enlace = this.get('enlace');
						if ($enlace == 'vtnClose') {
                            console.log ('nada');
						}
                        else if ($enlace == 'ajax_link') {
                            var newWin2 = new mooWin.vtnEdit (this);
                        }
						else  {
							location.href = this.getProperty('enlace');
                        };
					};
					
					if (this.get('action2Buttom') != null) {
                        $action2Buttom = this.get('action2Buttom');
						if ($action2Buttom == 'window.reload') 
							location.href = window.location;
						if ($action2Buttom == 'node.destroy') 
							$(this.get('params2Buttom')).destroy();
					}
				}
			});
		});
	}
}