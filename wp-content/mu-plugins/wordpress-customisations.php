<?php
/**
 * Plugin Name: WordPress Customisations
 * Author: Mani Sohal
 * Version: 1.0.0
 */

/**
 * Custom menu order for admin menu
 *
 * @param int $menu_ord
 * @return array
 */
function wpse_custom_menu_order($menu_ord)
{
	if (!$menu_ord) return true;

	return array(
		'index.php',
		// Dashboard
		'separator1',
		// First separator
		'edit.php',
		// Posts
		'edit.php?post_type=event',
		// Events
		'edit.php?post_type=program',
		// Programs
		'edit.php?post_type=professor',
		// Professors
		'upload.php',
		// Media
		'edit.php?post_type=page',
		// Pages
		'edit-comments.php',
		// Comments
		'separator2',
		// Second separator
		'themes.php',
		// Appearance
		'plugins.php',
		// Plugins
		'users.php',
		// Users
		'tools.php',
		// Tools
		'options-general.php',
		// Settings
		'separator-last',
		// Last separator
		'edit.php?post_type=acf-field-group',
		// ACF
	);
}

add_filter('custom_menu_order', 'wpse_custom_menu_order', 18, 1);
add_filter('menu_order', 'wpse_custom_menu_order', 18, 1);