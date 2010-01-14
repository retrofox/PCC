// JsonData Actions list
  var $jsonDataObjActionsList = new Array ();
    $jsonDataObjActionsList = {
      global: {
        update: '_new'
      },
      objects: [
  <?php foreach ($pager->getResults() as $i => $producto_categoria): ?>
      <?php include_partial('producto_categoria/data_json-list_actions', array('producto_categoria' => $producto_categoria, 'helper' => $helper, 'line' => $i)) ?>
    <?php endforeach; ?>
 ]};