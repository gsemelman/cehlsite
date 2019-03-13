<?php 

use APPConnection\DbConnection;

include_once 'DbConnection';

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="UTF-8"/>
  	<meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86"/>
  	<title>Canadian Elite Hockey League</title>

</head>
<body>

<?php 



$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root";
$dbname="player_ratings";

$inst = new DbConnection('...', 'usr', 'pass');
var_dump($inst->isConnected());//false
$stmt = $inst->getStatement('SELECT name, team, age FROM player_ratings.cehl_master');
var_dump($inst->isConnected());//true

$stmt->execute();
$stmt->bind_result($name, $team, $age);
while ($stmt->fetch()) {
    printf("%s, %s, %s\n", $name, $team, $age);
}
$stmt->close();


// $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
// or die ('Could not connect to the database server' . mysqli_connect_error());

// $query = "SELECT name, team, age FROM player_ratings.cehl_master";

// if ($stmt = $con->prepare($query)) {
//     $stmt->execute();
//     $stmt->bind_result($name, $team, $age);
//     while ($stmt->fetch()) {
//         printf("%s, %s, %s\n", $name, $team, $age);
//     }
//     $stmt->close();
// }


// $con->close();
?>




</body>
</html>