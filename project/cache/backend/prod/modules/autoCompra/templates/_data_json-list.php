<script type="text/javascript">
<?php include_partial('compra/data_json-list_win', array('jsonData4Win' => $jsonData4Win)) ?>

 var $jsonDataBarMenuList = new Array ();
    $jsonDataBarMenuList = [
      {execute: 'this.optFilter'}
    ]

  var $jsonDataFilter = new Array ();
    $jsonDataFilter = [
      {filter: 'filter'},
      {action: '<?php echo moo_json_data_link_to_filters(__('Reset', array(), 'sf_admin'), 'compra_collection', array('action' => 'filter')) ?>'},
      {cancel: 'cancel'}
    ];

// JsonData Actions list
<?php include_partial('compra/data_json-list_rows', array('compra' => $compra, 'helper' => $helper, 'pager' => $pager)) ?>

// JsonData Actions
var $actions = new Array ();
$actions = [
  <?php echo $helper->mooJsonDataToNew(array(  'inWinPopUp' => true,  'params' =>   array(  ),  'class_suffix' => 'new',  'label' => 'New',)) ?> ]
</script>