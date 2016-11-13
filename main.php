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

$connection = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        !empty($_POST['tweet'])) 
    {
    $tweet = $_POST['tweet'];
    $userId = $_SESSION['loggedUserId'];
    $creationDate = date("Y-m-d h:i:s");
    

    $newTweet = new Tweet;
    $newTweet->setText($tweet);
    $newTweet->setUserId($userId);
    $newTweet->setCreationDate($creationDate);

    $result = $newTweet->saveToDB($connection);
}

 // Pobieranie informacji o zalogowanym użytowniku
    $loggedUser = new User;
    $loggedUserId = $_SESSION['loggedUserId'];
    $loggedUser = User::loadUserById($connection, $loggedUserId);
    $loggedUserName = $loggedUser->getUsername();
    $loggedUserEmail = $loggedUser->getEmail();

// Pobieranie informacji o ilości komentarzy pod tweetem
    $AllCommByTweetId = new Comment;
    


?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
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
        <!-- Example row of columns -->
        <div class="row ">

            <!-- Kolumna z danymi użytkownika -->
            <div class="col-md-3">
                
                <table class="table" id="table-user">                                
                        <tbody>
                        <div class="avatar"></div>

                        <tr> <a href="profile.php?userId=<?=$loggedUserId?>"><h3 class="full"><?= $loggedUserName ?></h3></a>  </tr>
                        <tr>  <?= $loggedUserEmail ?> </tr>

                        </tbody>
                    </table>
            </div>

            <!-- Kolumna z Tweetami -->
            <div class="col-md-9">
                <!--  START Nowe Tweety -->
                <form class="tweet" role="form" action="" method="POST">
                    <div class="form-group">
                        <textarea type="text" name="tweet" placeholder="Co się dzieje?" class="form-control" id="tweet"></textarea>
                    </div>
                    <div class="hide" id="hideElement">
                    <button type="submit" class="btn btn-info" >Tweetnij</button>
                    <span id="tweetCounter">140</span>
                    </div>
                </form>
                <!--  END Nowe Tweety -->
                <row>
                    <!-- START Kolumna Tweetów pobranych z bazy -->
                    <div class="col-md-12" style="padding: 0px;">
                        <h5>Kiedy Cię nie było...</h5>
                        <?php
                        $tweets = Tweet::loadAllTweets($connection);

                        for ($i = 0; $i < count($tweets); $i++) {
                            $id = $tweets[$i]->getUserId();
                            $loadedUser = User::loadUserById($connection, $id);
                            $username = $loadedUser->getUsername();
                            $userId = $loadedUser->getId();
                            $tweetId = $tweets[$i]->getTweetId();
                        ?>
                        
                            <table class="table" id="table-tweet">
                                <thead>
                                    <tr id="table-tweet-header">
                                        <td id="tweet-username">  <a href="userProfile.php?userId=<?=$userId?>"><strong><?= $username ?></strong> </a> </td>
                                        <td id="tweet-date"> <?= $tweets[$i]->getCreationDate() ?> </td>
                                        <td id="tweet-comment">
                                            <a href="comments.php?tweetId=<?=$tweetId?>">
                                                <span><?php
                                                $AllCommByTweetId = Comment::loadAllCommentByTweetId($connection, $tweetId);
                                                $quantityOfComments = count($AllCommByTweetId);
                                                echo $quantityOfComments;
                                                ?>
                                                </span>
                                                <span class="glyphicon glyphicon-comment"></span>
                                            </a>
                                            
                                        </td>
                                    </tr>
                                </thead>    
                                <tbody>    
                                    <tr>
                                         <td colspan="3" id="tweet-text"><a href="comments.php?tweetId=<?=$tweetId?>"><?= $tweets[$i]->getText() ?></a></td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                        
                        <?php } ?>

                    </div>
                    <!-- END Kolumna Tweetów pobranych z bazy -->
                </row>
            </div>
        </div>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
    </body>
</html>
