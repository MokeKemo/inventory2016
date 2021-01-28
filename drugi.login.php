<?php

session_start();

require_once 'includes/config.php';



$message = "";

$username = "";

//$lang = 'en';





if (isset($_POST['action'])) {

    switch ($_POST['action']) {

        case 'login':

            if (!empty($_POST['username']) && !empty($_POST['password'])) {

                $username = $_POST['username'];

                $password = $_POST['password'];

                $password = md5($password);

                //$lang = $_POST['selectLanguage'];



                if (Access::checkLogin($username, $password, $db)) {

                    $_SESSION['logged'] = true;

                    $_SESSION['username'] = $username;

                    //$_SESSION['lang'] = $lang;



                    header('Location: ' . BASE_URL);

                    exit;

                } else {

                    $message = "Wrong username / password";

                }

            } else {

                $message = "You must fill out both username and password";

            }



            break;

    }

}



if (isset($_GET['action'])) {

    switch ($_GET['action']) {

        case 'logout':

            $_SESSION['logged'] = false;

            $_SESSION = array();

            session_destroy();



            header('Location: ' . BASE_URL . 'login.php?action=bye');

            exit;

            break;



        case 'bye':

            $message = "You have successfully logged out";

            break;

    }

}



if (Access::isLoggedIn()) {

    header('Location: ' . BASE_URL);

    exit;

}



?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8">

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

        <title>Log In</title>

    </head>



    <body>
    <script>


        function statusChangeCallback(response) {
            console.log('statusChangeCallback');
            console.log(response);
            // The response object is returned with a status field that lets the
            // app know the current login status of the person.
            // Full docs on the response object can be found in the documentation
            // for FB.getLoginStatus().
            if (response.status === 'connected') {
                // Logged into your app and Facebook.

                testAPI();
            } else if (response.status === 'not_authorized') {
                // The person is logged into Facebook, but not your app.
                document.getElementById('status').innerHTML = 'Please log ' +
                    'into this app.';
            } else {
                // The person is not logged into Facebook, so we're not sure if
                // they are logged into this app or not.
                document.getElementById('status').innerHTML = 'Please log ' +
                    'into Facebook.';
            }
        }

        // This function is called when someone finishes with the Login
        // Button.  See the onlogin handler attached to it in the sample
        // code below.
        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        }

        window.fbAsyncInit = function() {
            FB.init({
                appId      : '474124136110135',
                cookie     : true,  // enable cookies to allow the server to access
                                    // the session
                xfbml      : true,  // parse social plugins on this page
                version    : 'v2.2' // use version 2.2
            });

            // Now that we've initialized the JavaScript SDK, we call
            // FB.getLoginStatus().  This function gets the state of the
            // person visiting this page and can return one of three states to
            // the callback you provide.  They can be:
            //
            // 1. Logged into your app ('connected')
            // 2. Logged into Facebook, but not your app ('not_authorized')
            // 3. Not logged into Facebook and can't tell if they are logged into
            //    your app or not.
            //
            // These three cases are handled in the callback function.

            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });

        };

        // Load the SDK asynchronously
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        // Here we run a very simple test of the Graph API after login is
        // successful.  See statusChangeCallback() for when this call is made.
        function testAPI() {
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me', function(response) {
                console.log('Successful login for: ' + response.name);
                var podaci = {};
                podaci['name']=response.name;
                podaci['action']='GetSession';
                $.ajax({

                    url:"settings/adapter.php",

                    type:"POST",

                    dataType:"JSON",

                    data:podaci,

                    async: true,

                    success:function(data){

                        if(data)

                        {

                            window.location.href="http://www.devinfpoint.com/inventory/index.php";

                        }

                    }

                });
            });
        }

</script>


    <p>For testing purposes try username: <b>mitarmiric</b> password: <b>korisnik</b></p>



    <div><?= $message ?></div>



    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">

        <p>

            <!--select id="selectLanguage" name="selectLanguage">

                <option value="en">English</option>

                <option value="bhs">BHS</option>

            </select-->

        </p>

        <p>

            <label for="username">Username:</label>

            <input type="text" name="username" id="username" value="<?= $username ?>">

        </p>

        <p>

            <label for="password">Password:</label>

            <input type="password" name="password" id="password">

        </p>

        <p>

            <input type="hidden" name="action" value="login">

            <input type="submit" value="Log In">

        <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>

        </p>





    </form>



    </body>



</html>