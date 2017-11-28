<br />
<div class="container">
    <div class="text-center">
    <h1>Edit RoomType [[ name ]]</h1>
    </div>
</div>
<div class="container">
    <form action="[[ formAction ]]/roomTypes/update?id=[[ id ]]" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Name" name="name" value="[[ name ]]"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Price" name="price" value="[[ price ]]"/>
        </div>
        <input class="btn btn-default" type="submit" value="Update Room Type!"/>
    </form>
</div>
<script src="[[ formAction ]]/public/assets/js/script.js"></script>