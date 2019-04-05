jQuery(document).ready(function ($) {

    function meaUpdateHeader(newText){
        $('.aim-header h3').text(newText);
    }

    function meaUpdateAim(html){
        $('#aim-body').html(html);
    }

    function meaCreateModal(html)

    $('#aim-body').on('keyup', 'input[name = username]', function() {
        if($(this).val() != ''){
            $('input[name=password]').prop('disabled', false);
        } else {
            $('input[name=password]').prop('disabled', true);
        }
    });

    $('#aim-body').on('keyup', 'input[name = password]', function () {
        var root = $('#sign-on-image').data('root');
        if ($(this).val() != '') {
            $('#sign-on-image').attr('src', root + 'green-guy.png');
        } else {
            $('#sign-on-image').attr('src', root + 'empty-guy.png');
        }
    });

});