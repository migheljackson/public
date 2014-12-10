  <div class="row share-city">
    <div class="small-12 columns">
      <div class="small-12">
        <h4><strong>[[+username]] earned [[+badge_name]]</strong></h4>
        <p>on <time>[[+earned_on]]</time></p>
      </div>
      <div class="row">
        <div class="small-12 large-12 columns">
          <div class="small-12 columns panel">
            <div class="large-3 columns">
              <img src="[[+badge_url]]" alt="[[+badge_name]]" style="max-width: 200px;">
              <!--<a href="#" class="button small expand">View Badge Details</a>-->
            </div>
            <div class="large-9 columns">
              <p>[[+badge.description]]</p>
            </div>
          </div>
        </div>
        <!--
        <div class="small-12 large-6 columns">
          <div class="small-12 columns">
            <div class="show-for-medium-up clearfix panel">
              <h4>[BADGE CRITERIA SECTION]</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem ipsa, impedit pariatur cum soluta neque hic doloremque odio nemo, non.</p>
            </div>
            <div class="show-for-small panel">
              <a href="">See badge criteria</a>
            </div>            
          </div>
        </div>
      -->
      </div>
      <div class="row">
        <div class="small-12 columns">
          <h5><strong>Badges earned to achieve "[[+badge.name]]"</strong></h5>
        </div>
        <div class="small-12">
          <dl class="tabs" data-tab>
            [[+evidence_tabs]]
          </dl>
          <div class="tabs-content">
            [[+evidence_panels]]
          </div>
        </div>
      </div>
    </div>
  </div>