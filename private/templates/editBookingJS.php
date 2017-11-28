<!--<script src="[[ formAction ]]/public/assets/js/editBookingJS.js"></script>-->
<script>
    $(document).ready(function () {
        $('[name=start_date]').on('change', function () {
            $('span.start_date').text($(this).val());
        });
        $('[name=end_date]').on('change', function () {
            $('span.end_date').text($(this).val());
        });
        var roomType = '[[ roomType ]]';
//        $.getJSON('[[ formAction ]]/')
        alert(roomType);
    });
</script>