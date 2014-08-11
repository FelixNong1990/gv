<?php

/**
 * User Details
 *
 * @package bbPress
 * @subpackage Theme
 */
global $wpdb;
?>

	<?php do_action( 'bbp_template_before_user_details' ); ?>

	<?php if ( bbp_allow_search() ) : ?>

		<div class="bbp-search-form">

			<?php bbp_get_template_part( 'form', 'search' ); ?>

		</div>

	<?php endif; ?>
	<?php 
		$displayed_user_id = bbp_get_displayed_user_field( 'id', 'raw' );
		$registered_date = bbp_get_displayed_user_field( 'user_registered', 'raw' );
		$user_location = get_user_meta($displayed_user_id, 'user_location', true);
		$user_website = get_user_meta($displayed_user_id, 'user_url', true);
		//$user_display_name  = get_user_meta($displayed_user_id, 'display_name', true);
		$user_display_name  =  $wpdb->get_var( "SELECT display_name FROM $wpdb->users WHERE id=$displayed_user_id");

		// Get user facebook URL if existed
		$user_facebook  = get_user_meta($displayed_user_id, 'facebook', true);
		$user_facebook_id = get_user_meta($displayed_user_id, 'userpro_facebook_id', true);
		if(!ctype_space($user_facebook) && $user_facebook!=='') {
			$linked_facebook = true;
			$user_facebook_url = $user_facebook;
		} else if(!ctype_space($user_facebook_id) && $user_facebook_id!=='') {
			$linked_facebook = true;
			$user_facebook_url = 'https://www.facebook.com/app_scoped_user_id/' . $user_facebook_id;
		}

		// Get user Twitter URL if existed
		$user_twitter  = get_user_meta($displayed_user_id, 'twitter', true);
		$user_twitter_id = get_user_meta($displayed_user_id, 'twitter_oauth_id', true);
		if(!ctype_space($user_twitter) && $user_twitter!=='') {
			$linked_twitter = true;
			$user_twitter_url = $user_twitter;
		} else if(!ctype_space($user_twitter_id) && $user_twitter_id!=='') {
			$linked_twitter = true;
			$user_twitter_url = 'https://twitter.com/intent/user?user_id=' . $user_twitter_id;
		}
		
		// Get user Twitter URL if existed
		$user_google_plus  = get_user_meta($displayed_user_id, 'google_plus', true);
		if(!ctype_space($user_google_plus) && $user_google_plus!=='') {
			$linked_google_plus = true;
			$user_google_plus_url = $user_google_plus;
		}

		// Display social icon if existed
		if((!ctype_space($user_facebook) && $user_facebook!=='') || (!ctype_space($user_facebook_id) && $user_facebook_id!=='')
			|| (!ctype_space($user_twitter) && $user_twitter!=='') || (!ctype_space($user_twitter_id) && $user_twitter_id!=='')
			|| (!ctype_space($user_google_plus) && $user_google_plus!=='')
		) {
			$social = true;
		}


		// $args = array(
		// 	'search'         => $displayed_user_id,
		// 	'search_columns' => 'display_name'
		// );
		// $user_query = new WP_User_Query( $args );
		// $users = $user_query->get_results();

		//print_r($users);
		//echo($users[0]);
	?>
	<h2 class="user_display_name"><?php echo $user_display_name; ?></h2>
	<div id="bbp-single-user-details">
		<?php //echo do_shortcode('[userpro template=view]'); ?>
		<div id="bbp-user-avatar">

			<span class='vcard'>
				<a class="url fn n" href="<?php bbp_user_profile_url(); ?>" title="<?php //bbp_displayed_user_field( 'display_name' ); ?>" rel="me">
					<?php //echo get_avatar( bbp_get_displayed_user_field( 'user_email', 'raw' ), apply_filters( 'bbp_single_user_details_avatar_size', 150 ) ); ?>
					<?php echo get_avatar( $displayed_user_id, apply_filters( 'bbp_single_user_details_avatar_size', 150 ) ); ?>
				</a>
			</span>

		</div><!-- #author-avatar -->

		<?php 
			// $meta = get_user_meta($displayed_user_id);
			// echo "<pre>";
			// print_r($meta);
			// echo "</pre>";
		?>
		<ul id="forum-user-meta">
			<li id="user-member-since">
				<div class="forum-user-meta-icon"><i class="fa fa-calendar fa-2x"></i></div>
				<span>Member Since: <?php echo date("F jS, Y", strtotime($registered_date)); ?></span>
			</li>
			<?php if (!ctype_space($user_location) && $user_location!=='') { ?>
			<li id="user-location">
				<div class="forum-user-meta-icon"><i class="fa fa-map-marker fa-2x"></i></div> 
				<span><?php echo $user_location; ?></span>
			</li>
			<?php } ?>
			<?php if (!ctype_space($user_website) && $user_website!=='') { ?>
			<li id="user-website">
				<div class="forum-user-meta-icon"><i class="fa fa-link fa-2x"></i></div> 
				<a target="_blank" href="<?php echo $user_website; ?>"><span><?php echo $user_website; ?></span></a>
			</li>
			<?php } ?>
			<?php if($social) { ?> 
			<li id="profile_social">
				<?php if($linked_facebook) { ?> 
					<a target="_blank" class="profile_social_facebook" href="<?php echo $user_facebook_url; ?>"><i class="fa fa-facebook"></i></a>
				<?php } ?>
				<?php if($linked_twitter) { ?> 
					<a target="_blank" class="profile_social_twitter" href="<?php echo $user_twitter_url; ?>"><i class="fa fa-twitter"></i></a>
				<?php } ?>
				<?php if($linked_google_plus) { ?> 
					<a target="_blank" class="profile_social_google_plus" href="<?php echo $user_google_plus_url; ?>"><i class="fa fa-google-plus"></i></a>
				<?php } ?>
			</li>
			<?php } ?>
		</ul>
	</div><!-- #bbp-single-user-details -->

	
	<div id="bbp-user-navigation">
		<div class="info-group">
			<ul>
				<li class="<?php if ( bbp_is_single_user_profile() ) :?>current<?php endif; ?>">
					<span class="vcard bbp-user-profile-link">
						<a class="url fn n" href="<?php bbp_user_profile_url(); ?>" title="<?php printf( esc_attr__( "%s's Profile", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>" rel="me"><?php _e( 'Profile', 'bbpress' ); ?></a>
					</span>
				</li>

				<li class="<?php if ( bbp_is_single_user_topics() ) :?>current<?php endif; ?>">
					<span class='bbp-user-topics-created-link'>
						<a href="<?php bbp_user_topics_created_url(); ?>" title="<?php printf( esc_attr__( "%s's Topics Started", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Topics Started', 'bbpress' ); ?></a>
					</span>
				</li>

				<li class="<?php if ( bbp_is_single_user_replies() ) :?>current<?php endif; ?>">
					<span class='bbp-user-replies-created-link'>
						<a href="<?php bbp_user_replies_created_url(); ?>" title="<?php printf( esc_attr__( "%s's Replies Created", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Replies Created', 'bbpress' ); ?></a>
					</span>
				</li>
				<?php if ( bbp_is_favorites_active() ) : ?>
					<li class="<?php if ( bbp_is_favorites() ) :?>current<?php endif; ?>">
						<span class="bbp-user-favorites-link">
							<a href="<?php bbp_favorites_permalink(); ?>" title="<?php printf( esc_attr__( "%s's Favorites", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Favorites', 'bbpress' ); ?></a>
						</span>
					</li>
				<?php endif; ?>

				<?php if ( bbp_is_user_home() || current_user_can( 'edit_users' ) ) : ?>

					<?php if ( bbp_is_subscriptions_active() ) : ?>
						<li class="<?php if ( bbp_is_subscriptions() ) :?>current<?php endif; ?>">
							<span class="bbp-user-subscriptions-link">
								<a href="<?php bbp_subscriptions_permalink(); ?>" title="<?php printf( esc_attr__( "%s's Subscriptions", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Subscriptions', 'bbpress' ); ?></a>
							</span>
						</li>
					<?php endif; ?>

					<li class="<?php if ( bbp_is_single_user_edit() ) :?>current<?php endif; ?>">
						<span class="bbp-user-edit-link">
							<a href="<?php bbp_user_profile_edit_url(); ?>" title="<?php printf( esc_attr__( "Edit %s's Profile", 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php _e( 'Edit', 'bbpress' ); ?></a>
						</span>
					</li>

				<?php endif; ?>
			</ul>
		</div>
	</div><!-- #bbp-user-navigation -->
	<?php do_action( 'bbp_template_after_user_details' ); ?>
