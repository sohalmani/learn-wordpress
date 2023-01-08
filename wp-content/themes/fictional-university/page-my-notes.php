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
        <div class="create-note">
            <h2 class="headline headline--medium">Create New Note</h2>
            <input type="text" class="new-note-title" placeholder="Title">
            <textarea class="new-note-body" placeholder="Your note here..."></textarea>
            <span class="submit-note">Create Note</span>
        </div>
        <hr class="section-break" />
        <ul class="min-list link-lis" id="my-notes">
            <?php while($thisAuthorNotes->have_posts()): $thisAuthorNotes->the_post(); ?>
                <li data-id="<?php the_ID(); ?>">
                    <input type="text" class="note-title-field" value="<?php echo esc_attr(str_replace('Private: ', '', get_the_title())); ?>" readonly>
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea class="note-body-field" cols="30" rows="10" readonly><?php echo esc_textarea(wp_strip_all_tags(get_the_content())); ?></textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
<?php endwhile; ?>

<?php get_footer();