<?php

/**
 * User Profile
 *
 * @package bbPress
 * @subpackage Theme
 */

$displayed_author_id = bbp_get_displayed_user_field( 'id', 'raw' );
//$author_url = get_author_posts_url($displayed_author_id);
$protocol = is_localhost();
$author_login_name = get_the_author_meta('user_login', $displayed_author_id);

$current_user_id = get_current_user_id();

if($displayed_author_id === $current_user_id) {
	$author_url = $protocol . '/profile/';
} else {
	$author_url = $protocol . '/profile/' . $author_login_name;
}
?>

	<?php do_action( 'bbp_template_before_user_profile' ); ?>

	<div id="bbp-user-profile" class="bbp-user-profile">
		<!--<h2 class="entry-title"><?php //_e( 'Bio / Description', 'bbpress' ); ?></h2>-->
		<div class="bbp-user-section">

			<?php if ( bbp_get_displayed_user_field( 'description' ) ) : ?>

				<p class="bbp-user-description"><?php bbp_displayed_user_field( 'description' ); ?></p>

			<?php endif; ?>

			<p class="bbp-user-forum-role"><span class="bold"><?php  printf( __( 'Forum Role:',      'Avada' )); ?> </span><?php printf(bbp_get_user_display_role() ); ?></p>
			<p class="bbp-user-topic-count"><span class="bold"><?php printf( __( 'Topics Started:',  'Avada' )); ?> </span><?php printf(bbp_get_user_topic_count_raw() ); ?></p>
			<p class="bbp-user-reply-count"><span class="bold"><?php printf( __( 'Replies Created:', 'Avada' )); ?> </span><?php printf(bbp_get_user_reply_count_raw() ); ?></p>
			<a href="<?php echo $author_url; ?>" class="main-profile-btn">
				View main profile
			</a>
		</div>
	</div><!-- #bbp-author-topics-started -->

	<?php do_action( 'bbp_template_after_user_profile' ); ?>
