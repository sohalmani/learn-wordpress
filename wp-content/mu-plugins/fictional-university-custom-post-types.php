<?php

/**
 * Plugin Name: Fictional University CPT
 * Author: Mani Sohal
 * Version: 1.0.0
 */

function fictional_university_custom_post_types()
{
    register_post_type('event', array('has_archive' => true, 'labels' => array('name' => 'Events', 'all_items' => 'All Events', 'add_new_item' => 'Add New Event', 'edit_item' => 'Edit Event', 'singular' => 'Event',), 'menu_icon' => 'dashicons-calendar', 'public' => true, 'rewrite' => array('slug' => 'events')));
}

add_action('init', 'fictional_university_custom_post_types');