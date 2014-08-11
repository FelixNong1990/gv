<?php
/*
Simple:Press
Admin Components Special Ranks Form
$LastChangedDate: 2014-05-30 04:18:25 -0700 (Fri, 30 May 2014) $
$Rev: 11483 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function spa_special_rankings_form($rankings) {
	global $tab, $spPaths;
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	spjAjaxForm('sfaddspecialrank', 'sfreloadfr');
});
</script>
<?php

	spa_paint_options_init();
    $ahahURL = SFHOMEURL.'index.php?sp_ahah=components-loader&amp;sfnonce='.wp_create_nonce('forum-ahah').'&amp;saveform=specialranks&amp;action=newrank';
?>
	<form action="<?php echo $ahahURL; ?>" method="post" name="sfaddspecialrank" id="sfaddspecialrank">
<?php
	echo sp_create_nonce('special-rank-new');
	spa_paint_open_tab(spa_text('Components')." - ".spa_text('Special Forum Ranks'), true);
		spa_paint_open_panel();
			spa_paint_open_fieldset(spa_text('Special Forum Ranks'), true, 'special-ranks');

				spa_paint_input(spa_text('New Special Rank Name'), "specialrank", '', false, true);
				echo '<input type="submit" class="button-primary" id="addspecialrank" name="addspecialrank" value="'.spa_text('Add Special Rank').'" />';

			spa_paint_close_fieldset();

			do_action('sph_components_add_rank_panel');
			echo '</form>';

		spa_paint_close_panel();

		spa_paint_close_container();
		echo '<div class="sfform-panel-spacer"></div>';
	spa_paint_close_tab();

	# display rankings info
	if ($rankings) {
		spa_paint_open_nohead_tab(true);
		spa_paint_open_panel();
?>
		<table class="wp-list-table widefat">
			<tr>
				<th width="50%"><strong><?php spa_etext("Special Rank Name") ?></strong></th>
				<th width="50%"><strong><?php spa_etext("Special Rank Badge") ?></strong></th>
			</tr>
		</table>

<?php
		foreach ($rankings as $rank) {
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	spjAjaxForm('sfspecialrankupdate<?php echo $rank['meta_id']; ?>', '');
});
</script>
<?php
			$ahahURL = SFHOMEURL.'index.php?sp_ahah=components-loader&amp;sfnonce='.wp_create_nonce('forum-ahah').'&amp;saveform=specialranks&amp;action=updaterank&amp;id='.$rank['meta_id'];
			$delsite = SFHOMEURL.'index.php?sp_ahah=components&amp;sfnonce='.wp_create_nonce('forum-ahah').'&amp;action=del_specialrank&amp;key='.$rank['meta_id'];
?>
			<form action="<?php echo $ahahURL; ?>" method="post" id="sfspecialrankupdate<?php echo $rank['meta_id']; ?>" name="sfspecialrankupdate<?php echo $rank['meta_id']; ?>">
<?php
			echo sp_create_nonce('special-rank-update');
?>
			<table class="wp-list-table widefat" id="srank<?php echo $rank['meta_id']; ?>">
				<tr>
					<td width="50%" style="overflow:hidden">
						<input type="text" class="wp-core-ui" size="16" tabindex="'.$tab.'" name="<?php echo('specialrankdesc['.$rank['meta_id'].']'); ?>" value="<?php echo($rank['meta_key']); ?>" />
					</td>
					<td width="50%" style="overflow:hidden">
						<?php spa_select_icon_dropdown('specialrankbadge['.$rank['meta_id'].']', spa_text('Select Badge'), SF_STORE_DIR.'/'.$spPaths['ranks'].'/', $rank['meta_value']['badge'], true, 105); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="sp-half-row-left">
							<input type="submit" class="button-primary" style="vertical-align:top;" id="updatespecialrank.<?php echo($rank["meta_id"]); ?>" name="updatespecialrank.<?php echo($rank["meta_id"]); ?>" value="<?php spa_etext('Update Rank'); ?>" />
							</form>
							<img style="vertical-align:top;" onclick="spjDelRow('<?php echo $delsite; ?>', 'srank<?php echo $rank['meta_id']; ?>');" src="<?php echo SFCOMMONIMAGES; ?>delete.png" title="<?php spa_etext('Delete Special Rank'); ?>" alt="" />
<?php
				            $loc = '#sfrankshow-'.$rank['meta_id'];
				            $site = SFHOMEURL.'index.php?sp_ahah=components&amp;sfnonce='.wp_create_nonce('forum-ahah').'&amp;action=show&amp;key='.$rank['meta_id'];
							$gif= SFCOMMONIMAGES."working.gif";
							$text = esc_js(spa_text('Show/Hide Members'));
?>
							<input type="button" id="show<?php echo $rank['meta_id']; ?>" class="button-secondary" value="<?php echo $text; ?>" onclick="spjToggleRow('<?php echo $loc; ?>');spjShowMemberList('<?php echo $site; ?>', '<?php echo $gif; ?>', '<?php echo $rank['meta_id']; ?>');" />

						</div>

						<div class="sp-half-row-right">
<?php
							$base = SFHOMEURL.'index.php?sp_ahah=components-loader&amp;sfnonce='.wp_create_nonce('forum-ahah');
							$target = 'members-'.$rank['meta_id'];
							$image = SFADMINIMAGES;
?>
							<input type="button" id="remove<?php echo $rank['meta_id']; ?>" class="button-secondary button-jump-left" value="<?php spa_etext('Remove Members'); ?>" onclick="jQuery('<?php echo $loc; ?>').show();spjLoadForm('delmembers', '<?php echo $base; ?>', '<?php echo $target; ?>', '<?php echo $image; ?>', '<?php echo $rank['meta_id']; ?>', 'open'); " />
							<input type="button" id="add<?php echo $rank['meta_id']; ?>" class="button-secondary button-jump-left" value="<?php spa_etext('Add Members'); ?>" onclick="jQuery('<?php echo $loc; ?>').show();spjLoadForm('addmembers', '<?php echo $base; ?>', '<?php echo $target; ?>', '<?php echo $image; ?>', '<?php echo $rank['meta_id']; ?>', 'open'); " />

						</div
					</td>
				</tr>

				<tr id="sfrankshow-<?php echo($rank["meta_id"]); ?>">
					<td colspan="2">
					<div id="members-<?php echo($rank["meta_id"]); ?>"></div>
					</td>
				</tr>

			</table>
<?php
		}
		spa_paint_close_panel();
		spa_paint_close_container();
		echo '<div class="sfform-panel-spacer"></div>';
	spa_paint_close_tab();
	}
}
?>