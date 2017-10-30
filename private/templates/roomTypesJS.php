<script>

    $('#roomType3').load('hotel.dev/APIRoomsTypes/index', {passive: true},  function (data) {
        console.log('data = ', data);
    }.error(function (f) {
        console.log('f = ', f);
    }));

    $.getJSON('http://hotel.dev/APIRoomsTypes/index', function (data) {
        $.each(data, function (k, v) {
            $('#roomType2').append('<option value="' + v[1] + '">'+v [1] +'</option>')
        });
    })
</script>