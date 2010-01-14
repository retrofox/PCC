<script type="text/javascript">

 var $jsonDataBarMenuList = new Array ();
    $jsonDataBarMenuList = [
      {execute: 'this.optFilter'}
    ]

  var $jsonDataFilter = new Array ();
    $jsonDataFilter = [
      {filter: 'filter'},
      {action: '<?php echo moo_json_data_link_to_filters(__('Reset', array(), 'sf_admin'), 'producto_collection', array('action' => 'filter')) ?>'},
      {cancel: 'cancel'}
    ];

// JsonData Actions list
<?php include_partial('producto/data_json-list_rows', array('producto' => $producto, 'helper' => $helper, 'pager' => $pager)) ?>

// JsonData Actions
var $actions = new Array ();
$actions = [
  <?php echo $helper->mooJsonDataToNew(array(  'inWinPopUp' => true,  'params' =>   array(  ),  'class_suffix' => 'new',  'label' => 'New',)) ?> ]
</script>