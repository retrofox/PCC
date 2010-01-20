<?php
/********************************************************

	sNews 1.7 - January 2009
	Update 1.4
	Copyright (C) Solucija.com
	sNews is licensed under a Creative Commons License
*********************************************************
This issue of snews has all patches listed on
http://snewscms.com/forum/index.php?board=92.0
up to posting date of 24 Jan 2009

*********************************************************/
// Start sNews session
session_start();

// Show errors (uncomment the following, and comment the next to show errors).
//error_reporting(E_ALL ^ E_NOTICE);
// Hide errors (comment this, and uncomment the above to show errors).
error_reporting(0);

// CONFIGURATION VARIABLES

// DATABASE VARIABLES
function db($variable) {
	$db = array(
	// Edit here for the database information only
		// MySQL host
			'dbhost' 	=> 'localhost',
		// Database name
			'dbname' 	=> 'webpcc', //'xifox_webpcc',
		// Database Username
			'dbuname' 	=> 'root', //'xifox_pcc',
		// Database password
			'dbpass' 	=> 'alfilasesino',//%TPg#(|vq6~K',
		// Table prefix for multiple sNews systems on one database
		// if you don't need it just leave it blank
			'prefix' 	=> ''
	);
	return $db[$variable];
}

//SITE - Automatically detects the scripts location.
function site() {
	$host = 'http://'.$_SERVER['HTTP_HOST'];
	$directory = dirname($_SERVER['SCRIPT_NAME']);
	$website = $directory == '/' ? $host.'/' : $host.$directory.'/';
	return $website;
}

// Language Variables
function l($var) {
	global $l;
	return $l[$var];
}

// INFO LINE TAGS (readmore, comments, date)
$tags = array(
	'infoline' => '<p class="date">,readmore,comments,date,edit,</p>',
	'comments' => '<p class="meta">,name, '.l('on').' ,date,edit,</p>,<p class="comment">,comment,</p>'
);

function tags($tag) {
	global $tags;
	return $tags[$tag];
}

// Constants
// Website
	define('_SITE',site());
// Prefix
	define('_PRE',db('prefix'));
// Set login constant
	define('_ADMIN',(isset($_SESSION[_SITE.'Logged_In']) && $_SESSION[_SITE.'Logged_In'] == token() ? true : false));

// SITE SETTINGS - grab site settings from database
function s($var) {
	global $site_settings;
	if (!$site_settings){
		$query = 'SELECT name,value FROM '._PRE.'settings';
		$result = mysql_query($query);
		while ($r = mysql_fetch_assoc($result)) {
			$site_settings[$r['name']] = $r['value'];
		}
	}
	$value = $site_settings[$var];
	return $value;
}

// SESSION TOKEN
function token() {
	$a = md5(substr(session_id(), 2, 7));
	$b = $_SERVER['HTTP_USER_AGENT'];
	$token = md5($a.$b._SITE);
	return $token;
}

// STARTUP
connect_to_db();
	// LANGUAGE VARIABLES
	s('language') != 'EN' && file_exists('lang/'.s('language').'.php') == true ? include('lang/'.s('language').'.php') : include('lang/EN.php');
	// SYSTEM VARIABLES (not to be translated)
	//SEF links of the hardcoded items - RESERVED WORDS - will clash if using for article/category seftitles.
		$l['cat_listSEF'] = 'archive,contact,sitemap,login';
		if (_ADMIN) {$l['cat_listSEF'] .= ',administration,admin_category,admin_article,article_new,extra_new,page_new,snews_categories,snews_articles,extra_contents,snews_pages,snews_settings,snews_files,logout,groupings,admin_groupings';}
	//divider character
		$l['divider'] = '&middot;';
	// used in article pagination links
		$l['paginator'] = 'p_';
		$l['comment_pages'] = 'c_';
	// list of files & folders ignored by upload/file list routine
		$l['ignored_items'] = '.,..,cgi-bin,.htaccess,Thumbs.db,snews.php,index.php,lib.php,style.css,admin.js,'.s('language').'.php';

if(isset($_POST['Loginform']) && !_ADMIN) {
	$user = checkUserPass($_POST['uname']);
	$pass = checkUserPass($_POST['pass']);
	unset($_POST['uname'],$_POST['pass']);
	if (md5($user) === s('username') && md5($pass) === s('password') && checkMathCaptcha()) {
		$_SESSION[_SITE.'Logged_In'] = token();
		notification(2,'','administration');
	} else {
		die( notification(2,l('err_Login'),'login'));
	}
}
if($_POST['submit_text'] && !_ADMIN){
	die (notification(2,l('error_not_logged_in'),'home'));
}
if (!empty($_GET['category'])) {
	$url = explode('/', clean($_GET['category']));
	$categorySEF = $url[0];
	if (isset($url[1])) $subcatSEF = $url[1];
	if (substr($url[1], 0, 1) == l('comment_pages') && is_numeric(substr($url[1], 1, 1))) $commentsPage = $url[1];
	if (isset($url[2]))  $articleSEF= $url[2];
	if (isset($url[3])) $commentsPage = $url[3];
	if (check_category($categorySEF)) { $_catID = 0; return; }
	// Admin content
	if (_ADMIN) {
		$pub_a = ''; $pub_c = ''; $pub_x = '';
	} else {
		$pub_a = ' AND a.published = 1';
		$pub_c = ' AND c.published =\'YES\'';
		$pub_x = ' AND x.published =\'YES\'';
	}
 	// Query for  / Category / subcategory / article /
	if ($articleSEF && substr( $articleSEF, 0, 2) != l('paginator') && substr( $articleSEF, 0, 2) != l('comment_pages')) {
		$MainQuery = 'SELECT
			a.id AS id, title, position, description_meta, keywords_meta,
			c.id AS catID, c.name AS name, c.description, x.name AS xname
			FROM '._PRE.'articles'.' AS a,
				'._PRE.'categories'.' AS c
			LEFT JOIN '._PRE.'categories'.' AS x
				ON c.subcat=x.id
			WHERE a.category=c.id
				'.$pub_a.$pub_c.$pub_x.'
				AND x.seftitle="'.$categorySEF.'"
				AND c.seftitle="'.$subcatSEF.'"
				AND a.seftitle="'.$articleSEF.'"
		';
	}
 	// Two queries for / Category / subcategory  /  OR   / Category / article /
	elseif ($subcatSEF  && substr( $subcatSEF, 0, 2) != l('paginator') && substr( $subcatSEF, 0,2) != l('comment_pages')) {
		$Try_Article = mysql_query('SELECT
				a.id AS id, title, position, description_meta, keywords_meta,
				c.id as catID, name, description, subcat
			FROM '._PRE.'articles'.' AS a
			LEFT JOIN '._PRE.'categories'.' AS c
				ON category =  c.id
			WHERE c.seftitle = "'.$categorySEF.'"
				AND a.seftitle ="'.$subcatSEF.'"
				'.$pub_a.$pub_c.'
				AND subcat = 0
		');
		$R = mysql_fetch_assoc($Try_Article);
 		// query  for / category / article /
		if(empty($R)) {
			$MainQuery = 'SELECT
					c.id AS catID, c.name AS name, c.description, c.subcat,
					x.name AS xname
				FROM '._PRE.'categories'.' AS x
				LEFT JOIN '._PRE.'categories'.' AS c
					ON  c.subcat = x.id
				WHERE x.seftitle = "'.$categorySEF.'"
					AND c.seftitle = "'.$subcatSEF.'"
					'.$pub_c.$pub_x ;
		}
	} else {
	 switch(true):
		case (substr( $categorySEF, 0, 2) == l('paginator')) :
			break;
		case (false !== strpos($categorySEF, 'rss-')) :
			die(rss_contents($categorySEF, $articleSEF));
 		// Two queries for  / Category / OR  /Page/
		default:
			$Try_Page = mysql_query('SELECT
					id, title, category, description_meta, keywords_meta, position
				FROM '._PRE.'articles'.' AS a
				WHERE seftitle = "'.$categorySEF.'"
					'.$pub_a.'
					AND position = 3');
 			// query  for category
			$R = mysql_fetch_assoc($Try_Page);
			if (!$R) {
				$MainQuery ='SELECT
						id AS catID, name, description
					FROM '._PRE.'categories'.' AS c
					WHERE seftitle = "'.$categorySEF.'"
						AND subcat = 0
						'.$pub_c;
			}
		endswitch;
	}
	if (!empty($MainQuery)){
		$Mainresult = mysql_query($MainQuery);
		if (mysql_num_rows($Mainresult) === 1 ){
			$R = mysql_fetch_assoc($Mainresult);
		} elseif(!in_array($_GET['action'],explode(',',l('cat_listSEF')))){
			$categorySEF = '404';
			header('HTTP/1.1 404 Not Found');
			unset($subcatSEF,$articleSEF); }
		update_articles();
	}
// globals
} else {
	// ID for 'home'
	if (s('display_page') !== 0) $_ID = s('display_page');
}
if(!empty($R['category'])) $_CAT = $R['category'];
if(!empty($R['id'])) $_ID = $R['id'];
if(!empty($R['title'])) $_TITLE = $R['title'];
if(!empty($R['position'])) $_POS = $R['position'];
if(!empty($R['catID'])) $_catID = $R['catID'];
if(!empty($R['name'])) $_NAME = $R['name'];
if(!empty($R['xname'])) $_XNAME = $R['xname'];
if(!empty($R['keywords_meta'])) $_KEYW = $R['keywords_meta'];
if(!empty($R['description_meta']))  $_DESCR = $R['description_meta']; else $_DESCR = $R['description'];
// set comments page for / category / article /
if (isset($url[3]) && !$_XNAME) $commentsPage = $url[2];

//TITLE
function title() {
	global $categorySEF, $_DESCR, $_KEYW, $_TITLE, $_NAME, $_XNAME;
   	echo '<base href="'._SITE.'" />';
   	$title =  $_TITLE ? $_TITLE.' - ' : '';
   	$title .= $_NAME ? $_NAME.' - ' : '';
   	$title .= $_XNAME ? $_XNAME.' - ' : '';
   	if (check_category($categorySEF) == true && $categorySEF != 'administration' && $categorySEF)
   		$title .= l($categorySEF).' - ';
   		$title .= s('website_title');
		echo '
			<title>'.$title.'</title>
			<meta http-equiv="Content-Type" content="text/html; charset='.s('charset').'" />
			<meta name="description" content="'.(!empty($_DESCR) ? $_DESCR : s('website_description')).'" />
			<meta name="keywords" content="'.(!empty($_KEYW) ? $_KEYW : s('website_keywords')).'" />';
	if (_ADMIN) {
		echo '<script type="text/javascript">';
			include('js/admin.js');
		echo '</script>';
	}
}

//BREADCRUMBS
function breadcrumbs() {
	global $categorySEF, $subcatSEF, $_POS, $_TITLE, $_NAME, $_XNAME;
	$link = '<a href="'._SITE.'';
	if (_ADMIN) {
		echo $link.'administration/" title="'.l('administration').'">'.l('administration').'</a> '.l('divider').' ';
	}
	echo (!empty($categorySEF) ? $link.'">'.l('home').'</a>' : l('home'));
	if (!empty($categorySEF) && check_category($categorySEF) == false) {
		echo (!empty($subcatSEF) ? ' '.l('divider').' '.$link.$categorySEF.'/">
			'.(!empty($_XNAME) ? $_XNAME : $_NAME).'</a>' :
			(!empty($_NAME) ? ' '.l('divider').' '.$_NAME:''));
		if (!empty($subcatSEF) && $_XNAME) {
			echo ($_POS==1 ? ' '.l('divider').' '.$link.$categorySEF.'/'.$subcatSEF.'/">'.$_NAME.'</a>' : ' '.l('divider').' '.$_NAME);
		}
		echo (!empty($_TITLE)? ' '.l('divider').' '.$_TITLE : '');
	}
	if (check_category($categorySEF) == true && $categorySEF != 'administration' && $categorySEF) {
		echo ' '.l('divider').' '.l($categorySEF);}
}

// LOGIN LOGOUT LINK
function login_link() {
	$login = '<a href="'._SITE;
	$login .= _ADMIN ? 'logout/" title="'.l('logout').'">'.l('logout') :
		'login/" title="'.l('login').'">'.l('login').'';
	$login .= '</a>';
	echo $login;
}

// DISPLAY CATEGORIES
function categories() {
	global $categorySEF;
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
			c.seftitle, c.name, description, c.id AS parent'.$count.'
		FROM '._PRE.'categories'.' AS c '.$join.'
		WHERE c.subcat = 0 AND c.published = \'YES\'
		GROUP BY c.id
		ORDER BY c.catorder,c.id');
	if (mysql_num_rows($result) > 0){
		while ($r = mysql_fetch_array($result)) {
			$category_title = $r['seftitle'];
			$r['name'] = (s('language')!='EN' && $r['name'] == 'Uncategorized' && $r['parent']==1) ? l('uncategorised') : $r['name'];
			$class = $category_title == $categorySEF ? ' class="current"' : '';
			if (isset($r['total'])) { $num='('.$r['total'].')'; }
			echo '<li><a'.$class.' href="'._SITE.$category_title.'/" title="'.$r['name'].' - '.$r['description'].'">'.$r['name'].$num.'</a>';
			$parent = $r['parent'];
			if ($category_title == $categorySEF) { subcategories($parent); }
			echo '</li>';
		}
	} else {
		echo '<li>'.l('no_categories').'</li>';
	}
}

function subcategories($parent) {
	global $categorySEF, $subcatSEF;
	$qwr = !_ADMIN ? ' AND a.visible=\'YES\'' : '';
	if (s('num_categories') == 'on') {
		$count = ', COUNT(DISTINCT a.id) AS total';
		$join ='LEFT OUTER JOIN '._PRE.'articles'.' AS a
			ON (a.category = c.id AND a.position = 1 AND a.published = 1'.$qwr.')';
	} else {
		$count ='';
		$join='';
	}
	$subresult = mysql_query('SELECT c.seftitle AS subsef, description, name'.$count.'
		FROM '._PRE.'categories'.' AS c '.$join.'
		WHERE c.subcat = '.$parent.' AND c.published = \'YES\'
		GROUP BY c.id
		ORDER BY c.catorder,c.id');
	if (mysql_num_rows($subresult) !== 0) {
		echo '<ul>';
		while ($s = mysql_fetch_array($subresult)) {
			$subSEF = $s['subsef'];
			$class = $subSEF == $subcatSEF ? ' class="current"' : '';
			if (isset($s['total'])) {
				$num=' ('.$s['total'].')';
			}
			echo '<li class="subcat">
				<a'.$class.' href="'._SITE.$categorySEF.'/'.$subSEF.'/" title="'.$s['description'].'">
				'.$s['name'].$num.'</a></li>';
		}
		echo '</ul>';
	}
}

// DISPLAY PAGES
function pages() {
	global $categorySEF,$_No3;
	$qwr = !_ADMIN ? ' AND visible=\'YES\'' : '';
	$class = empty($categorySEF) ? ' class="current home"' : ' class="home"';
	echo '<li class="nobor"><a'.$class.' href="'._SITE.'" alt="home">'.l('home').'</a></li>';
	$class = ($categorySEF == 'archive') ? ' class="current archivo"' : ' class="archivo"';
	//echo '<li><a'.$class.' href="'._SITE.'archive/" alt="archivo">'.l('archive').'</a></li>';
	/*$query = "SELECT id, seftitle, title FROM "._PRE.'articles'." WHERE position = 3 $qwr ORDER BY artorder ASC, id";
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
	while ($r = mysql_fetch_array($result)) {
		$title = $r['title'];
		$class = ($categorySEF == $r['seftitle'])? ' class="current"' : '';
		if ($r['id'] != s('display_page')) {
			echo '<li><a'.$class.' href="'._SITE.$r['seftitle'].'/">'.$title.'</a></li>';
		}
	}*/
	$class = ($categorySEF == 'contact') ? ' class="current message"': ' class="message"';
	echo '<li><a'.$class.' href="'._SITE.'contact/" alt="Contacto">'.l('contact').'</a></li>';
	$class = ($categorySEF == 'sitemap') ? ' class="current sitemap"': ' class="sitemap"';
	echo '<li><a'.$class.' href="'._SITE.'sitemap/" alt="Sitemap">'.l('sitemap').'</a></li>';
	if ($num) $_No3 = true;
}

//EXTRA CONTENT
function extra($mode='', $styleit = 0, $classname = '', $idname= '') {
	global $categorySEF, $subcatSEF, $articleSEF, $_ID, $_catID;
   	if (empty($mode)) {
   		$mode = retrieve('seftitle', 'extras','id',1);
   	}
   	if (!_ADMIN) $qwr = ' AND visible=\'YES\''; else $qwr = '';
   	$mode = strtolower($mode);
   	$getExtra = retrieve('id', 'extras', 'seftitle', $mode);
   	$subCat = retrieve('subcat', 'categories', 'id', $_catID);
   	if (!empty( $_ID)) {
   		$getArt = $_ID;
   	}
   	if (!empty($subcatSEF)) {
   		$catSEF = $subcatSEF;
   	}
   	$url = $categorySEF.(!empty($subcatSEF)? '/'.$subcatSEF:'').(!empty($articleSEF)?'/'.$articleSEF :'');
   	$sql = 'SELECT
			id,title,seftitle,text,category,extraid,page_extra,
			position,displaytitle,show_in_subcats,visible
		FROM '._PRE.'articles'.'
		WHERE published = 1
			AND position = 2 ';
   	$query = $sql.(!empty($getExtra) ? ' AND extraid = '.$getExtra : ' AND extraid = 1');
   	$query = $query.$qwr.' ORDER BY artorder ASC,id ASC';
   	$result = mysql_query($query) or die(mysql_error());
	while ($r = mysql_fetch_array($result)) {
		$category = $r['category'];
		$page = $r['page_extra'];
	 	switch (true) {
			case ($category == 0 && $page<1):
				$print = false;
				break;
			case ($category == 0 && empty($_catID) && $page!=''):
				$print = check_category($catSEF) != true? true : false;
				break;
			case ($category == $_catID || ($category == $subCat && $r['show_in_subcats'] == 'YES')):
				$print = true;
				break;
			case ($category == -3 && $getArt == $page):
				$print = true;
				break;
			case ($category == -3 && $_catID == 0 && $getArt != $page && $page == 0
					&& $categorySEF !='' && !in_array($categorySEF,explode(',',l('cat_listSEF')))
					&& substr( $categorySEF, 0, 2) != l('paginator') ):
				$print = true;
				break;
			// To show up on all pages only
			case ($category == -1 && $_catID == 0 && $getArt != $page && $page == 0):
				$print = true;
				break;
			// To show up on all categories and pages
			case ($category == -1):
				$print = true;
				break;
			default:
				$print = false;
		}
 		if ($print == true) {
			if ($styleit == 1) {
				$container ='<div';
				$container .= !empty($classname) ? ' class="'.$classname.'"' : '';
				$container .= !empty($idname) ? ' id="'.$idname.'"' : '';
				$container .= '>';
				echo $container;
			}
			if ($r['displaytitle'] == 'YES') {
				echo '<h3>'. $r['title'] .'</h3>';
			}
			file_include($r['text'], 9999000);
			$visiblity = $r['visible'] == 'YES' ?
       			'<a href="'._SITE.'?action=process&amp;task=hide&amp;item=snews_articles&amp;id='.$r['id'].'&amp;back='.$url.'">'.l('hide').'</a>' :
      			l('hidden').' ( <a href="'._SITE.'?action=process&amp;task=show&amp;item=snews_articles&amp;id='.$r['id'].'&amp;back='.$url.'">'.l('show').'</a> )';
			echo _ADMIN ? '<p><a href="'._SITE.'?action=admin_article&amp;id='.$r['id'].'" title="'.l('edit').' '.$r['seftitle'].'">
				'.l('edit').'</a>'.' '.l('divider').' '.$visiblity.'</p>' : '';
			if ($styleit == 1) {
				echo '</div>';
			}
		}
	}
}

// PAGINATOR
function paginator($pageNum, $maxPage, $pagePrefix) {
	global $categorySEF,$subcatSEF, $articleSEF,$_ID, $_catID,$_POS, $_XNAME;
	switch (true){
		case !$_ID && !$_catID :
			$uri ='';
			break;
		case $_ID && $_XNAME :
			$uri = $categorySEF.'/'.$subcatSEF.'/'.$articleSEF.'/';
			break;
		case $_POS == 1 || $_XNAME :
			$uri = $categorySEF.'/'.$subcatSEF.'/';
			break;
		default :
			$uri = $categorySEF.'/';
	}
	$link = '<a href="'._SITE.$uri ;
	$prefix = !empty($pagePrefix) ? $pagePrefix : '';
	if ($pageNum > 1) {
		$goTo =  $link;
		$prev = (($pageNum-1)==1 ? $goTo :
			$link.$prefix.($pageNum - 1).'/').'" title="'.l('page').' '.($pageNum - 1).'">
				&lt; '.l('previous_page').'</a> ';
		$first = $goTo.'" title="'.l('first_page').' '.l('page').'">
			&lt;&lt; '.l('first_page').'</a>';
    } else {
		$prev = '&lt; '.l('previous_page');
		$first = '&lt;&lt; '.l('first_page');
	}
	if ($pageNum < $maxPage) {
		$next = $link.$prefix.($pageNum + 1).'/" title="'.l('page').' '.($pageNum + 1).'">
			'.l('next_page').' &gt;</a> ';
		$last = $link.$prefix.$maxPage.'/" title="'.l('last_page').' '.l('page').'">
			'.l('last_page').' &gt;&gt;</a> ';
	} else {
		$next = l('next_page').' &gt; ';
		$last = l('last_page').' &gt;&gt;';
	}
	echo '
		<div class="paginator">
			'.$first.' '.$prev.'
			<strong>['.$pageNum.'</strong> / <strong>'.$maxPage.']</strong>
			'.$next.' '.$last.'
		</div>';
}

// CENTER
function center() {
	// fatal session produced on failed login, and will display error message.
 	if (isset($_SESSION[_SITE.'fatal'])) {
		echo $_SESSION[_SITE.'fatal'];
		unset($_SESSION[_SITE.'fatal']);
	} else {
		global $categorySEF, $subcatSEF, $articleSEF;
		switch(true) {
			case isset($_GET['category']):
				$action = $categorySEF;
				break;
			case isset($_GET['action']):
				$action = $categorySEF == '404' ? $categorySEF : clean(cleanXSS($_GET['action']));
				break;
		}
		switch(true) {
			case isset($_POST['search_query']):
				search(); return; break;
			case isset($_POST['comment']):
				comment('comment_posted'); return; break;
			case isset($_POST['contactform']):
				contact(); return; break;
			case isset($_POST['Loginform']):
				administration(); return; break;
			case isset($_POST['submit_text']):
				processing(); return; break;
		}
		if (_ADMIN) {
	 		switch ($action) {
				case 'administration':
					administration(); return; break;
				case 'snews_settings':
					settings(); return; break;
				case 'snews_categories':
					admin_categories(); return; break;
				case 'admin_category':
					form_categories(); return; break;
				case 'admin_subcategory':
					form_categories('sub'); return; break;
				case 'groupings':
					admin_groupings(); return; break;
				case 'admin_groupings':
					form_groupings(); return; break;
				case 'snews_articles':
					admin_articles('article_view'); return; break;
				case 'extra_contents':
					admin_articles('extra_view'); return; break;
				case 'snews_pages':
					admin_articles('page_view'); return; break;
				case 'admin_article':
					form_articles(''); return; break;
				case 'article_new':
					form_articles('article_new'); return; break;
				case 'extra_new':
					form_articles('extra_new'); return; break;
				case 'page_new':
					form_articles('page_new'); return; break;
				case 'editcomment':
					edit_comment(); return; break;
				case 'snews_files':
					files(); return; break;
				case 'process':
					processing(); return; break;
				case 'logout':
					session_destroy();
					echo '<meta http-equiv="refresh" content="2; url='._SITE.'">';
					echo '<h2>'.l('log_out').'</h2>';
					return; break;
			}
		}
		switch ($action) {
			case 'archive':
				archive(); break;
			case 'sitemap':
				sitemap(); break;
			case 'contact':
				contact(); break;
			case 'login':
				login(); break;
			case '404':
				echo l('error_404'); break;
			default:
				articles(); break;
		}
	}
}

// ARTICLES
function articles() {
	global $categorySEF, $subcatSEF, $articleSEF, $_ID, $_POS, $_catID, $_XNAME;
	$frontpage = s('display_page');
	$title_not_found = '<h2>'.l('none_yet').'</h2>';
	if (_ADMIN) {
	 	$visible='';
		$title_not_found .= '<p>'.l('create_new').'
			<a href="'._SITE.'administration/" title="'.l('administration').'">'.l('administration').'</a></p>';
	} else {
		$visible =' AND a.visible=\'YES\' ';
	}
	if ($_ID || (!$_catID && $frontpage != 0)) {
		if (!$_ID) $_ID = $frontpage;
			// article or page, id as indentifier
			$query_articles = 'SELECT
					a.id AS aid,title,a.seftitle AS asef,text,a.date,
					a.displaytitle,a.displayinfo,a.commentable,a.visible
				FROM  '._PRE.'articles'.' AS a
				WHERE id ='.$_ID.$visible;
		} else {
		if (s('display_pagination') == 'on') $on = true; else $on = false;
		if ($on == true) {
			if ($articleSEF) {
				$SEF = $articleSEF;
			} elseif ($subcatSEF) {
				$SEF = $subcatSEF;
			} else {
				$SEF = $categorySEF;
			}
			// pagination
			$currentPage = strpos($SEF, l('paginator')) === 0 ? str_replace(l('paginator'), '', $SEF) : '';
			if ($_catID) {
				$count = 'SELECT COUNT(a.id) AS num
					FROM  '._PRE.'articles'.' AS a
					WHERE position = 1
						AND a.published =1
						AND category = '.$_catID.$visible.'
						GROUP BY category';
			} else {
				$count = 'SELECT COUNT(a.id) AS num
					FROM '._PRE.'articles'.' AS a
					LEFT OUTER JOIN '._PRE.'categories'.' as c
						ON category = c.id
					LEFT OUTER JOIN '._PRE.'categories'.' as x
						ON c.subcat =  x.id AND (x.published =\'YES\')
					WHERE show_on_home = \'YES\' '.$visible.'
						AND position = 1
						AND a.published =1
						AND c.published =\'YES\'
					GROUP BY show_on_home';
			}
			$count = mysql_query($count);
			if ($count) {
				$r = mysql_fetch_array($count);
				$num = $r['num'];
			}
		}
		if ($num === 0 ) {
			echo $title_not_found;
		} else {
			$articleCount = s('article_limit');
			$article_limit = (empty($articleCount) || $articleCount < 1) ? 100 : $articleCount;
			$totalPages = ceil($num/$article_limit);
			if (!isset($currentPage) || !is_numeric($currentPage) || $currentPage < 1) {
				$currentPage = 1;
			}
			// get the rows for category
			if ($_catID) {
				$query_articles = 'SELECT
						a.id AS aid,title,a.seftitle AS asef,text,a.date,
						a.displaytitle,a.displayinfo,a.commentable,a.visible
				FROM '._PRE.'articles'.' AS a
				WHERE position = 1
					AND a.published =1
					AND category = '.$_catID.$visible.'
				ORDER BY artorder ASC,date DESC
				LIMIT '.($currentPage - 1) * $article_limit.','.$article_limit;
			} else {
				$query_articles = 'SELECT
						a.id AS aid,title,a.seftitle AS asef,text,a.date,
							displaytitle,displayinfo,commentable,a.visible,
						c.name AS name,c.seftitle AS csef,
						x.name AS xname,x.seftitle AS xsef
					FROM '._PRE.'articles'.' AS a
					LEFT OUTER JOIN '._PRE.'categories'.' as c
						ON category = c.id
					LEFT OUTER JOIN '._PRE.'categories'.' as x
						ON c.subcat =  x.id AND x.published =\'YES\'
					WHERE show_on_home = \'YES\'
						AND position = 1
						AND a.published =1
						AND c.published =\'YES\''.$visible.'
					ORDER BY date DESC
					LIMIT '.($currentPage - 1) * $article_limit.','.$article_limit;
			}
		}
	}
	$result = mysql_query($query_articles);
	$numrows = mysql_num_rows($result);
	if (!$result || !$numrows) {
		if (_ADMIN) {
			echo $title_not_found;
		}
		echo '<ul class="vertical">';
			menu_articles(0,10,1);
		echo '</ul>';
	} else {
		$link = '<a href="'._SITE;
		while ($r = mysql_fetch_array($result)) {
			$infoline = $r['displayinfo'] == 'YES' ? true : false;
			$text = stripslashes($r['text']);
			if (!empty($currentPage)) {
				$short_display = strpos($text, '[break]');
				$shorten = $short_display == 0 ? 9999000 : $short_display;
			} else {
				$shorten = 9999000;
			}
			$comments_query = 'SELECT id FROM '._PRE.'comments'.'
				WHERE articleid = '.$r['aid'].' AND approved = \'True\'';
			$comments_result = mysql_query($comments_query);
			$comments_num = mysql_num_rows($comments_result);
			$a_date_format = date(s('date_format'), strtotime($r['date']));
			if ($r['csef']) $uri = $r['xsef'] ? $r['xsef'].'/'.$r['csef'] :  $r['csef'];
			elseif ($_XNAME) $uri = $categorySEF.'/'.$subcatSEF;
			else $uri = $categorySEF;
			$title = $r['title'];
			if ($r['displaytitle'] == 'YES') {
				if (!$_ID)  {
					echo '<h2 class="big">'.$link.$uri.'/'.$r['asef'].'/">'.$title.'</a></h2>';
				} else {
					echo '<h2>'.$title.'</h2>';
				}
			}
			file_include(str_replace('[break]', '',$text), $shorten);
			$commentable = $r['commentable'];
			$visiblity = $r['visible'] == 'YES' ?
       	 		'<a href="'._SITE.'?action=process&amp;task=hide&amp;item=snews_articles&amp;id='.$r['aid'].'&amp;back='.$uri.'">'.l('hide').'</a>' :
      	 		l('hidden').' ( <a href="'._SITE.'?action=process&amp;task=show&amp;item=snews_articles&amp;id='.$r['aid'].'&amp;back='.$uri.'">'.l('show').'</a> )' ;
			$edit_link = $link.'?action=admin_article&amp;id='.$r['aid'].'" title="'.$title.'">'.l('edit').'</a> ';
			$edit_link.= ' '.l('divider').' '.$visiblity;
			if (!empty($currentPage)) {
				if ($infoline == true) {
					$tag = explode(',', tags('infoline'));
					foreach ($tag as $tag) {
						switch (true) {
							case ($tag == 'date'):
								echo $a_date_format;
								break;
							case ($tag == 'readmore' && strlen($r['text']) > $shorten):
								echo $link.$uri.'/'.$r['asef'].'/">'.l('read_more').'</a> ';
								break;
							case ($tag == 'comments' && ($commentable == 'YES' || $commentable == 'FREEZ')):
								echo $link.$uri.'/'.$r['asef'].'/#'.l('comment').'1">
								'.l('comments').' ('.$comments_num.')</a> ';
								break;
							case ($tag == 'edit' && _ADMIN):
								echo ' '.$edit_link;
								break;
							case ($tag != 'readmore' && $tag != 'comments' && $tag != 'edit'):
								echo $tag;
								break;
						}
					}
				} else if (_ADMIN) {
					echo '<p>'.$edit_link.'</p>';
				}
			} else if (empty($currentPage)) {
				if ($infoline == true) {
					$tag = explode(',', tags('infoline'));
					foreach ($tag as $tag ) {
						switch ($tag) {
							case 'date':
								echo $a_date_format;
								break;
							case 'readmore':
							case 'comments': ;
								break;
							case 'edit':
								if (_ADMIN) {
									echo ' '.$edit_link;
								}
								break;
							default:
								echo $tag;
						}
					}
				} else if (_ADMIN) {
					echo '<p>'.$edit_link.'</p>';
				}
			}
		}
		if (!empty($currentPage) && ($num> $article_limit) && $on) {
			paginator( $currentPage, $totalPages, l('paginator'));
		}
		if (!empty($_POS) && empty($currentPage) && $infoline == true) {
			if ($commentable == 'YES') {
				comment('unfreezed');
			} else if ($commentable == 'FREEZ') {
				comment('freezed');
			}
		}
	}
}

// COMMENTS
function comment($freeze_status) {
 	echo '<h3>Comments</h3>';
 	global $categorySEF, $subcatSEF, $articleSEF, $_ID, $commentsPage;
 	if (isset($commentsPage)) {
 		$commentsPage = str_replace(l('comment_pages'),'',$commentsPage);
 	}
 	if (strpos($articleSEF, l('paginator')) === 0) {
 		$articleSEF = str_replace(l('paginator'), '', $articleSEF);
 	}
 	if (!isset($commentsPage) || !is_numeric($commentsPage) || $commentsPage < 1) {
 		$commentsPage = 1;
 	}
 	$comments_order = s('comments_order');
 	if (isset($_POST['comment'])) {
		$comment = cleanWords(trim($_POST['text']));
		$comment = strlen($comment) > 4 ? clean(cleanXSS($comment)) : null;
		$name = trim($_POST['name']);
		$name = strlen($name) > 1 ? clean(cleanXSS($name)) : null;
		$url = trim($_POST['url']);
		$url = (strlen($url) > 8 && strpos($url, '?') === false) ? clean(cleanXSS($url)) : null;
		$post_article_id = (is_numeric($_POST['id']) && $_POST['id'] > 0) ? $_POST['id'] : null;
		$ip = (strlen($_POST['ip']) < 16) ? clean(cleanXSS($_POST['ip'])) : null;
		if (_ADMIN) {
			$doublecheck = 1;
			$ident=1;
		} else {
			$contentCheck = retrieve('id', 'comments', 'comment', $comment);
			$ident = !$contentCheck || (time() - $_SESSION[_SITE.'poster']['time']) > s('comment_repost_timer') ||
				$_SESSION[_SITE.'poster']['ip'] !== $ip ? 1 : 0;
			$doublecheck = $_SESSION[_SITE.'poster']['article'] === "$comment:|:$post_article_id" &&
				(time()-$_SESSION[_SITE.'poster']['time']) < s('comment_repost_timer') ? 0 : 1;
		}
		if ($ip == $_SERVER['REMOTE_ADDR'] && $comment && $name && $post_article_id  &&
	 		checkMathCaptcha() && $doublecheck == 1 && $ident == 1) {
				$url = preg_match('/((http)+(s)?:(\/\/)|(www\.))([a-z0-9_\-]+)/', $url) ? $url : '';
				$url = substr($url, 0, 3) == 'www' ? 'http://'.$url : $url;
				$time = date('Y-m-d H:i:s');
				unset($_SESSION[_SITE.'poster']);
				$approved = s('approve_comments') != 'on'|| _ADMIN ? 'True' : '';
				$query = 'INSERT INTO '._PRE.'comments'.'(articleid, name, url, comment, time, approved) VALUES'.
					"('$post_article_id', '$name', '$url', '$comment', '$time', '$approved')";
				mysql_query($query);
				$_SESSION[_SITE.'poster']['article']="$comment:|:$post_article_id";
				$_SESSION[_SITE.'poster']['time'] = time();
				// this is to set session for checking multiple postings.
				$_SESSION[_SITE.'poster']['ip'] = $ip;
				$commentStatus = s('approve_comments') == 'on'&& !_ADMIN ? l('comment_sent_approve') : l('comment_sent');
				// eMAIL COMMENTS
				if (s('mail_on_comments') == 'on' && !_ADMIN) {
					if (s('approve_comments') == 'on') {
						$status = l('approved_text');
						$subject =l('subject_a');
					} else {
						$status = l('not_waiting_approved');
						$subject =l('subject_b');
					}
					$to = s('website_email');
					$send_array = array(
						'to'=>$to,
						'name'=>$name,
						'comment'=>$comment,
						'ip'=>$ip,
						'url'=>$url,
						'subject'=>$subject,
						'status'=>$status);
					send_email($send_array);
				}
				// End of Mail
		} else {
			$commentStatus = l('comment_error');
			$commentReason = l('ce_reasons');
			$fail = true;
			$_SESSION[_SITE.'comment']['name'] = $name;
			$_SESSION[_SITE.'comment']['comment'] = br2nl($comment);
			$_SESSION[_SITE.'comment']['url'] = $url;
			$_SESSION[_SITE.'comment']['fail'] = $fail;
		}
		echo '<h2>'.$commentStatus.'</h2>';
		if (!empty($commentReason)) {
			echo '<p>'.$commentReason.'</p>';
		}
		$postArt = clean(cleanXSS($_POST['article']));
		$postArtID = retrieve('category','articles','id',$post_article_id);
		if ($postArtID == 0) {
			$postCat = '' ;
		} else {
			$postCat = cat_rel($postArtID, 'seftitle').'/';
		}
		if ($fail){
			$back_link = _SITE.$postCat.$postArt;
			echo '<a href="'.$back_link.'/">'.l('back').'</a>';
		} else {
			echo '<meta http-equiv="refresh" content="1; url='._SITE.$postCat.$postArt.'/">';
		}
	} else {
		$commentCount = s('comment_limit');
		$comment_limit = (empty($commentCount) || $commentCount < 1) ? 100 : $commentCount;
		if (isset($commentsPage)) {
			$pageNum = $commentsPage;
		}
		$offset = ($pageNum - 1) * $comment_limit;
		$totalrows = 'SELECT count(id) AS num FROM '._PRE.'comments'.'
			WHERE articleid = '.$_ID.' AND approved = \'True\';';
		$rowsresult = mysql_query($totalrows);
		$numrows = mysql_fetch_array($rowsresult);
		$numrows = $numrows['num'];
/**** redundant/excessive
	/*	if ($numrows == 0) {
			if ($freeze_status != 'freezed' && s('freeze_comments') != 'YES') {
				echo '<p>'.l('no_comment').'</p>';
			} else {
				echo '<p>'.l('frozen_comments').'</p>';
			}
		} else {
/**** end redundant/excessive*****/
		if ($numrows > 0) {
			$query = 'SELECT
					id,articleid,name,url,comment,time,approved
				FROM '._PRE.'comments'.'
				WHERE articleid = '.$_ID.'
					AND approved = \'True\'
				ORDER BY id '.$comments_order.'
				LIMIT '."$offset, $comment_limit";
			$result = mysql_query($query) or die(l('dberror'));
			$ordinal = 1;
			$date_format = s('date_format');
			$edit_link = ' <a href="'._SITE.'?action=';
			while ($r = mysql_fetch_array($result)) {
				$date = date($date_format, strtotime($r['time']));
				$commentNum = $offset + $ordinal;
				$tag = explode(',', tags('comments'));
				foreach ($tag as $tag) {
			 	switch (true) {
					case ($tag == 'date'):
						echo '<a id="'.l('comment').$commentNum.'"
							name="'.l('comment').$commentNum.'"></a>'.$date;
						break;
					case ($tag == 'name'):
						$name = $r['name'];
						echo !empty($r['url']) ?
							'<a href="'.$r['url'].'" title="'.$r['url'].'" rel="nofollow">
							'.$name.'</a> ' : $name;
						break;
					case ($tag == 'comment'):
						echo $r['comment'];
						break;
					case ($tag == 'edit' && _ADMIN):
						echo $edit_link.'editcomment&amp;commentid='.$r['id'].'"
							title="'.l('edit').' '.l('comment').'">'.l('edit').'</a> ';
						echo $edit_link.'process&amp;task=deletecomment&amp;commentid='.$r['id'].'"
							title="'.l('delete').' '.l('comment').'" onclick="return pop()">'.l('delete').'</a>';
						break;
					case ($tag == 'edit'): ;
						break;
					default:
						echo $tag;
				}
			}
			$ordinal++;
		}
		$maxPage = ceil($numrows / $comment_limit);
		$back_to_page = ceil(($numrows + 1) / $comment_limit);
		if ($maxPage > 1) {
			paginator($pageNum, $maxPage,l('comment_pages'));
		}
	}
	if ($freeze_status != 'freezed' && s('freeze_comments') != 'YES') {
/*added 24 jan 2009*/ if ($numrows == 0) {echo '<p>'.l('no_comment').'</p>';}
		// recall and set vars for reuse when botched post
		if($_SESSION[_SITE.'comment']['fail'] == true) {
			$name = $_SESSION[_SITE.'comment']['name'];
			$comment = $_SESSION[_SITE.'comment']['comment'];
			$url = $_SESSION[_SITE.'comment']['url'];
			unset($_SESSION[_SITE.'comment']);
		} else {
			$url = $name = $comment = '';
		}
		// end var retrieval
		$art_value = empty($articleSEF) ? $subcatSEF : $articleSEF;
		echo '<div class="commentsbox"><h2>'.l('addcomment').'</h2>'."\r\n";
		echo '<p>'.l('required').'</p>'."\r\n";
		echo html_input('form', '', 'post', '', '', '', '', '', '', '', '', '', 'post', _SITE, '')."\r\n";
		echo html_input('text', 'name', 'name', $name, '* '.l('name'), 'text', '', '', '', '', '', '', '', '', '')."\r\n";
		echo html_input('text', 'url', 'url', $url, l('url'), 'text', '', '', '', '', '', '', '', '', '')."\r\n";
		echo html_input('textarea', 'text', 'text', $comment, '* '.l('comment'), '', '', '', '', '', '5', '5', '', '', '')."\r\n";
		echo mathCaptcha()."\r\n";
		echo '<p>';
		echo html_input('hidden', 'category', 'category', $categorySEF, '', '', '', '', '', '', '', '', '', '', '')."\r\n";
		echo html_input('hidden', 'id', 'id', $_ID, '', '', '', '', '', '', '', '', '', '', '')."\r\n";
		echo html_input('hidden', 'article', 'article', $art_value, '', '', '', '', '', '', '', '', '', '', '')."\r\n";
		echo html_input('hidden', 'commentspage', 'commentspage', $back_to_page, '', '', '', '', '', '', '', '', '', '', '')."\r\n";
		echo html_input('hidden', 'ip', 'ip', $_SERVER['REMOTE_ADDR'], '', '', '', '', '', '', '', '', '', '', '')."\r\n";
		echo html_input('hidden', 'time', 'time', time(), '', '', '', '', '', '', '', '', '', '', '');
		echo html_input('submit', 'comment', 'comment', l('submit'), '', 'button', '', '', '', '', '', '', '', '', '')."\r\n";
		echo '</p></form></div>';
	} else {
		echo '<p>'.l('frozen_comments').'</p>';
		}
	}
}

// ARCHIVE
function archive($start = 0, $size = 200) {
	echo '<h2>'.l('archive').'</h2>';
	$query = 'SELECT id FROM '._PRE.'articles'.'
		WHERE position = 1
			AND published = 1
			AND visible = \'YES\'
		ORDER BY date DESC
		LIMIT '."$start, $size";
	$result = mysql_query($query);
	$count = mysql_num_rows($result);
	if ($count === 0) {
		echo '<p>'.l('no_articles').'</p>';
	} else {
		while ($r = mysql_fetch_array($result)) {
			$Or_id[] = 'a.id ='.$r['id'];
		}
		$Or_id = implode(' OR ',$Or_id);
		$query = 'SELECT
				title,a.seftitle AS asef,a.date AS date,
				c.name AS name,c.seftitle AS csef,
				x.name AS xname,x.seftitle AS xsef
			FROM '._PRE.'articles'.' AS a
			LEFT OUTER JOIN '._PRE.'categories'.' as c
				ON category = c.id
			LEFT OUTER JOIN '._PRE.'categories'.' as x
				ON c.subcat =  x.id
			WHERE ('.$Or_id.')
				AND a.published = 1
				AND c.published =\'YES\'
				AND (x.published =\'YES\' || x.published IS NULL)
			ORDER BY date DESC
				LIMIT '."$start, $size";
		$result = mysql_query($query);
		$month_names = explode(', ', l('month_names'));
		$dot = l('divider');
		echo '<p>';
		while ($r = mysql_fetch_array($result)) {
			$year = substr($r['date'], 0, 4);
			$month = substr($r['date'], 5, 2) -1;
			$month_name = (substr($month, 0, 1) == 0) ? $month_names[substr($month, 1, 1)] : $month_names[$month];
			if ($last <> $year.$month) {
				echo '<strong>'.$month_name.', '.$year.'</strong><br />';
			}
			$last = $year.$month;
			$link = isset($r['xsef']) ? $r['xsef'].'/'.$r['csef'] : $r['csef'];
			echo $dot.' <a href="'._SITE.$link.'/'.$r['asef'].'/">
				'.$r['title'].' ('.$r['name'].')</a><br />';
		}
		echo'</p>';
	}
}

// SITEMAP
function sitemap() {
	echo '<h2>'.l('sitemap').'</h2>
		<h3><strong>'.l('pages').'</strong></h3>
		<ul>';
	$link = '<li><a href="'._SITE;
	echo $link.'">'.l('home').'</a></li>';
	echo $link.'archive/">'.l('archive').'</a></li>';
	$query = "SELECT title,seftitle
		FROM "._PRE.'articles'."
		WHERE position = 3
			AND published = 1
			AND visible = 'YES'
		ORDER BY artorder ASC, date, id";
	$result = mysql_query($query);
	while ($r = mysql_fetch_array($result)) {
		echo $link.$r['seftitle'].'/">'.$r['title'].'</a></li>';
	}
	echo $link.'contact/">'.l('contact').'</a></li>';
	echo $link.'sitemap/">'.l('sitemap').'</a></li>';
	echo '</ul>
		<h3><strong>'.l('articles').'</strong></h3>
		<ul>';
	$art_query = 'SELECT title, seftitle, date
		FROM '._PRE.'articles'.'
		WHERE position = 1
			AND published = 1
			AND visible = \'YES\'';
	$cat_query = 'SELECT id, name, seftitle, description, subcat
		FROM '._PRE.'categories'.'
		WHERE published = \'YES\'
			AND subcat = 0
			ORDER BY catorder,id';
	$cat_result = mysql_query($cat_query);
	if (mysql_num_rows($cat_result) == 0) {
		echo '<li>'.l('no_articles').'</li></ul>';
	} else {
		while ($c = mysql_fetch_array($cat_result)) {
			$category_title = $c['seftitle'];
			echo '<li><strong><a href="'._SITE.$category_title.'/" title="'.$c['description'].'">
				'.$c['name'].'</a></strong>';
			$catid = $c['id'];
			$query = $art_query.' AND category = '.$catid.' ORDER BY id DESC';
			$result = mysql_query($query);
			if (mysql_num_rows($result) > 0) {
				echo '<ul>';
			}
			while ($r = mysql_fetch_array($result)) {
				echo '<li>'.l('divider').'  <a href="'._SITE.$category_title.'/'.$r['seftitle'].'/">
					'.$r['title'].'</a></li>';
			}
			if (mysql_num_rows($result) > 0) {
				echo '</ul>';
			}
			$subcat_result = mysql_query('SELECT id, name, seftitle, description, subcat
				FROM '._PRE.'categories'.'
				WHERE published = \'YES\'
					AND subcat = '.$c['id'].'
				ORDER BY catorder ASC');
			if (mysql_num_rows($subcat_result) > 0) {
				echo '<ul>';
			}
			while ($s = mysql_fetch_array($subcat_result)) {
				$subcat_title = $s['seftitle'];
				$subcat_name = $s['name'];
				echo '<li class="subcat"><strong><a href="'.
					_SITE.$category_title.'/'.$subcat_title.'/" title="'.$s['description'].'">'.$subcat_name.'</a></strong>';
				$subcatid = $s['id'];
				$query = $art_query.' AND category = '.$subcatid.' ORDER BY id DESC';
				$artresult = mysql_query($query);
				if (mysql_num_rows($artresult) > 0) {
					echo '<ul>';
				}
				while ($r = mysql_fetch_array($artresult)) {
					echo '<li class="subcat">'.l('divider').'
						<a href="'._SITE.$category_title.'/'.$subcat_title.'/'.$r['seftitle'].'/">
						'.$r['title'].'</a></li>';
				}
				if (mysql_num_rows($artresult) > 0) {
					echo '</ul>';
				}
				echo '</li>';
			}
			if (mysql_num_rows($subcat_result) > 0) {
				echo '</ul>';
			}
			echo '</li>';
		}
		echo '</ul>';
	}
}

// CONTACT FORM
function contact() {
 	if (!isset($_POST['contactform'])) {
		echo '<div class="commentsbox"><h2>'.l('contact').'</h2>';
		echo '<p>'.l('required').'</p>';
		echo html_input('form', '', 'post', '', '', '', '', '', '', '', '', '', 'post', _SITE, '');
		echo html_input('text', 'name', 'name', '', '* '.l('name'), 'text', '', '', '', '', '', '', '', '', '');
		echo html_input('text', 'email', 'email', '', '* '.l('email'), 'text', '', '', '', '', '', '', '', '', '');
		echo html_input('text', 'weblink', 'weblink', '', l('url'), 'text', '', '', '', '', '', '', '', '', '');
		echo html_input('textarea', 'message', 'message', '', '* '.l('message'), '', '', '', '', '', '5', '5', '', '', '');
		echo mathCaptcha();
		echo '<p>';
		echo html_input('hidden', 'ip', 'ip', $_SERVER['REMOTE_ADDR'], '', '', '', '', '', '', '', '', '', '', '');
		echo html_input('hidden', 'time', 'time', time(), '', '', '', '', '', '', '', '', '', '', '');
		echo html_input('submit', 'contactform', 'contactform', l('submit'), '', 'button', '', '', '', '', '', '', '', '', '');
		echo '</p></form></div>';
		$_SESSION[_SITE.'contact'] = 0;
	} else {
		$to = s('website_email');
		$subject = s('contact_subject');
		$name = trim($_POST['name']);
		$name = strlen($name) > 1 ? clean(cleanXSS($name)) : null;
		$mail = trim($_POST['email']);
		$mail = (strlen($mail) > 7 && preg_match
			( '/^[A-Z0-9._-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z.]{2,6}$/i' , $mail)) ? clean(cleanXSS($mail)) : null;
		$url = trim($_POST['weblink']);
		$url = (strlen($url) > 8 && strpos($url, '?') === false) ? clean(cleanXSS($url)) : null;
		$message = trim($_POST['message']);
		$message = strlen($message) > 9 ? stripslashes(cleanXSS($message)) : null;
		$message = strip_tags($message);
		$now = is_numeric($_POST['time']) ? $_POST['time'] : null;
		$ip = (strlen($_POST['ip']) < 16) ? clean(cleanXSS($_POST['ip'])) : null;
		if($_SESSION[_SITE.'contact'] == 0){
	 		if ($ip == $_SERVER['REMOTE_ADDR'] && (time() - $now) > 4 && $name && $mail && $message && checkMathCaptcha()) {
				echo notification(0,l('contact_sent'),'home');
				$_SESSION[_SITE.'contact'] = 1;
				$send_array = array(
					'to'=>$to,
					'name'=>$name,
					'email'=>$mail,
					'message'=>$message,
					'ip'=>$ip,
					'url'=>$url,
					'subject'=>$subject);
				send_email($send_array);
		 	} else {
				echo notification(1,l('contact_not_sent'),'contact');
			}
		}
	}
}

// MENU ARTICLES
function menu_articles($start = 0, $size = 5, $cat_specific = 0) {
	global $categorySEF, $_catID,$subcatSEF;
	switch ($cat_specific){
		case 1 :
			$subcat = !empty($_catID) && empty($subcatSEF) ? 'AND c.subcat = '.$_catID : '';
			break;
		case 2 :
			$subcat = !empty($_catID) ? 'AND c.subcat = '.$_catID : '';
			break;
		default:
			$subcat = '';
	}
	$query = 'SELECT
			title,a.seftitle AS asef,date,
			c.name AS name,c.seftitle AS csef,
			x.name AS xname,x.seftitle AS xsef
		FROM '._PRE.'articles'.' AS a
		LEFT OUTER JOIN '._PRE.'categories'.' as c
			ON category = c.id
		LEFT OUTER JOIN '._PRE.'categories'.' as x
			ON c.subcat =  x.id AND x.published =\'YES\'
		WHERE position = 1
			AND a.published = 1
			AND c.published =\'YES\'
			AND a.visible = \'YES\'
			'.$subcat.'
		ORDER BY date DESC
			LIMIT '."$start, $size";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		if ( $count === 0) {
			echo '<li>'.l('no_articles').'</li>';
		} else {
			while ($r = mysql_fetch_array($result)) {
				$name = s('show_cat_names') == 'on' ? ' ('.$r['name'].')' : '';
				$date = date(s('date_format'), strtotime($r['date']));
				$link = isset($r['xsef']) ? $r['xsef'].'/'.$r['csef'] : $r['csef'];
				echo  '<li><a href="'._SITE.$link.'/'.$r['asef'].'/"
						title="'.$r['name'].' / '.$r['title'].' ('.$date.')">'.$r['title'].$name.'</a>
					</li>';
		}
	}
}

// NEW COMMENTS
function new_comments($number = 5, $stringlen = 30) {
	$query = 'SELECT
			a.id AS aid,title,a.seftitle AS asef,
			category,co.id,articleid,co.name AS coname,comment,
			c.name,c.seftitle AS csef,c.subcat,
			x.name,x.seftitle AS xsef
		FROM '._PRE.'comments'.' AS co
		LEFT OUTER JOIN '._PRE.'articles'.' AS a
			ON articleid = a.id
		LEFT OUTER JOIN '._PRE.'categories'.' AS c
			ON category = c.id AND c.published =\'YES\'
		LEFT OUTER JOIN '._PRE.'categories'.' AS x
			ON c.subcat = x.id AND x.published =\'YES\'
		WHERE a.published = 1 AND (a.commentable = \'YES\' || a.commentable = \'FREEZ\' )
			AND approved = \'True\'
		ORDER BY co.id DESC LIMIT '.$number;
	$result = mysql_query($query);
	if (mysql_num_rows($result) === 0) {
		echo '<li>'.l('no_comments').'</li>';
	} else {
	 	$comlim = s('comment_limit');
	 	$comment_limit = $comlim < 1 ? 1 : $comlim;
	 	$comments_order = s('comments_order');
	 	while ($r = mysql_fetch_array($result)) {
			$loopr = mysql_query("SELECT id FROM "._PRE.'comments'."
				WHERE articleid = '$r[articleid]'
				AND approved = 'True'
				ORDER BY id $comments_order");
			$num = 1;
			while ($r_art = mysql_fetch_array($loopr)) {
				if ($r_art['id'] == $r['id']) {
					$ordinal = $num;
				}
			$num++;
			}
			$name = $r['coname'];
			$comment = strip_tags($r['comment']);
			$page = ceil($ordinal / $comment_limit);
			$ncom = $name.' ('.$comment;
			$ncom = strlen($ncom) > $stringlen ? substr($ncom, 0, $stringlen - 3).'...' : $ncom;
			$ncom.= strlen($name) < $stringlen ? ')' : '';
			$ncom = str_replace(' ...', '...', $ncom);
			$paging = $page > 1 ? '/'.l('comment_pages').$page : '';
			$link = isset($r['xsef']) ? $r['xsef'].'/'.$r['csef'] : $r['csef'];
			$link .= '/'.$r['asef'];
			echo '<li><a href="'._SITE.$link.$paging.'/#'.l('comment').$ordinal.'"
					title="'.l('comment_info').' '.$r['title'].'">'.$ncom.'</a>
				</li>';
		}
	}
}

// SEARCH FORM
function searchform() { ?>
	<form id="search_engine" method="post" action="<?php echo _SITE; ?>" accept-charset="<?php echo s('charset');?>">
		<p><input class="searchfield" name="search_query" type="text" id="keywords" value="<?php echo l('search_keywords');
?>" onfocus="document.forms['search_engine'].keywords.value='';" onblur="if (document.forms['search_engine'].keywords.value == '') document.forms['search_engine'].keywords.value='<?php echo l('search_keywords'); ?>';" />
		<input class="searchbutton" name="submit" type="submit" value="<?php echo l('search_button')?>" /></p>
	</form>
<?php }

//SEARCH ENGINE
function search($limit = 20) {
	$search_query = clean(cleanXSS($_POST['search_query']));
	echo '<h2>'.l(search_results).'</h2>';
	if (strlen($search_query) < 4 || $search_query == l('search_keywords')) {
		echo '<p>'.l('charerror').'</p>';
	} else {
		$keywords = explode(' ', $search_query);
		$keyCount = count($keywords);
		$query = 'SELECT a.id
			FROM '._PRE.'articles'.' AS a
			LEFT OUTER JOIN '._PRE.'categories'.' as c
				ON category = c.id AND c.published =\'YES\'
			LEFT OUTER JOIN '._PRE.'categories'.' as x
				ON c.subcat =  x.id AND x.published =\'YES\'
			WHERE position != 2
				AND a.published = 1
				AND';
		if(!_ADMIN){
			$query = $query.' a.visible = \'YES\' AND ';
		}
		if ($keyCount > 1) {
			for ($i = 0; $i < $keyCount - 1; $i++) {
				$query = $query.' (title LIKE "%'.$keywords[$i].'%" ||
					text LIKE "%'.$keywords[$i].'%" ||
					keywords_meta LIKE "%'.$keywords[$i].'%") &&';
			}
			$j = $keyCount - 1;
			$query = $query.'(title LIKE "%'.$keywords[$j].'%" ||
				text LIKE "%'.$keywords[$j].'%" ||
				keywords_meta LIKE "%'.$keywords[$j].'%")';
		} else {
			$query = $query.'(title LIKE "%'.$keywords[0].'%" ||
				text LIKE "%'.$keywords[0].'%" ||
				keywords_meta LIKE "%'.$keywords[0].'%")';
		}
		$query = $query.' ORDER BY id DESC LIMIT '.$limit;
		$result = mysql_query($query);
		$numrows = mysql_num_rows($result);
		if (!$numrows) {
			echo '<p>'.l('noresults').'
				<strong>'.stripslashes($search_query).'</strong>.</p>';
		} else {
			echo '<p><strong>'.$numrows.'</strong> '.l('resultsfound').' <strong>'.
			stripslashes($search_query).'</strong>.</p>';
			while ($r = mysql_fetch_array($result)) {
				$Or_id[] = 'a.id ='.$r['id'];
			}
			$Or_id = implode(' OR ',$Or_id);
			$query = 'SELECT
					title,a.seftitle AS asef,a.date AS date,
					c.name AS name,c.seftitle AS csef,
					x.name AS xname,x.seftitle AS xsef
				FROM '._PRE.'articles'.' AS a
				LEFT OUTER JOIN '._PRE.'categories'.' as c
					ON category = c.id
				LEFT OUTER JOIN '._PRE.'categories'.' as x
					ON c.subcat =  x.id
				WHERE '.$Or_id;
			$result = mysql_query($query);
			while ($r = mysql_fetch_array($result)) {
				$date = date(s('date_format'), strtotime($r['date']));
				if ($r['name']) $name = ' ('.$r['name'].')';
				if (isset($r['xsef']))  $link = $r['xsef'].'/'.$r['csef'].'/';
				else $link = isset($r['csef']) ? $r['csef'].'/' : '';
				echo '<p><a href="'._SITE.$link.$r['asef'].'/">'.$r['title'].$name.'</a> - '.$date.'</p>';
			}
		}
	}
	echo '<p><br /><a href="'._SITE.'">'.l('backhome').'</a></p>';
}

// RSS FEED - ARTICLES/PAGES/COMMENTS
function rss_contents($rss_item, $artSEF=''){
 	header('Content-type: text/xml; charset='.s('charset').'');
 	$limit = s('rss_limit');
 	switch($rss_item) {
		case 'rss-articles':
			$heading = l('articles');
			$query = _PRE.'articles'.' WHERE position = 1 AND visible = \'YES\' AND published = 1 ORDER BY date';
			break;
		case 'rss-pages':
			$heading = l('pages');
			$query = _PRE.'articles'.' WHERE position = 3 AND visible = \'YES\' AND published = 1 ORDER BY date';
			break;
		case 'rss-comments':
			$heading = l('comments');
			$query = _PRE.'comments'." WHERE approved = 'True' ORDER BY id";
			break;
	}
 	echo '<?xml version="1.0" encoding="'.s('charset').'"?>
 		<rss version="2.0"><channel>
 		<title><![CDATA['.s('website_title').']]></title>
 		<description><![CDATA['.$heading.']]></description>
 		<link>'._SITE.'</link>
 		<copyright><![CDATA[Copyright '.s('website_title').']]></copyright>
 		<generator>sNews CMS</generator>';
 	$result = mysql_query("SELECT * FROM $query DESC LIMIT $limit");
 	$numrows = mysql_num_rows($result);
 	$comments_order = s('comments_order');
 	$ordinal = $comments_order == 'DESC' ? 1 : $numrows;
 	$comment_limit = s('comment_limit') < 1 ? 1 : s('comment_limit');
 	$comments_order = s('comments_order');
 	while ($r = mysql_fetch_assoc($result)) {
		switch($rss_item) {
			case 'rss-articles':
			case 'rss-pages':
				$date = date('D, d M Y H:i:s +0000', strtotime($r['date']));
				if ($r['category'] == 0) {
					$categorySEF = '';
				} else {
					$categorySEF = cat_rel($r['category'], 'seftitle').'/';
				}
				$articleSEF = $r['seftitle'];
				$title = $r['title'];
				$text = $r['text'];
				break;
			case 'rss-comments':
				$subquery = "SELECT id FROM "._PRE.'comments'."
					WHERE articleid = ".$r['articleid']."
					ORDER BY id $comments_order";
				$subresult = mysql_query($subquery);
				$num = 1;
				while ($subr = mysql_fetch_array($subresult)) {
					if ($subr['id'] == $r['id']) {
						$ordinal = $num;
					}
					$num++;
				}
				$page = ceil($ordinal / $comment_limit);
				$articleSEF = retrieve('seftitle', 'articles', 'id', $r['articleid']);
				$articleCat = retrieve('category', 'articles', 'id', $r['articleid']);
				$articleTitle = retrieve('title', 'articles', 'id', $r['articleid']);
				if ($articleCat == 0) {
					$categorySEF = '';
				} else {
					$categorySEF = cat_rel($articleCat, 'seftitle').'/';
				}
				if (!empty($articleSEF)) {
					$paging = $page > 1 ? $page.'/' : '';
					$comment_link = $paging.'#'.l('comment').$ordinal;
				}
				$date = date('D, d M Y H:i:s +0000', strtotime($r['time']));
				$title = $articleTitle.' - '.$r['name'];
				$text = $r['comment'];
				break;
		}
		$link = _SITE.$categorySEF.$articleSEF.'/'.$comment_link;
		$item  =
			'<item>
			<title><![CDATA['.strip($title).']]></title>
			<description>
				<![CDATA[
				'.strip($text).'
				]]>
			</description>
			<pubDate>'.$date.'</pubDate>
			<link>'.$link.'</link>
			<guid>'.$link.'</guid>
			</item>';
			echo $item;
	}
	echo '</channel></rss>';
	exit;
}

// RSS FEED - LINK BUILDER
function rss_links(){
	global $categorySEF, $subcatSEF, $articleSEF, $_catID, $_No3;
	$_countArt = retrieve('COUNT(id)','articles','position','1');
	$_countPage = $_No3;
	$_countComment = retrieve('COUNT(id)','comments','approved','True');
	if (!$_countArt && !$_countPage && !$_countComment && !$_countArtComment) {
		echo '<li>'.l('no_rss').'</li>';
	} else {
		if ($_countArt) {
			echo '<li><a href="rss-articles/">'.l('rss_articles').'</a></li>';
		}
		if ($_countPage) {
			echo '<li><a href="rss-pages/">'.l('rss_pages').'</a></li>';
		}
		if ($_countComment) {
			echo '<li><a href="rss-comments/">'.l('rss_comments').'</a></li>';
		}
	}
}

/*** ADMINISTRATIVE FUNCTIONS ***/

// LOGIN
function login() {
	if (!_ADMIN) {
        echo '<div class="adminpanel">
		<h2>'.l('login').'</h2>';
		echo html_input('form', '', 'post', '', '', '', '', '', '', '', '', '', 'post', _SITE.'administration/', '');
		echo '<p>'.l('login_limit').'</p>';
		echo html_input('text', 'uname', 'uname', '', l('username'), 'text', '', '', '', '', '', '', '', '', '');
		echo html_input('password', 'pass', 'pass', '', l('password'), 'text', '', '', '', '', '', '', '', '', '');
		echo mathCaptcha();
		echo '<p>';
		echo html_input('hidden', 'Loginform', 'Loginform', 'True', '', '', '', '', '', '', '', '', '', '', '');
		echo html_input('submit', 'submit', 'submit', l('login'), '', 'button', '', '', '', '', '', '', '', '', '');
		echo '</p></form></div>';
	} else {
		echo '<h2>'.l('logged_in').'</h2>
			<p><a href="'._SITE.'logout/" title="'.l('logout').'">'.l('logout').'</a></p>';
	}
}

//CONTENTS COUNTER
function stats($field, $position) {
	if (!empty($position)) {
		$pos = " WHERE position = $position";
	} else {
		$pos = '';
	}
	$query = 'SELECT id FROM '._PRE.$field.$pos;
	$result = mysql_query($query);
	$numrows = mysql_num_rows($result);
	return $numrows;
}

// FORM GENERATOR
function html_input($type, $name, $id, $value, $label, $css, $script1, $script2, $script3, $checked, $rows, $cols, $method, $action, $legend) {
	$lbl = !empty($label) ? '<label for="'.$id.'">'.$label.'</label>' : '';
	$ID = !empty($id) ? ' id="'.$id.'"' : '';
	$style = !empty($css) ? ' class="'.$css.'"' : '';
	$js1 = !empty($script1) ? ' '.$script1 : '';
	$js2 = !empty($script2) ? ' '.$script2 : '';
	$js3 = !empty($script3) ? ' '.$script3 : '';
	$attribs = $ID.$style.$js1.$js2.$js3;
	$val = ' value="'.$value.'"';
	$input = '<input type="'.$type.'" name="'.$name.'"'.$attribs;
	switch($type) {
		case 'form': $output = (!empty($method) && $method != 'end') ?
			'<form method="'.$method.'" action="'.$action.'"'.$attribs.' accept-charset="'.s('charset').'">' : '</form>'; break;
		case 'fieldset': $output = (!empty($legend) && $legend != 'end') ?
			'<fieldset><legend'.$attribs.'>'.$legend.'</legend>' : '</fieldset>'; break;
		case 'text':
		case 'password': $output = '<p>'.$lbl.':<br />'.$input.$val.' /></p>'; break;
		case 'checkbox':
		case 'radio': $check = $checked == 'ok' ? ' checked="checked"' : ''; $output = '<p>'.$input.$check.' /> '.$lbl.'</p>'; break;
		case 'hidden':
		case 'submit':
		case 'reset':
		case 'button': $output = $input.$val.' />'; break;
		case 'textarea':
			$output = '<p>'.$lbl.':<br />
			<textarea name="'.$name.'" rows="'.$rows.'" cols="'.$cols.'"'.$attribs.'>'.$value.
			'</textarea></p>'; break;
	}
	return $output;
}

// ADMINISTRATION
function administration() {
   	if (!_ADMIN) {
		echo( notification(1,l('error_not_logged_in'),'login'));
	} else {
		$catnum = mysql_fetch_assoc(mysql_query("SELECT COUNT(id) as catnum FROM "._PRE.'categories'.""));
		foreach ($_POST as $key) {unset($_POST[$key]);}
		echo '<div class="adminpanel">';
		echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '',''.l('administration'));
		echo '<p>'.l('categories').': <a href="admin_category/">'.l('add_new').'</a>';
		$link = ' '.l('divider').' <a href="';
		if (stats('categories','') > 0) {
			echo $link.'snews_categories/">'.l('view').'</a>';
		}
		echo '</p><p>'.l('articles').': ';
		$art_new = $catnum['catnum'] > 0 ? '<a href="article_new/">'.l('add_new').'</a>' : l('create_cat');
		echo $art_new;
		if (stats('articles','1') > 0) {
			echo $link.'snews_articles/">'.l('view').'</a>';
		}
		echo '</p><p>'.l('pages').': <a href="page_new/">'.l('add_new').'</a>';
		if (stats('articles','3') > 0) {
			echo $link.'snews_pages/">'.l('view').'</a>';
		}
		echo '</p>';
		if (s('enable_extras') == 'YES') {
			echo '<div class="adminpanel2">';
			echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', l('extra_contents'));
			echo '<p>'.l('groupings').': <a href="admin_groupings/">'.l('add_new').'</a>';
			if (stats('extras','') > 0) {
				echo $link.'groupings/">'.l('view').'</a>';
			}
			echo '</p>';
		}
		echo '<p>'.l('extra_contents').': <a href="extra_new/">'.l('add_new').'</a>';
		if (stats('articles','2') > 0) {
			echo $link.'extra_contents/">'.l('view').'</a>';
		}
		echo '</p>';
		if (s('enable_extras') == 'YES') {
			echo '</fieldset></div>';
		}
		echo '</fieldset></div>';
		$query_comm = 'SELECT id,articleid,name FROM '._PRE.'comments'.' WHERE approved != \'True\'';
		$result_comm = mysql_query($query_comm);
		$unapproved = mysql_num_rows($result_comm);
		if ($unapproved > 0) {
			echo '<div class="adminpanel">';
			echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', l('comments'));
			echo '<p><a onclick="toggle(\'sub1\')" style="cursor: pointer;" title="'.l('unapproved').'">
				'.$unapproved.' '.l('wait_approval').'</a></p>';
			echo '<div id="sub1" style="display: none;">';
			while ($r = mysql_fetch_array($result_comm)) {
				$articleTITLE = retrieve('title', 'articles', 'id', $r['articleid']);
				echo '<p>'.$r['name'].' (<strong>'.$articleTITLE.'</strong>) '.l('divider').'
					<a href="'._SITE.'?action=editcomment&amp;commentid='.$r['id'].'">'.l('edit').'</a></p>';
			}
			echo '</div></fieldset></div>';
		}
		echo '<div class="adminpanel">';
		echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', l('site_settings'));
		echo '<p><a href="snews_settings/">'.l('settings').'</a></p>
			<p><a href="snews_files/">'.l('files').'</a></p></fieldset></div>
			<div class="adminpanel">';
		echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', l('login_status'));
		echo '<p><a href="logout/">'.l('logout').'</a></p></fieldset></div>';
	}
}

// SETTINGS FORM
function settings() {
	echo html_input('form', '', '', '', '', '', '', '', '', '', '', '', 'post', '?action=process&amp;task=save_settings', '');
	echo '<div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '','<a onclick="toggle(\'sub1\')" style="cursor: pointer;">'.l('settings').'</a>');
	echo '<div id="sub1" style="display: none;">';
	echo html_input('text', 'website_title', 'webtitle', s('website_title'), l('a_website_title'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'home_sef', 'webSEF', s('home_sef') == '' ? l('home_sef') : s('home_sef'), l('a_home_sef'), '', 'onkeypress="return SEFrestrict(event);"', '', '', '', '', '', '', '', '');
	echo html_input('text', 'website_description', 'wdesc', s('website_description'), l('a_description'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'website_keywords', 'wkey', s('website_keywords'), l('a_keywords'), '', '', '', '', '', '', '', '', '', '');
	echo '</div></fieldset></div><div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', '<a onclick="toggle(\'sub2\')" style="cursor: pointer;">'.l('a_contact_info').'</a>');
	echo '<div id="sub2" style="display: none;">';
	echo html_input('text', 'website_email', 'we', s('website_email'), l('a_website_email'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'contact_subject', 'cs', s('contact_subject'), l('a_contact_subject'), '', '', '', '', '', '', '', '', '', '');
	echo '</div></fieldset></div><div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', '<a onclick="toggle(\'sub3\')" style="cursor: pointer;">'.l('a_time_settings').'</a>');
	echo '<div id="sub3" style="display: none;">';
	echo html_input('text', 'language', 'lang', s('language') == '' ? 'EN' : s('language'), l('a_language'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'charset', 'char', s('charset') == '' ? 'UTF-8' : s('charset'), l('charset'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'date_format', 'dt', s('date_format'), l('a_date_format'), '', '', '', '', '', '', '', '', '', '');
	echo '</div></fieldset></div><div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '','<a onclick="toggle(\'sub4\')" style="cursor: pointer;">'.l('contents').'</a>');
	echo '<div id="sub4" style="display: none;">';
	echo html_input('text', 'article_limit', 'artl', s('article_limit'), l('a_article_limit'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'rss_limit', 'rssl', s('rss_limit'), l('a_rss_limit'), '', '', '', '', '', '', '', '', '', '');
	echo '<p><label for="dp">'.l('a_display_page').':</label><br /> <select name="display_page" id="dp">';
	echo '<option value="0"'.(s('display_page') == 0 ? ' selected="selected"' : '').'>'.l('none').'</option>';
	$query = 'SELECT id,title FROM '._PRE.'articles'.' WHERE position = 3 ORDER BY id ASC';
	$result = mysql_query($query);
	while ($r = mysql_fetch_array($result)) {
		echo '<option value="'.$r['id'].'"';
		if (s('display_page') == $r['id']) {
			echo ' selected="selected"';
		}
		echo '>'.$r['title'].'</option>';
	}
	echo '</select></p>';
	echo html_input('checkbox', 'display_new_on_home', 'dnoh', '', l('a_display_new_on_home'), '', '', '', '', (s('display_new_on_home') == 'on' ? 'ok' : ''), '', '', '', '', '');
	echo html_input('checkbox', 'display_pagination', 'dpag', '', l('a_display_pagination'), '', '', '', '', (s('display_pagination') == 'on' ? 'ok' : ''), '', '', '', '', '');
	echo html_input('checkbox', 'num_categories', 'nc', '', l('a_num_categories'), '', '', '', '', (s('num_categories') == 'on' ? 'ok' : ''), '', '', '', '', '');
	echo html_input('checkbox', 'show_cat_names', 'scn', '', l('a_show_category_name'), '', '', '', '', (s('show_cat_names') == 'on' ? 'ok' : ''), '', '', '', '', '');
	echo html_input('checkbox', 'enable_extras', 'ee', '', l('enable_extras'), '', '', '', '', (s('enable_extras') == 'YES' ? 'ok' : ''), '', '', '', '', '');

	echo html_input('text', 'file_ext', 'fileext', s('file_extensions'), l('file_extensions'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'allowed_file', 'all_file', s('allowed_files'), l('allowed_files'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'allowed_img', 'all_img', s('allowed_images'), l('allowed_images'), '', '', '', '', '', '', '', '', '', '');

	echo '</div></fieldset></div><div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', '<a title="'.l('comments').'" onclick="toggle(\'sub5\')" style="cursor: pointer;">'.l('comments').'</a>');
	echo '<div id="sub5" style="display: none;">';
	echo html_input('checkbox', 'approve_comments', 'ac', '', l('a_approve_comments'), '', '', '', '', (s('approve_comments') == 'on' ? 'ok' : ''), '', '', '', '', '');
	echo html_input('text', 'comment_repost_timer', 'crt', s('comment_repost_timer'), l('comment_repost_timer'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('checkbox', 'mail_on_comments', 'mc', '', l('a_mail_on_comments'), '', '', '', '', (s('mail_on_comments') == 'on' ? 'ok' : ''), '', '', '', '', '');
	echo html_input('checkbox', 'enable_comments', 'ec', '', l('enable_comments'), '', '', '', '', (s('enable_comments') == 'YES' ? 'ok' : ''), '', '', '', '', '');
	echo html_input('checkbox', 'freeze_comments', 'dc', '', l('freeze_comments'), '', '', '', '', (s('freeze_comments') == 'YES' ? 'ok' : ''), '', '', '', '', '');
	echo '<p><label for="co">'.l('a_comments_order').':</label><br /><select id="co" name="comments_order">';
	echo '<option value="DESC"'.(s('comments_order') == 'DESC' ? ' selected="selected"' : '').'>'.l('newer_top').'</option>';
	echo '<option value="ASC"'.(s('comments_order') == 'ASC' ? ' selected="selected"' : '').'>'.l('newer_bottom').'</option></select></p>';
	echo html_input('text', 'comment_limit', 'cl', s('comment_limit'), l('a_comment_limit'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('checkbox', 'word_filter_enable', 'wfe', '', l('a_word_filter_enable'), '', '', '', '', (s('word_filter_enable') == 'on' ? 'ok' : ''), '', '', '', '', '');
	echo html_input('text', 'word_filter_file', 'wff', s('word_filter_file'), l('a_word_filter_file'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'word_filter_change', 'wfc', s('word_filter_change'), l('a_word_filter_change'), '', '', '', '', '', '', '', '', '', '');
	echo '</div></fieldset></div><p>';
	echo html_input('submit', 'save', 'save', l('save'), '', 'button', '', '', '', '', '', '', '', '', '');
	echo '</p></form>';
	echo html_input('form', '', '', '', '', '', '', '', '', '', '', '', 'post', '?action=process&amp;task=changeup', '');
  echo '<div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', '<a title="'.l('change_up').'" onclick="toggle(\'sub6\')" style="cursor: pointer;">'.l('change_up').'</a>');
	echo '<div id="sub6" style="display: none;">';
	echo '<p>'.l('login_limit').'</p>';
	echo html_input('text', 'uname', 'uname', '', l('a_username'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('password', 'pass1', 'pass1', '', l('a_password'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('password', 'pass2', 'pass2', '', l('a_password2'), '', '', '', '', '', '', '', '', '', '');
	echo '<p>';
	echo html_input('hidden', 'task', 'task', 'changeup', '', '', '', '', '', '', '', '', '', '', '');
	echo html_input('submit', 'submit_pass', 'submit_pass', l('save'), '', 'button', '', '', '', '', '', '', '', '', '');
	echo '</p></div></fieldset></div></form>';
}

// LISTS CATEGORIES
function category_list($id) {
	if (isset($_GET['id']) && is_numeric($_GET['id']) && !is_null($_GET['id'])) {
		$var = $id;
	}
	echo '<select name="subcat" id="subcat">';
	$selected =' selected="selected"';
	$result = mysql_query('SELECT id,name FROM '._PRE.'categories'.'
			WHERE subcat = 0 ORDER BY catorder, id');
	if (!empty($var)) {
		$parent_selection = $selected;
	}
   	echo '<option value="0"'.$parent_selection.'>'.l('not_sub').'</option>';
   	while ($r = mysql_fetch_array($result)) {
		$child = retrieve('subcat','categories','id',$var);
		if ($r['id'] == $child) {
			echo '<option value="'.$r['id'].'"'.$selected.'>'.$r['name'].'</option>';
		} elseif ($id!=$r['id']){
    		echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
		}
	}
	echo '</select>';
}

// CATEGORIES FORM
function form_categories($subcat='cat') {
	if (isset($_GET['id']) && is_numeric($_GET['id']) && !is_null($_GET['id'])) {
		$categoryid = $_GET['id'];
		$query = mysql_query('SELECT id,name,seftitle,published,description,subcat,catorder FROM '._PRE.'categories'.' WHERE id='.$categoryid);
		$r = mysql_fetch_array($query);
		$jresult = mysql_query("select name from "._PRE.'categories'."
			where id = ".$r['subcat']);
		while($j = mysql_fetch_array($jresult)) {
			$name = $j['name'];
		}
		$frm_action = _SITE.'?action=process&amp;task=admin_category&amp;id='.$categoryid;
		$frm_add_edit = $r['subcat'] == '0' ? l('edit').' '.l('category') : l('edit').' '.l('subcategory').' '.$name ;
		$frm_name = $r['name'];
		$subcat = $r['subcat'] == 0 ? 'cat' : 'subcat';
		$frm_sef_title = $r['seftitle'];
		$frm_description = $r['description'];
		$frm_publish = $r['published'] == 'YES' ? 'ok' : '';
		$catorder = $r['catorder'];
		$frm_task = 'edit_category';
		$frm_submit = l('edit');
	} else {
		$sub_cat = isset($_GET['sub_id']) ? $_GET['sub_id'] : '0';
		if ($sub_cat!='cat') {
			$jresult = mysql_query('SELECT name FROM '._PRE.'categories'.' WHERE id = '.$sub_cat);
			while($j = mysql_fetch_array($jresult)) {
				$name = $j['name'];
			}
		}
		$frm_action = _SITE.'?action=process&amp;task=admin_category';
		$frm_add_edit = empty($sub_cat) ? l('add_category') : l('add_subcategory').' ('.$name.')';
		$frm_sef_title = $_POST['name'] == '' ? cleanSEF($_POST['name']) : cleanSEF($_POST['seftitle']);
		$frm_description = '';
		$frm_publish = 'ok';
		$frm_task = 'add_category';
		$frm_submit = l('add_category');
	}
	echo html_input('form', '', 'post', '', '', '', '', '', '', '', '', '', 'post', $frm_action, '');
	echo '<div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', $frm_add_edit);
	echo html_input('text', 'name', 't', $frm_name, l('name'), '', 'onchange="genSEF(this,document.forms[\'post\'].seftitle)"', 'onkeyup="genSEF(this,document.forms[\'post\'].seftitle)"', '', '', '', '', '', '', '');
	echo html_input('text', 'seftitle', 's', $frm_sef_title, l('sef_title_cat'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'description', 'desc', $frm_description, l('description'), '', '', '', '', '', '', '', '', '', '');
	if (empty($sub_cat)) {
		echo '<p>'.l('subcategory').': <br />'; category_list($categoryid); echo '</p>';
	}
	$publish = $subcat == 'cat' ? l('publish_category') : l('publish_subcategory');
	echo html_input('checkbox', 'publish', 'pub', 'YES', $publish, '', '', '', '', $frm_publish, '', '', '', '', '');
	echo '</fieldset></div><p>';
	if ($sub_cat) {
		echo html_input('hidden', 'subcat', 'subcat', $sub_cat, '', '', '', '', '', '', '', '', '', '', '');
	}
   	echo html_input('hidden', 'catorder', 'catorder', $catorder, '', '', '', '', '', '', '', '', '', '', '');
   	echo html_input('hidden', 'task', 'task', 'admin_category', '', '', '', '', '', '', '', '', '', '', '');
	echo html_input('submit', $frm_task, $frm_task, $frm_submit, '', 'button', '', '', '', '', '', '', '', '', '');
	if (!empty($categoryid)) {
		echo '&nbsp;&nbsp;';
		echo html_input('hidden', 'id', 'id', $categoryid, '', '', '', '', '', '', '', '', '', '', '');
		echo html_input('submit', 'delete_category', 'delete_category', l('delete'), '', 'button', 'onclick="javascript: return pop()"', '', '', '', '', '', '', '', '');
	}
	echo '</p></form>';
}

// CATEGORIES - ADMIN LIST
function admin_categories() {
	$add = ' - <a href="admin_category/">'.l('add_new').'</a>';
	$link = '?action=admin_category';
	$tab = 1;
	echo '<div class="adminpanel"><fieldset><legend>'.l('categories').$add.'</legend>';
	echo html_input('form', '', 'post', '', '', '', '', '', '', '', '', '', 'post', '?action=process&amp;task=reorder', '');
	echo '<p><input type="hidden" name="order" id="order" value="snews_categories" /></p>';
	$query = 'SELECT id, name, description, published, catorder FROM '._PRE.'categories'.' WHERE subcat = 0 ORDER BY catorder,id ASC';
	$result = mysql_query($query);
	if (!$result || !mysql_num_rows($result)) {
		echo '<p>'.l('category_not_exist').'</p>';
	} else {
		while ($r = mysql_fetch_array($result)) {
			$cat_input = '<input type="text" name="cat_'.$r['id'].'" value="'.$r['catorder'].'" size="1" tabindex="'.$tab.'" /> &nbsp;';
			echo '<p>'.$cat_input.'<strong>'.$r['name'].'</strong>
				'.l('divider').' <a href="'._SITE.$link.'&amp;id='.$r['id'].'" title="'.$r['description'].'">'.l('edit').'</a> ';
			echo $r['published'] != 'YES' ? ' '.l('divider').' ['.l('status').' '.l('unpublished').']' : '';
			echo ' '.l('divider').' <a href="'._SITE.$link.'&amp;sub_id='.$r['id'].'" title="'.$r['description'].'">
				'.l('add_subcategory').'</a></p>';
			$subquery = 'SELECT id,name,description,published,catorder
				FROM '._PRE.'categories'.' WHERE subcat = '.$r['id'].' ORDER BY catorder,id ASC';
			$subresult = mysql_query($subquery); $tab2 = 1;
			while ($sub = mysql_fetch_array($subresult)) {
				$subcat_input = '<input type="text" name="cat_'.$sub['id'].'" value="'.$sub['catorder'].'" size="1" tabindex="'.$tab2.'" /> &nbsp;';
				echo '<p class="subcat">'.$subcat_input.'<strong>'.$sub['name'].'</strong>
					'.l('divider').' <a href="'._SITE.$link.'&amp;id='.$sub['id'].'" title="'.$sub['description'].'">'.l('edit').'</a> ';
				echo ($sub['published'] != 'YES' ? ' '.l('divider').' ['.l('status').' '.l('unpublished').']' : '');
				echo '</p>'; $tab2++;
			}
			$tab++;
		}
	}
	echo '<p>'.html_input('submit', 'reorder', 'reorder', l('order_content'), '', 'button', '', '', '', '', '', '', '', '', '');
	echo '</p></form>';
	echo '</fieldset></div>';
}

// DELETE CATEGORY BY ID
function delete_cat($id){
	$catdata = mysql_fetch_array(mysql_query("SELECT catorder,subcat FROM "._PRE.'categories'." WHERE id = $id"));
	$cat_order = $catdata['catorder'];
	$cat_subcat = $catdata['subcat'];
	mysql_query("DELETE FROM "._PRE.'categories'." WHERE id = $id LIMIT 1");
	$query = mysql_query("SELECT id,catorder FROM "._PRE.'categories'."
		WHERE catorder > $cat_order AND subcat = $cat_subcat");
	while ($r = mysql_fetch_array($query)) {
		mysql_query("UPDATE "._PRE.'categories'." SET
			catorder = catorder - 1 WHERE id = $r[id]");
	}
}

// ARTICLES - POSTING TIME
function posting_time($time='') {
	echo '<p>'.l('day').':&nbsp;<select name="fposting_day">';
	$thisDay = !empty($time) ? substr($time, 8, 2) : intval(date('d'));
	for($i = 1; $i < 32; $i++) {
		echo '<option value="'.$i.'"';
		if($i == $thisDay) {
			echo ' selected="selected"';
		}
		echo '>'.$i.'</option>';
	}
	echo '</select>&nbsp;&nbsp;'.l('month').':&nbsp;<select name="fposting_month">';
	$thisMonth = !empty($time) ? substr($time, 5, 2) : intval(date('m'));
	for($i = 1; $i < 13; $i++) {
		echo '<option value="'.$i.'"';
		if($i == $thisMonth) {
			echo ' selected="selected"';
		}
		echo '>'. $i .'</option>';
	}
	echo '</select>&nbsp;&nbsp;'.l('year').':&nbsp;<select name="fposting_year">';
   	$PresentYear = intval(date('Y'));
   	$thisYear = !empty($time) ? substr($time, 0, 4) : $PresentYear;
   	for($i = $thisYear-3; $i < $PresentYear + 3; $i++) {
		echo '<option value="'.$i.'"';
		if($i == $thisYear) {
			echo ' selected="selected"';
		}
		echo '>'.$i.'</option>';
	}
	echo '</select>&nbsp;&nbsp;'.l('hour').':&nbsp;<select name="fposting_hour">';
	$thisHour = !empty($time) ? substr($time, 11, 2) : intval(date('H'));
	for($i = 0; $i < 24; $i++) {
		echo '<option value="'.$i.'"';
		if($i == $thisHour) {
			echo ' selected="selected"';
		}
		echo '>'.$i.'</option>';
	}
	echo '</select>&nbsp;&nbsp;'.l('minute').':&nbsp;<select name="fposting_minute">';
	$thisMinute = !empty($time) ? substr($time, 14, 2) : intval(date('i'));
	for($i = 0; $i < 60; $i++) {
		echo '<option value="'.$i.'"';
		if($i == $thisMinute) {
			echo ' selected="selected"';
		}
		echo '>'.$i.'</option>';
	}
	echo '</select></p>';
	return;
}

// ARTICLES FORM
function form_articles($contents) {
 	if (is_numeric($_GET['id']) && !is_null($_GET['id'])) {
		$id = $_GET['id'];
		$query = mysql_query('SELECT * FROM '._PRE.'articles'.' WHERE id='.$id);
		$r = mysql_fetch_array($query);
		$article_category = $r['category'];
		$edit_option = $r['position']==0 ? 1 : $r['position'];
		$edit_page = $r['page_extra'];
		$extraid = $r['extraid'];
		switch ($edit_option) {
			case 1:
				$frm_fieldset = l('edit').' '.l('article');
				$toggle_div='show';
				$frm_position1 = 'selected="selected"';
				break;
			case 2:
				$frm_fieldset = l('edit').' '.l('extra_contents');
				$toggle_div='show';
				$frm_position2 = 'selected="selected"';
				break;
			case 3:
				$frm_fieldset = l('edit').' '.l('page');
				$toggle_div='show';
				$frm_position3 = 'selected="selected"';
				break;
		}
		$frm_action = _SITE.'?action=process&amp;task=admin_article&amp;id='.$id;
		$frm_title = $_SESSION[_SITE.'temp']['title'] ? $_SESSION[_SITE.'temp']['title'] : $r['title'];
		$frm_sef_title = $_SESSION[_SITE.'temp']['seftitle'] ? cleanSEF($_SESSION[_SITE.'temp']['seftitle']) : $r['seftitle'];
		$frm_text = str_replace('&', '&amp;', $_SESSION[_SITE.'temp']['text'] ? $_SESSION[_SITE.'temp']['text'] : $r['text']);
		$frm_meta_desc = $_SESSION[_SITE.'temp']['description_meta'] ?
			cleanSEF($_SESSION[_SITE.'temp']['description_meta']) : $r['description_meta'];
		$frm_meta_key = $_SESSION[_SITE.'temp']['keywords_meta'] ?
			cleanSEF($_SESSION[_SITE.'temp']['keywords_meta']) : $r['keywords_meta'];
		$frm_display_title = $r['displaytitle'] == 'YES' ? 'ok' : '';
		$frm_display_info = $r['displayinfo'] == 'YES' ? 'ok' : '';
		$frm_publish = $r['published'] == 1 ? 'ok' : '';
		$show_in_subcats = $r['show_in_subcats'] == 'YES' ? 'ok' : '';
		$frm_showonhome = $r['show_on_home'] == 'YES' ? 'ok' : '';
		$frm_commentable = ($r['commentable'] == 'YES' || $r['commentable'] == 'FREEZ') ? 'ok' : '';
		$frm_task = 'edit_article';
		$frm_submit = l('edit');
	} else {
		switch ($contents) {
			case 'article_new':
				$frm_fieldset = l('article_new');
				$toggle_div='';
				$pos = 1;
				$frm_position1 = 'selected="selected"';
				break;
			case 'extra_new':
				$frm_fieldset = l('extra_new');
				$toggle_div='';
				$pos = 2;
				$frm_position2 = 'selected="selected"';
				break;
			case 'page_new':
				$frm_fieldset = l('page_new');
				$toggle_div='';
				$pos = 3;
				$frm_position3 = 'selected="selected"';
				break;
		}
		if (empty($frm_fieldset)) {
			$frm_fieldset =  l('article_new');
		}
		$frm_action = _SITE.'?action=process&amp;task=admin_article';
		$frm_title = $_SESSION[_SITE.'temp']['title'];
		$frm_sef_title = cleanSEF($_SESSION[_SITE.'temp']['seftitle']);
		$frm_text = $_SESSION[_SITE.'temp']['text'];
		$frm_meta_desc = cleanSEF($_SESSION[_SITE.'temp']['description_meta']);
		$frm_meta_key = cleanSEF($_SESSION[_SITE.'temp']['keywords_meta']);
		$frm_display_title = 'ok';
		$frm_display_info = ($contents == 'extra_new') ? '' : 'ok';
		$frm_publish = 'ok';
		$show_in_subcats = 'ok';
		$frm_showonhome = s('display_new_on_home') == 'on' ? 'ok' : '';
		$frm_commentable = ($contents == 'extra_new' || $contents == 'page_new' || s('enable_comments') != 'YES') ? '' : 'ok';
		$frm_task = 'add_article';
		$frm_submit = l('submit');
	}
	$catnum = mysql_fetch_assoc(mysql_query("SELECT COUNT(id) as catnum FROM "._PRE.'categories'.""));
 	if ($contents == 'article_new' && $catnum['catnum'] < 1) {
 		echo l('create_cat');
 	} else {
		echo html_input('form', '', 'post', '', '', '', '', '', '', '', '', '', 'post', $frm_action, '');
		echo '<div class="adminpanel">';
		if ($toggle_div=='show') {
			echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', '<a title="'.$frm_fieldset.
				'" onclick="toggle(\'edit_article\')" style="cursor: pointer;">'.$frm_fieldset.'</a>');
			echo '<div id="edit_article" style="display: none;">';
		} else {
			echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', $frm_fieldset);
		}
			echo html_input('text', 'title', 'at', $frm_title, l('title'), '', 'onchange="genSEF(this,document.forms[\'post\'].seftitle)"', 'onkeyup="genSEF(this,document.forms[\'post\'].seftitle)"', '', '', '', '', '', '', '');
		if ($contents == 'extra_new' || $edit_option == 2) {
			echo '<div style="display: none;">';
			echo html_input('text', 'seftitle', 'as', $frm_sef_title, l('sef_title'), '', '', '', '', '', '', '', '', '', '');
			echo '</div>';
		} else {
			echo html_input('text', 'seftitle', 'as', $frm_sef_title, l('sef_title'), '', '', '', '', '', '', '', '', '', '');
		}
		echo html_input('textarea', 'text', 'txt', $frm_text, l('text'), '', '', '', '', '', '2', '100', '', '', '');
		buttons();
		if ($contents != 'page_new' && $edit_option != 3) {
			echo '<p><label for="cat">';
			echo ($contents == 'extra_new' || $edit_option == 2) ?  l('appear_category') : l('category');
			if ($contents == 'extra_new' || $edit_option == 2) {
				echo ':</label><br /><select name="define_category" id="cat" onchange="dependancy(\'extra\');">';
				echo '<option value="-1"'.($article_category == -1 ? ' selected="selected"' : '').'>'.l('all').'</option>';
				echo '<option value="-3"'.($article_category == -3 ? ' selected="selected"' : '').'>'.l('page_only').'</option>';
		   	}
	   	else echo ':</label><br /><select name="define_category" id="cat" onchange="dependancy(\'snews_articles\');">';
		$category_query = 'SELECT id,name,subcat FROM '._PRE.'categories'.'
			WHERE published = \'YES\' AND subcat = 0 ORDER BY catorder,id ASC';
		$category_result = mysql_query($category_query);
		while ($cat = mysql_fetch_array($category_result)) {
			echo '<option value="'.$cat['id'].'"';
			if ($article_category == $cat['id']) {
				echo ' selected="selected"';
			}
			echo '>'.$cat['name'].'</option>';
			$subquery = 'SELECT id,name,subcat FROM '._PRE.'categories'.'
				WHERE subcat = '.$cat['id'].' ORDER BY catorder,id ASC';
			$subresult = mysql_query($subquery);
			while ($s = mysql_fetch_array($subresult)) {
				echo '<option value="'.$s['id'].'"';
				if ($article_category == $s['id']) {
					echo ' selected="selected"';
				}
				echo '>--'.$s['name'].'</option>';
			}
		}
		echo '</select></p>';
		if ($contents == 'extra_new' || $edit_option == 2) {
			$none_display = $article_category == -1 ? 'none' : 'inline';
			echo '<div id="def_page" style="display:'.$none_display.';"><p><label for="dp">'.l('appear_page').':</label>
				<br /><select name="define_page" id="dp">';
			echo '<option value="0"'.($edit_option != '2' ? ' selected="selected"' : '').'>'.l('all').'</option>';
			$query = 'SELECT id,title FROM '._PRE.'articles'.' WHERE position = 3 ORDER BY id ASC';
			$result = mysql_query($query);
			while ($r = mysql_fetch_array($result)) {
				echo '<option value="'.$r['id'].'"';
				if ($edit_page == $r['id']) {
					echo ' selected="selected"';
				}
				echo '>'.$r['title'].'</option>';
			}
			echo '</select><br />'.
			html_input('checkbox', 'show_in_subcats', 'asc', 'YES', l('show_in_subcats'), '', '', '', '', $show_in_subcats, '', '', '', '', '').'</p></div>';
		}
	}
	if ($contents == 'article_new' || $edit_option == 1) {
	 	echo html_input('checkbox', 'show_on_home', 'sho', 'YES', l('show_on_home'), '', '', '', '', $frm_showonhome, '', '', '', '', '');
	}
	echo html_input('checkbox', 'publish_article', 'pu', 'YES', l('publish_article'), '', '', '', '', $frm_publish, '', '', '', '', '');
	if ($toggle_div=='show') {
		echo '</div>';
	}
	echo '</fieldset></div><div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', '<a title="'.l('preview').
		'" onclick="toggle(\'preview\')" style="cursor: pointer;">'.l('preview').'</a>');
	echo '<div id="preview" style="display: none;"></div></fieldset></div><div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', '<a title="'.l('customize').
		'" onclick="toggle(\'customize\')" style="cursor: pointer;">'.l('customize').'</a>');
	echo '<div id="customize" style="display: none;">';
	if ($contents == 'extra_new' || $edit_option == 2) {
		if (s('enable_extras') == 'YES') {
			echo '<p><label for="ext">'.l('define_extra').'</label><br />';
			echo '<select name="define_extra" id="ext">';
			$extra_query = 'SELECT id,name FROM '._PRE.'extras'.' ORDER BY id ASC';
			$extra_result = mysql_query($extra_query);
			while ($ex = mysql_fetch_array($extra_result)) {
				echo '<option value="'.$ex['id'].'"';
				if ($extraid == $ex['id']) {
					echo ' selected="selected"';
				}
				echo '>'.$ex['name'].'</option>';
			}
			echo '</select></p>';
		} else {
			echo html_input('hidden', 'define_extra', 'ext', 1, '', '', '', '', '', '', '', '', '', '', '');
		}
	}
	if (!empty($id)) {
		echo '<p><label for="pos">'.l('position').':</label>
			<br /><select name="position" id="pos">';
		echo '<option value="1"'.$frm_position1.'>'.l('center').'</option>';
		echo '<option value="2"'.$frm_position2.'>'.l('side').'</option>';
		echo '<option value="3"'.$frm_position3.'>'.l('display_page').'</option>';
		echo '</select></p>';
	} else {
		echo html_input('hidden', 'position', 'position', $pos, '', '', '', '', '', '', '', '', '', '', '');
	}
	if ($contents != 'extra_new' && $edit_option != '2') {
		echo html_input('text', 'description_meta', 'dm', $frm_meta_desc, l('description_meta'), '', '', '', '', '', '', '', '', '', '');
		echo html_input('text', 'keywords_meta', 'km', $frm_meta_key, l('keywords_meta'), '', '', '', '', '', '', '', '', '', '');
	}
	echo html_input('checkbox', 'display_title', 'dti', 'YES', l('display_title'), '', '', '', '', $frm_display_title, '', '', '', '', '');
	if ($contents != 'extra_new' && $edit_option != '2') {
		echo html_input('checkbox', 'display_info', 'di', 'YES', l('display_info'), '', '', '', '', $frm_display_info, '', '', '', '', '');
		echo html_input('checkbox', 'commentable', 'ca', 'YES', l('enable_commenting'), '', '', '', '', $frm_commentable, '', '', '', '', '');
		if (!empty($id)) {
			echo '<p><input name="freeze" type="checkbox" id="fc"';
			if ($r['commentable'] == 'FREEZ') {
				echo ' checked="checked" />';
			} else if ($r['commentable'] == 'YES') {
				echo ' />';
			} else {
				echo ' />';
			}
			echo ' <label for="fc"> '.l('freeze_comments').'</label></p>';
		}
	}
	echo '</div></fieldset></div>';
	if ($contents == 'article_new' || $edit_option == 1) {
		echo '<div class="adminpanel">';
		echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', '<a title="'.l('publish_date').
			'" onclick="toggle(\'admin_publish_date\')" style="cursor: pointer;">'.l('publish_date').'</a>');
		echo '<div id="admin_publish_date" style="display: none;">';
		echo html_input('checkbox', 'fposting', 'fp', 'YES', l('enable'), '', '', '', '', '', '', '', '', '', '');
		echo '<p>'.l('server_time').': '.date('d.m.Y. H:i:s').'</p>';
		echo '<p>'.l('article_date').'</p>';
		!empty($id) ? posting_time($r['date']) : posting_time();
		echo '</div></fieldset></div>';
	}
	echo '<p>';
	echo html_input('hidden', 'task', 'task', 'admin_article', '', '', '', '', '', '', '', '', '', '', '');
	echo html_input('submit', $frm_task, $frm_task, $frm_submit, '', 'button', '', '', '', '', '', '', '', '', '');
	if (!empty($id)) {
		echo html_input('hidden', 'article_category', 'article_category', $article_category, '', '', '', '', '', '', '', '', '', '', '');
		echo html_input('hidden', 'id', 'id', $id, '', '', '', '', '', '', '', '', '', '', '');
		echo html_input('submit', 'delete_article', 'delete_article', l('delete'), '',
		'button', 'onclick="javascript: return pop()"', '', '', '', '', '', '', '', '');
	}
	echo '</p></form>';
}}

// ARTICLES - ADMIN LIST
function admin_articles($contents) {
	global $categorySEF, $subcatSEF;
	$link = '<a href="'._SITE.$categorySEF.'/';
	switch ($contents) {
		case 'article_view':
			$title = l('articles');
			$sef = 'article_new';
			$goto = 'snews_articles';
			$p = 1;
			$qw = 'position < 2 AND position >-1 ';
		break;
		case 'extra_view':
			$title = l('extra_contents');
			$sef = 'extra_new';
			$goto = 'extra_contents';$p = '2';
			$qw = 'position = 2 ';
		break;
		case 'page_view':
			$title = l('pages');
			$sef = 'page_new';
			$p = '3';
			$goto = 'snews_pages';
			$qw = 'position = 3 ';
			break;
	}
	$subquery = 'AND '.$qw;
	if (stats('articles',$p) > 0) {
		$add = ' - <a href="'.$sef.'/" title="'.l('add_new').'">
			'.l('add_new').'</a> - '.l('see').' ('.$link.'">'.l('all').'</a>) -
			'.l('filter').' ('.$link.l('year').'">'.l('year').'</a> / '.$link.l('month').'">
			'.l('month').'</a>)';
	} else {
		$add = '';
	}
	$tab = 1;
	if ($subcatSEF == l('year') || $subcatSEF == l('month')) {
		$query = 'SELECT DISTINCT(YEAR(date)) AS dyear FROM '._PRE.'articles'.' WHERE '.$qw.' ORDER BY date DESC';
		$result = mysql_query($query);
		$month_names = explode(', ', l('month_names'));
		echo '<div class="adminpanel">';
		echo '<fieldset><legend>'.l('articles').' - '.l('filter').'
			<span style="color: #0000FF">'.$subcatSEF.'</span> - '.l('see').' ('.$link.'">'.l('all').'</a>) -
			'.l('filter').' ('.$link.l('year').'">'.l('year').'</a> /
			'.$link.l('month').'">'.l('month').'</a>)</legend>';
		if ($result){
			while ($r = mysql_fetch_array($result)) {
		 		$ryear = $r['dyear'];
				echo ($subcatSEF == l('month') ? '<span style="color: #0000FF">'.$r['dyear'].'</span>' :
					$link.l('year').'='.$r['dyear'].'">'.$r['dyear'].'</a> ');
				if ($subcatSEF == l('month')) {
					$qx = "SELECT DISTINCT(MONTH(date)) AS dmonth FROM "._PRE.'articles'." WHERE $qw AND YEAR(date)=$ryear ORDER BY date ASC";
					$rqx = mysql_query($qx);
					while ($rx = mysql_fetch_array($rqx)){
				 		$m = $rx['dmonth'] - 1;
						echo ' '.l('divider').' '.$link.l('year').'='.$r['dyear'].';'.l('month').'='.$rx['dmonth'].'">'.$month_names[$m].'</a> ';
					}
				}
				echo '<br />';
			}
		}
		echo '</fieldset></div>';
		return;
	}
	$txtYear = l('year');
	$txtMonth = l('month');
  	if (substr($subcatSEF, 0, strlen($txtYear)) == $txtYear) {
  		$year = substr($subcatSEF, strlen($txtYear)+1, 4);
  	}
  	$find = strpos($subcatSEF,l('month'));
  	if ($find > 0) {
  		$month = substr($subcatSEF, $find + strlen($txtMonth) + 1, 2);
  	}
	$filterquery = !empty($year) ? "AND YEAR(date)='".$year."' " : '';
	$filterquery .= !empty($month) ? "AND MONTH(date)='".$month."' " : '';
	$no_content = !empty($filterquery) ? '<p>'.l('no_content_for_filter').'</p>' : '<p>'.l('article_not_exist').'</p>';
	echo html_input('form', '', 'post', '', '', '', '', '', '', '', '', '', 'post', '?action=process&amp;task=reorder', '');
	echo '<div class="adminpanel"><fieldset><legend>'.$title.$add.'</legend>';
	echo '<p><input type="hidden" name="order" id="order" value="'.$goto.'" /></p>';
	if ($contents == 'extra_view') {
		$cat_array_irregular = array('-1','-3');
	 	foreach ($cat_array_irregular as $cat_value) {
	 		$legend_label = $cat_value == -3 ? l('pages') : l('all');
	 		$page_only_xsql = $cat_value == -3 ? 'page_extra ASC,' : '';
	 		$sql = "SELECT id, title, seftitle, date, published, artorder, visible, default_page, page_extra
	 			FROM "._PRE.'articles'."
	 			WHERE category = $cat_value
	 				AND position = $p $filterquery
	 			ORDER BY $page_only_xsql artorder ASC, date DESC ";
	 		$query = mysql_query($sql) or die(mysql_error());
	 		$num_rows = mysql_num_rows($query);
	 		$tab=1;
	 		echo '<fieldset><legend>'.$legend_label.'</legend>';
			if ($num_rows == 0) {
				echo $no_content;
			} else {
				$lbl_filter = -5;
				while ($r = mysql_fetch_array($query)) {
					if ($cat_value == -3) {
						if ($lbl_filter != $r['page_extra']) {
							$assigned_page = retrieve('title','articles','id',$r['page_extra']);
							echo !$assigned_page ? l('all_pages') : $assigned_page;
						}
					}
					$order_input = '<input type="text" name="page_'.$r['id'].'" value="'.$r['artorder'].'" size="1" tabindex="'.$tab.'" /> &nbsp;';
					echo '<p>'.$order_input.'<strong title="'.date(s('date_format'), strtotime($r['date'])).'">
						'.$r['title'].'</strong> '.l('divider').'
						<a href="'._SITE.$row['seftitle'].'/'.$r['seftitle'].'/">'.l('view').'</a> ';
					if ($r['default_page'] != 'YES'){
						echo  l('divider').' <a href="'._SITE.'?action=admin_article&amp;id='.$r['id'].'">'.l('edit').'</a> ';
					}
					$visiblity = $r['visible'] == 'YES' ?
						'<a href="'._SITE.'?action=process&amp;task=hide&amp;item='.$item.'&amp;id='.$r['id'].'">'.l('hide').'</a>' :
						l('hidden').' ( <a href="'._SITE.'?action=process&amp;task=show&amp;item='.$item.'&amp;id='.$r['id'].'">'.l('show').'</a> )' ;
					echo ' '.l('divider').' '.$visiblity;
					if ($r['published'] == 2) {
						echo  l('divider').' ['.l('status').' '.l('future_posting').']';
					}
					if ($r['published'] == 0) {
						echo  l('divider').' ['.l('status').' '.l('unpublished').']';
					}
					echo '</p>';
					$tab++;
					$lbl_filter = $r['page_extra'];
				}
			}
			echo '</fieldset>';
		}
	}
 	if ($contents == 'article_view' || $contents == 'extra_view') {
 	 	$item = $contents == 'extra_view' ? 'extra_contents': 'snews_articles';
		$cat_query = "SELECT id, name, seftitle FROM "._PRE.'categories'." WHERE subcat = 0";
		$cat_res = mysql_query($cat_query);
		$num = mysql_num_rows($cat_res);
		if (!$cat_res || !$num) {
			echo '<p>'.l('no_categories').'</p>';
		} else {
			$sql = "SELECT id, title, seftitle, date, published, artorder, visible, default_page
				FROM "._PRE.'articles'."
				WHERE category = '0'
					AND position = $p $subquery
					ORDER BY artorder ASC, date DESC ";
			$query = mysql_query($sql) or die(mysql_error());
			$num_rows = mysql_num_rows($query);
			if ($num_rows > 0) {
				echo '<fieldset><legend>'.l('no_category_set').'</legend>';
				while ($O = mysql_fetch_array($query)) {
					$order_input = '<input type="text" name="page_'.$O['id'].'" value="'.$O['artorder'].'" size="1" tabindex="'.$tab22.'" /> &nbsp;';
					echo '<p>'.$order_input.'<strong title="'.date(s('date_format'), strtotime($O['date'])).'">'.$O['title'].'</strong> ';
					if ($r['default_page'] != 'YES'){
						echo  l('divider').' <a href="'._SITE.'?action=admin_article&amp;id='.$O['id'].'">'.l('edit').'</a> ';
					}
					$visiblity = $O['visible'] == 'YES' ?
               	 		'<a href="'._SITE.'?action=process&amp;task=hide&amp;item='.$item.'&amp;id='.$O['id'].'">'.l('hide').'</a>' :
               	 		l('hidden').' ( <a href="'._SITE.'?action=process&amp;task=show&amp;item='.$item.'&amp;id='.$O['id'].'">'.l('show').'</a> )' ;
               			echo ' '.l('divider').' '.$visiblity;
					if ($O['published'] == 2) {
						echo  l('divider').' ['.l('status').' '.l('future_posting').']';
					}
					if ($O['published'] == 0) {
						echo  l('divider').' ['.l('status').' '.l('unpublished').']';
					}
					echo '</p>';
					$tab22++;
				}
				echo '</fieldset>';
			}
			while ($row = mysql_fetch_array($cat_res)) {
				echo '<fieldset><legend>'.$row['name'].'</legend>';
				$sql = "SELECT id, title, seftitle, date, published, artorder, visible, default_page
					FROM "._PRE.'articles'."
					WHERE category = '".$row['id']."'
						AND position = $p $subquery $filterquery
					ORDER BY artorder ASC, date DESC ";
				$query = mysql_query($sql) or die(mysql_error());
				$num_rows = mysql_num_rows($query);
				if ($num_rows == 0) {
					echo $no_content;
				}
				while ($r = mysql_fetch_array($query)) {
					$order_input = '<input type="text" name="page_'.$r['id'].'" value="'.$r['artorder'].'" size="1" tabindex="'.$tab.'" /> &nbsp;';
					echo '<p>'.$order_input.'<strong title="'.date(s('date_format'), strtotime($r['date'])).'">
						'.$r['title'].'</strong> '.l('divider').'
						<a href="'._SITE.$row['seftitle'].'/'.$r['seftitle'].'/">'.l('view').'</a> ';
					if ($r['default_page'] != 'YES'){
						echo  l('divider').' <a href="'._SITE.'?action=admin_article&amp;id='.$r['id'].'">'.l('edit').'</a> ';
					}
					$visiblity = $r['visible'] == 'YES' ?
               	 		'<a href="'._SITE.'?action=process&amp;task=hide&amp;item='.$item.'&amp;id='.$r['id'].'">'.l('hide').'</a>' :
               	 		l('hidden').' ( <a href="'._SITE.'?action=process&amp;task=show&amp;item='.$item.'&amp;id='.$r['id'].'">'.l('show').'</a> )' ;
               		echo ' '.l('divider').' '.$visiblity;
					if ($r['published'] == 2) {
						echo  l('divider').' ['.l('status').' '.l('future_posting').']';
					}
					if ($r['published'] == 0) {
						echo  l('divider').' ['.l('status').' '.l('unpublished').']';
					}
					echo '</p>';
					$tab++;
				}
				$query2 = mysql_query("SELECT id, name, seftitle FROM "._PRE.'categories'." WHERE subcat = '$row[id]' ORDER BY catorder ASC");
				$tab2 = 1;
				while ($row2 = mysql_fetch_array($query2)){
					echo '<a class="subcat" onclick="toggle(\'subcat'.$row2['id'].'\')" style="cursor: pointer;">'.$row2['name'].'</a><br />';
					echo '<div id="subcat'.$row2['id'].'" style="display: none;" class="subcat">';
					$catart_sql2 = "SELECT id, title, seftitle, date, published, artorder, visible
						FROM "._PRE.'articles'."
						WHERE category = '$row2[id]' $subquery $filterquery
						ORDER BY category ASC, artorder ASC, date DESC ";
					$catart_query2 = mysql_query($catart_sql2) or die(mysql_error());
					$num_rows2 = mysql_num_rows($catart_query2);
					if ($num_rows2 == 0) {
						echo $no_content;
					}
					while ($ca_r2 = mysql_fetch_array($catart_query2)) {
						$order_input2 = '<input type="text" name="page_'.$ca_r2['id'].'" value="'.$ca_r2['artorder'].'" size="1" tabindex="'.$tab2.'" /> &nbsp;';
						$catSEF = cat_rel($row2['id'],'seftitle');
						echo '<p>'.$order_input2.'<strong title="'.date(s('date_format'), strtotime($ca_r2['date'])).'">
							'.$ca_r2['title'].'</strong> '.l('divider').'
							<a href="'._SITE.$catSEF.'/'.$ca_r2['seftitle'].'/">'.l('view').'</a> ';
						echo  l('divider').' <a href="'._SITE.'?action=admin_article&amp;id='.$ca_r2['id'].'">'.l('edit').'</a> ';
						$visiblity2 = $ca_r2['visible'] == 'YES' ?
			       	 		'<a href="'._SITE.'?action=process&amp;task=hide&amp;item=snews_articles&amp;id='.$ca_r2['id'].'">'.l('hide').'</a>' :
            	   	 		l('hidden').' ( <a href="'._SITE.'?action=process&amp;task=show&amp;item=snews_articles&amp;id='.$ca_r2['id'].'">
            	   	 			'.l('show').'</a> )';
       					echo ' '.l('divider').' '.$visiblity2;
						if ($ca_r2['published'] == 2) {
							echo  l('divider').' ['.l('status').' '.l('future_posting').']';
						}
						if ($ca_r2['published'] == 0) {
							echo  l('divider').' ['.l('status').' '.l('unpublished').']';
						}
						echo '</p>';
					}
					echo '</div>';
					$tab2++;
				}
				echo '</fieldset>';
			}
		}
	} elseif ($contents == 'page_view') {
		$sql = "SELECT id, title, seftitle, date, published, artorder, visible, default_page
			FROM "._PRE.'articles'."
			WHERE position = 3 $subquery
			ORDER BY artorder ASC, date DESC ";
		$query = mysql_query($sql) or die(mysql_error());
		$num_rows = mysql_num_rows($query);
		if ($num_rows == 0) {
			echo '<p>'.l('article_not_exist').'</p>';
		}
		while ($r = mysql_fetch_array($query)) {
			$order_input = '<input type="text" name="page_'.$r['id'].'" value="'.$r['artorder'].'" size="1" tabindex="'.$tab.'" /> &nbsp;';
			echo '<p>'.$order_input.'<strong title="'.date(s('date_format'), strtotime($r['date'])).'">
				'.$r['title'].'</strong> '.l('divider').'
				<a href="'._SITE.$r['seftitle'].'/">'.l('view').'</a> ';
			if ($r['default_page'] != 'YES') {
				echo  l('divider').' <a href="'._SITE.'?action=admin_article&amp;id='.$r['id'].'">'.l('edit').'</a> ';
			}
			$visiblity = $r['visible'] == 'YES' ?
                '<a href="'._SITE.'?action=process&amp;task=hide&amp;item=snews_pages&amp;id='.$r['id'].'">'.l('hide').'</a>' :
                l('hidden').' ( <a href="'._SITE.'?action=process&amp;task=show&amp;item=snews_pages&amp;id='.$r['id'].'">'.l('show').'</a> )' ;
			echo ' '.l('divider').' '.$visiblity;
			if ($r['published'] == 2) {
				echo  l('divider').' ['.l('status').' '.l('future_posting').']';
			}
			if ($r['published'] == 0) {
				echo  l('divider').' ['.l('status').' '.l('unpublished').']';
			}
			echo '</p>';
			$tab++;
		}
	}
	echo '</fieldset>';
	echo '<p>'.html_input('submit', 'reorder', 'reorder', l('order_content'), '', 'button', '', '', '', '', '', '', '', '', '');
	echo '</p></div></form>';
}

//BUTTONS
function buttons(){
   	echo '<div class="clearer"></div>
	<p>'.l('formatting').':
	<br class="clearer" />';
   	$formatting = array(
		'strong' => '',
		'em' => 'key',
		'underline' => 'key',
		'del' => 'key',
		'p' => '',
		'br' => ''
	);
   	foreach ($formatting as $key => $var) {
      	$css = $var == 'key' ? $key :'buttons';
      	echo '<input type="button" name="'.$key.'" title="'.l($key).'" class="'.$css.'" onclick="tag(\''.$key.'\')" value="'.
		l($key.'_value').'" />';
	}
   	echo '</p><br class="clearer" /><p>'.l('insert').': <br class="clearer" />';
   	$insert = array('img', 'link', 'include', 'func','intro');
   	foreach ($insert as $key) {
      	echo '<input type="button" name="'.$key.'" title="'.l($key).'" class="buttons" onclick="tag(\''.
		$key.'\')" value="'.l($key.'_value').'" />';
	}
   	echo '<br class="clearer" /></p>';
}

// COMMENTS - EDIT
function edit_comment() {
	$commentid = $_GET['commentid'];
	$query = mysql_query('SELECT id,articleid,name,url,comment,approved FROM '._PRE.'comments'.' WHERE id='.$commentid);
	$r = mysql_fetch_array($query);
	$articleTITLE = retrieve('title', 'articles', 'id', $r['articleid']);
	echo html_input('form', '', 'post', '', '', '', '', '', '', '', '', '', 'post', '?action=process&amp;task=editcomment&amp;id='.$commentid, '');
	echo '<div class="adminpanel">';
	echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', l('edit_comment').' (<strong>'.$articleTITLE.'</strong>)');
	echo html_input('textarea', 'editedcomment', 'ec', stripslashes($r['comment']), l('comment'), '', '', '', '', '', '2', '100', '', '', '');
	echo html_input('text', 'name', 'n', $r['name'], l('name'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('text', 'url', 'url', $r['url'], l('url'), '', '', '', '', '', '', '', '', '', '');
	echo html_input('checkbox', 'approved', 'a', '', l('approved'), '', '', '', '', $r['approved'] == 'True' ? 'ok' : '', '', '', '', '', '');
	echo '</fieldset></div><p>';
	echo html_input('hidden', 'id', 'id', $r['articleid'], '', '', '', '', '', '', '', '', '', '', '');
	echo html_input('submit', 'submit_text', 'submit_text', l('edit'), '', 'button', '', '', '', '', '', '', '', '', '');
	echo html_input('hidden', 'commentid', 'commentid', $r['id'], '', '', '', '', '', '', '', '', '', '', '');
	echo html_input('submit', 'delete_text', 'delete_text', l('delete'), '',
		'button', 'onclick="javascript: return pop()"', '', '', '', '', '', '', '', '');
	echo '</p></form>';
}

// FORM EXTRA GROUPINGS
function form_groupings() {
 	if (s('enable_extras') == 'YES') {
		if (isset($_GET['id']) && is_numeric($_GET['id']) && !is_null($_GET['id'])) {
			$extraid = $_GET['id'];
			$query = mysql_query('SELECT id,name,seftitle,description FROM '._PRE.'extras'.' WHERE id='.$extraid);
			$r = mysql_fetch_array($query);
			$frm_action = _SITE.'?action=process&amp;task=admin_groupings&amp;id='.$extraid;
			$frm_add_edit = l('edit');
			$frm_name = $r['name'];
			$frm_sef_title = $r['seftitle'];
			$frm_description = $r['description'];
			$frm_task = 'edit_groupings';
			$frm_submit = l('edit');
		} else {
			$frm_action = _SITE.'?action=process&amp;task=admin_groupings';
			$frm_add_edit = l('add_groupings');
			$frm_name = $_POST['name'];
			$frm_sef_title = $_POST['name'] == '' ? cleanSEF($_POST['name']) : cleanSEF($_POST['seftitle']);
			$frm_description = '';
			$frm_task = 'add_groupings';
			$frm_submit = l('add_groupings');
		}
		echo html_input('form', '', 'post', '', '', '', '', '', '', '', '', '', 'post', $frm_action, '');
		echo '<div class="adminpanel">';
		echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', $frm_add_edit);
		echo html_input('text', 'name', 't', $frm_name, l('name'), '',
			'onchange="genSEF(this,document.forms[\'post\'].seftitle)"',
			'onkeyup="genSEF(this,document.forms[\'post\'].seftitle)"', '', '', '', '', '', '', '');
		echo html_input('text', 'seftitle', 's', $frm_sef_title, l('extra_title'), '', '', '', '', '', '', '', '', '', '');
		echo html_input('text', 'description', 'desc', $frm_description, l('description'), '', '', '', '', '', '', '', '', '', '');
		echo '</fieldset></div><p>';
		echo html_input('hidden', 'task', 'task', 'admin_groupings', '', '', '', '', '', '', '', '', '', '', '');
		echo html_input('submit', $frm_task, $frm_task, $frm_submit, '', 'button', '', '', '', '', '', '', '', '', '');
		if (!empty($extraid)) {
			echo '&nbsp;&nbsp;';
			echo html_input('hidden', 'id', 'id', $extraid, '', '', '', '', '', '', '', '', '', '', '');
			if ($extraid != 1) {
				echo html_input('submit', 'delete_groupings', 'delete_groupings', l('delete'), '',
				'button', 'onclick="javascript: return pop()"', '', '', '', '', '', '', '', '');
			}
		}
		echo '</p></form>';
	}
}

// ADMIN GROUPINGS
function admin_groupings() {
 	if (s('enable_extras') == 'YES') {
		if (stats('extras','') > 0) {
			$add = ' - <a href="admin_groupings/" title="'.l('add_new').'">'.l('add_new').'</a>';
		} else {
			$add = '';
		}
		echo '<div class="adminpanel"><fieldset><legend>'.l('groupings').$add.'</legend>';
		$result = mysql_query('SELECT id,name,description FROM '._PRE.'extras'.' ORDER BY id ASC');
		if (!$result || !mysql_num_rows($result)) {
			echo '<p>'.l('group_not_exist').'</p>';
		} else {
			while ($r = mysql_fetch_array($result)) {
				echo '<p><strong>'.$r['name'].'</strong> '.l('divider').'<a href="'._SITE.'?action=admin_groupings&amp;id='.$r['id'].'" title="'.$r['description'].'">'.l('edit').'</a></p>';
 			}
 		}
 		echo '</fieldset></div>';
	}
}

/*** PROCESSING (CATEGORIES, CONTENTS, COMMENTS) ***/
function processing() {
	if (!_ADMIN) {
		echo (notification(1,l('error_not_logged_in'),'home'));
	} else {
	$action = clean(cleanXSS($_GET['action']));
  	$id = clean(cleanXSS($_GET['id']));
  	$commentid = $_POST['commentid'];
  	$approved = $_POST['approved'] == 'on' ? 'True' : '';
  	$name = clean(entity($_POST['name']));
  	$category = !empty($_POST['define_category']) ? $_POST['define_category'] : 0;
  	$subcat = $_POST['subcat'];
  	$page = $_POST['define_page'];
  	$def_extra = $_POST['define_extra'];
  	$description = clean(entity($_POST['description']));
  	$title = clean(entity($_POST['title']));
  	$seftitle = $_POST['seftitle'];
	$url = cleanXSS($_POST['url']);
	$comment = $_POST['editedcomment'];
	$text = clean($_POST['text']);
  	$date = date('Y-m-d H:i:s');
  	$description_meta = entity($_POST['description_meta']);
	$keywords_meta = entity($_POST['keywords_meta']);
  	$display_title = $_POST['display_title'] == 'on' ? 'YES' : 'NO';
	$display_info = $_POST['display_info'] == 'on' ? 'YES' : 'NO';
  	$commentable = $_POST['commentable'] == 'on' ? 'YES' : 'NO';
	$freez = $_POST['freeze'] == 'on' ? 'YES' : 'NO';
  	if ($freez == 'YES' && $commentable == 'YES') {
  		$commentable = 'FREEZ';
  	}
	$position = $_POST['position']> 0 ? $_POST['position'] : 1;
	if ($position == 2) {
		$position = $_POST['cat_dependant'] == 'on' ? 21 : 2;
	}
  	$publish_article = ($_POST['publish_article'] == 'on') ? 1 : 0;
  	$show_in_subcats = $_POST['show_in_subcats'] == 'on' ? 'YES' : 'NO';
	$show_on_home = ($_POST['show_on_home'] == 'on' || $position > 1) ? 'YES' : 'NO';
	$publish_category = $_POST['publish'] == 'on' ? 'YES' : 'NO';
  	$fpost_enabled = false;
    if ($_POST['fposting'] == 'on') {
		$fpost_enabled = true;
		$date = $_POST['fposting_year'].'-'.$_POST['fposting_month'].'-'.$_POST['fposting_day'].' '.
		$_POST['fposting_hour'].':'.$_POST['fposting_minute'].':00';
     	if (date('Y-m-d H:i:s') < $date) $publish_article = 2;
    }
    $task = clean(cleanXSS($_GET['task']));
	switch ($task) {
		case 'save_settings':
	 		if (isset($_POST['save'])) {
				$website_title = $_POST['website_title'];
				$home_sef = $_POST['home_sef'];
				$website_description = $_POST['website_description'];
				$website_keywords = $_POST['website_keywords'];
				$website_email = $_POST['website_email'];
				$contact_subject = $_POST['contact_subject'];
				$language = $_POST['language'];
				$charset = $_POST['charset'];
				$date_format = $_POST['date_format'];
				$article_limit = $_POST['article_limit'];
				$rss_limit = $_POST['rss_limit'];
				$display_page = $_POST['display_page'];
				$display_new_on_home = $_POST['display_new_on_home'];
				$display_pagination = $_POST['display_pagination'];
				$num_categories = $_POST['num_categories'];
				$show_cat_names = $_POST['show_cat_names'];
				$approve_comments = $_POST['approve_comments'];
				$mail_on_comments = $_POST['mail_on_comments'];
				$comments_order = $_POST['comments_order'];
				$comment_limit = $_POST['comment_limit'];
				$word_filter_enable = $_POST['word_filter_enable'];
				$word_filter_file = $_POST['word_filter_file'];
				$word_filter_change = $_POST['word_filter_change'];
				$enable_extras = $_POST['enable_extras'] == 'on' ? 'YES' : 'NO';
				$enable_comments = $_POST['enable_comments'] == 'on' ? 'YES' : 'NO';
				$comment_repost_timer = is_numeric($_POST['comment_repost_timer']) ? $_POST['comment_repost_timer'] : '15';
				$freeze_comments = $_POST['freeze_comments'] == 'on' ? 'YES' : 'NO';
				$file_ext = $_POST['file_ext'];
				$allowed_file = $_POST['allowed_file'];
				$allowed_img = $_POST['allowed_img'];
				$ufield = array(
					'website_title' => $website_title,
					'home_sef' => $home_sef,
					'website_description' => $website_description,
					'website_keywords' => $website_keywords,
					'website_email' => $website_email,
					'contact_subject' => $contact_subject,
					'language' => $language,
					'charset' => $charset,
					'date_format' => $date_format,
					'article_limit' => $article_limit,
					'rss_limit' => $rss_limit,
					'display_page' => $display_page,
					'comments_order' => $comments_order,
					'comment_limit' => $comment_limit,
					'word_filter_file' => $word_filter_file,
					'word_filter_change' => $word_filter_change,
					'display_new_on_home' => $display_new_on_home,
					'display_pagination' => $display_pagination,
					'num_categories' => $num_categories,
					'show_cat_names' => $show_cat_names,
					'approve_comments' => $approve_comments,
					'mail_on_comments' => $mail_on_comments,
					'word_filter_enable' => $word_filter_enable,
					'enable_extras' => $enable_extras,
					'enable_comments' => $enable_comments,
					'freeze_comments' => $freeze_comments,
					'comment_repost_timer' => $comment_repost_timer,
					'file_extensions' => $file_ext,
					'allowed_files' => $allowed_file,
					'allowed_images' => $allowed_img
			 );
		 	while (list($key, $value) = each($ufield)) {
				mysql_query("UPDATE "._PRE.'settings'." SET VALUE = '$value' WHERE name = '$key' LIMIT 1");
			}
			echo notification(0,'','snews_settings');
		}
		break;
		case 'changeup':
			if (isset($_POST['submit_pass'])) {
				$user = checkUserPass($_POST['uname']);
				$pass1 = checkUserPass($_POST['pass1']);
				$pass2 = checkUserPass($_POST['pass2']);
				if ($user && $pass1 && $pass2 && $pass1 === $pass2) {
					$uname = md5($user);
					$pass = md5($pass2);
					$query = "UPDATE "._PRE.'settings'." SET VALUE=";
					mysql_query($query."'$uname' WHERE name='username' LIMIT 1");
					mysql_query($query."'$pass' WHERE name='password' LIMIT 1");
					echo notification(0,'','administration');
        		} else {
        			die(notification(2,l('pass_mismatch'),'snews_settings'));
        		}
			}
		break;
		case 'admin_groupings':
			switch (true) {
				case (empty($name)):
					echo notification(1,l('err_TitleEmpty').l('errNote'));
					form_groupings();
					break;
				case (empty($seftitle)):
					echo notification(1,l('err_SEFEmpty').l('errNote'));
					form_groupings();
					break;
				case(check_if_unique('group_name', $name, $id, '')):
					echo notification(1,l('err_TitleExists').l('errNote'));
					form_groupings();
					break;
				case(check_if_unique('group_seftitle', $seftitle, $id, '')):
					echo notification(1,l('err_SEFExists').l('errNote'));
					form_groupings();
					break;
				case(cleancheckSEF($seftitle) == 'notok'):
					echo notification(1,l('err_SEFIllegal').l('errNote'));
					form_groupings();
					break;
				default:
			  		switch (true) {
						case (isset($_POST['add_groupings'])):
							mysql_query("INSERT INTO "._PRE.'extras'."(name, seftitle, description)
								VALUES('$name', '$seftitle', '$description')");
							break;
						case (isset($_POST['edit_groupings'])):
							mysql_query("UPDATE "._PRE.'extras'." SET
								name = '$name',
								seftitle = '$seftitle',
								description = '$description'
								WHERE id = $id LIMIT 1");
							break;
						case (isset($_POST['delete_groupings'])):
							mysql_query("DELETE FROM "._PRE.'extras'." WHERE id = $id LIMIT 1");
							break;
			  		}
				echo notification(0,'','groupings');
			}
			break;
		case 'admin_category':
		case 'admin_subcategory':
			switch (true) {
				case (empty($name)):
					echo notification(1,l('err_TitleEmpty').l('errNote'));
					form_categories();
					break;
				case (empty($seftitle)):
					echo notification(1,l('err_SEFEmpty').l('errNote'));
					form_categories();
					break;
				case (isset($_POST['add_category']) && check_if_unique('subcat_name', $name, '', $subcat)):
					echo notification(1,l('err_TitleExists').l('errNote'));
					form_categories();
					break;
				case (isset($_POST['add_category']) && check_if_unique('subcat_seftitle', $seftitle, '', $subcat)):
					echo notification(1,l('err_SEFExists').l('errNote'));
					form_categories();
					break;
				case (isset($_POST['edit_category']) && $subcat == 0 && check_if_unique('cat_name_edit', $name, $id, '')):
					echo notification(1,l('err_TitleExists').l('errNote'));
					form_categories();
					break;
				case (isset($_POST['edit_category']) && $subcat == 0 && check_if_unique('cat_seftitle_edit', $seftitle, $id, '')):
					echo notification(1,l('err_SEFExists').l('errNote'));
					form_categories();
					break;
				case (isset($_POST['edit_category']) && $subcat != 0 && check_if_unique('subcat_name_edit', $name, $id, $subcat)):
					echo notification(1,l('err_TitleExists').l('errNote'));
					form_categories();
					break;
				case (isset($_POST['edit_category']) && $subcat != 0 && check_if_unique('subcat_seftitle_edit', $seftitle, $id, $subcat)):
					echo notification(1,l('err_SEFExists').l('errNote'));
					form_categories();
					break;
				case (cleancheckSEF($seftitle) == 'notok'):
					echo notification(1,l('err_SEFIllegal').l('errNote'));
					form_categories();
					break;
				case ($subcat==$id):
					echo notification(1,l('errNote'));
					form_categories();
					break;
				default:
					switch(true) {
						case(isset($_POST['add_category'])):
							$catorder = mysql_fetch_array(mysql_query(
								"SELECT MAX(catorder) as max
								FROM "._PRE.'categories'." WHERE subcat = $subcat"));
							$catorder = $catorder['max'] + 1;
							mysql_query("INSERT INTO "._PRE.'categories'."
								(name, seftitle, description, published, catorder, subcat)
								VALUES('$name', '$seftitle', '$description', '$publish_category', '$catorder','$subcat')");
							break;
						case(isset($_POST['edit_category'])):
							$catorder = mysql_fetch_array(mysql_query(
								"SELECT MAX(catorder) as max
								FROM "._PRE.'categories'." WHERE subcat = $subcat"));
							$catorder = isset($_POST['catorder']) ? $_POST['catorder'] : $catorder['max'] + 1;
							mysql_query("UPDATE "._PRE.'categories'." SET
								name = '$name',
								seftitle = '$seftitle',
								description = '$description',
								published = '$publish_category',
								subcat='$subcat',
								catorder='$catorder'
								WHERE id = $id LIMIT 1");
							break;
						case (isset($_POST['delete_category'])):
							$any_subcats = retrieve('COUNT(id)','categories','subcat',$id);
							$any_articles = retrieve('COUNT(id)','articles','category',$id);
							if ($any_subcats > 0 || $any_articles > 0) {
								echo notification(1,l('warn_catnotempty'),'');
								echo '<p><a href="'._SITE.'administration/" title="'.l('administration').'">
									'.l('administration').'</a>  OR  <a href="'._SITE.'?action=process&amp;task=delete_category_all&amp;id='.$id.'" onclick="javascript: return pop(\'x\')" title="'.l('administration').'">
									'.l('empty_cat').'</a></p>';
								$no_success = true;
							} else { delete_cat($id); }
							break;
					}
				$success = isset($no_success) ? '' : notification(0,'','snews_categories');
				echo $success;
			}
			break;
		case 'reorder':
			if (isset($_POST['reorder'])) {
				switch ($_POST['order']){
					case 'snews_articles':
					case 'extra_contents':
					case 'snews_pages':
						$table = 'articles';
						$order_type = 'artorder';
						$remove = 'page_';
						break;
					case 'snews_categories':
						$table = 'categories';
						$order_type = 'catorder';
						$remove = 'cat_';
						break;
				}
				foreach ($_POST as $key => $value){
					$type_id = str_replace($remove,'',$key);
					$key = clean(cleanXSS(trim($value)));
					if ($key != 'reorder' && $key != 'order' && $key != $table && $key != l('order_content') && $key != $_POST['order']){
						$query = "UPDATE "._PRE.$table." SET $order_type = $value WHERE id = $type_id LIMIT 1;";
						mysql_query($query) or die(mysql_error().'<br />'.$query);
					}
				}
				echo notification(0,l('please_wait'));
				echo '<meta http-equiv="refresh" content="1; url='._SITE.$_POST['order'].'/">';
			}
			break;
		case 'admin_article':
			$_SESSION[_SITE.'temp']['title'] = $title;
			$_SESSION[_SITE.'temp']['seftitle'] = $seftitle;
			$_SESSION[_SITE.'temp']['text'] = $text;
			switch (true) {
				case (empty($title)):
					echo notification(1,l('err_TitleEmpty').l('errNote'));
					form_articles('');
					unset($_SESSION[_SITE.'temp']);
					break;
				case (empty($seftitle)):
					echo notification(1,l('err_SEFEmpty').l('errNote'));
					$_SESSION[_SITE.'temp']['seftitle'] = $_SESSION[_SITE.'temp']['title'];
					form_articles('');
					unset($_SESSION[_SITE.'temp']);
					break;
				case (cleancheckSEF($seftitle) == 'notok'):
					echo notification(1,l('err_SEFIllegal').l('errNote'));
					form_articles('');
					unset($_SESSION[_SITE.'temp']);
					break;
				case ($position == 1 && $_POST['article_category'] != $category && isset($_POST['edit_article'])
						&& check_if_unique('article_title', $title, $category, '')):
					echo notification(1,l('err_TitleExists').l('errNote'));
					form_articles('');
					unset($_SESSION[_SITE.'temp']);
					break;
				case ($position == 1 && $_POST['article_category'] != $category && isset($_POST['edit_article'])
						&& check_if_unique('article_seftitle', $seftitle, $category, '')):
					echo notification(1,l('err_SEFExists').l('errNote'));
					form_articles('');
					unset($_SESSION[_SITE.'temp']);
					break;
				case (!isset($_POST['delete_article']) && !isset($_POST['edit_article'])
						&& check_if_unique('article_title', $title, $category, '')):
					echo notification(1,l('err_TitleExists').l('errNote'));
					form_articles('');
					unset($_SESSION[_SITE.'temp']);
					break;
				case (!isset($_POST['delete_article']) && !isset($_POST['edit_article'])
						&& check_if_unique('article_seftitle', $seftitle, $category, '')):
					echo notification(1,l('err_SEFExists').l('errNote'));
					form_articles('');
					unset($_SESSION[_SITE.'temp']);
					break;
				default:
					$pos = $position;
					$sub = !empty($category) ? ' AND category = '.$category : '';
					$curr_artorder = retrieve('artorder','articles','id',$id);
					if (!$curr_artorder){
						$artorder = 1;
					} else {
						$artorder = $curr_artorder;
					}
					switch ($pos) {
						case 1: $link = 'snews_articles'; break;
						case 2: $link = 'extra_contents'; break;
						case 3: $link = 'snews_pages'; break;
					}
					switch (true) {
						case (isset($_POST['add_article'])):
							mysql_query("INSERT INTO "._PRE.'articles'."(
								title, seftitle, text, date, category,
								position, extraid, page_extra, displaytitle,
								displayinfo, commentable, published, description_meta,
								keywords_meta, show_on_home, show_in_subcats, artorder)
							VALUES('$title', '$seftitle', '$text', '$date', '$category',
								'$position', '$def_extra', '$page', '$display_title',
								'$display_info', '$commentable', '$publish_article',
								'$description_meta', '$keywords_meta', '$show_on_home',
								'$show_in_subcats', '$artorder')");
							break;
						case (isset($_POST['edit_article'])):
							$category = $position == 3 ? 0 : $category;
							$old_pos = retrieve('position','articles','id',$id);
							// Only do this if page is changed to art/extra
							if ($position != $old_pos && $old_pos == 3) {
								$chk_extra_query = "SELECT id FROM "._PRE.'articles'."
									WHERE position = 2 AND category = -3 AND  page_extra = $id";
								$chk_extra_sql = mysql_query($chk_extra_query) or die(mysql_error('oops'));
								if ($chk_extra_sql) {
									while ($xtra = mysql_fetch_array($chk_extra_sql)) {
										$xtra_id = $xtra['id'];
										mysql_query("UPDATE "._PRE.'articles'." SET
											category = '0', page_extra = ''
											WHERE id = $xtra_id");
									}
								}
							}
							if ($fpost_enabled == true) {
								$future =  "date = '$date',";
								//allows backdating of article
								$publish_article = strtotime($date) < time() ? 1 : $publish_article;
							}
							mysql_query("UPDATE "._PRE.'articles'." SET
								title='$title',
								seftitle = '$seftitle',
								text = '$text',
								".$future."
								category = $category,
								position = $position,
								extraid = '$def_extra',
								page_extra = '$page',
								displaytitle = '$display_title',
								displayinfo = '$display_info',
								commentable = '$commentable',
								published = $publish_article,
								description_meta = '$description_meta',
								keywords_meta = '$keywords_meta',
								show_on_home='$show_on_home',
								show_in_subcats='$show_in_subcats',
								artorder = '$artorder'
								WHERE id = $id LIMIT 1") or die(mysql_error());
							break;
						case(isset($_POST['delete_article'])):
							if ($position == 3) {
								$chk_extra_query = "SELECT id FROM "._PRE.'articles'."
									WHERE position = 2 AND category = -3 AND  page_extra = $id";
								$chk_extra_sql = mysql_query($chk_extra_query) or die(mysql_error());
								if ($chk_extra_sql) {
									while ($xtra = mysql_fetch_array($chk_extra_sql)) {
										$xtra_id = $xtra['id'];
										mysql_query("UPDATE "._PRE.'articles'." SET category = '0',page_extra = ''	WHERE id = $xtra_id");
									}
								}
							}
							mysql_query("DELETE FROM "._PRE.'articles'." WHERE id = $id");
							mysql_query("DELETE FROM "._PRE.'comments'." WHERE articleid = $id");
							if ($id == s('display_page')) {
								mysql_query("UPDATE "._PRE.'settings'." SET
									VALUE = 0 WHERE name = 'display_page'");
							}
							break;
					}
				echo notification(0,'',$link);
				unset($_SESSION[_SITE.'temp']);
			}
			break;
		case 'editcomment':
			$articleID = retrieve('articleid', 'comments', 'id', $commentid);
			$articleSEF = retrieve('seftitle', 'articles', 'id', $articleID);
			$articleCAT = retrieve('category','articles','seftitle',$articleSEF);
			$postCat = cat_rel($articleCAT, 'seftitle');
			$link = $postCat.'/'.$articleSEF;
			if (isset($_POST['submit_text'])) {
				mysql_query("UPDATE "._PRE.'comments'." SET
					name = '$name',
					url = '$url',
					comment = '$comment',
					approved = '$approved'
					WHERE id = $commentid");
			} else if (isset($_POST['delete_text'])) {
				mysql_query("DELETE FROM "._PRE.'comments'." WHERE id = $commentid");
			}
			echo notification(0,'',$link);
			break;
		case 'deletecomment':
			$commentid = $_GET['commentid'];
			$articleid = retrieve('articleid', 'comments', 'id', $commentid);
			$articleSEF = retrieve('seftitle', 'articles', 'id', $articleid);
			$articleCAT = retrieve('category','articles','id', $articleid);
			$postCat = cat_rel($articleCAT, 'seftitle');
			$link = $postCat.'/'.$articleSEF;
       		mysql_query("DELETE FROM "._PRE.'comments'." WHERE id = $commentid");
			echo notification(0,'', $link);
			echo '<meta http-equiv="refresh" content="1; url='._SITE.$postCat.'/'.$articleSEF.'/">';
			break;
		case 'delete_category_all':
			$art_query = mysql_query("SELECT id FROM "._PRE.'articles'." WHERE category = $id");
			while ($rart = mysql_fetch_array($art_query)) {
				mysql_query("DELETE FROM "._PRE.'comments'." WHERE articleid = $rart[id]");
			}
			mysql_query("DELETE FROM "._PRE.'articles'." WHERE category = $id");
			$sub_query = mysql_query("SELECT id FROM "._PRE.'categories'." WHERE subcat = $id");
			while ($rsub = mysql_fetch_array($sub_query)) {
				$art_query = mysql_query("SELECT id FROM "._PRE.'articles'." WHERE category = $rsub[id]");
				while ($rart = mysql_fetch_array($art_query)) {
					mysql_query("DELETE FROM "._PRE.'comments'." WHERE articleid = $rart[id]");
				}
				mysql_query("DELETE FROM "._PRE.'articles'." WHERE category = $rsub[id]");
			}
			mysql_query("DELETE FROM "._PRE.'categories'." WHERE subcat = $id"); delete_cat($id);
			echo notification(0,'', 'snews_categories');
			break;
		case 'hide':
        case 'show':
            $id = $_GET['id'];
            $item = $_GET['item'];
            $back = $_GET['back'];
            $no_yes = $task == 'hide' ? 'NO' : 'YES';
            switch ($item) {
                case 'snews_articles':
                	$order = 'artorder';
                	$link = empty($back) ? 'snews_articles' : $back;
                	break;
                case 'extra_contents':
                	$order = 'artorder';
                	$link = empty($back) ? 'extra_contents' : $back;
                	break;
                case 'snews_pages':
                	$order = 'artorder';
                	$link = empty($back) ? 'snews_pages' : $back;
                	break;
            }
            $item = 'articles';
            mysql_query("UPDATE "._PRE."$item SET visible = '$no_yes' WHERE id = '$id'");
            echo notification(0,l('please_wait'));
            echo '<meta http-equiv="refresh" content="1; url='._SITE.$link.'/">';
        break;
		}
	}
}

// FILES
function files() {
 	$upload_file = isset($_POST['upload']) ? $_POST['upload'] : null;
 	$ip = (isset($_POST['ip']) && $_POST['ip'] == $_SERVER['REMOTE_ADDR']) ? $_POST['ip'] : null;
 	$time = (isset($_POST['time']) && (time() - $_POST['time']) > 4) ? $_POST['time'] : null;
 	if ($ip && $time && $upload_file && _ADMIN) {
		$ignore = explode(',', l('ignored_items'));
		$file_types = explode(',', s('allowed_files'));
		$image_types = explode(',', s('allowed_images'));
		$extension = array_merge($file_types, $image_types);
		if ($_FILES['imagefile']['type']) {
			$filetemp = $_FILES['imagefile']['tmp_name'];
			$filename = strtolower($_FILES['imagefile']['name']);
			$filetype = $_FILES['imagefile']['type'];
			if (!in_array(substr(strrchr($filename, '.'), 1), $extension) || in_array($filename, $ignore)) {
				die(notification(2,l('file_error'),'snews_files'));
			} else {
				$upload_dir = $_POST['upload_dir'].'/';
				copy ($filetemp, $upload_dir.$filename) or die (l('file_error'));
				echo notification(0,'','snews_files');
				$kb_size = round(($_FILES['imagefile']['size'] / 1024), 1);
				echo '<p><a href="'.$upload_dir.$filename.'" title="'.$filename.'">'.$filename.'</a> ['.$kb_size.' KB] ['.$filetype.']</p>';
			}
		} else {
			die(notification(2,l('file_error'),'snews_files'));
		}
	} else {
		if (isset($_GET['task']) == 'delete') {
			$file_to_delete = $_GET['folder'].'/'.$_GET['file'];
			@unlink($file_to_delete);
			echo notification(0,'','snews_files');
		} else {
			echo '<div class="adminpanel">';
			echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', l('upload'));
			echo '<form method="post" action="snews_files/" enctype="multipart/form-data">';
			echo '<p>'.l('uploadto').
			'&nbsp;&nbsp;&nbsp;<select name="upload_dir" id="ud1">';
			echo '<option value=".">..</option>';
			filelist('option',".", 0);
			echo '</select></p><p>'.l('uploadfrom').
			'&nbsp;&nbsp;&nbsp;<input type="file" name="imagefile" /></p><p>';
			echo html_input('hidden', 'ip', 'ip1', $_SERVER['REMOTE_ADDR'], '', '', '', '', '', '', '', '', '', '', '');
			echo html_input('hidden', 'time', 'time1', time(), '', '', '', '', '', '', '', '', '', '', '');
			echo html_input('submit', 'upload', 'upload', l('upload'), '', 'button', '', '', '', '', '', '', '', '', '');
			echo '</p></form></fieldset></div><div class="adminpanel">';
			echo html_input('fieldset', '', '', '', '', '', '', '', '', '', '', '', '', '', l('view_files').' '.(!isset($_POST['upload_dir']) ? ' root' : ' '.
			str_replace('.', 'root', $_POST['upload_dir'])));
			echo '<form method="post" action="snews_files/" enctype="multipart/form-data">';
			echo '<p><select name="upload_dir" id="ud2"><option value=".">..</option>';
			filelist('option',".");
			echo '</select>';
			echo html_input('hidden', 'file', 'file', $file, '', '', '', '', '', '', '', '', '', '', '');
			echo html_input('hidden', 'ip', 'ip2', $_SERVER['REMOTE_ADDR'], '', '', '', '', '', '', '', '', '', '', '');
			echo html_input('hidden', 'time', 'time2', time(), '', '', '', '', '', '', '', '', '', '', '');
			echo html_input('submit', 'show', 'show', l('view'), '', 'button', '', '', '', '', '', '', '', '', '');
			$handle = (isset($_POST['upload_dir']) && strlen($_POST['upload_dir']) > 2) ? substr($_POST['upload_dir'], 2) : ".";
			echo '</p><p>';
			filelist('list', $handle);
			echo '</p></form></fieldset></div>';
		}
	}
}

// FILELIST FUNCTION
function filelist($mode, $path, $depth = 0) {
	$ignore = explode(',', l('ignored_items'));
	$file_types = explode(',', s('allowed_files'));
	$image_types = explode(',', s('allowed_images'));
	$types = array_merge($file_types, $image_types);
	$dh = @opendir($path);
	while (false !== ($file = readdir($dh))) {
		$target = $path.'/'.$file;
		if(!in_array($file, $ignore)) {
			$spaces = str_repeat(l('divider').' ', ($depth));
			switch(true) {
				case ($mode == 'option' && is_dir($target)):
					$selected = $_POST['view_dir'] == $target ? ' selected="selected"' : '';
					echo '<option value="'.$target.'"'.$selected.'>'.$spaces.$file.'</option>';
			  		filelist('option', $target, ($depth + 1));
			  		break;
			  	case ($mode == 'list' && is_file($target) && in_array(substr(strrchr($target, '.'), 1), $types)):
			  		echo '
					<a href="'.$target.'" title="'.l('view').' '.$file.'">'.$file.'</a>
						'.l('divider').'
					<a href="?action=snews_files&amp;task=delete&amp;folder='.$path.'&amp;file='.$file.'" title="'.l('delete').' '.$file.'" onclick="return pop()">
						'.l('delete').'</a><br />';
			  		break;
			}
		}
	}
	closedir($dh);
}

// CONNECT TO DATABASE
function connect_to_db() {
	$db = mysql_connect(db('dbhost'), db('dbuname'), db('dbpass'));
	mysql_select_db(db('dbname')) or die(l('dberror'));
	if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '"._PRE.'articles'."'")) != 1) {
      	die(l('db_tables_error'));
	}
}

// Get parent/child from an id
function cat_rel($var, $column) {
	$categoryid = $var;
	$join_result = mysql_query(
		"SELECT parent.$column FROM "._PRE.'categories'." as child
			INNER JOIN "._PRE.'categories'." as parent
				ON parent.id = child.subcat
			WHERE child.id = $categoryid");
	while ($j = mysql_fetch_array($join_result)) {
		$parent = $j[$column].'/';
	}
	$subresult = mysql_query(
		"SELECT $column FROM "._PRE.'categories'."
			WHERE id = $categoryid");
	while ($c = mysql_fetch_array($subresult)) {
		$child = $c[$column];
	}
	return $parent.$child;
}

// SMART RETRIEVE FUNCTION
function populate_retr_cache() {
	global $retr_cache_cat_id, $retr_cache_cat_sef;
	$result = mysql_query('SELECT id, seftitle, name FROM '._PRE.'categories'.'');
	while ($r = mysql_fetch_array($result)) {
		$retr_cache_cat_id[$r['id']] = $r['seftitle'];
		$retr_cache_cat_sef[$r['seftitle']] = $r['name'];
	}
}
$retr_init = False;

function retrieve($column, $table, $field, $value) {
	if (is_null($value))
		return null;
	if ($table == 'categories') {
		global $retr_cache_cat_id, $retr_cache_cat_sef, $retr_init;
		if (!$retr_init) {
			populate_retr_cache();
			$retr_init = true;
		}
		if ($column == 'name') {
			return $retr_cache_cat_sef[$value];
		} else if ($column == 'seftitle') {
			return $retr_cache_cat_id[$value];
		}
	}
	$result = mysql_query("SELECT $column FROM "._PRE."$table WHERE $field = '$value'");
	while ($r = mysql_fetch_array($result)) {
		$retrieve = $r[$column];
	}
	return $retrieve;
}

//NOTIFICATION
function notification($error = 0, $note = '', $link = '') {
	// adds a "Warning" option
	$title = $error == 0 ? l('operation_completed') : ($error !== 0? l('admin_error') : l('warning'));
	$note = (!$note || empty($note)) ? '' : '<p>'.$note.'</p>';
	switch(true){
		case (!$link):
			$goto = '';
			break;
		case ($link == 'home'):
			$goto = '<p><a href="'._SITE.'">'.l('backhome').'</a></p>';
			break;
		case ($link != 'home'):
			$goto = '<p><a href="'._SITE.$link.'/" title="'.$link.'">'.l('back').'</a></p>';
			break;
	}
	if ($error == 2) {
		$_SESSION[_SITE.'fatal'] = $note == '' ? '' : '<h3>'.$title.'</h3>'.$note.$goto;
		echo '<meta http-equiv="refresh" content="0; url='._SITE.$link.'/">';
		return;
	} else {
		$output = '<h3>'.$title.'</h3>'.$note.$goto;
		return $output;
	}
}

// PREPARING ARTICLE FOR XML
function strip($text) {
	$search = array('/\[include\](.*?)\[\/include\]/', '/\[func\](.*?)\[\/func\]/', '/\[break\]/', '/</', '/>/');
	$replace = array('', '', '', '<', '>');
	$output = preg_replace($search, $replace, $text);
	$output = stripslashes(strip_tags($output, '<a><img><h1><h2><h3><h4><h5><ul><li><ol><p><hr><br><b><i><strong><em><blockquote>'));
	return $output;
}

// HTML ENTITIES
function entity($item) {
	$item = htmlspecialchars($item, ENT_QUOTES, s('charset'));
	return $item;
}

//FILE INCLUSION
function file_include($text, $shorten) {
	$fulltext = substr($text, 0, $shorten);
   if(substr_count ($fulltext, '&')>0){$fulltext = str_replace('&', '&amp;', str_replace('&amp;', '&', $fulltext));}
	if ($shorten < 9999000 && preg_match('<p>',$fulltext)) {
		if (substr_count ($fulltext, '<p>') > substr_count ($fulltext, '</p>')) {
			$fulltext .='</p>';
		}
	}
    $ins = strpos($fulltext, '[/func]');
    if ($ins > 0) {
       	$text = str_replace('[func]', '|&|', $fulltext);
       	$text = str_replace('[/func]', '|&|', $text);
       	$text = explode('|&|', $text);
		$num = count($text) - 1;
		$i = 1;
		while ($i <= $num) {
			$func = explode(':|:', $text[$i]);
			ob_start();
			$returned = call_user_func_array($func[0], explode(',',$func[1]));
			$text[$i] = ob_get_clean();
			if (empty($text[$i])) {
				$text[$i] = $returned;
			}
			$i = $i + 2;
		}
		$fulltext = implode($text);
    }
	$inc = strpos($fulltext, '[/include]');
	if ($inc > 0) {
		$text = str_replace('[include]', '|&|', $fulltext);
		$text = str_replace('[/include]', '|&|', $text);
		$text = explode('|&|', $text);
		$num = count($text);
		$extension = explode(',', s('file_extensions'));
		for ($i = 0; $i<$num; $i++) {
			if ($i == $num) {
				break;
			}
			if (!in_array(substr(strrchr($text[$i], '.'), 1), $extension)) {
				echo substr($text[$i], 0);
			} else {
				if (preg_match('/^[a-z0-9_\-.\/]+$/i', $text[$i])) {
					$filename=$text[$i];
					file_exists($filename) ? include($filename) : print l('error_file_exists');
				} else {
					echo l('error_file_name');
				}
			}
		}
	} else {
		echo $fulltext;
	}
}

// CLEAN - cleaning query
function clean($query) {
	if (get_magic_quotes_gpc()) {
		$query = stripslashes($query);
	}
	$query = mysql_real_escape_string($query);
	return $query;
}

// BREAK TO NEW LINE
function br2nl($text){
    $text = str_replace('\r\n','',str_replace("<br />","\n",preg_replace('/<br\\\\s*?\\/??>/i', "\\n", $text)));
    return $text;
}

// SEND EMAIL
function send_email($send_array) {
	foreach ($send_array as $var => $value) { $$var = $value; }
   	$body = isset($status) ? $status."\n" : '';
   	if (isset($message)) {
 		$text = l('message').': '."\n".br2nl($message)."\n";
   	}
   	if (isset($comment)) {
   		$text = l('comment').': '."\n".br2nl($comment)."\n";
   	}
   	$header = "MIME-Version: 1.0\n";
   	$header .= "Content-type: text/plain; charset=".s('charset')."\n";
   	$header .= "From: $name <$email>\r\nReply-To: $name <$email>\r\nReturn-Path: <$email>\r\n";
   	$body .= isset($name) ? l('name').': '.$name."\n" : '';
   	$body .= isset($email) ? l('email').': '.$email."\n" : '';
//   	The below requires new lang var if ip to be sent with email -  $l['ip'] = 'IP';
//   	$body .= isset($ip) ? l('ip').': '.$ip."\n" : '';
   	$body .= isset($url) && $url!='' ? l('url').': '.$url."\n\n" : '';
   	$body .= $text."\n";
   	mail($to,$subject,$body,$header);
}

// USER/PASS CHECK
function checkUserPass($input) {
	$output = clean(cleanXSS($input));
	$output = strip_tags($output);
	if (ctype_alnum($output) === true && strlen($output) > 3 && strlen($output) < 14) {
		return $output;
	} else {
		return null;
	}
}

// MATH CAPTCHA
function mathCaptcha() {
	$x = rand(1, 9);
	$y = rand(1, 9);
	$_SESSION[_SITE.'mathCaptcha-digit'] = $x + $y;
	$math = '
		<p><label for="calc">
			* '.l('math_captcha').':
		</label><br />';
	$math .= $x.' + '.$y.' = ';
	$math .= '
		<input type="text" name="calc" id="calc" />
		</p>';
	return $math;
}

// CHECK MATH CAPTCHA RESULT
function checkMathCaptcha() {
	$result = false;
   	$testNumber = isset($_SESSION[_SITE.'mathCaptcha-digit']) ? $_SESSION[_SITE.'mathCaptcha-digit'] : 'none';
   	unset($_SESSION[_SITE.'mathCaptcha-digit']);
   	if (is_numeric($testNumber) && is_numeric($_POST['calc']) && ($testNumber == $_POST['calc'])) {
    	$result = true;
    }
   	return $result;
}

//CATEGORY CHECK
function check_category($category) {
	$main_menu = explode(',', l('cat_listSEF'));
	if (in_array($category, $main_menu)) {
		return true;
	} else {
		return false;
	}
}

// MAKE A CLEAN SEF URL
function cleanSEF($string) {
	$string = str_replace(' ', '-', $string);
	$string = preg_replace('/[^0-9a-zA-Z-_]/', '', $string);
	$string = str_replace('-', ' ', $string);
	$string = preg_replace('/^\s+|\s+$/', '', $string);
	$string = preg_replace('/\s+/', ' ', $string);
	$string = str_replace(' ', '-', $string);
	return strtolower($string);
}

// CLEAN CHECK SEF
function cleancheckSEF($string) {
    $ret = !preg_match('/^[a-z0-9-_]+$/i', $string) ? 'notok' : 'ok';
    return $ret;
}


// XSS CLEAN
$XSS_cache = array();
$ra1 = array('applet', 'body', 'bgsound', 'base', 'basefont', 'embed', 'frame', 'frameset', 'head', 'html',
             'id', 'iframe', 'ilayer', 'layer', 'link', 'meta', 'name', 'object', 'script', 'style', 'title', 'xml');
$ra2 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script',
            'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base',
            'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy',
            'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint',
            'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick',
            'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged',
            'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave',
            'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus',
            'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload',
            'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover',
            'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange',
            'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit',
            'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart',
            'onstop', 'onsubmit', 'onunload');
$tagBlacklist = array_merge($ra1, $ra2);

//CLEANXSS
function cleanXSS($val) {
	if ($val != "") {
		global $XSS_cache;
		if (!empty($XSS_cache) && array_key_exists($val, $XSS_cache)) return $XSS_cache[$val];
		$source = html_entity_decode($val, ENT_QUOTES, 'ISO-8859-1');
		$source = preg_replace('/&#38;#(\d+);/me','chr(\\1)', $source);
		$source = preg_replace('/&#38;#x([a-f0-9]+);/mei','chr(0x\\1)', $source);
		while($source != filterTags($source)) {
			$source = filterTags($source);
		}
		$source = nl2br($source);
		$XSS_cache[$val] = $source;
		return $source;
	}
	return $val;
}

//FILTER TAGS
function filterTags($source) {
	global $tagBlacklist;
	$preTag = NULL;
	$postTag = $source;
	$tagOpen_start = strpos($source, '<');
	while($tagOpen_start !== FALSE) {
		$preTag .= substr($postTag, 0, $tagOpen_start);
		$postTag = substr($postTag, $tagOpen_start);
		$fromTagOpen = substr($postTag, 1);
		$tagOpen_end = strpos($fromTagOpen, '>');
		if ($tagOpen_end === false) break;
		$tagOpen_nested = strpos($fromTagOpen, '<');
		if (($tagOpen_nested !== false) && ($tagOpen_nested < $tagOpen_end)) {
			$preTag .= substr($postTag, 0, ($tagOpen_nested+1));
			$postTag = substr($postTag, ($tagOpen_nested+1));
			$tagOpen_start = strpos($postTag, '<');
			continue;
		}
		$tagOpen_nested = (strpos($fromTagOpen, '<') + $tagOpen_start + 1);
		$currentTag = substr($fromTagOpen, 0, $tagOpen_end);
		$tagLength = strlen($currentTag);
		if (!$tagOpen_end) {
			$preTag .= $postTag;
			$tagOpen_start = strpos($postTag, '<');
		}
		$tagLeft = $currentTag;
		$attrSet = array();
		$currentSpace = strpos($tagLeft, ' ');
		if (substr($currentTag, 0, 1) == '/') {
			$isCloseTag = TRUE;
			list($tagName) = explode(' ', $currentTag);
			$tagName = substr($tagName, 1);
		} else {
			$isCloseTag = FALSE;
			list($tagName) = explode(' ', $currentTag);
		}
		if ((!preg_match('/^[a-z][a-z0-9]*$/i',$tagName)) || (!$tagName) || ((in_array(strtolower($tagName), $tagBlacklist)))) {
			$postTag = substr($postTag, ($tagLength + 2));
			$tagOpen_start = strpos($postTag, '<');
			continue;
		}
		while ($currentSpace !== FALSE) {
			$fromSpace = substr($tagLeft, ($currentSpace+1));
			$nextSpace = strpos($fromSpace, ' ');
			$openQuotes = strpos($fromSpace, '"');
			$closeQuotes = strpos(substr($fromSpace, ($openQuotes+1)), '"') + $openQuotes + 1;
			if (strpos($fromSpace, '=') !== FALSE) {
				if (($openQuotes !== FALSE) && (strpos(substr($fromSpace, ($openQuotes+1)), '"') !== FALSE))
					$attr = substr($fromSpace, 0, ($closeQuotes+1));
					else $attr = substr($fromSpace, 0, $nextSpace);
			} else $attr = substr($fromSpace, 0, $nextSpace);
			if (!$attr) $attr = $fromSpace;
				$attrSet[] = $attr;
				$tagLeft = substr($fromSpace, strlen($attr));
				$currentSpace = strpos($tagLeft, ' ');
		}
		$postTag = substr($postTag, ($tagLength + 2));
		$tagOpen_start = strpos($postTag, '<');
	}
	$preTag .= $postTag;
	return $preTag;
}

// CLEAN - WORD FILTER
function cleanWords($text) {
    if ((strtolower(s('word_filter_enable')) == 'on') && (file_exists(s('word_filter_file')))) {
        $bad_words_from_what = preg_replace('/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', '', file(s('word_filter_file')));
        $bad_words_from_what = preg_replace('/^(.*)$/', '/\\1/i', $bad_words_from_what);
        $bad_words_to_what = s('word_filter_change');
        $text = preg_replace($bad_words_from_what, $bad_words_to_what, $text);
        return $text;
    } else {
		return $text;
	}
}

// CHECK IF UNIQUE
function check_if_unique($what, $text, $not_id = 'x', $subcat) {
	$text = clean($text);
	switch ($what) {
		case 'article_seftitle':
			$sql = _PRE.'articles'.' WHERE seftitle = "'.$text.(!empty($not_id) ? '"
				AND category = '.$not_id : '"');
			break;
		case 'article_title':
			$sql = _PRE.'articles'.' WHERE title = "'.$text.(!empty($not_id) ? '"
				AND category = '.$not_id : '"');
			break;
		case 'subcat_seftitle':
			$sql = _PRE.'categories'.' WHERE seftitle = "'.$text.'"
				AND subcat = '.$subcat;
			break;
		case 'subcat_name':
			$sql = _PRE.'categories'.' WHERE name = "'.$text.'"
				AND subcat = '.$subcat;
			break;
		case 'cat_seftitle_edit':
			$sql = _PRE.'categories'.' WHERE seftitle = "'.$text.'"
				AND id != '.$not_id;
			break;
		case 'cat_name_edit':
			$sql = _PRE.'categories'.' WHERE name = "'.$text.'"
				AND id != '.$not_id;
			break;
		case 'subcat_seftitle_edit':
			$sql = _PRE.'categories'.' WHERE seftitle = "'.$text.'"
				AND subcat = '.$subcat.' AND id != '.$not_id;
			break;
		case 'subcat_name_edit':
			$sql = _PRE.'categories'.' WHERE name = "'.$text.'"
				AND subcat = '.$subcat.' AND id != '.$not_id;
			break;
		case 'group_seftitle':
			$sql = _PRE.'extras'.' WHERE seftitle = "'.$text.(!empty($not_id) ? '"
				AND id != '.$not_id : '"');
			break;
		case 'group_name':
			$sql = _PRE.'extras'.' WHERE name = "'.$text.(!empty($not_id) ? '"
				AND id != '.$not_id : '"');
			break;
	}
	$rows = mysql_num_rows(mysql_query('SELECT id FROM '.$sql));
	if ($rows == 0) {
		return false;
	} else {
		return true;
	}
}

// ARTICLES - FUTURE POSTING
function update_articles() {
	$last_date = s('last_date');
	$updatetime = !empty($last_date) ? strtotime($last_date) : time();
	$dif_time = time() - $updatetime;
	if ($dif_time > 1200 || empty($last_date)) {
		mysql_query('UPDATE '._PRE.'articles'.'
					SET published=1
					WHERE published=2
						AND date <= NOW()');
		mysql_query('UPDATE '._PRE.'settings'.'
					SET value=NOW()
					WHERE name=\'last_date\'');
	}
}


?>
