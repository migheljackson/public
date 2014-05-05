<!--
@name RequestPasswordResetPage
@description Page for the Direct Sign up into COL
-->
<section class="step" data-step-title="step-recover-password-1">
<div class="sign-up-page">
    <div class="row">
        <div class="small-12 large-centered large-9 columns">
            <h2 class="text-center">Forgot Password</h2>
            <hr>
            <h4 class="text-center">Tell us who you are</h4>
            <div class="small-12 large-centered large-6 columns">
            <form id="request_password_reset" action="start-reset-password">
                <span style="display:none" id="error_pw_reset_username" class="error_message"></span>
            <label for="email">
                <input id="pw_reset_username" name="username" type="text" placeholder="Enter E-Mail address or user name">
            </label>
            <div class="row">
            <div class="small-12 large-12 columns">
            <input type="submit" class="button small expand radius next-step" value="Next step"/>
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

    $("#request_password_reset").validity(function(){
        $("#pw_reset_username").require("Oops, you have to tell us your username or email address.");
    });
});

</script>