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
	color:#<?php echo $databaseColors['colorMainText']; ?>;
	background-color:#<?php echo $databaseColors['colorMainBackground']; ?>;
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


/* Header for table */
#MyCEHL tr.tr td {
	background-color: #<?php echo $databaseColors['colorTableHeaderBackground']; ?>;
	border:1px solid #<?php echo $databaseColors['colorTableBorder']; ?>;
	color:#<?php echo $databaseColors['colorTableHeaderText']; ?>;
	font-weight:bold;
}

#MyCEHL table.table {
	border-collapse: collapse;
}
#MyCEHL table.table td {
	border:1px solid #<?php echo $databaseColors['colorTableBorder']; ?>;
	padding: 2px;
}

#MyCEHL table.table tr.tr_content1 {
	color:  #<?php echo $databaseColors['colorTableText1']; ?>;
	background-color: #<?php echo $databaseColors['colorTableBackground1']; ?>;
}
#MyCEHL table.table tr.tr_content2 {
	color:  #<?php echo $databaseColors['colorTableText2']; ?>;
	background-color: #<?php echo $databaseColors['colorTableBackground2']; ?>;
}
#MyCEHL table.table tr.tr_content1:hover, table.table tr.tr_content2:hover {
	color:  #<?php echo $databaseColors['colorTableTextHover']; ?>;
	background-color: #<?php echo $databaseColors['colorTableBackgroundHover']; ?>;
}

/* General Input Formatting */
#MyCEHL input.inputText, select {
	box-sizing: border-box;
	border: 2px solid #<?php echo $databaseColors['colorInputBorder']; ?>;
	color:  #<?php echo $databaseColors['colorInputText']; ?>;
	background-color: #<?php echo $databaseColors['colorInputBackground']; ?>;
	padding: 5px 0px;
	border-radius: 4px;
	transition-duration: 0.2s;
}

#MyCEHL input.inputText:hover, select:hover {
	border: 2px solid #<?php echo $databaseColors['colorInputBorderHover']; ?>;
}

#MyCEHL input.button {
	width: 100%;
	text-align: center;
	background-color: #<?php echo $databaseColors['colorButtonBackground']; ?>; 
	color: #<?php echo $databaseColors['colorButtonText']; ?>; 
	border: 2px solid #<?php echo $databaseColors['colorButtonBorder']; ?>;
	padding: 5px 0px;
	cursor: pointer;
	border-radius: 4px;
	transition-duration: 0.2s;
}
#MyCEHL input.button:hover {
	border: 2px solid #<?php echo $databaseColors['colorButtonBorderHover']; ?>;
	box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}

.labelContainer {
	display: block;
	position: relative;
	padding-left: 35px;
	margin-bottom: 12px;
	cursor: pointer;
	font-size: 16px;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.labelContainer input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.customRadio {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #eee;
    border-radius: 50%;
}

.labelContainer:hover input ~ .customRadio {
    background-color: #<?php echo $databaseColors['colorInputBorderHover']; ?>;
}

.labelContainer input:checked ~ .customRadio {
    background-color: #<?php echo $databaseColors['colorInputBorder']; ?>;
}

.customRadio:after {
    content: "";
    position: absolute;
    display: none;
}

.labelContainer input:checked ~ .customRadio:after {
    display: block;
}

.labelContainer .customRadio:after {
 	top: 6px;
	left: 6px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: #<?php echo $databaseColors['colorInputBackground']; ?>;
}


/* LEAGUE SETTINGS PAGE */
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
	color:#<?php echo $databaseColors['colorTableTextHover']; ?>;
}

/* GM EDITOR TEAM LINES */
input.lines {
	cursor: pointer;
	width: 115px;
	border: 0px;
	/*background-color: #f9f9f9;*/
	font-size:11px;
	line-height: 17px;
	padding:1px 0px;
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
  line-height:24px;
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
/* 		display:table */
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
	}
}

/* GM EDITOR MOBILE VIEW - Team Lines */
@media screen and (min-width: 501px) {
	div#tlDivLinesEV, div#tlDivLinesPP, div#tlDivLinesPK {
		max-width: 290px;
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