


<?php

include FS_ROOT.'gmo/membre/js.php';

include FS_ROOT.'gmo/css.php'; // Styling Pages

include FS_ROOT.'gmo/admin/lang.php';
if ( isset($_GET['admin']) || isset($_POST['admin']) ) {
	$mode = ( isset($_GET['admin']) ) ? $_GET['admin'] : $_POST['admin'];
	$mode = htmlspecialchars($mode);
	
	if ( $mode == 'trade' ) include FS_ROOT.'admin/trade_js.php';
	if ( $mode == 'trademan' ) include FS_ROOT.'admin/tradeMan_js.php';
	if ( $mode == 'ufa' ) include FS_ROOT.'admin/ufa_js.php';
	if ( $mode == 'ufasign' ) include FS_ROOT.'admin/ufaSign_js.php';
}
?>

</head>
<body>
<div id="popupAlert" style="display:none; position:fixed; top:5px; left:50%; transform: translateX(-50%); width:85%; z-index:20; text-align:center; padding:20px; background-color:#ae654c; color:#ffffff; font-weight:bold; border-radius:10px; border:0px;"></div>
<?php
$equipe = $_SESSION['equipe'];

if ( isset($_GET['admin']) || isset($_POST['admin']) ) {
	$mode = ( isset($_GET['admin']) ) ? $_GET['admin'] : $_POST['admin'];
	$mode = htmlspecialchars($mode);
	
	if( $mode != 'gmo' && $mode != 'first' ) {
	    echo '<a href="'.BASE_URL.'MyCehl.php?#Admin">'.$db_admin_all_langue[0].'</a><br>';
		echo $league_name.'<br>';
	}

	if ( $mode == 'user' ) include FS_ROOT.'gmo/admin/user.php';
	if ( $mode == 'pass' ) include FS_ROOT.'gmo/admin/password.php';
	if ( $mode == 'noms' ) include FS_ROOT.'gmo/admin/noms.php';
	if ( $mode == 'userpass' ) include FS_ROOT.'gmo/admin/userpass.php';
	if ( $mode == 'triche' ) include FS_ROOT.'gmo/admin/triche.php';
	if ( $mode == 'actif' ) include FS_ROOT.'gmo/admin/actif.php';
	if ( $mode == 'fhlteam' ) include FS_ROOT.'gmo/admin/fhlteam.php';
	if ( $mode == 'first' ) include FS_ROOT.'gmo/admin/first.php';
	if ( $mode == 'param' ) include FS_ROOT.'gmo/admin/param.php';
	if ( $mode == 'upload' ) include FS_ROOT.'gmo/admin/upload.php';
	if ( $mode == 'trade' ) include FS_ROOT.'gmo/admin/trade.php';
	if ( $mode == 'trademan' ) include FS_ROOT.'gmo/admin/tradeMan.php';
	if ( $mode == 'ufa' ) include FS_ROOT.'gmo/admin/ufaSend.php';
	if ( $mode == 'ufasign' ) include FS_ROOT.'gmo/admin/ufaSign.php';
	if ( $mode == 'colors' ) include FS_ROOT.'gmo/admin/colors.php';
	if ( $mode == 'colors2' ) include FS_ROOT.'gmo/admin/colorsGet.php';
	if ( $mode == 'position' ) include FS_ROOT.'gmo/admin/position.php';
	if ( $mode == 'poll' ) include FS_ROOT.'gmo/admin/poll.php';
}
else {
	//echo $league_name.'<br>';	
	include FS_ROOT.'gmo/admin/accueil.php';
}

echo '</div>';
?>