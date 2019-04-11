<?php
require_once 'config.php';
include 'lang.php';
$CurrentHTML = '';
$CurrentTitle = $teamCardTitle;
$CurrentPage = 'TeamOverview';
include 'head.php';
include 'TeamHeader.php';
?>

<?php
// Format Ordinal
function ordinalEnglish($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}
function ordinalFrench($number) {
    if($number == 1) return $number. 'er';
	else return $number. 'e';
}

// Obtenir l'abbréviation de l'équipe
include 'phpGetAbbr.php'; // Output $TSabbr / $folderLeagueURL2

$matches = glob($folder.'*'.$playoff.'GMs.html');
$folderLeagueURL = '';
$matchesDate = array_map('filemtime', $matches);
arsort($matchesDate);
foreach ($matchesDate as $j => $val) {
	$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'GMs')-strrpos($matches[$j], '/')-1);
	break 1;
}

// Nom du club-école
$Fnm = $folder.$folderLeagueURL2.'FarmStandings.html';
$farmName = '';
$b = 0;
$d = 0;
$standingFarmFileFound = 1000;
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '<PRE>')) {
			$b = 0;
			if($standingFarmFileFound == 1000) $d = 1;
			else $d = 0;
		}
		if($d == 1 && substr_count($val, ') ')) {
			$reste = trim($val);
			$standingFarmFileEquipe[$b] = substr($reste, 0, strpos($reste, '('));
			$reste = trim(substr($reste, strpos($reste, ')')+1));
			$standingFarmFilePJ[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFarmFileW[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFarmFileL[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFarmFileT[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFarmFilePts[$b] = substr($reste, 0, strpos($reste, ' '));
			if(isset($TSabbr) && substr_count($val, '('.$TSabbr)) {
				$farmName = substr($val, 0, strpos($val, '('));
				$standingFarmFileFound = $b;
			}
			$b++;
		}
	}
}

// Nom du DG
$Fnm = $folder.$folderLeagueURL.'GMs.html';
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'HREF') && !substr_count($val, '<BR>') && substr_count($val, $currentTeam.' ')) {
			$gm = substr($val, 16, 26);
			if(substr_count($gm, 'LHSX')) $libre = 1;
			else $libre = 0;
			break 1;
		}
	}
}

// Classement en saison / Conférence / Division
$Fnm = $folder.$folderLeagueURL2.'Standings.html';
$b = 0;
$d = 0;
$standingFileOLDetect = 0;
$f = 0;
$standingFileFound = 1000;
$standingFileDivisionFound = 1000;
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'STK') && (substr_count($val, 'OL') || substr_count($val, 'OTL'))) {
			$standingFileOLDetect = 1;
		}
		if(substr_count($val, 'Division</H3>')) {
			$b = 0;
			$d = 0;
			if($standingFileDivisionFound == 1000) {
				$f = 1;
				if(isset($standingFileDivisionSerie)) unset($standingFileDivisionSerie);
			}
			else $f = 0;
		}
		if(substr_count($val, 'Conference</H3>')) {
			if($standingFileFound == 1000) {
				$d = 1;
				$b = 0;
				unset($standingFileSerie);
			}
			else {
				$d = 0;
			}
			
		}
		if($d == 1 && substr_count($val, 'HREF=')) {
			$reste = trim($val);
			if(substr_count($reste, 'WIDTH')) {
				$reste = substr($reste, strpos($reste, '<A '));
			}
			$standingFileSerie[$b] = substr($reste, 0, strpos($reste, '<'));
			$reste = trim(substr($reste, strpos($reste, '>')+1));
			$standingFileEquipe[$b] = substr($reste, 0, strpos($reste, '</A>'));
			$reste = trim(substr($reste, strpos($reste, '</A>')+4));
			$standingFilePJ[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFileW[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFileL[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFileT[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFileOL[$b] = '';
			if($standingFileOLDetect == 1) {
				$standingFileOL[$b] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
			}
			$standingFilePts[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			if($standingFileEquipe[$b] == $currentTeam) $standingFileFound = $b;
			if($standingFileSerie[$b] != ''){
				if($standingFileSerie[$b] == 'z') $standingFileSerie[$b] = '<a href="Standings.php" class="info" style="color:#000000">'.$standingZ.'<span>'.$standingZFull.'</span></a>';
				if($standingFileSerie[$b] == 'y') $standingFileSerie[$b] = '<a href="Standings.php" class="info" style="color:#000000">'.$standingY.'<span>'.$standingYFull.'</span></a>';
				if($standingFileSerie[$b] == 'x') $standingFileSerie[$b] = '<a href="Standings.php" class="info" style="color:#000000">'.$standingX.'<span>'.$standingXFull.'</span></a>';
			}
			$b++;
		}
		if($f == 1 && substr_count($val, 'HREF=')) {
			$reste = trim($val);
			if(substr_count($reste, 'WIDTH')) {
				$reste = substr($reste, strpos($reste, '<A '));
			}
			$standingFileDivisionSerie[$b] = substr($reste, 0, strpos($reste, '<'));
			$reste = trim(substr($reste, strpos($reste, '>')+1));
			$standingFileDivisionEquipe[$b] = substr($reste, 0, strpos($reste, '</A>'));
			$reste = trim(substr($reste, strpos($reste, '</A>')+4));
			$standingFileDivisionPJ[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFileDivisionW[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFileDivisionL[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFileDivisionT[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			$standingFileDivisionOL[$b] = '';
			if($standingFileOLDetect == 1) {
				$standingFileDivisionOL[$b] = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
			}
			$standingFileDivisionPts[$b] = substr($reste, 0, strpos($reste, ' '));
			$reste = trim(substr($reste, strpos($reste, ' ')));
			if($standingFileDivisionEquipe[$b] == $currentTeam) $standingFileDivisionFound = $b;
			if($standingFileDivisionSerie[$b] != ''){
				if($standingFileDivisionSerie[$b] == 'z') $standingFileDivisionSerie[$b] = '<a href="Standings.php" class="info" style="color:#000000">'.$standingZ.'<span>'.$standingZFull.'</span></a>';
				if($standingFileDivisionSerie[$b] == 'y') $standingFileDivisionSerie[$b] = '<a href="Standings.php" class="info" style="color:#000000">'.$standingY.'<span>'.$standingYFull.'</span></a>';
				if($standingFileDivisionSerie[$b] == 'x') $standingFileDivisionSerie[$b] = '<a href="Standings.php" class="info" style="color:#000000">'.$standingX.'<span>'.$standingXFull.'</span></a>';
			}
			$b++;
		}
		
	}
}
else echo $allFileNotFound.' - '.$Fnm.'<br>';

//$standingFileEquipe
//$standingFileDivisionEquipe

// Last Game - Next Game + Team Record
$round = 0;
$nextGameFile = 0;
$linkRnd = '';
$recordConferenceGP = 0;
$recordConferenceWin = 0;
$recordConferenceLos = 0;
$recordConferenceTie = 0;
$recordConferencePts = 0;
$recordDivisionGP = 0;
$recordDivisionWin = 0;
$recordDivisionLos = 0;
$recordDivisionTie = 0;
$recordDivisionPts = 0;
$recordHomeGP = 0;
$recordHomeWin = 0;
$recordHomeLos = 0;
$recordHomeTie = 0;
$recordHomePts = 0;
$recordAwayGP = 0;
$recordAwayWin = 0;
$recordAwayLos = 0;
$recordAwayTie = 0;
$recordAwayPts = 0;

if (file_exists($folder.$folderLeagueURL2.'PLF-Round1-Schedule.html')) {
	$round = 1;
}
if (file_exists($folder.$folderLeagueURL2.'PLF-Round2-Schedule.html')) {
	$round = 2;
}
if (file_exists($folder.$folderLeagueURL2.'PLF-Round3-Schedule.html')) {
	$round = 3;
}
if (file_exists($folder.$folderLeagueURL2.'PLF-Round4-Schedule.html')) {
	$round = 4;
}

$Fnm = $folder.$folderLeagueURL2.'Schedule.html';
for($j=0;$j<=$round;$j++) {
	if($j != 0) {
		$Fnm = $folder.$folderLeagueURL2.'PLF-Round'.$j.'-Schedule.html';
	}
	if(file_exists($Fnm)) {
		// DÉTECTER LA DERNIÈRE PARTIE ET LA PROCHAINE
		$tableau = file($Fnm);
		while(list($cle,$val) = myEach($tableau)) {
			if(substr_count($val, $currentTeam) && substr_count($val, ' at ') && !substr_count($val, '<strike>')){
				$reste = trim(str_replace('<br>','', $val));
				$reste = trim(str_replace('<BR>','', $reste));
				$nextNumber = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$nextEquipe1 = substr($reste, 0, strpos($reste, ' at'));
				$reste = trim(substr($reste, strpos($reste, 'at')+2));
				$nextEquipe2 = $reste;
				if($j == 0) $nextGameFile = 'Schedule2.php';
				if($j == 1) $nextGameFile = 'Schedule2.php&plf=1&rnd=1';
				if($j == 2) $nextGameFile = 'Schedule2.php&plf=1&rnd=2';
				if($j == 3) $nextGameFile = 'Schedule2.php&plf=1&rnd=3';
				if($j == 4) $nextGameFile = 'Schedule2.php&plf=1&rnd=4';
				break 2;
			}
			if(substr_count($val, $currentTeam) && substr_count($val, 'A HREF=')){
				$reste = trim(substr($val, strpos($val, '> ')+1));
				$lastNumber = substr($reste, 0, strpos($reste, ' '));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$count = strlen($reste);
				$z = 0;
				while( $z < $count ) {
					if( ctype_digit($reste[$z]) ) {
						$pos3 = $z;
						break 1;
					}
					$z++;
				}
				$lastEquipe1 = substr($reste, 0, $pos3-1);
				$reste = trim(substr($reste, $pos3));
				$lastScore1 = trim(substr($reste, 0, strpos($reste, ' ')));
				$reste = trim(substr($reste, strpos($reste, ' ')));
				$z = 0;
				while( $z < $count ) {
					if( ctype_digit($reste[$z]) ) {
						$pos3 = $z;
						break 1;
					}
					$z++;
				}
				$lastEquipe2 = substr($reste, 0, $pos3-1);
				$reste = trim(substr($reste, $pos3));
				$lastScore2 = trim($reste);
				if($j != 0) $linkRnd = '&rnd='.$j;
				if($j == 0) {
					$tmpCle = $cle + 2;
					$tempOT = $tableau[$tmpCle];
					
					// Away
					if($lastEquipe1 == $currentTeam) {
						$tmpRecordConference = 0;
						for($y=0;$y<count($standingFileEquipe);$y++) {
							if($standingFileEquipe[$y] == $lastEquipe2) {
								$tmpRecordConference = 1;
								break 1;
							}
						}
						$tmpRecordDivision = 0;
						for($y=0;$y<count($standingFileDivisionEquipe);$y++) {
							if($standingFileDivisionEquipe[$y] == $lastEquipe2) {
								$tmpRecordDivision = 1;
								break 1;
							}
						}
						if($lastScore1 < $lastScore2 && (!substr_count($tempOT, '(OT)') || $leagueOvertimePoint == 0)) {
							$recordAwayLos++; // Perdu
							if($tmpRecordConference == 1) $recordConferenceLos++;
							if($tmpRecordDivision == 1) $recordDivisionLos++;
						}
						if($lastScore1 == $lastScore2 || (substr_count($tempOT, '(OT)') && $lastScore1 < $lastScore2 && $leagueOvertimePoint == 1)) {
							$recordAwayTie++; // Nulle
							if($tmpRecordConference == 1) $recordConferenceTie++;
							if($tmpRecordDivision == 1) $recordDivisionTie++;
						}
						if($lastScore1 > $lastScore2) {
							$recordAwayWin++; // Win
							if($tmpRecordConference == 1) $recordConferenceWin++;
							if($tmpRecordDivision == 1) $recordDivisionWin++;
						}
					}
					// Home
					if($lastEquipe2 == $currentTeam) {
						$tmpRecordConference = 0;
						for($y=0;$y<count($standingFileEquipe);$y++) {
							if($standingFileEquipe[$y] == $lastEquipe1) {
								$tmpRecordConference = 1;
								break 1;
							}
						}
						$tmpRecordDivision = 0;
						for($y=0;$y<count($standingFileDivisionEquipe);$y++) {
							if($standingFileDivisionEquipe[$y] == $lastEquipe1) {
								$tmpRecordDivision = 1;
								break 1;
							}
						}
						if($lastScore2 < $lastScore1 && (!substr_count($tempOT, '(OT)') || $leagueOvertimePoint == 0)) {
							$recordHomeLos++; // Perdu
							if($tmpRecordConference == 1) $recordConferenceLos++;
							if($tmpRecordDivision == 1) $recordDivisionLos++;
						}
						if($lastScore2 == $lastScore1 || (substr_count($tempOT, '(OT)') && $lastScore2 < $lastScore1 && $leagueOvertimePoint == 1)) {
							$recordHomeTie++; // Nulle
							if($tmpRecordConference == 1) $recordConferenceTie++;
							if($tmpRecordDivision == 1) $recordDivisionTie++;
						}
						if($lastScore2 > $lastScore1) {
							$recordHomeWin++; // Win
							if($tmpRecordConference == 1) $recordConferenceWin++;
							if($tmpRecordDivision == 1) $recordDivisionWin++;
						}
					}
				}
			}
		}
	}
	else echo $allFileNotFound.' - '.$Fnm.'<br>';
}
$recordHomeGP = $recordHomeWin + $recordHomeLos + $recordHomeTie;
$recordHomePts = ($recordHomeWin * 2) + $recordHomeTie;
$recordAwayGP = $recordAwayWin + $recordAwayLos + $recordAwayTie;
$recordAwayPts = ($recordAwayWin * 2) + $recordAwayTie;
$recordDivisionGP = $recordDivisionWin + $recordDivisionLos + $recordDivisionTie;
$recordDivisionPts = ($recordDivisionWin * 2) + $recordDivisionTie;
$recordConferenceGP = $recordConferenceWin + $recordConferenceLos + $recordConferenceTie;
$recordConferencePts = ($recordConferenceWin * 2) + $recordConferenceTie;



// Entraineur
$Fnm = $folder.$folderLeagueURL.'Coaches.html';
$a = 0;
$entraineur = '';
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if($a == 1 && substr_count($val, '('.$currentTeam)) {
			$pos = strpos($val, '(');
			$pos++;
			$pos3 = $pos - 2;
			$entraineur = substr($val, 0, $pos3);
			break 1;
		}
		if(substr_count($val, '                                   ')) {
			$a = 1;
		}
	}
}

// Arena, billets, place, masse salariale
$Fnm = $folder.$folderLeagueURL.'Finance.html';
$b = 0;
$d = 1;
$arena = '';
$sieges = 0;
$billets = 0;
$propayroll = 0;
$farmpayroll = 0;
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'A NAME=') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
			$b = 1;
		}
		if(substr_count($val, 'Arena') && $b && $d) {
			$arena = substr($val, 52, 30);
		}
		if(substr_count($val, 'Capacity') && $b && $d) {
			$pos = strpos($val, '</TD>', strpos($val, '</TD>')+5);
			$sieges = substr($val, 25, $pos-25);
		}
		if(substr_count($val, 'Ticket Price') && $b && $d) {
			$billets = substr($val, 30, 5);
		}
		if(substr_count($val, '<TD>Pro Payroll</TD>') && $b && $d) {
			$pos = strpos($val, '</TD></TR>');
			$pos = $pos - 69;
			$propayroll = substr($val, 69, $pos);
		}
		if(substr_count($val, '<TD>Farm Payroll</TD>') && $b && $d) {
			$pos = strpos($val, '</TD></TR>');
			$pos = $pos - 30;
			$farmpayroll = substr($val, 30, $pos);
			break 1;
		}
	}
}

// PROSPECT
$Fnm = $folder.$folderLeagueURL.'Futures.html';
$a = 0;
$b = 0;
$d = 1;
$npropect = 0;
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'A NAME=') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
			$b = 1;
		}
		if($a == 1 && $b && $d) {
			$pos = strpos($val, '<');
			$prospect = substr($val, 0, $pos);
			break 1;
		}
		if(substr_count($val, '<H4>Prospects</H4>') && $b && $d) {
			$a = 1;
		}
		
	}
	if(isset($prospect)) $npropect = substr_count($prospect, ',') + 1;
}

// Nombre de joueurs + Average
$Fnm = $folder.$folderLeagueURL.'PlayerVitals.html';
$a = 0;
$b = 0;
$d = 1;
$njoueurs = 0;
$vitalsAge = 0;
$vitalsGrandeur = 0;
$vitalsPoids = 0;
$vitalsSalaire = 0;
if (file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, 'A NAME=') && $b) {
			$d = 0;
		}
		if(substr_count($val, 'A NAME='.$currentTeam)) {
			$b++;
		}
		if($a == 3 && $b && $d) {
			$reste = trim(substr($val, strpos($val, '  '), strpos($val, '</PRE>')-strpos($val, '  ')));
			$vitalsAge = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$vitalsGrandeur = substr($reste, 0, strpos($reste, '  '));
			$vitalsGrandeur = str_replace('ft', '\'', $vitalsGrandeur);
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$vitalsPoids = substr($reste, 0, strpos($reste, '  '));
			$reste = trim(substr($reste, strpos($reste, '  ')));
			$vitalsSalaire = substr($reste, 0);
			$a++;
		}
		if(substr_count($val, '------------------') && $b && $d) {
			$a++;
		}
		if($a == 2 && $b && $d) {
			$njoueurs++;
		}
		if($a == 1 && $b && $d) {
			$a++;
		}
		if(substr_count($val, '<PRE>') && $b && $d) {
			$a = 1;
		}
	}
}

$d = 1;
$times = 0;
while($d == 1) {
	if($times == 0) $Fnm = $folder.$folderLeagueURL.'TeamScoring.html';
	if($times == 1) $Fnm = $folder.$folderLeagueURL2.'TeamScoring.html';
	$a = 0;
	$b = 0;
	$e = 0;
	$f = 0;
	$i = 0;
	if(file_exists($Fnm)) {
		$tableau = file($Fnm);
		while(list($cle,$val) = myEach($tableau)) {
			$val = utf8_encode($val);
			if(substr_count($val, '</PRE><BR>') && $b) {
				$d = 0;
			}
			if(substr_count($val, 'A NAME='.$currentTeam) && $d) {
				$b = 1;
			}
			if($b && $d && substr_count($val, '------------')) {
				$e = 0;
			}
			if($b && $d && $e) {
				$reste = trim($val);
				if(substr_count($val, '                         ')) {
					$i--;
				}
				else {
					$statsPosition[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					$statsNumber[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					if(substr($reste, 0, 1) == '*') {
						$statsRookie[$i] = substr($reste, 0, 1);
						$reste = trim(substr($reste, 1));
					}
					else $statsRookie[$i] = '';
					//$reste = trim(substr($reste, strpos($reste, '  ')));
				}
				$statsPS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPCTG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsHT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGW[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsSHG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPPG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsPIM[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsDiff[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsP[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsA[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGP[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
				if(!substr_count($val, '                         ')) {
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$statsName[$i] = $reste;
					
					if(substr_count($statsName[$i], 'xtrastats.html')) {
						$statsName[$i] = trim(substr($statsName[$i], strpos($statsName[$i], '"')+1, strpos($statsName[$i], '>')-1-strpos($statsName[$i], '"')-1));
					}
				}
				$i++;
			}
			if($b && $d && substr_count($val, '------------')) {
				$f = 0;
			}
			if($b && $d && $f) {
				$reste = trim($val);
				if(substr_count($val, '                         ')) {
					$i--;
				}
				else {
					$statsGPosition[$i] = 'G';
					$statsGNumber[$i] = substr($reste, 0, strpos($reste, ' '));
					$reste = trim(substr($reste, strpos($reste, ' ')));
					if(substr($reste, 0, 1) == '*') {
						$statsGRookie[$i] = substr($reste, 0, 1);
						$reste = trim(substr($reste, 1));
					}
					else $statsGRookie[$i] = '';
				}
				$statsGAS[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGPIM[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGPCT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGSA[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGGA[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGSO[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGT[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGL[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGW[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGAVG[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGMin[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGGP[$i] = substr($reste, strrpos($reste, ' '));
				$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
				$statsGTeam[$i] = trim(substr($reste, strrpos($reste, ' ')));
				if(!substr_count($val, '                         ')) {
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$statsGName[$i] = $reste;
					if(substr_count($statsGName[$i], 'xtrastats.html')) {
						$statsGName[$i] = trim(substr($statsGName[$i], strpos($statsGName[$i], '"')+1, strpos($statsGName[$i], '>')-1-strpos($statsGName[$i], '"')-1));
					}
				}
				$i++;
			}
			if($b && $d && substr_count($val, 'PCTG') ) {
				$e = 1;
				$i = 0;
			}
			if($b && $d && substr_count($val, 'AVG') ) {
				$f = 1;
				$i = 0;
			}
		}
	}
	if($times == 1 && $d == 1) $d = 0;
		$times++;
}

// Team Stats PP% PK% GF/G GA/G
$Fnm = $folder.$folderLeagueURL2.'TeamStats.html';
$a = 0;
$c = 1;
$i = 0;
if(file_exists($Fnm)) {
	$tableau = file($Fnm);
	while(list($cle,$val) = myEach($tableau)) {
		$val = utf8_encode($val);
		if(substr_count($val, '</PRE>')){
			$a++;
		}
		if($a == 1 && !isset($teamStatsFilePP)){
			$i++;
			$tmpTeam = trim(substr($val, 0, 10));
			$tmpPP = substr($val, 18, 5);
			if($tmpTeam == $currentTeam) {
				$teamStatsFilePP = $tmpPP;
				if($leagueLang == "EN") $teamStatsFilePPPos = ordinalEnglish($i);
				if($leagueLang == "FR") $teamStatsFilePPPos = ordinalFrench($i);
			}
		}
		if($a == 3 && !isset($teamStatsFilePK)){
			$i++;
			$tmpTeam = trim(substr($val, 0, 10));
			$tmpPK = substr($val, 24, 5);
			if($tmpTeam == $currentTeam) {
				$teamStatsFilePK = $tmpPK;
				if($leagueLang == "EN") $teamStatsFilePKPos = ordinalEnglish($i);
				if($leagueLang == "FR") $teamStatsFilePKPos = ordinalFrench($i);
			}
		}
		if($a == 7 && !isset($teamStatsFileGFG)){
			$i++;
			$tmpTeam = trim(substr($val, 0, 10));
			$tmpGFG = substr($val, 39, 5);
			if($tmpTeam == $currentTeam) {
				$teamStatsFileGFG = $tmpGFG;
				if($leagueLang == "EN") $teamStatsFileGFGPos = ordinalEnglish($i);
				if($leagueLang == "FR") $teamStatsFileGFGPos = ordinalFrench($i);
			}
		}
		if($a == 9 && !isset($teamStatsFileGAG)){
			$i++;
			$tmpTeam = trim(substr($val, 0, 10));
			$tmpGAG = substr($val, 45, 5);
			if($tmpTeam == $currentTeam) {
				$teamStatsFileGAG = $tmpGAG;
				if($leagueLang == "EN") $teamStatsFileGAGPos = ordinalEnglish($i);
				if($leagueLang == "FR") $teamStatsFileGAGPos = ordinalFrench($i);
			}
		}
		if(substr_count($val, '<PRE>')){
			$a++;
			$i = 0;
		}
	}
}
//echo '<h3 class = "text-center wow fadeIn">'.$CurrentTitle.'</h3>';
//echo '<div style="clear:both; width:555px; margin-left:auto; margin-right:auto; border:solid 1px '.$couleur_contour.';">';




echo '<div class = "container">';

echo '<div class="card">';

//echo '<div class="card-header wow fadeIn"><h3>'.$CurrentTitle.'</h3></div>';

echo'<div class="card-header p-1">';

    include 'TeamCardHeader.php';
        
echo' </div>';

echo '<div class="card-body wow fadeIn">';

echo '<div class = "row wow fadeIn">';
	echo '<div class = "col-sm-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">';
    	echo '<div class = "table-responsive">';
    		echo '<table class="table table-sm table-striped">';
    		echo '<thead>';
    		echo '<tr class="tableau-top"><th colspan="4"><h5 class="m-0">Team Info</h5></th></tr>';
    		echo '</thead>';
    		echo '<tbody>';
    		echo '<tr><td style="width:90px; font-weight:bold;">'.$teamCardGM.'</td><td style="width:175px;">'.$gm.'</td><td style="width:90px; font-weight:bold;">'.$teamCardArena.'</td><td>'.$arena.'</td></tr>';
    		echo '<tr><td style="font-weight:bold;">'.$teamCardCoach.'</td><td>'.$entraineur.'</td><td style="font-weight:bold;">'.$teamCardSeats.'</td><td>'.$sieges.'</td></tr>';
    		echo '<tr><td style="font-weight:bold;">'.$teamCardFarm.'</td><td>'.ucwords(strtolower($farmName)).'</td><td style="font-weight:bold;">'.$teamCardTicket.'</td><td>'.$billets.'</td></tr>';
    		echo '</tbody>';
    		echo '</table>';
    	echo '</div>';
	echo '</div>';
echo '</div>';


echo '<div class="row wow fadeIn">';

echo '<div class="col-sm-12 col-md-5 offset-md-1">';

//echo '<table class="table table-sm">';
if(isset($lastNumber)) {
	echo '<a href="games.php?num='.$lastNumber.$linkRnd.'">';
	echo '<table class="table table-sm table-striped">';
	echo '<thead>';
	echo '<tr class="tableau-top"><th colspan="2"><h5 class="m-0">'.$teamCardLastGame.' #'.$lastNumber.'</h5></th></tr>';
	echo '</thead>';
	echo '<tbody>';
	echo '<tr class="hover2"><td>'.$lastEquipe1.'</td><td style="text-align:right;">'.$lastScore1.'</td></tr>';
	echo '<tr class="hover1"><td>'.$lastEquipe2.'</td><td style="text-align:right;">'.$lastScore2.'</td></tr>';
	echo '</tbody>';
	echo '</table></a>';
}

if(isset($nextNumber)) {
	echo '<a href="'.$nextGameFile.'">';
	echo '<table class="table table-sm table-striped">';
	echo '<thead>';
	echo '<tr class="tableau-top"><th><h5 class="m-0">'.$teamCardNextGame.' #'.$nextNumber.'</h5></th></tr>';
	echo '</thead>';
	echo '<tbody>';
	echo '<tr class="hover2"><td>'.$nextEquipe1.'</td></tr>';
	echo '<tr class="hover1"><td>'.$nextEquipe2.'</td></tr>';
	echo '</tbody>';
	echo '</table></a>';
}

if(isset($propayroll)) {
	echo '<a href="Finance.php'.$plfLink.'">';
    echo '<table class="table table-sm table-striped">';
    echo '<thead>';
	echo '<tr class="tableau-top"><th colspan="2"><h5 class="m-0">'.$teamCardFinancial.'</h5></th></tr>';
	echo '</thead>';
	echo '<tbody>';
	echo '<tr class="hover2"><td>'.$teamCardProPayroll.'</td><td style="text-align:right;">'.$propayroll.'</td></tr>';
	echo '<tr class="hover1"><td>'.$teamCardFarmPayroll.'</td><td style="text-align:right;">'.$farmpayroll.'</td></tr>';
	$propayroll2 = preg_replace('/\D/', '', $propayroll);
	$farmpayroll2 = preg_replace('/\D/', '', $farmpayroll);
	if($leagueSalaryIncFarm == 0) {
		$restant = $leagueSalaryCap - $propayroll2;
	}
	if($leagueSalaryIncFarm == 1) {
		$restant = $leagueSalaryCap - $propayroll2 - $farmpayroll2;
	}
	$restant = number_format($restant, 0, ' ', ',');
	echo '<tr class="hover2"><td>'.$teamCardPayrollRemaining.'</td><td style="text-align:right;">'.$restant.'</td></tr>';
	echo '</tbody>';
	echo '</table></a>';
}

echo '<div>';
echo '<table class="table table-sm table-striped">';
echo '<thead>';
echo '<tr class="tableau-top"><th colspan="2"><h5 class="m-0">'.$teamCardPlayerInfos.'</h5></th></tr>';
echo '</thead>';
echo '<tbody>';
echo '<tr class="hover2"><td>'.$teamCardPlayers.'</td><td style="text-align:right;">'.$njoueurs.'</td></tr>';
echo '<tr class="hover1"><td>'.$teamCardProspects.'</td><td style="text-align:right;">'.$npropect.'</td></tr>';
echo '<tr class="hover2"><td>'.$teamCardAvgAge.'</td><td style="text-align:right;">'.$vitalsAge.'</td></tr>';
echo '<tr class="hover1"><td>'.$teamCardAvgHeight.'</td><td style="text-align:right;">'.$vitalsGrandeur.'</td></tr>';
echo '<tr class="hover2"><td>'.$teamCardAvgWeight.'</td><td style="text-align:right;">'.$vitalsPoids.'</td></tr>';
echo '<tr class="hover1"><td>'.$teamCardAvgSalary.'</td><td style="text-align:right;">'.$vitalsSalaire.'</td></tr>';
echo '</tbody>';
echo '</table></div>';

if(isset($statsPosition) && count($statsPosition) >= 5) {
	//echo '<div><table class="table table-sm">';
    echo '<div>';
	echo '<table class="table table-sm table-striped">
        <thead>
        <tr class="tableau-top">
            <th colspan="9"><h5 class="m-0">'.$teamCardBestPlayer.'</h5></th>
        </tr>
        <tr class="tableau-top">
		<th style="text-align:center;"><a class="info" href="javascript:return;">P<span>Position</span></a></th>
		<th><a class="info" href="javascript:return;">#<span>'.$scoringNumber.'</span></a></th>
		<th><a class="info" href="javascript:return;">R<span>'.$scoringRookie.'</span></a></th>
		<th>'.$scoringName.'</th>
		<th style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGPm.'<span>'.$scoringGP.'</span></a></th>
		<th style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGm.'<span>'.$scoringG.'</span></a></th>
		<th style="text-align:right;"><a class="info" href="javascript:return;">A<span>'.$scoringAssits.'</span></a></th>
		<th style="text-align:right; font-weight:bold;"><a class="info" href="javascript:return;">P<span>Points</span></a></th>
		</tr>
        </thead>
        <tbody>';
	$c = 1;
	for($i=0;$i<5;$i++) {
		if($c == 1) $c = 2;
		else $c = 1;
		echo '<tr class="hover'.$c.'">';
		echo '<td>'.$statsPosition[$i].'</td>';
		echo '<td>'.$statsNumber[$i].'</td>';
		echo '<td>'.$statsRookie[$i].'</td>';
		echo '<td>'.$statsName[$i].'</td>';
		echo '<td style="text-align:right;">'.$statsGP[$i].'</td>';
		echo '<td style="text-align:right;">'.$statsG[$i].'</td>';
		echo '<td style="text-align:right;">'.$statsA[$i].'</td>';
		echo '<td style="text-align:right;">'.$statsP[$i].'</td>';
		echo '</tr>';
	}
	echo '</tbody></table></div>';
}

if(isset($statsGNumber) && count($statsGNumber) >= 2) {
	echo '<div>';

	echo '<table class="table table-sm table-striped">
        <thead>
        <tr class="tableau-top">
            <th colspan="9"><h5 class="m-0">'.$teamCardBestGoalie.'</h5></th>
        </tr>
        <tr class="tableau-top">
		<th><a class="info" href="javascript:return;">#<span>'.$scoringNumber.'</span></a></th>
		<th><a class="info" href="javascript:return;">R<span>'.$scoringRookie.'</span></a></th>
		<th>'.$scoringName.'</th>
		<th style="text-align:right;"><a class="info" href="javascript:return;">MIN<span>'.$scoringMIN.'</span></a></th>
		<th style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringAVGm.'<span>'.$scoringAVG.'</span></a></th>
		<th style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringWm.'<span>'.$scoringW.'</span></a></th>
		<th style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringLm.'<span>'.$scoringL.'</span></a></th>
		<th style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringTm.'<span>'.$scoringT.'</span></a></th>
		<th style="text-align:right;"><a class="info" href="javascript:return;">PCT<span>'.$scoringPCT.'</span></a></th>
		</tr>
        </thead>
        <tbody>';
	$tableauf = $statsGPCT;
	natsort($tableauf);
	$tableauf = array_reverse ($tableauf, TRUE);
	$key = key($tableauf);
	$val = current($tableauf);
	$c = 1;
	$i = 0;
	while(list ($key, $val) = myEach($tableauf)) {
		if($c == 1) $c = 2;
		else $c = 1;
		echo '<tr class="hover'.$c.'">';
		echo '<td>'.$statsGNumber[$key].'</td>';
		echo '<td>'.$statsGRookie[$key].'</td>';
		echo '<td>'.$statsGName[$key].'</td>';
		echo '<td style="text-align:right;">'.$statsGMin[$key].'</td>';
		echo '<td style="text-align:right;">'.$statsGAVG[$key].'</td>';
		echo '<td style="text-align:right;">'.$statsGW[$key].'</td>';
		echo '<td style="text-align:right;">'.$statsGL[$key].'</td>';
		echo '<td style="text-align:right;">'.$statsGT[$key].'</td>';
		echo '<td style="text-align:right;">'.$statsGPCT[$key].'</td>';
		echo '</tr>';
		if($i == 1) break 1;
		$i++;
	}
	echo '<tbody></table></div>';
}

echo '</div>';

//echo '<div style="float:right;">';
//echo '<div class="col-sm-12 col-md-6">';
//echo '<div class="col-sm-12 col-md-4">';
echo '<div class="col-sm-12 col-md-5">';
if(isset($standingFileSerie)) {
	echo '<a href="Standings3.php">';
	echo '<table class="table table-sm table-striped">';
	echo '<thead>';
	echo '<tr class="tableau-top">
	<th colspan="9"><h5 class="m-0">'.$teamCardConference.'</h5></th>
	</tr>';
	echo '<tr class="tableau-top">';
	echo '<th></th>';
	echo '<th></th>';
	echo '<th><a href="Standings.php" class="info">'.$standingTeam.'</a></th>';
	echo '<th><a href="Standings.php" class="info">'.$standingGP.'<span>'.$standingGPFull.'</span></a></th>';
	echo '<th><a href="Standings.php" class="info">'.$standingW.'<span>'.$standingWFull.'</span></a></th>';
	echo '<th><a href="Standings.php" class="info">'.$standingL.'<span>'.$standingLFull.'</span></a></th>';
	echo '<th><a href="Standings.php" class="info">'.$standingE.'<span>'.$standingEFull.'</span></a></th>';
	if($standingFileOLDetect == 1) echo '<th><a href="Standings.php" class="info">'.$standingOT.'<span>'.$standingOTFull.'</span></a></th>';
	echo '<th><a href="Standings.php" class="info"><b>'.$standingPTS.'</b><span>'.$standingPTSFull.'</span></a></th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$c = 1;
	$tmpNbr = count($standingFileSerie);
	if($standingFileFound < 2) {
		$tmpStart = 0;
		$tmpEnd = 5;
	}
	if($standingFileFound >= 2 && $standingFileFound < $tmpNbr-2) {
		$tmpStart = $standingFileFound - 2;
		$tmpEnd = $standingFileFound + 3;
	}
	if($standingFileFound > $tmpNbr-3) {
		$tmpStart = $tmpNbr-5;
		$tmpEnd = $tmpNbr;
	}

	for($i=$tmpStart;$i<$tmpEnd;$i++) {
		if($c == 1) $c = 2;
		else $c = 1;
		$bold = '';
		if($i == $standingFileFound) $bold = 'font-weight:bold;';
		echo '<tr class="hover'.$c.'">';
		echo '<td style="'.$bold.'">'.($i+1).'</td>';
		echo '<td style="'.$bold.'">'.$standingFileSerie[$i].'</td>';
		echo '<td style="'.$bold.'">'.$standingFileEquipe[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFilePJ[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFileW[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFileL[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFileT[$i].'</td>';
		if($standingFileOLDetect == 1) echo '<td style="text-align:right;'.$bold.'">'.$standingFileOL[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'"><b>'.$standingFilePts[$i].'</b></td>';
		echo '</tr>';
	}
	echo '</tbody></table></a>';
}

if(isset($standingFileDivisionSerie)) {
	echo '<a href="Standings3.php">';
	echo '<table class="table table-sm table-striped">';
	echo '<thead>';
	echo '<tr class="tableau-top">
	<td colspan="9"><h5 class="m-0">'.$teamCardDivision.'</h5></td>
	</tr>';
	echo '<tr class="tableau-top">';
	echo '<td></td>';
	echo '<td></td>';
	echo '<td><a href="Standings.php" class="info">'.$standingTeam.'</a></td>';
	echo '<td><a href="Standings.php" class="info">'.$standingGP.'<span>'.$standingGPFull.'</span></a></td>';
	echo '<td><a href="Standings.php" class="info">'.$standingW.'<span>'.$standingWFull.'</span></a></td>';
	echo '<td><a href="Standings.php" class="info">'.$standingL.'<span>'.$standingLFull.'</span></a></td>';
	echo '<td><a href="Standings.php" class="info">'.$standingE.'<span>'.$standingEFull.'</span></a></td>';
	if($standingFileOLDetect == 1) echo '<td style="text-align:right;"><a href="Standings.php" class="info">'.$standingOT.'<span>'.$standingOTFull.'</span></a></td>';
	echo '<td><a href="Standings.php" class="info"><b>'.$standingPTS.'</b><span>'.$standingPTSFull.'</span></a></td>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$c = 1;
	for($i=0;$i<count($standingFileDivisionSerie);$i++) {
		if($c == 1) $c = 2;
		else $c = 1;
		$bold = '';
		if($i == $standingFileDivisionFound) $bold = 'font-weight:bold;';
		echo '<tr class="hover'.$c.'">';
		echo '<td style="'.$bold.'">'.($i+1).'</td>';
		echo '<td style="'.$bold.'">'.$standingFileDivisionSerie[$i].'</td>';
		echo '<td style="'.$bold.'">'.$standingFileDivisionEquipe[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFileDivisionPJ[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFileDivisionW[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFileDivisionL[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFileDivisionT[$i].'</td>';
		if($standingFileOLDetect == 1) echo '<td style="text-align:right;'.$bold.'">'.$standingFileDivisionOL[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'"><b>'.$standingFileDivisionPts[$i].'</b></td>';
		echo '</tr>';
	}
	echo '</tbody></table></a>';
}
if(isset($standingFarmFilePJ)) {
	echo '<a href="FarmStandings.php?s=1">';
	echo '<div class="table-responsive">';
	echo '<table class="table table-sm table-striped">';
	echo '<thead>';
	echo '<tr class="tableau-top">
	<th colspan="7"><h5 class="m-0">'.$teamCardConferenceFarm.'</h5></th>
	</tr>';
	echo '<tr class="tableau-top">';
	echo '<th></th>';
	echo '<th><a href="Standings.php" class="info">'.$standingTeam.'</a></th>';
	echo '<th><a href="FarmStandings.php?s=1" class="info">'.$standingGP.'<span>'.$standingGPFull.'</span></a></th>';
	echo '<th><a href="FarmStandings.php?s=1" class="info">'.$standingW.'<span>'.$standingWFull.'</span></a></th>';
	echo '<th><a href="FarmStandings.php?s=1" class="info">'.$standingL.'<span>'.$standingLFull.'</span></a></th>';
	echo '<th><a href="FarmStandings.php?s=1" class="info">'.$standingE.'<span>'.$standingEFull.'</span></a></th>';
	echo '<th><a href="FarmStandings.php?s=1" class="info"><b>'.$standingPTS.'</b><span>'.$standingPTSFull.'</span></a></th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$c = 1;
	$tmpNbr = count($standingFarmFilePJ);
	if($standingFarmFileFound < 2) {
		$tmpStart = 0;
		$tmpEnd = 5;
	}
	if($standingFarmFileFound >= 2 && $standingFarmFileFound < $tmpNbr-2) {
		$tmpStart = $standingFarmFileFound - 2;
		$tmpEnd = $standingFarmFileFound + 3;
	}
	if($standingFarmFileFound > $tmpNbr-3) {
		$tmpStart = $tmpNbr-5;
		$tmpEnd = $tmpNbr;
	}
	for($i=$tmpStart;$i<$tmpEnd;$i++) {
		if($c == 1) $c = 2;
		else $c = 1;
		$bold = '';
		if($i == $standingFarmFileFound) $bold = 'font-weight:bold;';
		echo '<tr class="hover'.$c.'">';
		echo '<td style="'.$bold.'">'.($i+1).'</td>';
		echo '<td style="'.$bold.'">'.$standingFarmFileEquipe[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFarmFilePJ[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFarmFileW[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFarmFileL[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'">'.$standingFarmFileT[$i].'</td>';
		echo '<td style="text-align:right;'.$bold.'"><b>'.$standingFarmFilePts[$i].'</b></td>';
		echo '</tr>';
	}
	echo '</tbody></table></div></a>';
}

// Team Record
if($recordConferenceGP != 0 || $recordDivisionGP != 0 || $recordHomeGP != 0 || $recordAwayGP != 0) {

    echo '<table class="table table-sm table-striped">';
    echo '<thead>';
	echo '<tr class="tableau-top">
	<th colspan="6"><h5 class="m-0">'.$teamCardReccord.'</h5></th>
	</tr>';
	echo '<tr class="tableau-top">';
	echo '<th>'.$teamCardRecord.'</th>';
	echo '<th style="text-align:right;"><a href="FarmStandings.php?s=1" class="info">'.$standingGP.'<span>'.$standingGPFull.'</span></a></th>';
	echo '<th style="text-align:right;"><a href="FarmStandings.php?s=1" class="info">'.$standingW.'<span>'.$standingWFull.'</span></a></th>';
	echo '<th style="text-align:right;"><a href="FarmStandings.php?s=1" class="info">'.$standingL.'<span>'.$standingLFull.'</span></a></th>';
	echo '<th style="text-align:right;"><a href="FarmStandings.php?s=1" class="info">'.$standingE.'<span>'.$standingEFull.'</span></a></th>';
	echo '<th style="text-align:right;"><a href="FarmStandings.php?s=1" class="info"><b>'.$standingPTS.'</b><span>'.$standingPTSFull.'</span></a></th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$c = 1;
	if($recordConferenceGP != 0) {
		if($c == 1) $c = 2;
		else $c = 1;
		echo '<tr class="hover'.$c.'">';
		echo '<td>'.$teamCardRecordConference.'</td>';
		echo '<td style="text-align:right;">'.$recordConferenceGP.'</td>';
		echo '<td style="text-align:right;">'.$recordConferenceWin.'</td>';
		echo '<td style="text-align:right;">'.$recordConferenceLos.'</td>';
		echo '<td style="text-align:right;">'.$recordConferenceTie.'</td>';
		echo '<td style="text-align:right;">'.$recordConferencePts.'</td>';
		echo '</tr>';
	}
	if($recordDivisionGP != 0) {
		if($c == 1) $c = 2;
		else $c = 1;
		echo '<tr class="hover'.$c.'">';
		echo '<td>'.$teamCardRecordDivision.'</td>';
		echo '<td style="text-align:right;">'.$recordDivisionGP.'</td>';
		echo '<td style="text-align:right;">'.$recordDivisionWin.'</td>';
		echo '<td style="text-align:right;">'.$recordDivisionLos.'</td>';
		echo '<td style="text-align:right;">'.$recordDivisionTie.'</td>';
		echo '<td style="text-align:right;">'.$recordDivisionPts.'</td>';
		echo '</tr>';
	}
	if($recordHomeGP != 0) {
		if($c == 1) $c = 2;
		else $c = 1;
		echo '<tr class="hover'.$c.'">';
		echo '<td>'.$teamCardRecordHome.'</td>';
		echo '<td style="text-align:right;">'.$recordHomeGP.'</td>';
		echo '<td style="text-align:right;">'.$recordHomeWin.'</td>';
		echo '<td style="text-align:right;">'.$recordHomeLos.'</td>';
		echo '<td style="text-align:right;">'.$recordHomeTie.'</td>';
		echo '<td style="text-align:right;">'.$recordHomePts.'</td>';
		echo '</tr>';
	}
	if($recordAwayGP != 0) {
		if($c == 1) $c = 2;
		else $c = 1;
		echo '<tr class="hover'.$c.'">';
		echo '<td>'.$teamCardRecordAway.'</td>';
		echo '<td style="text-align:right;">'.$recordAwayGP.'</td>';
		echo '<td style="text-align:right;">'.$recordAwayWin.'</td>';
		echo '<td style="text-align:right;">'.$recordAwayLos.'</td>';
		echo '<td style="text-align:right;">'.$recordAwayTie.'</td>';
		echo '<td style="text-align:right;">'.$recordAwayPts.'</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
}

// Team Stats
if(isset($teamStatsFilePP)) {
    echo '<table class="table table-sm table-striped">';
    echo '<thead>';
	echo '<tr class="tableau-top">
	<th colspan="4"><h5 class="m-0">'.$teamStatsTitle.'</h5></th>
	</tr>';
	echo '<tr class="tableau-top">';
	echo '<th style="text-align:right;"><a href="javascript:return;" class="info">'.$teamStatsPPm.'<span>'.$teamStatsPP.'</span></a></th>';
	echo '<th style="text-align:right;"><a href="javascript:return;" class="info">'.$teamStatsPKm.'<span>'.$teamStatsPK.'</span></a></th>';
	echo '<th style="text-align:right;"><a href="javascript:return;" class="info">'.$teamStatsGFGm.'<span>'.$teamStatsGFG.'</span></a></th>';
	echo '<th style="text-align:right;"><a href="javascript:return;" class="info">'.$teamStatsGAGm.'<span>'.$teamStatsGAG.'</span></a></th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	echo '<tr class="hover2">';
	echo '<td style="text-align:right;">'.$teamStatsFilePP.'</td>';
	echo '<td style="text-align:right;">'.$teamStatsFilePK.'</td>';
	echo '<td style="text-align:right;">'.$teamStatsFileGFG.'</td>';
	echo '<td style="text-align:right;">'.$teamStatsFileGAG.'</td>';
	echo '</tr>';
	echo '<tr class="hover1">';
	echo '<td style="text-align:right;">'.$teamStatsFilePPPos.'</td>';
	echo '<td style="text-align:right;">'.$teamStatsFilePKPos.'</td>';
	echo '<td style="text-align:right;">'.$teamStatsFileGFGPos.'</td>';
	echo '<td style="text-align:right;">'.$teamStatsFileGAGPos.'</td>';
	echo '</tr>';
	echo '</tbody>';
	echo '</table>';
}

echo '</div>';

// BEST ALL TIME 10 PLAYERS SEASONS POINTS
// Recherche des saisons antérieurs
if($folderCarrerStats != '0') {
	$hashFolder = '';
	$tmpLong = 0;
	for($i=0;$i<substr_count($folderCarrerStats, '/');$i++) {
		if($hashFolder != '') $tmpLong = strlen($hashFolder)+1;
		$hashFolder = substr($folderCarrerStats, 0+$tmpLong, strpos($folderCarrerStats, '/'));
		if(substr_count($hashFolder, '#') > 0) break 1;
	}
	$Fnm = str_replace("#/","*",$folderCarrerStats);
	$NumberSeason = 0;
	$dirs = glob($Fnm, GLOB_ONLYDIR);
	for($j=0;$j<count($dirs);$j++) {
		if(substr_count($dirs[$j], $hashFolder)) {
			$tmpYear = substr($dirs[$j], strlen($folderCarrerStats)-2);
			if($NumberSeason < $tmpYear) $NumberSeason = $tmpYear;
		}
	}

	// Recherche Seasons TeamScoring - Current Season
	$matches = glob($folder.'*TeamScoring.html');
	$folderLeagueURL = '';
	$matchesDate = array_map('filemtime', $matches);
	arsort($matchesDate);
	foreach ($matchesDate as $j => $val) {
		if(!substr_count($matches[$j], 'PLF')) {
			$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'TeamScoring')-strrpos($matches[$j], '/')-1);
			$FnmCurrentSeason = $folder.$folderLeagueURL.'TeamScoring.html';
			break 1;
		}
	}
	$matches = glob($folder.'*PLFTeamScoring.html');
		$folderLeagueURL = '';
		$matchesDate = array_map('filemtime', $matches);
		arsort($matchesDate);
		foreach ($matchesDate as $j => $val) {
			if(substr_count($matches[$j], 'PLF')) {
				$folderLeagueURL = substr($matches[$j], strrpos($matches[$j], '/')+1,  strpos($matches[$j], 'PLFTeamScoring')-strrpos($matches[$j], '/')-1);
				$FnmCurrentPlayoff = $folder.$folderLeagueURL.'PLFTeamScoring.html';
				break 1;
			}
		}
	$i = 0;
	$j = 0;
	for($workSeason=$NumberSeason+1;$workSeason>0;$workSeason--) {
		$Fnm = '';
		if($NumberSeason < $workSeason) {
			$Fnm = $FnmCurrentSeason;
		}
		else {
			$Fnmtmp = str_replace("#",$workSeason,$folderCarrerStats);
			$matches = glob($Fnmtmp.'*TeamScoring.html');
			$folderLeagueURL = '';
			for($k=0;$k<count($matches);$k++) {
				if(!substr_count($matches[$k], 'PLF')) {
					$folderLeagueURL = substr($matches[$k], strrpos($matches[$k], '/')+1,  strpos($matches[$k], 'TeamScoring')-strrpos($matches[$k], '/')-1);
					$Fnm = $Fnmtmp.$folderLeagueURL.'TeamScoring.html';
					break 1;
				}
			}
		}
		$b = 0;
		$e = 0;
		$f = 0;
		if(file_exists($Fnm)) {
			$tableau = file($Fnm);
			while(list($cle,$val) = myEach($tableau)) {
				$val = utf8_encode($val);
				if(substr_count($val, 'A NAME=')) {
					//$reste = substr($val, strpos($val, '='), strpos($val, '</')-strpos($val, '='));
					//$lastTeam = trim(substr($reste, strpos($reste, '>')+1));
					$b = 1;
				}
				if($b && substr_count($val, '------------')) {
					$e = 0;
					if($f == 1) {
						$b = 0;
						$f = 0;
					}
				}
				if($b && $e) {
					$reste = trim($val);
					if(!substr_count($val, '                         ')) {
						$tmpFwdPosition = trim(substr($reste, 0, strpos($reste, ' ')));
						$reste = trim(substr($reste, strpos($reste, ' ')));
						$tmpFwdNumber = trim(substr($reste, 0, strpos($reste, ' ')));
						$reste = trim(substr($reste, strpos($reste, ' ')));
						if(substr($reste, 0, 1) == '*') {
							$tmpFwdRookie = trim(substr($reste, 0, 1));
							$reste = trim(substr($reste, 1));
						}
						else $tmpFwdRookie = '';
						$tmpFwdHT2 = 0;
					}
					$tmpFwdPS = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdGS = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdPCTG = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdS = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdHT = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdGT = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdGW = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdSHG = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdPPG = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdPIM = trim(substr($reste, strrpos($reste, ' '))) * 1;
					
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdDiff = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdP = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdA = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdG = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdGP = trim(substr($reste, strrpos($reste, ' '))) * 1;
					$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
					$tmpFwdTeam = trim(substr($reste, strrpos($reste, ' ')));
					if(!substr_count($val, '                         ')) {
						$reste = trim(substr($reste, 0, strrpos($reste, ' ')));
						$tmpFwdName = $reste;
						if(substr_count($tmpFwdName, 'xtrastats.html')) {
							$tmpFwdName = trim(substr($tmpFwdName, strpos($tmpFwdName, '"')+1, strpos($tmpFwdName, '>')-1-strpos($tmpFwdName, '"')-1));
						}
					}
					
					if(isset($TSabbr) && $TSabbr == $tmpFwdTeam) {
						$tmpVal = $tableau[$cle+1];
						
						if(substr_count($tmpVal, '                         ') || (!substr_count($val, '                         ') && !substr_count($tmpVal, '                         '))) {
							$tmpFwdHT2 += $tmpFwdHT;
						}
						$tmpFound = 0;
						if(isset($statsFwdName) && $NumberSeason >= $workSeason) {
							for($v=0;$v<count($statsFwdName);$v++) {
								if($statsFwdName[$v] == $tmpFwdName) {
									$statsFwdPS[$v] += $tmpFwdPS;
									$statsFwdGS[$v] += $tmpFwdGS;
									//$statsFwdPCTG[$v] += $tmpFwdPCTG;
									$statsFwdS[$v] += $tmpFwdS;
									$statsFwdHT[$v] += $tmpFwdHT2;
									$statsFwdGT[$v] += $tmpFwdGT;
									$statsFwdGW[$v] += $tmpFwdGW;
									$statsFwdSHG[$v] += $tmpFwdSHG;
									$statsFwdPPG[$v] += $tmpFwdPPG;
									$statsFwdPIM[$v] += $tmpFwdPIM;
									$statsFwdDiff[$v] += $tmpFwdDiff;
									$statsFwdP[$v] += $tmpFwdP;
									$statsFwdA[$v] += $tmpFwdA;
									$statsFwdG[$v] += $tmpFwdG;
									$statsFwdGP[$v] += $tmpFwdGP;
									$statsFwdPCTG[$v] = 0;
									if($statsFwdS[$v] != 0) {
										$statsFwdPCTG[$v] = round(($statsFwdG[$v] / $statsFwdS[$v] * 100), 1);
									}
									$tmpFound = 1;
									break 1;
								}
							}
						}
						if($tmpFound == 0) {
							$statsFwdPosition[$i] = $tmpFwdPosition;
							$statsFwdNumber[$i] = $tmpFwdNumber;
							$statsFwdRookie[$i] = $tmpFwdRookie;
							$statsFwdPS[$i] = $tmpFwdPS;
							$statsFwdGS[$i] = $tmpFwdGS;
							//$statsFwdPCTG[$i] = $tmpFwdPCTG;
							$statsFwdS[$i] = $tmpFwdS;
							$statsFwdHT[$i] = $tmpFwdHT2;
							$statsFwdGT[$i] = $tmpFwdGT;
							$statsFwdGW[$i] = $tmpFwdGW;
							$statsFwdSHG[$i] = $tmpFwdSHG;
							$statsFwdPPG[$i] = $tmpFwdPPG;
							$statsFwdPIM[$i] = $tmpFwdPIM;
							$statsFwdDiff[$i] = $tmpFwdDiff;
							$statsFwdP[$i] = $tmpFwdP;
							$statsFwdA[$i] = $tmpFwdA;
							$statsFwdG[$i] = $tmpFwdG;
							$statsFwdGP[$i] = $tmpFwdGP;
							$statsFwdTeam[$i] = $tmpFwdTeam;
							$statsFwdName[$i] = $tmpFwdName;
							$statsFwdPCTG[$i] = 0;
							if($statsFwdS[$i] != 0) {
								$statsFwdPCTG[$i] = round(($statsFwdG[$i] / $statsFwdS[$i] * 100), 1);
							}
							$statsFwdSeason[$i] = $workSeason;
							$i++;
						}
						
					}
				}
				if($b && substr_count($val, 'PCTG') ) {
					$e = 1;
				}
				if($b && substr_count($val, 'AVG') ) {
					$f = 1;
				}
			}
		}
		//else echo $allFileNotFound.' - '.$Fnm;
	}
	
	
echo '</div>';


	if(isset($statsFwdName)) {
		echo '<div class = "row wow fadeIn">';
		//echo '<div class="col-sm-12 col-md-8 offset-md-2">';
		echo '<div class="col-sm-12 col-md-12 col-lg-8 offset-lg-2">';
		echo '<a href="CareerLeaders.php?one=1"><div style="clear:both;">';
			echo '<div><h5 class="tableau-top m-0"  style = "padding-top:5px; padding-bottom:5px">'.$teamCardBest10Players.'</h3></div>';
			echo '<div class="table-responsive">';
			echo '<table class="table table-sm table-striped">';
			echo '<thead>';
			echo '<tr class="tableau-top">
				<td></td>
				<td style="text-align:center;"><a class="info" href="javascript:return;">P<span>Position</span></a></td>
				<td><a class="info" href="javascript:return;">'.$scoringName.'</a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGPm.'<span>'.$scoringGP.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGm.'<span>'.$scoringG.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">A<span>'.$scoringAssits.'</span></a></td>
				<td style="text-align:right; font-weight:bold;"><a class="info" href="javascript:return;">P<span>Points</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">+/-<span>'.$scoringDiff.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringPIMm.'<span>'.$scoringPIM.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringPPm.'<span>'.$scoringPP.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringSHm.'<span>'.$scoringSH.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGWm.'<span>'.$scoringGW.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGTm.'<span>'.$scoringGT.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringHTm.'<span>'.$scoringHT.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringSm.'<span>'.$scoringS.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringPCTGm.'<span>'.$scoringPCTG.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringGSm.'<span>'.$scoringGS.'</span></a></td>
				<td style="text-align:right;"><a class="info" href="javascript:return;">'.$scoringPSm.'<span>'.$scoringPS.'</span></a></td>
				</tr>';
			echo '</thead>';
			echo '<tbody>';
			$tableauf = $statsFwdP;
			arsort($tableauf);
			$key = key($tableauf);
			$val = current($tableauf);
			$c = 1;
			$stop = 1;
			while(list ($key, $val) = myEach($tableauf)) {
				if($stop == 11) break 1;
				if($c == 1) $c = 2;
				else $c = 1;
				echo '<tr class="hover'.$c.'">
					<td style="">'.$stop.'</td>
					<td style="text-align:center;">'.$statsFwdPosition[$key].'</td>
					<td style="">'.$statsFwdName[$key].'</td>
					<td style="text-align:right;">'.$statsFwdGP[$key].'</td>
					<td style="text-align:right;">'.$statsFwdG[$key].'</td>
					<td style="text-align:right;">'.$statsFwdA[$key].'</td>
					<td style="text-align:right; font-weight:bold;">'.$statsFwdP[$key].'</td>
					<td style="text-align:right;">'.$statsFwdDiff[$key].'</td>
					<td style="text-align:right;">'.$statsFwdPIM[$key].'</td>
					<td style="text-align:right;">'.$statsFwdPPG[$key].'</td>
					<td style="text-align:right;">'.$statsFwdSHG[$key].'</td>
					<td style="text-align:right;">'.$statsFwdGW[$key].'</td>
					<td style="text-align:right;">'.$statsFwdGT[$key].'</td>
					<td style="text-align:right;">'.$statsFwdHT[$key].'</td>
					<td style="text-align:right;">'.$statsFwdS[$key].'</td>
					<td style="text-align:right;">'.$statsFwdPCTG[$key].'</td>
					<td style="text-align:right;">'.$statsFwdGS[$key].'</td>
					<td style="text-align:right;">'.$statsFwdPS[$key].'</td>
					</tr>';
				$stop++;
			}
			echo '</tbody></table>';
			echo '</div>';
		echo '</div></a>';
		
		echo '</div>';
	echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
	}
}



?>

<?php include 'footer.php'; ?>