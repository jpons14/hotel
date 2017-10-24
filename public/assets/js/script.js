$(document).ready(function () {
  $.each($('.nav-link'), function (k,v) {
     if ($(v).text() == $.cookie('current')){
       $(v).addClass('active');
     } else{
       $(v).removeClass('active');
     }
  });
  $('.datepicker').datepicker();

  $('select').on('change', function () {
      $("form.by").submit();
  });

  $('a').on('click', function () {
    $.cookie('current', $(this).text());
  });

});