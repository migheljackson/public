<!--
@name ChooseAvatar
@description Page for the Direct Sign up into COL
-->
[[!fe_get_presetavatars]]

<style>

.selected_answer {
  border: 5px solid; 
  border-radius: 27px; 
  border-color: yellow; 
  background-color: yellow;
}
</style>
<div class="sign-up-page">
    <div class="row" id="avatar_setup">
        <div class="small-12 large-centered large-9 columns">
            <h2 id="page_header"  class="text-center">[[+page_header]]</h2>
            
            <hr>
            <h4 class="text-center">Select your avatar</h4>
            <div class="small-12 large-centered large-6 columns">
            <form id="set_avatar" action="#">
            <ul class="avatar small-block-grid-4 columns">
                [[+avatar_items]]
            </ul>
           
            <div id="next_steps" class="row" style="display:none;">
            <div class="small-12 large-12 columns">
                <a href="/explore" class="button small expand radius next-step">[[+exploring_label]]</a>
            </div>
            </div>
            </form>
            </div>
        </div>
    </div>
    <div id="custom_questions" class="row"  style="display:none;">
<div class="small-12 large-centered large-9 columns">
            <h2 id="page_header"  class="text-center">ALMOST DONE......</h2>
            <hr>
            <h4 class="text-center">Answer a few more questions so that we can learn more about you.<i>They are optional.</i></h4>
            <form id="custom_questions_form">
              <div class="row">
                <div class="small-12 large-centered large-9 columns">
                [[+custom_questions]]
              </div>
              </div>
              <div class="small-12 large-6 columns">
                <a id="custom_question_answers_submit" href="#" class="button small expand radius next-step">Submit & start exploring activities</a>
              </div>
              <div class="small-12 large-6 columns">
                Not interested in filling this out now?
                <br>
                <a id="custom_question_answers_skip" href="#" class="">Skip this and start exploring activities now ></a>
              </div>
            </form>
            
            
    </div>
</div>

<script type="text/javascript">
var hide_next_steps = [[+enforce_choice]];
var has_custom_questions = [[+has_custom_questions]];

var redirect_to_page = function(redirect_to){
  var o_redirect = $.getUrlVar("r");
          if (o_redirect && o_redirect !== undefined && o_redirect.length > 0) {
              redirect_to = decodeURIComponent(o_redirect);
          }
  window.location = redirect_to;
};

$(function(){
  if (!hide_next_steps) {
    $('#next_steps').show();
  }

  var o_redirect = $.getUrlVar("r");
  if (o_redirect && o_redirect !== undefined && o_redirect.length > 0) {
    $('#next_steps').hide();
  }
});

$(document).on('click', '#custom_question_answers_skip', function(e){
  e.preventDefault();
  redirect_to_page('/explore');
  return false;
});

$(document).on('click', '#custom_question_answers_submit', function(e){
  e.preventDefault();
  var custom_question_answers = {}

  var answers = $('#custom_questions_form').serializeArray();
  for (var i = answers.length - 1; i >= 0; i--) {
    var a_data = answers[i];
    var key = a_data.name.replace("custom_question_answers[ ", "").replace(" ]", "");
    var value = a_data.value;
    custom_question_answers[key] = value;
  };

  $.ajax({
    dataType: "JSON",
    url: 'fe-ajax-json-passthrough',
    data: {
      endpoint: "/users/custom_question_answers.json",
      payload: {custom_question_answers: custom_question_answers},
      method: "post"
    },
    error: function(xhr, txtStatus, error ) {
      debugger;
      }, 
    success: function(data) {
      if (data.status==200 || data.status == 201) {
        redirect_to_page("/explore");
      }
    }
  });
  return false;
});


$(document).on('click', '.avatar_item', function(e){
  $(this).parent().children('li').children('input').removeAttr("checked");
  $(this).parent().children('li').children('img').removeClass("selected_answer");
  $(this).find("input").prop("checked", true);
  $(this).children('img').addClass("selected_answer");

  $.ajax({
      type: "POST",
      data: $("#set_avatar").serialize(),
      url: "fe-do-setavatar",
      success: function(data) {
        var json = JSON.parse(data);

        // console.log(json.status);

        if (json.status == 200 || json.status == 201) {
          $('#page_header').text("Your Avatar has been set!");
          
          if (has_custom_questions) {
            $("#avatar_setup").fadeOut();
            $("#custom_questions").fadeIn();
          } else {
            redirect_to_page('my-profile');
            $('#next_steps').show();
          }
          
          

        } else {
          $('#next_steps').show();
            console.log(json.errors + " " + json.result);
            alert("There was an error trying to set your avatar. Please try again in a moment or start exploring");
        }
        
      },
      error: function(data) {
        $('#next_steps').show();
        var json = JSON.parse(data);
        console.log(json.errors + " " + json.result);
        alert("There was an error trying to set your avatar. Please try again in a moment or start exploring");

      }
    });

});
</script>

