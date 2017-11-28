$(document).ready(function () {
    // $('.delete').click(function (e) {
    //     e.preventDefault();
    //     alert('something');
    //     var that = this;
    //     $.confirm({
    //         title: 'Delete!',
    //         content: 'You will delete this room type!',
    //         buttons: {
    //             confirm: function () {
    //                 $.alert('Confirmed!');
    //
    //                 $(that).trigger('click');
    //             },
    //             cancel: function () {
    //                 $.alert('Canceled!');
    //             },
    //         }
    //     });
    // });
    $('.delete').confirm({
        buttons: {
            confirm: function () {
                location.href = this.$target.attr('href');
            },
            cancel: function () {
            }
        }
    })

});

