<?php
/**
 * Render del blocco "Slider a schede".
 *
 * Genera lo stesso markup del vecchio template-parts/slider/slider.php:
 * riquadro blu con le slide, barra di navigazione e, sotto, il contenuto di ogni scheda.
 *
 * @package WordPress
 * @subpackage San_Filippo_Neri
 *
 * @var array    $attributes Attributi del blocco.
 * @var string   $content    Contenuto già renderizzato (non usato).
 * @var WP_Block $block      Istanza del blocco.
 */

$sanfilipponeri_slides = array();
foreach ( $block->inner_blocks as $sanfilipponeri_inner ) {
	if ( 'sanfilipponeri/slide' === $sanfilipponeri_inner->name ) {
		$sanfilipponeri_slides[] = $sanfilipponeri_inner;
	}
}

if ( ! $sanfilipponeri_slides ) {
	return;
}

$sanfilipponeri_count = count( $sanfilipponeri_slides );
?>
<div
<?php
echo get_block_wrapper_attributes( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	array(
		'class'              => 'sfn-slider',
		'style'              => '--odn-count: ' . (int) min( $sanfilipponeri_count, 4 ) . ';',
		'data-height-cutoff' => (string) max( 0, (int) ( $attributes['heightCutoff'] ?? 100 ) ),
	)
);
?>
>
	<div id="odn-slider">
		<span id="odn-dot-container">
			<?php for ( $sanfilipponeri_i = 0; $sanfilipponeri_i < $sanfilipponeri_count; $sanfilipponeri_i++ ) : ?>
				<span role="button" tabindex="0" class="odn-dot" data-index="<?php echo (int) $sanfilipponeri_i; ?>" aria-label="<?php echo esc_attr( sprintf( 'Scheda %d', $sanfilipponeri_i + 1 ) ); ?>"></span>
			<?php endfor; ?>
		</span>
		<span id="odn-arrow-container">
			<img width="80" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/freccia.svg' ) ); ?>" alt="">
		</span>
		<span id="odn-slide-container">
			<?php foreach ( $sanfilipponeri_slides as $sanfilipponeri_slide ) : ?>
				<?php $sanfilipponeri_attrs = $sanfilipponeri_slide->attributes; ?>
				<div class="odn-slide">
					<?php if ( ! empty( $sanfilipponeri_attrs['kicker'] ) ) : ?>
						<p class="odn-p-small"><?php echo wp_kses_post( $sanfilipponeri_attrs['kicker'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $sanfilipponeri_attrs['title'] ) ) : ?>
						<p class="odn-p-big"><?php echo wp_kses_post( $sanfilipponeri_attrs['title'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $sanfilipponeri_attrs['buttonText'] ) ) : ?>
						<p>
							<?php if ( ! empty( $sanfilipponeri_attrs['buttonUrl'] ) ) : ?>
								<a class="odn-button" href="<?php echo esc_url( $sanfilipponeri_attrs['buttonUrl'] ); ?>"<?php echo empty( $sanfilipponeri_attrs['buttonNewTab'] ) ? '' : ' target="_blank" rel="noopener"'; ?>><?php echo wp_kses_post( $sanfilipponeri_attrs['buttonText'] ); ?></a>
							<?php else : ?>
								<button type="button" class="odn-button"><?php echo wp_kses_post( $sanfilipponeri_attrs['buttonText'] ); ?></button>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</span>
	</div>
	<div id="odn-navlinks">
		<?php foreach ( $sanfilipponeri_slides as $sanfilipponeri_i => $sanfilipponeri_slide ) : ?>
			<span role="button" tabindex="0" class="odn-navlink" data-index="<?php echo (int) $sanfilipponeri_i; ?>"><?php echo esc_html( $sanfilipponeri_slide->attributes['label'] ?? '' ); ?></span>
		<?php endforeach; ?>
	</div>
	<br id="sep">
	<div id="odn-bodies">
		<?php foreach ( $sanfilipponeri_slides as $sanfilipponeri_slide ) : ?>
			<div class="odn-slider-body">
				<?php echo $sanfilipponeri_slide->render(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
