<div id="comment-list" class="scrollable">
	<div class="viewport">
		<div class="overview">
			<ul>
				<li class="clearfix">
					<div class="avatar-wrapper">
						<?php echo get_avatar($unpro_model->author_email(get_the_ID()),'48', usernoisepro_url("/images/default-avatar.gif") ) ?>
					</div>
					<div class="single-comment-content">
						<h4><?php echo esc_html(un_feedback_author_name(get_the_ID())) ?>, <small><?php echo un_human_time_diff(get_the_time('U')) . " " . __('ago', 'usernoise-pro')?></small> <?php if ($type && $type != 'praise'): ?>
							<span class="feedback-status"><?php echo $unpro_model->get_feedback_status_name(get_the_ID()) ?></span>
							<?php $liked = in_array(get_the_ID(), preg_split('/,/', isset($_COOKIE['likes']) ? $_COOKIE['likes'] : '')) ?>
							<?php $disliked = in_array(get_the_ID(), preg_split('/,/', isset($_COOKIE['dislikes']) ? $_COOKIE['dislikes'] : ''))?>
							<a class="dislikes" href="#like-<?php the_ID() ?>" <?php echo $disliked ? 'disabled="disabled"' : ''?>><i class="icon-thumbs-down"></i><span><?php un_the_feedback_dislikes()?></span></a>
							<a class="likes" href="#like-<?php the_ID()?>" <?php echo $liked ? 'disabled="disabled"' : ''?>><i class="icon-thumbs-up"></i><span><?php un_the_feedback_likes()?></span></a>
						<?php endif ?></h4>
						<?php the_content() ?>
					</div>
				</li>
				<?php if ($query->have_comments()){
					while($query->have_comments()){
						$query->the_comment();?>
						<?php require(usernoisepro_path('/html/comment.php')) ?>
						<?php 
					}
				} else {
					require(usernoisepro_path('/html/comments-blank-slate.php'));
				} ?>
			</ul>
			<form id="comment-form">
				<div class="avatar-wrapper">
					<?php echo get_avatar(get_current_user_id(),'48', usernoisepro_url("/images/default-avatar.gif") ) ?>
				</div>
				<div class="fields">
					<?php if (!is_user_logged_in()): ?>
						<div class="left">
							<?php $h->text_field('name', isset($_COOKIE['un_name']) ? $_COOKIE['un_name'] : __('Name'), array('id' => 'un-comment-name', 'class' => 'text text-empty')) ?>
						</div>
						<div class="right">
						<?php $h->text_field('email', isset($_COOKIE['un_email']) ? $_COOKIE['un_email'] : __('Your email (will not be published)', 'usernoise-pro') , array('id' => 'un-comment-email', 'class' => 'text text-empty')) ?>
						</div>
					<?php endif ?>
					<?php $textarea_rows = un_get_option(UN_FEEDBACK_FORM_SHOW_SUMMARY) || 
					un_get_option(UN_FEEDBACK_FORM_SHOW_TYPE) || un_get_option(UN_FEEDBACK_FORM_SHOW_EMAIL) ? '7' : '4' ?>
					<?php $h->textarea('comment', _x( 'Comment', 'noun'), array('id' => 'un-comment', 'rows' => $textarea_rows, 'class' => 'text'))?>

					<div id="submit-comment-wrapper">
						<i class="icon-asterisk icon-spin"></i>
						<input type="submit" value="<?php _e('Submit') ?>">
					</div>

				</div>
			</form>
		</div>
	</div>
	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
</div>
