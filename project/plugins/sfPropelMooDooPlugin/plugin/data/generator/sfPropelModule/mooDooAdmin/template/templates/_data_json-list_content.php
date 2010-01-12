<script type="text/javascript">

 var $jsonDataBarMenuList = new Array ();
    $jsonDataBarMenuList = [
      {execute: 'this.optFilter'}
    ]

  var $jsonDataFilter = new Array ();
    $jsonDataFilter = [
      {filter: 'filter'},
      {action: '[?php echo moo_json_data_link_to_filters(__('Reset', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]'},
      {cancel: 'cancel'}
    ];

// JsonData Actions list
[?php include_partial('<?php echo $this->getModuleName() ?>/data_json-list_rows', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper, 'pager' => $pager)) ?]

// JsonData Actions
var $actions = new Array ();
$actions = [
<?php if ($actions = $this->configuration->getValue('list.actions')): ?>
<?php foreach ($actions as $name => $params): ?>
<?php if ('_new' == $name): ?>
  <?php echo $this->addCredentialCondition('[?php echo $helper->mooJsonDataToNew('.$this->asPhp($params).') ?]', $params) ?>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
 ]
</script>