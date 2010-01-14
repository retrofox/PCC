// JsonData Actions list
  var $jsonDataObjActionsList = new Array ();
    $jsonDataObjActionsList = {
      global: {
        update: '_new'
      },
      objects: [
  <?php foreach ($pager->getResults() as $i => $producto): ?>
      <?php include_partial('producto/data_json-list_actions', array('producto' => $producto, 'helper' => $helper, 'line' => $i)) ?>
    <?php endforeach; ?>
 ]};