<!--
@name ProfileBadgeItem
@description Item to list badge
-->
  <li class="profile_badge_detail" data-date="[[+sort_awarded_at]]" data-name="[[+badge_name]]">
	<a href="badge-details?id=[[+badge_id]]"><img class="badge_image" src="[[+badge_image_url]]" alt="[[+badge_name]]" ></a>
    
      <div class="badge_stuff badge_details" >
      <p class="badge_name">[[+badge_name]]</p>
      <p class="badge_earned" style="">Earned: <time datetime="[[+awarded_at]]">[[+awarded_at]]</time>
      </p>
      <span><a href="badge-details?id=[[+badge_id]]" class="button small radius round"> View Badge</a></span>
      </div>
  </li>