var menuIsActive = false;

window.addEvent ('domready', function () {
  // ToolTips
  // var myTips = new Tips('a');

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
            $action.node_insert = 'content-insert-node';
            if ($action.execute !== undefined) eval ($action.execute+'($action, e, false)');
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
    };
  }
});


var $jsonDataMenuLinks = new Array ();

$jsonDataMenuLinks = [
  {type: 'ajax_link', link: '/sfGuardUser/new', update: '_new', execute: 'renderAjaxNewWin'},
  {type: 'ajax_link', link: '/sfGuardUser', link_content: '/sfGuardUser/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  {},
  {type: 'ajax_link', link: '/sfGuardGroup/new', update: '_new', execute: 'renderAjaxNewWin'},
  {type: 'ajax_link', link: '/sfGuardGroup', link_content: '/sfGuardGroup/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  {},
  {type: 'ajax_link', link: '/sfGuardPermission/new', update: '_new', execute: 'renderAjaxNewWin'},
  {type: 'ajax_link', link: '/sfGuardPermission', link_content: '/sfGuardPermission/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},

  {type: 'ajax_link', link: '/producto/new', update: '_new', execute: 'renderAjaxNewWin'},
  {type: 'ajax_link', link: '/producto', link_content: '/producto/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  {},
  {type: 'ajax_link', link: '/producto_categoria', link_content: '/producto_categoria/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  {type: 'ajax_link', link: '/producto_udm', link_content: '/producto_udm/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},

  {type: 'ajax_link', link: '/proveedor/new', update: '_new', execute: 'renderAjaxNewWin'},
  {type: 'ajax_link', link: '/proveedor', link_content: '/proveedor/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  {},
  {type: 'ajax_link', link: '/proveedor_rubro', link_content: '/proveedor_rubro/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  
  {type: 'ajax_link', link: '/evento', link_content: '/nota_pedido/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  {type: 'ajax_link', link: '/compra', link_content: '/nota_pedido/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  {type: 'ajax_link', link: '/venta', link_content: '/nota_pedido/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  {},
  {type: 'ajax_link', link: '/nota_pedido', link_content: '/nota_pedido/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'},
  {type: 'ajax_link', link: '/recepcion_pedido', link_content: '/recepcion_pedido/index?win_container=true', update: '_new', execute: 'renderAjaxListWin'}
]