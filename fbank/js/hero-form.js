// JavaScript Document

$(document).ready(function() {
    "use strict";

    $(".contact_us").submit(function(e) {
        e.preventDefault();
        var dataString = "FullName=" + $(".FullName").val() + "&PhoneNumber=" + $(".PhoneNumber").val() +
            "&locationcus=" + $(".locationcus").val() + "&Addresscus=" + $(".Addresscus").val() +
            "&City=" + $(".City").val() + "&Customer=" + $(".Customer").val() +
            "&Messagecus=" + $(".Messagecus").val();

        $.ajax({
            type: "POST",
            // url: "process_contact_form.php",
            data: dataString,
            cache: false,
            beforeSend: function() {
                $("input.submit").fadeIn("slow").val("Sending Request, please wait...");
                $("button.submit").attr("disabled", "disabled");
            },
            success: function(d) {
                $('span#request_msg').fadeIn('slow').html(d);
                $("input.submit").fadeIn("slow").val("Send Message");
                $("input.submit").removeAttr("disabled");
            }
        });
        return false;
    });
});

$('span#request_msg').fadeIn('slow').delay(400).fadeOut('slow');