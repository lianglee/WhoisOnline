<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Core Team
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

ossn_register_callback('ossn', 'init', function (): void {
		ossn_extend_view('css/ossn.default', 'whoisonline/css');										 
		if(ossn_isLoggedin()){
			ossn_register_menu_item('newsfeed', array(
				'name' => 'whoisonline',
				'text' => ossn_print('whoisonline'),
				'href' => ossn_site_url('whoisonline'),
				'parent' => 'links',
			));			
			ossn_register_page('whoisonline', 'whoisonline_page_handler');
		}
});
function whoisonline(array $params = array()): int | array | bool {
		$time      = time();
		$intervals = 60;
		$users     = new OssnUser();
		$notself   = "";
		
		if(ossn_isLoggedin()){
			$user = ossn_loggedin_user();
			$notself  = "AND u.guid != {$user->guid}";
		}
		$default   = array(
				'offset' => input('online_users_page', '', 1),
				'wheres' => "(u.last_activity > {$time} - {$intervals} {$notself})",
		);
		$args = array_merge($default, $params);
		return $users->searchUsers($args);
}
function whoisonline_page_handler($pages): void {
		$title   = ossn_print('whoisonline');
		$content = ossn_set_page_layout('newsfeed', array(
				'content' => ossn_plugin_view('whoisonline/view', $params),
		));
		echo ossn_view_page($title, $content);
}