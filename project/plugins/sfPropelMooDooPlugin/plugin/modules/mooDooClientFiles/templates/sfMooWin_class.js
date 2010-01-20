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
    injectTo: '',
    id: false,                                     // Identificador de la ventana
    loadWithAjax: true,
    link: '',
    link_content: '',
    nodeInf: '_parent',
    cssPrefix: 'mooWin',
    container: 'content',
    
    fullComplete: true,
    dims: {},
    heardeButtons: {
      refresh: true,
      min: true,
      max: true,
      close: true
    }
  },

  initialize: function(options, winManager){
    // Asignamos el objeto parent y luego lo hacemos null para que la clase pueda definir this.options
    this.prps = {};

    this.setOptions(options);
    
    this.initConf();
    this.winManager = winManager;

    this.addEvent ('winDomReady', function () {

      this.redims ();

      // Renderizamos win
      this.render();
      this.makeWin();

      this.show();
      this.fireEvent('renderComplete', this.element);
    });
  },

  // Configuracion Inicial
  initConf: function(){

    console.debug ("this -> ", this);
    this.elems = {};
    this.jsonData = {};

    // Properties of win
    this.prps.id = this.options.id ? this.options.id : this.options.link;

    this.elems.injectTo = ($(this.options.injectTo));

    // Cargamos el contenido de la ventana con AJAX ?
    if (this.options.loadWithAjax) {

      this.createAjaxConex();
      this.ajaxConex.send();

      this.addEvent ('winDomReady', function () {
        // Asignacion de datos en JSON del servidor
        this.dataJsonAssign();

        // Insertamos el nodo de la ventana dentro del nodo padre
        this.element = this.ajaxConex.response.elements[0];
        this.insertWinNode ();

        // Buscamos las referencias de los nodos asignados
        this.getWinNodes();
        this.getWinNodesContent();
        this.elems.block.setOpacity (0.3);
      });
    }
  },

  insertWinNode: function () {
    this.element.inject(this.elems.injectTo);
    this.element.addEvent('mousedown', function () {
      this.fireEvent('mousedown')
    }.bind(this));
  },

  // Tomamos los nodos principales de una ventana
  getWinNodes: function(){
    this.elems.block = this.element.getChildren()[0];
    this.elems.handle = this.element.getChildren()[1];
    this.elems.content = this.element.getElement('.win_content');
    this.elems.state = this.element.getElement('.win_state');
    this.elems.winButtons = this.elems.handle.getElements('ul li');
  },

  getWinNodesContent: function(){
    this.elems.objActions = this.elems.content.getElements ('.btn_admin_actions');
  },

  /***  Metodos de Render  ***/
  render: function () {
    this.makeButtonsBar();
    this.renderContent();
  },

  renderContent: function () {
    this.makeAccordions();
    this.renderButtons(this.elems.objActions);
    this.renderAction2Buttons();
  },

  makeButtonsBar: function () {
    var buttonsBar = new Element ('ul'), confButton;

    for(confButton in this.options.heardeButtons) {
      if (confButton) {
        buttonsBar.adopt (
          new Element ('li', {
            'class': 'hbtn_'+confButton
            })
          )
      }
    }
    // inject into win content
    buttonsBar.inject(this.elems.handle)

    buttonsBar.addEvents({
      'click:relay(li)': function (ev) {
        this[ev.target.get('class').substring(5, ev.target.get('class').length)]();
      }.bind(this)
    })
  },

  // Renderiamos TODOS los botones de un objeto win
  renderButtons: function ($btns) {
    //console.debug ("$btns -> ", $btns);
    renderButtonsAction ($btns);
  },

  // Renderizamos los botones que suelen estar dentro del botton de un objeto win
  renderAction2Buttons: function () {
    this.elems.objActions.each(function($btn, $iB){
      $btn.addEvents({
        'click': function(e){
          $editAction = this.jsonData.objectActions[$iB];                                                        // <- viene por Json
          $editAction.obj_parent = this;

          console.debug ("$editAction -> ", $editAction);
          this[$editAction.action]();

          //if ($editAction.type == 'delete_object') $editAction.formDelete = this.elems.formDelete                  // <- es para eliminar ?
          //if ($editAction.execute !== undefined) eval ($editAction.execute+'($editAction, e, false)');
        }.bind (this)
      });
    }, this);
  },

  dataJsonAssign: function () {
    this.jsonData.serverOptions = $jsonData4Win;
    this.dataJsonContentAssign();
  },

  dataJsonContentAssign: function () {
    this.jsonData.objectActions = $actions;
  },

  show: function(){
    this.element.setStyle ('display', 'block');
  },

  hide: function(){
    this.element.setStyle ('display', 'none');
  },

  fadeIn: function(){
    this.element.setOpacity (1);
  },

  fadeOut: function(){
    this.element.setOpacity (0.3)
  },

  hideContent: function () {
    this.elems.content.setStyle ('visibility', 'hidden');
  },

  showContent: function () {
    this.elems.content.setStyle ('visibility', 'visible');
  },

  // minimiza Win
  min: function () {

  },

  // maximiza Win
  max: function () {

  },

  close: function(){
    this.fadeOut();
    this.destroy();
  },

  contentDestroy: function(){
  },

  destroy: function(){
    this.element.destroy();
    this.fireEvent ('destroyed', this.id);
  },

  blockOn: function () {
    var $styles = this.element.getStyles ('width', 'height');
    $styles.display = 'block';
    this.elems.block.setStyles ($styles);
  },

  blockOff: function () {
    this.elems.block.setStyle ('display', 'none');
  },

  addWin: function (atts, winParent) {
    this.winManager.add (atts, winParent);
  },
  /*
  refresh: function () {
    this.removeEvents ('winDomReady');
    this.ajaxConex.send();
  },
*/
  refresh: function ($url) {
    
    this.removeEvents ('winDomReady');            // <- Removemos todos las funcones asociadas al evento winDomReady

    $url = $url || false;
    this.ajaxConex.options.url = $url ? $url : this.options.link_content;


    this.addEvent ('winDomReady', function () {
      this.dataJsonContentAssign();
      this.elems.content.set ('html', this.ajaxConex.response.html);
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

    this.elems.state.back = this.elems.state.get('text');
    this.elems.state.set('text', arguments[0]);
    if (arguments[1]) {
      (function () {
        this.elems.state.set('text', this.elems.state.back);
      }).delay (1500, this);
    }
  },

  createAjaxConex: function () {
    this.ajaxConex = new Request.HTML({
      url: this.options.link,
      method: 'GET',
      onFailure: function($xhr){
        $('content').set ('html', $xhr.responseText);
      },
      onSuccess: function(tree, elems, html, js){
        this.fireEvent ('winDomReady', [tree, elems, html, js])
      }.bind(this)
    });
  },

  // Creamos Ventana
  makeWin: function(){
    this.element.setStyle ('position', 'absolute');
    
    this.dragWin = new Drag.Move(this.element, {
      handle: this.elems.handle,
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
    if (this.elems.content.getElements('h2.titleSection').length) {
      this.winAccordion = new Fx.Accordion(this.elems.content.getElements('h2.titleSection'), this.elems.content.getElements('div.fieldSection'), {
        show: 0,
        opacity: false,
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

    this.options.dims.width = this.options.dims.width || this.jsonData.serverOptions.dims.width;
    this.options.dims.left = this.options.dims.left || this.jsonData.serverOptions.dims.left;
    this.options.dims.top = this.options.dims.top || this.jsonData.serverOptions.dims.top;

    this.element.setStyles ({
      width: this.options.dims.width,
      left: this.options.dims.left,
      top: this.options.dims.top
    })
  },

  dims2Node: function () {
    this.options.dims = this.element.getCoordinates ();
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
    this.elems.winActions = this.elems.content.getElement ('div.win_footer');
    this.elems.formEdit = this.elems.content.getElement ('form');
    this.elems.formDelete = this.element.getElement ('form.hiddenForm');

    this.widgetSelectsWithAdd = this.elems.content.getElements ('div.select_with_add');
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
    this.widgetSelectsWithAdd.each (function ($selWAdd, $iS) {
      var objChoice = new sfWidgetFromPropelWithAdd ($selWAdd);
    }.bind(this));
  },

  createAjaxConex: function () {
    this.parent ()

    this.editAjaxConex = new Request.HTML({
      url: this.elems.formEdit,
      method: 'GET',
      onFailure: function($xhr){
        $('content').set ('html', $xhr.responseText);
      },
      onSuccess: function($tree, $elems, $html, $js){
        this.fireEvent ('editResponseIsReady', [$tree, $elems, $html, $js])
      }.bind(this)
    });
  },

  save: function () {
    this.editAjaxConex.addEvent ('success', this.serverEditResponse.bind(this));

    this.editAjaxConex.options.url = this.elems.formEdit.get('action');
    this.editAjaxConex.post(this.elems.formEdit);
  },

  serverEditResponse: function () {
    this.renderEditResponse();
    var $win_flashes = this.elems.content.getElement ('div.win_flashes');

    this.blockOn();
    console.debug ("this -> ", this);

    if ($flashEditResponse.action_state == 'ok' && (this.prps.winParent != window)) {
      this.prps.winParent.refresh();
      this.prps.winParent.setState ('Registro editado.')
    }

    (function () {
      $win_flashes.dispose();
      this.blockOff();
    }).delay (1000, this);
  },

  renderEditResponse: function () {
    this.flashEditResponse = $flashEditResponse;                                        // <- Respuesta programada en _flashEdit
    this.elems.content.set('html', this.editAjaxConex.response.html);
    this.getWinNodesContent();
    this.renderContent();
  },

  closeAndParentRefresh: function () {
    if (this.prps.winParent != window) {
      this.prps.winParent.refresh();
      this.hideAndDestroy();
    }
    else location.reload();
  }
})

mooWin.sfPropelNew = new Class({
  Extends: mooWin.sfPropelEdit,

  Implements: [Events, Options],

  options: {
    
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
        this.elems.content.getElement ('div.win_flashes').dispose();
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
    if (this.prps.winParent != window) {
      this.prps.winParent.refresh();
    }
    // Este metodo elimina el objeto tipo win y genera uno nuevo tipo edit.
    // Viene, por javascript, todos los elementos.
    var $dims = this.dims2Node();

    this.flashEditResponse.action.obj_parent = this.options.obj_parent;
    this.flashEditResponse.action.injectTo = this.options.injectTo;
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
    this.jsonData.listActions = $jsonDataObjActionsList;
  },

  getWinNodesContent: function () {
    this.parent();

    this.getWinListMenuNodes();
    this.getWinListNodesContent();

  },

  getWinListNodesContent: function () {
    this.nodeListContainer = this.elems.content.getElement ('.list-container');
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
    this.nodesMenuBottons = this.elems.content.getElements ('.win_bar').getChildren('a').flatten();
    this.nodesMenuWins = this.elems.content.getElements ('div.win_bar div.wins_bar').getChildren('div').flatten();

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
        this.jsonData.listActions = $jsonDataObjActionsList;       // <- Actulizamos solo los datos JSON del listado
        this.nodeListContainer.set('html', this.listAjaxRequest.response.html);
        this.getWinListNodesContent ();

        this.makeListContent();

      }.bind(this)
    });
  },

  renderContent: function () {
    this.parent();

    this.makeBarMenu();
    if (this.nodeAdminFilter) this.makeWinFilter();
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

    this.prps.winFilter = new Drag (this.nodeAdminFilter, {
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

    // Acciones del listado
    //this.elems.objActions = this.nodeListContainer.getElements ('ul.sf_admin_actions li.btn_admin_actions');
    //this.renderButtons(this.elems.objActions);
    //this.renderAction2Buttons();

    // Boton accion de cada objeto
    this.nodeListBtnObjectAction.each (function ($btn, $iB) {
      $btn.addEvents ({
        'mousedown': function (e) {
          this.nodeListBlkObjectActions = this.nodeListBlkObjectAction[$iB].getElements ('li.mooBOA');    // <- Nodos (li) de cada accion de UN objeto
          this.nodeListBlkObjectAction[$iB].setStyle('display', 'block');

          // Agregamos los eventos a cada action si no se ha hecho previemente
          if (!this.jsonData.listActions.objects[$iB].rendered) {
            this.jsonData.listActions.objects[$iB].rendered = true;      // <- Ya esta renderizado el bloque de acciones

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
                  var listAtts = this.jsonData.listActions.objects[$iB];
                  var atts = listAtts.actions[$iA];

                  //act.injectTo = this.jsonData.serverOptions.win.nodeId_winsEmbedded;  @todo Las ventanas deberían insertarse dentro de su nodo
                  atts.injectTo = 'content-insert-node';

                  this[atts.action](atts, this);
                  //this.winManager.add (act);
                  //console.debug ("this.winManager -> ", this.winManager);
                  //if (act.execute !== undefined) eval (act.execute+'(act, e, false)');
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
    $ev.stop();
    $action.formDelete = $(this.jsonData.serverOptions.win.nodeId_formMethod);

    // Token ?
    if ($action._csrf_token) {
      $input_token = new Element ('input', {
        type: 'hidden',
        name: '_csrf_token',
        value: $action._csrf_token
      })
      $input_token.inject ($action.formDelete);
    }

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