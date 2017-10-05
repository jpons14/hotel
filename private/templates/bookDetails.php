<div class="container">
    <div class="jumbotron">
        <h1 class="display-3">[[ title ]]</h1>

        <hr />
        <p>[[ description ]]</p>
        <hr/>
        <p>Conservation: [[ conservation ]]</p>
        <ul>
            <li>Old: [[ old ]] days</li>
            <li>Normal: [[ normal ]] days</li>
            <li>New: [[ new ]] days</li>
        </ul>
        <hr />
        [[ buttonBookings ]]
        <hr />
        <div class="container">
            <form method="POST" action="[[ formAction ]]/bookings/booking?bookId=[[ id ]]">
                <div class="form-group">
                    <label for="pickUp">Pick Up Date</label>
                    <input name="pickUp" required class="form-control datepicker" type="text" id="pickUp"/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" value="Reserve"/>
                </div>
            </form>
        </div>
        <img src="[[ img ]]" alt="IMG"/>
    </div>
</div>
