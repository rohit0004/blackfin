<?php 
$req = filter_var(htmlentities($_POST['req']),FILTER_SANITIZE_STRING);
switch ($req) {
 case 'username':
 echo "<div id=\"myModal\" class=\"custom_display\">
  <div class=\"modal-content\">
    <span class=\"close\">&times;</span>
	<div style=\"text-align:center;\">
   <p for=\"postcolor\">Select custom background color:</p>
   <input type=\"color\" id=\"backgroundcolor\" name=\"postcolor\"  onchange=\"myFunction()\">
   </div>
  </div>
</div> ";
 
 break; 
/*case 'firsthomeui':
$tc = filter_var(htmlentities($_GET['tc']),FILTER_SANITIZE_STRING);
if (is_dir("imgs/")) {
        $check_path = "";
    }elseif (is_dir("../imgs/")) {
        $check_path = "../";
    }elseif (is_dir("../../imgs/")) {
        $check_path = "../../";
    }
?>
<div class="container-fluid">
 <?php switch ($tc) { ?>
 <?php case 'search':?>
<?php break; ?>
<?php case 'search':
if($tc == 'search'){
		echo"
		<style>
		.rohit{display:none;}.discover{display:block;}
		</style>";
	}
	 ?>
<div>
 <div id="Search"  style="height: auto;">

      <div>
  <div style="margin:0px auto; max-width:600px;">
  <div class="navbar_fetchBox" id="search_r">
  <div  id="getSearchResult" class="scrollbar" style="overflow: auto;max-height: 450px;"></div>
  <p  id="LoadingSearchResult" style="background: url(imgs/loading_video.gif) center center no-repeat;width: 100%;height: 80px;margin: 0px;display: none;"></p>
  </div>
  <div  id="roh">
  <?php
  ?>
  
	  </div>
       </div>
  </div>
	</div>
</div>
<?php break; ?>
<!--====================[ Languages section ]======================-->
<?php case 'video': ?>
<div style="margin-top:70px;">
<div id="Video"  style="height: auto;">
<div style="margin:0px auto; max-width:600px;">
 <div data-addui='tabs'>
    <div role='tabs'>
      <div><?= _FOR_YOU ?></div>
      <div><?= _FOLLOWING ?></div>
    </div>
    <div role='contents'>
      <div>
	  
 <?php
echo "show following video";
?>
	  
       </div>
 <div>
<?php
echo "show following video";
?>

      </div>
    </div>
  </div>
  
  </div>
    
</div>
</div>
<?php break; ?>
<?php case 'audio': ?>
<div style="margin-top:70px;">
<div id="Audio"  style="height: auto;">
   <!---message-->
  <div style="margin:0px auto; max-width:600px;">
	 <div data-addui='tabs'>
    <div role='tabs'>
      <div><?= _FOR_YOU ?></div>
      <div><?= _FOLLOWING ?></div>
	    <div><?= _FOR_YOU ?></div>
    </div>
    <div role='contents'>
	    <div>
<div class="group" style="margin-top:50px;">
    	<div class="messages_col1">
    		<div class="mCol1_title">
    		<input type="text" class="m_contacts_search" id="mU_search" name="mU_search" placeholder="<?= _SEARCH ; ?>" />
    		</div>
			<div id="m_contacts" class="scrollbar" style="position: absolute; top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto; padding:12px;">
            <p class="m_contacts_title"><?= _REQUEST  ?></p>
                <div id="m_contacts_requests">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
                <br>
                <p class="m_contacts_title" style="border-top: 1px solid #d0d4d8;"><?= _FRIENDS ; ?></p>
                <div id="m_contacts_friends">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
</div> 
<div id="m_contacts_search" class="scrollbar" style="position:absolute;display:none;top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto;padding:12px;"></div>
</div> 
        </div>
		</div>
		<!----->	
     <div>
  	  <div class="container-fluid">
<div class="group" style="margin-top:50px;">
    	<div class="messages_col1">
			<div id="m_groups" class="scrollbar" style="position: absolute; top: 0; right: 0; left: 0; bottom: 0; overflow: auto; padding:12px;">
                <br>
                <p class="m_contacts_title"><?= _FRIENDS ; ?></p>
                <div id="m_contacts_group">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
</div> 
</div> 
        </div>
		</div>
</div>
<!----->
  <div>
	<div class="group" style="margin-top:50px;">
    	<div class="messages_col1">
    		<div class="mCol1_title">
    		<input type="text" class="m_contacts_channals" id="mG_search" name="mG_search" placeholder="<?= _SEARCH ; ?>" />
    		</div>
			<div id="m_channels" class="scrollbar" style="position: absolute; top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto; padding:12px;">
                <p class="m_contacts_title"><?= _FRIENDS ; ?></p>
                <div id="m_contacts_channals">
                    <div style="text-align: center; padding: 15px;"><img src="<?= $check_path; ?>imgs/loading_video.gif"></div>
                </div>
</div> 
<div id="m_channels_search" class="scrollbar" style="position:absolute;display:none;top: 0; right: 0; left: 0; bottom: 0; margin-top: 50px; overflow: auto;padding:12px;"></div>
</div> 
        </div>
</div>
<!----->
</div>
</div>	
</div>  
 <!---message-->  
  </div>
<?php break; ?>
<?php case 'notification': ?>
<div>
<?php
echo "notificatioon";
?>
</div>
<?php break; ?>
<!--====================[ General section ]======================-->
<?php default: ?>

<div id="Home"  style="height: auto;">
    	<div style="margin:0px auto; max-width:600px;">
	 <div class="write_post" style="margin-top:60px;">
            
                    <?php include("includes/w_post_form.php"); ?>
                </div>
  <div data-addui='tabs'>
  <div>
    <div role='tabs'>
      <div id="foryoupost"><?= _FOR_YOU ;?></div>
      <div id="followingpost"><?= _FOLLOWING ?></div>
      <div id="group_post" onclick="getfile('modal')">Groups</div>
    </div>
	</div>
    <div role='contents'>
      <div>
	  <div id="foryou">
			</div>
			<div id="m_post_loading" style='text-align: center; padding: 15px;'><img src='<?php echo $check_path; ?>imgs/loading_video.gif'></div>
       </div>
	
	   <!---->
	  
      <div>
	  <div id="following_home">
	  <div id="m_post_loading" style='text-align: center; padding: 15px;'><img src='<?php echo $check_path; ?>imgs/loading_video.gif'></div>
			</div>
       </div>
	  
	 
      <div>  
	<div id="groups_post_home">
	<div id="m_post_loading" style='text-align: center; padding: 15px;'><img src='<?php echo $check_path; ?>imgs/loading_video.gif'></div>
			</div>
       </div>
	   
	 
       </div>
    </div>
  </div>
	
  
  </div>
  
   
<?php  break; } ?>

 </div>
 
</div>
<?php 
break;*/

}
?>