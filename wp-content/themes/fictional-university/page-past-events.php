<?php
$past_events = new WP_Query(array(
	'paged' => get_query_var('paged', 1),
	'post_type' => 'event',
	'meta_key' => 'event_date',
	'meta_query' => array(
		array(
			'key' => 'event_date',
			'compare' => '<',
			'value' => date('Ymd'),
			'type' => 'numeric',
		),
	),
	'orderby' => 'meta_value_num',
	'order' => 'DESC'
));
?>

<?php get_header(); ?>

	<div class="page-banner">
		<div class="page-banner__bg-image"
			 style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg'); ?>)"></div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title"><?php the_title(); ?></h1>
			<div class="page-banner__intro">
				<p><?php the_content(); ?></p>
			</div>
		</div>
	</div>

	<div class="container container--narrow page-section">
		<?php
		while ($past_events->have_posts()): $past_events->the_post();
			get_template_part('template-parts/content-event');
		endwhile;
		wp_reset_postdata();
		?>
		<?php echo paginate_links(array(
			'total' => $past_events->max_num_pages
		)); ?>
	</div>

<?php get_footer();
