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