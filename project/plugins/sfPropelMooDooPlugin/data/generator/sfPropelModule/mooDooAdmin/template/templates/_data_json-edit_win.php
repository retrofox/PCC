// JsonData editWin
  $jsonData4Win = {
    win: [?php echo json_encode($jsonData4Win->getRaw('win')) ?],
    controller: [?php echo json_encode($jsonData4Win->getRaw('controller')) ?],
    dims: [?php echo json_encode($jsonData4Win->getRaw('dims')) ?]
  }