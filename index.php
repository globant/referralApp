<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>POC</title>

        <link rel="stylesheet" href="/resources/css/custom.css" />
    </head>
    <body>
        <h1>Hello, world!</h1>
        <div id="login-btn">
            <span class="g-signin"
                data-scope="https://www.googleapis.com/auth/plus.login"
                data-clientid="229737568035-t0isieq89rkd65av2uvebo4iu2jrju43.apps.googleusercontent.com"
                data-redirecturi="postmessage"
                data-accesstype="offline"
                data-callback="signInCallback"
                data-cookiepolicy="single_host_origin">
            </span>
        </div>

        <a href="#" title="Log out!" id="logout-btn">Log out!</a>

        <script src="/resources/js/jquery-1.11.1.min.js"></script>
        <script src="https://apis.google.com/js/client:platform.js" async defer></script>
        <script src="/resources/js/custom.js"></script>
    </body>
</html>