<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-3">Start Date: <span class="start_date">[[ startDate ]]</span></h1>
        <h1 class="display-3">End Date: <span class="end_date">[[ endDate ]]</span></h1>
        <h1 class="display-3">Room type: <span class="end_date">[[ roomType ]]</span></h1>
        <h1 class="display-3">Price: <span class="end_date">[[ price ]]€</span></h1>
    </div>
</div>
<form action="[[ formAction ]]/bookings/sendMails" method="post">
    <div class="form-group">
        <input type="text" name="dni" class="from-control" placeholder="DNI"/>
    </div>
    <div class="form-group">
        <input type="email" name="email" class="from-control" placeholder="E-email"/>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-default" value="Confirm"/>
    </div>
</form>

<script>
    var url = window.location.href;
    url = url.split('?')[1];
    $('form').attr('action', $('form').attr('action') + '?' + url);
</script>