<?php ?>




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
                            <input type="text" name="email" placeholder="Email" class="form-control" id="email-l">
                            <span class="komunikat hide"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="hasło" class="form-control" id="password-l">
                            <span class="komunikat hide"></span>
                        </div>
                        <button type="submit" class="btn btn-info btn-block" id="button-l">Zaloguj się</button>
                        <span class="komunikat hide"></span>
                    </form>

                    <form  action="register.php" class="register" role="form" method="POST">
                        <thead>
                            <h4>Pierwszy raz na Twitterze?</h4>
                            <span>Zarejestruj się</span>
                        </thead>
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Imię i nazwisko" class="form-control" id="name-r">
                            <span class="komunikat hide"></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" placeholder="E-mail" class="form-control" id="email-r">
                            <span class="komunikat hide"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Hasło" class="form-control" id="password-r">
                            <span class="komunikat hide"></span>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block" id="button-r">Zarejestruj się na Twitterze</button>
                        <span class="komunikat hide"></span>
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
            (function (b, o, i, l, e, r) {
                b.GoogleAnalyticsObject = l;
                b[l] || (b[l] =
                        function () {
                            (b[l].q = b[l].q || []).push(arguments)
                        });
                b[l].l = +new Date;
                e = o.createElement(i);
                r = o.getElementsByTagName(i)[0];
                e.src = '//www.google-analytics.com/analytics.js';
                r.parentNode.insertBefore(e, r)
            }(window, document, 'script', 'ga'));
            ga('create', 'UA-XXXXX-X', 'auto');
            ga('send', 'pageview');
        </script>

        <script>
            $(document).ready(function () {
                
                $('#password-l').on('blur', function () {
                    var input = $(this);
                    var pass_length = input.val().length;
                    console.log(pass_length);
                    
                    if (pass_length >= 8 && pass_length <= 16) {
                        input.parent().removeClass("has-error").addClass("has-success");
                        input.next('.komunikat').text("Wprowadzono poprawne hasło.").removeClass("error").removeClass("hide").addClass("ok show");
                    } else {
                        input.parent().removeClass("has-success").addClass("has-error");
                        input.next('.komunikat').text("Hasło musi mieć min. 8 i max. 16 znaków. Bez znaków specjalnych!").removeClass("ok").removeClass("hide").addClass("error");

                    }
                });

          
                $('#email-l').on('blur', function () {
                    var input = $(this);
                    var pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                    var is_email = pattern.test(input.val());
                    if (is_email) {
                        input.parent().removeClass("has-error").addClass("has-success");
                        input.next('.komunikat').text("Wprowadzono poprawny email.").removeClass("error").removeClass("hide").addClass("ok");
                    } else {
                        input.parent().removeClass("has-succes").addClass("has-error");
                        input.next('.komunikat').text("Wprowadź poprawny email!").removeClass("ok").removeClass("hide").addClass("error");
                    }
                });
                
                //Po próbie wysłania formularza rejsetracji 
		$('#button-l').click(function(event){
                        var button = $(this);
			var email = $('#email-l');
			var password = $('#password-l');
			
                        console.log(email.parent().hasClass('has-success'));
                        console.log(password.parent().hasClass('has-success'));
                        
			if(email.parent().hasClass('has-success') && password.parent().hasClass('has-success')){	
			}
			else {
				event.preventDefault();
				button.next('.komunikat').text("Uzupełnij wszystkie pola!").removeClass("ok").removeClass("hide").addClass("error");	
			}
		});
                
                
                
                
                //REJESTRACJA
                $('#name-r').on('blur', function () {
                    var input = $(this);
                    var name_length = input.val().length;
                    if (name_length >= 4 && name_length <= 25) {
                        input.parent().removeClass("has-error").addClass("has-success");
                        input.next('.komunikat').text("Wprowadzono poprawną nazwę.").removeClass("error").removeClass("hide").addClass("ok");
                    } else {
                        input.parent().removeClass("has-success").addClass("has-error");
                        input.next('.komunikat').text("Nazwa musi mieć więcej niż 3 i mniej niż 25 znaków!").removeClass("ok").removeClass("hide").addClass("error");

                    }
                });
                
                $('#password-r').on('blur', function () {
                    var input = $(this);
                    var pass_length = input.val().length;
                    console.log(pass_length);
                    
                    if (pass_length >= 8 && pass_length <= 16) {
                        input.parent().removeClass("has-error").addClass("has-success");
                        input.next('.komunikat').text("Wprowadzono poprawne hasło.").removeClass("error").removeClass("hide").addClass("ok");
                    } else {
                        input.parent().removeClass("has-success").addClass("has-error");
                        input.next('.komunikat').text("Hasło musi mieć min. 8 i max. 16 znaków. Bez znaków specjalnych!").removeClass("ok").removeClass("hide").addClass("error");

                    }
                });

          
                $('#email-r').on('blur', function () {
                    var input = $(this);
                    var pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                    var is_email = pattern.test(input.val());
                    if (is_email) {
                        input.parent().removeClass("has-error").addClass("has-success");
                        input.next('.komunikat').text("Wprowadzono poprawny email.").removeClass("error").removeClass("hide").addClass("ok");
                    } else {
                        input.parent().removeClass("has-succes").addClass("has-error");
                        input.next('.komunikat').text("Wprowadź poprawny email!").removeClass("ok").removeClass("hide").addClass("error");
                    }
                });
                
                //Po próbie wysłania formularza rejsetracji 
		$('#button-r').click(function(event){
                        var button = $(this);
			var name = $('#name-r');
			var email = $('#email-r');
			
			if(name.parent().hasClass('has-success') && email.parent().hasClass('has-success')){	
			}
			else {
				event.preventDefault();
				button.next('.komunikat').text("Uzupełnij wszystkie pola!").removeClass("ok").removeClass("hide").addClass("error");	
			}
		});

            });
        </script>   

    </body>
</html>
