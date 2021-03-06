<?php
include_once 'src/init.php';
include_once 'src/config.php';
include_once 'src/User.php';
include_once 'src/Tweet.php';
include_once 'src/Comment.php';

if (isset($_SESSION['loggedUserId'])) {
    
} else {
    header('Location: index.php');
}

if (isset($_GET['tweetId'])) {
    $tweetId = $_GET['tweetId'];
}

$connection = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        !empty($_POST['comment'])) {
    $comment = $_POST['comment'];
    $userId = $_SESSION['loggedUserId'];
    $creationDate = date("Y-m-d h:i:s");


    $newComment = new Comment();
    $newComment->setText($comment);
    $newComment->setUserId($userId);
    $newComment->setTweetId($tweetId);
    $newComment->setCreationDate($creationDate);
    $result = $newComment->saveToDB($connection);
}
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <base href="comments.php">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Twitter</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">


        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->


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
                        <li><a href="messages.php">Wiadomości</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="logout.php">Wyloguj się </a></li>
                    </ul>
                </div><!--/.navbar-collapse -->
            </div>
        </nav>

        <div class="container">
            
            <div class="row ">
                <div class="col-md-4">
                    <h5>Twoje dane:</h5>

                    <?php
                    $loggedUser = new User;
                    $loggedUserId = $_SESSION['loggedUserId'];
                    $loggedUser = User::loadUserById($connection, $loggedUserId);
                    $loggedUserName = $loggedUser->getUsername();
                    $loggedUserEmail = $loggedUser->getEmail();
                    ?>

                    <table class="table table-hover" id="table-tweet">                                
                        <thead>
                            <tr><div style="background-color: #2B7BB9; height: 80px;"></div></tr>
                            <tr id="table-tweet-header">
                                <td> Użytkownik: <?= $loggedUserName ?> </td>
                                <td> Email:  <?= $loggedUserEmail ?> </td>
                            </tr>
                        </thead>    
                        <tbody>
                            <tr>
                                <td><form action="profile.php" method="POST"><button class="btn btn-info btn-xs">Twój profil</button></form></td>
                            </tr>

                        </tbody>
                    </table>

                </div>
                <div class="col-md-8">
                    <h5>Tweet</h5>
                    <?php
                    $tweet = new Tweet;
                    $tweet = Tweet::loadTweetById($connection, $tweetId);

                    $id = $tweet->getUserId();
                    $loadedUser = new User;
                    $loadedUser = User::loadUserById($connection, $id);
                    $username = $loadedUser->getUsername();
                    ?>


                    <table class="table" id="table-tweet">                                
                        <tbody>
                            <tr id="table-tweet-header">
                                <td> <strong><?= $username ?></strong> </td>
                                <td> Data: <?= $tweet->getCreationDate() ?> </td>
                            </tr>
                            <tr>
                                <td colspan="2"><?= $tweet->getText() ?></td>
                            </tr>
                            <tr class="hidden-option">
<!--                                                <td>
                                    <a href="comments.php?tweetId=<?= $tweetId ?>"><span class="glyphicon glyphicon-comment"></span></a>
                                    <a href="comments.php"><span class="glyphicon glyphicon-heart"></span></a>
                                </td>-->
                            </tr>

                        </tbody>
                    </table>

                    <row>
                        <div class="col-md-12" style="padding: 0px;">
                            <h5>Somentuj:</h5>
                            <form class="comment" role="form" action="" method="POST">
                                <div class="form-group">
                                    <textarea type="text" name="comment" placeholder="Skomentuj" class="form-control" id="comment"></textarea>
                                    <span class="komunikat hide"></span>
                                </div>
                                <button type="submit" class="btn btn-info" id="send-comment">Skomentuj</button>
                                <span class="komunikat hide"></span>
                                <span id="commentCounter">60</span>
                            </form>

                            <h5>Komentarze:</h5>

                            <?php 
                            $comments = new Comment;
                            $loadedComments = $comments->loadAllCommentByTweetId($connection, $tweetId);
                   
                            for ($i = 0; $i < count($loadedComments); $i++) {
                                $id = $loadedComments[$i]->getUserId();
                                $loadedUser = new User;
                                $loadedUser = User::loadUserById($connection, $id);
                                $username = $loadedUser->getUsername();
                                $commentId = $loadedComments[$i]->getCommentId();
                            ?>
                                   
                                <table class="table" id="table-tweet">                                
                                    <tbody>
                                        <tr id="table-tweet-header">
                                            <td> <strong><?= $username ?></strong> </td>
                                            <td> Data: <?= $loadedComments[$i]->getCreationDate() ?> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><?= $loadedComments[$i]->getText() ?></td>
                                        </tr>
<!--                                        <tr class="hidden-option">
                                            <td>
                                                <a href="comments.php?tweetId=<?=$tweetId?>"><span class="glyphicon glyphicon-comment"></span></a>
                                                <a href="comments.php"><span class="glyphicon glyphicon-heart"></span></a>
                                            </td>
                                        </tr>-->

                                    </tbody>
                                </table>
                            
                            <?php } ?>

                        </div>
                    </row>
                </div>
            </div>
        </div>

        <hr>


    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

     <script src="js/vendor/bootstrap.min.js"></script>

    <script src="js/main.js"></script>

</body>
</html>
