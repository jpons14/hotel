<script>
    $.getJSON('http://hotel.dev/APIRoomsTypes/index', function (data) {
        $.each(data, function (k, v) {
            $('#roomType').append('<option value="' + v[0] + '">'+v [1] +'</option>');
        });
    })
</script>