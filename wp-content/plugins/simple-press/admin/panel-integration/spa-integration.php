<?php
/*
Simple:Press
Admin Integration
$LastChangedDate: 2013-11-07 09:56:16 -0800 (Thu, 07 Nov 2013) $
$Rev: 10844 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

global $spStatus;

# Check Whether User Can Manage Integration
if (!sp_current_user_can('SPF Manage Integration')) {
	spa_etext('Access denied - you do not have permission');
	die();
}

include_once(SF_PLUGIN_DIR.'/admin/panel-integration/spa-integration-display.php');
include_once(SF_PLUGIN_DIR.'/admin/panel-integration/support/spa-integration-prepare.php');
include_once(SF_PLUGIN_DIR.'/admin/library/spa-tab-support.php');

if($spStatus != 'ok') {
    include_once(SPLOADINSTALL);
    die();
}

global $adminhelpfile;
$adminhelpfile = 'admin-integration';
# --------------------------------------------------------------------

if (isset($_GET['tab']) ? $tab = $_GET['tab'] : $tab = 'page');
spa_panel_header();
spa_render_integration_panel($tab);
spa_panel_footer();

?>