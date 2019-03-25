<?php

//set_include_path('../');

$CurrentHTML = 'Login.php';
$CurrentTitle = 'Login';
$CurrentPage = 'Login';

include 'config.php';
include 'lang.php';
include 'common.php';
include 'head.php';

if ( ! empty( $_POST ) ) {
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
        // Getting submitted user data from database
//         $con = new mysqli($db_host, $db_user, $db_pass, $db_name);
//         $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
//         $stmt->bind_param('s', $_POST['username']);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $user = $result->fetch_object();
        
//         // Verify user password and set $_SESSION
//         if ( password_verify( $_POST['password'], $user->password ) ) {
//             $_SESSION['user_id'] = $user->ID;
//         }

        $_SESSION['user_id'] = $_POST['username'] ;
        echo $_SESSION['user_id'];
    }
}

?>

<form action="" method="post">
<input type="text" name="username" placeholder="Enter your username" required>
<input type="password" name="password" placeholder="Enter your password" required>
<input type="submit" value="Submit">
</form>


<?php include 'footer.php'; ?>

