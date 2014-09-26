<section class="step" data-step-title="step-1">
  <div class="profile clearfix">
    <div class="small-12 large-centered large-9 columns">
      <h3 class="text-center">ALLOW "[[+org_name]]" to award you badges on your [[++site_name]] account. </h3>
      <hr>
      <h5 class="text-center" id="status"><strong>What information we will share with [[+org_name]]?</strong></h4>
      <h5 class="text-center">[[+org_name]] will be able to award badges to your [[++site_name]] account, but we will not share any personal information about you with [[+org_name]].</h5>
      <hr>
      <h5>Do you want to allow [[+org_name]] to award you badges?</h5>
      
      <div class="small-6  large-6 columns" >
        <form action="fe-do-grant_access" id="grant_access_form">
          <input type="hidden" name="api_token" id="api_token" value="[[+api_token]]" />
          <input type="hidden" name="ouid" id="ouid" value="[[+ouid]]" />
          <input type="submit" id="yes" name="confirm" value="Yes - I approve" class="button round">
        </form>
      </div>
      <div class="small-6  large-6 columns" >
        <a href="[[+org_access_denied_url]]" class="button round cancel">No - Cancel and go back</a>
        <!--<input type="button" id="no" name="confirm" value="No - Cancel and go back" class="button round cancel"> -->
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">

$(document).on('submit', '#grant_access_form', 
  function(e){ 
    e.preventDefault();
    $.ajax({
    url: 'fe-ajax-json-passthrough',
    data: {
      endpoint: "/users/grant_access.json",
      payload: {api_token: $('#api_token').val(), ouid: $('#ouid').val()},
      method: "post"
    },
    dataType: "JSON",
    success: function(data) {
        
        if (data.status == 200 || data.status == 201) {
         window.location = data.result.redirect_url;
          
        } else {
          alert(data.errors);
        }
    },
    error: function(xhr, txtStatus, error ) {
      debugger;
    }
  });
    return false;
  });

</script>