<?php
include_once 'src/init.php';;
include_once 'src/config.php';
include_once 'src/User.php';

$connection = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        !empty($_POST['email']) &&
        !empty($_POST['name']) &&
        !empty($_POST['password'])) 
    {
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        
        $newUser = new User;
        $newUser->setEmail($email);
        $newUser->setPassword($password);
        $newUser->setUsername($name);
                
        $result = $newUser->saveToDB($connection);
        var_dump($result);
        
    if ($result == true) {     
            $loggedUserId = $newUser->getId();
            $_SESSION['loggedUserId'] = $loggedUserId;
            header('Location: main.php');
            echo "utworzono użytkownika";
            exit;
    } else {
        header('Location: index.php');
    }
}else {
        header('Location: index.php');
        echo "Podaj wszystkie dane";
        
    }
?>