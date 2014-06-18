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
                    <select name="badge-sort" id="badge_sort">
                        <option value="">Sort by</option>
                        <option value="date">date</option>
                        <option value="name">name</option>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="small-centered small-12 large-4 columns">
            <ul id="badge_items" class="small-block-grid-2 large-block-grid-3 text-center">
                [[+badge_items]]
            </ul>
        </div>
    </div>
</div>
<script src="[[++iremix_base_url]]/col/pathways/profile_widget?js=true&jwt=[[+jwt]]"></script>
<!--<iframe id="main_iframe" style="border: 0px;" src="[[++iremix_base_url]]/col/pathways/profile_widget" width="100%" height="0"></iframe>-->
<div class="profile-badges">
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
                <select name="activity-sort" id="activity_sort">
                    <option value="">Sort by</option>
                    <option value="date">date</option>
                    <option value="name">name</option>
                </select>
            </div>
        </div>
    </div>
    <br>
    <div id="activity_items" class="small-centered small-12 large-4 columns">
        [[+activities_items]]
    </div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
function compare_by_date(a, b) {
  return a.date.localeCompare(b.date);
}

function compare_by_name(a, b) {
   return a.name.localeCompare(b.name);
}

$(document).on("change", "#badge_sort", function(e){
 var arr = [];
 $('#badge_items li').each(function(){
    var meta = {date: $(this).attr("data-date"), name: $(this).attr("data-name"), elem: $(this)};
    arr.push(meta);
 });
 var sort_type = $(this).find('option:selected').val();
 if (sort_type == "date") {
    arr.sort(compare_by_date);
    } else {
        arr.sort(compare_by_name);
    }
 $.each(arr, function(index, item){
    item.elem.appendTo(item.elem.parent());
});
});

$(document).on("change", "#activity_sort", function(e){
 var arr = [];
 $('#activity_items .activity_item').each(function(){
    var meta = {date: $(this).attr("data-date"), name: $(this).attr("data-name"), elem: $(this)};
    arr.push(meta);
 });
 var sort_type = $(this).find('option:selected').val();
 if (sort_type == "date") {
    arr.sort(compare_by_date);
    } else {
        arr.sort(compare_by_name);
    }
 $.each(arr, function(index, item){
   item.elem.parent().appendTo(item.elem.parent().parent());
});
});

$(document).on("change", "#do_sort, #doing_sort, #done_sort", function(e){
         var arr = [];
         var t_id = '#' + $(this).attr("id");
         $(t_id + '_items .pw_item').each(function(){
            var meta = {date: $(this).attr("data-date"), name: $(this).attr("data-name"), elem: $(this)};
            arr.push(meta);
         });
         var sort_type = $(this).find('option:selected').val();
         if (sort_type == "date") {
            arr.sort(compare_by_date);
            } else {
                arr.sort(compare_by_name);
            }
         $.each(arr, function(index, item){
            item.elem.parent().appendTo(item.elem.parent().parent());
        });
        }); 



function alertsize(pixels){
    pixels+=32;
    document.getElementById('main_iframe').style.height=pixels+"px";
}

window.addEventListener('message',function(event) {
  
  console.log('message received:  ' + event.data,event);
  //event.source.postMessage('holla back youngin!',event.origin);
        var msg_data = event.data;
        if (msg_data.type == 'resize') {

        alertsize(msg_data.data);
        }
        if (msg_data.type == "redirect") {
            window.location = msg_data.data;
        }
},false);

</script>