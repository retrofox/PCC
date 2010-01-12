var $wins = new Array ();

var renderAjaxWin = function ($objAct) {
  if (!$wins.contains ($objAct.link)) {
    new mooWin ($objAct);
    $wins.push($objAct.link);
  }
}

var renderAjaxEditWin = function ($objAct) {
  if (!$wins.contains ($objAct.link)) {
    $editWin = new mooWin.sfPropelEdit ($objAct);
    $wins.push($objAct.link);
  }
}

var renderAjaxNewWin = function ($objAct) {
  if (!$wins.contains ($objAct.link)) {
    $newWin = new mooWin.sfPropelNew ($objAct);
    $wins.push ($objAct.link);
  }
}

var renderAjaxListWin = function ($objAct) {
  if (!$wins.contains ($objAct.link)) {
    new mooWin.sfPropelList ($objAct);
    $wins.push ($objAct.link);
  }
}

var renderAjax = function ($objAct) {
  renderAjax.obj_params = $objAct;
  renderAjax.ajaxConex = new Request.HTML({
    url: $objAct.link,
    method: 'GET',
    onFailure: function($xhr){
      $('content').set ('html', $xhr.responseText);
    },
    onSuccess: function(tree, elems, html, js){
      $($objAct.node_insert).set ('html', html);
      //renderAjax.fireEvent('ajaxIsReady', tree, elems, html, js);
    }
  }).send();
}