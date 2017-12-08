<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-3">Start Date: <span class="start_date">[[ startDate ]]</span></h1>
        <h1 class="display-3">End Date: <span class="end_date">[[ endDate ]]</span></h1>
        <h1 class="display-3">Room type: <span class="room_type">[[ roomType ]]</span></h1>
        <h1 class="display-3">Price: <span class="price">[[ price ]]€</span></h1>
        <h1 class="display-4">Price Additional Services: <span class="price_additional_services"></span></h1>
    </div>
</div>
<div class="container">
    <form action="[[ formAction ]]/bookings/sendMails" method="post">
        <div class="form-group">
            <select class="select-additional-services js-example-basic-multiple form-control" name="additional_services[]"
                    multiple="multiple">
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


    var d = '';
    var result = '';
    var price = 0;

    $(document).ready(function () {
        $.ajax({
            url: '[[ formAction ]]/APIAdditionalServices/index',
            async: true,
            success: function (data) {
                console.log('success', data);
                result = $.map(data, function (value, index) {
                    return [value];
                });
                $('.js-example-basic-multiple').select2({
                    data: result,
                });
            },
            error: function (errData) {
                console.log('error', errData);
            }
        });
        $('select').on('change', function () {
            var ids = $('.js-example-basic-multiple').val();
            var tmpPrice = 0;
            $.each(ids, function (key, val) {
                tmpPrice += parseInt(result[val - 1].price);
            });
            price = tmpPrice;
            $('.price_additional_services').text(price + '€');
        });
    });
</script>