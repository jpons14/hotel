$(document).ready(function () {
  $('.datepicker').datepicker();

  $('select').on('change', function () {
      $("form.by").submit();
  });

});