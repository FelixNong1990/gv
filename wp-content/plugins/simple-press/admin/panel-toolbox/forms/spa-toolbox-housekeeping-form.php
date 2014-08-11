<?php
/*
Simple:Press
Admin Toolbox Uninstall Form
$LastChangedDate: 2014-05-30 03:18:14 -0700 (Fri, 30 May 2014) $
$Rev: 11479 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function spa_toolbox_housekeeping_form()
{
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	spjAjaxForm('sfindexes', 'sfreloadhk');
	spjAjaxForm('sfnewpostcleanup', 'sfreloadhk');
	spjAjaxForm('sftransientcleanup', 'sfreloadhk');
	spjAjaxForm('sfpostcountcleanup', 'sfreloadhk');
	spjAjaxForm('sfresetprofiletabs', 'sfreloadhk');
	spjAjaxForm('sfresetauths', 'sfreloadhk');
	spjAjaxForm('sfresetcombined', 'sfreloadhk');
	spjAjaxForm('sfflushcache', 'sfreloadhk');
	<?php do_action('sph_toolbox_housekeeping_ajax'); ?>
});
</script>
<?php
    $ahahURL = SFHOMEURL."index.php?sp_ahah=toolbox-loader&amp;sfnonce=".wp_create_nonce('forum-ahah')."&amp;saveform=housekeeping";
?>
	<form action="<?php echo $ahahURL; ?>" method="post" id="sfhousekeepingform" name="sfhousekeeping">
	</form>
<?php
	spa_paint_options_init();
	spa_paint_open_tab(spa_text('Toolbox')." - ".spa_text('Housekeeping'));
		spa_paint_open_panel();
			spa_paint_open_fieldset(spa_text('Rebuild Indexes'), true, 'rebuild-indexes');
				echo '<tr><td style="border:none !important;"><p class="sublabel">'.spa_text("You shouldn't need to rebuild your indexes unless asked to by Simple:Press Support.").'</p></td></tr>';
?>
				<tr><td style="border:none !important;">
				<form action="<?php echo $ahahURL; ?>" method="post" id="sfindexes" name="sfindexes">
				<?php echo sp_create_nonce('forum-adminform_housekeeping'); ?>
				<p class="sublabel"><?php spa_etext('Select forum to have its indexes rebuilt') ?>:<br /><br /></p>
				<select class="wp-core-ui" name="forum_id" >
					<p class="wp-core-ui sublabel"><?php echo sp_render_group_forum_select(false, false, false, true, '', '', 'wp-core-ui', 20); ?></p>


				</select>
                <br /><br />
				<input type="submit" class="button-primary" id="saveit" name="rebuild-fidx" value="<?php spa_etext('Rebuild Forum Indexes'); ?>" onclick="jQuery('#riimg').show();"/>
				<img class="sfhidden" id="riimg" src="<?php echo(SFCOMMONIMAGES.'working.gif'); ?>" alt=""/>
				</form>
				</td></tr>
<?php
				echo '<tr><td style="border:none !important;"><p class="sublabel">'.spa_text('Note: Rebuilding the forum indexes may take some time if you have a large number of topics or posts.').'</p><br /></td></tr>';
			spa_paint_close_fieldset();
		spa_paint_close_panel();

		spa_paint_open_panel();
			spa_paint_open_fieldset(spa_text('New Post Cleanup'), true, 'newpost-cleanup');
				echo '<p class="sublabel">'.spa_text('This will reset the New Posts list for users who haven not visited the forum in the specified number of days.').'</p>';
?>

				<form action="<?php echo $ahahURL; ?>" method="post" id="sfnewpostcleanup" name="sfnewpostcleanup">
				<?php echo sp_create_nonce('forum-adminform_housekeeping'); ?>

				<span>Number of Days Since User's Last Visit:
				<input class="wp-core-ui" type="text" value="30" name="sfdays" /></span>
				<br />
				<input type="submit" class="button-primary" id="saveit" name="clean-newposts" value="<?php spa_etext('Clean New Posts List'); ?>"  onclick="jQuery('#npcimg').show();"/>
				<img class="sfhidden" id="npcimg" src="<?php echo(SFCOMMONIMAGES.'working.gif'); ?>" alt=""/>
				</form>
<?php
				echo spa_text('Note: Cleaning up the New Post Lists may take some time if you have a large number of users that meet the criteria.').'</p><br />';
			spa_paint_close_fieldset();
		spa_paint_close_panel();

		spa_paint_open_panel();
			spa_paint_open_fieldset(spa_text('User Post Count Cleanup'), true, 'post-count-cleanup');
				echo '<tr><td style="border:none !important;"><p class="sublabel">'.spa_text('This will go through the users and posts database tables and recalculate post counts for all users based on existing posts.').'</p></td></tr>';
?>
				<tr><td style="border:none !important;">
				<form action="<?php echo $ahahURL; ?>" method="post" id="sfpostcountcleanup" name="sfpostcountcleanup">
				<?php echo sp_create_nonce('forum-adminform_housekeeping'); ?><br />
				<input type="submit" class="button-primary" id="saveit" name="postcount-cleanup" value="<?php spa_etext('Clean Up Post Counts'); ?>"  onclick="jQuery('#pcimg').show();"/>
				<img class="sfhidden" id="pcimg" src="<?php echo(SFCOMMONIMAGES.'working.gif'); ?>" alt=""/>
				</form>
				</td></tr>
<?php
				echo '<tr><td colspan="2" style="border:none !important;"><p class="sublabel">'.spa_text('Note: Recalculating user post counts may take some time if you have a large number of users and cannot be reversed.').'</p><br /></td></tr>';
			spa_paint_close_fieldset();
		spa_paint_close_panel();

		do_action('sph_toolbox_housekeeping_left_panel');
		spa_paint_tab_right_cell();

		spa_paint_open_panel();
			spa_paint_open_fieldset(spa_text('Transient Cleanup'), true, 'transient-cleanup');
				echo '<tr><td style="border:none !important;"><p class="sublabel">'.spa_text('This will clean up expired WP Transients from the WP options table and any expired SP user notices.').'</p></td></tr>';
?>
				<tr><td style="border:none !important;">
				<form action="<?php echo $ahahURL; ?>" method="post" id="sftransientcleanup" name="sftransientcleanup">
				<?php echo sp_create_nonce('forum-adminform_housekeeping'); ?><br />
				<input type="submit" class="button-primary" id="saveit" name="transient-cleanup" value="<?php spa_etext('Clean Up Transients'); ?>"  onclick="jQuery('#tcimg').show();"/>
				<img class="sfhidden" id="tcimg" src="<?php echo(SFCOMMONIMAGES.'working.gif'); ?>" alt=""/>
				</form>
				</td></tr>
<?php
			spa_paint_close_fieldset();
		spa_paint_close_panel();

		spa_paint_open_panel();
			spa_paint_open_fieldset(spa_text('Rebuild Default Profile Tabs'), true, 'reset-tabs');
				echo '<tr><td style="border:none !important;"><p class="sublabel">'.spa_text('This will remove all Profile Tabs and restore to default state.').'</p></td></tr>';
?>
				<tr><td style="border:none !important;">
				<form action="<?php echo $ahahURL; ?>" method="post" id="sfresetprofiletabs" name="sfresetprofiletabs">
				<?php echo sp_create_nonce('forum-adminform_housekeeping'); ?>
				<input type="submit" class="button-primary" id="saveit" name="reset-tabs" value="<?php spa_etext('Reset Profile Tabs'); ?>"  onclick="jQuery('#rdptimg').show();"/>
				<img class="sfhidden" id="rdptimg" src="<?php echo(SFCOMMONIMAGES.'working.gif'); ?>" alt=""/>
				</form>
				</td></tr>
<?php
			spa_paint_close_fieldset();
		spa_paint_close_panel();

		spa_paint_open_panel();
			spa_paint_open_fieldset(spa_text('Reset the Auths Cache'), true, 'reset-auths');
				echo '<tr><td style="border:none !important;"><p class="sublabel">'.spa_text("This will force a rebuild of each user's auth cache. It does not change any permissions.").'</p></td></tr>';
?>
				<tr><td style="border:none !important;">
				<form action="<?php echo $ahahURL; ?>" method="post" id="sfresetauths" name="sfresetauths">
				<?php echo sp_create_nonce('forum-adminform_housekeeping'); ?>
				<input type="submit" class="button-primary" id="saveit" name="reset-auths" value="<?php spa_etext('Reset Auths Cache'); ?>"  onclick="jQuery('#rtacimg').show();"/>
				<img class="sfhidden" id="rtacimg" src="<?php echo(SFCOMMONIMAGES.'working.gif'); ?>" alt=""/>
				</form>
				</td></tr>
<?php
			spa_paint_close_fieldset();
		spa_paint_close_panel();

		spa_paint_open_panel();
			spa_paint_open_fieldset(spa_text('Reset combined CSS/JS'), true, 'reset-combined');
				echo '<tr><td style="border:none !important;"><p class="sublabel">'.spa_text("This will force a rebuild of the combined CSS and JS cache files.").'</p></td></tr>';
?>
				<tr><td style="border:none !important;">
				<form action="<?php echo $ahahURL; ?>" method="post" id="sfresetcombined" name="sfresetcombined">
				<?php echo sp_create_nonce('forum-adminform_housekeeping'); ?>
				<input type="submit" class="button-primary" id="saveit" name="reset-combinedcss" value="<?php spa_etext('Reset Combined CSS Cache'); ?>"  onclick="jQuery('#rtccimg').show();"/>
				<input type="submit" class="button-primary" id="saveit" name="reset-combinedjs" value="<?php spa_etext('Reset Combined Script Cache'); ?>"  onclick="jQuery('#rtccimg').show();"/>
				<img class="sfhidden" id="rtccimg" src="<?php echo(SFCOMMONIMAGES.'working.gif'); ?>" alt=""/>
				</form>
				</td></tr>
<?php
			spa_paint_close_fieldset();
		spa_paint_close_panel();

		spa_paint_open_panel();
			spa_paint_open_fieldset(spa_text('Flush general cache'), true, 'flush-cache');
				echo '<tr><td style="border:none !important;"><p class="sublabel">'.spa_text("This will force a flushing of the general cache.").'</p></td></tr>';
?>
				<tr><td style="border:none !important;">
				<form action="<?php echo $ahahURL; ?>" method="post" id="sfflushcache" name="sfflushcache">
				<?php echo sp_create_nonce('forum-adminform_housekeeping'); ?>
				<input type="submit" class="button-primary" id="saveit" name="flushcache" value="<?php spa_etext('Flush General Cache'); ?>"  onclick="jQuery('#fcacheimg').show();"/>
				<img class="sfhidden" id="fcacheimg" src="<?php echo(SFCOMMONIMAGES.'working.gif'); ?>" alt=""/>
				</form>
				</td></tr>
<?php
			spa_paint_close_fieldset();
		spa_paint_close_panel();

		do_action('sph_toolbox_housekeeping_right_panel');

		spa_paint_close_container();
		echo '<div class="sfform-panel-spacer"></div>';
	spa_paint_close_tab();
}
?>