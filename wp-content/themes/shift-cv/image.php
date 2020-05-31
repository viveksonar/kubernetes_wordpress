<?php
/**
 * The template to display the attachment
 *
 * @package WordPress
 * @subpackage SHIFT_CV
 * @since SHIFT_CV 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	get_template_part( apply_filters( 'shift_cv_filter_get_template_part', 'content', get_post_format() ), get_post_format() );

	// Parent post navigation.
	?>
	<div class="nav-links-single">
		<?php
		the_post_navigation(
			array(
				'prev_text' => '<span class="nav-arrow"></span>'
					. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'shift-cv' ) . '</span> '
					. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'shift-cv' ) . '</span> '
					. '<h5 class="post-title">%title</h5>'
					. '<span class="post_date">%date</span>',
			)
		);
		?>
	</div>
	<?php

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
