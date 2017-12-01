$(document).ready(function () {
    $.each($('.nav-link'), function (k, v) {
        if ($(v).text() == $.cookie('current')) {
            $(v).addClass('active');
        } else {
            $(v).removeClass('active');
        }
    });
    var forbidden = ['12/1/2017', '12/4/2017'];
    $('.datepicker').datepicker({
        beforeShowDay: function (Date) {

            // var date = new Date();
            var curr_day = Date.getDate();
            var curr_month = Date.getMonth() + 1;
            var curr_year = date.getFullYear();

            var curr_date = curr_month + '/' + curr_day + '/' + curr_year;
            if (forbidden.indexOf(curr_date) > -1) return false;
        },
        autoclose: true
    });

    $('select').on('change', function () {
        $("form.by").submit();
    });

    $('a').on('click', function () {
        $.cookie('current', $(this).text());
    });

    $('a').on('click', function () {
        3
    });

});
