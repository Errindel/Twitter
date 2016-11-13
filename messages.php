<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'src/init.php';
include_once 'src/config.php';
include_once 'src/User.php';
include_once 'src/Tweet.php';
include_once 'src/Comment.php';
include_once 'src/Message.php';



if (isset($_SESSION['loggedUserId'])) {
    
} else {
    header('Location: index.php');
}




?>




<!doctype html>
<html class="no-js" lang=""> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Twitter</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">    
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/profile.css">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

    <!-- =========================================================== NAV -->
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="main.php">Główna</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php">Wyloguj się </a></li>
                </ul>

            </div><!--/.navbar-collapse -->
        </div>
    </nav>
    <!-- =========================================================== NAV -->
    <!-- =========================================================== NAV-userbar -->
    <div class="container-fluid full" >
        <div class="row full">
            <div class="col-md-12 full">
                <div id="background-img"></div>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="active" href="#">Twoje Tweety</a></li>
                            <li><a  id="changeData"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Zmień dane</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
     <!-- =========================================================== NAV-userbar -->
    
    <div class="container">
        <div class="row ">
            <div class="col-md-3">
                <!-- =========== logged user info panel ================= -->
                <table class="table" id="table-user">                                
                    <tbody>
                        <div class="avatar"></div>
                        <tr> <h3 class="full"><?= $loggedUserName ?></h3>  </tr>
                        <tr>  <?= $loggedUserEmail ?> </tr>
                    </tbody>
                </table>

                <!-- =========== logged user info change panel show/hide with JS ================= -->
                <form class='form hide' id="change-data-form" role='form' action='' method='POST'> 
                    <div class='form-group'> 
                        <label> Imię: </label> 
                        <input type='text' name='changeName' placeholder='Imię' class='form-control' id='change-name'> 
                        <label> E-mail</label> 
                        <input type='text' name='changeEmail' placeholder='E-mail' class='form-control' id='change-email'>
                        <label> Hasło</label>
                        <input type='password' name='changePassword' placeholder='Hasło' class='form-control' id='change-password'>
                    </div>
                    <button name='changeData' type='submit' class='btn btn-info'>Zmień dane</button>
                </form>
            </div>
            
            <!-- =========== show all msg by logged user id ================= -->
            <div class="col-md-9">
                <div class="col-md-12" style="padding: 0px;">
                    <h5>Wiadomości</h5>
                    <?php
                    $msg = Message::loadAllMessageByReceiverId($connection, $loggedUserId);

                    for ($i = 0; $i < count($msg); $i++) {
                        $id = $msg[$i]->getSenderId();
                        $loadedUser = User::loadUserById($connection, $id);
                        $username = $loadedUser->getUsername();
                    ?>
                    <table class="table table-hover" id="table-tweet">                                
                        <tbody>
                            <tr id="table-tweet-header"> <!-- =========== show username, date, quantity of comments ================= -->
                                <td> <strong><?= $username ?></strong> </td>
                                <td> Data: <?= $msg[$i]->getDate() ?> </td>
                                <td id="tweet-comment"><span><?php
                                    $quantityOfComments = $msg[$i]->getStatus();
                                    echo $quantityOfComments;
                                    
                                ?></span></td>
                            </tr>
                            <tr> <!-- =========== show msg txt ================= -->
                                <td colspan="3"><?= $msg[$i]->getMessageTxt() ?></a></td>
                            </tr>
                            <tr>
                                <td colspan="3"> <!-- =========== answer form ================= -->
                                    <form class='form' id="send-msg" role='form' action='' method='POST'>
                                        <div class='form-group'> 
                                            <label> Odpowiedz </label> 
                                            <textarea type='text' name='msgTxt' placeholder='Wiadomośc...' class='form-control' id='change-name'></textarea> 
                                        </div> 
                                        <button name='newMsg' type='submit' class='btn btn-info'>Wyślij wiadomość</button> 
                                    </form>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <?php } ?> <!--  for ending-->
                </div>
            </div>
        </div>
    </div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

<script src="js/vendor/bootstrap.min.js"></script>

<script src="js/main.js"></script>
</html>


<?php
// get DBconnection
$connection = getDbConnection();
// loads info about logged in user
$loggedUserId = $_SESSION['loggedUserId'];
$loggedUser = User::loadUserById($connection, $loggedUserId);
$loggedUserName = $loggedUser->getUsername();
$loggedUserEmail = $loggedUser->getEmail();



// send new message
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
            !empty($_POST['msgTxt'])
    ) {
        $messageTxt = $_POST['msgTxt'];
        $senderId = $_SESSION['loggedUserId'];

        $newMsg = new Message;
        $date = date("Y-m-d h:i:s");
        $newMsg->setDate($date);
        $newMsg->setMessageTxt($messageTxt);
        $newMsg->setSenderId($senderId);
        $newMsg->setReceiverId($id);
        $newMsg->setStatus(0);

        $result = $newMsg->saveToDB($connection);
    }

// change data form
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        !empty($_POST['changeName']) &&
        !empty($_POST['changeEmail']) &&       
        !empty($_POST['changePassword'])        
        ) {
    $username = $_POST['changeName'];
    $email = $_POST['changeEmail'];
    $newPassword = $_POST['changePassword'];
    $userId = $_SESSION['loggedUserId'];

    $changeData = new User;
    $changeData = User::loadUserById($connection, $userId);
    $changeData->setEmail($email);
    $changeData->setPassword($newPassword);
    $changeData->setUsername($username);

    $result = $changeData->saveToDB($connection);
}
    
?>