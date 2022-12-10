<?php get_header(); ?>

    <?php page_banner(array(
        'title' => 'All Programs',
        'subtitle' => 'There is something for everyone, have a look around',
    )); ?>

    <div class="container container--narrow page-section">
		<?php if (have_posts()): ?>
            <ul class="link-list min-list">
				<?php while (have_posts()): the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
            </ul>
			<?php echo paginate_links(); ?>
		<?php endif; ?>
    </div>

<?php get_footer();
