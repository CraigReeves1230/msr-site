
$(function(){

    var recipient_id = $("#user_messages").data("user-id");

    Echo.private(`new-pm.${recipient_id}`).listen('PrivateMessageSent', function(event){

        // variables needed
        var message_icon = $("#message_icon");
        var alert_message = $("#alert_message");
        var message_dropdown = $("#message-dropdown");
        var message_html = `<li class='message-preview'>
                    <a href="${event.link}"><div class='media'>
                    <span class='pull-left'><img class='media-object' height='35' src="${event.image}" alt=''>
                    </span><div class='media-body'><h5 class='media-heading'>
                    <strong>${event.author.name}</strong></h5><p class='small text-muted'>
                    <i class='fa fa-clock-o'></i> ${event.created_at}</p><p>${event.message}</p></div></div></a></li>`;

        // fade in alert
        alert_message.text("You have been sent a new private message from " + event.author.name + ".");
        alert_message.fadeIn(500);
        alert_message.removeProp("hidden").delay(4000);
        alert_message.fadeOut(500);

        // update dropdowns
        $(message_html).prependTo(message_dropdown);

        // update icon on top bar
        message_icon.css("color", "#50D4FD");

    });

});









