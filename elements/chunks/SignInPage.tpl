<!--
@name SignInPage
@description Page for the Direct Sign up into COL
-->
[[!fe_get_username_parameter]]
<section class="step" data-step-title="step-1">
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
                    window.location = 'my-profile';
                } else {
                    $('#error_dsignin_username').text(json.errors).show();
                }
            }
        });
    }
    return false;
});
</script>