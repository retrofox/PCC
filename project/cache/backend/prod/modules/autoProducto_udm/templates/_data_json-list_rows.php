// JsonData Actions list
  var $jsonDataObjActionsList = new Array ();
    $jsonDataObjActionsList = {
      global: {
        update: '_new'
      },
      objects: [
  <?php foreach ($pager->getResults() as $i => $producto_udm): ?>
      <?php include_partial('producto_udm/data_json-list_actions', array('producto_udm' => $producto_udm, 'helper' => $helper, 'line' => $i)) ?>
    <?php endforeach; ?>
 ]};