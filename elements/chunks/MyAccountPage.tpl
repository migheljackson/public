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
        <!--
        <div class="small-6 small-offset-1 columns">
          <a href="#" class="link ch-avatar">Change avatar</a>
        </div>
        -->
      </div>
    </div>
    <!--
    <div class="small-12 columns">
      <div class="title-line small-centered small-12 large-8 columns">
        <h3 class="text-center">My Info</h3>
        <hr class="line">
      </div>
    </div>
    <div class="small-centered small-12 large-3 columns">
      <form>
        <label for="name">First & Last Name<br>
          <input type="text" placeholder="">
        </label>
        <label for="user">User Name<br>
          <input type="text" placeholder="">
        </label>
        <label for="birthday">Birthday<br>
          <input type="date" placeholder="01/20/14">
        </label>
        <label for="pass change">Change password<br><br>
          <input type="submit" class="button small radius right" value="UPDATE MY INFO">
        </label>
      </form>
    </div>
    -->
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
<script id="tpl_claim_code_input" type="text/x-handlebars-template">
<div class="clearfix"></div>
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
$(function() {
  var source = $("#tpl_claim_code_input").html();
  template = Handlebars.compile(source);
  add_code();
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