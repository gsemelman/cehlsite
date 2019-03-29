<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

if($modeGMO == 1) include GMO_ROOT.'editor/teamRoster.php';
if($modeGMO == 2) include GMO_ROOT.'editor/teamLines.php';

?>

<script type="text/javascript">
<!--

<?php if($modeGMO == 1) { ?>
document.addEventListener("DOMContentLoaded", trDivCreateLists(), false);
<?php } ?>

<?php if($modeGMO == 2) { ?>
document.addEventListener("DOMContentLoaded", tlDivCreateLists(), false);
<?php } ?>

//-->
</script>