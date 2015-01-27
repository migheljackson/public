<!--
@name SignInPage
@description Page for the Direct Sign up into COL
-->
[[!fe_get_username_parameter]]
[[!fe_do_iremix_signout]]
<section class="step" data-step-title="step-1" style="display:block">
<div class="sign-up-page">
    <div class="row">
        <div class="small-12 large-centered large-9 columns">
            <h2 class="text-center">Sign In</h2>
            <hr>
            <h4 class="text-center">Enter your credentials</h4>
            <div class="small-12 large-centered large-6 columns">
            <form action="[[fe_get_signin_url]]" id="direct_signin">
            <label for="name">
            <span id="error_dsignin_username"  class="error_message"  style="display:none;"></span>
                <input type="text" id="dsignin_username" name="username" placeholder="username" value="[[+username]]">
            </label>
            <label for="password">
            <span id="error_dsignin_password" class="error_message" style="display:none;"></span>
                <input id="dsignin_password" name="password" type="password" placeholder="Password">
            </label>            
            <div class="row">
            <div class="small-12 large-12 columns">
                <input type="submit" class="button small expand radius next-step" value="Log in" /><br><br>
                <div class="small-12 large-12 columns text-center">
                    <a id="sign_up_link" href="/sign-up" class="link text-center" title="new">I don't have an account</a>
                </div>
                <div class="small-6 columns">
                    <a href="forgotten-password" class="link text-center">forgot your password?</a>
                </div>
                <div class="small-6 columns">
                    <a href="forgotten-username" class="link text-center">forgot your username?</a>
                </div>
     
            </div>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>
</section>

<script type="text/javascript">
$(function(){
    var o_redirect = $.getUrlVar("r");
    if (o_redirect && o_redirect !== undefined && o_redirect.length > 0) {
        var href = $('#sign_up_link').attr("href") + "?r=" + o_redirect;
        $('#sign_up_link').attr("href", href); 
    }
});
$(document).on('submit', '#direct_signin', function(e) {
    e.preventDefault();
    $.validity.start();
    $('#dsignin_username').require("Please enter in your username");
    $('#dsignin_password').require("Please enter in your password");
    var result = $.validity.end();

    if (result.valid) {
        $.ajax({
            type: "POST",
            data: $("#direct_signin").serialize(),
            url: $("#direct_signin").attr("action"),
            success: function(data) {
                var json = JSON.parse(data);

                console.log(json.status);

                if (json.status == 200 || json.status == 201) {
                    var redirect_to = "/my-profile";

                    var o_redirect = $.getUrlVar("r");
                    if (o_redirect && o_redirect !== undefined && o_redirect.length > 0) {
                        redirect_to = decodeURIComponent(o_redirect);
                    }


                    window.location = redirect_to;
                } else {
                    $('#error_dsignin_username').text(json.errors).show();
                }
            }
        });
    }
    return false;
});
</script>
