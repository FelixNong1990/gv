<?php

function un_the_feedback_status(){
	echo un_get_the_feedback_status();
}

function un_get_the_feedback_status(){
	global $unpro_model, $id;
	return $unpro_model->get_feedback_status_name($id);
}

function un_the_feedback_status_slug(){
	echo un_get_the_feedback_status_slug();
}

function un_get_the_feedback_status_slug(){
	global $unpro_model, $id;
	return $unpro_model->get_feedback_status($id);
}

function un_the_feedback_likes(){
	echo un_get_the_feedback_likes();
}

function un_the_feedback_dislikes(){
	echo un_get_the_feedback_dislikes();
}

function un_get_the_feedback_likes(){
	global $id;
	if ($likes = get_post_meta($id, '_likes', true))
		return $likes;
	return 0;
}
function un_get_the_feedback_dislikes(){
	global $id;
	if ($dislikes = get_post_meta($id, '_dislikes', true))
		return $dislikes;
	return 0;
}

function usernoisepro_url($path){
	return plugins_url() . '/' . USERNOISEPRO_DIR . $path;
}

function usernoisepro_path($path){
	return dirname(USERNOISEPRO_MAIN) . $path;
}


function un_human_time_diff($from, $to = ''){
	if ( empty( $to ) )
		$to = time();
	if (class_exists('DateTime') && method_exists('DateTime', 'diff')){
		$from_date = new DateTime("@{$from}");
		$to_date = new DateTime("@{$to}");
		$diff = $to_date->diff($from_date);
		if ($diff->d < 7){
			return human_time_diff($from, $to);
		} elseif ($diff->m < 1){
			return sprintf(_n('%s week', '%s weeks', (int)round($diff->d / 7), 'usernoise-pro'), (int)round($diff->d / 7));
		} elseif ($diff->m < 12) {
			return sprintf(_n('%s month', '%s months', $diff->m, 'usernoise-pro'), $diff->m);
		} else {
			return sprintf(_n('%s year', '%s years', $diff->y, 'usernoise-pro'), $diff->y);
		}
	} 
	return human_time_diff($from, $to);
}

function un_get_type_icon($type_slug){
	$term = get_term_by('slug', $type_slug, FEEDBACK_TYPE);
	return un_get_term_meta($term->term_id, 'icon');
}