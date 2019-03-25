<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

if($modeGMO == 1) include FS_ROOT.'gmo/editor/teamRoster.php';
if($modeGMO == 2) include FS_ROOT.'gmo/editor/teamLines.php';

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