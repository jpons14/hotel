<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

</head>
<body>

<div class="container">
<h1>Login</h1>
<form action="[[ formAction ]]/users/doLogin" method="POST">
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
<a href="[[ formAction ]]/users/register">Register</a>
</div>
</body>
</html>