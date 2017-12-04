<br />
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-3">Start Date: <span class="start_date">[[ start_date ]]</span></h1>
        <h1 class="display-3">End Date: <span class="end_date">[[ end_date ]]</span></h1>
        <h1 class="display-3">Price: <span class="price"></span></h1>
    </div>
</div>
<div class="container">
    <form method="POST" action="[[ formAction ]]/bookings/update?id=[[ id ]]">
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input name="start_date" value="[[ start_date ]]" required="required" class="form-control datepicker" type="text" id="start_date"/>
        </div>
        <div class="form-group">
            <label for="end_date">End date</label>
            <input name="end_date" value="[[ end_date ]]" required="required" class="form-control datepicker" type="text" id="end_date"/>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-default submit-edit" value="Reserve"/>
        </div>
    </form>
</div>
<script src="[[ formAction ]]/public/assets/js/script.js"></script>