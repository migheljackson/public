$(document).on('submit', '#form_signin', function(e) {
    e.preventDefault();
    $.validity.start();
    $('#username').require("Please enter in your username");
    $('#password').require("Please enter in your password");
    var result = $.validity.end();

    if (result.valid) {
        $.ajax({
            type: "POST",
            data: $("#form_signin").serialize(),
            url: $("#form_signin").attr("action"),
            success: function(data) {
                var json = JSON.parse(data);

                console.log(json.status);

                if (json.status == 200 || json.status == 201) {
                    window.location = 'my-profile';
                } else {
                    $('#error_username').text(json.errors).show();
                }
            }
        });
    }
    return false;
});
$(document).ready(function() {

    // We'll decide to install our custom output mode under the name 'custom':
    $.validity.outputs.field_fill = {

        // In this case, the start function will just reset the inputs:
        start: function() {
            $('.fail').removeClass('fail');
            $('.error_message').hide();
        },

        end: function(results) {

        },

        // Our raise function will display the error and animate the text-box:
        raise: function($obj, msg) {

            $('#error_' + $obj.attr("id")).text(msg).show();

            // Animate the border of the text box:
            $obj.addClass('fail');

        },

        // Our aggregate raise will just raise the error on the last input:
        raiseAggregate: function($obj, msg) {

            this.raise($($obj.get($obj.length - 1)), msg);

        }
    };

    $.validity.setup({
        outputMode: "field_fill"
    });
    $('#sign_up a').click(function() {
        $('#signup-pop').slideToggle('fast');
    })

});