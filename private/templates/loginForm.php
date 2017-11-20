<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="[[ formAction ]]/public/assets/css/style.css" />
    <link rel="stylesheet" href="[[ formAction ]]/public/assets/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css" />
    <script src="[[ formAction ]]/public/assets/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">
<h1>Login</h1>
<form action="[[ formAction ]]/users/doLogin?message=[[ message ]]" method="POST">
    <div class="form-group">
        <label for="email">Email</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="form-control" type="email" id="email" name="email" placeholder="email"/>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" id="password" placeholder="Password" name="password"/>
    </div>
    <input class="btn btn-default" type="submit" value="Login"/>
</form>
<a href="[[ formAction ]]/users/register?message=[[ message ]]">Register</a>
</div>
</body>
</html>