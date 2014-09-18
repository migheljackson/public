<!--
@name PlaylistDetailPage
@description source for event details view
-->

[[!fe_get_playlist? &playlist_id=`[[+playlist_id]]`]]

				<!-- playlist start -->
				<div class="small-12 columns playlists">
					<h3>LEARNING PLAYLISTS</h3>
					<!-- breadcrumbs -->
					<ul class="breadcrumbs">
						<li><a href="#">EXPLORE</a></li>
						<li><a href="#">PLAYLISTS</a></li>
						<li class="current"><a href="#">DETAIL</a></li>
					</ul>
					<!-- playlist short resume -->
<div id="sys_notification_box" class="large-12 large-centered text-center panel callout radius" style="background: #fff;display:none;"> 
<h4 id="system_notification">

</h4>
</div>
					<div class="small-12 large-8 large-centered columns">

						<div class="large-3 small-12 columns">
							<img src="[[+playlist-logo]]" class="center-text th" alt="">
						</div>
						<div class="large-9 small-12 columns">
							<h4>[[+playlist-name]]</h4>
							<p>[[+playlist-blurb]]</p>
							[[$PlaylistDetailUserWidget?playlist_id=[[+playlist_id]]]]
							
						</div>
					</div>
					<hr>
					<!-- playlist carrouselle -->
					<div class="row">
						<div class="small-12 large-11 large-centered columns carrouselle">
							<div class="large-1 show-for-medium-up columns">
								<a href="#" class="middle orbit-prev"><i class="fa fa-chevron-left fa-3x"></i></a>
							</div>
							<div class="large-5 small-12 columns">
								<div class="featured" >
									<ul data-orbit>
									[[+media-items]]
									</ul>																	
								</div>
							</div>
							<div class="large-1 show-for-medium-up columns">
								<a href="#" class="middle orbit-next"><i class="fa fa-chevron-right fa-3x"></i></a>
							</div>							
							<div class="small-12 large-5 columns">
								<p>[[+playlist-description]]</p>
								[[+badge-items]]
							</div>
						</div>
					</div>
					<!-- Playlist items -->
					<div class="row">
						<div class="panel small-12 columns">
							<ul class="small-block-grid-1 large-block-grid-4 columns">
								[[+playlist-items]]
							</ul>
						</div>
					</div>
				</div>
				
				<script>
				$(function(){
					$(document).foundation({
						orbit: {
							navigation_arrows: false,
      				next_class: 'orbit-next', // Class name given to the next button
      				prev_class: 'orbit-prev', // Class name given to the previous button
      				variable_height: false, // Does the slider have variable height content?
      				swipe: true
  				}
				});
					
					});
				</script>

				<!-- playlist end -->
