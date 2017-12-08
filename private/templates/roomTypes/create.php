<br/>
<div class="container">
    <div class="text-center">
        <h1>Create RoomType</h1>
    </div>
</div>
<div class="container">
    <form action="[[ formAction ]]/roomTypes/store" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Name" name="name"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Price" name="price"/>
        </div>
        <input class="btn btn-default" type="submit" value="Create Room Type!"/>
    </form>
</div>
<script src="[[ formAction ]]/public/assets/js/script.js"></script>