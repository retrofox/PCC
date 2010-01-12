/*
 Script: dxd-1.2-class.js
 autor: Damian Suarez
 email: damian.suarez@xifox.net
 Contiene las clases <DxD.Move>
 Class: mooWin
 Clase para crear ventanas utilizando codigo HTML, CSS y JS
 Note:
 DxD.Base requiere un doctype XHTML.
 License:
 Licencia MIT-style.
 
 Argumentos:
 */
var mooWin = new Class({
    //Extends: Drag.Move,
    
    Implements: [Events, Options],
    options: {
        title: 'Pudu', // Titulo de la Ventana.
        url2Ajax: '', // enlace con el cual se hace la peticion con AJAX
        nodeInf: '_parent',
        cssPrefix: 'mooWin',
        fullComplete: true,
        box: [300, 200, 30, 30],
        
        renderWin: true,
        container: 'content', // nombre del nodo en el cual se injecta la ventana si es que no se ha definido la propiedad update.
        tagHTML: 'div', // Esta propiedad se utiliza si se debe construir el nodo de la ventana.
        tagHeaderWin: 'h1' // Idem anterior. Es el tag html del header de la ventana.
    },
    
    initialize: function($linkNode, options){
        //this.parent($linkNode, options);
        this.setOptions(options);
        
        // Configuraciones iniciales
        this.optionsControl($linkNode);
        
        // si this.node no esta definido en un metodo hijo hacemos el control de nodo
        if (!this.node) 
            this.nodeControl(); // Control de nodo HTML
        // Controlamos propiedades de dimension
        this.dimsControl();
        
        if (this.ajaxControl()) 
            this.createAjaxConex(); // Control conexión con AJAX
        //this.makeWin();
        
        // Creamos ventana siempre y cuando tengamos respuesta de AJAX.
        this.addEvent('ajaxReady', this.makeWin.bind(this));
    },
    
    optionsControl: function($linkNode){
        // Seteamos url2Ajax como propiedades de this.options
        if (this.options.url2Ajax == '') 
            this.options.url2Ajax = $linkNode.get('ajax_link');
			//console.log (this.options.url2Ajax);
    },

    /*
     * nodeControl. Controlamos la referencia al nodo HTML (this.node).
     * Si el nodo no existe se crea uno nuevo y se injecta dentro del parametro definido como this.options.container. Por defecto este vaor es 'content'.
     * Si el nodo se crea, inicialmente se aplica display :none ... ??
     */
    nodeControl: function(){
        // Definimos propiedad que contiene la referencia al nodo HTML
        // Que hacemos si el nodo no existe ?
        
        if ($(this.options.update) == null) {
            // Creamos un nuevo elemento
            this.node = new Element(this.options.tagHTML, {
                'id': this.options.update,
                'class': this.options.cssPrefix
            });
            
            // Insertamos el Nodo dentro del documento.
            (this.node).inject($(this.options.container));
        }
        
        else {
            // El nodo existe
            
            // Definimos propiedad de objeto que contiene el nodo html de la ventana
            this.node = $(this.options.update);
            
            /* Buscamos si el nodo tiene definido dimension y posicionamiento.
             * A veces el nodo contenedor suele tener definido, en formato JSON, la dimension y posicion del nodo.
             */
            // Si el nodo ya existe no renderizamos una ventana
            //this.options.renderWin = false;
        };
        
            },
    
    /*
     * Con este método controlamos si están definidas las dimensiones de la win en el nodo contenedor
     */
    dimsControl: function(){
        if (this.node.get('options')) {
            var dims = JSON.decode(this.node.get('options')).box.split('x');
            dims.each(function(dim, iD){
                dims[iD] = dim.toInt()
            });
            this.options.box = dims;
        }
    },
    
    /*
     * Method: ajaxControl()
     * En este control vamos a ver si existe una petición por AJAX ...
     * o en realidad el código HTML viene dentro del mismo codigo HTML de la pagina
     */
    ajaxControl: function(){
        // Generanmos conexion con AJAX si es que tenemos definido
        return true
    },
    
    // Conexion con el server a traves de AJAX
    createAjaxConex: function(){
    
        // Abrimos conexion AJAX
        this.ajaxConex = new Request.HTML({
            url: this.options.url2Ajax,
            onFailure: function($xhr){
                $(this.options.container).set('html', $xhr.responseText);
            }.bind(this)            ,
            
            onSuccess: function(tree, elems, html, js){
                // guardamos respuesta de AJAX en el objeto.
                this.ajaxResponse(tree, elems, html, js);
                
                // Disparamos eventos ...
                this.fireEvent('ajaxReady', this);
            }.bind(this)
        });
        
        // Enviamos Peticion
        this.ajaxConex.send();
        
    },
    
    
    // Acciones de procesamiento luego de la respuesta en AJAX.
    ajaxResponse: function(tree, elems, html, js){
    
        /*
         // Imprimimos respuesta en ventana nueva ?
         if (this.options.renderWin) {
         if (elems[0].get ('tag') != this.options.tagHeaderWin) html = '<'+this.options.tagHeaderWin+'>' + this.options.title + '</'+this.options.tagHeaderWin+'>' + html;
         this.node.set({
         'html': html
         });
         }
         else {
         this.node.set({
         'html': html
         });
         };
         */
        // Imprimimos respuesta en ventana nueva ?
        if (this.options.renderWin) {
        
            // Acá hay que hacer todo el procesamiento de la ventana .. por ejemplo, agregarlos los nodos de botones, resimension, etc.
            // Buscamos componentes de la ventana en respuesta de AJAX (mmm ... muy experimental).
            //if (elems[0].get ('tag') != this.options.tagHeaderWin) html = '<'+this.options.tagHeaderWin+'>' + this.options.title + '</'+this.options.tagHeaderWin+'>' + html;
            this.node.set({
                'html': html
            });
            
            // Mostramos ventana
            this.renderWin(tree, elems, html, js);
            
        };
        
            },
    
    /*
     * Renderizamos la respuesta llamando a funciones que vienen definidas en el html de la respuesta de AJAX.
     * Por convencion, esto viene en el PRIMER nodo de la respuesta
     */
    renderWin: function(){
        if (this.node.getElement('.win_feedback')) {
            $renderFunctios = (JSON.decode(this.node.getElement('.win_feedback').get('text')).render_functions);
            $renderFunctios.each(function($renderFunction, $iRf){
                $strExecute = $renderFunction.name + '(' + $renderFunction.args + '); ';
                eval($strExecute);
            });
        }
    },
    
    /*
     * Con este metodo mostramos la ventana
     */
    show: function(){
        // Mostramos el nodo de la ventana.
        this.node.setStyle('display', 'block');
    },
    
    hide: function(){
        this.node.setStyle('display', 'none');
    },
    
    fadeIn: function(){
        this.node.content.setStyle('visibility', 'hidden');
        this.node.setOpacity(0.6);
    },
    
    fadeOut: function(){
        this.node.content.setStyle('visibility', 'visible');
        this.node.setOpacity(1);
    },
    
    hideAndContentDestroy: function(){
        this.hide();
        this.contentDestroy();
    },
    
    contentDestroy: function(){
        this.node.empty();
    },
    
    destroy: function(){
        this.node.destroy();
    },
	
	refresh: function () {
		this.ajaxConex.send();
	},
    
    /*
     * Agregamos comportamiento de Ventana
     */
    makeWin: function(win){
        // Definimos estilos Dimensiones de la ventana
        this.node.setStyles({
            //width: this.options.box[0],
            //			height: this.options.box[1],
            left: this.options.box[2],
            top: this.options.box[3]
        });
        
        // Handle viene definido con un nodo con propiedad css '.win_handle.'
        this.node.handle = this.node.getElements('.win_handle');
        
        this.dragMove = new Drag.Move(this.node, {
            container: this.options.container,
            handle: this.node.handle,
            
            onStart: function(e){
                this.fadeIn();
            }.bind(this)            ,
            
            onComplete: function(e){
                this.fadeOut();
            }.bind(this)            ,
            
            onDrop: function(element, droppable){
                /*				if (!droppable) 
                 console.log(element, ' dropped on nothing');
                 else
                 console.log(element, 'dropped on', droppable);
                 */
            },
            
            onEnter: function(element, droppable){
                //console.log(element, 'entered', droppable);
            },
            
            onLeave: function(element, droppable){
                //console.log(element, 'left', droppable);
            }
        });
        
        // Insertamos el Nodo dentro del documento.
        //(this.node).inject(this.options.container);

        // Botones del Header de la ventana
        $winBtns = this.node.getElements('div.win .win_handle ul li');
        $winBtns.each(function($btnWin, $iB){
        
            var bgPos = $btnWin.getStyle('background-position').split(' ');
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
                    if ($btnWin.hasClass('btnHW03')) this.hideAndContentDestroy();
					if ($btnWin.hasClass('btnHW04')) this.refresh();
                }.bind(this)
            });
        }.bind(this));
        
		(function(){
            this.show()
        }.bind(this)).delay(100);
    }
});





/*
 *  Class: mooWin.fromLink
 *  Clase que crea una ventana en funcion de nodo tipo enlace que contiene los valores necesarios para la conexión con AJAX, dimensiones, etc. O sea. un quilombo.
 */
mooWin.fromLink = new Class({
    Extends: mooWin,
    
    Implements: [Events, Options],
    
    options: {
        update: '' // Nodo en el cual se imprime la respuesta del servidor que viene por AJAX.
    },
    
    initialize: function($linkNode){
    
        // Las opciones vienen impresas en un atributo del nodo de link ($linkNode) denominado 'options'; en formato JSON.
        // En la propiedad linkOptions guardamos estas propiedades.
        this.linkOptions = JSON.decode($linkNode.get('options'));
        
        // Control de atributos del $linkNode
        this.linkControl($linkNode);
        
        // Definimos propiedad de objeto this.linkNode
        this.linkNode = $linkNode;
        
        // Llamamos al metodo Padre.
        this.parent($linkNode, this.linkOptions);
        
    },
    
    /*
     * Redefinimos metodo.
     * Si el link que abre la ventana ($nodeLink) contiene opciones (options="{..) de dimension y posicionamiento (box=widthxHeight ...) definimos propiedades this.options.box ...
     * y si no ... llamamos al metodo padre y nos quedamos chitos.
     */
    dimsControl: function(){
    
        // Primero buscamos si esta propiedad viene en el link
        if (this.linkOptions.box != null) {
            // Para las dimensiones y posicion de la ventana usamos box: 'width'x'height'x'left'x'top'
            var dims = this.linkOptions.box.split('x');
            dims.each(function(dim, iD){
                dims[iD] = dim.toInt()
            });
            this.options.box = dims;
        }
        else {
            this.parent();
        }
    },
    
    linkControl: function($linkNode){
        // La propiedad this.linkOptions.update es una de las mas importates ya que define desde el nodo link disparador $linkNode ...
        // ... el nodo al cual sera impreso la respuesta de server por ajax.
        // Si el valor 'update' que viene dentro del atributo 'options' no esta definido ...
        if (this.linkOptions.update == undefined) {
            // Definimos propiedad que apunta el nodo update
            
            // Queda requete pendiente....
            // Por convencion ... si no esta definido el valor del 'update' ...
            // ... usamos el valor de la URL como identificador 'id'
            this.options.update = this.linkOptions.url;
            
            // Armamos nueva cadena JSON
            var opciones = JSON.encode(this.linkOptions);
            
            // Seteamos propiedad
            $linkNode.setProperty('options', opciones);
            
        }
        else {
            // copiamos esta configuracion dentro de las opiones de la ventana.
            this.options.update = this.linkOptions.update;
        };
            }
});









/*
 *  Class: mooWin.vtnEdit
 */
mooWin.vtnEdit = new Class({
    Extends: mooWin.fromLink,
    
    Implements: [Events, Options],
    
    options: {},
    
    initialize: function($linkNode){
        // Llamamos al metodo Padre.
        this.parent($linkNode);
    },
    
    /*
     * Renderiza la ventana con las opciones y elementos comunes de una ventana de Edicion.
     * Este metodo se dispara autamaticamente cuando el AJAX se ha cargado correctamente.
     */
    renderWin: function(tree, elems, html, js){
        //console.log ('renderWin en mooWin.vtnEdit: ', this.node.msgWinContent);
        
        // Nodos relevantes de una win
        this.node.content = this.node.getElement('.win_content');
        this.node.footer = this.node.getElement('.win_footer');
        this.node.msgWinContent = this.node.getElement('.win_msg_content');

        // Renderizamos comportamiento comun de todo boton que se precio de serlo
        render_behavior_buttons(this.node.footer, '.btn_admin_actions');
		
        // Widget selectWithAdd ?
        if (this.node.content.getElement('table.select_with_add')) this.addSelectWithAdd();
        this.renderWinContent();
    },
    
    /* Renderiza solo el contenido de la ventana, que es casi todo */
    renderWinContent: function(){
		
		//console.log (this.node);

	/********************************************
	 * Efecto hover sobre las filas del listado *
	 ********************************************/
	var $rows = this.node.content.getElements('tr.sf_admin_row');
	$rows.each (function ($row, $iR){
		$row.addEvents ({
			'mouseenter': function (e) {
				this.addClass('sf_admin_row-hover');
			},
			'mouseleave': function (e) {
				this.removeClass('sf_admin_row-hover');
			}
		})
	}, this);




	/***************************
	 * Acciones td del listado *
	 ***************************/
	var $btnsActions = this.node.content.getElements('td.sf_admin_td_actions div.btn-action');
	var $blqsActions = this.node.content.getElements('td.sf_admin_td_actions ul.sf_admin_ul_actions');
//	var $isVisibled = true;

	$btnsActions.each (function ($btn, $iB) {
		var $btnActionsLi = $blqsActions[$iB].getElements ('li');
		var $sfAdminListTdActionsForm = $('sf_admin_list_td_actions_form');

		$btnActionsLi.each (function ($btnLi, $iL) {
            $btnLi.addEvents ({
                'mouseenter': function () {
                    $btnLi.addClass('btn_object_action-hover');
                },
                'mouseleave': function () {
                    $btnLi.removeClass('btn_object_action-hover');
                },
                'mousedown': function () {
                    $btnLi.addClass('btn_object_action-down');
                },
                'mouseup': function () {
                    $btnLi.removeClass('btn_object_action-down');
                }
            });

			if ($btnLi.get('link_delete')) {
				$btnLi.addEvent ('click', function (e) {
				/*
				 // Script de delete original del generator (1.2.1)
				 if (confirm('Are you sure?')) {
				 	var f = document.createElement('form');
				 	f.style.display = 'none';
				 	this.parentNode.appendChild(f);
				 	f.method = 'POST';
				 	f.action = this.href;
				 	var m = document.createElement('input');
				 	m.setAttribute('type', 'hidden');
				 	m.setAttribute('name', 'sf_method');
				 	m.setAttribute('value', 'delete');
				 	f.appendChild(m);
				 	f.submit();
				 };
				 return false;
				 */
					if (confirm($btnLi.getProperty('msg'))) {
						$sfAdminListTdActionsForm.setProperty('action', $btnLi.getProperty('link_delete'));
						$sfAdminListTdActionsForm.submit();
					}
				});
			};
		});

		$btn.addEvents ({
			'mousedown': function (e) {
				$blqsActions[$iB].setStyle('display', 'block');
			}
		});

		$blqsActions[$iB].addEvents ({
			'mouseleave': function (e) {
				//e.stop();
				$blqsActions[$iB].setStyle ('display', 'none');
			}
		})
	});

		
        // Botones de acciones del footer de una Win
        var $btns;
		// Accordion para los fieldset ?
		if (this.node.content != null) {
			if (this.node.content.getElement('div.winAccordion h2.titleSection')) 
				this.makeAccordion();


			if ($btns = this.node.content.getElements('.btn_admin_actions')) {
				$btns.each(function($btn, $iB){
					$btn.addEvent('click', function(){

						// Boton para cerrar ventana
						if ($btn.get('enlace') == 'vtnClose') 
							this.hideAndContentDestroy();
						
						// Borra registro
						if ($link = $btn.get('link_delete')) {
							$deleteForm = this.node.getElement('form.hiddenForm');
							$deleteForm.set('action', $link);
							$deleteForm.set('send', {
								onFailure: function(obj){
									this.node.set('html', obj.responseText);
								}.bind(this)								,
								onComplete: function(response){
									this.node.content.set('html', response);
									this.node.footer.destroy();
									render_behavior_buttons(this.node.content, '.btn_admin_actions');
								}.bind(this)
							});
							$deleteForm.send();
						};
						
						// Graba modificaciones (edit)
						if ($link = $btn.get('link_save')) {
							$saveForm = this.node.getElement('form');
							$saveForm.set('send', {
								onFailure: function(obj){
									this.node.set('html', obj.responseText);
								}.bind(this)								,
								
								onComplete: function(htmlResponse){
									this.node.content.set('html', htmlResponse);
									render_behavior_buttons(this.node.content, '.btn_admin_actions');
									this.renderWinContent();
								}.bind(this)
							});
							$saveForm.send();
						};
					}.bind(this));
				}.bind(this))
			};
		}
	},
	
	// Agregamos comportamiento a lo select definidos con un boton para agregar
	addSelectWithAdd: function () {
		
		// Identificamos los bloques que tengan un selecto con comportamiento Add
		$content2Select = this.node.content.getElements ('table.select_with_add');

		// Recorremos, uno a uno, todos los bloques
		$content2Select.each (function ($selWAdd, $iS) {
			// Botones de cada bloque (3)
			var $btns2Select = $selWAdd.getElements ('.btn24x24');
			
			// Input
			var $input2add = $selWAdd.getElement('input');

			// Select
			var $select2Refresh = $selWAdd.getElement('select');
			
			// winPopUp
			var $winPopUp;

			// Comportamiento de eventos de raton y teclado.
			$btns2Select[0].addEvent ('click', function (e) {
				e.stop();
				$winPopUp = this.getFirst().getFirst();
				$input2add = this.getElement('input');
				$select2Refresh = this.getParent().getElement('select');
				$winPopUp.setStyle('display', 'block');
			});

			// Boton Cancelar
			$btns2Select[1].addEvent ('click', function (e) {
				e.stop();
				$winPopUp.setStyle('display', 'none');
			});

			// Conexion de AJAX
			var addWAjax = new Request.HTML({
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript){
					$select2Refresh.set ('html', responseHTML);
					$winPopUp.setStyle('display', 'none');
				}.bind(this)
			});

			// Boton Agregar
			$btns2Select[2].addEvent ('click', function (e) {
				e.stop();
				addWAjax.options.url = $input2add.get('link_to_add')+'?value='+$input2add.get('value');
				addWAjax.send();
			}.bind(this));

			// Teclas especiales			
			$input2add.addEvent ('keypress', function (e){
				if (e.code == 27) $btns2Select[1].fireEvent('click', e);
				if (e.code == 13) $btns2Select[2].fireEvent('click', e);
			});
		}.bind(this));
	},
	
	makeAccordion: function(){
		this.winAccordion = new Accordion(this.node.content.getElement ('div.winAccordion'), 'h2.titleSection', 'div.fieldSection', {
			show: 0,
			opacity: 0,
			onActive: function(toggler, element){
				toggler.addClass ('titleSection-hover')
			},
			onBackground: function(toggler, element){
				toggler.removeClass ('titleSection-hover')
			}
		});

		// Buscamos errores en cada elemento del accordion Esto tal vz haya que implementarlo del lado del server.
		this.winAccordion.elements.each (function (el, iE) {
			if (el.getElement('.error_list')) this.winAccordion.togglers[iE].setStyle('color', 'red');
		}.bind(this));
	}
});



var DxD = new Class({
    Implements: [Events, Options],
    
    options: {
        adjWins: [],
        autoLevel: true,
        zIndexTop: 1000,
        zIndexBottom: 100
    },
    initialize: function(winS, options){
        this.setOptions(options);
        
        // Ventanas		
        this.winS = [];
        
        // Nodos de las ventanas
        this.winS.nodes = [];
        
        if (winS != undefined) {
            this.winS.extend(winS);
            this.setIni();
        };
    },

	// Construccion de las ventanas    
    setIni: function(){
        // Recorremos todas las ventanas Iniciales
        (this.winS).each(function(win, iW){
            //		console.log (iW);
        });
    },
    
    /*
     * Metodo para agregar una ventana al conjunto de ventanas
     */
    openWin: function(vtn, options){
    },
    
    /*
     * addFromLink: Agregamos una ventana a partir de un link HTML.
     * Utiliza mooWin.fromLink.
     */
    openFromLink: function(link){
    
        // Controlamos datos, estados, etc. de los links ...
        optionsLink = this.linkControl(link);
        
        // Vemos si el nodo no ha sido creado anteriormente
        if ($(optionsLink.update) == null) {
        
            // Creamos objeto tipo Win que ha sido invocada desde un link HTML
            var newWin = new mooWin(link, optionsLink);
            
            // Redefinimos atributo options en link HTML de donde ha sido abierta la ventana
            link.setProperty('options', JSON.encode(optionsLink));
            
            // Antes de agregar el elemento de ventana al arreglo de ventanas ...
            // piespeamos que haya sido agregado antes. Es un control mas ... que se yo.
            if (!this.winS.nodes.contains(newWin.node)) {
                // Se trata de una nueva ventana
                this.winS.nodes.push(newWin.node);
                var ind = this.winS.push(newWin)
                this.winS[ind - 1].ind = ind - 1;
            };
                    };
            },
    
    linkControl: function(link){
        // Las opciones vienen impresas en un atributo del nodo denominado 'options'; en formato JSON
        // Decodificamos
        options = JSON.decode(link.get('options'));
        
        // Si el valor 'update' que viene dentro del atributo 'options' no esta definido ...
        if (options.update == undefined) {
        
            // Definimos propiedad que apunta el nodo update, que ...
            // por convencion, si no esta definido el valor del 'update' ...
            // ... usamos el valor de la URL como identificador 'id'
            options.update = options.url;
            
            // Armamos nueva cadena JSON
            var newOptions = JSON.encode(options);
            
            // Seteamos propiedad en documento html ?
            // link.setProperty ('options', newOptions);
        };
        
        // Para las dimensiones y posicion de la ventana usamos box: 'width'x'height'x'left'x'top'
        var dims = options.box.split('x');
        dims.each(function(dim, iD){
            dims[iD] = dim.toInt()
        });
        options.box = dims;
        
        return options;
    }
});
