<style type="text/css">


a.info {
  position:relative;
  text-decoration: none; 
  color:<?php echo $tableauSubTitleColor; ?>;
}
a:hover.info {
  text-decoration: none;
  background: none;
  color:<?php echo $mouseHoverTableLine; ?>;
}
a.info span {display: none;}
a:hover.info span {
  display: inline;
  position: fixed; 
  bottom:15px;
  left:1px;
  z-index: 20;
  background: <?php echo $couleur_contour; ?>;
  color: <?php echo $tableauSubTitleColor; ?>;
  border:1px solid #000;
  text-align:center;
  font-size: 10px;
  line-height:12px;
  padding:2px 6px;
  width:100px;
}
.lien-blanc {
font-size:10pt;
color:<?php echo $tableauSubTitleColor; ?>;
text-decoration: none;
}
.lien-blanc:hover {
font-size:10pt;
color:<?php echo $mouseHoverTableLine; ?>;
text-decoration: none;
}
.lien-noir {
font-size:10pt;
color:#000000;
text-decoration: none;
}
.lien-noir:hover {
font-size:10pt;
color:#8B1F1C;
text-decoration: none;
}

.text-blanc {
/* line-height:12pt; */
/* font-size:10pt; */
/* font-family:arial,verdana,sans-serif; */
color:<?php echo $tableauSubTitleColor; ?>;
text-decoration: none;
}

.bold-blanc {
/* font-size:10pt; */
/* font-family:arial,verdana,sans-serif; */
font-weight: bold;
color:<?php echo $tableauSubTitleColor; ?>;
}
.tableau {
	border-collapse: collapse;
	width:100%;
}
.tableau-top {
	background-color:<?php echo $tableauSubTitleBackColor; ?>;
	color:<?php echo $tableauSubTitleColor; ?>;
}
.tableau-top td {
	font-weight: bold;
}

tr.hover1, div.ch>atHover1 {
	background-color:<?php echo $tableau_ligne1; ?>;
}
tr.hover2, div.chatHover2 {
	background-color:<?php echo $tableau_ligne2; ?>;
}


</style>
