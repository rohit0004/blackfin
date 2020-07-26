function gProfile(gid){
var requ = "groupProfile";
var path = "<?php echo $check_path; ?>";
$.ajax({
    type:'POST',
    url:"../includes/group_channel_request.php",
    data:{'req':requ,'path':path,'gid':gid},
    beforeSend:function(){
   $('#g_profiles_loading').show();
    },
    success:function(data){
		 $('#g_profiles').html(data);
		 $('#g_profiles_loading').hide();
    }
}); 
}
