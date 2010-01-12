/*
 Script: sfMooWin_class.js
 autor: Damian Suarez
 email: damian.suarez@xifox.net
 Contiene las clases <mooWin>
 Class: mooWin
  Clase para crear ventanas utilizando codigo HTML, CSS y JS
  Note:
  mooWin requiere un doctype XHTML.
  License:
  Licencia MIT-style.
 */

var mooWin = new Class({
  Implements: [Events, Options],
  options: {
    id: false,                                     // Identificador de la ventana
    loadWithAjax: true,
    link: '',
    link_content: '',
    nodeInf: '_parent',
    cssPrefix: 'mooWin',
    container: 'content',
    node_insert: '',
    fullComplete: true,
    dims: {},
    enabledHeaderBottons: [1, 1, 1, 1]
  },

  initialize: function(options){
    // Asignamos el objeto parent y luego lo hacemos null para que la clase pueda definir this.options
    this.objParent = options.obj_parent || window;
    options.obj_parent = null;

    this.setOptions(options);
    
    this.initConf();

    this.id = (this.options.id ? this.options.id : this.options.link);
    this.addEvent ('winDomReady', function () {

      this.redims ();

      // Renderizamos win
      this.render();
      this.makeWin();

      this.show();
      this.fireEvent('renderComplete', this.nodeWin);
    });
  },

  // Configuracion Inicial
  initConf: function(){
    // nodeParentInsert. Nodo donde insertamos la ventana.
    this.nodeParentInsert = ($(this.options.node_insert));

    // Cargamos el contenido de la ventana con AJAX ?
    if (this.options.loadWithAjax) {

      this.createAjaxConex();
      this.ajaxConex.send();

      this.addEvent ('winDomReady', function () {
        // Asignacion de datos en JSON del servidor
        this.dataJsonAssign();

        // Insertamos el nodo de la ventana dentro del nodo padre
        this.nodeWin = this.ajaxConex.response.elements[0];
        this.insertWinNode ();

        // Buscamos las referencias de los nodos asignados
        this.getWinNodes();
        this.getWinNodesContent();
        this.nodeBlock.setOpacity (0.3);
      });
    }
  },

  insertWinNode: function () {
    this.nodeWin.inject(this.nodeParentInsert, 'top');
  },

  // Tomamos los nodos principales de una ventana
  getWinNodes: function(){
    this.nodeBlock = this.nodeWin.getChildren()[0];
    this.nodeHandle = this.nodeWin.getChildren()[1];
    this.nodeContent = this.nodeWin.getElement('.win_content');
    this.nodeState = this.nodeWin.getElement('.win_state');
    this.nodesHeaderBottons = this.nodeHandle.getElements('ul li');
  },

  getWinNodesContent: function(){
    this.nodesObjectActions = this.nodeContent.getElements ('.btn_admin_actions');
  },

  /***  Metodos de Render  ***/
  render: function () {
    this.renderHeaderBottons();
    this.renderContent();
  },

  renderContent: function () {
    this.makeAccordions();
    this.renderButtons(this.nodesObjectActions);
    this.renderAction2Buttons();
  },

  renderHeaderBottons: function () {
    this.nodesHeaderBottons.each(function($btnWin, $iB){
      var bgPos = $btnWin.getStyle('background-position').split(' ');
      if (this.options.enabledHeaderBottons[$iB]){
        $btnWin.addEvents({
          'mouseenter': function(){
            $btnWin.setStyle('background-position', bgPos[0] + ' ' + (bgPos[1].toInt() - 20).toString() + 'px');
          },
          'mouseleave': function(){
            $btnWin.setStyle('background-position', bgPos[0] + ' ' + bgPos[1]);
          },
          'mousedown': function(e){
            e.stop();
            $btnWin.setStyles({
              'background-position': bgPos[0] + ' ' + (bgPos[1].toInt() - 40).toString() + 'px',
              'color': '#FFF'
            });
          },
          'mouseup': function(){
            $btnWin.setStyles({
              'background-position': bgPos[0] + ' ' + bgPos[1]
            })
          },
          'click': function(e){
            if ($btnWin.hasClass('btnHW03')) this.hideAndDestroy();
            if ($btnWin.hasClass('btnHW04')) this.refreshContent();
          }.bind(this)
        });
      }
      else {
        $btnWin.setStyles({
          'background-position': bgPos[0] + ' ' + (bgPos[1].toInt() - 60).toString() + 'px',
          'cursor': 'default'
        });
      }
    }.bind(this));
  },

  // Renderiamos TODOS los botones de un objeto win
  renderButtons: function ($btns) {
    renderButtonsAction ($btns);
  },

  // Renderizamos los botones que suelen estar dentro del botton de un objeto win
  renderAction2Buttons: function () {
    this.nodesObjectActions.each(function($btn, $iB){
      $btn.addEvents({
        'click': function(e){
          $editAction = this.serverObjectActions[$iB];                                                        // <- viene por Json
          $editAction.obj_parent = this;
          if ($editAction.type == 'delete_object') $editAction.formDelete = this.nodeWinFormDelete                  // <- es para eliminar ?
          if ($editAction.execute !== undefined) eval ($editAction.execute+'($editAction, e, false)');
        }.bind (this)
      });
    }, this);
  },

  dataJsonAssign: function () {
    this.serverOptions = $jsonData4Win;
    this.dataJsonContentAssign();
  },

  dataJsonContentAssign: function () {
    this.serverObjectActions = $actions;
  },

  show: function(){
    this.nodeWin.setStyle ('display', 'block');
  },

  hide: function(){
    this.nodeWin.setStyle ('display', 'none');
  },

  fadeIn: function(){
    this.nodeWin.setOpacity (1);
  },

  fadeOut: function(){
    this.nodeWin.setOpacity (0.3)
  },

  hideContent: function () {
    this.nodeContent.setStyle ('visibility', 'hidden');
  },

  showContent: function () {
    this.nodeContent.setStyle ('visibility', 'visible');
  },

  hideAndDestroy: function(){
    this.fadeOut();
    this.destroy();
  },

  contentDestroy: function(){
  },

  destroy: function(){
    this.nodeWin.destroy();
    $wins.erase(this.id);           // <- Ojo con esto pepe !!!
    this.fireEvent ('winDestroy', this.id);
  },

  blockOn: function () {
    var $styles = this.nodeWin.getStyles ('width', 'height');
    $styles.display = 'block';
    this.nodeBlock.setStyles ($styles);
  },

  blockOff: function () {
    this.nodeBlock.setStyle ('display', 'none');
  },

  refresh: function () {
    this.removeEvents ('winDomReady');
    this.ajaxConex.send();
  },

  refreshContent: function ($url) {

    this.removeEvents ('winDomReady');            // <- Removemos todos las funcones asociadas al evento winDomReady

    $url = $url || false;
    this.ajaxConex.options.url = $url ? $url : this.options.link_content;

    this.addEvent ('winDomReady', function () {
      this.dataJsonContentAssign();
      this.nodeContent.set ('html', this.ajaxConex.response.html);
      this.getWinNodesContent();
      this.renderContent();
    });

    this.ajaxConex.send();
  },

  /*
 * arguments[0]: message
 * arguments[1]: autoback = true
 *
 */
  setState: function () {
    arguments[1] = arguments[1] || true;

    this.nodeState.back = this.nodeState.get('text');
    this.nodeState.set('text', arguments[0]);
    if (arguments[1]) {
      (function () {
        this.nodeState.set('text', this.nodeState.back);
      }).delay (1500, this);
    }
  },

  createAjaxConex: function () {
    this.ajaxConex = new Request.HTML({
      url: this.options.link,
      method: 'GET',
      onFailure: function($xhr){
	console.debug ('error !!!');
        $('content').set ('html', $xhr.responseText);
	
      },
      onSuccess: function(tree, elems, html, js){
        this.fireEvent ('winDomReady', [tree, elems, html, js])
      }.bind(this)
    });
  },

  // Creamos Ventana
  makeWin: function(){
    //console.count ('<makeWin>');
    this.nodeWin.setStyle ('position', 'absolute');
    
    this.dragWin = new Drag.Move(this.nodeWin, {
      handle: this.nodeHandle,
      container: $(this.options.container),

      onStart: function(e){
        this.fadeOut();
        this.hideContent();
      }.bind(this),

      onComplete: function(e){
        this.fadeIn();
        this.showContent();
      }.bind(this)
    });
  },

  makeAccordions: function(){
    if (this.nodeContent.getElements('h2.titleSection').length) {
      this.winAccordion = new Fx.Accordion(this.nodeContent.getElements('h2.titleSection'), this.nodeContent.getElements('div.fieldSection'), {
        show: 0,
        opacity: 0,
        onActive: function(toggler, element){
          toggler.addClass ('titleSection-hover')
        },
        onBackground: function(toggler, element){
          toggler.removeClass ('titleSection-hover');
        }
      });
    }
  },

  redims: function () {

    // Analizamos dims viene como opciones del objeto
    if (this.options.dims) {
      if ($type(this.options.dims) == 'string') {

        reDims = new Array();
        reDims = this.options.dims.split('x');

        this.options.dims = new Object();

        this.options.dims.width = reDims[0].toInt();
        //this.options.dims.height = reDims[1];
        this.options.dims.left = reDims[2].toInt();
        this.options.dims.top = reDims[3].toInt();
      }
    }

    this.options.dims.width = this.options.dims.width || this.serverOptions.dims.width;
    this.options.dims.left = this.options.dims.left || this.serverOptions.dims.left;
    this.options.dims.top = this.options.dims.top || this.serverOptions.dims.top;

    this.nodeWin.setStyles ({
      width: this.options.dims.width,
      left: this.options.dims.left,
      top: this.options.dims.top
    })
  },

  dims2Node: function () {
    this.options.dims = this.nodeWin.getCoordinates ();
    return this.options.dims;
  }
});






mooWin.sfPropelEdit = new Class({
  Extends: mooWin,

  Implements: [Events, Options],

  options: {
  },

  initialize: function(options){
    this.parent(options);
  },

  getWinNodesContent: function(){
    this.parent();
    this.getWinFormNodes();
  },

  getWinFormNodes: function () {
    this.nodeWinActions = this.nodeContent.getElement ('div.win_footer');
    this.nodeWinFormEdit = this.nodeContent.getElement ('form');
    this.nodeWinFormDelete = this.nodeWin.getElement ('form.hiddenForm');

    this.widgetSelectsWithAdd = this.nodeContent.getElements ('div.select_with_add');
  },

  dataJsonContentAssign: function () {
    this.parent();
  },

  renderContent: function () {
    this.parent();
    this.makeWidgets ();
  },

  makeWidgets: function () {
    // $propelChoiceWithAdd <- viene ejecutado en la respuesta por AJAX
    if (this.widgetSelectsWithAdd.length) this.renderPropelChoiceWithAdd();
  },

  renderPropelChoiceWithAdd: function () {
    // Recorremos, uno a uno, todos los bloques
    this.widgetSelectsWithAdd.each (function ($selWAdd, $iS) {
      var $nodesWidget = $selWAdd.getChildren();

      var $popUp = $nodesWidget[0];
      var $select2Refresh = $nodesWidget[1];
      var $btn2PopUp = $nodesWidget[2];

      var $nodesPopUpWidget = $popUp.getChildren();

      var $input2Add = $nodesPopUpWidget[0];
      var $btn2Add = $nodesPopUpWidget[2];
      var $btn2Cancel = $nodesPopUpWidget[1];

      var $btns = new Array ($btn2PopUp, $btn2Cancel, $btn2Add);
      this.renderButtons ($btns);

      // Comportamiento de eventos de raton y teclado.
      $btn2PopUp.addEvent ('click', function (e) {
        $popUp.setStyle('display', 'block');
        $input2Add.focus();
      });

      $btn2Cancel.addEvent ('click', function (e) {
        e.stop();
        $popUp.setStyle('display', 'none');
      });

      // Teclas especiales
      $input2Add.addEvent ('keypress', function (e){
        if (e.code == 27) $btn2Cancel.fireEvent('click', e);
        if (e.code == 13) $btn2Add.fireEvent('click', e);
      });

      // Conexion de AJAX
      var addWAjax = new Request.HTML({
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript){
          $select2Refresh.set ('html', responseHTML);
          $popUp.setStyle('display', 'none');
        }.bind(this)
      });

      // Boton Agregar
      $btn2Add.addEvent ('click', function (e) {
        e.stop();
        addWAjax.options.url = $input2Add.get('link_to_add')+'?value='+$input2Add.get('value');
        addWAjax.send();
      }.bind(this));

    }.bind(this));
  },

  createAjaxConex: function () {
    this.parent ()

    this.editAjaxConex = new Request.HTML({
      url: this.nodeWinFormEdit,
      method: 'GET',
      onFailure: function($xhr){
	console.debug ('error !!!');
        //console.debug ($xhr.responseText);
        $('content').set ('html', $xhr.responseText);
      },
      onSuccess: function($tree, $elems, $html, $js){
        this.fireEvent ('editResponseIsReady', [$tree, $elems, $html, $js])
        this.serverEditResponse();
      }.bind(this)
    });
  },

  save: function ($objAct, $ev) {
    this.editAjaxConex.options.url = this.nodeWinFormEdit.get('action');
    this.editAjaxConex.post(this.nodeWinFormEdit);
  },

  serverEditResponse: function () {
    this.renderEditResponse();
    var $win_flashes = this.nodeContent.getElement ('div.win_flashes');

    this.blockOn();

    if ($flashEditResponse.action_state == 'ok' && (this.objParent != window)) {
      this.objParent.refreshContent();
      this.objParent.setState ('Registro editado.')
    }

    (function () {
      $win_flashes.dispose();
      this.blockOff();
    }).delay (1000, this);
  },

  renderEditResponse: function () {
    this.flashEditResponse = $flashEditResponse;                                        // <- Respuesta programada en _flashEdit
    this.nodeContent.set('html', this.editAjaxConex.response.html);
    this.getWinNodesContent();
    this.renderContent();
  },

  closeAndParentRefresh: function () {
    if (this.objParent != window) this.objParent.refreshContent();
    else location.reload();
    this.hideAndDestroy();
  }
})

mooWin.sfPropelNew = new Class({
  Extends: mooWin.sfPropelEdit,

  Implements: [Events, Options],

  options: {
    enabledHeaderBottons: [0, 1, 1, 1]
  },

  initialize: function(json, options){
    this.parent(json, options);
  },

  serverEditResponse: function () {
    this.renderEditResponse();
    this.blockOn();

    (function () {
      // Vemos si la edicion ha sido correcta
      if (this.flashEditResponse.action_state == 'error') {
        this.nodeContent.getElement ('div.win_flashes').dispose();
        this.blockOff();
      }
      else if (this.flashEditResponse.auto_action == 'reedit') {
        // La edicion es correcta. Entonces eliminamos el objeto new y creamos uno nuevo tipo edit
        this.new2Edit();
      }
      else if (this.flashEditResponse.auto_action == 'close_and_parent_refresh') {
        // La edicion es correcta. Entonces eliminamos el objeto new y creamos uno nuevo tipo edit
        this.closeAndParentRefresh();
      }
    }).delay (1000, this);
  },

  new2Edit: function () {
    if (this.objParent != window) {
      this.objParent.refreshContent();
    }
    // Este metodo elimina el objeto tipo win y genera uno nuevo tipo edit.
    // Viene, por javascript, todos los elementos.
    var $dims = this.dims2Node();

    //console.debug ('this.flashEditResponse -> ', this.flashEditResponse);

    this.flashEditResponse.action.obj_parent = this.options.obj_parent;
    this.flashEditResponse.action.node_insert = this.options.node_insert;
    this.flashEditResponse.action.dims = $dims;

    renderAjaxEditWin (this.flashEditResponse.action)
    this.hideAndDestroy();
  }
});


mooWin.sfPropelList = new Class({
  Extends: mooWin,

  Implements: [Events, Options],

  options: {
  },

  initialize: function(json, options){
    this.parent(json, options);
  },

  // Asignación de los datos JSON que vienen desde el server
  dataJsonContentAssign: function () {
    this.parent();

    this.serverOptions2BarMenu = $jsonDataBarMenuList;
    this.serverOptions2Filter = $jsonDataFilter;
    this.serverObjectListActions = $jsonDataObjActionsList;
  },

  getWinNodesContent: function () {
    //console.count ('<getListContentNodes>');
    this.parent();

    this.getWinListMenuNodes();
    this.getWinListNodesContent();

  },

  getWinListNodesContent: function () {
    this.nodeListContainer = this.nodeContent.getElement ('.list-container');
    this.nodeListContent = this.nodeListContainer.getElement ('.sf_admin_list');
    this.nodeListRows = this.nodeListContent.getElements('.sf_admin_row').flatten();
    this.nodeListBtnObjectAction = this.nodeListContent.getElements ('.btn-action').flatten();
    this.nodeListBlkObjectAction = this.nodeListContent.getElements ('ul.sf_admin_ul_actions').flatten();

    // head y foot de la tabla
    this.nodesListTHeadLinks = this.nodeListContent.getElements ('table thead tr th a').flatten();
    this.nodesListTFootLinks = this.nodeListContent.getElements ('table tfoot tr th a').flatten();
  },

  // Metodos de acceso a los nodos
  getWinListMenuNodes: function () {
    this.nodesMenuBottons = this.nodeContent.getElements ('.win_bar').getChildren('a').flatten();
    this.nodesMenuWins = this.nodeContent.getElements ('div.win_bar div.wins_bar').getChildren('div').flatten();

    // Hacemos todas las ventanas dentro de la barra de menu draggeables
    this.nodesMenuWins.each (function ($win, $iW){
      if ($win.hasClass('sf_admin_filter')) this.nodeAdminFilter = $win;
    }, this)
  },

  createAjaxConex: function () {
    this.parent();

    // Definimos objeto ajax para los request del listado
    this.listAjaxRequest = new Request.HTML({
      onSuccess: function(){
        this.serverObjectListActions = $jsonDataObjActionsList;       // <- Actulizamos solo los datos JSON del listado
        this.nodeListContainer.set('html', this.listAjaxRequest.response.html);
        this.getWinListNodesContent ();
        this.makeListContent();
      }.bind(this)
    });
  },

  renderContent: function () {
    this.parent();

    this.makeBarMenu();
    this.makeWinFilter();
    this.makeListContent();
  },

  makeBarMenu: function () {
    this.nodesMenuBottons.each(function ($nodeBtn, $iB){
      var $action2option = this.serverOptions2BarMenu[$iB];

      $action2option.enabled = true;                            // <- condicion inicial

      $nodeBtn.addEvents ({
        'click': function (ev) {
          ev.stop();
          $win = this.nodesMenuWins[$iB];

          if ($action2option.enabled) {
            $nodeBtn.addClass ('linked');
            $win.setStyle ('display', 'block');
            $action2option.enabled = false;
          }
          else {
            $nodeBtn.removeClass ('linked');
            $win.setStyle ('display', 'none');
            $action2option.enabled = true;
          }

          if ($action2option.execute !== undefined && $action2option.enabled) eval ($action2option.execute+'($action2option, ev, $win)');

        }.bind(this)
      })
      
    }, this);
  },

  makeWinFilter: function () {
    // Ajax conex para los filtros
    var $nodeFilterForm = this.nodeAdminFilter.getElement ('form');

    this.winFilter = new Drag (this.nodeAdminFilter, {
      handle: this.nodeAdminFilter.getElement('.bar_menu')
    }, this);

    var $btns = this.nodeAdminFilter.getChildren('div.filter_btns').getChildren('a').flatten();

    $nodeFilterForm.addEvent ('submit', function ($ev){
      $ev.stop();
      $btns[0].fireEvent('click', $ev);
    })

    $btns.each(function($btn, $iB){

      $btn.addEvents({
        'click': function (ev) {
          ev.stop();
          if ($iB == 0) {
            this.listAjaxRequest.options.url = $nodeFilterForm.get('action');
            this.listAjaxRequest.post($($nodeFilterForm));
          }
          else if ($iB == 1) {
            this.listAjaxRequest.options.url = this.serverOptions2Filter[1].action;
            this.listAjaxRequest.post();
          } else {
            this.nodesMenuBottons[0].fireEvent('click', ev);
          }
        }.bind(this)
      })
    }, this);
  },

  makeListContent: function () {
    // Enlaces del thead de la tabla.
    this.nodesListTHeadLinks.each (function ($theadLink, $iT){
      $theadLink.addEvents ({
        click: function ($ev) {
          $ev.stop();
          this.listAjaxRequest.options.method = 'get';
          this.listAjaxRequest.options.url = $theadLink.get('href');
          this.listAjaxRequest.send('only_list=true');
        }.bind(this)
      })
    }, this);

    // Enlaces del tfoot de la tabla. Paginador.
    this.nodesListTFootLinks.each (function ($tfootLink, $iT){
      $tfootLink.addEvents ({
        click: function ($ev) {
          $ev.stop();
          this.listAjaxRequest.options.method = 'get';
          this.listAjaxRequest.options.url = $tfootLink.get('href');
          this.listAjaxRequest.send('only_list=true');
        }.bind(this)
      })
    }, this);

    // Simple animacion en los renglones
    this.nodeListRows.each (function ($row, $iR){
      $row.addEvents ({
        'mouseenter': function (e) {
          this.addClass('sf_admin_row-hover');
        },
        'mouseleave': function (e) {
          this.removeClass('sf_admin_row-hover');
        }
      })
    }, this);

    // Boton accion de cada objeto
    this.nodeListBtnObjectAction.each (function ($btn, $iB) {
      $btn.addEvents ({
        'mousedown': function (e) {
          this.nodeListBlkObjectActions = this.nodeListBlkObjectAction[$iB].getElements ('li.mooBOA');    // <- Nodos (li) de cada accion de UN objeto
          this.nodeListBlkObjectAction[$iB].setStyle('display', 'block');

          // Agregamos los eventos a cada action si no se ha hecho previemente
          if (!this.serverObjectListActions.objects[$iB].rendered) {
            this.serverObjectListActions.objects[$iB].rendered = true;      // <- Ya esta renderizado el bloque de acciones

            // Eventos de cada accion de UN Objeto
            this.nodeListBlkObjectActions.each (function ($nodeAction, $iA) {

              $nodeAction.addEvents ({
                'mouseenter': function () {
                  $nodeAction.addClass('mooBOA-hover');
                },
                'mouseleave': function () {
                  $nodeAction.removeClass('mooBOA-hover');
                },
                'mousedown': function () {
                  $nodeAction.addClass('mooBOA-down');
                },
                'mouseup': function () {
                  $nodeAction.removeClass('mooBOA-down');
                },
                'click': function () {
                  var $objAction = this.serverObjectListActions.objects[$iB];
                  var $action = $objAction.actions[$iA];

                  $action.obj_parent = this;
                  $action.node_insert = this.serverOptions.win.nodeId_winsEmbedded;

                  if ($action.execute !== undefined) eval ($action.execute+'($action, e, false)');
                }.bind(this)
              })
            }, this);
          }
        }.bind(this)
      });
    }, this);

    // bloques de accines de cada objeto. Lo hacemos desaparecer cuando el mouse sale de su area
    this.nodeListBlkObjectAction.each (function ($block, $iB) {
      $block.addEvents ({
        mouseleave: function () {
          $block.setStyle ('display', 'none');
        }.bind(this)
      })
    }, this);
  },

  optFilter: function ($action2option, ev, $win) {

  },
  deleteObject: function ($action, $ev) {
    $action.formDelete = $(this.serverOptions.win.nodeId_formMethod);
    $ev.stop();
    if (confirm($action.msg)) {
      new Request.HTML({
        url: $action.link,
        onComplete: function (tree, elems, html, js) {
          eval ($deleteResponse.action_delete+'()');
        }.bind(this)
      }).post($action.formDelete);
    }
  }
})