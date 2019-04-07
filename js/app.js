jQuery(document).ready(function ($) {

    var root = "/wp-content/themes/noveltyshoe"; //set the root for portability

    //setup the tones
    var sent = document.createElement('audio');
    sent.setAttribute('src', root + '/audio/imsend.wav');

    var received = document.createElement('audio');
    received.setAttribute('src', root + '/audio/received.mp3');


    function meaUpdateHeader(newText){
        $('.aim-header h3').text(newText);
    }

    function meaUpdateAim(html){
        $('#aim-body').html(html);
    }

    function meaCreateModal(html, title = 'Alert', type = 'error'){

        var theAlert = $('#modal-template').clone();
        $(theAlert).appendTo('body');

        //setup the image
        image = root + "/img";
        if(type == 'info'){
            image += "/help.png";
        } else {
            image += "/error.png";
        }

        theAlert.find('img').attr('src', image);
        theAlert.find('.modal-text').html(html);
        theAlert.find('.aim-header h3').text(title);

        theAlert.removeClass('template');
        // $('body').prepend("<div class='modal'><div class='aim-header light-blue-background'><h3>" + title + "</h3></div><div class='flex modal-content align-center'><div class='modal-image'>" + image + "</div><div class='modal-text'>" + html + "</div></div><div><button class='alert-button'>OK</button></div></div>");
    }

    function meaBuddyList() {
        var buddyList = $('.buddy-list').clone();
        $('#aim-content').html(buddyList);
    }

    //Set a bunch of globals...
    var i = 0;
    var messages = new Array();
    var length = 0;

    function meaDoChat(response) {
        length = response.length;
        messages = $.parseJSON(response);
        console.log(messages);
        i = 0;
        var seen = 0;
        if(typeof messages[1] !== 'undefined' && messages[1].length > 0){
            $.each(messages[1], function() {
                var senderClass = "me";
                if (messages[1][seen].sender != 'Purposefull7') {
                    senderClass = "friend";
                }
                $('.chat-screen').append("<p data-answer='" + messages[1][seen].answer + "'><span class='" + senderClass +"'>" + messages[1][seen].sender + ":</span> " + messages[1][seen].message + "</p>");
                
                seen++;
            });
            $('.send-message').attr('disabled', false);
            $('#active-chat .chat-screen').scrollTop($('#active-chat .chat-screen')[0].scrollHeight);
        } else {
            meaChatDelay();
        }


    }

    function meaChatDelay(){
        setTimeout(function() {
            var senderClass = "me";
            if(messages[0][i].sender != 'Purposefull7'){
                senderClass = "friend";
                received.play();
            } else {
                sent.play();
            }
            $('.chat-screen').append("<p data-answer='" + messages[0][i].answer + "'><span class='" + senderClass +"'>" + messages[0][i].sender + ":</span> " + messages[0][i].message + "</p>");
            $.ajax({
                url: novelty.ajaxurl,
                dataType: 'text',
                method: 'POST',
                data: {
                    action: 'novelty_update_seen',
                    post: messages[0][i].post,
                },
                type: 'POST',
                success: function (response) {
                    console.log(response);
                }
            });
            $('#active-chat .chat-screen').scrollTop($('#active-chat .chat-screen')[0].scrollHeight);
            i++;
            console.log(messages);
            if(messages[0][i-1].clue == '1'){
                $('.send-message').attr('disabled', false);
                return;
            } else if(--length){
                meaChatDelay();
            }
        }, messages[0][i].delay);
    }

    //Triggers

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
            $('#sign-on-image').attr('src', root + 'green-guy.png').addClass('active');
        } else {
            $('#sign-on-image').attr('src', root + 'empty-guy.png').removeClass('active');
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
        $(this).parents('.modal').remove();
    });

    $('body').on('click', '#sign-on-image.active', function() {
        
        var username = $('#username').val();
        var password = $('#password').val();
        var response = '';

        if(username != 'purposefull7'){
            response = "Your username is incorrect";
        } else if (password != '123') {
            response = "That password sucks.";
        } else {
            meaBuddyList();
            return;
        }
        
        meaCreateModal(response);
    });

    $('#aim-body').on('click', '.buddy-list .tabs li', function() {

        var target = $(this).data('target');
        $('.list').removeClass('active');
        $("." + target).addClass('active');

        $('.buddy-list .tabs li').removeClass('active-tab');
        $(this).addClass('active-tab');
    });

    $('#aim-body').on('click', '.categories li', function() {
        $(this).find('.drilldown').toggleClass('drilldown-open');
        $(this).find('.buddy-list-members').slideToggle();
    });

    $('#aim-body').on('click', '.buddy-list-members li', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var chat = $('#chat-window').clone();
        chat.find('.aim-header h3').text($(this).data('user'));
        chat.attr('id', 'active-chat');
        chat.prependTo('body');

        $.ajax({
            url: novelty.ajaxurl,
            dataType: 'text',
            method: 'POST',
            data: {
                action: 'novelty_feed',
            },
            type: 'POST',
            success: function (response) {
                meaDoChat(response);
            }
        });
    });

    $('body').on('click', '.aim-send', function() {
        var answer = $('#active-chat p:last-child').data('answer');
        var guess = $('#active-chat textarea').val();
        console.log(answer + " " + guess);
        if(guess == answer){
            $('#active-chat textarea').val('').attr('disabled','disabled');
            meaChatDelay(messages, i, length);
        } else {
            meaCreateModal('WRONG!');
        }
    });

});

function resetSeen(){
    jQuery.ajax({
        url: novelty.ajaxurl,
        dataType: 'text',
        method: 'POST',
        data: {
            action: 'novelty_reset_seen',
        },
        type: 'POST',
        success: function (response) {
            response = jQuery.parseJSON(response)
            console.log(response);
        }
    });
}