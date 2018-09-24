﻿<?php
// Version 1.01
// Made By Éric Leclerc
// eleclerc@hotmail.ca
// Edit this file with Notepad++ Or an editor with UTF-8 w/o BOM capability

// Langue | Français: 'FR' | English: 'EN'
$leagueLang = 'EN';

// Chemin de destination des fichiers html de votre ligue, même dossier '';, répertoire précédant '../';
// Enter where your HTML files are located in your website. Same folder = '';, Previous directory = '../';
// Ex: '../html/'; -> Your HTML files folder: http://yourLeague.com/html/ -> Add-on folder: http://yourLeague.com/TablePage/
$folder = 'transfer/';

// Chemin de destination des fichiers html des parties, à partir de votre répertoire précédant $folder, si tout vos fichiers sont dans le même dossier mettre '';
// If your games files aren't in the same directory as the other files, enter here the subfolder of $folder.
// If Everything is in the same folder enter '';
$folderGames = '';

# SALARY COP
// 0 : Calcul de la masse salariale avec le Pro payroll seulement
// 1 : Calcul de la masse salariale avec le Pro + Farm Payroll
// 0 : Calculate Salary Cap with only Pro Payroll
// 1 : Calculate Salary Cap with Pro + Farm Payroll
$leagueSalaryIncFarm = 0;

// Plafond salariale | Salary Cap | Ex: 56000000 for 56M$
$leagueSalaryCap = 53000000;

// Alerte Proche du Plafond Salariale | Warning Near Salary Cap | Ex: 55000000 for 55M$
$leagueSalaryClose = 52000000;

// Plafond salariale minimum | Floor Salary Cap | Ex: 45000000 for 45M$ | 0 : Désactivé/Unactivated
$leagueSalaryCapFloor = 0;

// Point en Prolongation | Overtime Point | 0:Off | 1:On (One Point)
$leagueOvertimePoint = 1;

# CAREER STATS
// Needed Files in each season folders : GMs, PlayerVitals, TeamScoring, PLFTeamScoring, Standings

// Chemin d'accès aux dossiers contenants les anciennes saisons. Mettre / à la fin. 0 = désactivé
// Ce dossier doit avoir le même nom et avoir le chiffre de la saison, example: Season 1, Season 2, Season 3. Mettre # à la place du chiffre!
// Example complète: ../backup/Season #/
// De plus, le dossier de la saison actuelle ne doit pas être ici. Sinon, les stats vont être chargés deux fois.

// Enter where your backup HTML files are located in your website. Unabled : 0;
// This folder MUST have the same name and at the end, the number of the season. Ex: Season 1, Season 2, Season 3. Put # to replace the number!
// Full example: ../backup/Season #/
// The current season/playoff folder shouldn't be here,  it will duplicates stats.

$folderCarrerStats = 'backup/season#/';

# BOXSCORE LOGO
// Logo optimal specs: width:60px, height:30px (The image will be resized if to big in either direction)
// Supported Formats: JPEG, GIF, PNG, BMP, ICO (PNG Recommanded)
// Logo names: the same as the name in your FHLsim but ALL the characters in lowercase Ex: RED WINGS = red wings
// Enter where your team logos are located in your website. Same folder = '';, Previous directory = '../';
$folderTeamLogos = 'logos/';

#GMO Location. 
//Location of Online GM editor
$folderGmo = 'gmo/';

#Legacy file locations (old html files still referenced)
$folderLegacy = 'legacy/';

# CHAT BOX SETTINGS
// Enabled : 1 | Disabled : 0
$leagueChatBox = 0;

// For more information about timezone available : http://php.net/manual/en/timezones.php, copy paste your timezone in the box bellow!
$leagueTimeZone = 'America/Toronto';

# BACK AND HOME BUTTONS
// Enabled : 1 | Disabled : 0
$leagueBackButton = 0;

// Enabled : 1 | Disabled : 0
$leagueHomeButton = 0;

# FUTURES PAGE
// Choose between hockeyDB : 1 or EliteProspect : 2
$leagueFuturesLink = 2;

# Playoff mode
# Regular Season : 1 or Playoffs : 2
#$playoff = 0;

//////////////////////////////////////
// PARAMÈTRES DES COULEURS - COLORS //
//////////////////////////////////////

// Bleu LHSX - LHSX Blue : 1
// Gris Foncé - Dark Grey : 2
// Rouge Doux - Soft Red : 3
// Vert Pomme - Green Apple : 4
// STHS simon t color : 5
// Orange : 6
$selectedColor = 1;

// Ne pas modifier - Don't modify
include 'config_color'.$selectedColor.'.php';
?>