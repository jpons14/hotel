<div class="container">
<form action="[[ formAction ]]/bookings/by" class="by" method="post">
    <div class="row">
    <div class="form-group">
        <div class="col-md-9">
        <input class="form-control" type="text" name="text" placeholder="What to search 0"/>
        </div>
        <div class="col-md-3">
        <select class="form-control" name="what" id="what">
            <option value="selectOne" selected="selected" disabled="disabled">Select One</option>
            <option value="userEmail">User Email</option>
            <option value="bookId">Book ID</option>
            <option value="notReturned">Not Returned</option>
            <option value="todayReturn">Return Today</option>
        </select>
        </div>
    </div>
    </div>
</form>
</div>