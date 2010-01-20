  var $jsonData4Win = new Array ();
  $jsonData4Win = {
    controller: {
      moduleName: '<?php echo $this->getModuleName() ?>',
      action: 'new'},
    node: {
      win: 'winWin_<?php echo $this->params['route_prefix'] ?>_[?php echo $<?php echo $this->getSingularName() ?>->getId() ?]'
    },
    dims: {
      width: 450,
      left: 100,
      top: 40
    }
  };