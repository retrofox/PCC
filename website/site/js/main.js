window.addEvent('domready', function() {

/* console.debug('toggler, iT -> ', number_active);

/*var togglers = $('menu_interior').getChildren('li'), number_active;
  togglers.each (function (toggler, iT){
    console.debug('toggler, iT -> ', toggler.hasClass('active'), iT);

    if (toggler.hasClass('active')) {
      number_active = iT;
    }
  })

  console.debug('number_active -> ', number_active);

  console.debug('togglers -> ', togglers);*/

	//create our Accordion instance
	var myAccordion = new Accordion($('leftnavcontainer'), 'li.toggler', 'ul.bloque', {
		opacity: false,
		show: number_active,
		alwaysHide: false,
    initialDisplayFx: false,
		onActive: function(toggler, element){
			toggler.addClass('toggler-active');
		},
		onBackground: function(toggler, element){
			toggler.removeClass('toggler-active');
		}
                
               


	});

});