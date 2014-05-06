<!--
@name Over13ResetPasswordPage
@description Page for the Direct Sign up into COL
-->

<style>
.step {
    position: absolute;
    height: 100%;
    width: 100%;
    display: none;
}

.selected_answer {
  border: 5px solid; 
  border-radius: 27px; 
  border-color: yellow; 
  background-color: yellow;
}
</style>
[[!fe_set_password_reset_parameters]]
<form id="reset_password_form" type="post" action="process-signup" class="form-horizontal" style="position:relative;min-height:600px;">
   <section class="step" data-step-title="step-4" style="">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Forgot Password</h2>
          <hr>
          <h4 class="text-center">Set a new Password</h4>
          <div class="small-12 large-centered large-6 columns">
            
            <span style="display:none" id="error_email_address" class="error_message"></span>
            <input type="hidden" name="forgotten_password_token" value="[[+forgotten_password_token]]" />
            <span style="display:none" id="error_username" class="error_message"></span>
            <label for="user">
              <input type="text" name="username" id="username" placeholder="User name" readonly value=[[+username]]>
            </label>
            <span style="display:none" id="error_password" class="error_message"></span>
            <label for="pass">
              <input type="password"  id="password" name="password" placeholder="Password">
            </label>
            <div class="row" style="">
              <div class="small-12 columns">
                <div class="progress small-12 large-7 columns radius">
                  <span id="score_meter" class="meter" style="width: 0%"></span>
                </div>
                <div class="small-12 large-5 columns">
                  <a id="generate_password" href="#" class="link generate">Generate password</a>
                </div>
              </div>
              <div class="row">
                <div class="small-12 columns">
                  <div class="small-4 large-2 columns">
                    <div class="switch tiny round">
                      <input id="z1" name="switch-z" value="show" type="radio">
                      <label for="z1" onclick=""></label>
                      <input id="z" name="switch-z" type="radio" value="hide" checked>
                      <label for="z" onclick=""></label>
                      
                      <span></span>
                    </div>
                  </div>
                  <div class="small-8 large-10 columns">
                    <p>Show password</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="small-12 columns">
                <a href="#" id="reset_password" class="button small expand radius next-step">Set Password</a>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>
  

  <section class="step" data-step-title="step-5" style="display:none;">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Forgot Password</h2>
          <hr>
          <h4 id="result_message" class="text-center"></h4>
          <div class="small-12 large-centered large-6 columns">
            
          
            
          </div>
        </div>
      </div>
    </div>
  </section>
</form>
<script type="text/javascript" src="assets/js/jquery.mask.js"></script>
<script type="text/javascript" src="assets/js/jquery.validity.js"></script>
<script type="text/javascript" src="assets/js/moment.js"></script>
<script type="text/javascript">
var over_13 = false;
var current_step = 1;
var go_to_step = function(step_num) {

  var $target = $('section[data-step-title="step-'+step_num+'"]'),
            $other = $target.siblings('.active');

        /*
        if (!$target.hasClass('active')) {
            $other.each(function(index, self) {
                var $this = $(this);
                $this.removeClass('active').animate({
                    left: $this.width(),
                }, 500);
            });

            $target.addClass('active').show().css({
                left: -($target.width())
            }).animate({
                left: 0
            }, 500);
        }
        */
        $other.fadeOut().removeClass('active');
        $target.fadeIn().addClass('active');
}

function scorePassword(pass) {
    var score = 0;
    if (!pass)
        return score;

    // award every unique letter until 5 repetitions
    var letters = new Object();
    for (var i=0; i<pass.length; i++) {
        letters[pass[i]] = (letters[pass[i]] || 0) + 1;
        score += 5.0 / letters[pass[i]];
    }

    // bonus points for mixing it up
    var variations = {
        digits: /\d/.test(pass),
        lower: /[a-z]/.test(pass),
        upper: /[A-Z]/.test(pass),
        nonWords: /\W/.test(pass),
    }

    variationCount = 0;
    for (var check in variations) {
        variationCount += (variations[check] == true) ? 1 : 0;
    }
    score += (variationCount - 1) * 10;

    return parseInt(score);
}

function generate_password()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!?()#-";

    for( var i=0; i < 8; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}


$(document).on("change", "#password", function(e){
  var score = scorePassword($(this).val());
  $("#score_meter").attr("style", "width: "+score+"%");
});

$(document).on("change", 'input[name="switch-z"]', function(e){
  if($('input[name="switch-z"]:checked').length>0) {
    if($('input[name="switch-z"]:checked').val()=="show") {
      $('#password').attr("type", "text");
    } else {
      $('#password').attr("type", "password");
    }
  }
});
$(document).on("click", "#reset_password", function(e) {
  e.preventDefault();
  $.validity.start();
  $('#username').require("You need to create your username to continue.");
  $('#password').require("You need to set a password for your account.");

  var result = $.validity.end();
  if (result.valid) {
    // post form via ajax
    $.ajax({
      type: "POST",
      data: $("#reset_password_form").serialize(),
      url: "fe-do-reset-password",
      success: function(data) {
        var json = JSON.parse(data);

        // console.log(json.status);
        

        if (json.status == 200 || json.status == 201) {
          $('#result_message').text("Your new password has been set. We are redirecting you to your profile page.");
          go_to_step(5);
          window.setTimeout(function() {
            window.location = "my-profile";
          }, 5000);

        } else {
          if (json.status == 400 || json.status == 404) {
            $('#result_message').text(json.errors[0]);
            go_to_step(5);
          } else {
            console.log(json.errors + " " + json.result);
            alert("There was an error trying to create your account. Please try again in a moment.");
          }
        }
      },
      error: function(data) {
        var json = JSON.parse(data);
        console.log(json.errors + " " + json.result);
        alert("There was an error trying to create your account. Please try again in a moment.");

      }
    });
  }

  return false;
});

$(document).on("click", "#generate_password", function(e){
  e.preventDefault();
  $('input[name="switch-z"]').removeAttr("checked");
  $('#z1').prop("checked", true);
  $('#password').val(generate_password()).trigger("change");
  $('input[name="switch-z"]').trigger("change");
  return false;
});

</script>
<div class="clearfix"></div>