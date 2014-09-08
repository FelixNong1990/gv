<?php 
	global $smof_data; 
	global $current_user;
	get_currentuserinfo();
	$display_name = $current_user->display_name;
	$avatar = get_avatar( $current_user->ID, 36 );
?>
<div class="header-v2">
	<?php if($smof_data['header_left_content'] != 'Leave Empty' || $smof_data['header_right_content'] != 'Leave Empty'): ?>
	<div class="header-social">
		<div class="avada-row">
			<div class="alignleft">
				<?php
				// if($smof_data['header_left_content'] == 'Contact Info') {
					// get_template_part('framework/headers/header-info');
				// } elseif($smof_data['header_left_content'] == 'Social Links') {
					// get_template_part('framework/headers/header-social');
				// } elseif($smof_data['header_left_content'] == 'Navigation') {
					// get_template_part('framework/headers/header-menu');
				// }
				?>
				<a href="http://www.gameveins.com">"<img src="<?php echo content_url(); ?>/images/logo_40.png" width="40" height="40" /></a>
			</div>
			<div class="middle-search">
				<?php echo do_shortcode('[ajaxy-live-search show_category="1" show_post_category="1" post_types="post" label="Search" iwidth="180" delay="500" width="315" url="http://localhost/gv/?s=%s" credits="1" border="1px solid #eee"]'); ?>
			</div>
			<div class="alignright">
				<?php
				if($data['header_right_content'] == 'Contact Info') {
					get_template_part('framework/headers/header-info');
				} elseif($data['header_right_content'] == 'Social Links') {
					get_template_part('framework/headers/header-social');
				} elseif($data['header_right_content'] == 'Navigation') {
					get_template_part('framework/headers/header-menu');
				}
				?>
				<?php 
				if(!is_user_logged_in()) { 
				?>
				    <!-- <?php //echo get_site_url();?>/register/ -->
					<a href="#" class="popup-login btn btn-primary btn-lg"><i class="fa fa-sign-in fa-lg login"></i> Log In</a>
					<a href="#" class="popup-register btn btn-success btn-lg"><i class="fa fa-pencil fa-lg signup"></i> Register</a>
				<?php 
				} else {
				?>
						<nav id="colorNav">
							<ul>
								<li class="green">
									<div class="btn-group user-wrapper">
										<button type="button" class="btn btn-primary welcome">Welcome, <?php echo $display_name; ?></button>
										<button type="button" class="btn btn-primary avatar">
											<?php
												echo $avatar;
											 ?>
										</button>
									</div>
									<?php
										$userId = get_current_user_id();
										$user_login_name = get_the_author_meta('user_login', $userId);
									?>
									<ul>
										<li><a href="<?php echo get_site_url();?>/video-submission/">Post new Video</a></li>
										<li><a href="<?php echo get_site_url();?>/video-manager/">Video Manager</a></li>
										<li><a href="<?php echo get_site_url();?>/profile/">Main Profile</a></li>
										<li><a href="<?php echo get_site_url();?>/forums/profile/<?php echo $user_login_name; ?>/">Forum Profile</a></li>
										<li><a href="<?php echo wp_logout_url(); ?>">Log Out</a></li>
									</ul>
								</li>

								<!-- More menu items -->

							</ul>
						</nav>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<header id="header">
		<div class="avada-row main_nav" style="padding-top:<?php echo $smof_data['margin_header_top']; ?>;padding-bottom:<?php echo $smof_data['margin_header_bottom']; ?>;">
			<!--<div class="logo" data-margin-right="<?php //echo $smof_data['margin_logo_right']; ?>" data-margin-left="<?php //echo $smof_data['margin_logo_left']; ?>" data-margin-top="<?php //echo $smof_data['margin_logo_top']; ?>" data-margin-bottom="<?php //echo $smof_data['margin_logo_bottom']; ?>" style="margin-right:<?php //echo $smof_data['margin_logo_right']; ?>;margin-top:<?php //echo $smof_data['margin_logo_top']; ?>;margin-left:<?php //echo $smof_data['margin_logo_left']; ?>;margin-bottom:<?php //echo $smof_data['margin_logo_bottom']; ?>;">
				<a href="<?php //bloginfo('url'); ?>">
					<img src="<?php //echo $smof_data['logo']; ?>" alt="<?php //bloginfo('name'); ?>" class="normal_logo" />
					<?php //if($smof_data['logo_retina'] && $smof_data['retina_logo_width'] && $smof_data['retina_logo_height']): ?>
					<?php
					//$pixels ="";
					//if(is_numeric($smof_data['retina_logo_width']) && is_numeric($smof_data['retina_logo_height'])):
					//$pixels ="px";
					//endif; ?>
					<img src="<?php //echo $smof_data["logo_retina"]; ?>" alt="<?php //bloginfo('name'); ?>" style="width:<?php //echo $smof_data["retina_logo_width"].$pixels; ?>;max-height:<?php //echo $smof_data["retina_logo_height"].$pixels; ?>; height: auto !important" class="retina_logo" />
					<?php //endif; ?>
				</a>-->
			<!--</div>-->
			<nav>
				<?php get_template_part('framework/headers/header-main-menu'); ?>
			</nav>
		</div>
		
	</header>
</div>