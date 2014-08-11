<?php
/*
Simple:Press
DESC:
$LastChangedDate: 2014-02-11 07:27:53 -0800 (Tue, 11 Feb 2014) $
$Rev: 11064 $
*/

# ==========================================================================================
#
# 	FORUM PAGE
#	This file loads for forum page loads only
#
# ==========================================================================================

global $spStatus;

$redirect = (isset($_SERVER['REDIRECT_URL'])) ? $_SERVER['REDIRECT_URL'] : '';

if (!defined('SPMEMBERLIST')) define('SPMEMBERLIST', sp_url('members'));

# hack to get around wp_list_pages() bug
if ($spStatus == 'ok') {
	# go for whole row so it gets cached.
	$t = spdb_table(SFWPPOSTS, "ID=".sp_get_option('sfpage'), 'row');
	if (!defined('SFPAGETITLE')) define('SFPAGETITLE', $t->post_title);
}

do_action('sph_forum_constants');

?>