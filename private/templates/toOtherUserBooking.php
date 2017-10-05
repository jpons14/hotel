<div class="container">
<form action="[[ formAction ]]/bookings/bookToOther" method="post">
    <div class="form-group">
        <input type="text" class="form-control" name="userEmail" placeholder="User Email" />
    </div>
    <div class="form-group">
        <input type="text" name="bookId" class="form-control" placeholder="Book ID" />
    </div>

    <div class="form-group">
        <label for="pickUp">Pick Up Date</label>
        <input name="pickUp" required class="form-control datepicker" type="text" id="pickUp"/>
    </div>
    <input type="submit" value="Book" class="btn btn-default" />
</form>
</div>