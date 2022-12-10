<?php

function fictional_university_support()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	add_image_size('professor-portrait', 480, 640, true);
	add_image_size('professor-landscape', 400, 260, true);
	add_image_size('page-banner', 1600, 480, true);

	register_nav_menu('header_main', 'Main Navigation in Header');
	register_nav_menu('footer_explore', 'Explore Column in Footer');
	register_nav_menu('footer_learn', 'Learn Column in Footer');
}

add_action('after_setup_theme', 'fictional_university_support');

function fictional_university_assets()
{
	wp_enqueue_style('google-fonts',
		'//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('fictional-university-index', get_theme_file_uri('build/index.css'));
	wp_enqueue_style('fictional-university-style-index', get_theme_file_uri('build/style-index.css'));
	wp_enqueue_script('fictional-university-index', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0',
		true);
}

add_action('wp_enqueue_scripts', 'fictional_university_assets');

function fictional_university_fetch_upcoming_events($query)
{
	if (is_admin() || !$query->is_main_query()) {
		return false;
	}

	if (is_post_type_archive('event')) {
		$query->set('meta_key', 'event_date');
		$query->set('meta_query', array(
				array(
					'key' => 'event_date',
					'compare' => '>=',
					'value' => date('Ymd'),
					'type' => 'numeric',
				)
			));
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
	}

	if (is_post_type_archive('program')) {
		$query->set('posts_per_page', -1);
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
	}
}

add_action('pre_get_posts', 'fictional_university_fetch_upcoming_events');

function display_date($date = '', $format = 'd M Y')
{
	$new_date = new DateTime($date);
	echo $new_date->format($format);
}