<br/>
<div class="container">
    <form action="[[ formAction ]]/bookings/by" class="by" method="post">
        <div class="row">
            <div class="form-group">
                <div class="col-md-9">
                    <input class="form-control" type="text" name="textSearcher" placeholder="What to search 0"/>
                </div>
            </div>
        </div>
        <input type="hidden" name="what">
    </form>
</div>
<script>
    var s = '';
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
        console.log(key[1]);
        s = key[1];
        if (key.length < 2 && key[1] == null)
            e.preventDefault();
        // e.preventDefault();
    });
</script>