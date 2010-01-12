window.addEvent ('domready', function () {

	var $sfAdminContainer = $('sf_admin_container');
	var sfAdminContent = $('sf_admin_content');
	
	// Buscamos botones para renderizar
	render_behavior_buttons ($$('body')[0], '.btn110, .btn24x24, .btn-action, .btn_admin_actions, .btn_admin_filters');



	/**************************************
	 * Filtros del listado del generator. *
	 **************************************/
	var btnToggleFilerSlide = $('toggleFilerSlide');
	var btnFilterOn = $('btnFilterOn');
	var btnFilterOff = $('btnFilterOff');
	var btnSubmit = $('sf_admin_batch_actions_choice_go');
	
	
	var chkSelectAll = $('sf_admin_list_batch_checkboxAll');
	var chkSelectInvert = $('sf_admin_list_batch_checkboxInvert');

	var sfAdminFilerForm = $('sf_admin_filter_form'); 			// Formulario de filtros
	var sfAdminContentForm = $('sf_admin_content_form');		// Formulario de Batch

	// Efecto de Slide de la solapa de los filtros
	var filterSlide = new Fx.Slide('sf_admin_filter_slide', {
		onComplete: function () {
			if (this.open) {
				btnToggleFilerSlide.getElement('div').addClass('icn-flecha-arriba');
				btnToggleFilerSlide.getElement('div').removeClass('icn-flecha-abajo');
			}
			else {
				btnToggleFilerSlide.getElement('div').addClass('icn-flecha-abajo');
				btnToggleFilerSlide.getElement('div').removeClass('icn-flecha-arriba');
			}
		}
	});

	// Escondemos el slide
	filterSlide.hide();

	// Comportamiento de boton de toggle para la solapa del filtro
	btnToggleFilerSlide.addEvent ('mousedown', function (e) {
		//e.stop();
		filterSlide.toggle();
	});

	// envío del filtro del list
	btnFilterOn.addEvent ('click', function (e) {
		//e.stop();
		sfAdminFilerForm.submit();
	});

	// Disparamos el formulario tambien cuando apretamos 'Enter' en campo de formulario
	sfAdminFilerForm.addEvent ('keydown', function (e){
		if (e.code == 13) btnFilterOn.fireEvent('click', e);
	});

	/* Implementamos de otra manera el reset de formulario
	 * La idea es la misma que la usada por symfony 1.2.1, que es crear un formulario mediante DOM y llamar el script PHP actual (modulo/accion) 
	 * pero con el fomulario vacio (con metodo POST).
	 * Esto hace que se 'limpien' los filtros.
	 */
	btnFilterOff.addEvent ('click', function (e) {
		e.stop();
		var f = document.createElement('form');
		f.style.display = 'none';
		this.parentNode.appendChild(f);
		f.method = 'POST';
		f.action = this.get('hrefreset');
		f.submit();
	});
	/** Fin Filtros del Listado **/


	/************************
	 * Acciones del Listado *
	 ************************/
	// Todos los checkboxs del list
	var checks = sfAdminContent.getElements('table tbody input[type=checkbox]');
	
	// Limpiamos los botones
	if (chkSelectAll != null) {
		chkSelectInvert.setProperty ('checked', '');											// desCheck
		// Boton selecciona/deselecciona Todo
		chkSelectAll.addEvent ('click', function (e){
			checks.each (function (check, iC) {
				check.setProperty ('checked', chkSelectAll.getProperty ('checked'));
			});
		});
		chkSelectAll.setProperty('checked', '');
	}

	if (chkSelectInvert != null) {
		chkSelectInvert.setProperty('checked', '');
		// Boton invierte seleccion
		chkSelectInvert.addEvent ('click', function (e){
			checks.each (function (check, iC) {
				var chkState = (check.getProperty ('checked')) ? '' : 'checked';
				check.setProperty ('checked', chkState);
			});
		});
	}

	checks.each (function (check, iC) {
		check.setProperty ('checked', '');
	});

	// Boton Submit
	btnSubmit.addEvent ('click', function (e) {
		e.stop()
		sfAdminContentForm.submit();
	});
	/** fin Acciones del Formulario **/


	/***************************
	 * Acciones td del listado *
	 ***************************/
	var $btnsActions = sfAdminContent.getElements('.sf_admin_list td.sf_admin_td_actions div.btn-action');
	var $blqsActions = sfAdminContent.getElements('.sf_admin_list td.sf_admin_td_actions ul.sf_admin_ul_actions');
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


	/********************************************
	 * Efecto hover sobre las filas del listado *
	 ********************************************/
	var $rows = sfAdminContent.getElements('.sf_admin_list tr.sf_admin_row');
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
	/*********************************
	 * Ventana Principal de Mensajes *
	 *********************************/
	var $vtnMainError = $sfAdminContainer.getElements ('div.error');
	if ($vtnMainError != '') {
		var $btnFlashError = $('btn_flash_error');

		// Construimos ventana de bloqueo
		var $vtnDims = $sfAdminContainer.getStyles ('height', 'width');
		var $vtnContainerBlock = new Element('div', {
			'class': 'blk_sf_admin_container',
			'styles': $vtnDims
		});

		$vtnContainerBlock.setStyle ('opacity', 0.3);
		$vtnContainerBlock.inject($sfAdminContainer, 'top');

		$vtnMainError.setStyles ($vtnDims);
		
		// Boton de Cerrar
		$btnFlashError.addEvent ('click', function (e) {
			e.stop;
			$vtnContainerBlock.destroy();
			$vtnMainError.destroy();
		});
	}
	/** fin Ventana Principal de Errores **/

});