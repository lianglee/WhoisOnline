<div class="ossn-page-contents">
	<strong><?php echo ossn_print('whoisonline');?></strong>
    <?php
		$users = whoisonline();
		if($users){
			$count = whoisonline(['count' => true]);
			echo ossn_plugin_view('output/users', array(
						'users' => $users,												  
			));
			echo ossn_view_pagination($count, 10, array(
						'offset_name' => 'online_users_page',								
			));
		} else {
			echo ossn_print('whoisonline:no');	
		}
	?>	
</div>