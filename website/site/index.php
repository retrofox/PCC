<?php include('snews.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <meta name="robots" content="index,follow" />
    <meta name="author" content="XiFOX.net" />
    <?php title(); ?>

    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style_old.css" rel="stylesheet" type="text/css" />
    <script src="js/mootools.js" type="text/javascript"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/iepngfix_tilebg.js"></script>
  </head>

  <body>
    <div id="frame">
      <!--header start here -->
      <div id="headcontainer">
        <a href="<?php echo _SITE ?>"><img src="images/logo.png" alt="Protecci&oacute;n Cat&oacute;dica del Comahue" title="Protecci&oacute;n Cat&oacute;dica del Comahue" class="logo" /></a>

        <ul>
          <?php pages(); ?>
        </ul>
        <img src="images/frente2.png" alt="Protecci&oacute;n Cat&oacute;dica del Comahue" class="foto_header" />
        <h1><?php echo s('website_title'); ?></h1>
        <h2><?php echo s('website_description'); ?></h2>
      </div>
      <!--header end here -->

      <!--body start here -->
      <div id="maincontainer">
        <!--left panel start here -->
        <div id="leftnavcontainer">
          <ul id="menu_interior">
            <?php
            global $categorySEF, $subcatSEF;
            $qwr = !_ADMIN ? ' AND a.visible=\'YES\'' : '';
            if (s('num_categories') == 'on') {
              $count = ', COUNT(DISTINCT a.id) as total';
              $join = 'LEFT OUTER JOIN '._PRE.'articles'.' AS a
								ON (a.category = c.id AND a.position = 1  AND a.published = 1'.$qwr.')';
            } else {
              $count ='';
              $join='';
            }
            $result = mysql_query('SELECT
									c.seftitle, c.name, c.seftitle, description, c.id AS parent'.$count.'
								FROM '._PRE.'categories'.' AS c '.$join.'
								WHERE c.subcat = 0 AND c.published = \'YES\'
								GROUP BY c.id
								ORDER BY c.catorder,c.id');
            if (mysql_num_rows($result) > 0) {
              $i=0;
              while ($r = mysql_fetch_array($result)) {
                $i++;
                $category_title = $r['seftitle'];
                $r['name'] = (s('language')!='EN' && $r['name'] == 'Uncategorized' && $r['parent']==1) ? l('uncategorised') : $r['name'];
                
                if($category_title == $categorySEF)
                  $number = $i-1;

                if (isset($r['total'])) {
                  $num='('.$r['total'].')';
                }

                echo '<li class="toggler"><h5 class="color'.$i.'">'.$r['name'].'<span></span></h5> ';
                $query_articles = 'SELECT
											a.id AS aid,title,a.seftitle AS asef,text,a.date,
											a.displaytitle,a.displayinfo,a.commentable,a.visible
											FROM '._PRE.'articles'.' AS a
											WHERE position = 1
											AND a.published =1
											AND category = '.$r['parent'].'
											ORDER BY artorder ASC,date DESC';
                //echo $query_articles;
                $articles= mysql_query($query_articles);
                if (mysql_num_rows($articles) > 0) {
                  echo '<ul class="bloque">';
                  while ($a = mysql_fetch_array($articles)) {
                    $item_title =$a['asef'];
                    $active = ($item_title == $subcatSEF)? 'class="current"': '';


                    echo '<li>
																	<a href="'.$r['seftitle'].'/'.$a['asef'].'"'.$active.' >'.$a['title'].'<span></span> </a>
																  </li>';
                  }

                  echo '</ul>';
                }
                echo '</li>';
              }
            } else {
              echo '<li>'.l('no_categories').'</li>';
}
?>
            <br class="spacer" />
        </div>
        <!--left panel end here -->

        <!--right panel end here -->
        <div id="body">

          <?php

          if (_ADMIN) { ?>
          <div id="crumbs"><?php breadcrumbs(); ?> </div>
  <?php }
          else if(isset($_GET['category']) && $_GET['category']!='Home') {?>
            <!--div id="camino"><?php breadcrumbs(); ?></div-->
  <?php } ?>
<?php center(); ?>

        </div>
        <!--right panel end here -->
        <br class="spacer" />

        <!--footer start here -->
        <div id="footercontainer">
          &copy; 2009 Protecci&oacute;n Cat&oacute;dica del Comahue s.r.l - Todos los derechos reservados - <?php login_link(); ?> <br />
        </div>
        <!--footer start here -->
      </div>
      <!--body end here -->
    </div>
  </body>
</html>
<script>
  var number_active = <?php echo $number ?>;
</script>