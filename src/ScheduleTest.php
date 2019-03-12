<?php

include 'config.php';
include 'lang.php';
include_once 'common.php';
include_once 'classes/ScheduleHolder.php';
include_once 'classes/ScheduleObj.php';

$CurrentPage = 'Schedule2';
$playoff = '';

$fileName = getLeagueFile($folder, $playoff, 'Schedule.html', 'Schedule');

$schedule = new ScheduleHolder($fileName, '');

$results = $schedule->getSchedule();

$lastDayPlayed =  $schedule ->getLastDayPlayed();

$new_array = getFilteredArray('gameDay', $lastDayPlayed, $schedule->getSchedule());

print_r($new_array);


?>