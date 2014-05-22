<!--
@name Under13ResetPassword
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
<form id="reset_password_form" type="post" action="process-signup" class="form-horizontal" style="position:relative;min-height:600px;">
  <section class="step active" data-step-title="step-1" style="display:block;">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Forgot Password</h2>
          <div class="steps">
            <ul>
              <li><a href="#" class="active">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              
            </ul>
          </div>
          <hr>
          <h4 class="text-center">Great! A few more questions</h4>
          <input type="hidden" name="username" value="[[+username]]" />
          <div class="small-12 large-centered large-6 columns">
            <span style="display:none" id="error_name" class="error_message"></span>
            <label for="name">
              <input name="full_name" id="name" type="text" placeholder="First & last name" >
            </label>
            <div class="row">
              <span style="display:none" id="error_birthdate" class="error_message"></span>
              <span style="display:none" id="error_birthmonth" class="error_message"></span>
              <span style="display:none" id="error_birthyear" class="error_message"></span>
              <span style="display:none" id="error_dob" class="error_message"></span>
              <div class="small-12 large-4 columns">
                <label for="birthmonth">
                  <select id="birthmonth" name="birthmonth" >
                    <option value=""> Select Month </option>
                     <option value="01">January</option>
                     <option value="02">February</option>
                     <option value="03">March</option>
                     <option value="04">April</option>
                     <option value="05">May</option>
                     <option value="06">June</option>
                     <option value="07">July</option>
                     <option value="08">August</option>
                     <option value="09">September</option>
                     <option value="10">October</option>
                     <option value="11">November</option>
                     <option value="12">Decemeber</option>
                  </select>
                </label>
              </div>
              <div class="small-12 large-4 columns">
                <label for="birthdate">
                  <select id="birthdate" name="birthdate">
                    <option value=""> Select Day </option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>                     
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option> 
                    <option value="20">20</option>                   
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                  </select>
                  <input type="hidden" name="dob" id="dob" />
                </label>
              </div>
              <div class="small-12 large-4 columns">
                <label for="year">
                  <select id="birthyear" name="birthyear" >
                    <option value=""> Select Year </option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
                    <option value="1994">1994</option>
                    <option value="1993">1993</option>
                    <option value="1992">1992</option>
                    <option value="1991">1991</option>
                    <option value="1990">1990</option>
                    <option value="1989">1989</option>
                    
                  </select>
                </label>
              </div>
            </div>
            
            <div class="row">
              <div class="small-12 large-12 columns">
                <a href="#" id="btn_step1" class="button small expand radius next-step">Continue</a><br><br>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      
    </div>
  </section>
  <section class="step" data-step-title="step-2" style="display:none;">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Forgot Password</h2>
          <div class="steps">
            <ul>
              <li><a href="#" class="back_to_step" data-rel="1">1</a></li>
              <li><a href="#" class="active">2</a></li>
              <li><a href="#">3</a></li>
              
            </ul>
          </div>
          <hr>
          <h4 class="text-center">Great! A few more questions</h4>
          <div class="small-12 large-centered large-6 columns">
            <span style="display:none" id="error_answers" class="error_message"></span>
            <input type="hidden" name="answers" id="answers" value="" />
            [[+security_questions]]
            <div class="row">
              <div class="small-12 large-12 columns">
                <a id="save_security_answers" href="#"  class="button small expand radius next-step">Continue</a>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="step" data-step-title="step-4" style="display:none;">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Forgot Password</h2>
          <div class="steps">
            <ul>
              <li><a href="#" class="back_to_step" data-rel="1">1</a></li>
              <li><a href="#" class="back_to_step optional" data-rel="2">2</a></li>
              <li><a href="#" class="active">3</a></li>
              
            </ul>
          </div>
          <hr>
          <h4 class="text-center">Set a new Password</h4>
          <div class="small-12 large-centered large-6 columns">
            
            <span style="display:none" id="error_email_address" class="error_message"></span>
            
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
                <a href="#" id="reset_password" class="button small expand radius next-step">Reset Password</a>
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

$(document).on('click', '#btn_step1', function(e) {
  
  $.validity.start();
  $('#name').require("You did not enter your name! Enter your name below.").maxLength(255).assert(function(el) {
    var result = false;
    var name_data_length = $(el).val().split(" ").length;
    if (name_data_length < 2) {
      result = false;
    } else {
      result = true;
    }
    return result;

  }, "You only entered your first name. Enter your last name to continue.");
  var month_set = $('#birthmonth').require("We need to know when were born. Please select the month.");
  if (!month_set.hasClass("fail")) {
    var day_set = $('#birthdate').require("We need to know when were born. Please select the day.");
    if (!day_set.hasClass("fail")) {
    var year_set = $('#birthyear').require("We need to know when were born. Please select the year");
    if (!year_set.hasClass("fail")) {

      $('#dob').val($('#birthmonth').val() + "/" + $('#birthdate').val() + '/' + $('#birthyear').val()).match("date", "Oops! Please review your birthdate and re-enter.").assert(function(el) {
        return moment($(el).val(), "MM/DD/YYYY").isValid();
      }, "Oops! Please review your birthdate and re-enter.");
    }
  }
  }

  var result = $.validity.end();

  if (result.valid) {
    
      go_to_step( 2);
    
  }
});



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

$(document).on("click", ".back_to_step", function(e) {
  e.preventDefault();
  go_to_step( $(this).attr("data-rel"));
  return false;
});

$(document).on('click', '.security_answer', function(e){
  $(this).parent().children('li').children('input').removeAttr("checked");
  $(this).parent().children('li').removeClass("selected_answer");
  $(this).find("input").prop("checked", true);
  $(this).addClass("selected_answer");
});

$(document).on("click", "#save_security_answers", function(e){
  e.preventDefault();
  if($('li.security_answer input:checked').length == 2) {
     $('#answers').val("answered");
    } else {
      $('#answers').val("");
    }
  

  $.validity.start();
  $('#security_answers').require("Oops! You need to answer both questions to continue.").assert(function(){
    if($('li.security_answer input:checked').length == 2) {
      return true;
    } else {
      return false;
    }
   
  }, "Oops! You need to answer both questions to continue.");
  var result = $.validity.end();

  if (result.valid) {
    go_to_step(4);
  }
  return false;
});

$(function() {

  $.extend($.validity.patterns, {
    month_day: /^((0?\d)|(1[012]))[\/-]([012]?\d|30|31)$/
  });

  $('#birthday').mask('00/00');
 /* $('#direct_signup').easyWizard({
    showSteps: false,
    debug: true,
    showButtons: false
  }); */
});
</script>
<div class="clearfix"></div>