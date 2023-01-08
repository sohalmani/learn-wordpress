<?php

if (!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/')));
    exit;
}

$thisAuthorNotes = new WP_Query(array(
    'post_type' => 'note',
    'posts_per_page' => -1,
    'author' => get_current_user_id(),
));

?>

<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>
    <?php page_banner(); ?>

    <div class="container container--narrow page-section">
        <?php if($thisAuthorNotes->have_posts()): ?>
            <ul class="min-list link-lis" id="my-notes">
                <?php while($thisAuthorNotes->have_posts()): $thisAuthorNotes->the_post(); ?>
                    <li>
                        <input type="text" class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>">
                        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                        <textarea class="note-body-field" cols="30" rows="10"><?php echo esc_textarea(wp_strip_all_tags(get_the_content())); ?></textarea>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endwhile; ?>

<?php get_footer();