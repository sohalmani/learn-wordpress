<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image"
             style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg'); ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <!-- TODO: Add subtitle below using Custom Fields -->
                <p>Learn how the school of your dreams got started. Remind me to edit this field later using Custom
                    Fields.</p>
            </div>
        </div>
    </div>

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

        <!--        <div class="page-links">-->
        <!--            <h2 class="page-links__title"><a href="#">About Us</a></h2>-->
        <!--            <ul class="min-list">-->
        <!--                <li class="current_page_item"><a href="#">Our History</a></li>-->
        <!--                <li><a href="#">Our Goals</a></li>-->
        <!--            </ul>-->
        <!--        </div>-->

        <div class="generic-content"><?php the_content(); ?></div>
    </div>
<?php endwhile; ?>

<?php get_footer();