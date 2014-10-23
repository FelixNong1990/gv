<?php 
get_header(); 

$category = get_the_category();
$catArr = array();
foreach ($category as $key) {
	array_push($catArr, $key->cat_name);
}

//if (in_array("Dota", $catArr)):
	?>
<!-- <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/single-dota.css" /> -->
<?php
//endif;
//print_r($catArray);
//$firstCategory = $category[0]->cat_name;

?>
<?php
	function random_float ($min,$max) {
	   return ($min+lcg_value()*(abs($max-$min)));
	}
	
	
	//global $wpdb;
	//$results = $wpdb->get_results("SELECT * FROM gv_posts where post_status='publish' and post_type='post'",ARRAY_A);
	//foreach ($results as $key=>$val) {
		//$post_id = $val['ID'];
		//update_post_meta( $post_id, '_kksr_avg', random_float(4,5));
		//update_post_meta( $post_id, '_kksr_casts', rand(40,100));
		// update_post_meta( $post_id, '_kksr_avg', 4.8);
		// update_post_meta( $post_id, '_kksr_casts', 50);
		// update_post_meta( $post_id, '_kksr_ips', 'YToxOntpOjA7czo5OiIxMjcuMC4wLjEiO30=');
		// update_post_meta( $post_id, '_kksr_ratings', 240);
	//}
?>

		<?php
			// echo "<pre>";
			// print_r($_GET);
			// echo "</pre>";
			
			// Get the longest match between title and content and add it as the focus keyword for yoast seo
			// global $wpdb;
			// $results = $wpdb->get_results("SELECT * FROM gv_posts where post_status='publish' and post_type='post'",ARRAY_A);
			// foreach ($results as $key=>$val) {
			// 	$postID = $val['ID'];
			// 	//$postID = get_the_ID();
			// 	$title = get_the_title($postID);
			// 	$content = apply_filters('the_content', get_post_field('post_content', $postID));
			// 	$strip_title = strip_tags($title);
			// 	$strip_content = strip_tags($content);
				
			// 	// Clean tags by replacing them with spaces
			// 	$clean_title = cleanTagsBySpace($title);
			// 	$clean_content = cleanTagsBySpace($content);
				
			// 	$final_title = html_entity_decode($clean_title,ENT_QUOTES,'UTF-8');
			// 	$final_content = html_entity_decode($clean_content,ENT_QUOTES,'UTF-8');
				
			// 	$focuskw = get_longest_common_subsequence($final_title,$final_content);
			// 	if(str_word_count($focuskw) < 2) {
			// 		$focuskw = $final_title;
			// 		if(mb_strlen($focuskw , 'UTF-8') > 55) {
			// 			$focuskw = wp_trim_words($focuskw,3,'');
			// 		}
			// 	}
			// 	$metadesc = $final_title . ' - ' . $final_content;
			// 	if(mb_strlen($metadesc , 'UTF-8') > 157) {
			// 		$metadesc = mb_substr($metadesc,0,157,"utf-8");
			// 		//$metadesc = str_replace(array('[',']'),'',$metadesc);
			// 	}
				
			// 	$focuskw = implode(' ', array_slice(explode(' ', $final_title), 0, 10));
				
			// 	update_post_meta( $postID, '_yoast_wpseo_focuskw', $focuskw);
			// 	update_post_meta( $postID, '_yoast_wpseo_title', $title);
			// 	update_post_meta( $postID, '_yoast_wpseo_metadesc', $metadesc);
			// }
			
			$postID = get_the_ID();
			$title = get_the_title($postID);
			$content = apply_filters('the_content', get_post_field('post_content', $postID));
			$strip_title = strip_tags($title);
			$strip_content = strip_tags($content);
			
			// Clean tags by replacing them with spaces
			$clean_title = cleanTagsBySpace($title);
			$clean_content = cleanTagsBySpace($content);
			
			$final_title = html_entity_decode($clean_title,ENT_QUOTES,'UTF-8');
			$final_content = html_entity_decode($clean_content,ENT_QUOTES,'UTF-8');
			
			$focuskw = get_longest_common_subsequence($final_title,$final_content);
			if(str_word_count($focuskw) < 2) {
				$focuskw = $final_title;
				if(mb_strlen($focuskw , 'UTF-8') > 55) {
					$focuskw = wp_trim_words($focuskw,3,'');
				}
			}
			$metadesc = $final_title . ' - ' . $final_content;
			if(mb_strlen($metadesc , 'UTF-8') > 157) {
				$metadesc = mb_substr($metadesc,0,157,"utf-8");
				//$metadesc = str_replace(array('[',']'),'',$metadesc);
			}
			
			$focuskw = implode(' ', array_slice(explode(' ', $final_title), 0, 10));
			
			update_post_meta( $postID, '_yoast_wpseo_focuskw', $focuskw);
			update_post_meta( $postID, '_yoast_wpseo_title', $title);
			update_post_meta( $postID, '_yoast_wpseo_metadesc', $metadesc);
			
			// $result = str_split_unicode($metadesc);
			// echo "<pre>";
			// print_r($result);
			// echo "</pre>";
			
			// echo "<pre>";
			// print_r($longest_match);
			// echo "</pre>";
			
			//echo $focuskw = get_the_title();
			// $focuskw = html_entity_decode($title,ENT_QUOTES,'UTF-8');
			// if(strlen($focuskw) > 55) {
				// $focuskw = wp_trim_words($focuskw,3,'');
				// //$focuskw = substr( $focuskw,0,55);
				// //$focuskw = ShortenText($focuskw,30);
			// }
			
			
			
			// Split tring into array of characters
			// $result = str_split($focuskw);
			// echo "<pre>";
			// print_r($result);
			// echo "</pre>";

			

			//$meta = get_post();
			
			// wp_update_post(
            // array (
					// 'ID'        => 5285,
					// 'post_name' => uniqid()
				// )
			// );
			// $meta = get_post_meta(get_the_ID());
			// echo "<pre>";
			// print_r($meta);
			// echo "</pre>";
			//echo $id;
			
			//echo do_shortcode('[ajaxy-live-search show_category="1" show_post_category="1" post_types="post" label="Search" iwidth="180" delay="500" width="315" url="http://localhost/gv/?s=%s" border="1px solid #eee"]');
			//echo do_shortcode('[wpdreams_ajaxsearchpro id=3]');
			// $user_ID = get_current_user_id();
			// $user_rated = get_the_author_meta( 'tie_rated' , $user_ID ) ;
			// $score = $user_rated[$id];
			// $smallStarPercentage = ($score/5)*100;
			// echo $score; 
			// echo $id;
			// $arr = get_post_meta($post->ID);
			// echo "<pre>";
			// print_r($arr);
			// echo "</pre>";
			// $rating = get_post_meta( $id, '_kksr_avg' , true );
			// echo $rating;
		?>
		<span title="Amazing !" class="post-single-rate post-small-rate stars-small"><span style="width:<?php echo $smallStarPercentage; ?>%"></span></span>
			<?php 
				$url = get_post_meta($id, 'post_meta_embed_code', true); 
				// if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
					// $video_id = $match[1];
				// };
				$video_info = getVideoInfo($url);
				$video_id   = $video_info['video_id'];
				$video_provider   = $video_info['video_provider'];
				if($video_provider == 'youtube') {
					$src = 'http://i1.ytimg.com/vi/' . $video_id . '/mqdefault.jpg';
				} else if($video_provider == 'vimeo') {
					$file_contents = file_get_contents("http://vimeo.com/api/oembed.json?url=http%3A//vimeo.com/" . $video_id, true);
					$vimeo_info    = json_decode($file_contents,true);
					$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $video_id . ".php"));
					$src = $hash[0]['thumbnail_medium'];  
				}
				//update_post_meta($id, '_thumbnail_id', $src);
				// echo "<pre>";
				// print_r($vid_info);
				// echo "</pre>";
			?>
			<!-- <iframe width="920" height="315" src="//www.youtube.com/embed/<?php echo $video_id; ?>?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe> -->



<div id="content" class="single-post-content">
	<!--<h2 class="vid_description">Posted on <?php //echo $published_date; ?></h2>-->
	<?php if($smof_data['blog_post_title']): ?>
	<h1 class="entry-title"><?php the_title(); ?></h1>
	<?php else: ?>
	<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
	<?php endif; ?>
	
	<div class="details">
		<div class="user">
			<?php
				$post = get_post( $postID );
				
				// Get author id
				$author_id=$post->post_author; 
				$protocol = is_localhost();
				$author_login_name = get_the_author_meta('user_login', $author_id);
				$author_display_name = get_the_author_meta('display_name', $author_id);
				$author_url = $protocol . '/profile/' . $author_login_name;
				$author_email = get_the_author_meta('user_email',$author_id); 
			?>
			<a title="View <?php echo $author_display_name; ?>'s profile" href="<?php echo $author_url; ?>"><?php echo get_avatar( $author_email, '40' ); ?></a>
			<div class="user-data">
				<span class="user-link">Posted by <a title="View <?php echo $author_display_name; ?>'s profile" href="<?php echo $author_url; ?>"><?php echo $author_display_name; ?></a><i class="fa fa-chevron-right"></i></span>
				<!--<p>
					<i class="fa fa-video-camera"></i>
					<?php
						// Get total number of post by author id
						//echo $user_post_count = count_user_posts( $author_id );
					?>
					Videos
				</p>-->
			</div>
			
		</div>
		<!--<div class="ratings">
			<?php //if(function_exists("kk_star_ratings")) : echo kk_star_ratings($id); endif; ?>
		</div>-->
		<?php
			//echo getPostLikeLink( $post->ID );
			//echo get_template_directory_uri();
		?>

		<div class="clr"></div>
		
	</div>
	
	<article class="description-wrapper">
		<div class="video-description">
			<?php
				$post_object = get_post( $postID );
				echo $post_object->post_content;
			?>
		</div>
	</article>

	<ul class="social_share">
		<li>
			<a rel="nofollow" class="ss_btn ss_facebook" href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href),'facebook-share-dialog','width=670,height=436');return false;" target="_blank" title="Share on Facebook">
				<span class="ss_icon"></span>
				<span class="ss_vendor">Share on Facebook</span>
			</a>
		</li>
		<li>
			<a rel="nofollow" class="ss_btn ss_twitter" href="#" onclick="window.open('http://twitter.com/home?status=<?php echo urlencode($post->post_title); ?>:%0a<?php the_permalink(); ?> via @GameVeins','twitter-share-dialog','width=670,height=436');return false;" target="_blank" title="Share on Twitter">
				<span class="ss_icon"></span>
				<span class="ss_vendor">Share on Twitter</span>
			</a>
		</li>
		<li>
			<a rel="nofollow" class="ss_btn ss_google" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" title="Share on Facebook">
				<span class="ss_icon"></span>
				<span class="ss_vendor">Share on Google+</span>
			</a>
		</li>
	</ul>

	<div class="flexslider post-slideshow">
		<ul class="slides">
			<li>
				<div class="full-video">
					<?php
					if(!$video_provider == 'youtube') {
					?>
						<iframe width="854" height="480" src="https://www.youtube.com/embed/<?php echo $video_id; ?>?rel=0&autoplay=1&wmode=opaque" frameborder="0" allowfullscreen></iframe>
					<?php 
					} else if($video_provider == 'vimeo') {
					?>
						<object width="854" height="480"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $video_id; ?>&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00adef&amp;fullscreen=1&amp;autoplay=1&amp;loop=0" /><embed wmode="transparent" src="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $video_id; ?>&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=1&amp;color=00adef&amp;fullscreen=1&amp;autoplay=1&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="854" height="480"></embed></object>
					<?php
					}
					?>
				</div>
			</li>
		</ul>
	</div>
	<?php if(have_posts()): the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<?php
		global $smof_data;
		if( ! post_password_required($post->ID) ):
		if((!$smof_data['legacy_posts_slideshow'] && !$smof_data['posts_slideshow']) && get_post_meta($post->ID, 'pyre_video', true)): ?>
		<!--<div class="flexslider post-slideshow">
			<ul class="slides">
				<li class="full-video">
					<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
				</li>
			</ul>
		</div>-->
		<?php endif;
		if($smof_data['featured_images_single']):
		if($smof_data['legacy_posts_slideshow']):
		$args = array(
		    'post_type' => 'attachment',
		    'numberposts' => $smof_data['posts_slideshow_number']-1,
		    'post_status' => null,
		    'post_parent' => $post->ID,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_mime_type' => 'image',
			'exclude' => get_post_thumbnail_id()
		);
		$attachments = get_posts($args);
		if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
		?>
		<div class="flexslider post-slideshow">
			<ul class="slides">
				<?php if(!$smof_data['posts_slideshow']): ?>
				<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
				<li>
					<div class="full-video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</div>
				</li>
				<?php elseif(has_post_thumbnail() ): ?>
				<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
				<li>
					<?php if( ! $smof_data['status_lightbox']  ): ?>
					<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					<?php else: ?>
					<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />
					<?php endif; ?>
				</li>
				<?php endif; ?>
				<?php else: ?>
				<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
				<li>
					<div class="full-video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</div>
				</li>
				<?php endif; ?>
				<?php if(has_post_thumbnail() && !get_post_meta($post->ID, 'pyre_video', true)): ?>
				<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
				<li>
					<?php if( ! $smof_data['status_lightbox']  ): ?>
					<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					<?php else: ?>
					<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />
					<?php endif; ?>
				</li>
				<?php endif; ?>
				<?php foreach($attachments as $attachment): ?>
				<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
				<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
				<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
				<li>
					<?php if( ! $smof_data['status_lightbox']  ): ?>
					<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', $attachment->ID); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment->ID, '_wp_attachment_image_alt', true); ?>" /></a>
					<?php else: ?>
					<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />
					<?php endif; ?>
				</li>
				<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
		<?php endif; ?>
		<?php else: ?>
		<?php
		if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
		?>
		<div class="flexslider post-slideshow">
			<ul class="slides">
				<?php if(!$smof_data['posts_slideshow']): ?>
				<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
				<li>
					<div class="full-video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</div>
				</li>
				<?php elseif(has_post_thumbnail() ): ?>
				<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
				<li>
					<?php if( ! $smof_data['status_lightbox']  ): ?>
					<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					<?php else: ?>
					<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />
					<?php endif; ?>
				</li>
				<?php endif; ?>
				<?php else: ?>
				<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
				<li>
					<div class="full-video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</div>
				</li>
				<?php endif; ?>
				<?php if(has_post_thumbnail() ): ?>
				<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
				<li>
					<?php if( ! $smof_data['status_lightbox']  ): ?>
					<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					<?php else: ?>
					<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />
					<?php endif; ?>
				</li>
				<?php endif; ?>
				<?php
				$i = 2;
				while($i <= $smof_data['posts_slideshow_number']):
				$attachment_new_id = kd_mfi_get_featured_image_id('featured-image-'.$i, 'post');
				if($attachment_new_id):
				?>
				<?php $attachment_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
				<?php $full_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
				<?php $attachment_data = wp_get_attachment_metadata($attachment_new_id); ?>
				<li>
					<?php if( ! $smof_data['status_lightbox']  ): ?>
					<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', $attachment_new_id); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment_new_id, '_wp_attachment_image_alt', true); ?>" /></a>
					<?php else: ?>
					<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment_new_id, '_wp_attachment_image_alt', true); ?>" />
					<?php endif; ?>
				</li>
				<?php endif; $i++; endwhile; ?>
				<?php endif; ?>
			</ul>
		</div>
		<?php endif; ?>
		<?php endif; ?>
		<?php endif; ?>
		<?php endif; // password check ?>
		

		<div class="post-content">
			<?php //the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>
		<?php if( ! post_password_required($post->ID) ): ?>

		<?php if( !$smof_data['social_sharing_box'] ):
		?>
		<div class="fusion-sharing-box share-box">
			<h4>Share this video with your friends:</h4>
			<div class="fusion-social-networks boxed-icons">
				<a class="fusion-social-network-icon fusion-tooltip fusion-facebook icon-facebook" style="color:#bebdbd;background-color:#e8e8e8;border-color:#e8e8e8;border-radius:4px;" href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href),'facebook-share-dialog','width=670,height=436');return false;" target="_blank" data-placement="top" data-title="Facebook" data-toggle="tooltip" data-original-title="" title=""></a>
				<a class="fusion-social-network-icon fusion-tooltip fusion-twitter icon-twitter" style="color:#bebdbd;background-color:#e8e8e8;border-color:#e8e8e8;border-radius:4px;" href="#" onclick="window.open('http://twitter.com/home?status=<?php echo urlencode($post->post_title); ?>:%0a<?php the_permalink(); ?> via @GameVeins','twitter-share-dialog','width=670,height=436');return false;" target="_blank" data-placement="top" data-title="Twitter" data-toggle="tooltip" data-original-title="" title=""></a>
				<?php 
					$id = get_the_ID();
					$url = get_post_meta($id, 'post_meta_embed_code', true);
					if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
						$video_id = $match[1];
					};
					$full_image =  'http://i1.ytimg.com/vi/' . $video_id . '/mqdefault.jpg';
				?>
				<a class="fusion-social-network-icon fusion-tooltip fusion-pinterest icon-pinterest" style="color:#bebdbd;background-color:#e8e8e8;border-color:#e8e8e8;border-radius:4px;" href="#" onclick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?>&amp;media=<?php echo $full_image; ?>','pinterest-share-dialog','width=670,height=436');return false;" target="_blank" data-placement="top" data-title="Pinterest" data-toggle="tooltip" data-original-title="" title=""></a>
				<a class="fusion-social-network-icon fusion-tooltip fusion-tumblr icon-tumblr" style="color:#bebdbd;background-color:#e8e8e8;border-color:#e8e8e8;border-radius:4px;" href="#" onclick="window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink()); ?>&amp;name=<?php echo urlencode($post->post_title); ?>&amp;description=<?php echo urlencode(get_the_excerpt()); ?>','tumblr-share-dialog','width=670,height=436');return false;" target="_blank" data-placement="top" data-title="Tumblr" data-toggle="tooltip" data-original-title="" title=""></a>
				<a class="fusion-social-network-icon fusion-tooltip fusion-googleplus icon-googleplus" style="color:#bebdbd;background-color:#e8e8e8;border-color:#e8e8e8;border-radius:4px;" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" data-placement="top" data-title="Googleplus" data-toggle="tooltip" data-original-title="" title=""></a>
				<a class="fusion-social-network-icon fusion-tooltip fusion-linkedin icon-linkedin" style="color:#bebdbd;background-color:#e8e8e8;border-color:#e8e8e8;border-radius:4px;" href="#" onclick="window.open('http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>','linkedin-share-dialog','width=670,height=436');return false;" target="_blank" data-placement="top" data-title="Linkedin" data-toggle="tooltip" data-original-title="" title=""></a>
				<a class="fusion-social-network-icon fusion-tooltip fusion-reddit icon-reddit" style="color:#bebdbd;background-color:#e8e8e8;border-color:#e8e8e8;border-radius:4px;" href="#" onclick="window.open('http://reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>','reddit-share-dialog','width=670,height=436');return false;" target="_blank" data-placement="top" data-title="Reddit" data-toggle="tooltip" data-original-title="" title=""></a>
				<a class="fusion-social-network-icon fusion-tooltip fusion-mail icon-mail" style="color:#bebdbd;background-color:#e8e8e8;border-color:#e8e8e8;border-radius:4px;" href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>" data-placement="top" data-title="Mail" data-toggle="tooltip" data-original-title="" title=""></a>
				<div class="fusion-clearfix">
				</div>
			</div>
		</div>

		<?php endif; ?>
		

		
		<div class="clr"></div>
		<?php
			$published_date = get_the_time('F jS, Y', $id);
		?>
		
		

        <div class="vid_categories">
        	<span class="vid_cat_icon">
				<i class="fa fa-folder-open-o"></i>
				<span>Categories:</span> 
        	</span>
        	<div class="vid_cat_btn">
        	<?php
        		$categories = get_the_category($id);
        		foreach ($categories as $category) {
    			?>
					<a class="btn btn-cyan" href="<?php echo get_category_link($category->cat_ID); ?>" title="View all posts in <?php echo $category->name?>"><?php echo $category->name?></a>
    			<?php
        		}

        	?>
        	</div>
        </div>

		<div class="vid_tags">
        	<span class="vid_tag_icon">
				<i class="fa fa-tags"></i>
				<span>Tags:</span> 
        	</span>
			<div class="vid_tag_btn">
        	<?php
        		$tags = get_the_tags();
        		if( $tags ) foreach( $tags as $tag ) {
    			?>
					<a href="<?php echo get_tag_link($tag->term_id); ?>" rel="tag" title="View all posts tagged with <?php echo $tag->name?>"><?php echo $tag->name; ?></a>
    			<?php
        		}

        	?>
        	</div>
        </div>

		<?php //echo do_shortcode('[ratings]'); ?>
		<?php //echo $id; ?>
		<?php //echo do_shortcode('[ratingwidget post_id=' . $id . ']'); ?>
		<?php //echo do_shortcode('[taq_review]'); ?>


		<?php if($smof_data['blog_comments']): ?>
			<?php comments_template(); ?>
			<?php //echo do_shortcode('[js-disqus]'); ?>
		<?php endif; ?>
		<?php endif; // password check ?>
	</div>
	<?php endif; ?>
</div>
<?php wp_reset_query(); ?>
<div id="sidebar" class="single-post-sidebar">
	<div class="posts-list">
		<ul>
			<?php 
				$id       		  = get_the_ID();
				setPostViews($id);
				$published_date = get_the_time('F jS, Y', $id);
				// Get the ID of a given category
			    //$category_id = get_cat_ID( 'Dota' );

			    
			    
			    // Get id of sub category by slug name
			    //$subSlugName = get_category_by_slug('beginner-dota');
					//$subId = $subSlugName->term_id;

					// Get the URL of this category	
					//$category_link = get_category_link( $id );

					// Get all category information of current post
    			$categoryInfo		  = get_the_category($id);
    			
				//$parantCatId = $categoryInfo[1]->category_parent;

 //    			$parentscategory ="";
				// foreach($categoryInfo as $category) {
				// 	if ($category->category_parent == 0) {
				// 		$parentscategory .= ' <a href="' . get_category_link($category->cat_ID) . '" title="' . $category->name . '">' . $category->name . '</a>, ';
				// 	}
				// }
				// echo substr($parentscategory,0,-2);

				$parentscategory = array();
				foreach($categoryInfo as $category) {
					if ($category->category_parent != 0) {
						array_push($parentscategory, get_cat_slug($category->cat_ID));
					}
				}
				
    			//$categoryListName = get_categories('child_of=' . $firstCategoryId);

       			$query1 = array(
   					'category_name'  => implode(",", $parentscategory), 
   					'posts_per_page' => 10,
   					'orderby'        => 'rand',
   					'post__not_in'   => array($id)
   				);

       			$total_posts = count(get_posts($query1));
       			$n=0;

   				$wpQuery = new WP_Query($query1);
   				

				while($wpQuery->have_posts()) : $wpQuery->the_post();
				$n++;
				
				$id = $post->ID;
				$url = get_post_meta($id, 'post_meta_embed_code', true); 
				$video_info = getVideoInfo($url);
				$video_id   = $video_info['video_id'];
				$video_provider   = $video_info['video_provider'];

				if($video_provider == 'youtube') {
					$link = "https://gdata.youtube.com/feeds/api/videos/". $video_id;
					$doc = new DOMDocument;
					$doc->load($link);
					$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
					$duration = $doc->getElementsByTagName('duration')->item(0)->getAttribute('seconds');
					$src = 'http://i1.ytimg.com/vi/' . $video_id . '/mqdefault.jpg';
				} else if($video_provider == 'vimeo') {
					$file_contents = file_get_contents("http://vimeo.com/api/oembed.json?url=http%3A//vimeo.com/" . $video_id, true);
					$vimeo_info    = json_decode($file_contents,true);
					$duration      = $vimeo_info['duration'];
					$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $video_id . ".php"));
					$src = $hash[0]['thumbnail_medium'];  
				}
				
				if($duration >= 3600) {
					$duration = gmdate("H:i:s", $duration);
				} else {
					$duration = gmdate("i:s", $duration);
				}
				$views = getPostViews($id);
       		?>
			<li class="cf item-video">
				<a class="item-video-link" href="<?php the_permalink(); ?>">
					<div class="thumb">
							<span class="clip">
								<img src="<?php echo $src ?>"><span class="vertical-align"></span>
							</span>
							<span class="overlay"></span>
						
						<span class="duration"><?php echo $duration; ?></span>
					</div>
					<div class="post-text">
						<span class="vid_title" title="<?php the_title(); ?>">
							<?php the_title(); ?>	
						</span>
						<span class="vid_author">
							by <span class="author_name"><?php the_author(); ?></span>	
						</span>
						<p class="vid_views">
							<?php echo $views ?> views
						</p>
					</div>
					<div class="clear"></div>
				</a>
			</li>
			<!-- <li>
				<div class="vid_thumbnail">
					<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
						<img width="120" src="http://img.youtube.com/vi/<?php //echo $video_id; ?>/default.jpg" class="" alt="banner-1" />        
						<span class="duration"><?php //echo $duration; ?></span>
					</a>
				</div>
				<div class="post-text">
					<span class="vid_title">
							<?php the_title(); ?>	
					</span>
					<p class="vid_views">
						<?php //echo $views ?> views
					</p>
				</div>
				<div class="clear"></div>
			</li> -->
			<?php
				if ($n == $total_posts) {
					
				} else {
			?>
			
			<!-- <hr class="video-divider" /> -->

			<?php } endwhile; ?></ul>
	</div>
</div>


<?php get_footer(); ?>