<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" >
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
  </head>

  <body>
    <div id="header">
      <?php include_partial ('global/mainMenu'); ?>
    </div>

    <div id="wrapper">
      <div id="content">
        <div id="content-insert-node"></div>
        <?php echo $sf_data->getRaw('sf_content'); ?>
      </div>
    </div>

    <div id="stateBar">
      <?php include_partial ('global/stateBar'); ?>
    </div>
  </body>
</html>
