<script type="text/javascript">

 var $jsonDataBarMenuList = new Array ();
    $jsonDataBarMenuList = [
      {execute: 'this.optFilter'}
    ]

  var $jsonDataFilter = new Array ();
    $jsonDataFilter = [
      {filter: 'filter'},
      {action: '<?php echo moo_json_data_link_to_filters(__('Reset', array(), 'sf_admin'), 'producto_udm_collection', array('action' => 'filter')) ?>'},
      {cancel: 'cancel'}
    ];

// JsonData Actions list
<?php include_partial('producto_udm/data_json-list_rows', array('producto_udm' => $producto_udm, 'helper' => $helper, 'pager' => $pager)) ?>

// JsonData Actions
var $actions = new Array ();
$actions = [
  <?php echo $helper->mooJsonDataToNew(array(  'label' => 'Nueva',  'inWinPopUp' => true,  'params' =>   array(  ),  'class_suffix' => 'new',)) ?> ]
</script>