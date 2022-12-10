<?php get_header(); ?>

    <?php page_banner(array(
        'title' => 'All Events',
        'subtitle' => 'See what\'s going on in our world',
    )); ?>

    <div class="container container--narrow page-section">
		<?php
		while (have_posts()): the_post();
			get_template_part('template-parts/content-event');
		endwhile;
		wp_reset_postdata();
		?>
		<?php echo paginate_links(); ?>
        <hr class="section-break">
        <p>Want to recap the older events? <a href="<?php echo site_url('past-events'); ?>">Check out the past events
                archive!</a></p>
    </div>

<?php get_footer();
