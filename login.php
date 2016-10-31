<?php
include_once 'src/init.php';
include_once 'src/config.php';
include_once 'src/User.php';

$connection = getDbConnection();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        !empty($_POST['email']) &&
        !empty($_POST['password'])) 
    {
        $email = $_POST['email'];
        
        $password = $_POST['password'];
        $loggedUser = User::loadUserByEmail($connection, $email);
                

    if ($loggedUser != null) {
        $hash = $loggedUser->getHashedPassword();
        echo $hash;
        if (password_verify($_POST['password'], $hash)) {
            $loggedUserId = $loggedUser->getId();
            $_SESSION['loggedUserId'] = $loggedUserId;
            header('Location: main.php');
            exit;
        } else {
            header('Location: index.php');
            $message = "Niepoprawny login lub hasło. Spróbuj ponownie";
            
        }
    } else {
        header('Location: index.php');
        $message = "Niepoprawny login lub hasło. Spróbuj ponownie";
    }
}
?>