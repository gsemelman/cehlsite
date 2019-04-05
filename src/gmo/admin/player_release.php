
<?php


include GMO_ROOT.'login/mysqli.php';

$playerReleaseId = array();


$sql = "SELECT id, date(date) as date, EQUIPE as team, playerName FROM `".$db_table."_player_release` r INNER JOIN  `".$db_table."` g ON r.teamId = g.INT";

$query = mysqli_query($con, $sql) or die(mysqli_error($con));
if(mysqli_num_rows($query) != 0) {
    $x = 0;
    while($data = mysqli_fetch_array($query)) {
        $playerReleaseId[$x] = $data['id'];
        $playerReleaseDate[$x] = $data['date'];
        $playerReleaseTeam[$x] = $data['team'];
        $playerReleaseName[$x] = $data['playerName'];

        $x++;
    }

}


mysqli_close($con);
    
    

?>
<div class="container mt-3">

	<h5>Player Release Requests</h5>
	<div class="row">
		<div class="col">
            <table class="table table-sm table-striped text-center">
              <thead>
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Team</th>
                  <th scope="col">Player</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
               
                <?php 
                if($playerReleaseId){
                    for ($i = 0; $i < count($playerReleaseId); $i++) {
                        echo '<tr>
                          <td>'.$playerReleaseDate[$i].'</td>
                          <td>'.$playerReleaseTeam[$i].'</td>
                           <td>'.$playerReleaseName[$i].'</td>
                          <td><input onclick="javascript:deleteReleaseRequest('.$playerReleaseId[$i].');" class="button" type="button" value="'.$db_admin_position[11].'"></td>
                        </tr>';
                    }
                }
         
                ?>
         
              </tbody>
            </table>
    	</div>
	</div>
</div>

<?php 
unset($playerReleaseId,$playerReleaseDate,$playerReleaseTeam,$playerReleaseName);
?>

<script type="text/javascript">
function deleteReleaseRequest(id) {
	   $.ajax({
	    	  type: "POST",
	    	  url: "<?php echo BASE_URL?>gmo/admin/player_release_delete.php",
	    	  data: {id: id}, // serializes the form's elements.
	    	 // dataType: 'json',
	    	  success: function(data){
	
	    	    location.reload();
	    	   
	    	  },
	    	    error : function(xhr, textStatus, errorThrown ) {
	    	        if (textStatus == 'timeout') {
	    	            this.tryCount++;
	    	            if (this.tryCount <= this.retryLimit) {
	    	                //try again
	    	                $.ajax(this);
	    	                return;
	    	            }            
	    	            return;
	    	        }
//	    	        if (xhr.status == 500) {
//	    	        	 alert("Error Requesting ticket price change");
//	    	        } else {
//	    	            //handle error
//	    	        }
	    	        alert("Error Deleting player release");

	    	        return;
	    	       
	    	    }
	    	});
}
</script>
