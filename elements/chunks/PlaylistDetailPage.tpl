<!--
@name PlaylistDetailPage
@description source for event details view
-->
<!--<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.3.7/slick.css"/>-->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.2/owl.carousel.min.css"/>
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
						<div class="small-12 large-10 large-centered columns carrouselle">
							<div class="large-1 show-for-medium-up columns">
								<a href="#" class="middle orbit-prev"><i class="fa fa-chevron-left fa-3x"></i></a>
							</div>
							<div class="large-5 small-12 columns">
								<div id="playlist_media" class="" style="max-height:280px important!">
									
									[[+media-items]]
																									
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
						<div class="panel small-12 large-10 large-centered columns clearfix">
							<ul class="small-block-grid-1 large-block-grid-4 columns">
								[[+playlist-items]]
							</ul>
						</div>
					</div>
				</div>
				<!--<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.3.6/slick.min.js"></script>-->
				<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.2/owl.carousel.min.js"></script>
				
				<script>

				$(document).on('click', '.orbit-prev', function (e) {
					e.preventDefault();
					var owl = $("#playlist_media").data('owlCarousel');
					owl.prev();
					return false;
				});
				$(document).on('click', '.orbit-next', function (e) {
					e.preventDefault();
					var owl = $("#playlist_media").data('owlCarousel');
					owl.next();
					return false;
				});

				$(function(){

					$("#playlist_media").owlCarousel({
 
      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem: true,
 			 navigationText: [
      "<i class='fa fa-chevron-left icon-white fa-3x'></i>",
      "<i class='fa fa-chevron-right icon-white fa-3x'></i>"
      ],
 
  });
					
					/*
						$('#playlist_media').slick({
							nextArrow: '.orbit-next',
							prevArray: '.orbit-prev',		
							//vertical: true
							onBeforeChange: function(){  $('#playlist_media div').show(); }					
						});
					*/
					});
				</script>

				<!-- playlist end -->
