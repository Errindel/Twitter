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

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
}
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

        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/profile.css">


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
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="logout.php">Wyloguj się </a></li>
                    </ul>

                </div><!--/.navbar-collapse -->
            </div>
        </nav>


        <div class="container-fluid full" >
            <div class="row full">
                <div class="col-md-12 full">
                    <div id="background-img"></div>
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a id="sendMsg">Wyślij wiadomość</a></li>
                                <li><a class="active" href="#">Tweety</a></li>

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="row full">


            </div>
        </div>
        <div class="container">
            <!-- Example row of columns -->

            <div class="row ">

                <div class="col-md-3">

                    <?php
                    $user = User::loadUserById($connection, $userId);
                    $userName = $user->getUsername();
                    $userEmail = $user->getEmail();
                    ?>

                    <table class="table" id="table-user">                                
                        <tbody>
                        <div class="avatar"></div>

                        <tr> <h3 class="full"><?= $userName ?></h3>  </tr>
                        <tr>  <?= $userEmail ?> </tr>

                        </tbody>
                    </table>

                    <form class='form hide' id="send-msg" role='form' action='sendMsg.php' method='POST'>
                        <div class='form-group'> 
                            <label> Wiadomość: </label> 
                            <textarea type='text' name='changeName' placeholder='Imię' class='form-control' id='change-name'></textarea> 
                        </div> 
                        <button name='changeData' type='submit' class='btn btn-info'>Wyślij wiadomość</button> 
                    </form>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12" style="padding: 0px;">
                        <h5>Tweety</h5>
                        <?php
                        $tweets = Tweet::loadAllTweetsByUserId($connection, $userId);



                        for ($i = 0; $i < count($tweets); $i++) {
                            $id = $tweets[$i]->getUserId();
                            $loadedUser = User::loadUserById($connection, $id);
                            $username = $loadedUser->getUsername();
                            $tweetId = $tweets[$i]->getTweetId();
                            ?>
                            <table class="table table-hover" id="table-tweet">                                
                                <tbody>
                                    <tr id="table-tweet-header">
                                        <td> <strong><?= $username ?></strong> </td>
                                        <td> Data: <?= $tweets[$i]->getCreationDate() ?> </td>
                                        <td id="tweet-comment">
                                            <a href="comments.php?tweetId=<?= $tweetId ?>">
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
                                    <tr>
                                        <td colspan="3"><a href="comments.php?tweetId=<?= $tweetId ?>"><?= $tweets[$i]->getText() ?></a></td>
                                    </tr>

                                </tbody>
                            </table>
                        <?php } ?>

                    </div>

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
