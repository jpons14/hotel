<br />
<div class="container">
    <form action="[[ formAction ]]/bookings/by" class="by" method="post">
        <div class="row">
            <div class="form-group">
                <div class="col-md-9">
                    <input class="form-control" type="text" name="textSearcher" placeholder="What to search 0"/>
                </div>
            </div>

        </div>
    </form>
</div>
<script>
    var paterns = '[[ patterns ]]';
    $('input[name=textSearcher]').on('keyup', function () {
        console.log($(this).val());
    });
</script>