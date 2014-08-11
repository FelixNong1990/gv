<?php
/*
Simple:Press
Admin Permissions Add Permission Form
$LastChangedDate: 2014-05-30 03:18:14 -0700 (Fri, 30 May 2014) $
$Rev: 11479 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function spa_permissions_add_permission_form() {
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	spjAjaxForm('sfrolenew', 'sfreloadpb');
	jQuery(function(jQuery){vtip();})
});
</script>
<?php
	# Get correct tooltips file
	$lang = WPLANG;
	if (empty($lang)) $lang = 'en';
	$ttpath = SPHELP.'admin/tooltips/admin-permissions-tips-'.$lang.'.php';
	if (file_exists($ttpath) == false) $ttpath = SPHELP.'admin/tooltips/admin-permissions-tips-en.php';
	if (file_exists($ttpath)) include_once($ttpath);

	global $spGlobals;
	spa_paint_options_init();

    $ahahURL = SFHOMEURL."index.php?sp_ahah=permissions-loader&amp;sfnonce=".wp_create_nonce('forum-ahah')."&amp;saveform=addperm";
	?>
	<form action="<?php echo $ahahURL; ?>" method="post" id="sfrolenew" name="sfrolenew">
		<?php
		echo sp_create_nonce('forum-adminform_rolenew');
		spa_paint_open_tab(spa_text('Permissions')." - ".spa_text('Add New Permission'), true);
			spa_paint_open_panel();
				spa_paint_open_fieldset(spa_text('Add New Permission'), 'true', 'create-new-permission-set');

					spa_paint_input(spa_text('Permission Set Name'), "role_name", '', false, true);
					spa_paint_input(spa_text('Permission Set Description'), "role_desc", '', false, true);

					spa_paint_select_start(spa_text('Clone Existing Permission Set'), 'role', 'role');
					spa_display_permission_select('', false);
					spa_paint_select_end('<small>('.spa_text('Select an existing Permission Set to Clone.  Any settings below will be ignored.').')</small>');

?>
					<br /><p><strong><?php spa_etext("Permission Set Actions") ?>:</strong></p>
					<?php
					echo '<p><img src="'.SFADMINIMAGES.'sp_GuestPerm.png" alt="" width="16" height="16" align="top" />';
					echo '<small>&nbsp;'.spa_text('Note: Action settings displaying this icon will be ignored for Guest Users').'</small>';
					echo '&nbsp;&nbsp;&nbsp;<img src="'.SFADMINIMAGES.'sp_GlobalPerm.png" alt="" width="16" height="16" align="top" />';
					echo '<small>&nbsp;'.spa_text('Note: Action settings displaying this icon require enabling to use').'</small>';
					echo '&nbsp;&nbsp;&nbsp;<img src="'.SFADMINIMAGES.'sp_Warning.png" alt="" width="16" height="16" align="top" />';
					echo '<small>&nbsp;'.spa_text('Note: Action settings displaying this icon should be used with great care').'</small></p>';

					sp_build_site_auths_cache();

					$sql = "SELECT auth_id, auth_name, auth_cat, authcat_name, warning FROM ".SFAUTHS."
							JOIN ".SFAUTHCATS." ON ".SFAUTHS.".auth_cat = ".SFAUTHCATS.".authcat_id
							WHERE active = 1
							ORDER BY auth_cat, auth_id";
					$authlist = spdb_select('set', $sql);

					$firstitem = true;
					$category = '';
					?>
					<!-- OPEN OUTER CONTAINER DIV -->
					<div class="outershell" style="width: 100%;">
					<?php

					foreach($authlist as $a) {
						if($category != $a->authcat_name) {
							$category = $a->authcat_name;
							if(!$firstitem) {
								?>
								<!-- CLOSE DOWN THE ENDS -->
								</table></div>
								<?php
							}
							?>
							<!-- OPEN NEW INNER DIV -->
							<div class="innershell">
							<!-- NEW INNER DETAIL TABLE -->
							<table width="100%" border="0">
							<tr><td colspan="2" class="permhead"><?php spa_etext($category); ?></td></tr>
							<?php
							$firstitem = false;
						}

						$auth_id = $a->auth_id;
						$auth_name = $a->auth_name;
						$authWarn = (empty($a->warning)) ? false : true;
						$warn = ($authWarn) ? " permwarning" : '';
						$tip = ($authWarn) ? " class='vtip permwarning' title='".esc_js(spa_text($a->warning))."'" : '';

						$button = 'b-'.$auth_id;
						if ($spGlobals['auths'][$auth_id]->ignored || $spGlobals['auths'][$auth_id]->enabling || $authWarn) {
							$span = '';
						} else {
							$span = ' colspan="2" ';
						}

						?>
							<tr<?php echo($tip); ?>>
								<td class="permentry<?php echo($warn); ?>">

								<label for="sf<?php echo $button; ?>" class="sflabel">
								<img align="top" style="float: right; border: 0pt none ; margin: -4px 5px 0px 3px; padding: 0;" class="vtip" title="<?php echo $tooltips[$auth_name]; ?>" src="<?php echo SFADMINIMAGES; ?>sp_Information.png" alt="" />
								<?php spa_etext($spGlobals['auths'][$auth_id]->auth_desc); ?></label>
								<input type="checkbox" name="<?php echo $button; ?>" id="sf<?php echo $button; ?>"  />
								<?php if ($span == '')
								{ ?>
									<td align="center" class="permentry" width="32px">
								<?php }
								if ($span == '') {
									if ($spGlobals["auths"][$auth_id]->enabling) {
										echo '<img src="'.SFADMINIMAGES.'sp_GlobalPerm.png" alt="" width="16" height="16" title="'.spa_text('Requires Enabling').'" />';
									}
									if($spGlobals['auths'][$auth_id]->ignored) {
										echo '<img src="'.SFADMINIMAGES.'sp_GuestPerm.png" alt="" width="16" height="16" title="'.spa_text('Ignored for Guests').'" />';
									}
									if($authWarn) {
										echo '<img src="'.SFADMINIMAGES.'sp_Warning.png" alt="" width="16" height="16" title="'.spa_text('Use with Caution').'" />';
									}
									echo '</td>';
								} else {
								?>
								</td><td class="permentry" width="32px"></td>
								<?php
								}
								?>
							</tr>

						<?php
					}
					?>
					<!-- END CONTAINER DIV -->
					</table></div><div class="clearboth"></div>
					</div>
					<?php

				spa_paint_close_fieldset();
			spa_paint_close_panel();
			do_action('sph_perm_add_perm_panel');
		spa_paint_close_container();
?>
	<div class="sfform-submit-bar">
	<input type="submit" class="button-primary" id="saveit" name="saveit" value="<?php spa_etext('Create New Permission'); ?>" />
	</div>
	</form>
	<?php spa_paint_close_tab(); ?>

	<div class="sfform-panel-spacer"></div>
<?php
}
?>