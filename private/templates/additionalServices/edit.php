<br />
<div class="container">
    <form action="[[ formAction ]]/additionalServices/update?id=[[ id ]]" method="post">
        <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Name of the additional service" value="[[ name ]]" />
        </div>
        <div class="form-group">
            <input type="number" name="price" class="form-control" placeholder="Price of the additional service" value="[[ price ]]" />
        </div>
        <input type="submit" value="Update it!" class="btn btn-success" />
    </form>
</div>