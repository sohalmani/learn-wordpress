<?php get_header(); ?>

    <?php page_banner(array(
        'title' => 'All Events',
        'subtitle' => 'See what\'s going on in our world',
    )); ?>

    <div class="container container--narrow page-section">
		<?php while (have_posts()): the_post(); ?>
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
		<?php echo paginate_links(); ?>
        <hr class="section-break">
        <p>Want to recap the older events? <a href="<?php echo site_url('past-events'); ?>">Check out the past events
                archive!</a></p>
    </div>

<?php get_footer();
