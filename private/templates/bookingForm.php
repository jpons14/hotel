<br />
<div class="container">
    <form method="POST" action="[[ formAction ]]/bookings/checkAvailableRooms">
        <div class="form-group">
            <label for="pickUp">Pick Up Date</label>
            <input name="pickUp" required class="form-control datepicker" type="text" id="pickUp"/>
        </div>
        <div class="form-group">
            <label for="pickOff">Pick Off Date</label>
            <input name="pickOff" required class="form-control datepicker" type="text" id="pickOff"/>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-default" value="Reserve"/>
        </div>
    </form>
</div>