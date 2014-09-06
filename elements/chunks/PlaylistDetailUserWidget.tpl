<!--
@name PlaylistDetailUserWidgetLoggedIn
@description source for event details view
-->
<script type="text/javascript">
// call ajax passthrough to load the user registration for this playlist
var playlist_id = [[+playlist_id]];

var start_playlist = function(){
  $.ajax({
    url: 'fe-ajax-json-passthrough',
    data: {
      endpoint: "/user_registrations/signup.json",
      payload: {link_type: "Playlist", link_id: playlist_id},
      method: "post"
    },
    dataType: "JSON",
    success: function(data) {
        
        if (data.status == 200 || data.status == 201) {
          $("#next_step_link").off("click");

          if (data.result.hasOwnProperty("id")) {
            $("#start_button_label").text("");
            $("#next_step_link").attr("href", "#");
            $("#system_notification").text("You have started this playlist. Check out the activities below to complete it.");
          } 
          
        } else if(data.status == 403) {
          $("#start_button_label").text("Login to get started");
          $("#next_step_link").attr("href", "/sign-in?r="+window.location);
        } else {
          alert(data.errors);
        }
    },
    error: function(xhr, txtStatus, error ) {
      debugger;
    }
  });

};

$.ajax({
  url: 'fe-ajax-json-passthrough',
  data: {
    endpoint: "/user_registrations/Playlist/"+playlist_id+".json",
    payload: {dummy: "dummy"},
    method: "get"
  },
  dataType: "JSON",
  success: function(data) {
      debugger
      if (data.status == 200) {
        if (data.result.hasOwnProperty("state")) {
          if (data.state == "completed") {
            $("#start_button_label").text("");
            $("#next_step_link").attr("href", "#");
            $("#system_notification").text("High five! You completed this playlist");
          } else {
            $("#start_button_label").text("");
            $("#next_step_link").attr("href", "#");
            $("#system_notification").text("You have started this playlist. Check out the activities below to complete it.");
          }
          

        } else {
          $("#start_button_label").text("Start this playlist");
          $("#next_step_link").attr("href", "#");
          $("#next_step_link").on("click", function(e){
            start_playlist();
          });
        }

        
      } else if(data.status == 403) {
        $("#start_button_label").text("Login to get started");
        $("#next_step_link").attr("href", "/sign-in?r="+window.location);
      } else {
        alert(data.errors);
      }
  },
  error: function(xhr, txtStatus, error ) {
    debugger;
  }
});


</script>
<a id="next_step_link" href="">
<button id="start_button_label"></button>
</a>
<span id="system_notification"></span>