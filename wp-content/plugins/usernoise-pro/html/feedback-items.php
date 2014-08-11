<?php global $un_model ?>
<?php global $unpro_model ?>
<?php while($query->have_posts()): $query->the_post(); ?>
	<li class="feedback" data-id="<?php the_ID() ?>">
		<div class="feedback-meta">
			<?php if (un_get_the_feedback_status()): ?>
				<span class="feedback-status <?php un_the_feedback_status_slug() ?>"><?php un_the_feedback_status() ?></span>
			<?php endif ?>
			<a class="feedback-title" href="#feedback-<?php the_ID() ?>">
				<?php the_title() ?>
			</a>
			<small><?php echo un_human_time_diff(get_the_time('U')) . " " . __('ago', 'usernoise-pro')?></small>
			<?php $liked = in_array(get_the_ID(), preg_split('/,/', isset($_COOKIE['likes']) ? $_COOKIE['likes'] : '')) ?>
			<?php $disliked = in_array(get_the_ID(), preg_split('/,/', isset($_COOKIE['dislikes']) ? $_COOKIE['dislikes'] : ''))?>
			<a class="right likes" href="#like-<?php the_ID() ?>" <?php echo $liked ? 'disabled="disabled"' : ''?>><i class="icon-thumbs-up"></i><span><?php un_the_feedback_likes()?></span></a>
			<a class="right dislikes" href="#like-<?php the_ID() ?>" <?php echo $disliked ? 'disabled="disabled"' : ''?>><i class="icon-thumbs-down"></i><span><?php un_the_feedback_dislikes()?></span></a>
			<a href="#feedback-<?php the_ID() ?>" class="comments right"><i class="icon-comments"></i><?php echo $post->comment_count ?></a>
		</div>
	</li>
<?php endwhile ?>