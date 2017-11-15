<script>
    $(document).ready(function () {
        var start_date = $('.start_date').text();
        var end_date = $('.end_date').text();
        var initial_url = $('a.reserve').attr('href');
        initial_url += '&start_date=' + start_date + '&end_date=' + end_date;
        $('a.reserve').attr('href', initial_url);
    });
</script>