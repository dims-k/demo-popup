jQuery(document).ready(function($) {
    $('.upload_button').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var id = button.prev('input').attr('id');
        var custom_uploader = wp.media({
            title: 'Select Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#' + id).val(attachment.url);
            button.nextAll('img').remove();
            button.nextAll('.remove_button').remove();
            button.after('<img src="' + attachment.url + '" style="max-width:100px; display:block; margin-top:10px;">');
            button.after('<button class="remove_button button">Remove Image</button>');
        }).open();
    });

    $('body').on('click', '.remove_button', function(e) {
        e.preventDefault();
        var button = $(this);
        var id = button.prevAll('input').attr('id');
        $('#' + id).val('');
        button.prevAll('img').remove();
        button.remove();
    });
});
