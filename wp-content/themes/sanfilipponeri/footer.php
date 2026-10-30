<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage San_Filippo_Neri
 */

?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<footer id="colophon" class="site-footer">

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav aria-label="<?php esc_attr_e( 'Secondary menu', 'twentytwentyone' ); ?>" class="footer-navigation">
				<ul class="footer-navigation-wrapper">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'items_wrap'     => '%3$s',
							'container'      => false,
							'depth'          => 1,
							'link_before'    => '<span>',
							'link_after'     => '</span>',
							'fallback_cb'    => false,
						)
					);
					?>
				</ul><!-- .footer-navigation-wrapper -->
			</nav><!-- .footer-navigation -->
		<?php endif; ?>
		<div id="my-footer">
			<?php
			foreach ( sanfilipponeri_social_links() as $sanfilipponeri_social => $sanfilipponeri_url ) :
				if ( ! $sanfilipponeri_url ) {
					continue;
				}
				?>
				<a href="<?php echo esc_url( $sanfilipponeri_url ); ?>" aria-label="<?php echo esc_attr( ucfirst( $sanfilipponeri_social ) ); ?>">
					<img class="my-footer-links" src="<?php echo esc_url( get_theme_file_uri( "assets/images/{$sanfilipponeri_social}.svg" ) ); ?>" alt="">
				</a>
			<?php endforeach; ?>
			<img id="my-footer-img" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/coda.svg' ) ); ?>" alt="">
			<img id="my-footer-img-mobile" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sfondo-1.svg' ) ); ?>" alt="">
		</div>
		<div id="footer-info">
			&copy; <?php sanfilipponeri_footer_name(); ?> - <?php echo esc_html( gmdate( 'Y' ) ); ?> - <a href="<?php echo esc_url( get_privacy_policy_url() ? get_privacy_policy_url() : home_url( '/privacy' ) ); ?>">privacy</a>
		</div><!-- #footer-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
