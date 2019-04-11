<?php
$dataTablesRequired = 1; //require datatables import

include 'config.php';
include 'lang.php';
$CurrentHTML = 'PlayerSearch.php';
$CurrentTitle ='Player Search';
$CurrentPage = 'PlayerSearch';
include 'head.php';

include_once 'classes/TeamHolder.php';

$gmFile = getLeagueFile($folder, $playoff, 'GMs.html', 'GMs');
$teams = new TeamHolder($gmFile);

?>

<style>
.dataTable > thead > tr > th[class*="sort"]:after{
    content: "" !important;
    background-color:var(--table-sort-desc);  
}
.dataTable > thead > tr > th[class*="sort"]:before{
    content: "" !important;
    background-color:var(--table-sort-desc);  
}

.dataTable th.sorting_desc{
  background-color:var(--table-sort-desc);  
}

.dataTable th.sorting_asc{
   background-color:var(--table-sort-asc);  
}

.dataTable th{
width:10px;
}


</style>

<div class="container" >
	
	<div class="card">
    		<?php include 'SectionHeader.php';?>
    		<div class="card-body p-2">
			<div class="container">
				<div class="row py-2">
					<div class="col">

						<!-- position -->
						<div class="row">
							<div class="input-group mb-3 col-sm-6">
								<div class="input-group-prepend">
									<label class="input-group-text" for="positionInputField">Position</label>
								</div>
								<select class="custom-select" id="positionInputField">
									<option value="">All Players</option>
									<option value="Skaters">All Skaters</option>
									<option value="Forwards">All Forwards</option>
									<option value="C">Center</option>
									<option value="RW">Right Wing</option>
									<option value="LW">Left Wing</option>
									<option value="D">Defense</option>
									<option value="G">Goalie</option>
								</select>
							</div>

							<!-- team -->
							<div class="input-group mb-3 col-sm-6">
								<div class="input-group-prepend">
									<label class="input-group-text" for="teamInputField">Team</label>
								</div>
								<select class="custom-select" id="teamInputField">
									<option value="">All Teams</option>
                      				<?php
                                        foreach ($teams->get_teams() as $team) {
                                            echo '<option value="' . $team . '">' . $team . '</option>';
                                        }
                                    ?>

                    		   </select>
							</div>
			
						</div>
						<div class="row">
										
							<!-- type -->
							<div class="input-group mb-3 col-sm-6">
								<div class="input-group-prepend">
									<label class="input-group-text" for="typeInputField">Type</label>
								</div>
								<select class="custom-select" id="typeInputField">
									<option value="">All Types</option>
									<option value="Pro">Pro</option>
									<option value="Farm">Farm</option>
									<option value="ProFarm" selected="selected">Pro/Farm</option>
									<option value="ProFarmProspect">Pro/Farm/Prosepct</option>
									<option value="Prospect">Prospect</option>
                     				<option value="Prospect">Unassigned</option>
                    		   </select>
							</div>
						</div>
						
						<div class="accordion" id="searchAccordion">
                          <div class="card">
                            <div class="card-header" id="advancedSearch">
                              <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                  Advanced Filter
                                </button>
                              </h5>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="advancedSearch" data-parent="#searchAccordion">
                              <div class="card-body">
                              	<div class="row">
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">IT</span>
        								</div>
        								<input id="itMin" type="text" class="form-control" value = 0> 
        								<input id="itMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">SP</span>
        								</div> 
        								<input id="spMin" type="text" class="form-control" value = 0> 
        								<input id="spMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">ST</span>
        								</div>
        								<input id="stMin" type="text" class="form-control" value = 0> 
        								<input id="stMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">EN</span>
        								</div> 
        								<input id="enMin" type="text" class="form-control" value = 0> 
        								<input id="enMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">DU</span>
        								</div>
        								<input id="duMin" type="text" class="form-control" value = 0> 
        								<input id="duMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">DI</span>
        								</div> 
        								<input id="diMin" type="text" class="form-control" value = 0> 
        								<input id="diMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">SK</span>
        								</div>
        								<input id="skMin" type="text" class="form-control" value = 0> 
        								<input id="skMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">PA</span>
        								</div> 
        								<input id="paMin" type="text" class="form-control" value = 0> 
        								<input id="paMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3" >
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">PC</span>
        								</div>
        								<input id="pcMin" type="text" class="form-control" value = 0> 
        								<input id="pcMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">DF</span>
        								</div> 
        								<input id="dfMin" type="text" class="form-control" value = 0> 
        								<input id="dfMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">SC</span>
        								</div>
        								<input id="scMin" type="text" class="form-control" value = 0> 
        								<input id="scMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">EN</span>
        								</div> 
        								<input id="enMin" type="text" class="form-control" value = 0> 
        								<input id="enMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						<div class="row pt-1">
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">LD</span>
        								</div>
        								<input id="ldMin" type="text" class="form-control" value = 0> 
        								<input id="ldMax" type="text" class="form-control" value = 99>
        							</div>
        							<div class="input-group col-6 col-lg-3">
        								<div class="input-group-prepend">
        									<span class="input-group-text" id="">OV</span>
        								</div> 
        								<input id="ovMin" type="text" class="form-control" value = 0> 
        								<input id="ovMax" type="text" class="form-control" value = 99>
        							</div>
        						</div>
        						
        						<button id="btnSearch" class="btn btn-sm btn-outline-primary my-2">Filter</button>
                              
                              
                              </div>
                            </div>
                          </div>
                        </div>    
                            
						

					</div>
				</div>

				<div class="row ">
					<div class="table-responsive">
						
						<table id="tblPlayerSearch" class="table table-sm table-striped display" style="width:100%">
                            <thead>
                                <tr>
                                	<th><?php echo $rostersName ?></th>
                               	    <th>Team</th>
                               	    <th>Type</th>
									<th>PO</th>
									<th><?php echo $rostersIT ?> </th>
									<th><?php echo $rostersSP ?> </th>
									<th><?php echo $rostersST ?> </th>
									<th><?php echo $rostersEN ?> </th>
									<th><?php echo $rostersDU ?> </th>
									<th><?php echo $rostersDI ?> </th>
									<th><?php echo $rostersSK ?> </th>
									<th><?php echo $rostersPA ?> </th>
									<th><?php echo $rostersPC ?> </th>
									<th><?php echo $rostersDF ?> </th>
									<th><?php echo $rostersOF ?> </th>
									<th><?php echo $rostersEX ?> </th>
									<th><?php echo $rostersLD ?> </th>
									<th><?php echo $rostersOV ?> </th>	 	
                                </tr>
                            </thead>
                         
                        </table>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>


	<script>
	https://www.canadianelitehockeyleague.ca/CareerStatsPlayer.php?csName=A.J.+Greer

        $(document).ready(function() {
        	var table = $('#tblPlayerSearch').DataTable( {
        		dom: 'lftBip',
        		scrollY:        true,
                scrollX:        true,
                scrollCollapse: true,
                order: [[ 17, "desc" ]],
                fixedColumns:   {
                    leftColumns: 1,
                    rightColumns: 1
                },
                "ajax": "<?php echo BASE_URL?>PlayerSearchAjax.php",
                "columns": [
                    //{ "data": "name" },
                    { "data": "name",
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a href='<?php echo BASE_URL?>CareerStatsPlayer.php?csName="+ encodeURIComponent(oData.name)+"'>"+oData.name+"</a>");
                        }
                    },
                	{ "data": "team" },
                	{ "data": "type" },
                    { "data": "position" },
                    { "data": "it" },
                    { "data": "sp" },
                    { "data": "st" },
                    { "data": "en" },
                    { "data": "du" },
                    { "data": "di" },
                    { "data": "sk" },
                    { "data": "pa" },
                    { "data": "pc" },
                    { "data": "df" },
                    { "data": "sc" },
                    { "data": "ex" },
                    { "data": "ld" },
                    { "data": "ov" }
                ],
                lengthMenu: [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
                language: {
                    "lengthMenu": "Display _MENU_ records"
                }, 
                buttons: [
                	'copyHtml5',
                    {
                        extend: 'excelHtml5',
                        title: 'FreeAgencyExport'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'FreeAgencyExport'
                    }
                ]
            } );

            $('#positionInputField, #teamInputField, #typeInputField').change( function() {
                table.draw();
            } );

            $( "#btnSearch" ).click(function() {
            	 table.draw();
            	});

            $("#collapseOne").on("hide.bs.collapse", function(){
            	 //table.draw();
              });

            

            
        } );

        $.fn.dataTable.ext.search.push(
        	    function( settings, data, dataIndex ) {
        	    	// Don't filter on anything other than "myTable"
        	        if ( settings.nTable.id !== 'tblPlayerSearch' ) {
        	            return true;
        	        }

        	        var display = false;

            	    //position filter
        	    	var posSelection = $('#positionInputField').val();
        	    	var pos = data[3]; 
        	    	
        	    	if(posSelection === ''){
        	    		display = true;
        	    	}else if(posSelection == 'Skaters'){
    
                    	if (pos.match('^(?=.*?(C|RW|LW|D)).*?')) {
                    		display = true;
                    	}
                    	
                    }
                    else if(posSelection == 'Forwards'){
                       	if (pos.match('^(?=.*?(C|RW|LW)).*?')) {
                       		display = true;
                    	}
                    }else{
                    	display = posSelection === pos;
                    }   

                    if(!display) return false;
                   

 					//team filter
 					var teamSelection = $('#teamInputField').val();
 					var team = data[1]; 
 					if(teamSelection === ''){
        	    		display = true;
        	    	}else if(teamSelection === team){
        	    		display = true;
                    }else{
                        return false; 
                    }

                    //type filter
                    var typeSelection = $('#typeInputField').val();
                    var type = data[2]; 
            		if(typeSelection === ''){
        	    		display = true;
        	    	}else if(typeSelection === type){
        	    		display = true;
                    }else if(typeSelection === 'ProFarm' && ('Pro' === type || 'Farm' === type)){
        	    		display = true;
                    }else if(typeSelection === 'ProFarmProspect' && ('Pro' === type || 'Farm' === type  || 'Prospect' === type)){
        	    		display = true;
                    }else{
                        return false; 
                    }
            		
                    //attribs
                    
                    if ( $( '#collapseOne' ).hasClass( "show" ) ) {
                    	if(!attribBetween('it', data[3])) return false;
                        if(!attribBetween('sp', data[4])) return false;
                        if(!attribBetween('st', data[5])) return false;
                        if(!attribBetween('en', data[6])) return false;
                        if(!attribBetween('du', data[7])) return false;
                        if(!attribBetween('di', data[8])) return false;
                        if(!attribBetween('sk', data[9])) return false;
                        if(!attribBetween('pa', data[10])) return false;
                        if(!attribBetween('pc', data[11])) return false;
                        if(!attribBetween('df', data[12])) return false;
                        if(!attribBetween('sc', data[13])) return false;
                        if(!attribBetween('en', data[14])) return false;
                        if(!attribBetween('ld', data[15])) return false;
                        if(!attribBetween('ov', data[16])) return false;
                    }
                    
                   

        	       return display;
        	    }
        	);

    	

    	function attribBetween(attrib, val){

			var min = $('#' + attrib + 'Min');
			var max =  $('#' + attrib + 'Max');

        	if(min.val() == 0 && max.val() == 99) return true;

        	
    		if (val >= min.val() && val <= max.val()) {
        		 return true;
    		}

    		return false;
    	}
        
	</script>

<?php include 'footer.php'; ?>