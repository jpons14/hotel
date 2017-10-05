<div class="container">
    <h1>Create Users</h1>
    <form action="[[ formAction ]]/users/doRegister?from=createUser" method="POST">
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