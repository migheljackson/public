<!--
@name DirectSignup
@description Page for the Direct Sign up into COL
-->

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
            <label for="name" class="bold">First & Last Name</label>
            <input name="full_name" id="name" type="text" placeholder="First & last name" value="[[+full_name]]" >
            
            <div class="row">
              <input type="hidden" id="preset_dob" value="[[+date_of_birth]]">
              <div class="small-12 large-12 columns">
                <label for="birthmonth" class="bold">Your Birthdate</label>
              </div>
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
                     <option value="12">December</option>
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
            <div id="code_entered" class="small-12" style="display:none">Sweet! Your account claim code <span id="claim_code_entered"></span> has been successfully verified.</div>
            <div id="code_select" class="small-12 link">
	            <label class="bold">Do you have a claim code?</label>
	            <select id="claim_code_select">
	            	<option value="">Select One</option>
	            	<option value="yes">Yes</option>
	            	<option value="no">No</option>
	            	<option value="idk">Don't Know</option>
	            </select>
            </div>
            <div id="code_inline" class="small-12" style="display:none">
		        <label>Enter your claim code</label>
		        <span id="error_claim_code" class="error_message" style="display:none;"></span>
		        <div class="small-6 column" style="padding-left:0">
		        	<input type="text" name="claim_code" id="claim_code" placeholder="Claim code" value="[[+claim_code]]">
		        </div>
		        <div class="small-6 column">
		        	<a id="claim_code_continue" class="button small radius next-step">Verify</a>
		    	</div>
		    </div>
            <div class="row">
              <div class="small-12 large-12 columns">
                <a id="btn_step1" class="button small expand radius next-step">Continue Sign Up</a><br><br>
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
          <h4 class="text-center">Parent/Legal guardian info</h4>
          <div class="small-12 large-centered large-6 columns">
            <span style="display:none" id="error_guardian_email_address" class="error_message"></span>
            <label for="email" class="bold">Your parent/legal guardian - Email</label>
            <input name="guardian_email_address" id="guardian_email_address" type="text" placeholder="Legal Guardian E-Mail" value="[[+guardian_email_address]]">
            <span style="display:none" id="error_guardian_phone" class="error_message"></span>
            <label for="phone" class="bold">Your parent/legal guardian -  Phone number</label>
            <span style="font-size:.8em">Your parent or guardian will get text messages about your achievements.</span>
            <input name="guardian_phone" id="guardian_phone" type="text" placeholder="Legal Guardian Phone Number" value="[[+guardian_phone]]">
            <div class="small-12 columns link" data-reveal-id="why_parent_info">
              <a href="#">Why do we ask this?</a><br>
            </div>
            <div class="row">
              <div class="small-12 large-6 columns">
                <a id="skip_guardian_info" href="#" class="button small secondary expand radius" style="background: #EEE; color: #DD8F68">I don't have either</a>
              </div>
              <div class="small-12 large-6 columns">
                <a id="save_guardian_info"  href="#" class="button small expand radius next-step">Continue Sign Up</a>
              </div>
            </div>
            
          </div>
        </div>
        <div id="why_parent_info" class="reveal-modal tiny" data-reveal>
        <p>Why do we ask for this info?</p>
         <p>We ask for your parent/guardian info so that we can:</p>
        <ul><li>
        Contact your parent/guardian if you have issues accessing your account
      </li>
      <li>
        Let your parent/guardian know about your learning experience
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
              <input name="email_address" id="email_address" type="text" placeholder="E-mail address" value="[[+email_address]]">
            </label>
            <span style="display:none" id="error_zipcode" class="error_message"></span>
            <label for="zip" class="bold">Your Zip code - Optional</label>
              <input name="zipcode" type="text" placeholder="Zip code">
            </label>
              
            <span style="display:none" id="error_username" class="error_message"></span>
            <label for="user" class="bold">Create your username</label>
            <input type="text" name="username" id="username" placeholder="Username">
            
            <span style="display:none" id="error_password" class="error_message"></span>
            <div class="small-8 large-6 column" style="padding-left:0; margin-left:0">
	            <label for="pass" class="bold">Create your password
	              <input type="password"  id="password" name="password" placeholder="Password">
	            </label>
            </div>
            <div class="small-12 large-6 columns" style="padding-right:0; padding-left:0;padding-top: 21px;">
              <div class="small-7 large-5 columns" style="padding-left:0">
                <div class="switch tiny round">
                  <input id="z1" name="switch-z" value="show" type="radio">
                  <label for="z1" onclick=""></label>
                  <input id="z" name="switch-z" type="radio" value="hide" checked>
                  <label for="z" onclick=""></label>
                  
                  <span></span>
                </div>
                
              </div>
              <div class="small-8 large-7 columns" style="padding-left:0; padding-right:0;">
                <p style="font-size:0.8em">Show password</p>
              </div>
            </div>
            <div class="row" style="">
              <div class="small-12 columns">
                <div class="progress small-12 large-7 columns radius">
                  <span id="score_meter" class="meter" style="width: 0%"></span>
                </div>
                <div class="small-12 large-5 columns">
                  <a id="generate_password" href="#" class="link generate">Generate password</a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="small-12 columns">
              <span style="display:none" id="error_permission" class="error_message"></span>
              	<label><input id="permission" type="checkbox" class="roadblock" name="permission" value="true" style="visibility: visible"/> Agree to <a href="tos" onclick='window.open("tos", "tos", "height=400,width=400"); return false;'>Terms of Service</a></label>
                <a href="#" id="create_account" class="button small expand radius next-step" disabled>Continue Sign up</a>
              </div>
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
  ga('col.send', 'event', 'Signup', 'step', step_num);
  var $target = $('section[data-step-title="step-'+step_num+'"]'),
            $other = $target.siblings('.active');
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

function generate_password() {
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
  return false;
});

$(document).on('open', '[data-reveal]', function () {
  var modal = $(this);
  if(modal.attr("id")=="code") {
    // add mask
    $('#claim_code').mask("AAAAA");
  }
});

$(document).on('click', '#claim_code_continue', function(){
  $.validity.start();
  $('#claim_code').minLength(5, 'The claim code you entered is not valid. Please review it and enter a valid claim code.');

  var result = $.validity.end();
  if (result.valid) {
	if($('#claim_code').val().substr(0,1).toLowerCase()=="a") {
  		$('#dob').val($('#birthmonth').val() + "/" + $('#birthdate').val() + '/' + $('#birthyear').val());
  		verify($('#name').val(), $('#dob').val(), $('#claim_code').val());
  	} else if ($("#claim_code").val().length > 0) {
      $('#claim_code_entered').text($("#claim_code").val());
      $('#code_entered').show();
    } else {
      $('#code_entered').hide();
    }
  }
  return false;
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
$('#zipcode').match("zip", "Zip code needs to be in 5 digits");
if (over_13) {
  $('#email_address').require("You need to enter your email! Enter your email address below.").match("email", "Oops! The email address is not complete.");
}
$('#permission').assert($("#permission:checked").length != 0, 
        "Please agree with the terms of service.");
  var result = $.validity.end();
  if (result.valid) {
    // post form via ajax
    $.ajax({
      type: "POST",
      data: $("#direct_signup").serialize(),
      url: "fe-dosignup",
      success: function(data) {
        var json = JSON.parse(data);

        if (json.status == 200 || json.status == 201) {
          redirect_to = 'choose-avatar'

          var o_redirect = $.getUrlVar("r");
          if (o_redirect && o_redirect !== undefined && o_redirect.length > 0) {
              redirect_to = redirect_to + "?r=" + o_redirect;
          }

          window.location = redirect_to;
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
              var error_message = '"'+current_username+'" is already taken. How about you give it another try or use "' + current_username + '1", "' + current_username + '2" , or "' + current_username + '3".';
              $("#error_username").text(error_message).show();
              return;
            }

          } else {
            alert("There was an error trying to create your account. Please try again in a moment.");
          }
        }
      },
      error: function(data) {
        var json = JSON.parse(data);
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

  if($('#preset_dob').val().length > 0) {
    var preset_dob = $('#preset_dob').val().split("/");
    $("#birthmonth option[value='"+preset_dob[0]+"']").prop("selected", true);
    $("#birthdate option[value='"+preset_dob[1]+"']").prop("selected", true);
    $("#birthyear option[value='"+preset_dob[2]+"']").prop("selected", true);
    debugger;
    $('#btn_step1').trigger('click');
    var preset_dob = moment($('#preset_dob').val(), "MM/DD/YYYY");
    over_13 = preset_dob.isBefore(moment().subtract('years', 13));
    if (!over_13) {
      go_to_step( 3);
    }
  }

  $('#birthday').mask('00/00');
});
$(document).ready(function() {
  ga('col.send', 'event', 'Signup', 'step', '1');
  $('.roadblock').click(function(){
    if ($(this).is(':checked') ) {
      $("#create_account").removeAttr("disabled");
    } else {
      $("#create_account").attr("disabled","disabled");
    }
  });
});

function verify(name, dob, code) {
	var params = "dob="+dob+"&name="+name+"&code="+code;
	
	 $.ajax({
      url: "validate-claim-code",
      method: "post",
      dataType: "json",
      data: {dob: dob, name:name, code: code},
      success: function(data) {
	    if(data.status==400) {
	    	var msg;	
	    	if(data.errors[0]=="No user found with that external_sys_id"){
	    		msg="The account code you entered is not valid. Please review it and enter a valid account code.";
	    	} else {
	    		msg="Your account code is not valid. Please review your name, date of birth, and account code. Try again or create account without code.";
	    	}
	    	$("#error_claim_code").text(msg).show();
	    } else {
	    	$('#claim_code_entered').text($("#claim_code").val());
      		$('#code_entered').show();
      		$("#error_claim_code").hide();
      		$("#code_inline").hide();
      		$("#code_select").hide();
		}
		return false;
	  },
	  error: function(data, errorString, error) {
	  	alert(errorString);
	  }
	});
}
     $('#claim_code_select').change(function() {
        if($(this).val()=="yes"){
            $("#code_inline").slideToggle();
       	}
     });
</script>
<div class="clearfix"></div>
