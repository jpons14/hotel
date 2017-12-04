
<!--<script src="[[ formAction ]]/public/assets/js/editBookingJS.js"></script>-->
<script>
    $(document).ready(function () {
        var sd = $('[name=start_date]');
        var ed = $('[name=end_date]');
        sd.on('change', function () {
            $('span.start_date').text($(this).val());
            updateData();
        });
        ed.on('change', function () {
            $('span.end_date').text($(this).val());
            updateData();
        });
        var roomType = '[[ roomType ]]';

        function updateData() {
            $.getJSON('[[ formAction ]]/APIBookings/calculatePrice?roomType=' + roomType + '&start_date=' + sd.val() + '&end_date=' + ed.val(), function (data) {
                if (data.number_rooms == 0) {
                    $('span.price').text('there are ' + data.number_rooms + ' rooms aviable');
                    // $('.submit-edit').hide();
                } else
                    $('span.price').text(data.price + "€");

            });
        }

        updateData();
    });
</script>