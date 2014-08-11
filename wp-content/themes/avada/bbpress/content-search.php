<?php

/**
 * Search Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums">
	<div class="bbp-search-form forum-search-page">
		<?php bbp_breadcrumb(); ?>
		<div class="search-page-search-form">
			<form role="search" method="get" id="bbp-search-form" action="<?php bbp_search_url(); ?>">
				<div>
					<label class="screen-reader-text hidden" for="bbp_search">Search for:</label>
					<input type="hidden" name="action" value="bbp-search-request">
					<input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" placeholder="<?php _e( 'Search the Forum...', 'Avada' ); ?>" />
					<input tabindex="<?php bbp_tab_index(); ?>" class="button" type="submit" id="bbp_search_submit" value="Search" />
				</div>
			</form>

		</div>
	</div>
		<?php bbp_set_query_name( 'bbp_search' ); ?>

		<?php do_action( 'bbp_template_before_search' ); ?>

		<?php if ( bbp_has_search_results() ) : ?>

			 <?php bbp_get_template_part( 'pagination', 'search' ); ?>

			 <?php bbp_get_template_part( 'loop',       'search' ); ?>

			 <?php bbp_get_template_part( 'pagination', 'search' ); ?>

		<?php elseif ( bbp_get_search_terms() ) : ?>

			 <?php bbp_get_template_part( 'feedback',   'no-search' ); ?>

		<?php else : ?>

			<?php bbp_get_template_part( 'form', 'main' ); ?>

		<?php endif; ?>

		<?php do_action( 'bbp_template_after_search_results' ); ?>
</div>

