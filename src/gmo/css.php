<style type="text/css">
 /*body { 
 	margin:0px;  
 	padding: 0px; 
	font-size:12px;
	font-weight:normal;
 	font-family:Arial,"trebuchet ms",sans-serif; 
	color:#<?php //echo $databaseColors['colorMainText']; ?>;
	background-color:#<?php //echo $databaseColors['colorMainBackground']; ?>;
 	text-decoration: none; 
}*/

#MyCEHL{
	font-size:12px;
	font-weight:normal;
	/*color:#<?php //echo $databaseColors['colorMainText']; ?>;
	background-color:#<?php //echo $databaseColors['colorMainBackground']; ?>;*/
	text-decoration: none;
}

table.statsPadding td {
	padding-left:2px;
	padding-right:2px;
}

.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
	color: #<?php echo $databaseColors['colorTooltipText']; ?>;
	background-color: #<?php echo $databaseColors['colorTooltipBackground']; ?>;
	border: 2px solid #<?php echo $databaseColors['colorTooltipBorder']; ?>;
    text-align: center;
    border-radius: 4px;
    padding: 5px 0;
	opacity: 0;
	transition: opacity 0.5s;
    
    /* Position the tooltip */
    position: absolute;
    z-index: 1;
    top: 100%;
    left: 0px;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
	opacity: 1;
}

#MyCEHL div.selected, input.selected {
	background-color:#<?php echo $databaseColors['colorDivBackgroundActive']; ?>;
	color:#<?php echo $databaseColors['colorDivTextActive']; ?>;
}



/* GM EDITOR TEAM LINES */
input.lines {
	cursor: pointer;
/* 	width: 115px; */
 	border: 0px; 
	/*background-color: #f9f9f9;*/
	width: 100%;
	font-size:11px;
/* 	line-height: 17px; */
    line-height: 20px;
/* 	padding:1px 0px; */
}

.linesPos {
	cursor: pointer;
	width: 100%;
	display: inline-block;
}
input.lines:hover {
	background-color: #dddddd;
	color:#000000;
}

.linesPos {
	font-size:11px;
	line-height: 17px;
}



/* GM EDITOR MOBILE VIEW - Team Roster */
.selectedPlayers{
  cursor: pointer;
/*   line-height:24px; */
    line-height:2;
}

#trDivTableStats{
    	background-color: #f0f0f0;
		box-shadow: 5px 0px 5px #f0f0f0;
}


@media screen and (min-width: 510px) {
	.trButton1 {
		display:inline-block;
    }
	.trButton2 {
		display:none;
    }
	.trDivSelect {
		clear:none;
		width:auto;
		width:154px;
	}
	#trImgProtect {
		display:inline;
		margin-top:0px;
	}
	#trImgTeamLines {
		display:inline;
	}
	#trImgLoadLines {
		margin-bottom:0px;
	}
	#trTableStats {
		float:right;
		clear:none;
	}
	#trHrStats {
		margin-bottom:10px;
	}
	#trTableStats2 {
		 display:table;
	}
	#trTableStats3 {
		display:none;
	}
	
	.selectedPlayers{
	   height:200px;
	}
}
@media screen and (max-width: 509px) {
	.trButton1 {
		display:none;
    }
	.trButton2 {
		display:inline;
    }
	.trDivSelect {
		clear:left;
		width:60%;
	}
	#trImgProtect {
		display:block;
		margin-top:5px;
	}
	#trImgTeamLines {
		display:block;
	}
	#trImgLoadLines {
		margin-bottom:5px;
	}
	#trTableStats {
		float:left;
		clear:left;
	}
	div#trDivTableStats {
/* 		position:fixed; */
	
/* 		top:50px; */
/* 		bottom:0px; */

		background-color: #f0f0f0;
		width:100%;
		box-shadow: 5px 0px 5px #f0f0f0;
 		display:table 
	}
	#trHrStats {
/* 		margin-bottom:96px; */
margin-bottom:0px;
	}
	#trTableStats2 {
		 font-size:10px;
		 display:none;
	}
	#trTableStats3 {
		float:left;
		display:block;
	}
	
	.selectedPlayers{
	   height:120px;
	   line-height:22px;
	}
	
}

/* GM EDITOR MOBILE VIEW - Team Lines */

#tlDivTableStats{
  	background-color: #f0f0f0;
	box-shadow: 5px 0px 5px #f0f0f0;
}

@media screen and (min-width: 501px) {
	div#tlDivLinesEV, div#tlDivLinesPP, div#tlDivLinesPK {
		max-width: 320px;
	}
	table#tlTableStatsRight {
		float: right;
	}
}

@media screen and (max-width: 500px) {
	div#tlDivLinesEV, div#tlDivLinesPP, div#tlDivLinesPK {
		max-width: 200px;
	}
}

@media screen and (max-width: 342px) {
	div#tlDivLinesEV, div#tlDivLinesPP, div#tlDivLinesPK {
		max-width: 145px;
	}
}
@media (min-height: 480px) and (min-width: 465px), (min-height: 661px) and (min-width: 465px) {
	div#tlDivTableStats {
		margin-bottom: 5px;
	}
}
@media (max-height: 479px) and (min-width: 465px), (max-height: 660px) and (min-width: 320px) and (max-width: 464px) {
	div#tlDivTableStats {
		clear:both; position: fixed; bottom:0px; background-color: #f0f0f0; max-width:530px; box-shadow: 5px 0px 5px #f0f0f0;
	}
	div#tlDivBottomSpacer {
		margin-bottom: 95px;
	}
}
@media (max-height: 479px) and (min-width: 465px) {
	div#tlDivBottomSpacer {
		margin-bottom: 60px;
	}
}
@media (max-height: 660px) and (min-width: 320px) and (max-width: 464px) {
	div#tlDivBottomSpacer {
		margin-bottom: 95px;
	}
}


</style>