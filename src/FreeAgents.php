<?php
include 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = 'Free Agents';
$CurrentPage = 'FreeAgents';
include 'head.php';

include_once 'common.php';
?>

<style>

.table.fixed-column-striped,
.table.fixed-column {
    border-collapse: collapse;
    width: 100%;
}

.table.fixed-column td, th,
.table.fixed-column-striped td, th {
    /*border: 1px solid #dddddd;*/
    text-align: left;
    padding: 3px;
}

.table.fixed-column-striped th:first-child, td:first-child,
.table.fixed-column th:first-child, td:first-child
{
  position:sticky;
  left:0px;
}

.table.fixed-column-striped tr:nth-child(even) td:first-child {
     background-color:rgba(176, 214, 255, 1.0);
}
.table.fixed-column-striped tr:nth-child(odd) td:first-child {
    background-color:rgba(225, 239, 255, 1.0);
}

.table tfoot th,
.table thead th{
    background-color:rgba(23, 145, 202, 1.0);
}

.table.fixed-column-striped th a,
.table.fixed-column th a
{
  color:#ffffff;
}

.table-striped>tbody>tr:nth-child(even) {background-color:rgba(176, 214, 255, 1.0);}
.table-striped>tbody>tr:nth-child(odd) {background-color:rgba(225, 239, 255, 1.0);}

</style>

	<div class = "container" style = "width: 100%; height: 100%;">
	
	<h3><?php echo $CurrentTitle; ?></h3>
	
		<?php
		
		function everything_in_tags($string, $tagname)
		{
		    $pattern = "#<\s*?$tagname\b[^>]*>(.*?)</$tagname\b[^>]*>#s";
		    preg_match($pattern, $string, $matches);
		    return $matches[1];
		}
		
		function extractString($string, $start, $end) {
		    $string = " ".$string;
		    $ini = strpos($string, $start);
		    if ($ini == 0) return "";
		    $ini += strlen($start);
		    $len = strpos($string, $end, $ini) - $ini;
		    return substr($string, $ini, $len);
		}
		
		$playoff = '';
		
		$Fnm = getLeagueFile($folder, $playoff, 'FreeAgents.html', 'FreeAgents');
		
		$a = 0;
		$i = 0;
		if (file_exists($Fnm)) {
		    $tableau = file($Fnm);
		    while(list($cle,$val) = myEach($tableau)) {
		        $val = utf8_encode($val);
		        
		        //get current team
		        if(substr_count($val, '<H3>')) {
		            $curTeam = trim(strip_tags($val));
		        }
		        
		        //extract player attribs
		        if(substr_count($val, '</PRE>')) {
		            $a = 0;
		        }
		        if($a == 1) {
		            $reste = trim($val);
		            $unassignedOV[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedLD[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedEX[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedSC[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedDF[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedPC[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedPA[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedSK[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedDI[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedDU[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedEN[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedST[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedSP[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedIT[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedPO[$i] = trim(substr($reste, strrpos($reste, ' ')));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedSalary[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedStatus[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedAG[$i] = substr($reste, strrpos($reste, ' '));
		            $reste = trim(substr($reste, 0, strrpos($reste, ' ')));
		            $unassignedPL[$i] = $reste;
		            
		            $unassignedTeam[$i] = $curTeam;
		            
		            //echo $unassignedPL[$i];
		            
		            $i++;
		            
		           
		        }
		        if(substr_count($val, '<PRE>Player')) {
		            $a = 1;
		        }
		    }
		    if(isset($unassignedPL)) {
		        
		        echo '<div class="table-responsive">';
		        echo '<table id="freeAgents" class="table table-sm table-striped fixed-column-striped">';
		        
		        echo '<thead>
                                        <tr class="tableau-top">
                                            <th class="text-left">'.$rostersName.'</th>
                                            <th>Team</th>
                                            <th>Age</th>
                                            <th>Status</th>
                                            <th>Salary</th>
                                			<th>PO</th>
                                            <th>'.$rostersIT.'</th>
                                            <th>'.$rostersSP.'</th>
                                            <th>'.$rostersST.'</th>
                                            <th>'.$rostersEN.'</th>
                                            <th>'.$rostersDU.'</th>
                                            <th>'.$rostersDI.'</th>
                                            <th>'.$rostersSK.'</th>
                                            <th>'.$rostersPA.'</th>
                                            <th>'.$rostersPC.'</th>
                                            <th>'.$rostersDF.'</th>
                                            <th>'.$rostersOF.'</th>
                                            <th>'.$rostersEX.'</th>
                                            <th>'.$rostersLD.'</th>
                                            <th>'.$rostersOV.'</th>
         
                            			</tr>
                                    </thead>';
		        echo '<tbody style="font-weight:normal">';
		        
		        for ($x = 0; $x < $i; $x++) {
		            //echo "The number is: $unassignedPL[$x] <br>";
		            echo '<tr>';
		            echo '<td class="text-left">'.$unassignedPL[$x].'</td>';
		            echo '<td>'.$unassignedTeam[$x].'</td>';
		            echo '<td>'.$unassignedAG[$x].'</td>';
		            echo '<td>'.$unassignedStatus[$x].'</td>';
		            echo '<td>'.$unassignedSalary[$x].'</td>';
		            echo '<td>'.$unassignedPO[$x].'</td>';
		            echo '<td>'.$unassignedIT[$x].'</td>';
		            echo '<td>'.$unassignedSP[$x].'</td>';
		            echo '<td>'.$unassignedST[$x].'</td>';
		            echo '<td>'.$unassignedEN[$x].'</td>';
		            echo '<td>'.$unassignedDU[$x].'</td>';
		            echo '<td>'.$unassignedDI[$x].'</td>';
		            echo '<td>'.$unassignedSK[$x].'</td>';
		            echo '<td>'.$unassignedPA[$x].'</td>';
		            echo '<td>'.$unassignedPC[$x].'</td>';
		            echo '<td>'.$unassignedDF[$x].'</td>';
		            echo '<td>'.$unassignedSC[$x].'</td>';
		            echo '<td>'.$unassignedEX[$x].'</td>';
		            echo '<td>'.$unassignedLD[$x].'</td>';
		            echo '<td>'.$unassignedOV[$x].'</td>';
		            echo '</tr>';        
		        } 
		        echo '</tbody>';
		        echo '</table>';
		        
		    }else {
		        echo $langUnassignedPlayersNotFound;
		    }

		}
		else echo $allFileNotFound.' - '.$Fnm;
		?>
		
		
        

<!-- 		<div class="row"> -->
<!-- 			<div class="col-sm-12 col-md-8 offset-md-2 iframe-container"> 
				<iframe src="<?php echo $folder ?>cehlFreeAgents.html" frameborder="0" allowfullscreen></iframe>
			</div> -->
<!-- 		</div> -->
		
	</div>
	
	<script>

	window.onload = function () {
	makeTableSortable('freeAgents');
	};

	</script>

</body>

</html>