<!--
@name DirectSignup
@description Page for the Direct Sign up into COL
-->
[[!fe_get_securityquestions]]
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
<form id="direct_signup" type="post" action="process-signup" class="form-horizontal" style="position:relative;min-height:600px;">
  <section class="step active" data-step-title="step-1" style="display:block;">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Sign Up</h2>
          <div class="steps">
            <ul>
              <li><a href="#" class="active">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
            </ul>
          </div>
          <hr>
          <h4 class="text-center">Your Info</h4>
          <div class="small-12 large-centered large-6 columns">
            <span style="display:none" id="error_name" class="error_message"></span>
            <label for="name">
              <input name="name" id="name" type="text" placeholder="First & last name" >
            </label>
            <div class="row">
              <span style="display:none" id="error_birthday" class="error_message"></span>
              <span style="display:none" id="error_birthyear" class="error_message"></span>
              <span style="display:none" id="error_dob" class="error_message"></span>
              <div class="small-12 large-6 columns">
                <label for="birthday">
                  <input id="birthday" type="text" placeholder="Birthday month / year" >
                  <input type="hidden" name="dob" id="dob" />
                </label>
              </div>
              <div class="small-12 large-6 columns">
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
                    <option value="1988">1988</option>
                    <option value="1987">1987</option>
                    <option value="1986">1986</option>
                    <option value="1985">1985</option>
                    <option value="1984">1984</option>
                    <option value="1983">1983</option>
                    <option value="1982">1982</option>
                    <option value="1981">1981</option>
                    <option value="1980">1980</option>
                    <option value="1979">1979</option>
                    <option value="1978">1978</option>
                    <option value="1977">1977</option>
                    <option value="1976">1976</option>
                    <option value="1975">1975</option>
                    <option value="1974">1974</option>
                    <option value="1973">1973</option>
                    <option value="1972">1972</option>
                    <option value="1971">1971</option>
                    <option value="1970">1970</option>
                    <option value="1969">1969</option>
                    <option value="1968">1968</option>
                    <option value="1967">1967</option>
                    <option value="1966">1966</option>
                    <option value="1965">1965</option>
                    <option value="1964">1964</option>
                    <option value="1963">1963</option>
                    <option value="1962">1962</option>
                    <option value="1961">1961</option>
                    <option value="1960">1960</option>
                    <option value="1959">1959</option>
                    <option value="1958">1958</option>
                    <option value="1957">1957</option>
                    <option value="1956">1956</option>
                    <option value="1955">1955</option>
                    <option value="1954">1954</option>
                    <option value="1953">1953</option>
                    <option value="1952">1952</option>
                    <option value="1951">1951</option>
                    <option value="1950">1950</option>
                    <option value="1949">1949</option>
                    <option value="1948">1948</option>
                    <option value="1947">1947</option>
                    <option value="1946">1946</option>
                    <option value="1945">1945</option>
                    <option value="1944">1944</option>
                    <option value="1943">1943</option>
                    <option value="1942">1942</option>
                    <option value="1941">1941</option>
                    <option value="1940">1940</option>
                    <option value="1939">1939</option>
                    <option value="1938">1938</option>
                    <option value="1937">1937</option>
                    <option value="1936">1936</option>
                    <option value="1935">1935</option>
                    <option value="1934">1934</option>
                    <option value="1933">1933</option>
                    <option value="1932">1932</option>
                    <option value="1931">1931</option>
                    <option value="1930">1930</option>
                    <option value="1929">1929</option>
                    <option value="1928">1928</option>
                    <option value="1927">1927</option>
                    <option value="1926">1926</option>
                    <option value="1925">1925</option>
                    <option value="1924">1924</option>
                    <option value="1923">1923</option>
                    <option value="1922">1922</option>
                    <option value="1921">1921</option>
                    <option value="1920">1920</option>
                    <option value="1919">1919</option>
                    <option value="1918">1918</option>
                    <option value="1917">1917</option>
                    <option value="1916">1916</option>
                    <option value="1915">1915</option>
                    <option value="1914">1914</option>
                    <option value="1913">1913</option>
                    <option value="1912">1912</option>
                    <option value="1911">1911</option>
                    <option value="1910">1910</option>
                    <option value="1909">1909</option>
                    <option value="1908">1908</option>
                    <option value="1907">1907</option>
                    <option value="1906">1906</option>
                    <option value="1905">1905</option>
                    <option value="1904">1904</option>
                    <option value="1903">1903</option>
                    <option value="1902">1902</option>
                    <option value="1901">1901</option>
                    <option value="1900">1900</option>
                  </select>
                </label>
              </div>
            </div>
            
            <div class="small-12 link"><a href="#" data-reveal-id="code">Do you have a claim code?</a></div>
            <div class="row">
              <div class="small-12 large-12 columns">
                <a href="#" id="btn_step1" class="button small expand radius next-step">Continue Sign Up</a><br><br>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <!-- Claim code modal -->
      <div id="code" class="reveal-modal tiny" data-reveal>
        <p>Enter your claim code</p>
          <label for="code">
            <input type="text" name="claim_code" id="claim_code" placeholder="Claim code">
          </label>
          <input type="submit" value="Continue" class="button small expand radius next-step">
        
        <a class="close-reveal-modal">&#215;</a>
      </div>
    </div>
  </section>
  <section class="step" data-step-title="step-2" style="display:none;">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Sign Up</h2>
          <div class="steps">
            <ul>
              <li><a href="#" class="back_to_step" data-rel="1">1</a></li>
              <li><a href="#" class="active">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
            </ul>
          </div>
          <hr>
          <h4 class="text-center">Legal guardian info</h4>
          <div class="small-12 large-centered large-6 columns">
            <span style="display:none" id="error_guardian_email_address" class="error_message"></span>
            <label for="email">
              <input name="guardian_email_address" id="guardian_email_address" type="text" placeholder="Legal Guardian E-Mail">
            </label>
            <span style="display:none" id="error_guardian_phone" class="error_message"></span>
            <label for="phone">
              <input name="guardian_phone" id="guardian_phone" type="text" placeholder="Legal Guardian Phone Number">
            </label>
            <div class="small-12 columns link" data-reveal-id="why_parent_info">
              <a href="#">Why do we ask this?</a><br>
            </div>
            <div class="row">
              <div class="small-12 large-6 columns">
                <a id="skip_guardian_info" href="#" class="button small secondary expand radius">I don't have either</a>
              </div>
              <div class="small-12 large-6 columns">
                <a id="save_guardian_info"  href="#" class="button small expand radius next-step">Continue Sign Up</a>
              </div>
            </div>
            
          </div>
        </div>
        <div id="why_parent_info" class="reveal-modal tiny" data-reveal>
        <p>Why do we ask for this info?</p>
         <p>We ask for your parent info so that we can:</p>
        <ul><li>
        Contact your parent if you have issues accessing your account
      </li>
      <li>
        Let your parent know about your learning experience
      </li>
</ul>

        <a class="close-reveal-modal">&#215;</a>
      </div>
      </div>
    </div>
  </section>
  <section class="step" data-step-title="step-3" style="display:none;">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Sign Up</h2>
          <div class="steps">
            <ul>
              <li><a href="#" class="back_to_step" data-rel="1">1</a></li>
              <li><a href="#" class="back_to_step" data-rel="2">2</a></li>
              <li><a href="#" class="active">3</a></li>
              <li><a href="#">4</a></li>
            </ul>
          </div>
          <hr>
          <h4 class="text-center">Password reminder</h4>
          <div class="small-12 large-centered large-6 columns">
            <span style="display:none" id="error_answers" class="error_message"></span>
            <input type="hidden" name="answers" id="answers" value="" />
            [[+security_questions]]
            <div class="row">
              <div class="small-12 large-12 columns">
                <a id="save_security_answers" href="#"  class="button small expand radius next-step">Continue Sign Up</a>
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
          <h2 class="text-center">Sign Up</h2>
          <div class="steps">
            <ul>
              <li><a href="#" class="back_to_step" data-rel="1">1</a></li>
              <li><a href="#" class="back_to_step optional" data-rel="2">2</a></li>
              <li><a href="#" class="back_to_step optional" data-rel="3">3</a></li>
              <li><a href="#" class="active">4</a></li>
            </ul>
          </div>
          <hr>
          <h4 class="text-center">Create account</h4>
          <div class="small-12 large-centered large-6 columns">
            
            <span style="display:none" id="error_email_address" class="error_message"></span>
            <label class="over_13" for="email">
              <input name="email_address" id="email_address" type="text" placeholder="E-mail address">
            </label>
              
            <label for="zip">
              <input name="zipcode" type="text" placeholder="Zip code">
            </label>
              
            <span style="display:none" id="error_username" class="error_message"></span>
            <label for="user">
              <input type="text" name="username" id="username" placeholder="User name">
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
                <a href="#" id="create_account" class="button small expand radius next-step">Continue Sign up</a>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>
  
</form>
<script type="text/javascript" src="assets/js/jquery.easyWizard.js"></script>
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
  var day_set = $('#birthday').require("We need to know when were born. Enter your birthdate.").match("month_day", "Opps! Please review your birthdate and re-enter.");
  if (!day_set.hasClass("fail")) {
    var year_set = $('#birthyear').require("We need to know when were born. Please select the year");
    if (!year_set.hasClass("fail")) {

      $('#dob').val($('#birthday').val() + '/' + $('#birthyear').val()).match("date", "Oops! Please review your birthdate and re-enter.").assert(function(el) {
        return moment($(el).val(), "MM/DD/YYYY").isValid();
      }, "Oops! Please review your birthdate and re-enter.");
    }
  }

  var result = $.validity.end();

  if (result.valid) {
    var dob = moment($('#dob').val(), "MM/DD/YYYY");
    over_13 = dob.isBefore(moment().subtract('years', 13));
    if (over_13) {
      // go to step 4
      go_to_step( 4);
      $(".back_to_step.optional").removeClass("back_to_step");
    } else {
      $(".over_13").hide();
      go_to_step( 2);
    }
  }
});

$(document).on("click", "#skip_guardian_info", function(e){
  e.preventDefault();
  $('input[name="guardian_email_address"]').val("");
  $('input[name="guardian_phone"]').val("");
  go_to_step( 3);
  return false;
});

$(document).on("click", "#save_guardian_info", function(e){
  e.preventDefault();
  $.validity.start();
  $('#guardian_email_address').match("email", "Oops! The email address does not look correct.");
  $('#guardian_phone').match("phone", "Oops! Enter the number in this format. 111-111-1111.");
  $('#guardian_email_address').assert(function(){
    if ($('#guardian_email_address').val().length == 0 && $('#guardian_phone').val().length==0) {
      return false;
    } else {
      return true;
    }
      

  }, "If you don't know either your guardian's phone number or email click the 'I don't have either' button!")
  var result = $.validity.end();
  if (result.valid) {
    go_to_step( 3);
  }
  return false;
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

$(document).on("click", "#create_account", function(e){
e.preventDefault();
$.validity.start();
$('#username').require("You need to create your username to continue.");
$('#password').require("You need to create a password for your account.");
if (over_13) {
  $('#email_address').require("You need to enter your email! Enter your email address below.").match("email", "Oops! The email address is not complete.");
}
  var result = $.validity.end();
  if (result.valid) {
    // post form via ajax
    $.ajax({
      type: "POST",
      data: $("#direct_signup").serialize(),
      url: "fe-dosignup",
      success: function(data) {
        var json = JSON.parse(data);

        // console.log(json.status);

        if (json.status == 200 || json.status == 201) {
          window.location = 'choose-avatar';
        } else {
          if (json.status == 400) {
            if (json.errors['guardian_email_address']) {
              go_to_step(2);
              $("#error_guardian_email_address").text("Oops, it doesn't look like we can send email to the below address.Please make sure its right!").show();
              return
            }

            if (json.errors['email_address']) {
              $("#error_email_address").text("Oops, it doesn't look like we can send email to the below address.Please make sure its right!").show();
              return
            }

            if (json.errors['username'] && json.errors['username'][0].indexOf("unique") > 0) {
              var current_username = $('#username').val();
              var error_message = 'Darn! "'+current_username+'" is already taken. How about you give it another try or use "' + current_username + '1", "' + current_username + '2" , or "' + current_username + '3".';
              $("#error_username").text(error_message).show();
              return;
            }

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
  $.extend($.validity.patterns, {
    month_day: /^((0?\d)|(1[012]))[\/-]([012]?\d|30|31)$/
  });
  $.validity.setup({
    outputMode: "field_fill"
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