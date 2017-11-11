<br />
<div class="container">
    <form method="POST" action="[[ formAction ]]/bookings/checkAvailableRooms">
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input name="start_date" required class="form-control datepicker" type="text" id="start_date"/>
        </div>
        <div class="form-group">
            <label for="end_date">End date</label>
            <input name="end_date" required class="form-control datepicker" type="text" id="end_date"/>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-default" value="Reserve"/>
        </div>
    </form>
</div>