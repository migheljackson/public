  <div class="row share-city">
    <div class="small-12 columns">
      <div class="small-12">
        <br>
        <h4><strong>[[+username]] earned [[+badge.name]]</strong></h4>
        <p>on <time>[[+earned_on]]</time></p>
      </div>
      <div class="row">
       <div class="small-12 columns">
        <div class="small-12 columns panel bg-green">
         <div class="small-12 medium-4 large-2 columns">
          <img src="[[+badge_url]]" alt="[[+badge_name]]" style="max-width: 200px;">
          <!--<a href="#" class="button small expand">View Badge Details</a>-->
        </div>
        <div class="small-12 medium-8 large-8 columns end">
          <p>[[+badge.description]]</p> 
          [[+evidence_links]]
          
        </div>
      </div>
    </div>
    <div class="small-12 columns">
      <div class="small-12">
       <div class="show-for-medium-up clearfix">
        <hr>
        <p><strong>Issuer:</strong></p>

        <div class="small-12 large-3 left">
          <img src="[[+org.logo_url]]" alt="[[+org.name]]" style="max-width:100px;max-height:100px;">
        </div>
        <div class="row">
          <div class="small-12 large-8 end columns">  
            <p>[[+org.name]]</p>
            <a href="[[+org.url]]">[[+org.url]]</a> 
          </div> 
        </div>
        <div class="small-12">
          <p><strong>Badge type:</strong> <span>[[+badge.badge_type]]</span></p>   
        </div>
        <div class="small-12">
          <p><strong>Expected duration:</strong> <span>[[+badge.duration]]</span></p>
        </div>
              [[+badge_criteria]]
           
      
      
      <div class="small-12 columns">  
        <h6><strong>Earned by participate in:</strong></h6>
        <div class="small-12 left" style="outline:1px solid #ccc;">
          <div class="medium-6 large-2 left">
          <div class="small-centered small-12 show-for-small columns">
              <br>
              <img src="http://placehold.it/260x170" alt="" class="text-center">
            </div>  
            <div class="small-12 show-for-medium-up">
              <img src="[[+scheduled_program.logo_url]]" alt="[[+scheduled_program.name]]">
            </div>
            <p href="#" class="columns"><small>[[+org.name]]<br>  
              [[+scheduled_program_categories]]</small></p>
            </div>
            <div class="medium-6 large-8 columns end" style="padding-top:0.5em;">
              <a href="">[[+scheduled_program.name]]</a>
              <!--<p><strong>Free in person</strong></p>-->
              <p>[[+scheduled_program.description]]</p> 
                <div class="small-12 large-4 end">
                  <a target="_blank" href="[[++site_url]]workshop-detail?id=[[+scheduled_program.id]]" class="button small radius expand">Learn more</a>
                </div>
              </div>
            </div>
          </div>
        </div>          
      </div>
    </div>
  </div>

</div>
</div>