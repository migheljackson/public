<li id="sign_up"><a href="#" class="button radius">Sign Up</a>
  <div id="signup-pop" class="signup-pop-block" style="display:none;">
    <div class="signup-wrapper clearfix arrow_box">
      <div class="row">
        <form id="form_signin" action="[[fe_get_signin_url]]">
          <div class="small-12 columns">
            <label for="new"><span>New Users</span><br>
              <a href="/sign-up" class="button expand radius" title="new">Create An Account</a>
            </label>
            <hr>
            
            <label for="login"><span>Existing Users</span><br/>
              <span id="error_signin_username"  class="error_message"  style="display:none;"></span>
              <input type="text" id="signin_username" name="username" placeholder="username">
            </label>
            
            <label for="pass">
              <span id="error_signin_password" class="error_message" style="display:none;"></span>
              <input type="password" name="password"  id="signin_password" placeholder="password">
            </label>
          </div>
          <div class="large-12 columns">
            <a href="forgotten-password" class="link text-center">forgot your password?</a>
          </div>
          <div class="large-12 columns">
            <a href="forgotten-username" class="link text-center">forgot your username?</a>
          </div>
          <div class="small-6 columns">
            <input type="submit" class="button expand small radius" value="Sign in">
          </div>
        </form>
      </div>
    </div>
  </div>
</li>
