<div id="messages"></div>
<script>
    var websocket;
    function addmsg(type, msg) {
        /* Simple helper to add a div.
        type is the name of a CSS class (old/new/error).
        msg is the contents of the div */
//        $("#messages").html(
//            "<div class='msg "+ type +"'>"+ msg +"</div>"
//        );
        $.each(msg, function (k, v) {
            var tableRow = $("td").filter(function () {
                return $(this).text() == v[0];
            }).closest("tr");
            tableRow.children('td').each(function (key) {
                if (key == 1)
                    $(this).text(v[1]);
                if (key == 2)
                    $(this).text(v[2]);
                if (key == 3)
                    $(this).text(v[3]);
            });
        });
    }


    websocket = new WebSocket("ws://hotel.dev[[ formAction ]]/APIBookings/index");

    console.log(websocket);



    function waitForMsg() {
        /* This requests the url "msgsrv.php"
        When it complete (or errors)*/
        $.ajax({
            type: "GET",
            url: "[[ formAction ]]/APIBookings/index",

            async: true, /* If set to non-async, browser shows page as "Loading.."*/
            cache: false,
            timeout: 50000, /* Timeout in ms */

            success: function (data) { /* called when request to barge.php completes */
                addmsg("new", data);
                /* Add response to a .msg div (with the "new" class)*/
                setTimeout(
                    waitForMsg, /* Request next message */
                    1000 /* ..after 1 seconds */
                );
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                addmsg("error", textStatus + " (" + errorThrown + ")");
                setTimeout(
                    waitForMsg, /* Try again after.. */
                    15000);
                /* milliseconds (15seconds) */
            }
        });
    };

    $(document).ready(function () {
        waitForMsg();
        /* Start the inital request */
    });
</script>