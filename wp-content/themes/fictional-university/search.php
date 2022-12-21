<?php get_header(); ?>

<?php page_banner(array(
    'title' => 'Search Results!',
    'subtitle' => 'Showing results for &ldquo;' . esc_html(get_search_query()) . '&rdquo;',
)); ?>

    <div class="container container--narrow page-section">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <div class="post-item">
                    <h2 class="headline headline--medium headline--post-title"><?php the_title(); ?></h2>
                    <div class="metabox">
                        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('M d, Y'); ?>
                            in <?php echo get_the_category_list(', '); ?></p>
                    </div>
                    <div class="generic-content">
                        <?php the_excerpt(); ?>
                        <p>
                            <a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue Reading &raquo;</a>
                        </p>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php echo paginate_links(); ?>
        <?php else: ?>
            <h2 class="headline headline--small-plus">Sorry, no results match your search!</h2>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>

<?php get_footer();