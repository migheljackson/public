<!--
@name TileItem
@description tile to be used for badges and activites
-->

<li>
  <div class="tile clearfix">
    <div class="small-12 medium-12 large-12 medium-centered columns">
      <div style="min-height:200px;">
      <a href="[[+link]][[+id]]" title="[[+name]]">
        <img src="[[+logo_url]]" alt="[[+name]]">
      </a>
      </div>
      <h3 class="text-center">[[+name]]</h3>
      <hr>
    </div>
    <div class="columns content-200">
      [[+description]]
    </div>
    <div class="columns main-action clearfix">
      <a href="[[+link]][[+id]]" title="[[+name]]" class="button expand radius action">LEARN MORE</a>
    </div>  
  </div>        
</li>