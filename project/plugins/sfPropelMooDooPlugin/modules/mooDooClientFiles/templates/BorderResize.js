/*
---

script: BorderResize.js

description:

license: MIT-style license

authors:
- Damian Suarez

requires:

provides: [BorderResize]

*/

var BorderResize = new Class({

	Implements: [Events, Options],

	options: {/*
    onEnterToResize: $empty(thisElement),
		onBeforeStart: $empty(thisElement),
		onStart: $empty(thisElement, event),
		onResize: $empty(thisElement, event),
		onCancel: $empty(thisElement),
		onComplete: $empty(thisElement, event),*/
		snap: 6,
		unit: 'px',
		grid: false,
		/*style: true,*/
		//limit: false,
		/*handle: false,*/
    boxLimit: {
      x: [100, 600],
      y: [100, 600]
    },
		preventDefault: true,
		stopPropagation: true,
    umbral: [0, 10],
		modifiers: {x: 'width', y: 'height'},
    positioned: {x: 'left', y: 'top'},
    sidesAllow: {
      left: true,
      right: true,
      top: true,
      bottom: true
    },
    cursorDecorate: true,
    borderDecorate: true,
    borderStyles: {
      'border-color': '#06A',
      'border-style': 'dashed'/*,
      'border-width': 5*/
    }
	},

	initialize: function(){
		var params = Array.link(arguments, {'options': Object.type, 'element': $defined});
		this.element = document.id(params.element);

		this.document = this.element.getDocument();

		this.setOptions(params.options || {});

		this.mouse = {'now': {}, 'start': {}, delta: {}};

    this.dims = {real: {}, normal: {}};
    this.pos = {'abs': {}, 'rel': {}};

    this.setBordersAllow();

    this.catchTo = {axis: {x: false, y: false}, border: {x: false, y: false}};
    this.border = {inside: false, x:{}, y:{}}

    this.boxLimit = this.getOption('boxLimit');

    this.allowResize = false;
    this.previousCursor = false;

		this.selection = (Browser.Engine.trident) ? 'selectstart' : 'mousedown';

		this.bound = {
      over: this.mouseOver.bind(this),
      leave: this.mouseLeave.bind(this),
			start: this.start.bind(this),
			check: this.check.bind(this),
			resize: this.resize.bind(this),
			stop: this.stop.bind(this),
			cancel: this.cancel.bind(this),
			eventStop: $lambda(false)
		};


    if(this.getOption('borderDecorate') || this.getOption('cursorDecorate')) {
      this.borderDecorate = false;
      this.cursorDecorate = false;
      
      if (this.getOption('borderDecorate')) {
        this.borderDecorate = true;
        this.styles = {x: [{}, {}], y: [{}, {}], nx: [{}, {}], ny: [{}, {}]};
        for (var style in this.getOption('borderStyles')){
          var ax, stlBase, getStl;
          ['top', 'left', 'bottom', 'right'].each (function (border, iB){
            stlBase = 'border-'+style.split('-')[1]
            getStl = 'border-'+border+'-'+style.split('-')[1];
            ax = (iB%2) ? 'x' : 'y';
            this.styles[ax][(iB/2).toInt()][getStl] = this.element.getStyle(getStl);
            this.styles['n'+ax][(iB/2).toInt()][getStl] = this.getOption('borderStyles')[stlBase];
          }, this)
        }
      }
      
      if (this.getOption('cursorDecorate')) {
        this.cursorDecorate = true;
        this.cssCursor = ['nw', 'n', 'ne', 'w', false, 'e', 'sw', 's', 'se'];
      }

      this.addEvent('changeBorder', this.decorate.bind(this));
    }

    this.attachOver();
	},

  attachOver: function () {
    this.recalc();
    this.element.addEvent('mouseleave', this.bound.leave);
    this.element.addEvent('mousemove', this.bound.over);

    this.attach();
    return;
  },

  detachOver: function () {
    ////console.debug ('detachOver');

    this.element.removeEvent('mouseleave', this.bound.leave);
    this.element.removeEvent('mousemove', this.bound.over);
    return this;
  },

  recalc: function () {

    this.dims.real = this.element.getSize();
    this.dims.normal.x = this.element.getStyle('width').toInt();
    this.dims.normal.y = this.element.getStyle('height').toInt();
    
    this.pos.abs = this.element.getPosition();

    this.pos.rel.x = this.element.getStyle('left').toInt();
    this.pos.rel.y = this.element.getStyle('top').toInt();
  },

  mouseOver: function (event) {
    if (!this.needRecalc) {
      this.needRecalc = true;
      //this.element.addEvent('mouseleave', this.bound.leave);
      //console.debug ('recalc ...');
      this.recalc();
    }
    var coors = {}, cursor = 5;

    for (var z in this.options.modifiers){
      coors[z] = event.page[z] - this.pos.abs[z];

      if ((coors[z] < this.options.umbral[1] && coors[z] > this.options.umbral[0]) && this.allow[z][0]) this.catchTo.axis[z] = -1
      else if ((coors[z] > this.dims.real[z] - this.options.umbral[1] && coors[z] < this.dims.real[z] - this.options.umbral[0]) && this.allow[z][1]) this.catchTo.axis[z] = 1
      else this.catchTo.axis[z] = false
    }

    cursor = (this.catchTo.axis.x + this.catchTo.axis.y*3) + 4;

    this.catchTo.border.x = ['left', false, 'right'][this.catchTo.axis.x + 1];
    this.catchTo.border.y = ['top', false, 'bottom'][this.catchTo.axis.y + 1];

    this.allowResize = (this.catchTo.axis.x || this.catchTo.axis.y) ? true : false;

    this.setEventsToReady(cursor);
  },

  mouseLeave: function (ev){
    //console.debug ('mouseLeave');
    //this.element.removeEvent('mouseleave', this.bound.leave);
    this.needRecalc = false;

    this.fireEvent('leave', this.element);
    var b = this.border;

    b.x.enterAx = false;
    b.y.enterAx = false;

    b.x.enter = false;
    b.y.enter = false;

    for (var z in this.options.modifiers){
      b[z].change = true;

      b[z].leaveAx = this.catchTo.axis[z];
      b[z].leave = this.catchTo.border[z];
    }

    this.fireEvent('changeBorder', [false, this.previousCursor, b]);

    this.previousCursor = false;
    b.x.leaveAx = false;
    b.y.leaveAx = false;
    b.x.leave = false;
    b.y.leave = false;
    this.border.inside = false;    
  },

  setEventsToReady: function (cursor) {

    if (cursor - 4) {
      if (!this.border.inside) {
        this.fireEvent('enter', this.element);
        this.border.inside = true;
      }
    }
    else if (this.previousCursor != 4) {
      this.fireEvent('leave', this.element);
      this.border.inside = false;
    }

    // onChangeCursor
    if (cursor !== this.previousCursor) {

      for (var z in this.options.modifiers){

        if (this.border[z].enterAx != this.catchTo.axis[z]) {
          this.border[z].change = true;

          this.border[z].leaveAx = this.border[z].enterAx;
          this.border[z].leave = this.border[z].enter;

          this.border[z].enterAx = this.catchTo.axis[z];
          this.border[z].enter = this.catchTo.border[z];

        } else {
          this.border[z].change = false;
        }
      }

      this.fireEvent('changeBorder', [cursor, this.previousCursor, this.border]);
      this.previousCursor = cursor;
    }
  },

	attach: function(){
    this.element.addEvent('mousedown', function (event){
      if (this.allowResize) {
        this.bound.start(event);
        
      }
    }.bind(this));
		return this;
	},

	detach: function(){
		this.element.removeEvent('mousedown', this.bound.start);
		return this;
	},

	start: function(event){
		if (event.rightClick) return;

    this.detachOver();

		if (this.options.preventDefault) event.preventDefault();
		if (this.options.stopPropagation) event.stopPropagation();

		this.mouse.start = event.page;
    this.mouse.delta = {x:0, y: 0}

		this.fireEvent('beforeStart', this.element);

    var limit = this.options.limit;
		this.limit = {x: [], y: []};

		for (var z in this.options.modifiers){
			if (!this.options.modifiers[z]) continue;
      /*
      if (limit && limit[z]){
				for (var i = 2; i--; i){
					if ($chk(limit[z][i])) this.limit[z][i] = $lambda(limit[z][i])();
				}
			}
      */
		}

		if ($type(this.options.grid) == 'number') this.options.grid = {x: this.options.grid, y: this.options.grid};
		this.document.addEvents({mousemove: this.bound.check, mouseup: this.bound.cancel});
		this.document.addEvent(this.selection, this.bound.eventStop);
	},

	check: function(event){
		if (this.options.preventDefault) event.preventDefault();
		var distance = Math.round(Math.sqrt(Math.pow(event.page.x - this.mouse.start.x, 2) + Math.pow(event.page.y - this.mouse.start.y, 2)));
		if (distance > this.options.snap){
			this.cancel();
			this.document.addEvents({
				mousemove: this.bound.resize,
				mouseup: this.bound.stop
			});
			this.fireEvent('start', [this.element, event, this.catchTo]).fireEvent('snap', this.element);
		}
	},

	resize: function(event){
		if (this.options.preventDefault) event.preventDefault();
		this.mouse.now = event.page;

		for (var z in this.options.modifiers){
			if (!this.options.modifiers[z]) continue;

      this.mouse.delta[z] = this.mouse.now[z] - this.mouse.start[z];

      /*
			if (this.options.limit && this.limit[z]){
				if ($chk(this.limit[z][1]) && (this.value.now[z] > this.limit[z][1])){
					this.value.now[z] = this.limit[z][1];
				} else if ($chk(this.limit[z][0]) && (this.value.now[z] < this.limit[z][0])){
					this.value.now[z] = this.limit[z][0];
				}
			}*/

			if (this.options.grid[z]) this.value.now[z] -= ((this.value.now[z] - (this.limit[z][0]||0)) % this.options.grid[z]);
		}
    this.redims(this.mouse.delta);
	},

  redims: function (delta) {
    for (var z in this.options.modifiers){
      if (this.catchTo.axis[z]) {
        var lam = this.dims.normal[z] - delta[z]*((this.catchTo.axis[z] > 0) ? (-1) : 1);

        if (lam < this.boxLimit[z][0] || lam > this.boxLimit[z][1]) {
          //this.stop();
          this.fireEvent('limit');
          return false
        }
        this.element.setStyle(this.options.modifiers[z], lam + this.options.unit);

        if (this.catchTo.axis[z] < 0) {
          this.element.setStyle(this.options.positioned[z], this.pos.rel[z] + delta[z] + this.options.unit);
        }

        this.fireEvent('resize', [delta, this.catchTo]);
      }
    }
  },

	cancel: function(event){
		this.document.removeEvent('mousemove', this.bound.check);
		this.document.removeEvent('mouseup', this.bound.cancel);
		if (event){
			this.document.removeEvent(this.selection, this.bound.eventStop);
			this.fireEvent('cancel', this.element);

      // add event Over
      this.attachOver();
		}
	},

	stop: function(event){

		this.document.removeEvent(this.selection, this.bound.eventStop);
		this.document.removeEvent('mousemove', this.bound.resize);
		this.document.removeEvent('mouseup', this.bound.stop);
		if (event) this.fireEvent('complete', [this.element, event]);

    // add event Over
    this.attachOver();
	},

  decorate: function (cursorIn, cursorOut, border){
    // styles in borders
    if(this.borderDecorate)  {
      for (var z in this.options.modifiers){
        if (border[z].change) {
          var indI = (border[z].enterAx) ? (border[z].enterAx+1)/2 : false;
          var indO = (border[z].leaveAx) ? (border[z].leaveAx+1)/2 : false;

          if (indI !== false) this.element.setStyles(this.styles['n'+z][indI]);
          if (indO !== false) this.element.setStyles(this.styles[z][indO]);
        }
      }
    }
    if(this.cursorDecorate) this.element.setStyle('cursor', (this.cssCursor[cursorIn]) ? this.cssCursor[cursorIn]+'-resize' : 'auto');
  },

  setBordersAllow: function (options) {
    var allow = $merge(this.getOption('sidesAllow'), options);
    if ($type(allow) == 'boolean') this.allow = {x:[allow, allow], y:[allow, allow]};
    else if ($type(allow) == 'object') this.allow = {x:[allow.left, allow.right], y:[allow.top, allow.bottom]};
  }
});