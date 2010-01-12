// JsonData Actions list
  var $jsonDataObjActionsList = new Array ();
    $jsonDataObjActionsList = {
      global: {
        update: '_new'
      },
      objects: [
  <?php foreach ($pager->getResults() as $i => $compra): ?>
      <?php include_partial('compra/data_json-list_actions', array('compra' => $compra, 'helper' => $helper, 'line' => $i)) ?>
    <?php endforeach; ?>
 ]};