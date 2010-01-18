var menuIsActive = false;
var $jsonDataMenuLinks = new Array ();

$jsonDataMenuLinks = [
  {type: 'ajax_link', link: '/sfGuardUser/new', update: '_new', winClass: 'sfPropelNew'},
  {type: 'ajax_link', link: '/sfGuardUser', link_content: '/sfGuardUser/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  {},
  {type: 'ajax_link', link: '/sfGuardGroup/new', update: '_new', winClass: 'sfPropelNew'},
  {type: 'ajax_link', link: '/sfGuardGroup', link_content: '/sfGuardGroup/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  {},
  {type: 'ajax_link', link: '/sfGuardPermission/new', update: '_new', winClass: 'sfPropelNew'},
  {type: 'ajax_link', link: '/sfGuardPermission', link_content: '/sfGuardPermission/index?win_container=true', update: '_new', winClass: 'sfPropelList'},

  {type: 'ajax_link', link: '/producto/new', update: '_new', winClass: 'sfPropelNew'},
  {type: 'ajax_link', link: '/producto', link_content: '/producto/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  {},
  {type: 'ajax_link', link: '/producto_categoria', link_content: '/producto_categoria/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  {type: 'ajax_link', link: '/producto_udm', link_content: '/producto_udm/index?win_container=true', update: '_new', winClass: 'sfPropelList'},

  {type: 'ajax_link', link: '/proveedor/new', update: '_new', winClass: 'sfPropelNew'},
  {type: 'ajax_link', link: '/proveedor', link_content: '/proveedor/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  {},
  {type: 'ajax_link', link: '/proveedor_rubro', link_content: '/proveedor_rubro/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  
  {type: 'ajax_link', link: '/evento', link_content: '/nota_pedido/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  {type: 'ajax_link', link: '/compra', link_content: '/nota_pedido/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  {type: 'ajax_link', link: '/venta', link_content: '/nota_pedido/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  {},
  {type: 'ajax_link', link: '/nota_pedido', link_content: '/nota_pedido/index?win_container=true', update: '_new', winClass: 'sfPropelList'},
  {type: 'ajax_link', link: '/recepcion_pedido', link_content: '/recepcion_pedido/index?win_container=true', update: '_new', winClass: 'sfPropelList'}
]