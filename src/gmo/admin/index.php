


<?php

include GMO_ROOT.'membre/js.php';

include GMO_ROOT.'css.php'; // Styling Pages

include GMO_ROOT.'admin/lang.php';
if ( isset($_GET['admin']) || isset($_POST['admin']) ) {
	$mode = ( isset($_GET['admin']) ) ? $_GET['admin'] : $_POST['admin'];
	$mode = htmlspecialchars($mode);
	
	if ( $mode == 'trade' ) include FS_ROOT.'admin/trade_js.php';
	if ( $mode == 'trademan' ) include FS_ROOT.'admin/tradeMan_js.php';
	if ( $mode == 'ufa' ) include FS_ROOT.'admin/ufa_js.php';
	if ( $mode == 'ufasign' ) include FS_ROOT.'admin/ufaSign_js.php';
}
?>

<style>

/* LEAGUE SETTINGS PAGE*/
table.tableSpace {
	border-collapse: separate;
    border-spacing:0px 5px;
    width: 100%;
}
table.tableSpace tr {
	box-shadow: 0px 0px 2px 0px rgba(38, 115, 76,0.12), 0px 2px 2px 0px rgba(38, 115, 76,0.24);
}
table.tableSpace td {
	padding: 10px;
}
table.tableSpace tr:nth-child(even) {
	background-color: #<?php echo $databaseColors['colorTableBackground2']; ?>;
	color:#<?php echo $databaseColors['colorTableText2']; ?>;
}
table.tableSpace tr:nth-child(odd) {
	background-color: #<?php echo $databaseColors['colorTableBackground1']; ?>;
	color:#<?php echo $databaseColors['colorTableText1']; ?>;
}
table.tableSpace tr:hover {
	background-color: #<?php echo $databaseColors['colorTableBackgroundHover']; ?>;
	color:#<?php //echo $databaseColors['colorTableTextHover']; ?>;
} 

</style>

</head>
<body>
<div id="popupAlert" style="display:none; position:fixed; top:5px; left:50%; transform: translateX(-50%); width:85%; z-index:20; text-align:center; padding:20px; background-color:#ae654c; color:#ffffff; font-weight:bold; border-radius:10px; border:0px;"></div>
<?php
$equipe = $_SESSION['equipe'];

if ( isset($_GET['admin']) || isset($_POST['admin']) ) {
	$mode = ( isset($_GET['admin']) ) ? $_GET['admin'] : $_POST['admin'];
	$mode = htmlspecialchars($mode);
	
	if( $mode != 'gmo' && $mode != 'first' ) {
	   // echo '<a href="'.BASE_URL.'MyCehl.php?#Admin">'.$db_admin_all_langue[0].'</a><br>';
	    echo '<a class="btn btn-outline-primary" href="'.BASE_URL.'MyCehl.php?#Admin">'.$db_admin_all_langue[0].'</a><br>';
	  
		//echo $league_name.'<br>';
	}

	if ( $mode == 'user' ) include GMO_ROOT.'admin/user.php';
	if ( $mode == 'pass' ) include GMO_ROOT.'admin/password.php';
	if ( $mode == 'noms' ) include GMO_ROOT.'admin/noms.php';
	if ( $mode == 'userpass' ) include GMO_ROOT.'admin/userpass.php';
	if ( $mode == 'triche' ) include GMO_ROOT.'admin/triche.php';
	if ( $mode == 'actif' ) include GMO_ROOT.'admin/actif.php';
	if ( $mode == 'fhlteam' ) include GMO_ROOT.'admin/fhlteam.php';
	if ( $mode == 'first' ) include GMO_ROOT.'admin/first.php';
	if ( $mode == 'param' ) include GMO_ROOT.'admin/param.php';
	if ( $mode == 'upload' ) include GMO_ROOT.'admin/upload.php';
	if ( $mode == 'trade' ) include GMO_ROOT.'admin/trade.php';
	if ( $mode == 'trademan' ) include GMO_ROOT.'admin/tradeMan.php';
	if ( $mode == 'ufa' ) include GMO_ROOT.'admin/ufaSend.php';
	if ( $mode == 'ufasign' ) include GMO_ROOT.'admin/ufaSign.php';
	if ( $mode == 'colors' ) include GMO_ROOT.'admin/colors.php';
	if ( $mode == 'colors2' ) include GMO_ROOT.'admin/colorsGet.php';
	if ( $mode == 'position' ) include GMO_ROOT.'admin/position.php';
	if ( $mode == 'poll' ) include GMO_ROOT.'admin/poll.php';
	if ( $mode == 'tickets' ) include GMO_ROOT.'admin/tickets.php';
	if ( $mode == 'playerRelease' ) include GMO_ROOT.'admin/player_release.php';
}
else {
	//echo $league_name.'<br>';	
	include GMO_ROOT.'admin/accueil.php';
}

echo '</div>';
?>