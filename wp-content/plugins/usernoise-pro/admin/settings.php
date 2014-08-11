<?php
global $unpro_settings;
class UNPRO_Settings{
	public function __construct(){
		add_filter('un_options', array($this, 'filter_un_options'));
		add_filter('un_notification_options', array($this, 'filter_notification_options'));
	}
	
	public function filter_notification_options($options){
		$options []= array('type' => 'text', 'name' => UNPRO_ADMIN_NOTIFICATION_EMAIL,
			'title' => __('Admin notifications email', 'usernoise-pro'), 'class' => 'medium',
			'default' => get_option('admin_email'));
		return $options;
	}
	
	public function filter_un_options($options){
		$this->h = new HTML_Helpers_0_4;
		$options []= array('type' => 'tab', 'title' => __('Pro', 'usernoise'));
		$options []= array('type' => 'checkbox', 'name' => UNPRO_ENABLE_DISCUSSIONS,
			'title' => __('Enable feedback list &amp; discussions.', 'usernoise-pro'),
			'label' => __('Enable feedback list &amp; discussions.', 'usernoise-pro'),
			'default' => true);
		$options []= array('type' => 'checkbox', 'name' => UNPRO_USE_ADVANCED_DEBUG,
			'title' => __('Enable advanced debug info', 'usernoise-pro'),
			'label' => __('Enable advanced debug info', 'usernoise-pro'),
			'legend' => __('Dont use in production to prevent system info disclosure.'));
		$options []= array('type' => 'checkbox', 'name' => UNPRO_ENABLE_FEEDS,
			'title' => __('Enable RSS feeds for feedback published', 'usernoise-pro'),
			'default' => false);
		$options []= array('type' => 'text', 'title' => __('Site URL in notifications', 'usernoise-pro'),
			'name' => UNPRO_NOTIFICATIONS_SITE, 'default' => get_bloginfo('url'), 'class' => 'medium');
		$options []= array('type' => 'section', 'title' => __('Button', 'usernoise-pro'));
		$options []= array('type' => 'select', 'name' => UNPRO_SHOW_FEEDBACK_BUTTON,
			'title' => __('Show feedback button', 'usernoise-pro'),
			'legend' => __('Change the feedback button visibility mode', 'usernoise-pro'),
			'values' => $this->h->hash2options(array('' => __('Everywhere', 'usernoise-pro'), 'registered' => __('To registered users only', 'usernoise-pro'), 'no' => __('Nowhere', 'usernoise-pro'))),
			'default' => '');
		$options []= array('type' => 'checkbox', 'name' => UNPRO_DISABLE_BUTTON_ON_LOGIN,
			'title' => __('Hide Feedback button on login, registration and password retrieval pages', 'usernoise-pro'),
			'label' => __('Hide Feedback button on login, registration and password retrieval pages', 'usernoise-pro'));
		$options []= array('type' => 'text', 'name' => UNPRO_CUSTOM_BUTTON_ID,
			'title' => __('Custom "Feedback" button HTML ID', 'usernoise-pro'),
			'class' => 'small',
			'legend' => __('Usernoise window will be shown upon click of element with that ID. For example, if you have the next link: <code>&lt;a href="#" id="my-link"&gt;some link&lt;/a&gt;</code>, put "my-link" here.'));
		$options []= array('type' => 'textarea', 'name' => UNPRO_CUSTOM_BUTTON_CSS,
			'title' => __('Custom CSS properties', 'usernoise-pro'),
			'legend' => __('Usernoise button custom CSS properties. Remove /* and */ to enable. Don\'t put here HTML tags.', 'usernoise-pro'),
			'default' => "/*\r\ncolor: white;\r\nbackground: #444;\r\nfont: 14px bold;\r\nborder: 2px solid white;\r\n*/",
			'rows' => '6');
		$options []= array('type' => 'section', 'title' => __('Form design', 'usernoise-pro'));
		$options []= array('type' => 'textarea', 'name' => UNPRO_FORM_CSS, 
			'title' => __('Custom CSS for Usernoise window', 'usernoise-pro'), 'rows' => 10,
			'legend' => __("You can override the form's style by applying your own CSS. Don't forget to remove comment symbols and do not put HTML tags here.", 'usernoise-pro'),
			'default' => "/*
h2{
	font-size: 29px;
}
p{
	font-size: 13px;
	line-height: 18px;
}
#types-wrapper li{
	
}
#types-wrapper li a{
	
}
textarea#un-description{
	
}
form input[type=text]{
	
}
form input[type=submit]{
	
}
*/");
		$options []= array('type' => 'custom', 
			'title' => __('HTML code for external usage.', 'usernoise-pro'),
			'legend' => __('Copy this HTML code into your site\'s <head> tag and use Usernoise on the external site. It is recommended to have your site on the same domain as Usernoise is. <strong>Please make sure to update the code if you change Usernoise settings.', 'usernoise-pro'),
			'html' => $this->h->_textarea('', unpro_get_external_code(), array('readonly' => true, 'rows' => 10)));
		return $options;
	}
	
}

$unpro_settings = new UNPRO_Settings;