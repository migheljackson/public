<!--
@name badgeDetails
@description source for workshop details view
-->

[[!get-badge-details]]

<div class="profile-badges">
<div class="small-12 columns" style="background:#eaf9fc;">
<div class="small-12 columns">
<div class="title-line small-centered small-12 large-10 columns">
<h3 class="text-center" style="background:#eaf9fc;">[[+name]]</h3>
<hr class="line">
<a href="#">< back </a>
</div>

<div class="row">
<div class="small-centered small-12 large-5 columns stats">
<div class="small-centered small-6 large-8 columns ">
<img src="[[+image_url]]" title="[[+name]]" alt="[[+name]]"/>
<br>
<h5 class="text-center"><strong>Issuer:</strong></h5>
<img src="[[+org.logo_url]]" style="max-height:50px" class="left"/> <p class="text-center">[[+org.name]]
<br/><a href="[[+org.url]]" title="[[+org.description]]">[[+org.url]]</a></p>
[[+issuedate]]
</div>

<br>
<h5 class="text-center"><strong>Description:</strong></h5>
<p class="text-center">[[+informal_description]]</p>
<p class="text-center"><strong>Badge Type:</strong> [[+badge_type]]</p>
<p class="text-center"><strong>Expected Duration:</strong> [[+duration]]</p>

[[+criteria]]
</div>
</div>

</div>
</div>
</div>
<div class="clearfix"></div>
</div>