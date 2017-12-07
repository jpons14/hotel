<br/>
<div class="container">
    <form action="[[ formAction ]]/bookings/by" class="by" method="post">
<!--        <div class="row">-->
            <div class="form-group">
<!--                <div class="col-md-9">-->
                    <input class="form-control" type="text" name="textSearcher" placeholder="What to search 0"/>
<!--                </div>-->
            </div>
<!--        </div>-->
        <input type="hidden" name="what">
    </form>
</div>
<div id="exampleModalLong" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Help</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>How to: <code>What you want to search:value you want to search</code></p>
                <p>Example: <code>start_date:01/18/2017</code></p>
            </div>
        </div>
    </div>
</div>
<script>
    var patternsString = '[[ patterns ]]';
    var patterns = patternsString.split(',');
    // $('input[name=textSearcher]').on('keyup', function () {
    //     var bool = patterns.includes($(this).val());
    //     if (bool) {
    //         $('input[name=what]').val($(this).val());
    //     }
    // });
    $('form.by').on('submit', function (e) {
        var key = $('[name=textSearcher]').val().split(':');
        var bool = patterns.includes(key[0]);
        if (key[0] === '')
            location.href = '[[ formAction ]]/bookings/index';
        else if (key[0] === '?'){
            console.log(key[0]);
            // $('#myModal').on('shown.bs.modal', function () {
                $('#exampleModalLong').modal('show');
            // });
        }

        if (key.length < 2 && key[1] == null)
            e.preventDefault();
        // e.preventDefault();
    });
</script>
