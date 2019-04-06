jQuery(document).ready(function ($) {

    var root = "/wordpress/wp-content/themes/noveltyshoe";

    function meaUpdateHeader(newText){
        $('.aim-header h3').text(newText);
    }

    function meaUpdateAim(html){
        $('#aim-body').html(html);
    }

    function meaCreateModal(html, title = 'Alert', type = 'error'){
        
        image = "<img src='" + root + "/img";

        if(type == 'info'){
            image += "/help.png";
        } else {
            image += "/error.png";
        }

        image += "'>";

        $('body').prepend("<div class='modal'><div class='aim-header light-blue-background'><h3>" + title + "</h3></div><div class='flex modal-content'><div id='modal-image'>" + image + "</div><div id='modal-text'>" + html + "</div></div><div><button class='alert-button'>OK</button></div></div>");
    }

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

    $('#aim-body').on('click', '.modal-trigger', function(e) {
        e.preventDefault();
        var content = $(this).data('content');
        var type = $(this).data('type');
        var title = $(this).data('title');
        meaCreateModal(content, title, type);
    });

    $('body').on('click', '.alert-button', function() {
        $('.modal').remove();
    });

    $('body').on('click', '#sign-on-image.active', function() {
        meaCreateModal('That password is incorrect.');
    });

});