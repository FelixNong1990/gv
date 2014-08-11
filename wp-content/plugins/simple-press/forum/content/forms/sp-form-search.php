<?php
/*
Simple:Press
Search Form Rendering
$LastChangedDate: 2014-04-26 18:33:18 -0700 (Sat, 26 Apr 2014) $
$Rev: 11351 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function sp_render_inline_search_form($args) {
	global $spVars, $spThisUser, $spGlobals, $spDevice;

	extract($args, EXTR_SKIP);

	# sanitize before use
	$searchIncludeDef	= (int) $searchIncludeDef;
	$searchScope	    = (int) $searchScope;

	if (!empty($labelLegend)) $labelLegend = sp_filter_title_display($labelLegend);
	if (!empty($labelScope)) $labelScope = sp_filter_title_display($labelScope);
	if (!empty($labelCurrent)) $labelCurrent  = sp_filter_title_display($labelCurrent);
	if (!empty($labelAll)) $labelAll = sp_filter_title_display($labelAll);
	if (!empty($labelMatch)) $labelMatch = sp_filter_title_display($labelMatch);
	if (!empty($labelMatchAny)) $labelMatchAny = sp_filter_title_display($labelMatchAny);
	if (!empty($labelMatchAll)) $labelMatchAll = sp_filter_title_display($labelMatchAll);
	if (!empty($labelMatchPhrase)) 	$labelMatchPhrase = sp_filter_title_display($labelMatchPhrase);
	if (!empty($labelOptions)) $labelOptions = sp_filter_title_display($labelOptions);
	if (!empty($labelPostTitles)) $labelPostTitles = sp_filter_title_display($labelPostTitles);
	if (!empty($labelPostsOnly)) $labelPostsOnly = sp_filter_title_display($labelPostsOnly);
	if (!empty($labelTitlesOnly)) $labelTitlesOnly = sp_filter_title_display($labelTitlesOnly);
	if (!empty($labelWildcards)) $labelWildcards = sp_filter_title_display($labelWildcards);
	if (!empty($labelMatchAnyChars)) $labelMatchAnyChars = sp_filter_title_display($labelMatchAnyChars);
	if (!empty($labelMatchOneChar)) $labelMatchOneChar = sp_filter_title_display($labelMatchOneChar);
	if (!empty($labelMinLength)) $labelMinLength = sp_filter_title_display($labelMinLength);
	if (!empty($labelMemberSearch)) $labelMemberSearch = sp_filter_title_display($labelMemberSearch);
	if (!empty($labelTopicsPosted)) $labelTopicsPosted = sp_filter_title_display($labelTopicsPosted);
	if (!empty($labelTopicsStarted)) $labelTopicsStarted = sp_filter_title_display($labelTopicsStarted);

	$pageview = $spVars['pageview'];

	$br = (defined('SP_USE_PRETTY_CBOX') && SP_USE_PRETTY_CBOX == true) ? '' : '<br />';

	# all or current forum?
	$out = '';
	$out.= '<fieldset class="spSearchFormAdvanced">';
	$out.= '<legend>'.$labelLegend.'</legend>';
	$out.= '<div class="spSearchSection spSearchSectionForm">';

	$out = apply_filters('sph_SearchFormTop', $out);

	$out.= '<div class="spRadioSection spLeft">';
	$tout = '';
	$tout.= '<p class="spSearchForumScope">&mdash;&nbsp;'.$labelScope.'&nbsp;&mdash;</p>';
	$ccheck = 'checked="checked"';
	$acheck = '';
	if (($pageview == 'forum') || ($pageview == 'topic')) {
		$tout.= '<input type="hidden" name="forumslug" value="'.esc_attr($spVars['forumslug']).'" />';
		$tout.= '<input type="hidden" name="forumid" value="'.esc_attr($spVars['forumid']).'" />';
        if (!empty($searchScope) && $searchScope == 2) {
            $ccheck = '';
    		$acheck = 'checked="checked"';
        }
		$tout.= '<input type="radio" id="sfradio1" name="searchoption" value="1" '.$ccheck.' />&nbsp;<label class="spLabel spRadio" for="sfradio1">'.$labelCurrent.'</label>'.$br;
	} else {
		$acheck = 'checked="checked"';
	}
	$tout.= '<input type="radio" id="sfradio2" name="searchoption" value="2" '.$acheck.' />&nbsp;<label class="spLabel spRadio" for="sfradio2">'.$labelAll.'</label>'.$br;
	$out.= apply_filters('sph_SearchFormForumScope', $tout);
	$out.= '</div>';

	# search type?
	$tout = '';
	$tout.= '<div class="spRadioSection spLeft">';
	$tout.= '<p class="spSearchMatch">&mdash;&nbsp;'.$labelMatch.'&nbsp;&mdash;</p>';
	$tout.= '<input type="radio" id="sfradio3" name="searchtype" value="1" checked="checked" />&nbsp;<label class="spLabel spRadio" for="sfradio3">'.$labelMatchAny.'</label>'.$br;
	$tout.= '<input type="radio" id="sfradio4" name="searchtype" value="2" />&nbsp;<label class="spLabel spRadio" for="sfradio4">'.$labelMatchAll.'</label>'.$br;
	$tout.= '<input type="radio" id="sfradio5" name="searchtype" value="3" />&nbsp;<label class="spLabel spRadio" for="sfradio5">'.$labelMatchPhrase.'</label>'.$br;
	$out.= apply_filters('sph_SearchFormMatch', $tout);
	$out.= '</div>';

	if ($spDevice == 'mobile') $out.= sp_InsertBreak('echo=0&spacer=12px');

	# topic title?
	$tout = '';
	$tout.= '<div class="spRadioSection spLeft">';
	$tout.= '<p class="spSearchOptions">&mdash;&nbsp;'.$labelOptions.'&nbsp;&mdash;</p>';
    $checked = ($searchIncludeDef == 1 || empty($searchIncludeDef) || $searchIncludeDef < 0 || $searchIncludeDef > 3) ? ' checked="checked"' : '';
	$tout.= '<input type="radio" id="sfradio6" name="encompass" value="1"'.$checked.' />&nbsp;<label class="spLabel spRadio" for="sfradio6">'.$labelPostsOnly.'</label>'.$br;
    $checked = ($searchIncludeDef == 2) ? ' checked="checked"' : '';
	$tout.= '<input type="radio" id="sfradio7" name="encompass" value="2"'.$checked.' />&nbsp;<label class="spLabel spRadio" for="sfradio7">'.$labelTitlesOnly.'</label>'.$br;
    $checked = ($searchIncludeDef == 3) ? ' checked="checked"' : '';
	$tout.= '<input type="radio" id="sfradio8" name="encompass" value="3"'.$checked.' />&nbsp;<label class="spLabel spRadio" for="sfradio8">'.$labelPostTitles.'</label>'.$br;
	$out.= apply_filters('sph_SearchFormOptions', $tout);
	$out.= '</div>';

	if ($spDevice == 'mobile') {
		$out.= '<div class="spRadioSection spLeft">';
		$out.= '<p class="spLeft spSearchDetails">'.$labelWildcards.':<br />*&nbsp; '.$labelMatchAnyChars.'&nbsp;&nbsp;&nbsp;&nbsp;%&nbsp; '.$labelMatchOneChar.'</p>';
		$out.= '<p class="spLeft spSearchDetails">'.sprintf($labelMinLength, '<b>'.$spGlobals['mysql']['search']['min'].'</b>', '<b>'.$spGlobals['mysql']['search']['max'].'</b>')."</p>";
		$out. '</div>';
	}
	$out.= '</div><br />';

	if ($spDevice != 'mobile') {
		$out.= sp_InsertBreak('echo=0');
		$out.= '<p class="spLeft spSearchDetails">'.$labelWildcards.':<br />*&nbsp; '.$labelMatchAnyChars.'&nbsp;&nbsp;&nbsp;&nbsp;%&nbsp; '.$labelMatchOneChar.'</p>';
		$out.= '<p class="spLeft spSearchDetails">'.sprintf($labelMinLength, '<b>'.$spGlobals['mysql']['search']['min'].'</b>', '<b>'.$spGlobals['mysql']['search']['max'].'</b>')."</p>";
	}

 	$out.= '</fieldset>';
	$out.= sp_InsertBreak('echo=0');

	$tout = '';
	if ($spThisUser->member) {
		$tout.= '<fieldset class="spSearchMember">';
		$tout.= '<legend>'.$labelMemberSearch.'</legend>';
		$tout.= '<div class="spSearchSection spSearchSectionUser">';
		$tout.= '<img src="'.sp_find_icon(SPTHEMEICONSURL, 'sp_Search.png').'" alt="" />';
		$tout.= '<input type="hidden" name="userid" value="'.$spThisUser->ID.'" />';
		$tout.= '<input type="submit" class="spSubmit" name="membersearch" value="'.$labelTopicsPosted.'" />';
		$tout.= '<input type="submit" class="spSubmit" name="memberstarted" value="'.$labelTopicsStarted.'" />';
		$tout.= '</div>';
		$tout.= '</fieldset>';
	}

	if (!empty($tout)) $out.= $tout;

	$out = apply_filters('sph_SearchFormBottom', $out);

	return $out;
}
?>