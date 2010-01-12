/*
    Script: dxd.class-1.2.2.1.js
    Clase DxD.
        Clase que implementa comportameitnos drags y drops a un grupo de elementos en forma conjunta.

    License:
    MIT-style license.

    @author: Damián Súarez (damian.suarez@xifox.net)
 */
var DxD = new Class({
  Implements: [Events, Options],

  options: {
    adjDrags: [],
    adjDrops: [],
    autoLevel: true,
    zIndexTop: 1000,
    zIndexBottom: 100,

    cssClass: 'DxD',
    textInDrop: true,

    drag: {
      snap: 6,
      unit: 'px',
      grid: false,
      style: true,
      limit: false,
      handle: false,
      invert: false,
      preventDefault: false,
      modifiers: {
        x: 'left',
        y: 'top'
      },
      umbral: 0,
      randomPos: true
    },

    drop: {
      umbral: 0,
      randomPos: false
    }
  },

  // Constructor
  initialize: function(drags, drops, options){
    // Seteamos elementos de la clase.
    this.setOptions(options);

    // Vector de los objetos Drags
    this.elDrags = new Array ();

    // Vector de los objetos drops.
    this.elDrops = new Array ();
    this.disElDrops = new Array ();     // Vector de drops que han finalizado sus trueDrops

    // Orden de los drags
    this.ordDrag = [];

    this.setIni(drags, drops);
  },

  // setIni
  setIni: function($elDrags, $elDrops){

    // Ultimo elemento drop droppeado
    this.lastDropped = false;

    // Seteos Iniciales de Drag
    this.selection = (Browser.Engine.trident) ? 'selectstart' : 'mousedown';
    this.document = $($elDrags[0]).getDocument();

    // Seteos de Drag.Move
    this.container = $(this.options.container);
    this.container.pos = $(this.options.container).getPosition();

    if ($elDrops) this.setIniDrops ($elDrops);
    this.setIniDrags ($elDrags);
  },

  setIniDrops: function ($elDrops) {

    // Recorremos Drops
    $elDrops.each(function($htmlDropNode, $iObj){
      // Llenamos el array de los objetos Drops
      this.elDrops.include ({
        ind: $iObj,
        node: $htmlDropNode,
        enabled: true,
        cntDrops: 0,
        dragsInDrop: [],
        isDropped: false,
        value: {},
        size: {}
      });

      // Clases Css iniciales ?
      $htmlDropNode.addClass(this.options.cssClass + '-iniDrop');

      this.createDrop (this.elDrops[$iObj])
    }, this);

    // Definimos propiedades de los drops: $objDrop.value: {left, top, right, bottom}.
    this.settingValueDrops();

    // Ajustamos posicion de los Drops
    if (this.options.drop.randomPos) this.options.adjDrops.randomize();
    this.adjustDrops();
  },

  setIniDrags: function ($elDrags) {
    /*************
     *** Drags ***
		 *************/
    $elDrags.each(function($htmlDragNode, $iObj){
      // Vamos llenando array con objetos Drags con todas sus propiedades
      this.elDrags.include ({
        ind: $iObj,
        node: $htmlDragNode,
        indDrop: false,
        enabled: true,
        size: {},
        hasDroppedOver: false,														// es $objDrop.ind si el drag ha Dropeado en algun drop
        backPos: {
          x: null,
          y: null
        },
        zIndex: $iObj + this.options.zIndexBottom
      });

      // Clase inicial para los elementos Drgas
      $htmlDragNode.addClass(this.options.cssClass + '-iniDrag');
			
      // Propiedades CSS Iniciales
      $htmlDragNode.setStyle('z-index', $iObj + this.options.zIndexBottom);

      // Vector que guarda el orden en Z de los drags
      this.ordDrag[$iObj] = $iObj;

      // Creamos propiedades de Drag (antes se usaba la clase Drag.Move)
      this.createDrag (this.elDrags[$iObj]);

    }, this); // end Drags

    // Ahustamos posiciones de drags
    if ($type(this.options.adjDrags) == 'object') this.adjObject2Array();
    if (this.options.drag.randomPos) this.orderIndDrag = this.options.adjDrags.randomize();
    if (this.options.adjDrags) this.adjustDrags();
  },

  createDrop: function ($objDrop) {
    // boundeamos los eventos de los nodos drops
    $objDrop.bound = {
      enterDrop: function($objDrag) {
        this.enterDrop($objDrag, $objDrop)
        }.bind(this),
      leaveDrop: function($objDrag) {
        this.leaveDrop($objDrag, $objDrop)
        }.bind(this)
    };

    // Atachamos eventos al objeto drag
    this.attachDrop($objDrop);
  },

  // Metodo que implementa todas las condiciones iniciales para hacer Drags a los nodos. Reemplaza al construcutor de la clase Drag.
  createDrag: function ($objDrag, $options) {

    // Calculamos sus dimensiones
    $objDrag.size = $objDrag.node.getSize();

    // Parametros de configuracion. Es uno de los puntos mas importantes a arreglar
    var params = Array.link([$objDrag.node, this.options.drag], {
      'options': Object.type,
      'element': $defined
    });

    this.setOptions(params.options || {});
    var htype = $type(this.options.drag.handle);		//	-> handle es una propiedad de cada drag

    $objDrag.handles = (htype == 'array' || htype == 'collection') ? $$(this.options.drag.handle) : $(this.options.drag.handle) || $objDrag.node;

    $objDrag.mouse = {
      'now': {},
      'pos': {},
      'start': {}
    };
    $objDrag.value = {
      'now': {},
      'umbral': {}
    };

    $objDrag.bound = {
      dragEnter: function($event){
        this.dragEnter($objDrag, $event)
        }.bind(this),
      dragLeave: function($event){
        this.dragLeave($objDrag, $event)
        }.bind(this),

      start: function($event){
        this.start($objDrag, $event)
        }.bind(this),
      check: function($event){
        this.check($objDrag, $event)
        }.bind(this),
      drag: function($event){
        this.drag($objDrag, $event)
        }.bind(this),
      stop: function($event){
        this.stop($objDrag, $event)
        }.bind(this),
      cancel: function($event){
        this.cancel($objDrag, $event)
        }.bind(this),
      eventStop: $lambda(false)
    };

    // Atachamos eventos al objeto drag
    this.attachDrag($objDrag);

    // Lo que viene es parte del contructor Drag.Move
    if (this.container && $type(this.container) != 'element') this.container = $(this.container.getDocument().body);

    var current = $objDrag.node.getStyle('position');
    var position = (current != 'static') ? current : 'absolute';

    if ($objDrag.node.getStyle('left') == 'auto' || $objDrag.node.getStyle('top') == 'auto') $objDrag.node.position($objDrag.node.getPosition($objDrag.node.offsetParent));

    // Define la posicion del drag
    $objDrag.node.setStyle('position', position);
  },

  'dragEnter': function ($objDrag) {
    if (this.options.autoLevel) this.raseUpDrag($objDrag);
    $objDrag.node.addClass (this.options.cssClass + '-enterDrag');
  },
  'dragLeave': function ($objDrag) {
    this.calcOrdDrags($objDrag);
    if (this.options.autoLevel) this.levelDrags($objDrag);
    $objDrag.node.removeClass (this.options.cssClass + '-enterDrag');
  },

  // start
  start: function($objDrag, $event){
    if (!this.bloclAllDrags) {
      // Cancelamos efecto ... por si anda girando por ahi.
      $objDrag.fx.cancel();
			
      // Nivelamos en el start si es que no está en forma automática
      if (!this.options.autoLevel)
        this.raseUpDrag($objDrag);
			
      // Parte de Drag.Move
      if (this.container) {
        var el = $objDrag.node, cont = this.container, ccoo = this.container.getCoordinates(el.offsetParent), cps = {}, ems = {};
				
        ['top', 'right', 'bottom', 'left'].each(function(pad){
          cps[pad] = cont.getStyle('padding-' + pad).toInt();
          ems[pad] = el.getStyle('margin-' + pad).toInt();
        }, $objDrag);
				
        var width = el.offsetWidth + ems.left + ems.right, height = el.offsetHeight + ems.top + ems.bottom;
        var x = [ccoo.left + cps.left, ccoo.right - cps.right - width];
        var y = [ccoo.top + cps.top, ccoo.bottom - cps.bottom - height];
				
        this.options.drag.limit = {
          x: x,
          y: y
        };
      }
			
      this.fireEvent('beforeStart', $objDrag); // <-- onBeforeStart
      if (this.options.drag.preventDefault)
        $event.preventDefault();
      $objDrag.mouse.start = $event.page;
			
      var $limit = this.options.drag.limit;
      $objDrag.limit = {
        'x': [],
        'y': []
      };
			
      // Calculo de los puntos relevantes de la posicion del drag
      for (var z in this.options.drag.modifiers) {
        if (!this.options.drag.modifiers[z])
          continue;
        if (this.options.drag.style)
          $objDrag.value.now[z] = $objDrag.node.getStyle(this.options.drag.modifiers[z]).toInt();
        else
          $objDrag.value.now[z] = $objDrag.node[this.options.drag.modifiers[z]];
        if (this.options.drag.invert)
          $objDrag.value.now[z] *= -1;
				
        $objDrag.mouse.pos[z] = $event.page[z] - $objDrag.value.now[z];
				
        if ($limit && $limit[z]) {
          for (var i = 2; i--; i) {
            if ($chk($limit[z][i]))
              $objDrag.limit[z][i] = $lambda($limit[z][i])();
          }
        }
      };

      if ($type(this.options.drag.grid) == 'number')
        this.options.drag.grid = {
          'x': this.options.drag.grid,
          'y': this.options.drag.grid
        };
			
      this.document.addEvents({
        mousemove: $objDrag.bound.check,
        mouseup: $objDrag.bound.cancel
      });
      this.document.addEvent($objDrag.selection, $objDrag.bound.eventStop);
    }
  },

  drag: function ($objDrag, $event) {
    if (this.options.drag.preventDefault) $event.preventDefault();
    $objDrag.mouse.now = $event.page;
    for (var z in this.options.drag.modifiers){
      if (!this.options.drag.modifiers[z]) continue;

      $objDrag.value.now[z] = $objDrag.mouse.now[z] - $objDrag.mouse.pos[z];

      if (this.options.drag.invert) $objDrag.value.now[z] *= -1;
      if (this.options.drag.limit && $objDrag.limit[z]){
        if ($chk($objDrag.limit[z][1]) && ($objDrag.value.now[z] > $objDrag.limit[z][1])){
          $objDrag.value.now[z] = $objDrag.limit[z][1];
        } else if ($chk($objDrag.limit[z][0]) && ($objDrag.value.now[z] < $objDrag.limit[z][0])){
          $objDrag.value.now[z] = $objDrag.limit[z][0];
        }
      };
      if (this.options.drag.grid[z]) $objDrag.value.now[z] -= ($objDrag.value.now[z] % $objDrag.options.drag.grid[z]);
      if (this.options.drag.style) $objDrag.node.setStyle(this.options.drag.modifiers[z], $objDrag.value.now[z] + this.options.drag.unit);
      else $objDrag.node[this.options.drag.modifiers[z]] = $objDrag.node.value.now[z];
    };

    $objDrag.value.umbral.x = $objDrag.value.now.x + this.options.drag.umbral + this.container.pos.x*this.dropsNotAreAbs;
    $objDrag.value.umbral.x2 = $objDrag.value.now.x - this.options.drag.umbral + this.container.pos.x*this.dropsNotAreAbs + $objDrag.size.x;
    $objDrag.value.umbral.y = $objDrag.value.now.y + this.options.drag.umbral + this.container.pos.y*this.dropsNotAreAbs;
    $objDrag.value.umbral.y2 = $objDrag.value.now.y - this.options.drag.umbral + this.container.pos.y*this.dropsNotAreAbs + $objDrag.size.y;

    this.fireEvent('drag', $objDrag);

    // Drag.Move
    this.checkDroppables($objDrag);

  },

  // check
  check: function ($objDrag, $event) {
    if (this.options.drag.preventDefault) $event.preventDefault();
    var distance = Math.round(Math.sqrt(Math.pow($event.page.x - $objDrag.mouse.start.x, 2) + Math.pow($event.page.y - $objDrag.mouse.start.y, 2)));

    if (distance > this.options.drag.snap){
      this.cancel($objDrag, $event);

      this.document.addEvents({
        mousemove: $objDrag.bound.drag,
        mouseup: $objDrag.bound.stop
      });
      this.fireEvent('start', $objDrag.node).fireEvent('snap', $objDrag.node);										// <-- ev.onStart

      $objDrag.node.addClass(this.options.cssClass + '-dragDrag');
    }
  },

  stop: function ($objDrag, $event) {

    $objDrag.node.removeClass(this.options.cssClass + '-dragDrag');

    if (!this.options.autoLevel) this.levelDrags($objDrag);

    if (this.overed) {
      this.overed.isDropped = true;
      this.overed.node.addClass (this.options.cssClass + '-dropDrop');

      // en el elemento drag ...
      $objDrag.node.addClass (this.options.cssClass + '-dropDrag');
      $objDrag.hasDroppedOver = this.overed.ind;

      this.fireEvent('drop', [$objDrag, this.overed]);															// <-- ev.onDrop
    }
    else {
      $objDrag.node.removeClass (this.options.cssClass + '-dropDrag');
      $objDrag.hasDroppedOver = false;

      if (this.lastDropped !== false) {                                                                           // <-- ev.onEmptyDrop
        this.fireEvent('emptyDrop', [$objDrag, this.lastDropped]);
      }
      else {
        this.fireEvent('emptyDrop', [$objDrag, null]);
      };
    };
    this.overed = null;

    this.document.removeEvent(this.selection, $objDrag.bound.eventStop);
    this.document.removeEvent('mousemove', $objDrag.bound.drag);
    this.document.removeEvent('mouseup', $objDrag.bound.stop);
    if ($event) this.fireEvent('complete', $objDrag);																							// <-- ev.onComplete

  },

  cancel: function ($objDrag, $event) {
    this.document.removeEvent('mousemove', $objDrag.bound.check);
    this.document.removeEvent('mouseup', $objDrag.bound.cancel);

    if ($event){
      this.document.removeEvent(this.selection, $objDrag.bound.eventStop);
      this.fireEvent('cancel', $objDrag.ind);
    };
  },

  checkAgainst: function($objD){
    var umbral = this.value.umbral ;
    return (!(umbral.x > $objD.value.right || umbral.x2 < $objD.value.left || umbral.y > $objD.value.bottom || umbral.y2 < $objD.value.top));
  },

  checkDroppables: function($objDrag){
    var overed = this.elDrops.filter(this.checkAgainst, $objDrag).getLast();

    if (this.overed != overed) {

      // leave
      if (this.overed) {
        this.overed.dragsInDrop.erase ($objDrag);
        this.fireEvent('leave', [$objDrag, this.overed]); 																					// <-- ev.onLeave
        this.overed.node.fireEvent('leave', [$objDrag, this.overed]);
      }

      // enter
      if (overed) {
        this.overed = overed;

        // Ultimo elemento drop droppeado
        this.lastDropped = overed;

        overed.dragsInDrop.include ($objDrag);

        // Disparamos onEnter si el drag NO se encontraba sobre el drop
        if (this.overed.ind !== $objDrag.hasDroppedOver) {
          this.fireEvent('enter', [$objDrag, overed]); 																					// <-- ev.onEnter
          overed.node.fireEvent('enter', [$objDrag, overed]);
        };
      }
      else {
        this.overed = null;
      };
    };
  },
    
  enterDrop: function ($objDrag, $objDrop) {
    $objDrag.node.addClass(this.options.cssClass + '-overDrag');
    $objDrop.node.addClass(this.options.cssClass + '-overDrop');
  },

  leaveDrop: function ($objDrag, $objDrop) {
    if (!this.overed.dragsInDrop.length) {
      this.overed.node.removeClass(this.options.cssClass + '-overDrop');
      this.overed.node.removeClass(this.options.cssClass + '-dropDrop');
    }

    $objDrag.node.removeClass(this.options.cssClass + '-overDrag');
    $objDrag.node.removeClass(this.options.cssClass + '-dropDrag');
  },

  attachDrag: function($objDrag){
    $objDrag.handles.addEvent('mousedown', $objDrag.bound.start);
    $objDrag.handles.addEvent('mouseenter', $objDrag.bound.dragEnter);
    $objDrag.handles.addEvent('mouseleave', $objDrag.bound.dragLeave);
    return $objDrag;
  },

  detachDrag: function($objDrag){
    $objDrag.handles.removeEvent('mousedown', $objDrag.bound.start);
    $objDrag.handles.removeEvent('mouseenter', $objDrag.bound.dragEnter);
    $objDrag.handles.removeEvent('mouseleave', $objDrag.bound.dragLeave);
    return $objDrag;
  },

  attachDrop: function($objDrop){
    $objDrop.node.addEvent('enter', $objDrop.bound.enterDrop);
    $objDrop.node.addEvent('leave', $objDrop.bound.leaveDrop);
    return $objDrop;
  },

  detachDrop: function($objDrop){
    // Pasamos el objeto de this.elDrops a this.disElDrops
    this.disElDrops.include ($objDrop);
    this.elDrops[this.elDrops.indexOf($objDrop)] = null;
    this.elDrops = this.elDrops.clean();

    $objDrop.enabled = false;
    $objDrop.node.removeEvent('enter', $objDrop.bound.enterDrop);
    $objDrop.node.removeEvent('leave', $objDrop.bound.leaveDrop);
    return $objDrop;
  },

  raseUpDrag: function($objDrag){
    $objDrag.zIndex = this.options.zIndexTop;
    $objDrag.node.setStyle('z-index', $objDrag.zIndex);
  },

  calcOrdDrags: function($objDrag) {
    var $levelDrag = this.ordDrag[$objDrag.ind];
    for (var $nvlDrag = $levelDrag + 1; $nvlDrag <= (this.elDrags.length - 1); $nvlDrag++) {
      iDrag = this.ordDrag.indexOf($nvlDrag);
      this.ordDrag[iDrag] = $nvlDrag - 1;
      this.elDrags[iDrag].zIndex =  $nvlDrag + this.options.zIndexBottom - 1;
    };
    this.ordDrag[$objDrag.ind] = this.elDrags.length - 1;
  },

  levelDrags: function () {
    this.elDrags.each (function ($objDrag, $iOB){
      if ($objDrag) $objDrag.node.setStyle ('z-index', this.options.zIndexBottom + this.ordDrag[$iOB])
    }, this);
  },

  adjustDrags: function() {
    (this.elDrags).each(function($objDrag, $iB){
      // Asignamos posicion inicial de los drags como propiedad.
      $objDrag.backPos = this.options.adjDrags[$iB];

      // Ahora definimos su posición
      $objDrag.node.position(this.options.adjDrags[$iB]);
    }, this);
  },

  adjObject2Array: function ()  {
    // En este caso suponemos que los elementos tienen las mismas dimensioens. Sería interesante hacer el calculo del posicionamiento para anchos variables entre cada elementos.
    var $distXEl = (this.options.adjDrags.width - this.elDrags[0].node.getComputedSize().totalWidth)/(this.options.adjDrags.elXLine);

    var $x;
    var $y = this.options.adjDrags.top;
    for ($i = 0, $el = 0; $i < this.elDrags.length; $i++) {
      $x = this.options.adjDrags.left + $distXEl*$el;

      // Asignamos posicion inicial de los drags como propiedad.
      this.elDrags[$i].backPos = {
        x: $x,
        y: $y
      };

      // Ahora definimos su posición
      //this.elDrags[$i].node.position(this.elDrags[$i].backPos);

      // Calculo de cierro del bucle
      if ($el >= this.options.adjDrags.elXLine) {
        $el =  0;
        $x = this.options.adjDrags.left;
        $y = $y + this.elDrags[0].node.getComputedSize().totalHeight + this.options.adjDrags.distXLine;
      }
      else {
        $el++;
      }
    }

    // Reconstruimos el array de ajuste. Todo el sistema de ajuste de los drags hay que mejorar en algun momento.
    this.options.adjDrags = [];
    this.elDrags.each (function ($objDrag, $oB) {
      this.options.adjDrags.include ($objDrag.backPos);
    }, this);
  },

  adjustDrops: function() {

    if ((this.options.adjDrops).length) {
      this.dropsNotAreAbs = false;

      // Recorremos todos los elementos Drags.
      (this.elDrops).each(function($objDrop, $iD){
        $objDrop.node.setStyle ('position', 'absolute');
        $objDrop.node.position(this.options.adjDrops[$iD]);

        // Redefinimos valores value de los objetos Drops
        $objDrop.value.left = this.options.adjDrops[$iD].x;
        $objDrop.value.top = this.options.adjDrops[$iD].y;

        $objDrop.value.right = $objDrop.node.getComputedSize().totalWidth + this.options.adjDrops[$iD].x;
        $objDrop.value.bottom = $objDrop.node.getComputedSize().totalHeight + this.options.adjDrops[$iD].y;

      }, this);
    }
    else {
      (this.elDrops).each(function($objDrop, $iD){
        $objDrop.value = $objDrop.node.getCoordinates();
      })
      this.dropsNotAreAbs = true;
    };
  },

  settingValueDrops: function () {

    this.elDrops.each(function ($objDrop, $iOB) {

      if ($type(this.options.drop.umbral) == 'object') {
        $objDrop.value.left = $objDrop.value.left + this.options.drop.umbral.left
        $objDrop.value.top = $objDrop.value.top + this.options.drop.umbral.top
        $objDrop.value.right = $objDrop.value.right - this.options.drop.umbral.right
        $objDrop.value.bottom = $objDrop.value.bottom - this.options.drop.umbral.bottom
      }
      if ($type(this.options.drop.umbral) == 'number') {

        $objDrop.value.left = $objDrop.value.left + this.options.drop.umbral
        $objDrop.value.top = $objDrop.value.top + this.options.drop.umbral
        $objDrop.value.right = $objDrop.value.right - this.options.drop.umbral
        $objDrop.value.bottom = $objDrop.value.bottom - this.options.drop.umbral
      }

      if ($type(this.options.drop.umbral) == 'string') {
        var $umbral = {};
        $umbral.x = ($objDrop.value.width*this.options.drop.umbral.toInt()/100).toInt();
        $umbral.y = ($objDrop.value.height*this.options.drop.umbral.toInt()/100).toInt()

        $objDrop.value.left = $objDrop.value.left + $umbral.x
        $objDrop.value.top = $objDrop.value.top + $umbral.y
        $objDrop.value.right = $objDrop.value.right - $umbral.x
        $objDrop.value.bottom = $objDrop.value.bottom - $umbral.y
      }
    }.bind(this));
  }
});


/*
    Script: dxd.class-1.2.2.1.js
    Clase DxD.Base.

    License:
    MIT-style license.

    @author: Damián Súarez (damian.suarez@xifox.net)
 */

DxD.Base = new Class({

  Extends: DxD,

  options: {
    dragDelete: true,
    multiDrop: false,
    sendToBack: false,
    textInDrop: true,

    drag: {
      Fx: {
        wait: false,
        duration: 1000,
        transition: Fx.Transitions.Back.easeOut
      }
    },

    drop: {
      Fx: {
        wait: false,
        duration: 1000,
        transition: Fx.Transitions.Back.easeOut
      }
    }
  },

  initialize: function(drags, drops, options){
    this.parent(drags, drops, options);
    this.setIniBase();

    this.addEvents ({
      'emptyDrop': this.dragEmptyDrop.bind(this),
      'complete': this.dragComplete.bind(this),
      'drop': this.dropComplete.bind(this)
    });
  },

  setIniBase: function () {
    // Drops
    this.elDrops.each (function ($objDrop, $iOB) {
      $objDrop.text = $objDrop.node.get('text').trim();
      $objDrop.fx = new Fx.Morph($objDrop.node, this.options.drop.Fx);

      // Definimos la maxima cantidad de drops en cada elemento
      if (this.options.multiDrop === true) {
        $objDrop.maxNumDrops = -1;                          // Infinito
      }
      else if (this.options.multiDrop === false) {
        $objDrop.maxNumDrops = 1;                          // Un Solo drop
      }
      else if ($type(this.options.multiDrop) == 'number') {
        $objDrop.maxNumDrops = this.options.multiDrop;     // La cantidad de drops definida
      }
      else if ($type(this.options.multiDrop) == 'string' && this.options.multiDrop == 'wordLength') {
        $objDrop.maxNumDrops = $objDrop.text.length;
      }
      else if ($type(this.options.multiDrop) == 'array') {
        $objDrop.maxNumDrops = this.options.multiDrop[$iOB];
      }

      else $objDrop.maxNumDrops = 1;
            
    }.bind(this));

    // Drags
    this.elDrags.each (function ($objDrag, $iOB) {
      $objDrag.text = $objDrag.node.get('text');
      $objDrag.fx = new Fx.Morph($objDrag.node, this.options.drag.Fx);
    }.bind(this));
  },

  enterDrop: function ($objDrag, $objDrop) {
    if (this.options.textInDrop) $objDrop.node.set('text', $objDrag.text);
    this.parent ($objDrag, $objDrop);
  },

  leaveDrop: function ($objDrag, $objDrop) {
    if (this.options.textInDrop) $objDrop.node.set('text', $objDrop.text);
    this.parent ($objDrag, $objDrop);
  },

  fncTrueDrop: function($objDrag, $objDrop){
    return ($objDrag.ind == $objDrop.ind) ? true : false;
  },

  dragEmptyDrop: function ($objDrag, $objLastDrop) {
    switch (this.options.sendToBack) {
      case 'ini':
        $objDrag.backPos = this.options.adjDrags[$objDrag.ind];
        break;

      case 'back':
        $objDrag.backPos = {
          x: $objDrag.value.now.x,
          y: $objDrag.value.now.y
        }
        break;
    };

    this.sendToBack ($objDrag);
  },

  dragComplete: function ($objDrag) {

  },

  dropComplete: function ($objDrag, $objDrop) {
    if (!this.fncTrueDrop($objDrag, $objDrop)) {

      // Quitamos el objeto drag dentro del array dragsInDrop
      $objDrop.dragsInDrop.erase ($objDrag);

      this.sendToBack($objDrag);

      $objDrag.hasDroppedOver = false;            // El drag no ha sido droppeado sobre ningun drop
      this.falseDrop ($objDrag, $objDrop);
      this.fireEvent ('falseDrop', [$objDrag, $objDrop]);																						// <-- ev.onFalseDrop
      this.fireEvent ('leave', [$objDrag, $objDrop]);
            

      $objDrop.node.fireEvent ('leave', [$objDrag, $objDrop]);
    }
    else {

      if (this.options.dragDelete) this.deleteDrag($objDrag);

      this.trueDrop ($objDrag, $objDrop);
      this.fireEvent ('trueDrop', [$objDrag, $objDrop]);																						// <-- ev.onTrueDrop
      $objDrop.node.fireEvent ('trueDrop', [$objDrag, $objDrop]);
    };
  },
    
  trueDrop: function ($objDrag, $objDrop) {
    $objDrop.node.addClass(this.options.cssClass + '-trueDrop');
        
    $objDrop.cntDrops++;
    if ($objDrop.cntDrops == $objDrop.maxNumDrops) {
      if (this.options.textInDrop) $objDrop.node.set('text', $objDrag.text);

      this.detachDrop ($objDrop);
      $objDrop.node.addClass(this.options.cssClass + '-trueDropComplete');
      this.fireEvent ('trueDropComplete', [$objDrag, $objDrop]);

      // Control de trueDrop en todos los drops
      if (!this.elDrops.length) this.fireEvent ('trueDropsComplete');
    }
  },

  falseDrop: function ($objDrag, $objDrop) {
    // Eliminamos clases CSS en drag y drops
    $objDrag.node.removeClass (this.options.cssClass + '-overDrag');
    $objDrag.node.removeClass (this.options.cssClass + '-dropDrag');

    if (!$objDrop.dragsInDrop.length) {
      $objDrop.node.removeClass(this.options.cssClass + '-overDrop');
      $objDrop.node.removeClass(this.options.cssClass + '-dropDrop');
    };
  },

  deleteDrag: function(drag){
    if (this.options.dragDelete) {
      if (this.options.dragDelete == 'none') drag.node.setStyle ('display', 'none');
      else drag.node.destroy();
    };
  },

  sendToBack: function($objDrag){
    //this.bloclAllDrags = true;
    $objDrag.fx.start({
      'left': $objDrag.backPos.x,
      'top': $objDrag.backPos.y
    });
  /*.chain (function () {
			this.bloclAllDrags = false;
		}.bind(this));
        */
  }
});

/*
    Script: dxd.class-1.2.2.1.js
    Clase DxD.Film.

    License:
    MIT-style license.

    @author: Damián Súarez (damian.suarez@xifox.net)
 */

DxD.Film = new Class({

  Extends: DxD.Base,

  options: {
    filmDrag: {
      index:   'self',
      ini:      {
        x: 120,
        y: 120
      },
      enter:    {
        x: 120,
        y:   0
      },
      drag:     {
        x: 120,
        y: 240
      },
      over:     {
        x: 120,
        y: 360
      },
      trueDrop: {
        x: 120,
        y:   0
      }
    },

    filmDrop: {
      index:              1,
      ini:                {
        x: 200,
        y:   0
      },
      enter:              {
        x: 400,
        y: 120
      },
      drop:               {
        x: 600,
        y: 240
      },
      trueDrop:           {
        x: 800,
        y:   0
      },
      trueDropComplete:   {
        x: 800,
        y:   0
      }
    },

    drag: {
    },

    drop: {
  }
  },

  initialize: function(drags, drops, options){
    this.parent(drags, drops, options);
    this.setIniFilm ();
  },

  setIniFilm: function () {
    // Configuramos desplazamiento del film en los drag

    this.elDrags.each (function ($objDrag, $iOB){
      var $indexDrag = (this.options.filmDrag.index == 'self') ? $objDrag.ind : this.options.filmDrag.index;

      $objDrag.node.setStyles ({
        'background-position': $indexDrag*(-1)*(this.options.filmDrag.ini.x).toString()+'px ' + (-1)*this.options.filmDrag.ini.y + 'px'
      });
    }.bind(this));

    // Configuramos desplazamiento del film en los drops
    if (this.options.filmDrop !== false) {
      this.elDrops.each (function ($objDrop, $iOB){
        var $indexDrop = (this.options.filmDrop.index == 'self') ? $objDrop.ind : this.options.filmDrop.index;
        $objDrop.node.setStyles ({
          'background-position': $indexDrop*(-1)*(this.options.filmDrop.ini.x).toString()+'px ' + (-1)*this.options.filmDrop.ini.y + 'px'
        });
      }.bind(this));
    };

    this.addEvents ({
      'trueDrop': function ($objDrag, $objDrop) {
        $indexDrag = (this.options.filmDrag.index == 'self') ? $objDrag.ind : this.options.filmDrag.index;
        $objDrag.node.setStyles ({
          'background-position': $indexDrag*(-1)*(this.options.filmDrag.trueDrop.x).toString()+'px ' + (-1)*this.options.filmDrag.trueDrop.y + 'px'
        });

        if (this.options.filmDrop !== false) {
          $indexDrop = (this.options.filmDrop.index == 'self') ? $objDrop.ind : this.options.filmDrop.index;

          $objDrop.node.setStyles ({
            'background-position': $indexDrop*(-1)*(this.options.filmDrop.trueDrop.x).toString()+'px ' + (-1)*this.options.filmDrop.trueDrop.y + 'px'
          });
        }
      },
      'trueDropComplete': function ($objDrag, $objDrop) {
        if (this.options.filmDrop !== false && $objDrop.enabled) {
          $indexDrop = (this.options.filmDrop.index == 'self') ? $objDrop.ind : this.options.filmDrop.index;
          $objDrop.node.setStyles ({
            'background-position': $indexDrop*(-1)*(this.options.filmDrop.trueDropComplete.x).toString()+'px ' + (-1)*this.options.filmDrop.trueDropComplete.y + 'px'
          });
        };
      }
    });
  },

  start: function ($objDrag, $ev) {
    $indexDrag = (this.options.filmDrag.index == 'self') ? $objDrag.ind : this.options.filmDrag.index;
    $objDrag.node.setStyles ({
      'background-position': $indexDrag*(-1)*(this.options.filmDrag.drag.x).toString()+'px ' + (-1)*this.options.filmDrag.drag.y + 'px'
    });
    this.parent($objDrag, $ev);
  },

  dragEnter: function ($objDrag, $ev) {
    $indexDrag = (this.options.filmDrag.index == 'self') ? $objDrag.ind : this.options.filmDrag.index;
    $objDrag.node.setStyles ({
      'background-position': $indexDrag*(-1)*(this.options.filmDrag.enter.x).toString()+'px ' + (-1)*this.options.filmDrag.enter.y + 'px'
    });
    this.parent($objDrag, $ev);
  },

  dragLeave: function ($objDrag, $ev) {
    $indexDrag = (this.options.filmDrag.index == 'self') ? $objDrag.ind : this.options.filmDrag.index;
    $objDrag.node.setStyles ({
      'background-position': $indexDrag*(-1)*(this.options.filmDrag.ini.x).toString()+'px ' + (-1)*this.options.filmDrag.ini.y + 'px'
    });
    this.parent($objDrag, $ev);
  },

  enterDrop: function ($objDrag, $objDrop) {
    $indexDrag = (this.options.filmDrag.index == 'self') ? $objDrag.ind : this.options.filmDrag.index;
    $objDrag.node.setStyles ({
      'background-position': $indexDrag*(-1)*(this.options.filmDrag.over.x).toString()+'px ' + (-1)*this.options.filmDrag.over.y + 'px'
    });

    if (this.options.filmDrop !== false) {
      $indexDrop = (this.options.filmDrop.index == 'self') ? $objDrag.ind : this.options.filmDrop.index;

      $objDrop.node.setStyles ({
        'background-position': $indexDrop*(-1)*(this.options.filmDrop.enter.x).toString()+'px ' + (-1)*this.options.filmDrop.enter.y + 'px'
      });
    }
    this.parent ($objDrag, $objDrop);
  },
  leaveDrop: function ($objDrag, $objDrop) {
    $indexDrag = (this.options.filmDrag.index == 'self') ? $objDrag.ind : this.options.filmDrag.index;

    $objDrag.node.setStyles ({
      'background-position': $indexDrag*(-1)*(this.options.filmDrag.drag.x).toString()+'px ' + (-1)*this.options.filmDrag.drag.y + 'px'
    });
    if (this.options.filmDrop !== false) {
      $indexDrop = (this.options.filmDrop.index == 'self') ? $objDrop.ind : this.options.filmDrop.index;
      $objDrop.node.setStyles ({
        'background-position': $indexDrop*(-1)*(this.options.filmDrop.ini.x).toString()+'px ' + (-1)*this.options.filmDrop.ini.y + 'px'
      });
    }
    this.parent ($objDrag, $objDrop);
  }
});


DxD.Swap = new Class({

  Extends: DxD.Base,

  options: {
    dragDelete: false,
    drag: {
      Fx: {
        duration: 500
      }
    }
  },

  initialize: function($drags, options) {
    this.parent($drags, false, options);
    this.setIniSwap ();
  },

  setIniSwap: function () {
    this.word4Drags = '';
    this.initWord = '';
    this.dropsNotAreAbs = false;
    this.elDrags.each (function ($objDrag, $iOB){
      this.initWord = this.initWord + $objDrag.text;
      this.word4Drags = this.word4Drags + this.elDrags[this.orderIndDrag.indexOf($iOB)].text;
      $objDrag.indDrop = this.orderIndDrag[$iOB];
      this.calcUmbral ($objDrag);
    }, this);
  },

  calcUmbral: function ($objDrag) {
    $objDrag.value.umbral.x = ($objDrag.backPos.x + this.options.drag.umbral).toInt();
    $objDrag.value.umbral.x2 = ($objDrag.backPos.x - this.options.drag.umbral + $objDrag.size.x).toInt();
    $objDrag.value.umbral.y = ($objDrag.backPos.y + this.options.drag.umbral).toInt();
    $objDrag.value.umbral.y2 = ($objDrag.backPos.y - this.options.drag.umbral + $objDrag.size.y).toInt();
  },

  checkAgainst: function($overDrag) {
    if ($overDrag === this || $overDrag.enabled === false) return false;
    var $umbralDrag = this.value.umbral;
    var $umbralOverD = $overDrag.value.umbral;
    return (!($umbralDrag.x > $umbralOverD.x2 || $umbralDrag.x2 < $umbralOverD.x || $umbralDrag.y > $umbralOverD.y2 || $umbralDrag.y2 < $umbralOverD.y));
  },

  sendToBack: function ($objDrag) {
    this.calcUmbral ($objDrag);
    this.parent ($objDrag);
  },

  checkDroppables: function($objDrag){
    var overed = this.elDrags.filter(this.checkAgainst, $objDrag).getLast();

    if (this.overed != overed) {
      if (this.overed) {
        //this.overed.dragsInDrop.erase ($objDrag);
        this.leaveOverDrag ($objDrag, this.overed);
        this.fireEvent('leaveOverDrag', [$objDrag, this.overed]); 																					// <-- ev.onLeave
      }

      // enter
      if (overed) {
        this.overed = overed;

        // Ultimo elemento drop droppeado
        this.lastDropped = overed;

        // Disparamos onEnter si el drag NO se encontraba sobre el drop
        this.enterOverDrag ($objDrag, overed);
        this.fireEvent('enterOverDrag', [$objDrag, overed]); 																					// <-- ev.onEnter
      }
      else {
        this.overed = null;
      };
    };
  },
	
  detachDrag: function ($objDrag) {
    $objDrag.enabled = false;
    this.parent($objDrag);
  },

  enterOverDrag: function ($objDragOut, $objDragIn) {
    $objDragOut.node.addClass(this.options.cssClass + '-overDrag');
    $objDragIn.node.addClass(this.options.cssClass + '-overDrop');
  },

  leaveOverDrag: function ($objDragOut, $objDragIn) {
    $objDragOut.node.removeClass(this.options.cssClass + '-overDrag');
    $objDragIn.node.removeClass(this.options.cssClass + '-overDrop');
  },

  dropComplete: function ($objDragOut, $objDragIn) {
    // Redefinimos posiciones
    var $tmp = {};
    $tmp = $objDragOut.backPos;
    $objDragOut.backPos = $objDragIn.backPos;
    $objDragIn.backPos = $tmp;

    // Intercambiamos posiciones en this.orderIndDrag y en los drags.indDrop
    $tmp = $objDragOut.indDrop;
    $objDragOut.indDrop = $objDragIn.indDrop;
    $objDragIn.indDrop = $tmp;
    this.orderIndDrag[$objDragOut.ind] = $objDragOut.indDrop;
    this.orderIndDrag[$objDragIn.ind] = $objDragIn.indDrop;

    // Llamamos a funcion leaveOverDrag, para definir los CSS
    this.leaveOverDrag ($objDragOut, $objDragIn);
    this.rebuildWord();


    this.sendToBack ($objDragIn);
    this.sendToBack ($objDragOut);
    this.fireEvent ('swap', [$objDragOut, $objDragIn]);
    if (this.initWord == this.word4Drags) this.fireEvent ('wordOk', this.initWord);
  },

  fncTrueDrop: function () {
    return true;
  },
  rebuildWord: function () {
    this.word4Drags = '';
    this.elDrags.each (function ($objDrag, $iOB){

      this.word4Drags = this.word4Drags + this.elDrags[this.orderIndDrag.indexOf($iOB)].text;
    }, this);
  }
});