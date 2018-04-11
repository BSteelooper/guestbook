<?php
//This is a module for pluck, an opensource content management system
//Website: http://www.pluck-cms.org

//LICENSE: MIT

//Make sure the file isn't accessed directly
defined('IN_PLUCK') or exit('Access denied!');

function guestbook_info() {
	global $lang;
	$module_info = array(
		'name'          => $lang['guestbook']['name'],
		'intro'         => $lang['guestbook']['intro'],
		'version'       => '0.1',
		'author'        => $lang['guestbook']['author'],
		'website'       => 'http://xobit.nl',
		'icon'          => 'images/icon.png',
		'compatibility' => '4.7'
	);
	return $module_info;
}
 
?>
