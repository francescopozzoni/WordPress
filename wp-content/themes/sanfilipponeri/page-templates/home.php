<?php
/**
 * Template Name: Home
 *
 * Pagina senza titolo, pensata per la homepage composta con il blocco "Slider a schede".
 *
 * @package WordPress
 * @subpackage San_Filippo_Neri
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'sfn-home' ); ?>>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php
endwhile;

get_footer();
