<!--
@name MyProfilePage
@description Page for the Direct Sign up into COL
-->
[[!fe_get_profile]]
<div class="profile">
    <div class="small-12 columns">
        <h2 class="text-center">My profile</h2>
        <div class="small-centered small-6 large-2 columns">
            <img src="[[+preset_avatar_url]]" alt="avatar" class="text-center">
        </div>
        <br>
        <h4 class="text-center">[[+username]]</h4>
        <p class="text-center "><a href="my-account" class="link">View my account</a>&nbsp;/&nbsp;<a href="my-account#claim_codes_link" class="link">Enter my claim codes</a></p>
    </div>
    <div class="clearfix"></div>
</div>
<div class="profile-badges">
    <div class="small-12 columns">
        <div class="title-line small-centered small-12 large-8 columns">
            <h3 class="text-center">My Badges</h3>
            <hr class="line">
        </div>
        <div class="row">
            <div class="small-centered small-12 large-5 columns stats">
                <div class="small-6 columns">
                    <p class="text-center">[[+badge_count]] Badges</p>
                </div>
                <div class="small-6 columns">
                    <select name="badge-sort">
                        <option value="">Sort by</option>
                        <option value="date">date</option>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="small-centered small-12 large-4 columns">
            <ul class="small-block-grid-2 large-block-grid-3 text-center">
                [[+badge_items]]
            </ul>
        </div>
    </div>
    <div class="small-12 columns">
        <div class="title-line small-centered small-12 large-8 columns">
            <h3 class="text-center">My Learning Activities</h3>
            <hr class="line">
        </div>
    </div>
    <div class="row">
        <div class="small-centered small-12 large-5 columns stats">
            <div class="small-6 columns">
                <p class="text-center">[[+activities_count]] Activities</p>
            </div>
            <div class="small-6 columns">
                <select name="badge-sort">
                    <option value="">Sort by</option>
                    <option value="date">date</option>
                </select>
            </div>
        </div>
    </div>
    <br>
    <div class="small-centered small-12 large-4 columns">
        [[+activities_items]]
    </div>
    <div class="clearfix"></div>
</div>