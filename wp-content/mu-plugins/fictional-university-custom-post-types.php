<?php

/**
 * Plugin Name: Fictional University CPT
 * Author: Mani Sohal
 * Version: 1.0.0
 */

function fictional_university_custom_post_types()
{
	register_post_type('event', array(
		'has_archive' => true,
		'labels' => array(
			'name' => 'Events',
			'all_items' => 'All Events',
			'add_new_item' => 'Add New Event',
			'edit_item' => 'Edit Event',
			'singular' => 'Event',
		),
		'menu_icon' => 'dashicons-calendar',
		'public' => true,
		'rewrite' => array('slug' => 'events'),
		'show_in_rest' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'custom-fields',
		),
	));

	register_post_type('program', array(
		'has_archive' => true,
		'labels' => array(
			'name' => 'Programs',
			'all_items' => 'All Programs',
			'add_new_item' => 'Add New Program',
			'edit_item' => 'Edit Program',
			'singular' => 'Program',
		),
		'menu_icon' => 'dashicons-awards',
		'public' => true,
		'rewrite' => array('slug' => 'programs'),
		'show_in_rest' => true,
		'supports' => array(
			'title',
			'editor',
		),
	));

	register_post_type('professor', array(
		'labels' => array(
			'name' => 'Professors',
			'all_items' => 'All Professors',
			'add_new_item' => 'Add New Professors',
			'edit_item' => 'Edit Professor',
			'singular' => 'Professors',
		),
		'menu_icon' => 'dashicons-welcome-learn-more',
		'public' => true,
		'show_in_rest' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
	));
}

add_action('init', 'fictional_university_custom_post_types');