<?php

class UNPRO_Shortcodes {
	function __construct(){
		add_action( 'init', array($this, '_init'));
		add_action('admin_enqueue_scripts', array($this, '_admin_enqueue_scripts'));
		add_filter( 'tiny_mce_version', 'wp_ideas_refresh_mce' );
		add_shortcode('usernoise_link', array($this, '_usernoise_link'));
		add_shortcode('usernoise_button', array($this, '_usernoise_button'));
		add_shortcode('show_usernoise_button', array($this, '_show_usernoise_button'));
		add_shortcode('hide_usernoise_button', array($this, '_hide_usernoise_button'));
	}
	
	function _admin_enqueue_scripts($suffix){
		global $submenu_file;
		if (preg_match('/^edit\.php/', $submenu_file)){
			wp_enqueue_style('unpro-admin', usernoisepro_url('/css/admin.css'), UNPRO_VERSION);
			wp_enqueue_style('un-font-awesome', usernoise_url('/vendor/font-awesome/css/font-awesome.css'), UNPRO_VERSION);
		}
	}
	function _init(){
		if ((current_user_can('edit_posts') || current_user_can('edit_pages')) && get_user_option('rich_editing') == 'true'){
			add_filter('mce_external_plugins', array($this, '_mce_external_plugins'));
			add_filter('mce_buttons', array($this, '_mce_buttons'));
		}
	}
	
	function _mce_buttons($buttons){
		$buttons []= "|";
		$buttons []= "usernoise_button";
		return $buttons;
	}
	function _mce_external_plugins($plugins){
		$plugins['UsernoiseShortcodes'] = usernoisepro_url('/js/post-editor.js');
		return $plugins;
	}
	
	public function _usernoise_link($attributes = null, $content){
		global $un_h;
		if (!$attributes) $attributes = array();
		$attributes['rel'] = 'usernoise';
		return $un_h->_link_to($content, '#',  $attributes);
	}
	
	function _usernoise_button($attrs, $content){
		return '<button rel="usernoise" class="usernoise">' . esc_html($content) . "</button>";
	}
	
	function _show_usernoise_button(){
		return "<script>usernoiseButton.showButton = true; </script>";
	}
	
	function _hide_usernoise_button(){
		return "<script>usernoiseButton.showButton = false;</script>";
	}
	
}
$unpro_shortcodes = new UNPRO_Shortcodes;