<?php
/*
Simple:Press
Admin Toolbox Uninstall Form
$LastChangedDate: 2014-05-30 03:18:14 -0700 (Fri, 30 May 2014) $
$Rev: 11479 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function spa_toolbox_log_form() {
	$sflog = spa_get_log_data();

#== log Tab ==========================================================

	spa_paint_open_tab(spa_text('Toolbox')." - ".spa_text('Install Log'), true);

			if (!$sflog) {
				spa_etext("There are no Install Log Entries");
				return;
			}

			spa_paint_open_fieldset(spa_text('Install Log'), false);
				echo "<table class='wp-list-table widefat'><tr>";
				echo "<th>".spa_text('Version')."</th>";
				echo "<th class='logDetail'>"."</th>";
				echo "<th>".spa_text('Build')."</th>";
				echo "<th class='logRelease'>".spa_text('Release')."</th>";
				echo "<th>".spa_text('Installed')."</th>";
				echo "<th class='logBy'>".spa_text('By')."</th>";
				echo "</tr>";

				foreach ($sflog as $log) {
					$idVer = 'version'.str_replace('.', '', $log['version']);
					$idQVer = str_replace('.', '-', $log['version']);

					echo "<tr>";
					echo "<td class='sflabel'>".$log['version']."</td>";
				    $site = SFHOMEURL.'index.php?sp_ahah=install-log&amp;sfnonce='.wp_create_nonce('forum-ahah').'&amp;log='.$idQVer;
					$gif = SFCOMMONIMAGES.'working.gif';
					echo '<td class="logDetail"><input type="button" class="logDetail button" value="'.spa_text('Details').'" onclick="spjLoadAhah(\''.$site.'\', \''.$idVer.'\', \''.$gif.'\');" /></td>';

					echo "</td>";
					echo "<td class='sflabel'>".$log['build']."</td>";
					echo "<td class='sflabel logRelease'>".$log['release_type']."</td>";
					echo "<td class='sflabel'>".sp_date('d', $log['install_date'])."</td>";
					echo "<td class='sflabel logBy'>".sp_filter_name_display($log['display_name'])."</td>";
					echo "</tr>";
					echo "<tr><td style='display:none;' class='sflabel' id='".$idVer."' colspan='5'></td></tr>";
				}
				echo '</table>';
			spa_paint_close_fieldset();
		spa_paint_close_panel();
		do_action('sph_toolbox_install_panel');
		spa_paint_close_container();
	spa_paint_close_tab();
}
?>