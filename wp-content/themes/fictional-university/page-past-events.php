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
		<?php while ($past_events->have_posts()): $past_events->the_post(); ?>
			<?php $event_date = get_field('event_date'); ?>
			<div class="event-summary">
				<a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
					<span class="event-summary__month"><?php display_date($event_date, 'M'); ?></span>
					<span class="event-summary__day"><?php display_date($event_date, 'd'); ?></span>
				</a>
				<div class="event-summary__content">
					<h5 class="event-summary__title headline headline--tiny">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h5>
					<p><?php echo wp_trim_words(get_the_content(), 15); ?>
						<a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a>
					</p>
				</div>
			</div>
		<?php endwhile; ?>
		<?php echo paginate_links(array(
			'total' => $past_events->max_num_pages
		)); ?>
	</div>

<?php get_footer();