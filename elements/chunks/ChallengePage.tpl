<!--
@name ChallengePage
@description source for event details view
-->

[[!fe_do_iremix_login_sync]]

<iframe id="main_iframe" style="border: 0px;" src="[[++iremix_base_url]]/col/pathways/[[!parameter_extractor? &param=id]]" width="100%" height="1800"></iframe>

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
},false);
</script>