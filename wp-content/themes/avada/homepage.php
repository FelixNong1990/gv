<?php
// Template Name: Home
global $shortname;
global $wpdb;
get_header(); ?>

<?php //$my_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = 'hello-world'"); echo $my_id;?>
<?php
//print_r(get_page_by_slug('register'))
?>

<?php
	/*$args = array(
	    'post_type' => 'post'
	);

	$post_query = new WP_Query($args);
	if($post_query->have_posts() ) {
		while($post_query->have_posts() ) {
	    	$post_query->the_post();
	    	$id = get_the_ID();
	    	echo '<h2>'.$id.'</h2>';
	    	//update_post_meta( $post_id, '_userpro_edit_restrict', 'none' );
	    }
	}*/

	// global $wpdb;
	// $results = $wpdb->get_results("SELECT * FROM gv_posts where post_status='publish' and post_type='post'",ARRAY_A);
	// foreach ($results as $key=>$val) {
	// 	$post_id = $val['ID'];
	// 	update_post_meta( $post_id, '_userpro_edit_restrict', 'none' );
	// }
	/*echo "<pre>";
	print_r($results);
	echo "</pre>";*/
?>



<div id="content" class="full-width">
	<?php
	//global $wpb;
	//echo $wpb->bookmarks();
	?>
	<?php //echo slider_pro(1); ?>
	<div class="fullwidth-box" style="padding-top: 0px; padding-bottom: 0px;">
		<div class="advanced-slider slider-pro video-slider" id="slider-pro-1" tabindex="0" style="width: 100%; height: 430px;">
			<div class="slides">
				<?php
					$catquery = new WP_Query( array(
							'category_name'=> 'featured' , 
							'posts_per_page' => 3,
							'post_type'      		 => 'post',
							'post_status'            => 'publish',
							'orderby'                => 'date',
							'order'                  => 'DESC',		
							'no_found_rows'          => true,
							'update_post_term_cache' => false,
							'update_post_meta_cache' => false
							//'cache_results'          => true
						) 
					);
					while($catquery->have_posts()) : $catquery->the_post();
					$post_id = get_the_ID();
					
					// $meta = get_post_meta( $post_id );
					// echo "<pre>";
					// print_r($meta);
					// echo "</pre>";
					
					$ratings = get_post_meta( $post_id, '_kksr_avg' , true );
					$per = ($ratings/5)*100;
					$views = getPostViews($post_id);
					$author_id=$post->post_author;
					$author_url = get_author_posts_url($author_id);
					$published_date = get_the_time('F j, Y', $post_id);
					
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
						$href = 'http://www.youtube.com/watch?v=' . $video_id . '&rel=0&controls=1&showinfo=0&theme=light';
					} else if($video_provider == 'vimeo') {
						$file_contents = file_get_contents("http://vimeo.com/api/oembed.json?url=http%3A//vimeo.com/" . $video_id, true);
						$vimeo_info    = json_decode($file_contents,true);
						$duration      = $vimeo_info['duration'];
						$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $video_id . ".php"));
						$src = $hash[0]['thumbnail_large'];
						$href = 'http://vimeo.com/' . $video_id;
					}
				?>
				<div class="slide">
					<div class="layer static" data-width="65%" data-height="100%" data-horizontal="-5" data-vertical="-2">
						<a class="video" href="<?php echo $href; ?>">
							<img src="<?php echo $src; ?>" width="100%" height="100%"/>
						</a>
					</div>
					<div class="layer static slider-description" data-horizontal="65%" data-vertical="-2" data-width="35%" data-height="100%">
						<div class="slider-right">
							<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div class="post-details-slider">
								<div class="post-details-rating" title="Rating: <?php echo $ratings; ?>">
									<div class="post-details-rating-score" style="width:<?php echo $per; ?>%"></div>
								</div>
							</div>
							<div class="post-details-slider">
								<i class="fa fa-user fa-lg"> </i>
								<span>Posted by <a class="post-details-author" title="Posts by <?php the_author(); ?>" href="<?php echo $author_url; ?>"><?php the_author(); ?></a></span>
							</div>
							<div class="post-details-slider">
								<i class="fa fa-calendar fa-lg"> </i>
								<span><?php echo $published_date; ?></span>
							</div>
							<div class="post-details-slider">
								<i class="fa fa-eye fa-lg"> </i>
								<span><?php echo $views; ?> Views</span>
							</div>
							<p>
								<?php echo strip_tags(limit_excerpt(get_the_content(),20)); ?>
							</p>
							<div class="more-link-slider">
								<a href="<?php the_permalink(); ?>" class="btn btn-primary">More details <i class="fa fa-arrow-right"></i></a>
							</div>
						</div>
					</div>
				</div>
				<?php 
					endwhile;
					wp_reset_query();
				?>
			</div>
		</div>

		<div class="utf-content">
		<?php
		    // Create array of all categories
			$gameArr = array('dota'=>"DOTA",'lol'=>"LEAGUE of LEGENDS",'smite'=>"SMITE",'starcraft'=>"STARCRAFT II",'cod'=>"CALL of DUTY",'yolo'=>"YOLO");
			$i = 0;
			foreach($gameArr as $gameArr=>$val) {
				$i++;
		?>
		<div class="cat-box">
			<h2 class="light-title title">
				<a title="View all videos related to <?php echo $val; ?>" class="title-link" href="<?php echo site_url() . '/category/' . $gameArr; ?>"><?php echo $val; ?></a>
			</h2>
			<div class="smart-control pull-right">
				
			</div>
			<hr class="divider-3d" />
		</div>

		<div class="owl-carousel">
			<?php
				$n = 0;
				$catquery = new WP_Query( array(
							'category_name'  		 => $gameArr , 
							'posts_per_page' 		 => 4,
							'post_type'      		 => 'post',
							'post_status'            => 'publish',
							'orderby'                => 'date',
							'order'                  => 'DESC',		
							'no_found_rows'          => true,
							//'update_post_term_cache' => false,
							//'update_post_meta_cache' => false,
							'cache_results'          => true
					)
				);
				
				
				while($catquery->have_posts()) : $catquery->the_post();
				$post_id = get_the_ID();
				$views = getPostViews($post_id);
				$rating = get_post_meta( $post_id, '_kksr_avg' , true );
				$percentage = ($rating/5)*100;
				$author_id=$post->post_author;
				$author_url = get_author_posts_url($author_id);
				$post_like_count = getTotalLike($post_id) ?: 0;
				$post_dislike_count = getTotalDislike($post_id) ?: 0;
				$published_date = get_the_time('F j, Y', $post_id);
				$embed = get_post_meta($post_id, 'post_meta_embed_code', true);
				$vid_info = getVideoInfo($embed);
				$vidId = $vid_info['video_id'];
			?>
			<div class="fusion-animated" data-animationtype="fadeInUp" data-animationduration="1">
				<div class="item">
					<div class="he-wrap tpl4">
						<div class="rounded-div" data-original="http://i1.ytimg.com/vi/<?php echo $vidId; ?>/mqdefault.jpg" style="background-image: url('<?php echo content_url(); ?>/images/blank.gif'); background-size: 100% 100%;"></div>
						<div class="he-view">
							<div class="bg">
								<div class="a0" data-animate="fadeIn"></div>
							</div>
							<div class="content">
								<a class="he-link" href="<?php the_permalink(); ?>"><img class="a0 icon_play" data-animate="jellyInDown" data-original="<?php echo content_url(); ?>/images/icon_play.png" src="<?php echo content_url(); ?>/images/blank.gif" /></a>
							</div>
						</div>
					</div>

					<div class="ca-details">
						<a class="ca-title-link" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><h3 class="ca-title"><?php the_title(); ?></h3></a>
						<div class="ca-author">
							<span>by</span>
							<span><a class="ca-author-link" title="View all videos of <?php the_author(); ?>" href="<?php echo $author_url; ?>"><?php the_author(); ?></a> on <?php echo $published_date; ?></span>
						</div>
						<div class="ca-excerpt">
							<p>
								<?php echo strip_tags(limit_excerpt(get_the_content(),20)); ?>
							</p>
						</div>
						<div class="ca-bottom-details">
							<div class="ca-views">
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
							</div>
							<div class="ca-ratings vid_ratings">
								<span title="Ratings: <?php echo $rating; ?>" class="post-small-rate">
									<span style="width:<?php echo $percentage; ?>%"></span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
				$n++;
				endwhile;
				wp_reset_query();
			?>		
		</div>
	<?php } ?>
	</div>
	</div>

</div>

<?php get_footer(); ?>
