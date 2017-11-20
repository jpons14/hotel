<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="[[ formAction ]]/public/assets/css/style.css" />
    <link rel="stylesheet" href="[[ formAction ]]/public/assets/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css" />
    <script src="[[ formAction ]]/public/assets/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
<h1>Register</h1>
<form action="[[ formAction ]]/users/doRegister?message=[[ message ]]" method="POST">
    <div class="form-group">
        <input class="form-control" type="text" name="dni" placeholder="DNI">
    </div>
    <div class="form-group">
        <input class="form-control" type="text" name="name" placeholder="name">
    </div>
    <div class="form-group">
        <input class="form-control" type="email" name="email" placeholder="email">
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="password" placeholder="password">
    </div>
    <input class="btn btn-default" type="submit" value="Register User"/>
</form>
</div>
</body>
</html>