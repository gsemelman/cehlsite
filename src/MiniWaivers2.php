<?php

include_once 'config.php';
include_once 'lang.php';
include_once 'common.php';
include_once 'classes/Waivers.php';
include_once 'classes/Waiver.php';

?>


<div class="container">
	<div class="row">
		<div class="col">
			<div class="table-responsive">
				<table class="table table-sm">

                <?php
                if (! isset($playoff))
                    $playoff = '';
                if ($playoff == 1)
                    $playoff = 'PLF';
                
                $fileName = getLeagueFile($folder, $playoff, 'Waivers.html', 'Waivers');
                
                if (file_exists($fileName)) {
                    //get waivers from file
                    $waivers = new Waivers($fileName);
                    $results = $waivers->get_waivers();
                    
                    if (isset($results) && !empty($results)) {
                        //create table header
                        echo '<tr class="tableau-top">
            			<th>'.$waiversPlayer.'</th>
            			<th>'.$waiversDate.'</th>
            			<th>'.$waiversBy.'</th>
            			<th>'.$waiversClaimed.'</th>
            			</tr>';
                        
                        //create result rows
                        foreach ($results as $waiver) {

                            echo '<tr">';
                                echo '<td>'.$waiver->player.'</td>';
                                echo '<td>'.$waiver->waiveDate.'</td>';
                                echo '<td>'.$waiver->waivedBy.'</td>';
                                echo '<td>'.$waiver->claimedBy.'</td>';
                            echo '</tr>';
                        }
                    }else{
                        //no waivers
                        echo '<tr><td colspan="4" style="font-weight:bold;">'.$waiversNothing.'</td></tr>';
                    }
                    

                } else
                    echo '<tr><td>' . $allFileNotFound . ' - ' . $fileName . '</td></tr>';
                
                ?>
                
                </table>
			</div>
		</div>
	</div>
</div>
