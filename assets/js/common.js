$(document).on('submit', '#form_signin', function(e) {
    e.preventDefault();
    $.validity.start();
    $('#signin_username').require("Please enter in your username");
    $('#signin_password').require("Please enter in your password");
    var result = $.validity.end();

    if (result.valid) {
        $.ajax({
            type: "POST",
            data: $("#form_signin").serialize(),
            url: $("#form_signin").attr("action"),
            success: function(data) {
                var json = JSON.parse(data);
                if (json.status == 200 || json.status == 201) {
                    var redirect_to = "/my-profile";
                    var o_redirect = $.getUrlVar("r");
                    if (o_redirect && o_redirect !== undefined && o_redirect.length > 0) {
                        redirect_to = o_redirect;
                    }
                    window.location = redirect_to;
                } else {
                    $('#error_signin_username').text(json.errors).show();
                }
            }
        });
    }
    return false;
});

$.extend({
    getUrlVars: function() {
        var vars = [],
            hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    },
    getUrlVar: function(name) {
        return $.getUrlVars()[name];
    }
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
    $('#login a').click(function() {
        $('#signup-pop').slideToggle('fast');
        $(this).toggleClass('button');
    });

});