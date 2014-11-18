<!--
@name badgeDetails
@description source for workshop details view
-->

[[+page_sub_header]]
<div class="small-12 left resume clearfix">
  <div class="small-12 large-6 large-centered columns">
    <h5 class="text-center">[[+name]]</h5>
    <div class="small-centered small-6 columns text-center">
      <img style="max-height:225px" src="[[+image_url]]" title="[[+name]]" alt="[[+name]]" class="th">
    </div>
    <div class="info-tip text-center rounded small-centered small-6 large-centered large-5 columns"><p>[[+issue_count]] learners earned this badge</p></div>
  </div>
</div>

<div class="small-12 columns playlists">
  <div id="sys_notification_box" class="large-12 large-centered text-center panel callout radius" style="background: #fff;display:none;">
    <h4 id="system_notification">
    </h4>
  </div>
  <div class="row">
    <div class="small-12 large-centered large-7 columns badge-resume">
      <p>[[+description]]</p>
              [[+issuer]]
        [[+issuedate]]
        [[+evidence]] 
        <p><strong>Badge Type:</strong> [[+badge_type]]</p>
        [[+duration]]
        [[+criteria]]      
        [[+activityList]]

                     
        </div>
      </div>
    </div>
    <div class="small-12 clearfix left">
      <div class="central-panel badge-panel small-12 left">
        <div class="row">
          <div class="small-12 columns">
            <h5 class="title-slide">EXPLORE SIMILAR BADGES</h5>
            <ul class="small-block-grid-1 large-block-grid-4 columns">
              [[+badgeList]]
                                 
            </ul>
          </div>
        </div>
      </div>
    </div>