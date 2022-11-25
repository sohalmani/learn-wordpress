<?php

/**
 * Add theme support
 * The 'add_theme_support()' function lets you enable certain features within WordPress
 * The hook used to enable feature is 'after_setup_theme'
 * @return void
 */
function fictional_university_support()
{
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'fictional_university_support');

function fictional_university_assets()
{
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('fictional-university-index', get_theme_file_uri('build/index.css'));
    wp_enqueue_style('fictional-university-style-index', get_theme_file_uri('build/style-index.css'));
    wp_enqueue_script('fictional-university-index', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'fictional_university_assets');