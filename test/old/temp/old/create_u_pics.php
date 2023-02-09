<script>

$(document).ready(function () {
    var i = 1;
    $('#add_pic').click(function ($click) {

            console.log('Creating pic' + i);
            $('#input_pic').append(
                '<div id="drop_zone'+i+'" class="drop_zone" style="width:200px; display:inline-block; margin-right:25px;">'+
                    '<span class="input-group-btn">' +
                    '<button style="height:3rem; margin-top:1.5rem;" type="button" name="remove" id="' + i + '" class="btn btn-danger pic_remove"><?php echo $lang["delete"];?></button>' +
                    '</span>' +
                    '<p>Click or drag and drop an image, video, or audio file ...</p>'+
                    '<input type="file" name="myFile" accept="audio/*,video/*,image/*" id="media'+i+'">'+
                    '<div id="preview'+i+'" class="preview"></div>'+
                '</div>');
    i++;
    });

    $(document).on('click', '.pic_remove', function () {
        //localStorage.setItem(createUpdate+'childItemCount', ((localStorage.getItem(createUpdate+'childItemCount'))-1));
        var button_id = $(this).attr("id");
        removalId = 'drop_zone' + button_id;
        $('#drop_zone' + button_id).fadeOut(150);
        setTimeout(function () { $('#drop_zone' + button_id).remove(); }, 150);
    });


});
</script>