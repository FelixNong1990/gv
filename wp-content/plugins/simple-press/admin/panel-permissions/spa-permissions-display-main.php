<?php
/*
Simple:Press
Admin Permissions Main Display
$LastChangedDate: 2014-02-16 08:54:17 -0800 (Sun, 16 Feb 2014) $
$Rev: 11078 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function spa_permissions_permission_main()
{
	$roles = sp_get_all_roles();
	if ($roles)
	{
		# display the permission set roles in table format
?>
		<table class="wp-list-table widefat">
			<tr>
				<th style="text-align:center;" width="9%" scope="col"><?php spa_etext("ID") ?></th>
				<th scope="col"><?php spa_etext("Name") ?></th>
				<th scope="col"><?php spa_etext("Name") ?></th>
			</tr>
		</table>
<?php
			foreach($roles as $role)
			{
?>
		<table id="rolerow-<?php echo($role->role_id); ?>" class="wp-list-table widefat">
			<tr>
				<td width="9%" class='row-title' align="center" style="padding:0px 0;"><?php echo $role->role_id; ?></td>
				<td><span class='row-title'><strong><?php echo sp_filter_title_display($role->role_name); ?></strong></span><span><br /><?php echo sp_filter_title_display($role->role_desc); ?></span></td>
			</tr>

			<tr>
				<td class='smallLabel'><?php spa_etext("Manage Permissions") ?></td>
				<td align="left" style="padding:0 0 0 3px;text-align:left;">
<?php
					$base = SFHOMEURL."index.php?sp_ahah=permissions-loader&amp;sfnonce=".wp_create_nonce('forum-ahah');
					$target = "perm-".$role->role_id;
					$image = SFADMINIMAGES;
?>
					<input type="button" class="button-secondary" value="<?php echo spa_text('Edit Permission'); ?>" onclick="spjLoadForm('editperm', '<?php echo $base; ?>', '<?php echo $target; ?>', '<?php echo $image; ?>', '<?php echo $role->role_id; ?>');" />
					<input type="button" class="button-secondary" value="<?php echo spa_text('Delete Permission'); ?>" onclick="spjLoadForm('delperm', '<?php echo $base; ?>', '<?php echo $target; ?>', '<?php echo $image; ?>', '<?php echo $role->role_id; ?>');" />
				</td>
			</tr>
			<tr class="sfinline-form"> <!-- This row will hold ahah forms for the current permission set -->
			  	<td colspan="2" style="padding: 0 10px 0 0;">
					<div id="perm-<?php echo $role->role_id; ?>">
					</div>
				</td>
			</tr>
		</table>
<?php	} ?>
		<br />
<?php
	} else {
		echo '<div class="sfempty">&nbsp;&nbsp;&nbsp;&nbsp;'.spa_text('There are no Permission Sets defined.').'</div>';
	}
}
?>