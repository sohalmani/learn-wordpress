<?php
$related_programs = get_field('related_programs');
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
		<div class="generic-content"><?php the_content(); ?></div>
		<?php if ($related_programs): ?>
			<hr class="section-break">
			<h2 class="headline headline--medium">Subject(s) Taught</h2>
			<ul class="link-list min-list">
				<?php foreach ($related_programs as $program): ?>
					<li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
<?php endwhile; ?>

<?php get_footer();