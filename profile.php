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
<body>
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
<!-- =========================================================== NAV-userbar -->
    <div class="container-fluid full" >
        <div class="row full">
            <div class="col-md-12 full">
                <div style="background-color: #2B7BB9; height: 200px; width: 100%"></div>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">Wiadomości</a></li>
                            <li><a class="active" href="#">Twoje Tweety</a></li>
                            <li><a  id="changeData"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Zmień dane</a></li>

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

                <?= $creationTime ?>
                <?php
                $loggedUser = new User;
                $loggedUserId = $_SESSION['loggedUserId'];
                $loggedUser = User::loadUserById($connection, $loggedUserId);
                $loggedUserName = $loggedUser->getUsername();
                $loggedUserEmail = $loggedUser->getEmail();
                ?>

                <table class="table" id="table-user">                                
                    <tbody>
                    <div class="avatar"></div>

                    <tr> <h3 class="full"><?= $loggedUserName ?></h3>  </tr>
                    <tr>  <?= $loggedUserEmail ?> </tr>

                    </tbody>
                </table>


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
            <div class="col-md-9">
                <div class="col-md-12" style="padding: 0px;">
                    <h5>Twoje Tweety</h5>
                    <?php
                    $tweets = Tweet::loadAllTweetsByUserId($connection, $loggedUserId);



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

<?php
// get DB connection
$connection = getDbConnection();

// add new Tweet
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        !empty($_POST['tweet'])) {
    $tweet = $_POST['tweet'];
    $userId = $_SESSION['loggedUserId'];
    $creationDate = date("Y-m-d h:i:s");

    $newTweet = new Tweet;
    $newTweet->setText($tweet);
    $newTweet->setUserId($userId);
    $newTweet->setCreationDate($creationDate);

    $result = $newTweet->saveToDB($connection);
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

    $changeData = User::loadUserById($connection, $userId);
    $changeData->setEmail($email);
    $changeData->setPassword($newPassword);
    $changeData->setUsername($username);

    $result = $changeData->saveToDB($connection);
}
?>