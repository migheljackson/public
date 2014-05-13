<!--
@name ForgotUsernamePage
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
<form id="request_username" type="post" action="fe-do-request-username" class="form-horizontal" style="position:relative;min-height:600px;">
  <section class="step active" data-step-title="step-1" style="display:block;">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Forgot Username</h2>
          <div class="steps">
            <ul>
              <li><a href="#" class="active">1</a></li>
              <li class="post_dob" style="display:none;"><a href="#">2</a></li>
            </ul>
          </div>
          <hr>
          <h4 class="text-center">Your Info</h4>
          <div class="small-12 large-centered large-6 columns">
            
            <div class="row">
              <div class="small-12 large-12 columns">
                <span >Your Birthdate</span>
              </div>
              <span style="display:none" id="error_birthdate" class="error_message"></span>
              <span style="display:none" id="error_birthmonth" class="error_message"></span>
              <span style="display:none" id="error_birthyear" class="error_message"></span>
              <span style="display:none" id="error_dob" class="error_message"></span>
              <div class="small-12 large-4 columns">
                <label for="birthmonth">
                  <select id="birthmonth" name="birthmonth" class="dob" >
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
                  <select id="birthdate" name="birthdate"  class="dob" >
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
                  <select id="birthyear" name="birthyear"  class="dob"  >
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
            <div class="under_13" style="display:none;">
              <span style="display:none" id="error_name" class="error_message"></span>
              <label for="name">
                <input name="full_name" id="full_name" type="text" placeholder="First & last name" >
              </label>
            </div>
            <div class="over_13" style="display:none;">
              <span style="display:none" id="error_email_address" class="error_message"></span>
              <label  for="email">
                <input name="email_address" id="email_address" type="text" placeholder="E-mail address">
              </label>
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
          <h2 class="text-center">Forgot Username</h2>
          <div class="steps">
            <ul>
              <li><a href="#" class="" data-rel="1">1</a></li>
              <li><a href="#" class="active" data-rel="2">2</a></li>
            </ul>
          </div>
          <hr>
          <h4 class="text-center">Password reminder</h4>
          <div class="small-12 large-centered large-6 columns">
            <span style="display:none" id="error_answers" class="error_message"></span>
            <input type="hidden" name="answers" id="answers" value="" />
            <div id="security_questions">
              
            </div>
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

    <section class="step" data-step-title="step-3" style="display:none;">
    <div class="sign-up-page">
      <div class="row">
        <div class="small-12 large-centered large-9 columns">
          <h2 class="text-center">Forgot Username</h2>

          <hr>
          <h4 id="result_message" class="text-center"></h4>
          <div class="small-12 large-centered large-6 columns">
            <span style="display:none" id="error_answers" class="error_message"></span>
            <input type="hidden" name="answers" id="answers" value="" />
            <div id="security_questions">
              
            </div>
            <div id="under_13_sign_in" class="row"  style="display:none;">
              <div class="small-12 large-12 columns">
                <a id="sign_in_button" href="#"  class="button small expand radius next-step">Continue to Sign In</a>
              </div>
            </div>
            <div id="support_message" class="row" style="display:none">
              <div class="small-12 large-12 columns">
                Do you need some help? Contact COL Support at ccol.support@digitalyouthnetwork.org
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>
  
  
</form>
<script type="text/javascript" src="[[++col_public.assets_url]]js/jquery.mask.js"></script>
<script type="text/javascript" src="[[++col_public.assets_url]]js/moment.js"></script>
<script type="text/javascript">
var over_13 = false;
var current_step = 1;
var go_to_step = function(step_num) {
  var $target = $('section[data-step-title="step-' + step_num + '"]'),
    $other = $target.siblings('.active');

  $other.fadeOut().removeClass('active');
  $target.fadeIn().addClass('active');
}


$(document).on('click', '#btn_step1', function(e) {

  $.validity.start();

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

  var email_address = $('#email_address').val();
  var full_name = $('#full_name').val();
  if (result.valid) {

    if (result.valid && (email_address.length == 0 && full_name.length == 0)) {
      var dob = moment($('#dob').val(), "MM/DD/YYYY");
      over_13 = dob.isBefore(moment().subtract('years', 13));
      if (over_13) {
        $('.over_13').show();
        $('.under_13').hide();

      } else {
        $('.post_dob').show();
        $(".over_13").hide();
        $('.under_13').show();
      }
    } else {
      $.validity.start();

      if (over_13) {
        $('#email_address').require("You need to enter your email! Enter your email address below.").match("email", "Oops! The email address is not complete.");
      } else {
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
      }

      var final_result = $.validity.end();

      if (final_result.valid) {
        // submit to the API
        $.ajax({
          method: "POST",
          url: "fe-do-request-username",
          data: $('#request_username').serialize(),
          dataType: "json",
          success: function(data) {
            debugger;
            if (over_13) {
              $('#result_message').text(data.result.msg);
              go_to_step(3);
            } else {
              if (data.result.success == true) {

                $('#security_questions').html(data.result['security_question_html']);
                go_to_step(2);
              } else {
                $('#result_message').text(data.result.msg);
                go_to_step(3);
              }

            }

          },
          error: function() {

          }
        });
        //  
      }

    }

  }
});


$(document).on("click", ".back_to_step", function(e) {
  e.preventDefault();
  go_to_step($(this).attr("data-rel"));
  return false;
});

$(document).on('click', '.security_answer', function(e) {
  $(this).parent().children('li').children('input').removeAttr("checked");
  $(this).parent().children('li').removeClass("selected_answer");
  $(this).find("input").prop("checked", true);
  $(this).addClass("selected_answer");
});

$(document).on("click", "#save_security_answers", function(e) {
e.preventDefault();
if ($('li.security_answer input:checked').length == 2) {
  $('#answers').val("answered");
} else {
  $('#answers').val("");
}

$.validity.start();
$('#answers').require("Oops! You need to answer both questions to continue.").assert(function() {
  if ($('li.security_answer input:checked').length == 2) {
    return true;
  } else {
    return false;
  }

}, "Oops! You need to answer both questions to continue.");
var result = $.validity.end();
if (result.valid) {
  $.ajax({
    method: "POST",
    url: "fe-do-request-username",
    data: $('#request_username').serialize(),
    dataType: "json",
    success: function(data) {

      if (over_13) {
        $('#result_message').text(data.result.msg);
        go_to_step(3);
      } else {
        if (data.result.success) {
          $('#under_13_sign_in').show();
          $('#sign_in_button').attr('href', data.result.msg);
          $('#result_message').text("Your username is " + data.result.username);
        } else {
          $('#result_message').text(data.result.msg);
          $('#support_message').show();
        }

        go_to_step(3);


      }

    },
    error: function() {

    }
  });
}
return false;
});


</script>
<div class="clearfix"></div>