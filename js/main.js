$(document).ready(function(){
            
//    +------------------------------+
//    | 01. COUNTER - COMMENTS.PHP   |
//    +------------------------------+
    
    
    var commentCount = 0;
    var commentMax = 60;

    $('textarea#comment').on('keyup', function(){
       var commentCount = $(this)[0].value.length;

       if(commentCount > commentMax){
           $(this)[0].value = $(this)[0].value.substr(0,60);
           commentCount = commentMax;
       }

       $('span#commentCounter')[0].innerText = commentCount + "/" + commentMax;
    });
    
            
//    +------------------------------+
//    | 02. COUNTER - MAIN.PHP   |
//    +------------------------------+
    
    var tweetCount = 0;
    var tweetMax = 140;
    
    $('textarea#tweet').on('keyup', function(){
       var tweetCount = $(this)[0].value.length;
       
       if(tweetCount > tweetMax){
           $(this)[0].value = $(this)[0].value.substr(0,140);
           tweetCount = tweetMax;
       }
       $('span#tweetCounter')[0].innerText = tweetCount + "/" + tweetMax;
    });
    
//    +------------------------------+
//    | 03. SHOW BUTTON - MAIN.PHP   |
//    +------------------------------+    
    
    $('textarea#tweet').focus(function(){
        $('div#hideElement').removeClass("hide");
    });
    
    
//    +---------------------------------+
//    | 04. CHANGE DATA - PROFILE.PHP   |
//    +---------------------------------+
    // script showing form that allows user to change data.
    
    $('a#changeData').click(function(){
       var newForm = $("<form class='change-data-form' role='form' action='' method='POST'> <div class='form-group'> <label> Imię: </label> <input type='text' name='changeName' placeholder='Imię' class='form-control' id='change-name'> <label> E-mail</label> <input type='text' name='changeEmail' placeholder='E-mail' class='form-control' id='change-email'> </div class='form-group'> <button type='submit' class='btn btn-info'>Zmień dane</button> </form>");
       var insert = $('div#change-data-form');
       
       insert.append(newForm);
        $('a#changeData').off('click');
    });
   
        
    
    
    
    
});
