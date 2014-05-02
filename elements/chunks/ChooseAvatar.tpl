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
    <div class="row">
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
</div>

<script type="text/javascript">
var hide_next_steps = [[+enforce_choice]];

$(function(){
  if (!hide_next_steps) {
    $('#next_steps').show();
  }
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
          $('#page_header').text("Your Avatar has been set!")
          $('#next_steps').show();
          window.location = 'my-profile';

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

