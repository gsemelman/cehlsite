<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Contracts';
$CurrentPage = 'Contracts';
include 'head.php';
?>

	<div class = "container">

<!-- 		<div class="row"> -->
<!-- 			<div class="col iframe-container"> 
				<iframe src="<?php echo $folderLegacy ?>cehlContracts.htm" frameborder="0" allowfullscreen></iframe>
 			</div> -->
<!-- 		</div> -->
		
		<h3>CEHL Contracts</h3>
		
		<div class="col-sm-3">
			 <select name="menu1" class="form-control mb-3" id="menu1">
			<option value="<?php echo $folderLegacy ?>cehlContracts.htm">Current</option>
            <option value="<?php echo $folderLegacy ?>season26contracts.htm">Season 26</option>
            <option value="<?php echo $folderLegacy ?>season25contracts.htm">Season 25</option>
            <option value="<?php echo $folderLegacy ?>season24contracts.htm">Season 24</option>
            <option value="<?php echo $folderLegacy ?>season23contracts.htm">Season 23</option>
            <option value="<?php echo $folderLegacy ?>season22contracts.htm">Season 22</option>
            <option value="<?php echo $folderLegacy ?>season21contracts.htm">Season 21</option>
            <option value="<?php echo $folderLegacy ?>season20contracts.htm">Season 20</option>
            <option value="<?php echo $folderLegacy ?>season19contracts.htm">Season 19</option>
            <option value="<?php echo $folderLegacy ?>season18contracts.htm">Season 18</option>
            <option value="<?php echo $folderLegacy ?>season17contracts.htm">Season 17</option>
            <option value="<?php echo $folderLegacy ?>season16contracts.htm">Season 16</option>
            <option value="<?php echo $folderLegacy ?>season15contracts.htm">Season 15</option>
            <option value="<?php echo $folderLegacy ?>season14contracts.htm">Season 14</option>
            <option value="<?php echo $folderLegacy ?>season13contracts.htm">Season 13</option>
            <option value="<?php echo $folderLegacy ?>season12contracts.htm">Season 12</option>
            <option value="<?php echo $folderLegacy ?>season11contracts.htm">Season 11</option>

            
            </select>
		
		</div>
		
		<div class="col iframe-container"> 
				<iframe id="contractFrame" src="<?php echo $folderLegacy ?>cehlContracts.htm" frameborder="0" allowfullscreen></iframe>
		</div>
       
        <script type="text/javascript">


        
         var urlmenu = document.getElementById( 'menu1' );
         urlmenu.onchange = function() {

        	 document.getElementById('contractFrame').src = this.options[ this.selectedIndex ].value;

         };
        </script>
		
	</div>

</body>

</html>