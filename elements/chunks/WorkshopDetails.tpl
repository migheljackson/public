<!--
@name workshopDetails
@description source for workshop details view
-->

[[!setSelectedPageClass? &page=`explore-body`]]
[[!fe_getworkshop]]
  <div class="row banner" id="workshop-pg" style="max-width:100%">
    <div class="large-12 columns mini-wrapper" style="">
      <h3 class="pg-title">EXPLORE</h3>
    </div>
  </div>

  <div class="row">
      <div class="small-2 large-2 columns" style="padding-top:.75em;height:1.5em;"><a href="#" onclick="history.go(-1); return false;">< Go Back</a></div>
  </div>

  <div class="row workshop">
    <div class="large-12 columns">
      <div class="items small-spacer-top">
        <div class="row">
          <div class="small-7 small-offset-2 large-7 large-offset-2" style="text-align:center">
              <h2 class="item-title">[[+name]]</h2>
              <p id="workshop-desc" style="text-align:left;text-overflow: ellipsis;height:100px; overflow: hidden; padding-bottom: 15px;position:relative;">[[+description]]</p>
              [[+reg_button]] [[+prog_button]]
          </div>
        </div>
        <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-3">
          <li>
            <h4 class="event-block-title center">time & place</h4>
            <div class="event-block clearfix">
              <div class="row">
                <div class="small-10 small-offset-1 large-offset-1 large-10 column">
                  <img src="/assets/images/cal-icon.png" class="left" style="padding-top:10px">
                  <p style="margin-left:33px">Starts [[+start_date]]</p><p style="margin-left:33px">Ends [[+end_date]]</p>
                </div>
              </div>
              <div class="row">
                <div class="small-10 small-offset-1 large-offset-1 large-10 column">
                  <img src="/assets/images/clock-icon.png" class="left" style="padding-top:10px">
                  <p style="margin-left:33px">Starts [[+start_time]]</p><p style="margin-left:33px">Ends [[+end_time]]</p>
                </div>
              </div>
              <div class="row">              
                <div class="small-11 small-offset-1 large-offset-1 large-11 column">
                  <img src="/assets/images/map-icon.png" class="left" style="padding-top:10px">
                  <p style="margin-left:33px">[[+location_name]]</p>
                  <p style="margin-left:33px">[[+address]]</p>
                  <p style="margin-left:33px">[[+city]],[[+state]] [[+zipcode]]</p>
                </div>
              </div>
            </div>
          </li>
          <li>
            <h4 class="event-block-title center">map</h4>
            <div id="map-canvas" class="event-block small-map clearfix"></div>
          </li>
          <li>
            <h4 class="event-block-title center">workshop info</h4>
            <div class="event-block clearfix">
              <div class="row">
                <div class="small-6 large-12 columns">
                  <p style="color: #35BDD3;">[[+price]]</p>
                  <p>Registration Deadline: [[+registration_deadline]]</p>
                  <ul class="work-cat">
                    [[+categoryHtml]]
                  </ul>
                </div>
                <hr/>
              </div>
              <div class="row">              
                  <div class="small-6 large-12 columns">
                    <p>Organization</p>
                    <p>[[+org_name]]</p>
                  </div>
                </div>
            </li>
            [[+contactHtml]]
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="large-12 columns" >
          <div class="events related-item clearfix" style="background-color:#E9E9E9;">
            <h5 class="item-title" style="text-align:center;">Did you find what you were looking for? If not, then keep exploring!</h5>
              <a href="explore" class="large button radius left" style="text-align:center;">KEEP EXPLORING</a>
              <br/>
          </div>
        </div>  
    </div>    
    <br/>
    
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZ5b_ROG8eqS9bogFLE1A7R8T3fBbc6Sw&sensor=false">
    </script>
    <script type="text/javascript">
      var orgHeight;
      function expandDesc() {
          var element = document.querySelector('#workshop-desc');
          $("#workshop-desc").height(element.scrollHeight);
          $("#expand-btn").attr("onclick","minimizeDesc();").text('show less');
      }
      function minimizeDesc() {
          // var element = document.querySelector('#workshop-desc');
          $("#workshop-desc").height(orgHeight);
          $("#expand-btn").attr("onclick","expandDesc();").text('show more');
      }
      function initialize() {
        $('.small-map').height($($('.event-block')[0]).height() + 16);
        var curLatLng = new google.maps.LatLng([[+latitude]], [[+longitude]]);
        var mapOptions = {
          center: curLatLng,
          zoom: 12
        };
        var map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
        // To add the marker to the map, use the 'map' property
        var marker = new google.maps.Marker({
            position: curLatLng,
            map: map,
            title:"[[+location_name]] - [[+address]]"
        });
      }
    
      $(document).ready(function() {
        initialize();
        var element = document.querySelector('#workshop-desc');
        if(element.offsetHeight < element.scrollHeight){
            $("#workshop-desc").append("<a id='expand-btn' style='position:absolute; bottom:0; right:0;' onclick='expandDesc();'>show more</a>");
            orgHeight = element.offsetHeight;
        }
        else{
          //your element don't have overflow
        }
      });
    </script>