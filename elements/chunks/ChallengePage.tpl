<!--
@name ChallengePage
@description source for event details view
-->

[[!fe_do_iremix_login_sync]]

<iframe id="main_iframe" style="border: 0px;" src="[[++iremix_base_url]]/col/pathways/[[!parameter_extractor? &param=id]]?start=[[!parameter_extractor? &param=start]]&challenge=[[!parameter_extractor? &param=activity]]&jwt=[[+jwt]]" width="100%" height="1800"></iframe>

<script>
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
        if (msg_data.type == "scroll") {
          window.scrollTo(0,0);
        }
        if (msg_data.type == "redirect") {
            window.location = msg_data.data;
        }
        if (msg_data.type == "scroll_height_request") {
          var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
          var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)
          var iframe_st =  $('#main_iframe').scrollTop();
          var sx, sy, d= document, r= d.documentElement, b= d.body;
          sx= r.scrollLeft || b.scrollLeft || 0;
          sy= r.scrollTop || b.scrollTop || 0;
          var msg = {type: "scroll_height", w: w, h: h, iframe_st: iframe_st, sx: sx, sy: sy};
          document.getElementById('main_iframe').contentWindow.postMessage(msg, '*');
        }
},false);
</script>