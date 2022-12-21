<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>
    <?php
    page_banner(array(
        'title' => get_the_title(),
        'subtitle' => 'Not able to find what you need? Let us help you!',
    ));
    ?>

    <div class="container container--narrow page-section">
        <?php $parent_id = wp_get_post_parent_id(get_the_ID()); ?>
        <?php if ($parent_id): ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_the_permalink($parent_id); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <?php echo get_the_title($parent_id); ?>
                    </a>
                    <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
        <?php endif; ?>

        <div class="generic-content">
            <form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>">
                <label class="headline headline--medium" for="s">Perform a new search:</label>
                <div class="search-form-row">
                    <input type="text" class="s" name="s" id="s" placeholder="What are you looking for?">
                    <input type="submit" class="search-submit" value="Search">
                </div>
            </form>
        </div>
    </div>
<?php endwhile; ?>

<?php get_footer();