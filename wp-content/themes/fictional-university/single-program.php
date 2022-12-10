<?php
$related_professors = new WP_Query(array(
	'post_type' => 'professor',
	'posts_per_page' => -1,
	'meta_query' => array(
		array(
			'key' => 'related_programs',
			'compare' => 'LIKE',
			'value' => '"' . get_the_ID() . '"',
		)
	),
	'orderby' => 'title',
	'order' => 'ASC',
));

$related_upcoming_events = new WP_Query(array(
	'post_type' => 'event',
	'posts_per_page' => -1,
	'meta_key' => 'event_date',
	'meta_query' => array(
		array(
			'key' => 'event_date',
			'compare' => '>=',
			'value' => date('Ymd'),
			'type' => 'numeric',
		),
		array(
			'key' => 'related_programs',
			'compare' => 'LIKE',
			'value' => '"' . get_the_ID() . '"',
		)
	),
	'order' => 'DESC',
	'orderby' => 'meta_value_num',
));
?>

<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image"
             style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg'); ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <!-- TODO: Add subtitle below using Custom Fields -->
                <p>Remind me to edit this field later using Custom Fields.</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    All Programs
                </a>
                <span class="metabox__main">Posted by <?php the_author_posts_link(); ?>. Expires on <?php the_time(); ?></span>
            </p>
        </div>
        <div class="generic-content"><?php the_content(); ?></div>
		<?php if ($related_professors): ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Related Professor(s)</h2>
            <ul class="professor-cards">
				<?php while ($related_professors->have_posts()): $related_professors->the_post(); ?>
                    <li class="professor-card__list-item">
                        <a href="<?php the_permalink(); ?>" class="professor-card">
                            <img class="professor-card__image" src="<?php the_post_thumbnail_url(); ?>" alt="">
                            <span class="professor-card__name"><?php the_title(); ?></span>
                        </a>
                    </li>
				<?php endwhile;
				wp_reset_postdata(); ?>
            </ul>
		<?php endif; ?>
		<?php if ($related_upcoming_events): ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Upcoming Event(s)</h2>
			<?php while ($related_upcoming_events->have_posts()): $related_upcoming_events->the_post(); ?>
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
                        <p>
							<?php if (has_excerpt()) {
								echo get_the_excerpt();
							} else {
								echo wp_trim_words(get_the_content(), 15);
							} ?>
                            <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a>
                        </p>
                    </div>
                </div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		<?php endif; ?>
    </div>
<?php endwhile; ?>

<?php get_footer();