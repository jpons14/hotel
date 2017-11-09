<br/>
<div class="container">
    <form action="[[ formAction ]]/rooms/update?id=[[ id ]]" method="POST">
        <div class="form-group">
            <input required="required" class="form-control" type="text" placeholder="Name" name="name"
                   value="[[ name ]]"/>
        </div>
        <div class="form-group">
            <select class="form-control" name="fk_roomtypes_id_name" id="roomType" required="required">
                <option value="" selected disabled>Select a room type</option>
            </select>
        </div>
        <div class="form-group">
            <input required="required" class="form-control" value="[[ adults_max_number ]]" type="number"
                   id="adults_max_num" name="adults_max_number" placeholder="Adults Max Number"/>
        </div>
        <div class="form-group">
            <input required="required" class="form-control" type="number" value="[[ children_max_number ]]"
                   id="children_max_num" name="children_max_number" placeholder="Children Max Number"/>
        </div>
        <input class="btn btn-default" type="submit" value="Update Room"/>
    </form>
</div>
<script>
    $.getJSON('[[ formAction ]]/APIRoomsTypes/index', function (data) {
        var id = [[id]];
        var html = '';
        var roomTypeSelected = '[[ roomTypeSelected ]]';

        $.each(data, function (k, v) {
            if (v[0] == roomTypeSelected)
                html += '<option selected="selected" value="' + v[0] + '">' + v[1] + '</option>';
            else
                html += '<option value="' + v[0] + '">' + v[1] + '</option>';
        });
        $('[name=fk_roomtypes_id_name]').append(html);
    })
</script>