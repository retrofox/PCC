window.addEvent('domready', function (ev) {
/*
 * Moo Window Manager
 */
  var windowManager = new mooWinManager($('content-insert-node'));


/************
 * MainMenu *
 ************/

  // Menu Principal
  var menuLevel0 = $$('.menuLevel0Header');
  var menuLevel1 = $$('.menuLevel1Content');
  var menuLevel2 = $$('.menuLevel1 ul li');

  var myArrayFx = new Array ();

  // Definimos comportamiento en cada opcion del menu (menuLevel0)
  menuLevel0.each (function ($opcionMenu, $iO){

    $opcionMenu.addEvents ({
      'mouseenter': function (e) {
        menuLevel1[$iO].puedeQuitar = false;

        this.addClass ('menu01-Hover');
        if (menuIsActive) meteMenu($iO);
      },
      'mouseleave': function (e) {
        menuLevel1[$iO].puedeQuitar = true;
        $opcionMenu.removeClass ('menu01-Hover');

        if (menuIsActive) (function(){
          sacaMenu($iO)
        }).delay (200);
      },
      'mousedown': function (e) {
        menuIsActive = true;
        meteMenu ($iO);
      }
    });
  });

  menuLevel1.each (function ($opcionSubMenu, $iO){
    // Configuracon de las ventanas
    menuLevel1[$iO].isActive = false;
    menuLevel1[$iO].puedeMeter = true;
    menuLevel1[$iO].puedeQuitar = false;

    $opcionSubMenu.addEvents ({
      'mouseenter': function () {
        menuLevel1[$iO].puedeQuitar = false;
      },
      'mouseleave': function (e) {
        menuLevel1[$iO].puedeQuitar = true;
        (function(){
          sacaMenu($iO)
          }).delay (200);
      }
    });
  });

  menuLevel2.each (function ($opcionLink, $iL) {
    if ($opcionLink.get('enlace')) $opcionLink.addClass('opcionLink');

    $opcionLink.addEvents ({
      'mouseenter': function () {
        this.addClass('opcionLink-hover');
      },
      'mouseleave': function (e) {
        this.removeClass('opcionLink-hover');
      },
      'click': function (e) {
        //if (this.get('enlace')) window.location = this.get('enlace');
        if ($jsonDataMenuLinks[$iL].type == "ajax_link") {
            var $action = $jsonDataMenuLinks[$iL];

            $action.injectTo = 'content-insert-node';
            windowManager.add ($action);
        }
      }
    });
  });


  var sacaMenu = function ($iO) {
    if (menuLevel1[$iO].puedeQuitar && menuLevel1[$iO].isActive) {
      menuLevel1[$iO].isActive = false;
      menuLevel1[$iO].setStyle('display', 'none');
      menuLevel0[$iO].removeClass('menu01-Active');
    }
  }

  var meteMenu = function ($iO) {
    if (menuLevel1[$iO].puedeMeter && !menuLevel1[$iO].isActive) {
      menuLevel1[$iO].isActive = true;

      menuLevel1[$iO].setStyle('display', 'block');
      menuLevel0[$iO].addClass ('menu01-Active');
    }
  }
})


/*
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
  */