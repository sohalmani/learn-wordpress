<?php

require get_theme_file_path('/inc/search-route.php');

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

    wp_localize_script('fictional-university-index', 'FictionalUniversityData', array(
        'rootUrl' => get_site_url()
    ));
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

function get_date($date = '', $format = 'd M Y')
{
    $new_date = new DateTime($date);
    return $new_date->format($format);
}

function display_date($date = '', $format = 'd M Y')
{
	echo get_date($date, $format);
}

function page_banner($args = null)
{
	if (!$args['title']) {
		$args['title'] = get_the_title();
	}

	if (!$args['subtitle']) {
		$args['subtitle'] = get_field('page_banner_subtitle');
	}

	if (!$args['background_image']) {
		if (get_field('page_banner_background_image')) {
			$args['background_image'] = get_field('page_banner_background_image')['sizes']['page-banner'];
		} else {
			$args['background_image'] = get_theme_file_uri('/images/ocean.jpg');
		}
	}

	?>
	<div class="page-banner">
		<div class="page-banner__bg-image"
			 style="background-image: url(<?php echo $args['background_image']; ?>)"></div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
			<div class="page-banner__intro">
				<p><?php echo $args['subtitle']; ?></p>
			</div>
		</div>
	</div>
	<?php
}

function add_author_field_in_rest_api() {
    register_rest_field('post', 'author_name', array(
        'get_callback' => function () {
            return get_the_author();
        }
    ));
}

add_action('rest_api_init', 'add_author_field_in_rest_api');

function redirectSubscribersToHome() {
    $theCurrentUser = wp_get_current_user();

    if (count($theCurrentUser->roles) == 1 && $theCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('admin_init', redirectSubscribersToHome);

function removeAdminBarForSubscribers() {
    $theCurrentUser = wp_get_current_user();

    if (count($theCurrentUser->roles) == 1 && $theCurrentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

add_action('wp_loaded', removeAdminBarForSubscribers);

function load_fictional_university_assets()
{
    wp_enqueue_style('google-fonts',
        '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('fictional-university-style-index', get_theme_file_uri('build/style-index.css'));
    wp_enqueue_style('fictional-university-index', get_theme_file_uri('build/index.css'));
}

add_action('login_enqueue_scripts', load_fictional_university_assets);

function setLoginTitle() {
    return get_bloginfo('name');
}

add_filter('login_headertitle', setLoginTitle);

function setLoginTitleUrl() {
    return esc_url(site_url('/'));
}

add_filter('login_headerurl', setLoginTitleUrl);