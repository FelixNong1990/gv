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

	$author_id    = get_the_author_meta('ID');
	$name         = get_the_author_meta('display_name', $author_id);
	$avatar       = get_avatar( get_the_author_meta('email', $author_id), '82' );
	$description  = get_the_author_meta('description', $author_id);

	if(empty($description)) {
		$description  = __("This author has not yet filled in any details.",'Avada');
		$description .= '</br>'.sprintf( __( 'So far %s has created %s entries.' ), $name, count_user_posts( $author_id ) );
	}
	?>
	<div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
		<div id="tabs" class="tabs">
			<nav>
				<ul>
					<li><a href="#section-1" class="icon-shop"><span>Shop</span></a></li>
					<li><a href="#section-2" class="icon-cup"><span>Drinks</span></a></li>
					<li><a href="#section-3" class="icon-food"><span>Food</span></a></li>
					<li><a href="#section-4" class="icon-lab"><span>Lab</span></a></li>
					<li><a href="#section-5" class="icon-truck"><span>Order</span></a></li>
				</ul>
			</nav>
			<div class="content">
				<section id="section-1">
					<div class="mediabox">
						<img src="img/01.png" alt="img01" />
						<h3>Sushi Gumbo Beetroot</h3>
						<p>Sushi gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato.</p>
					</div>
					<div class="mediabox">
						<img src="img/02.png" alt="img02" />
						<h3>Pea Sprouts Fava Soup</h3>
						<p>Lotus root water spinach fennel kombu maize bamboo shoot green bean swiss chard seakale pumpkin onion chickpea gram corn pea.</p>
					</div>
					<div class="mediabox">
						<img src="img/03.png" alt="img03" />
						<h3>Turnip Broccoli Sashimi</h3>
						<p>Nori grape silver beet broccoli kombu beet greens fava bean potato quandong celery. Bunya nuts black-eyed pea prairie turnip leek lentil turnip greens parsnip.</p>
					</div>
				</section>
				<section id="section-2">
					<div class="mediabox">
						<img src="img/04.png" alt="img04" />
						<h3>Asparagus Cucumber Cake</h3>
						<p>Chickweed okra pea winter purslane coriander yarrow sweet pepper radish garlic brussels sprout groundnut summer purslane earthnut pea tomato spring onion azuki bean gourd. </p>
					</div>
					<div class="mediabox">
						<img src="img/05.png" alt="img05" />
						<h3>Magis Kohlrabi Gourd</h3>
						<p>Salsify taro catsear garlic gram celery bitterleaf wattle seed collard greens nori. Grape wattle seed kombu beetroot horseradish carrot squash brussels sprout chard.</p>
					</div>
					<div class="mediabox">
						<img src="img/06.png" alt="img06" />
						<h3>Ricebean Rutabaga</h3>
						<p>Celery quandong swiss chard chicory earthnut pea potato. Salsify taro catsear garlic gram celery bitterleaf wattle seed collard greens nori. </p>
					</div>
				</section>
				<section id="section-3">
					<div class="mediabox">
						<img src="img/02.png" alt="img02" />
						<h3>Noodle Curry</h3>
						<p>Lotus root water spinach fennel kombu maize bamboo shoot green bean swiss chard seakale pumpkin onion chickpea gram corn pea.Sushi gumbo beet greens corn soko endive gumbo gourd.</p>
					</div>
					<div class="mediabox">
						<img src="img/06.png" alt="img06" />
						<h3>Leek Wasabi</h3>
						<p>Sushi gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato.</p>
					</div>
					<div class="mediabox">
						<img src="img/01.png" alt="img01" />
						<h3>Green Tofu Wrap</h3>
						<p>Pea horseradish azuki bean lettuce avocado asparagus okra. Kohlrabi radish okra azuki bean corn fava bean mustard tigernut wasabi tofu broccoli mixture soup.</p>
					</div>
				</section>
				<section id="section-4">
					<div class="mediabox">
						<img src="img/03.png" alt="img03" />
						<h3>Tomato Cucumber Curd</h3>
						<p>Chickweed okra pea winter purslane coriander yarrow sweet pepper radish garlic brussels sprout groundnut summer purslane earthnut pea tomato spring onion azuki bean gourd. </p>
					</div>
					<div class="mediabox">
						<img src="img/01.png" alt="img01" />
						<h3>Mushroom Green</h3>
						<p>Salsify taro catsear garlic gram celery bitterleaf wattle seed collard greens nori. Grape wattle seed kombu beetroot horseradish carrot squash brussels sprout chard.</p>
					</div>
					<div class="mediabox">
						<img src="img/04.png" alt="img04" />
						<h3>Swiss Celery Chard</h3>
						<p>Celery quandong swiss chard chicory earthnut pea potato. Salsify taro catsear garlic gram celery bitterleaf wattle seed collard greens nori. </p>
					</div>
				</section>
				<section id="section-5">
					<div class="mediabox">
						<img src="img/02.png" alt="img02" />
						<h3>Radish Tomato</h3>
						<p>Catsear cauliflower garbanzo yarrow salsify chicory garlic bell pepper napa cabbage lettuce tomato kale arugula melon sierra leone bologi rutabaga tigernut.</p>
					</div>
					<div class="mediabox">
						<img src="img/06.png" alt="img06" />
						<h3>Fennel Wasabi</h3>
						<p>Sea lettuce gumbo grape kale kombu cauliflower salsify kohlrabi okra sea lettuce broccoli celery lotus root carrot winter purslane turnip greens garlic.</p>
					</div>
					<div class="mediabox">
						<img src="img/01.png" alt="img01" />
						<h3>Red Tofu Wrap</h3>
						<p>Green horseradish azuki bean lettuce avocado asparagus okra. Kohlrabi radish okra azuki bean corn fava bean mustard tigernut wasabi tofu broccoli mixture soup.</p>
					</div>
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