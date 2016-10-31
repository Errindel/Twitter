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
        <link rel="stylesheet" href="css/index.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

       <?php 
                include_once 'src/init.php';
               include_once 'src/User.php';
               include_once 'src/Tweet.php';

//               $user = new User;
//
//               $user->setUsername("Adriana");
//               $user->setEmail("ad203@gmail.com");
//               $user->setPassword("12345");
//
//               $connection = getDbConnection();
//
//               $user->saveToDB($connection);
//
//               $id = 2;
//
//               $user = User::loadUserById($connection, $id);
//               if(empty($user)){
//                   echo "User does not exist";
//                   die;
//               };
//               $user = User::loadUserById($connection, $id);
//        
       ////
               //$user->delete($connection)


//               $tweet = new Tweet();
//               $tweet->setText("To jest tweet.");
//               $tweet->setUserId(1);
//               $tweet->setCreationDate("2016-12-12");
//
//               var_dump($tweet);
//
//               $tweet->saveToDB($connection);
//               var_dump($tweet);
//
//               $tweets = $tweet->loadAllTweetsByUserId($connection, 1);
//               var_dump($tweets);
        ?>





    <nav class="navbar navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Twitter</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row welcome">
        <div class="col-md-6">
          <h2>Witaj na Twitterze.</h2>
          <p class="welcome-txt">Połącz się ze swoimi znajomymi – i innymi ciekawymi ludźmi. Otrzymuj natychmiastowe aktualizacje na tematy, które Cię interesują. Obserwuj rozwój wydarzeń w czasie rzeczywistym, z każdej strony. </p>

        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
          <form action ="login.php" class="login" role="form" method="POST">
            <div class="form-group">
              <input type="text" name="email" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="password" placeholder="hasło" class="form-control">
            </div>
            <button type="submit" class="btn btn-info btn-block">Zaloguj się</button>
          </form>
            <?= $message ?>
          <form  action="register.php" class="register" role="form" method="POST">
            <h4>Pierwszy raz na Twitterze?</h4>
            <span>Zarejestruj się</span>
            <div class="form-group">
              <input type="text" name="name" placeholder="Imię i nazwisko" class="form-control">
            </div>
            <div class="form-group">
              <input type="text" name="email" placeholder="E-mail" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="password" placeholder="Hasło" class="form-control">
            </div>
            <button type="submit" class="btn btn-warning btn-block">Zarejestruj się na Twitterze</button>
          </form>
       </div>
      </div>

      <hr>


    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
