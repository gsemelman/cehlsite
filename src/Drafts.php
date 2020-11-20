<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Drafts';
$CurrentPage = 'Drafts';
include 'head.php';
?>

	<div class = "container">
<!-- 		<div class="row"> -->
<!-- 			<div class="col iframe-container"> -->
<!-- 				<iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTCOAzPLDY02CUCgRgyT96TGupcHtNGOS5v9Y9UWBTXy4p5KAAnt9IFcgMBb0PF-VpFKOqM1XPdGkJK/pubhtml?widget=true&amp;headers=false" frameborder="0" allowfullscreen></iframe> -->
<!-- 			</div> -->
<!-- 		</div> -->
		<h3>CEHL Drafts</h3>
		
	<!-- 	<a href="https://docs.google.com/spreadsheets/d/1hjOwb0M1nsEomyFvQL6dLpj0rSGLDTZ_vZS1p2QmN3c/edit?usp=sharing" target="_blank" class="btn btn-info" role="button">Enter 2017 Draft</a> -->
		
		<div class="col-sm-3">
			<select name="menu1" class="form-control mb-3" id="menu1">
				<option value="https://docs.google.com/spreadsheets/d/e/2PACX-1vSrQ8nkHXhKBcHarYRA5kFVJnktAFddhFMixIJaq11Kl3zSIsz_BlkDA7a3AKSNFIqOmS59BPNbPe-7/pubhtml?gid=1385704465&single=true">2018 Draft</option>
    			<option value="https://docs.google.com/spreadsheets/d/1hjOwb0M1nsEomyFvQL6dLpj0rSGLDTZ_vZS1p2QmN3c/pubhtml?gid=1385704465&amp;single=true&amp;widget=true&amp;headers=false">2017 Draft</option>
    			<option value="https://docs.google.com/spreadsheets/d/e/2PACX-1vTCOAzPLDY02CUCgRgyT96TGupcHtNGOS5v9Y9UWBTXy4p5KAAnt9IFcgMBb0PF-VpFKOqM1XPdGkJK/pubhtml?gid=1385704465&amp;single=true&amp;widget=true&amp;headers=false">2016 Draft</option>
                <option value="https://docs.google.com/spreadsheets/d/e/2PACX-1vQ-MY_MJPmANEv4h7JcR32CGPL0M67WuNNdySm1itvb8TafuieXJDHO3aHxBkzMhKcqWJrhhxZX1qpO/pubhtml?gid=1385704465&amp;single=true&amp;widget=true&amp;headers=false">2015 Draft</option>
                <option value="https://docs.google.com/spreadsheets/d/e/2PACX-1vRiFJzzhSl4WLhSTTtRkde82jb1cf_qGV0y68sTjHetqjDH2iSz0101jsxw8ML-VF4dcObgMP90TcqS/pubhtml?gid=1385704465&amp;single=true&amp;widget=true&amp;headers=false">2014 Draft</option>
                <option value="https://docs.google.com/spreadsheets/d/e/2PACX-1vQTgP2I-lRgcZuGqFjs_xYC3lstQmipd-mtaFBcRHaFeU_o4MMVkL8Y3Ch6adysiq3MeH_psMuY_tyv/pubhtml?gid=0&amp;single=true&amp;widget=true&amp;headers=false">2013 Draft</option>
                <option value="https://docs.google.com/spreadsheets/d/e/2PACX-1vQ8bcCG_3HENDLxPh1BH9nDepxmey9A7h_IcR0SlwohiUBkA8FJljidV-4SyoEJgc71PyjvVwZAJclv/pubhtml?gid=0&amp;single=true&amp;widget=true&amp;headers=false">2012 Draft</option>
                <option value="<?php echo $folderLegacy ?>2011draft.html">2011 Draft</option>
                <option value="<?php echo $folderLegacy ?>2010draft.html">2010 Draft</option>
                <option value="<?php echo $folderLegacy ?>2009draft.html">2009 Draft</option>
                <option value="<?php echo $folderLegacy ?>2008draft.html">2008 Draft</option>
                <option value="<?php echo $folderLegacy ?>2007draft.html">2007 Draft</option>
                <option value="<?php echo $folderLegacy ?>2006draft.html">2006 Draft</option>
                <option value="<?php echo $folderLegacy ?>2005draft.html">2005 Draft</option>
                <option value="<?php echo $folderLegacy ?>2004draft.html">2004 Draft</option>
                
            </select>
	
		</div>
		
<!-- 		<div class="col iframe-container">  -->
<!-- 				<iframe id="draftFrame" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vTCOAzPLDY02CUCgRgyT96TGupcHtNGOS5v9Y9UWBTXy4p5KAAnt9IFcgMBb0PF-VpFKOqM1XPdGkJK/pubhtml?widget=true&amp;headers=false" frameborder="0" allowfullscreen></iframe> -->
<!-- 		</div> -->
		
		<iframe id="draftFrame" onload="this.width=screen.width;this.height=screen.height;" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vSrQ8nkHXhKBcHarYRA5kFVJnktAFddhFMixIJaq11Kl3zSIsz_BlkDA7a3AKSNFIqOmS59BPNbPe-7/pubhtml?gid=1385704465&single=true" frameborder="0" allowfullscreen></iframe>

        <script type="text/javascript">

        
         var urlmenu = document.getElementById( 'menu1' );
         urlmenu.onchange = function() {
              //window.open(  this.options[ this.selectedIndex ].value );
        	 // location.href = this.options[ this.selectedIndex ].value;

        	 document.getElementById('draftFrame').src = this.options[ this.selectedIndex ].value;

         };
        </script>
		
	</div>
	
<?php include 'footer.php'; ?>