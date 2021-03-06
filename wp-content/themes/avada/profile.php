<?php
// Template Name: Profile
?>

<?php get_header(); ?>
	<?php
	$sidebar_exists = true;

	if($smof_data['blog_archive_sidebar'] == 'None') {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
		$content_class= 'full-width';
		$sidebar_exists = false;
	} elseif($smof_data['blog_sidebar_position'] == 'Left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
	} elseif($smof_data['blog_sidebar_position'] == 'Right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
	}

	$container_class = '';
	$post_class = '';
	if($smof_data['blog_archive_layout'] == 'Large Alternate') {
		$post_class = 'large-alternate';
	} elseif($smof_data['blog_archive_layout'] == 'Medium Alternate') {
		$post_class = 'medium-alternate';
	} elseif($smof_data['blog_archive_layout'] == 'Grid') {
		$post_class = 'grid-post';
		$container_class = sprintf( 'grid-layout grid-layout-%s', $smof_data['blog_grid_columns'] );
	} elseif($smof_data['blog_archive_layout'] == 'Timeline') {
		$post_class = 'timeline-post';
		$container_class = 'timeline-layout';
		if($smof_data['blog_archive_sidebar'] != 'None') {
			$container_class = 'timeline-layout timeline-sidebar-layout';
		}
	}

	global $wp_query;
	$author_name = $wp_query->query_vars['up_username'];

	if(empty($author_name)) {
		$author_name = get_the_author_meta('user_login', get_current_user_id());
	}

	$author_id    = get_the_author_meta('ID');
	$name         = get_the_author_meta('display_name', $author_id);
	$avatar       = get_avatar( get_the_author_meta('email', $author_id), '82' );
	$description  = get_the_author_meta('description', $author_id);

	if(empty($description)) {
		$description  = __("This author has not yet filled in any details.",'Avada');
		$description .= '</br>'.sprintf( __( 'So far %s has created %s entries.' ), $name, count_user_posts( $author_id ) );
	}
	
	// Get current user's login name 
	//$author_name = the_author_meta('user_login');
	?>
	<div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
		<div id="tabs" class="tabs">
			<nav>
				<ul>
					<li><a href="#section-1" class="tabsIcon icon-user"><span>Profile</span></a></li>
					<li><a href="#section-2" class="tabsIcon icon-camera"><span>Videos</span></a></li>
				</ul>
			</nav>
			<div class="content">
				<section id="section-1">
					<?php echo do_shortcode('[userpro template=view user=' . $author_name . ']'); ?>
				</section>
				<section id="section-2">
					<div id="posts-container" class="<?php echo $container_class; ?> clearfix">
			<?php
			$post_count = 1;

			$prev_post_timestamp = null;
			$prev_post_month = null;
			$first_timeline_loop = false;

			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			// Build the query arguments
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 10,
				'post_status' => 'publish',
				'author_name' => $author_name,
				'ignore_sticky_posts' => 1,
      			'paged' => $paged
			);
			$author_query = new WP_Query( $args );
			 
			if ( $author_query->have_posts() ) :
				while ( $author_query->have_posts() ) : $author_query->the_post();
			//while(have_posts()): the_post();
				$post_timestamp = strtotime($post->post_date);
				$post_month = date('n', $post_timestamp);
				$post_year = get_the_date('o');
				$current_date = get_the_date('o-n');

				$author_id=$post->post_author;
				$protocol = is_localhost();
				$author_login_name = get_the_author_meta('user_login', $author_id);
				$author_display_name = get_the_author_meta('display_name', $author_id);
				$author_url = $protocol . '/profile/' . $author_login_name;
			?>
			<?php if($smof_data['blog_archive_layout'] == 'Timeline'): ?>
			<?php if($prev_post_month != $post_month): ?>
				<div class="timeline-date"><h3 class="timeline-title"><?php echo get_the_date($smof_data['timeline_date_format']); ?></h3></div>
			<?php endif; ?>
			<?php endif; ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class($post_class.getClassAlign($post_count).' clearfix'); ?>>
				<?php if($smof_data['blog_archive_layout'] == 'Medium Alternate'): ?>
				<div class="date-and-formats">
					<div class="date-box">
						<span class="date"><?php the_time($smof_data['alternate_date_format_day']); ?></span>
						<span class="month-year"><?php the_time($smof_data['alternate_date_format_month_year']); ?></span>
					</div>
					<div class="format-box">
						<?php
						switch(get_post_format()) {
							case 'gallery':
								$format_class = 'images';
								break;
							case 'link':
								$format_class = 'link';
								break;
							case 'image':
								$format_class = 'image';
								break;
							case 'quote':
								$format_class = 'quotes-left';
								break;
							case 'video':
								$format_class = 'film';
								break;
							case 'audio':
								$format_class = 'headphones';
								break;
							case 'chat':
								$format_class = 'bubbles';
								break;
							default:
								$format_class = 'pen';
								break;
						}
						?>
						<i class="icon-<?php echo $format_class; ?>"></i>
					</div>
				</div>
				<?php endif; ?>
				<?php
				if($smof_data['featured_images']):
				if($smof_data['legacy_posts_slideshow']) {
					get_template_part('legacy-slideshow');
				} else {
					get_template_part('new-slideshow');
				}
				endif;
				?>
				<!--<div class="post-content-container">-->
					<?php if($smof_data['blog_archive_layout'] == 'Timeline'): ?>
					<div class="timeline-circle"></div>
					<div class="timeline-arrow"></div>
					<?php endif; ?>
					<?php if($smof_data['blog_archive_layout'] != 'Large Alternate' && $smof_data['blog_archive_layout'] != 'Medium Alternate' && $smof_data['blog_archive_layout'] != 'Grid'  && $smof_data['blog_archive_layout'] != 'Timeline'): ?>
					<h2 class=entry-title><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>
					<?php if($smof_data['blog_archive_layout'] == 'Large Alternate'): ?>
					<div class="date-and-formats">
						<div class="date-box">
							<span class="date"><?php the_time($smof_data['alternate_date_format_day']); ?></span>
							<span class="month-year"><?php the_time($smof_data['alternate_date_format_month_year']); ?></span>
						</div>
						<div class="format-box">
							<?php
							switch(get_post_format()) {
								case 'gallery':
									$format_class = 'images';
									break;
								case 'link':
									$format_class = 'link';
									break;
								case 'image':
									$format_class = 'image';
									break;
								case 'quote':
									$format_class = 'quotes-left';
									break;
								case 'video':
									$format_class = 'film';
									break;
								case 'audio':
									$format_class = 'headphones';
									break;
								case 'chat':
									$format_class = 'bubbles';
									break;
								default:
									$format_class = 'pen';
									break;
							}
							?>
							<i class="icon-<?php echo $format_class; ?>"></i>
						</div>
					</div>
					<?php endif; ?>
					<div class="post-content">

<?php
	// Get video infos
	$post_id = get_the_ID();
	$views = getPostViews($post_id);
	$url = get_post_meta($post_id, 'post_meta_embed_code', true); 
	$video_info = getVideoInfo($url);
	$video_id   = $video_info['video_id'];
	$video_provider   = $video_info['video_provider'];
	
	// Check whether current video provider is youtube or vimeo then get the thumnail source and video duration
	if($video_provider == 'youtube') {
		$link = "https://gdata.youtube.com/feeds/api/videos/". $video_id;
		$doc = new DOMDocument;
		$doc->load($link);
		$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
		$duration = $doc->getElementsByTagName('duration')->item(0)->getAttribute('seconds');
		$src = 'http://i1.ytimg.com/vi/' . $video_id . '/0.jpg';
	} else if($video_provider == 'vimeo') {
		$file_contents = file_get_contents("http://vimeo.com/api/oembed.json?url=http%3A//vimeo.com/" . $video_id, true);
		$vimeo_info    = json_decode($file_contents,true);
		$duration      = $vimeo_info['duration'];
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $video_id . ".php"));
		$src = $hash[0]['thumbnail_medium'];  
	}
	
	// Convert video duration from seconds to minutes or hours
	if($duration >= 3600) {
		$duration = gmdate("H:i:s", $duration);
	} else {
		$duration = gmdate("i:s", $duration);
	}
	
	// Other vids info
	$author_id=$post->post_author;
	//$author_url = get_author_posts_url($author_id);
	$protocol = is_localhost();
	$author_url = $protocol . '/profile/' . get_the_author_meta('user_login', $author_id);

	$post_like_count = getTotalLike($post_id) ?: 0;
	$post_dislike_count = getTotalDislike($post_id) ?: 0;
	//$published_date = get_the_time('F j, Y', $post_id);
	$published_date = get_the_time('d/m/Y', $post_id);
?>

<article class="loop-entry container">
	<a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="loop-entry-img-link">
	<div class="thumb">
			<span class="clip">
				<img class="lazy" data-original="<?php echo $src; ?>" src="<?php echo content_url(); ?>/images/blank.gif" /><span class="vertical-align"></span>
			</span>
			<span class="overlay"></span>
		
		<span class="duration"><?php echo $duration; ?></span>
	</div>
	</a>
	<h2 class="loop-entry-title-margin">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php 
			// if (strlen($post->post_title) > 35) {
				// echo substr(the_title($before = '', $after = '', FALSE), 0, 35) . '...'; 
			// } 
			// else {
				// the_title();
			// } 
			the_title();
			?>
		</a>
	</h2>

	<div class="entry-text">
		<?php
			$content = get_the_content();
			if (strlen(trim($content)) > 15) {
				$random = rand(15, 20);
				echo limit_excerpt($content, $random);
			} else {
				echo $content;
			}
		?>
		<hr class="showbiz-divider" />
		<?php

		?>
		<ul class="meta-left">
			<li class="meta-author"><a title="View <?php echo $author_display_name; ?>'s profile" href="<?php echo $author_url; ?>"><span class="fa fa-user"></span><?php echo $author_display_name; ?></a></li>
		    <li class="meta-date"><span class="fa fa-calendar"></span><?php echo $published_date; ?></li>
		    <li class="meta-view">
		    	<span class="fa fa-eye"></span>
		    	<?php 
					if($views == 0) {
						echo " No view";
					} elseif($views == 1) {
						echo " One view";
					} else {
						echo $views . " views";
					}
				?>
		    </li>
		</ul>

		<ul class="meta-right">
		    <li class="rating tn_like">
			    <span class="fa fa-thumbs-o-up"></span>
			    <?php 
					echo $post_like_count;
				?>
		    </li>
			<li class="rating tn_dislike">
				<span class="fa fa-thumbs-o-down"></span>
				<?php 
					echo $post_dislike_count;
				?>
			</li>
			<?php 
				$commentsNum = get_comments_number();
				if($commentsNum != 1) $commentsTitle = $commentsNum . ' Comments';
				else $commentsTitle = $commentsNum . ' Comment';
			?>
			<li class="meta-comment"><a class="cmt-link" title="<?php echo $commentsTitle; ?>" href="<?php comments_link(); ?>"><span class="fa fa-comment"></span><?php echo get_comments_number(); ?></a></li>
		</ul>

		<!-- /loop-entry-meta -->
	</div>
	<!-- /entry-text -->
</article>
<!-- /loop-entry -->
					
		
					</div>
					<div style="clear:both;"></div>
					<?php if(!$smof_data['post_meta']): ?>
					<div class="meta-info">
						<?php if($smof_data['blog_archive_layout'] == 'Grid' || $smof_data['blog_archive_layout'] == 'Timeline'): ?>
						<?php if($smof_data['blog_archive_layout'] != 'Large Alternate' && $smof_data['blog_archive_layout'] != 'Medium Alternate'): ?>
						<div class="alignleft">
							<?php if(!$smof_data['post_meta_read']): ?><a href="<?php the_permalink(); ?>" class="read-more"><?php echo __('Read More', 'Avada'); ?></a><?php endif; ?>
						</div>
						<?php endif; ?>
						<div class="alignright">
							<?php if(!$smof_data['post_meta_comments']): ?><?php comments_popup_link('<i class="icon-bubbles"></i>&nbsp;'.__('0', 'Avada'), '<i class="icon-bubbles"></i>&nbsp;'.__('1', 'Avada'), '<i class="icon-bubbles"></i>&nbsp;'.'%'); ?><?php endif; ?>
						</div>
						<?php else: ?>
						<?php if($smof_data['blog_archive_layout'] != 'Large Alternate' && $smof_data['blog_archive_layout'] != 'Medium Alternate'): ?>
						<div class="alignleft vcard">
							<?php if(!$smof_data['post_meta_author']): ?><?php echo __('By', 'Avada'); ?> <span class="fn"><?php the_author_posts_link(); ?></span><span class="sep">|</span><?php endif; ?><?php if(!$smof_data['post_meta_date']): ?><span class="updated" style="display:none;"><?php the_modified_time( 'c' ); ?></span><span class="published"><?php the_time($smof_data['date_format']); ?></span><span class="sep">|</span><?php endif; ?><?php if(!$smof_data['post_meta_cats']): ?><?php if(!$smof_data['post_meta_tags']){ echo __('Categories:', 'Avada') . ' '; } ?><?php the_category(', '); ?><span class="sep">|</span><?php endif; ?><?php if(!$smof_data['post_meta_tags']): ?><span class="meta-tags"><?php the_tags( ); ?></span><span class="sep">|</span><?php endif; ?><?php if(!$smof_data['post_meta_comments']): ?><?php comments_popup_link(__('0 Comments', 'Avada'), __('1 Comment', 'Avada'), '% '.__('Comments', 'Avada')); ?><?php endif; ?>
						</div>
						<?php endif; ?>
						<div class="alignright">
							<?php if(!$smof_data['post_meta_read']): ?><a href="<?php the_permalink(); ?>" class="read-more"><?php echo __('Read More', 'Avada'); ?></a><?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				<!--</div>-->
			</div>
			<?php
			$prev_post_timestamp = $post_timestamp;
			$prev_post_month = $post_month;
			$post_count++;
			endwhile;
			endif;
			?>
		</div>
		<?php themefusion_pagination($pages = '', $range = 2, $author_query); ?>
				</section>
			</div><!-- /content -->
		</div><!-- /tabs -->
	</div>
	<?php if( $sidebar_exists == true ): ?>
	<?php wp_reset_query(); ?>
	<div id="sidebar" style="<?php echo $sidebar_css; ?>">
	<?php
	if ($smof_data['blog_archive_sidebar'] != 'None' && function_exists('dynamic_sidebar')) {
		generated_dynamic_sidebar($smof_data['blog_archive_sidebar']);
	}
	?>
	</div>
	<?php endif; ?>
<?php get_footer(); ?>