<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-3">Start Date: <span class="start_date">[[ startDate ]]</span></h1>
        <h1 class="display-3">End Date: <span class="end_date">[[ endDate ]]</span></h1>
        <h1 class="display-3">Room type: <span class="end_date">[[ roomType ]]</span></h1>
        <h1 class="display-3">Price: <span class="end_date">[[ price ]]€</span></h1>
    </div>
</div>
<div class="container">
    <form action="[[ formAction ]]/bookings/sendMails" method="post">
        <div class="form-group">
            <select class="js-example-basic-multiple form-control" name="states[]" multiple="multiple">
                <option value="AL">Alabama</option>
                <option value="ALI">Alabama2</option>
                <option value="WY">Wyoming</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="dni" class="form-control" placeholder="DNI"/>
        </div>
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="E-email"/>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Confirm"/>
        </div>
    </form>
</div>
<script>
    var url = window.location.href;
    url = url.split('?')[1];
    $('form').attr('action', $('form').attr('action') + '?' + url);


    var sampleArray = [{id: 0, text: 'enhancement'}, {id: 1, text: 'bug'}
        , {id: 2, text: 'duplicate'}, {id: 3, text: 'invalid'}
        , {id: 4, text: 'wontfix'}];

    $(document).ready(function () {
        $('.js-example-basic-multiple').select2({
            autoclose: true,
            maximumSelectionLength: 2,
            data: sampleArray
        });
    });
</script>