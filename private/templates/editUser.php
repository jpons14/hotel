<div class="container">
    <img src="[[ img ]]" alt=" [[ name ]] image" class="img-responsive center-block" />
    <hr />
    <form action="[[ formAction ]]/users/update" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Name" name="name" value="[[ name ]]"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Address" name="address" value="[[ address ]]"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Phone" name="phone" value="[[ phone ]]"/>
        </div>
        <div class="form-group">
            <label for="userImage">User Image <small>Only "jpg" images</small></label>
            <input type="file" name="userImage" class="form-control" id="userImage">
        </div>
        <input class="btn btn-default" type="submit" value="Update user!"/>
    </form>
</div>
<script src="[[ formAction ]]/public/assets/js/script.js"></script>