<?php
class UNPRO_Controller{
	function __construct(){
		global $un_controller;
		add_action('un_after_feedback_form', array($this, 'action_un_after_feedback_form'));
		add_action('un_before_feedback_form', array($this, 'action_un_before_feedback_form'));
		add_action('un_feedback_content_top', array($this, 'action_un_feedback_content_top'));
		
		remove_action('un_feedback_form_body', array($un_controller, 'action_un_feedback_form_body'), 100);
		add_action('un_feedback_form_body', array($this, 'action_un_feedback_form_body'));
		add_action('un_after_feedback_wrapper', array($this, '_un_after_feedback_wrapper'));
		add_filter('un_window_class', array($this, '_un_window_class'));
		add_action('un_head', array($this, '_un_head'));
		
		
		add_action('wp_ajax_un_get_feedback', array($this, 'action_un_get_feedback'));
		add_action('wp_ajax_nopriv_un_get_feedback', array($this, 'action_un_get_feedback'));
		
		add_action('wp_ajax_un_like', array($this, 'action_like'));
		add_action('wp_ajax_nopriv_un_like', array($this, 'action_like'));
		
		add_action('wp_ajax_un_dislike', array($this, 'action_dislike'));
		add_action('wp_ajax_nopriv_un_dislike', array($this, 'action_dislike'));
		
		add_action('wp_ajax_un_submit_comment', array($this, 'action_unpro_submit_comment'));
		add_action('wp_ajax_nopriv_un_submit_comment', array($this, 'action_unpro_submit_comment'));
	
		add_action('wp_ajax_un_get_discussion', array($this, 'action_unpro_get_comments'));
		add_action('wp_ajax_nopriv_un_get_discussion', array($this, 'action_unpro_get_comments'));

		add_action('wp_set_comment_status', array($this, '_wp_set_comment_status'), 10, 2);
	}
	
	public function _wp_set_comment_status($comment_id, $status){
		$comment = get_comment($comment_id);
		$post = get_post($comment->comment_post_ID);
		if ($post->post_type != FEEDBACK || $post->post_author != 0){
			return;
		}
		global $unpro_model;
		$unpro_model->notify_feedback_author_on_comment($comment_id);
	}
	public function action_like(){
		$id = (int)$_REQUEST['id'];
		global $unpro_model;
		$likes = $this->extract_likes();
		$dislikes = $this->extract_dislikes();
		if (!in_array($id, $likes)){
			$likes []= $id;
			$unpro_model->add_like($id);
			if (in_array($id, $dislikes)){
				$dislikes = array_diff($dislikes, array($id));
				$unpro_model->remove_dislike($id);
			}
		}
		setcookie('likes', join(',', $likes), time() + 86400 * 365 * 10, '/');
		setcookie('dislikes', join(',', $dislikes), time() + 86400 * 365 * 10, '/');
		echo json_encode(array('likes' => $unpro_model->get_likes($id), 'dislikes' => $unpro_model->get_dislikes($id)));
		exit;
		
	}
	
	public function action_dislike(){
		$id = (int)$_REQUEST['id'];
		global $unpro_model;
		$likes = $this->extract_likes();
		$dislikes = $this->extract_dislikes();
		if (!in_array($id, $dislikes)){
			$dislikes []= $id;
			$unpro_model->add_dislike($id);
			if (in_array((string)$id, $likes)){
				$likes = array_diff($likes, array($id));
				$unpro_model->remove_like($id);
			}
		}
		setcookie('likes', join(',', $likes), time() + 86400 * 365 * 10, '/');
		setcookie('dislikes', join(',', $dislikes), time() + 86400 * 365 * 10, '/');
		echo json_encode(array('likes' => $unpro_model->get_likes($id), 'dislikes' => $unpro_model->get_dislikes($id)));
		exit;
	}
	
	private function extract_likes(){
		$likes = isset($_COOKIE['likes']) ? $_COOKIE['likes'] : null;
		if (is_string($likes))
			$likes = explode(',', $likes);
		else
			$likes = array();
		return $likes;
	}
	private function extract_dislikes(){
		$dislikes = isset($_COOKIE['dislikes']) ? $_COOKIE['dislikes'] : null;
		if (is_string($dislikes))
			$dislikes = explode(',', $dislikes);
		else
			$dislikes = array();
		return $dislikes;
	}
	
	public function _un_head(){
		$types = get_terms(FEEDBACK_TYPE, array('un_orderby_meta' => 'position', 'hide_empty' => false));
		$default_type = empty($types) ? null : $types[0]->slug;
	?>
		<link rel="stylesheet" href="<?php echo esc_attr(usernoisepro_url('/css/usernoise-pro.css?ver=' . UNPRO_VERSION)) ?>" type="text/css">
		<link rel="stylesheet" href="<?php echo esc_attr(usernoisepro_url('/css/fixes.css?ver=' . UNPRO_VERSION)) ?>" type="text/css">
		<script src="<?php echo esc_attr(usernoisepro_url('/vendor/jquery.tinyscrollbar.js?ver=' . UNPRO_VERSION)) ?>"></script>
		<script src="<?php echo esc_attr(usernoisepro_url('/vendor/jquery.resize.js?ver=' . UNPRO_VERSION)) ?>"></script>
		<script src="<?php echo esc_attr(usernoisepro_url('/vendor/bootstrap.tooltip.js?ver=' . UNPRO_VERSION)) ?>"></script>
		<script>
			var pro = <?php echo json_encode(array(
			'enable_types' => un_get_option(UN_FEEDBACK_FORM_SHOW_TYPE) ? 'true' : 'false',
			'enable_discussions' => un_get_option(UNPRO_ENABLE_DISCUSSIONS) ? 'true' : 'false',
			'ajaxurl' => admin_url('admin-ajax.php', 'relative'),
			'default_type' => $default_type
		)); ?>
		</script>
		<script src="<?php echo esc_attr(usernoisepro_url('/js/pro.js?v=' . UNPRO_VERSION)) ?>"></script>
		<?php
	}
	
	
	public function _un_window_class($classes){
		$classes[]= 'pro';
		return $classes;
	}
	
	public function _un_after_feedback_wrapper(){
		global $un_h;
		$h = $un_h;
		require usernoisepro_path('/html/pro.php');
	}
	
	public function action_un_feedback_form_body(){
		if (un_get_option(UN_SHOW_POWERED_BY)) require_once(usernoisepro_path('/html/powered-by.php'));
	}
	
	public function action_un_get_feedback(){
		global $post, $unpro_model, $un_model;
		$type_slug = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
		$offset = (int)$_REQUEST['offset'];
		$params = array('post_type' => FEEDBACK, 'post_status' => 'publish', 
			'offset' => $offset, 'posts_per_page' => 10, 
			'feedback_type_slug' => $type_slug,
			'orderby' => 'likes', 'order' => 'DESC');
		ob_start();
		$query = new WP_Query($params);
		if ($offset == 0){
			require(usernoisepro_path('/html/feedback-category.php'));
		} else {
			require(usernoisepro_path('/html/feedback-items.php'));
		}
		echo json_encode(array(
			'html' => ob_get_clean(),
			'end' => $query->post_count == 0
		));
		exit;
	}
	
	public function action_unpro_submit_comment(){
		global $unpro_model;
		$post_id = $_REQUEST['post_id'];
		$post = get_post($post_id);
		if ($post->post_type != FEEDBACK)
			wp_die(__('Hackin, huh?'));
		add_action('comment_duplicate_trigger', array($this, 'action_comment_duplicate_trigger'));
		$email = isset($_REQUEST['email']) &&  stripslashes($_REQUEST['email']) == __('Your email (will not be published)', 'usernoise-pro') ? '' : (isset($_REQUEST['email']) ? stripslashes($_REQUEST['email']) : '');
		if (is_user_logged_in() && !trim($email)){
			$user = get_userdata(get_current_user_id());
			$email = $user->user_email;
		}
		$comment = array(
			'comment_post_ID' => $post_id,
			'comment_author' => isset($_REQUEST['name']) && stripslashes($_REQUEST['name']) == __('Name') ? '' : (isset($_REQUEST['name']) ? stripslashes($_REQUEST['name']) : ''),
			'comment_author_email' => $email,
			'comment_content' => stripslashes($_REQUEST['comment']) == _x('Comment', 'noun') ? '' : stripslashes($_REQUEST['comment']),
			'comment_author_url' => '',
			'comment_type' => null,
			'user_id' => get_current_user_id()
		);
		$errors = $unpro_model->validate_comment($comment);
		if (!empty($errors)){
			echo json_encode(array('errors' => $errors));
			exit;
		}
		setcookie('un_email', $comment['comment_author_email']);
		setcookie('un_name', $comment['comment_author']);
		add_action('comment_post', array($this, '_comment_post'), 10, 2);
		// A hack for WPML.
		$_POST['comment_post_ID'] = $comment['comment_post_ID'];
		$comment_id = wp_new_comment( $comment );
		remove_action('comment_post', array($this, '_comment_post'), 10, 2);
		global $comment;
		$comment = get_comment($comment_id);
		ob_start();
		require(usernoisepro_path('/html/comment.php'));
		$html = ob_get_clean();
		echo json_encode(array('success' => true, 'html' => $html));
		exit;
	}
	
	public function _comment_post($comment_id, $approved){
		global $unpro_model;
		if (!$approved) return;
		$unpro_model->notify_feedback_author_on_comment($comment_id);
	}
	
	public function action_unpro_get_comments(){
		global $wp_query, $unpro_model, $un_model, $un_h;
		$h = $un_h;
		add_filter('comment_feed_limits', array($this, 'filter_unpro_comment_feed_limits'));
		add_filter('comment_feed_orderby', array($this, 'filter_unpro_comment_feed_orderby'));
		// A hack for WPML.
		$wp_query->query_vars['post_type'] = FEEDBACK;
		$query = new WP_Query(array('p' => $_REQUEST['post_id'], 'post_type' => FEEDBACK, 
			'withcomments' => 1, 'feed' => true));
		ob_start();
		$query->the_post();
		$type = $un_model->get_feedback_type(get_the_ID());
		$type = $type->slug;
		require(usernoisepro_path('/html/feedback-discussion.php'));
		$comments = ob_get_clean();
		ob_start();
		if (function_exists('dsq_comments_text'))
			remove_filter('comments_number', 'dsq_comments_text');
		comments_number(__('No Responses', 'usernoise-pro'), __('One Response', 'usernoise-pro'), 
			__('% Responses', 'usernoise-pro'));
		if (function_exists('dsq_comments_text'))
			add_filter('comments_number', 'dsq_comments_text');
		$count = ob_get_clean();
		echo json_encode(array('comments' => $comments, 'count' => $count));
		exit;
	}
	
	function filter_unpro_comment_feed_orderby(){
		return 'comment_date_gmt ASC';
	}
	
	function filter_unpro_comment_feed_limits(){
		return '';
	}
	
	public function action_comment_duplicate_trigger($commentdata){
		die(json_encode(array('errors' => array('comment' => __('Duplicate comment detected', 'usernoise-pro')))));
	}
	
	public static function filter_un_controller_class(){
		return 'UNPRO_Controller';
	}
	
	public function action_un_after_feedback_form(){
		global $unpro_model, $un_h;
		$h = $un_h;
		require(usernoisepro_path('/html/pro.php'));
	}
	
	public function action_un_before_feedback_form(){
		echo '<div id="feedback-blocks-wrapper">';
	}
	
	public function action_un_feedback_content_top(){
		?><a href="#" id="un-feedback-close"><img src="<?php echo usernoise_url("/vendor/facebox/closelabel.png") ?>" title="close" class="close_image" ></a><?php
	}
	
}
global $unpro_controller;
if (un_get_option(UNPRO_ENABLE_DISCUSSIONS)){
	$unpro_controller = new UNPRO_Controller;
}

