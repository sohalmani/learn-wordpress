<?php
get_header();
?>
    <h1><?php bloginfo('name'); ?></h1>
    <p><?php bloginfo('description'); ?></p>
<?php
while (have_posts()): the_post();
    ?>
    <div>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><?php the_content(); ?></p>
        <hr/>
    </div>
<?php
endwhile;

get_footer();