<div id="mainMenu">
  <div class="menuLevel0">
    <div class="menuLevel0Header menu01">
      <div class="icn"></div><h3>Usuario</h3>
    </div>
    <div class="menuLevel1Content">
      <div class="menuLevel1">
        <ul class="menu02">
          <li options="{'update':'vtn-menu-add'}" ajax_link="<?php echo url_for ('sfGuardUser/newWin') ?>" class="ajax_btn_to opcionLink"><div class="icn icn-productonuevo"></div>Nueva Cuenta de Usuario</li>
          <li enlace="<?php echo url_for ('sfGuardUser/index') ?>"><div class="icn icn-group"></div>Listado de Cuentas</li>
          <li class="divi01"></li>

          <li options="{'update':'vtn-menu-add'}" ajax_link=" <?php echo url_for('sfGuardGroup/ListNew', array(), 'messages') ?>" class="ajax_btn_to opcionLink"><div class="icn icn-group-add"></div><?php echo __('New Group') ?></li>
          <li enlace="<?php echo url_for ('sfGuardGroup/index') ?>"><div class="icn icn-group-list"></div>Listado de Grupos</li>

          <li class="divi01"></li>
          <li options="{'update':'vtn-menu-add'}" ajax_link=" <?php echo url_for('sfGuardPermission/ListNew', array(), 'messages') ?>" class="ajax_btn_to opcionLink"><div class="icn icn-user-credential"></div><?php echo __('New Permission') ?></li>
          <li enlace="<?php echo url_for ('sfGuardPermission/index') ?>"><div class="icn icn-group-credential"></div>Listado de Credenciales</li>
        </ul>
      </div>
      <div class="sombraBottom">
        <div class="sombraRightBottom"></div>
        <div class="sombraLeftBottom"></div>
      </div>
    </div>
  </div>

  <div class="menuLevel0">
    <div class="menuLevel0Header menu01">
      <div class="icn icn-producto"></div><h3>Productos</h3>
    </div>
    <div class="menuLevel1Content">
      <div class="menuLevel1">
        <ul class="menu02">
          <li options="{'update':'vtn-menu-add'}" ajax_link=" <?php echo url_for('producto/ListNew', array(), 'messages') ?>" class="ajax_btn_to opcionLink"><div class="icn icn-producto-add"></div><?php echo __('Add Product') ?></li>
          <li enlace="<?php echo url_for ('producto') ?>"><div class="icn icn-producto-list"></div>Listado de Productos</li>


          <li class="divi01"></li>
          <li enlace="<?php echo url_for ('producto_categoria') ?>"><div class="icn icn-producto-categoria"></div>Categorías de Productos</li>
          <li enlace="<?php echo url_for ('producto_udm') ?>"><div class="icn icn-producto-udm"></div>Unidades de Medida</li>
        </ul>
      </div>
      <div class="sombraBottom">
        <div class="sombraRightBottom"></div>
        <div class="sombraLeftBottom"></div>
      </div>
    </div>
  </div>

  <div class="menuLevel0">
    <div class="menuLevel0Header menu01">
      <div class="icn icn-proveedor"></div><h3>Proveedores</h3>
    </div>
    <div class="menuLevel1Content">
      <div class="menuLevel1">
        <ul class="menu02">
          <li options="{'update':'vtn-menu-add'}" ajax_link=" <?php echo url_for('proveedor/ListNew', array(), 'messages') ?>" class="ajax_btn_to opcionLink"><div class="icn icn-proveedor-add"></div><?php echo __('Add Supplier') ?></li>
          <li enlace="<?php echo url_for ('proveedor') ?>"><div class="icn icn-proveedor-list"></div>Listado de Proveedores</li>
          <li class="divi01"></li>
          <li enlace="<?php echo url_for ('proveedor_rubro') ?>"><div class="icn icn-proveedor-list"></div>Rubros</li>
        </ul>
      </div>
      <div class="sombraBottom">
        <div class="sombraRightBottom"></div>
        <div class="sombraLeftBottom"></div>
      </div>
    </div>
  </div>

  <div class="menuLevel0">
    <div class="menuLevel0Header menu01">
      <div class="icn icn-stock"></div><h3>Stock</h3>
    </div>
    <div class="menuLevel1Content">
      <div class="menuLevel1">
        <ul class="menu02">

          <li enlace="<?php echo url_for ('evento') ?>"><div class="icn icn-evento"></div>Eventos</li>
          <li enlace="<?php echo url_for ('compra') ?>"><div class="icn icn-comprar"></div>Compras</li>
          <li enlace="<?php echo url_for ('venta') ?>"><div class="icn icn-venta"></div>Ventas</li>
          <li class="divi01"></li>
          <li enlace="<?php echo url_for ('nota_pedido') ?>"><div class="icn icn-nota-pedido"></div>Nota de pedido</li>
          <li enlace="<?php echo url_for ('recepcion_pedido') ?>"><div class="icn icn-recepcion-pedido"></div>Recepción de pedidos</li>
        </ul>
      </div>
      <div class="sombraBottom">
        <div class="sombraRightBottom"></div>
        <div class="sombraLeftBottom"></div>
      </div>
    </div>
  </div>

</div>
