var deleteObject = function ($objAct, $ev) {
  $ev.stop();
  if (confirm($objAct.msg)) {
    var $myHTMLRequest = new Request.HTML({
      evalScripts: false,
      method: 'GET',
      url: $objAct.link,
      onFailure: function($xhr){
        $('content').set('html', $xhr.responseText);
      },
      onComplete: function (tree, elems, html, js) {
        eval (js);                                                // <- $deleteResponse
        switch ($deleteResponse.action_delete) {
          case 'window_reload':
            location.reload();
            break
          default:

          case 'delete_row':
            //$btnLi.getParent('tr').dispose();
            break;
        }
      }
    }).post($objAct.formDelete);
  }
}

var renderButtonsAction = function ($btns) {
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
        });
      }
    });
  }, this);
}