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
		<?php if ( sanfilipponeri_show_front_title() ) : ?>
			<header class="entry-header alignwide">
				<?php get_template_part( 'template-parts/header/entry-header' ); ?>
			</header><!-- .entry-header -->
		<?php endif; ?>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
	<?php
endwhile;

get_footer();
