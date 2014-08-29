<!--
@name UnsubscribeEmail
@description A simple form to unsubscribe from emails
-->

<section class="step" data-step-title="step-1">
  <div class="sign-up-page">
    <div class="small-12 large-centered large-9 columns">
      <h2 class="text-center">UNSUBSCRIBE MY EMAIL ADDRESS</h2>
      <hr>
      <h4 class="text-center" id="status">Are you sure you don't want to receive any notifications on [[!parameter_extractor? &param=email]] email address?</h4>
      <h5 class="text-center">**You will always receive an email if you request to reset your password.**</h5>
      <div class="small-12 large-centered large-6 columns" >
        <form action="fe-do-unsubscribe-email" id="delete_account">
          <input type="hidden" name="email" value="[[!parameter_extractor? &param=email]]" />
          <label for="yes">
            <input type="radio" id="yes" name="confirm" value="yes">
            Yes, unsubscribe me from any email notifications.
          </label>
          <label for="no">
            <input type="radio" id="no" name="confirm" value="no">
            No, I want to receive email notifications.
          </label>
          <div class="" id="reason_yes" style="display:none;">
            <label for="">
              Optional: Why do you want to stop receiving emails? 
              <br>
              (Check all that apply)
            </label>
            <label for="opt1">
              <input type="checkbox" name="reasons[]" value="Not interested in reading them." id="opt1" style="visibility:visible">
              Not interested in reading them.
            </label>
            <label for="opt2">
              <input type="checkbox" name="reasons[]" value="You send too many emails" id="opt2" style="visibility:visible">
              You send too many emails
            </label>
            <label for="opt3">
              <input type="checkbox" name="reasons[]" value="I do not use my email regularly" id="opt3" style="visibility:visible">
              I do not use my email regularly
            </label>
            <label for="opt5">
              <input type="checkbox" name="reasons[]" value="I do not use my email regularly" id="opt5" style="visibility:visible">
              I do not use my email regularly
            </label>
            <label for="opt6">
              <input type="checkbox" name="reasons[]" value="I prefer text messages" id="opt6" style="visibility:visible">
              I prefer text messages
            </label>
            <label for="opt7">
              <input type="checkbox" name="reasons[]" value="I'm too busy to read them" id="opt7" style="visibility:visible">
              I'm too busy to read them
            </label>
            <label for="opt4">
              <input type="checkbox" name="reasons[]" value="other" id="opt4" style="visibility:visible">
              Other
            </label>
            <textarea id="other_reason" style="display:none" name="reasons[]"></textarea>
            <input type="submit" class="button small expand radius next-step" value="Submit" /><br><br>
          </div>
        </form>
        <div id="reason_no" style="display:none;">
          <a href="/explore" class="button small expand radius next-step">Keep on exploring</a>
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
        if (json.status==200) {
          $('#status').text("Confirmation! You are now unsubscribed from email notifications.");
          $('#delete_account').hide();
          $('#reason_no').show();
        } else {
          alert("There was an error unsubscribing the email address. Please try again or contact support at ccol.support@digitalyouthnetwork.org and ask them to remove account with [[+username]] username.")
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