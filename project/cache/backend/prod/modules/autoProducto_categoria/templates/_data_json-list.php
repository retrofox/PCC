<script type="text/javascript">
<?php include_partial('producto_categoria/data_json-list_win', array('jsonData4Win' => $jsonData4Win)) ?>

 var $jsonDataBarMenuList = new Array ();
    $jsonDataBarMenuList = [
      {execute: 'this.optFilter'}
    ]

  var $jsonDataFilter = new Array ();
    $jsonDataFilter = [
      {filter: 'filter'},
      {action: '<?php echo moo_json_data_link_to_filters(__('Reset', array(), 'sf_admin'), 'producto_categoria_collection', array('action' => 'filter')) ?>'},
      {cancel: 'cancel'}
    ];

// JsonData Actions list
<?php include_partial('producto_categoria/data_json-list_rows', array('producto_categoria' => $producto_categoria, 'helper' => $helper, 'pager' => $pager)) ?>

// JsonData Actions
var $actions = new Array ();
$actions = [
  <?php echo $helper->mooJsonDataToNew(array(  'label' => 'Nueva',  'inWinPopUp' => true,  'params' =>   array(  ),  'class_suffix' => 'new',)) ?> ]
</script>