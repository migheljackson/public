<!--
@name MyAccountPage
@description Page User Account
-->
[[!fe_get_profile]]
<div class="profile">
  <div class="small-12 columns">
    <h2 class="text-center">My account</h2>
    <div class="small-centered small-6 large-2 columns">
      <img src="[[+preset_avatar_url]]" alt="avatar" class="text-center">
    </div>
    <br>
    <h4 class="text-center">[[+username]]</h4>
    <p class="text-center "><a href="my-profile" class="link">Go to my profile</a></p>
  </div>
  <div class="clearfix"></div>
</div>
<div class="profile-badges">
  <div class="small-12 columns">
    <div class="title-line small-centered small-12 large-8 columns">
      <h3 class="text-center">My Avatar</h3>
      <hr class="line">
    </div>
    <div class="row">
      <div class="small-centered small-12 large-5 columns stats">
        <div class="small-3 small-offset-2 columns">
          <img src="[[+preset_avatar_url]]" alt="avatar" class="text-center">
        </div>
        
        <div class="small-6 small-offset-1 columns">
          <a href="change-avatar" class="link ch-avatar">Change avatar</a>
        </div>
        
      </div>
    </div>
    
    <div class="small-12 columns">
      <div class="title-line small-centered small-12 large-8 columns">
        <h3 class="text-center">My Info</h3>
        <hr class="line">
      </div>
    </div>
    <div class="small-centered small-12 large-3 columns">
      <form id="update_account" action="fe-do-update-account" >
        <input type="hidden" name="id" value="[[+user_id]]"> 
        <span style="display:none" id="error_full_name" class="error_message"></span>
        <label for="full_name">First & Last Name<br>
          <input id="full_name" name="full_name" type="text" placeholder="Please enter your full name" value="[[+full_name]]">
        </label>
        <span style="display:none" id="error_username" class="error_message"></span>
        <label for="username">User Name<br>
          <input id="username"  name="username" type="text" placeholder="" value="[[+username]]">
        </label>
        <span style="display:none" id="error_dob" class="error_message"></span>
        <label for="dob">Birthdate<br>
          <input id="dob" type="text" value="[[+date_of_birth]]" name="dob">
        </label>
        <div class="over_13" style="display:none;">
        <span style="display:none" id="error_email_address" class="error_message"></span>
        <label for="email_address">Email address<br>
          <input name="email_address" id="email_address" type="text" placeholder="" value="[[+email_address]]">
        </label>
        </div>
         <div class="row">
          <a href="#" id="do_change_password">Change password</a>
        </div>
        <label for="password" style="display:none;" class="change_password">Password
          <input type="password"  id="password" name="password" placeholder="Password" >
        </label>
        
        <div class="row change_password" style="display:none;">
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

        <div class="under_13" style="display:none;">
          <h3 class="text-center" style="width:100%;">Parent/Guardian Information (Optional)</h3>
          <hr class="line">
          <span style="display:none" id="error_guardian_name" class="error_message"></span>
          <label for="guardian_name">Parent/Guardian Name<br>
            <input name="guardian_name" type="text" placeholder="" value="[[+guardian_name]]">
          </label>
          <span style="display:none" id="error_guardian_phone" class="error_message"></span>
        <label for="guardian_phone">Parent/Guardian Phone<br>
          <input id="guardian_phone" name="guardian_phone" type="text" placeholder="" value="[[+guardian_phone]]">
        </label>
          <span style="display:none" id="error_guardian_email_address" class="error_message"></span>
        <label for="guardian_email_address">Parent/Guardian Email address<br>
          <input name="guardian_email_address" type="text" placeholder="" value="[[+guardian_email_address]]">
        </label>
        </div>
       
              <input id ="update_account_submit" type="submit" class="button small radius expand" value="UPDATE MY INFO">
            <br><br>
      </form>
    </div>
    
    <div class="small-12 columns">
      <div class="title-line small-centered small-12 large-8 columns">
        <h3 class="text-center">My City of Learning Codes</h3>
        <hr class="line">
        <p class="text-center">Enter code(s) given to you here.</p>
      </div>
    </div>
    <div class="small-centered small-12 large-4 columns">
      <div class="clearfix"></div>
      <form id="claim_code_form" action="fe-do-claim-codes">
        <div id="claim_code_results" style="display:none;"><hr>
        <p class="text-center">Codes successfully added to your account.</p></div>
        <div id="claim_code_contents" ></div>
        <span id="btn_add_code" class="button tiny radius right">+ Add another code</span>
        <input type="submit" class="button small radius expand" value="ADD CODE TO MY PROFILE">
      </form>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<script type="text/javascript" src="[[++col_public.assets_url]]js/handlebars-v1.3.0.js"></script>
<script type="text/javascript" src="[[++col_public.assets_url]]js/jquery.mask.js"></script>
<script type="text/javascript" src="[[++col_public.assets_url]]js/moment.js"></script>
<script id="tpl_claim_code_input" type="text/x-handlebars-template">
<div class="clearfix"></div>
<a id="claim_codes_link"></a>
<div class="small-centered small-12 large-12 columns" data-code-ref="{{id}}" >
<p id="error_{{id}}" class="left alert-box error_message" style="display:none"></p>
</div>
<div class="small-6 large-4 columns" data-code-ref="{{id}}">
<label for="name"><br>
  <input id="{{id}}" name="claim_codes[ ]" type="text" placeholder="Enter code" class="claim_code_input" >
</label>
</div>
<div class="small-6 large-8 columns" data-code-ref="{{id}}">
<label for="actions code"><br>
  <span class="button tiny radius left warning remove_code" style="display:none;" data-code-ref="{{id}}">x Remove code</span>
  
</label>
</div>
</script>
<script id="tpl_claim_code_result" type="text/x-handlebars-template">
<div class="row">
<div class="small-6 large-5 columns">
  <img src="[[++col_public.assets_url]]images/checkmark-circle.png" class="left check">
  <img src="{{object.image_url}}" alt="{{name}}" class="th right" width="70px" height="70px">
</div>
<div class="small-6 large-7 columns">
  <p class="workshop-name">{{code}}</p>
  <p class="workshop-name">{{object_type}} name has been added to your account.</p>
</div>
<div class="small-12 columns">
  <a href="my-profile" class="profile-link">View {{object_type}} in your profile<br></a>
</div>
</div>
</script>
<script type="text/javascript">
var template = null;
var result_template = null;
var add_code = function() {
  $('.remove_code').show();
  context = {
    'id': new Date().getTime()
  };
  var html = template(context);
  $('#claim_code_contents').append(html);
  $('.claim_code_input').mask('AAAAA');
};
var remove_code_by_ref = function(code_ref) {
  $('*[data-code-ref="' + code_ref + '"]').remove();
};

var show_appropriate_fields = function() {
  $.validity.start();
  $('#dob').match("date", "Oops! Please review your birthdate and re-enter.").assert(function(el) {
        return moment($(el).val(), "MM/DD/YYYY").isValid();
      }, "Oops! Please review your birthdate and re-enter.");
  var result = $.validity.end();
  if (result.valid) {
    var dob = moment($('#dob').val(), "MM/DD/YYYY");
    over_13 = dob.isBefore(moment().subtract('years', 13));
    if (over_13) {
      $('.under_13').hide();
      $('.over_13').show();
    } else {
      $('.under_13').show();
      $('.over_13').hide();
    }
  }
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

$(document).on("change", "#dob", function(e){
  show_appropriate_fields();
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

$(document).on("click", '#do_change_password', function(e){
  e.preventDefault();
  $('.change_password').show();
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

$(document).on("click", "#update_account_submit", function(e){
  e.preventDefault();
  $.validity.start();
  $('#dob').require("Oops! Please enter your birthdate in the following format (MM/DD/YYYY)").match("date", "Oops! Please review your birthdate and re-enter.").assert(function(el) {
        return moment($(el).val(), "MM/DD/YYYY").isValid();
      }, "Oops! Please review your birthdate and re-enter.");
  var result = $.validity.end();
  if (result.valid) {
    $.validity.start();

    $('#username').require("You need to enter in your username to continue.");
    $('#full_name').require("You did not enter your name! Enter your name below.").maxLength(255).assert(function(el) {
    var result = false;
    var name_data_length = $(el).val().split(" ").length;
    if (name_data_length < 2) {
      result = false;
    } else {
      result = true;
    }
    return result;

  }, "You only entered your first name. Enter your last name to continue.");

    var dob = moment($('#dob').val(), "MM/DD/YYYY");
    over_13 = dob.isBefore(moment().subtract('years', 13));
    if (over_13) {
      $('#email_address').require("You need to enter your email! Enter your email address below.").match("email", "Oops! The email address is not complete.");
    } else {
      $('#guardian_email_address').match("email", "Oops! The email address does not look correct.");
      $('#guardian_phone').match("phone", "Oops! Enter the number in this format. 111-111-1111.");
    }
  }

  var result2 = $.validity.end();
  if (result2.valid) {
    $.ajax({
      type: "POST",
      dataType: "JSON",
      data: $("#update_account").serialize(),
      url: $("#update_account").attr("action"),
      success: function(json) {
        console.log(json.status);

        if (json.status == 200) {
          window.location = 'my-account';
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

$(function() {
  var source = $("#tpl_claim_code_input").html();
  template = Handlebars.compile(source);
  add_code();

  show_appropriate_fields();

  var result_source = $("#tpl_claim_code_result").html();
  result_template = Handlebars.compile(result_source);
  $(document).on('click', '#btn_add_code', function() {
    add_code();
  });
  $(document).on('click', '.remove_code', function() {
    remove_code_by_ref($(this).attr("data-code-ref"));
  });
  $('#claim_code_form').validity(function() {
    $('.claim_code_input').minLength(5, 'Code is not valid. Please review and enter the correct code.');
  });
  $('#claim_code_form').on("submit", function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      data: $("#claim_code_form").serialize(),
      url: $("#claim_code_form").attr("action"),
      success: function(data) {
        var json = JSON.parse(data);
        // console.log(json.status);
        if (json.status == 200) {
          for (var i = 0; i < json.result.length; i++) {
            r = json.result[i];
            var data_ref = $('input.claim_code_input[value="' + r.code + '"]').attr("id");
            if (r.success) {

              if (r.object.hasOwnProperty("badge_type")) {
                r.object_type = "Badge"
              } else {
                r.object_type = r.program_type;
              }
              $('#claim_code_results').show();
              var r_html = result_template(r);
              $('#claim_code_results').append(r_html);
              remove_code_by_ref(data_ref);
            } else {
              $('#error_' + data_ref).text(r.msg).show();
            }
          }

        } else {
          alert("There was an error trying to claim your codes. Please try again in a moment.");
          console.log(json.errors + " " + json.result);
          

        }
      },
      error: function(data) {
        alert("There was an error trying to claim your codes. Please try again in a moment.");
        var json = JSON.parse(data);
        console.log(json.errors + " " + json.result);
        
      }
    });
    return false;
  });
});
</script>