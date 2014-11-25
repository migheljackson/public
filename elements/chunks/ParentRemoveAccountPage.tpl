<!--
@name ParentRemoveAccountPage
@description Page to remove a learner's account
-->
[[!fe_get_account_remove_params]]
<section class="step" data-step-title="step-1">
  <div class="sign-up-page">
    <div class="small-12 large-centered large-9 columns">
      <h2 class="text-center">DELETE ACCOUNT</h2>
      <hr>
      <h4 class="text-center" id="status">[[+form_title]]</h4>
      <div class="small-12 large-centered large-6 columns" >
        <form action="fe-do-delete-account" id="delete_account">
          <input type="hidden" name="veto_token" value="[[+veto_token]]" />
          <input type="hidden" name="username" value="[[+username]]" />
          <input type="hidden" name="origin" value="[[+origin]]" />
          <label for="yes">
            <input type="radio" id="yes" name="confirm" value="yes">
            [[+yes_label]]
          </label>
          <label for="no">
            <input type="radio" id="no" name="confirm" value="no">
            [[+no_label]]
          </label>
          <div class="" id="reason_yes" style="display:none;">
            <label for="">
              [[+reasons_title]]
              <br>
              (Select all that apply)
            </label>
            [[+extra_option]]
            <label for="opt2">
              <input type="checkbox" name="reasons[]" value="I need more information on Chicago City of Learning." id="opt2" style="visibility:visible">
              I need more information on Chicago City of Learning.
            </label>
            <label for="opt3">
              <input type="checkbox" name="reasons[]" value="I do not wish to engage in Chicago City of Learning." id="opt3" style="visibility:visible">
              I do not wish to engage in Chicago City of Learning.
            </label>
            <label for="opt4">
              <input type="checkbox" name="reasons[]" value="other" id="opt4" style="visibility:visible">
              Other
            </label>
            <textarea id="other_reason" style="display:none" name="reasons[]"></textarea>
            <input type="submit" class="button small expand radius next-step" value="Continue" /><br><br>
          </div>
        </form>
        <div id="reason_no" style="display:none;">
          <a href="/" class="button small expand radius next-step">Learn more about City of Learning</a>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
$(function() {
  $('input[name="confirm"]').on("change", function(e) {
    e.preventDefault();
    if ($('input[name="confirm"]:checked').val() == "yes") {
      $('#reason_yes').show();
      $('#reason_no').hide();

    } else {
      $('#reason_yes').hide();
      $('#reason_no').show();
    }
    return false;
  });

  $('#opt4').on("change", function(e) {
    e.preventDefault();
    if ($('#opt4:checked').val() == "other") {
      $('#other_reason').show();
    } else {
      $('#other_reason').hide();
    }
    return false;
  });

  $('#delete_account').on("submit", function(e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      data: $("#delete_account").serialize(),
      url: $("#delete_account").attr("action"),
      success: function(data) {
        var json = JSON.parse(data);

        console.log(json.status);
        if (json.result.status==200) {
          $('#status').text("The account has been deleted!");
          $('#delete_account').hide();
          $('#reason_no').show();
        } else {
          alert("There was an error deleting the account. Please try again or contact support at ccol.support@digitalyouthnetwork.org and ask them to remove account with [[+username]] username.")
        }
        
        
      },
      error: function() {
        alert("There was an error deleting the account. Please contact support at ccol.support@digitalyouthnetwork.org and ask them to remove account with [[+username]] username.")
      }
    });
    return false;
  });
});
</script>