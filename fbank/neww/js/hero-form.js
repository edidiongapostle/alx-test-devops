// JavaScript Document

$(document).ready(function() {
    "use strict";

    $(".contact_us").submit(function(e) {
        e.preventDefault();
        var dataString = "full_name=" + $(".full_name").val() + "&country_location=" + $(".country_location").val() +
            "&email_address=" + $(".email_address").val() + "&phone_number=" + $(".phone_number").val() +
            "&address=" + $(".address").val() + "&city=" + $(".city").val() +
            "&customer=" + $(".customer").val() + "&message=" + $(".message").val();
            
        $.ajax({
            type: "POST",
            url: "process_contact_form.php",
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

$('span#request_msg').fadeIn('slow').delay(5000).fadeOut('slow');